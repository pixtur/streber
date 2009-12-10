<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * basic setup functions used in index.php
 *
 * @author Thomas Mann
 */


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
* Fix basic php issues and check version
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
        exit();
    }
}


/**
* Filter get and post-vars
*
* - We don't not distinguish security between post-,get- and cookie-vars
*   because any of them can be easily forged. We create a joined assoc array
*   and filter for too long variables and html-tags. Additional security-checks
*   should be done later in db- and field-classes.
*
* - passed parames should always be accessed like;
*
*    $f_person_name= get('person_name');
*
* - You CAN NOT access $_GET, $_POST and $_COOKIE-vars directly (because they are cleared)!
* - for additional information see std/common.inc
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
