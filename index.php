<?php
# streber - a php5 based project management system  (c) 2005 Thomas Mann / thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
* Welcome to the source-code. This is a good point to start reading.
*
* This is index.php - the master-control-page. There are NO other php-pages, except from
* install.php (which should have been delete in normal process).
*
* index.php does...
*
* - initialize the profiler
* - include config and customize
* - include core-components
* - authenticate the user
* - render a page (which means calling a function defined in a file at pages/*.inc)
*
* If you want to read more source-code try...
*
* - pages/_pagehandles.inc  - a list of definiation of all posibible pages, it's required rights, etc.
* - pages/home.inc          - example, how a normal page looks like
* - pages/effort.inc        - example, how a form-workflow looks like
* - lists/list_efforts.inc  - example for listing objects
* - db/class_effort.inc     - exampel for back-end definition of object-types
* - render/page.inc         - rending of html-code
*
*/
error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_STRICT |E_PARSE|E_CORE_ERROR|E_CORE_WARNING|E_COMPILE_ERROR);


/********************************************************************************
* setup framework
********************************************************************************/

### create a function to make sure we started at index.php ###
function startedIndexPhp() {return true; }

initialBasicFixes();
initProfiler();

### include std functions ###
require_once('std/common.inc.php');
require_once('std/errorhandler.inc.php');
require_once('conf/defines.inc.php');
require_once('conf/conf.inc.php');


### if no db_settings start installation ###
if(file_exists(confGet('DIR_SETTINGS').confGet('FILE_DB_SETTINGS'))) {
	require_once(confGet('DIR_SETTINGS').confGet('FILE_DB_SETTINGS'));
}
else {
    header("location:install/install.php");
    exit;
}

### user-settings ##
if(file_exists('customize.inc.php')) {
    require_once(confGet('DIR_STREBER') . 'customize.inc.php');
}

filterGlobalArrays();


/**
* run profiler and output measures in footer?
*/
if(confGet('USE_PROFILER')) {
    require_once(confGet('DIR_STREBER') . "std/profiler.inc.php");
}
else {
    ###  define empty functions ###
    function measure_start($id){};
    function measure_stop($id){};
    function render_measures(){return '';};
}

measure_start('time_complete'); # measure complete time (stops before profiling)
measure_start('core_includes'); # measure time for including core-components


### included database handler ###
$db_type = confGet('DB_TYPE');
if(file_exists("db/db_".$db_type."_class.php")){
    require_once(confGet('DIR_STREBER') . "db/db_".$db_type."_class.php");
}
else{
    trigger_error("Datebase handler not found for db-type '$db_type'", E_USER_ERROR);
}


### include the core-classes (php5) ###
require_once( confGet('DIR_STREBER') . 'db/db.inc.php');
require_once( confGet('DIR_STREBER') . 'std/class_auth.inc.php');
require_once( confGet('DIR_STREBER') . 'db/db_item.inc.php');
require_once( confGet('DIR_STREBER') . 'std/class_pagehandler.inc.php');

### trigger db request ###
$dbh = new DB_Mysql;
if(!is_null(confGet('SQL_MODE'))) {
    $dbh->prepare('SET sql_mode = "'. confGet('SQL_MODE') .'"')->execute();
}
if ($result = $dbh->prepare('SELECT NOW()')) {
  $result->execute();
}

measure_stop( confGet('DIR_STREBER') . 'core_includes');

/********************************************************************************
* authenticate user by cookie / start translation
********************************************************************************/
measure_start('authorize');
if(!$user = $auth->setCurUserByCookie()) {
    $user = $auth->setCurUserAsAnonymous();
}
measure_stop('authorize');


### set language as early as here to start translation... ###
{
    measure_start('language');
    if($user && !Auth::isAnonymousUser()) {
        $auth->storeUserCookie();                               # refresh user-cookie

        if(isset($auth->cur_user->language)
            && $auth->cur_user->language != ""
            && $auth->cur_user->language != "en"
        ) {
            setLang($auth->cur_user->language);
            build_person_fields();
        }
    }
    else {
        setLang(confGet('DEFAULT_LANGUAGE'));
        build_person_fields();
    }
    measure_stop('language');
}

/********************************************************************************
* include framework
********************************************************************************/
measure_start('plugins');
require_once( confGet('DIR_STREBER') . "std/constant_names.inc.php");
require_once( confGet('DIR_STREBER') . "render/render_page.inc.php");
require_once( confGet('DIR_STREBER') . "pages/_handles.inc.php");                 # already requires language-support
measure_stop('plugins');

if(function_exists('postInitCustomize')) {
    postInitCustomize();
}

measure_start('init2');
global $PH;
if($g_tags_removed) {
    new FeedbackWarning( __('For security reasons html tags were removed from passed variables')
    . " " . sprintf(__("Read more about %s."), $PH->getWikiLink('security settings')));
}

/********************************************************************************
* route to pages
********************************************************************************/
### if index.php was called without target, check environment ###
if(!$requested_page_id = get('go')) {
    require_once( confGet('DIR_STREBER') . "./std/check_version.inc.php");
    validateEnvironment();
}



$requested_page= $PH->getRequestedPage();

### pages with http auth ###


if($requested_page->http_auth) {

    if(!$user) {

        if($user= Auth::getUserByHttpAuth()) {

            $PH->show($requested_page->id);

            exit;
        }
        else {
           echo __('Sorry. 	Authentication failed');
           exit;
        }
    }
}

### valid user or anonymous user ###
if($user) {

    ### if no target-page show home ###
    if(!$requested_page_id) {

        ### if user has only one project go there ###
        $projects = $auth->cur_user->getProjects();
        if(count($projects) == 1) {
            new FeedbackMessage(sprintf(confGet('MESSAGE_WELCOME_ONEPROJECT'), $auth->cur_user->name,$projects[0]->name));
            $PH->show('projView',array('prj'=>$projects[0]->id));
        }
        else {
            new FeedbackMessage(confGet('MESSAGE_WELCOME_HOME'));
            $PH->show('home',array());
        }
        exit;
    }

    $PH->show($requested_page_id);
    exit;
}

### anonymous pages like Login or License ###
if($requested_page_id && $requested_page && $requested_page->valid_for_anonymous) {
    $PH->show($requested_page_id);
    exit;
}

### identified by tuid (email notification, etc.)
if(get('tuid') && $requested_page && $requested_page->valid_for_tuid) {
    if($auth->setCurUserByIdentifier(get('tuid'))) {
        log_message('...valid identifier-string(' . get('tuid') . ')', LOG_MESSAGE_DEBUG);

        ### set language ###
        if(isset($auth->cur_user->language)
            && $auth->cur_user->language != ""
            && $auth->cur_user->language != "en"
        ) {
            setLang($auth->cur_user->language);
        }

        ### store coookie ###
        $auth->storeUserCookie();

        ### render target page ###
        $PH->show($requested_page_id);
        exit;
    }
    else {
        new FeedbackWarning(__("Sorry, but this activation code is no longer valid. If you already have an account, you could enter you name and use the <b>forgot password link</b> below."));
        log_message('...invalid identifier-string(' . get('tuid') . ')', LOG_MESSAGE_DEBUG);
    }
}


### all other request lead to login-form ###
$PH->show('loginForm');
exit;



/********************************************************************
* basic setup functions follow
********************************************************************/

/**
* start timing for profiler
*/
function initProfiler()
{
    global $TIME_START;
    $TIME_START=microtime(1);
    global $DB_ITEMS_LOADED;
    $DB_ITEMS_LOADED=0;

    global $g_count_db_statements;
    $g_count_db_statements = 0;
}


/**
* fix basic php issues and check version
*/
function initialBasicFixes()
{
    /**
    * bypass date & timezone-related warnings with php 5.1
    */
    if (function_exists('date_default_timezone_set')) {
        $tz= @date_default_timezone_get();
        date_default_timezone_set($tz);
    }

    ini_set('zend.ze1_compatibility_mode', 0);
    ini_set("pcre.backtrack_limit", -1);                        # fix 5.2.0 prce bug with render_wiki
    if(function_exists('mb_internal_encoding')) {
        mb_internal_encoding("UTF-8");
    }
    #ini_set("mbstring.func_overload", 2);

    /**
    * add rough php-version check to at least avoid parsing errors.
    * fine version-check follows further down
    */
    if(phpversion() < "5.0.0") {
        echo "Sorry, but Streber requires php5 or higher.";
        exit;
    }
}


/**
* filter get and post-vars
*
* We don't not distinguish security between post-,get- and cookie-vars
* because any of them can be easily forged. We create a joined assoc array
* and filter for too long variables and html-tags. Additional security-checks
* should be done later in db- and field-classes.
*
* passed parames should always be accessed like;
*
*  $f_person_name= get('person_name');
*
* You CAN NOT access $_GET, $_POST and $_COOKIE-vars directly (because they are cleared)!
*
* for additional information see std/common.inc
*/
function filterGlobalArrays()
{
    ### clean global namespace from register globals ###
    if (@ini_get('register_globals')) {
       foreach ($_REQUEST as $key => $value) {
           unset($GLOBALS[$key]);
        }
    }

    clearRequestVars();
    addRequestVars($_GET);
    addRequestVars($_POST);
    addRequestVars($_COOKIE);

    $_COOKIE= $_GET= $_POST=array();
}



?>




