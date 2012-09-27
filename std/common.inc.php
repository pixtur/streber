<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

/**
 * function different purposes relating to:
 * - filtering and accessing request vars
 * - getting passed ids with wildcards
 * - language-support
 *
 * included from:index.php, install.php
 *
 * @author Thomas Mann
 * @uses:
 * @usedby: everything
 *
 */


/**
* About using referred variables:
*
* - all referred variables are combined into one assoc. array (see index.php)
* -
*/
global $g_request_vars;
$g_request_vars=array();

global $g_tags_removed;
$g_tags_removed= 0;


/**
* clear possibily defined request-vars
*/
function clearRequestVars() {
    global $g_request_vars;
    $g_request_vars=array();
}



/**
* filter request vars given as assoc. array
* - we don't want to trust any extern data therefore
*   strip weird size & remove weird characters
*/
function addRequestVars(&$referred_vars)
{
    global $g_request_vars;
    global $g_tags_removed;

    if(!isset($g_request_vars)) {
        $g_request_vars= array();
    }

    if(!isset($referred_vars) ) {
        trigger_error('filter_vars() called without proper parameters', E_USER_NOTICE);
        return;
    }

    foreach(array_keys($referred_vars) as $key) {

        ### skip too long variable key (probably an hacking-attempt) ###
        if(strlen($key) > 256) {
            trigger_error('Skipping too long key: "'.$key.'"', E_USER_NOTICE);
            continue;
        }

        ### skip variables with invalid name ###
        if(preg_match("/[\\'<>\/\"]/",$key)) {
            trigger_error('Skipping maleformed key: "'.$key.'"', E_USER_NOTICE);
            continue;
        }

        $value= $referred_vars[$key];

        if(is_string($value)) {

            switch(confGet('CLEAN_REFERRED_VARS')) {

                case 'STRIP_TAGS':
                    while ($value != strip_tags($value)) {
                       $g_tags_removed++;
                       $value = strip_tags($value);
                    }

                case 'HTML_ENTITIES':
                    break;

                default:
                    trigger_error("unknown setting for CLEAN_REFERRED_VARS: '".confGet('CLEAN_REFERRED_VARS')."'",E_USER_WARNING);
            }
            
            ### remove slashes if magic quotes
            if(get_magic_quotes_gpc()) {
                $value= stripslashes($value);
            }

            ### strip length ###
            $value= substr( $value,0,confGet('STRING_SIZE_MAX'));
        }
        else if(! is_numeric($value) ) {
            $content = print_r($value, true);
            trigger_error("Skipping referred value for '$key' of unknown type: '". gettype($value)."' $content", E_USER_NOTICE);
            continue;
        }
        $g_request_vars[$key] = $value;
    }
}



/**
* access request vars
*
* returns optional 2nd parameter, if variable isn't set
*/
function get($key, $default_value= NULL) {
    global $g_request_vars;

    if(isset($g_request_vars[$key])) {
        $value=$g_request_vars[$key];
        /**
        * weird boolean conversion
        */
        if(gettype($value) == 'boolean') {

            $value="";
        }
        return $value;
    }

    ### use wildcards ###
    else if(isset($g_request_vars) && preg_match("/\*/",$key)) {
        $key= str_replace("*",".*",$key);


        $hash= array();
        foreach($g_request_vars as $ikey=>$ivalue) {
            if(preg_match("/" . $key . "/", $ikey)) {
                $hash[$ikey]=$ivalue;
            }
        }
        return($hash);
    }
    return $default_value;
}

function getServerVar($name, $as_html= false)
{
    if( isset($_SERVER[$name]) ){
        if( $as_html) {
            return asHtml($_SERVER[$name] );
        }
        return $_SERVER[$name];
    }
}
/**
* sometimes useful for debugging
* - note the print of a double % which will trigger a warning for debug out
*   in unit tests
*
*/
function printFormVars()
{
    global $g_request_vars;
    echo "%" . "%<pre>";
    print_r($g_request_vars);
    echo "</pre>";
}

function debugMessage($message)
{
    echo "<div class=debugMessage><pre>";
    print_r( $message );
    echo "</pre></div>";
}



/**
* for securing hidden form information do following
* - when building up forms hiddenfields should be added like...
*           $form->add(new Form_HiddenField('task_project','',$project->id));
* - when rendering, the form requests a from handle for those which is stored with an md5 at _tmp/xxx
*   It then adds the md5 as 'hidden_crc'
*
* - when submitting a form with hidden_values you should first call validateFormCrc() which
*   returns NULL if one of the hidden parameters is missing is changed.
*/
function validateFormCrc()
{
    if(!$handle= get('hidden_crc')) {
        return NULL;
    }
    global $PH;
    $params= $PH->getFromParams($handle);
    if(!$params) {
        log_message("Validing crc for hidden form value failed (from handle missing)", LOG_MESSAGE_HACKING_ALERT);
        return NULL;
    }

    $log_message='';
    $flag_failure= false;
    foreach($params as $key => $value) {
        if($key == 'go') {
            continue;
        }
        if(is_null(get($key)) || get($key) != $value) {
            $log_message.="'$key': '$value' -> '".get($key)."'  ";
            $flag_failure = true;
        }
    }

    if($flag_failure) {
        global $auth;
        log_message("HACK?? Failed hidden form CRC ($log_message) by ". $auth->cur_user->name, LOG_MESSAGE_HACKING_ALERT);
        return NULL;

    }
    return true;
}


/**
* Checks for two parameters:
* - $captcha_input and $captcha_key
*
* The captcha image is been created in misc.inc.php -> imageRenderCaptcha($captcha_key)
* It rendens an image with a key created by the following formula:
*
*  substr(md5( $key . $auth->cur_user->identifier ), 0, 5)
*
* Both form parameters are protected by CRC and stored as from
* handles in the _tmp/ directory. If captcha_key is not found, the
* function returns with true and does nothing.
*
* Returns true/false or aborts if $abort_on_failure is true.
*
* Note: For convience instead of aborting, you should revisit the editForm.
*/
function validateFormCaptcha($abort_on_failure = false)
{
    global $auth;
    if($key= get('captcha_key')) {
        $captcha_input= get('captcha_input');

        $should_be= substr(md5( $key . $auth->cur_user->identifier ), 0, 5);


        if($captcha_input == $should_be) {
            return true;
        }
        else {
            if($abort_on_failure) {
                global $PH;
                $PH->abortWarning(__("Sorry, but the entered number did not match"));
            }
            return false;
        }
    }
    return true;
}

/**
* parse a mysql-dump with multiple queries and sent it to mysql
*
* - adds table-prefix to all select and create-statements
* - This function is a hack to quickly set up the db-structure. Sooner
*   or later it will be replaced with a real table-creation-function.
*/
function parse_mysql_dump($url, $table_prefix, $sql_obj)
{
    $file_content = file($url);
    $query = "";

    foreach($file_content as $sql_line){
        if(trim($sql_line) != "" && strpos($sql_line, "--") === FALSE){
            $query .= $sql_line;
            ### query complete ###
            if(preg_match("/;\s*$/", $sql_line)){

                ### add table-prefixes ###
                $matches= array();
                if(preg_match("/(CREATE\s*TABLE\s[`'](.*)[`'])\s*\(/", $query, $matches)) {
                    $create_string_old= $matches[1];
                    $table_name_old= $matches[2];
                    $create_string_new= str_replace($table_name_old, $table_prefix.$table_name_old, $create_string_old);
                    $query= str_replace($create_string_old, $create_string_new, $query);
                }
                if(preg_match("/(DROP\s+TABLE\s+IF\s+EXISTS [`']*(.*)[`']*);/", $query, $matches)) {
                    $create_string_old= $matches[1];
                    $table_name_old= $matches[2];
                    $create_string_new= str_replace($table_name_old, $table_prefix.$table_name_old, $create_string_old);
                    $query= str_replace($create_string_old, $create_string_new, $query);
                }
                if(preg_match("/(INSERT INTO [`']*(.*)[`']*)\s+\(/", $query, $matches)) {
                    $create_string_old= $matches[1];
                    $table_name_old= $matches[2];
                    $create_string_new= str_replace($table_name_old, $table_prefix.$table_name_old, $create_string_old);
                    $query= str_replace($create_string_old, $create_string_new, $query);
                }

                ### print errors ###
                if(!$result = $sql_obj->execute($query)) {
                    trace($sql_obj);
                    return false;
                }
                $query = "";
            }
         }
    }
    return true;
}



/**
* Basic object for setting values and passing
* constructor-parameters as assoc. array
*
*/
class BaseObject
{

    public function __construct($args=NULL)
    {
        if($args) {
            foreach($args as $key=>$value) {
                is_null($this->$key);   # cause E_NOTICE if member not defined
                $this->$key=$value;
            }
        }
    }


    public function __set($name,$value)
    {
        if($this->$name) {
            $this->$name= $value;
        }
        else {
            trigger_error("setting undefined member '$name'  to '$value'  in Class '" .@get_class($this). "' ",E_USER_WARNING);
            $this->$name= $value;
        }
    }


    #--- get --------------------------------------
    public function __get($nm)
    {
        if (isset($this->$nm)) {
           return $r;
        }
        else {
            trigger_error("reading undefined member '$nm'  in '" .@get_class($this). "' ", E_USER_WARNING);
        }
    }
}





/**
* inserts a number if key=>values into the first list, but does not overwrite existing values
*
* $a= array('x'=>1, 'z'=>2);
* $b= array('x'=>5, 'y'=>2);
* fillMissingValues($a,$b)      # set $b to ['x'=>1, 'y'=>2, 'z'=>2]
*
* Does not return the list!!!
*/
function fillMissingValues(&$list, $settings)
{
    foreach($settings as $key => $value){
        if(!array_key_exists($key, $list)) {
            $list[$key]= $value;
        }
    }
}



/**
* convert a string int months
* NOTE: this check is very loose to also fit for german
*/
function string2month(&$string) {
    $mon=1;
    foreach(array('Jan','Feb','Ma?.r','Apr','Ma','Jun','Jul','Aug','Sep','O','Nov','Dec') as $m) {
        if(preg_match("/^$m/i",$string,$matches)) {
            return "$mon";      # TODO-printf-formated layout for 2 digits
        }
        ++$mon;
    }
    return false;
}


function mysqlDatetime2utc($datetime) {
    $out=array();
    if(preg_match("/\b(\d\d\d\d)[^\d](\d?\d)[^\d](\d?\d)\s+(\d\d)[^\d](\d\d)[^\d](\d\d)\b/",$datetime,$matches)) {
        if(count($matches)==7) {
            $out['year']=$matches[1];
            $out['mon']=$matches[2];
            $out['day']=$matches[3];
            $out['hour']=$matches[4];
            $out['min']=$matches[5];
            $out['sec']=$matches[6];
            return $out;
        }
    }
     return false;
}

/**
* get html-passed ids
*
* - used to pass the ids of elements we want apply functions to (like edit a task, or delete task(2)
* - to avoid accidentally applying functions to both, we will check for wildscards (selected rows in a list)
*   rathen than for a single name (the id of the object the function is called from)
*/
function getPassedIds($name=false,$wild=false)
{

    $ids=NULL;
    #--- first check use wildcards --
    if(!$wild) {
        $wild= strtolower($name)."s_*";     # eg: 'objectS_*'
    }
    $selected_items= get($wild);

    if($selected_items) {
        $keys= array_keys($selected_items);
        foreach($keys as $key) {
            if(preg_match("/_(\d+)_chk/",$key,$matches)) {
                $ids[]=$matches[1];
            }
        }
    }
    if(!$ids) {
        #--- try original id ---
        if($name) {
            $id=get($name);
            $ids=array();
            if(isset($id)) {
                $ids[]=$id;
            }
        }
    }
    return $ids;
}

/**
* get exactly one html-passed id
* -  set PH->message if multiple selected
*/
function getOnePassedId($name=false,$wild=false, $abort_on_failure=true,$message=NULL)
{
    global $PH;

    if(!$message) {
        $message=__("No element selected? (could not find id)","Message if a function started without items selected");
    }
    $ids= getPassedIds($name,$wild);
    if(!$ids) {
        if($abort_on_failure) {
            $PH->abortWarning($message,ERROR_NOTE);
            exit("aborting");
        }
        return;
    }
    else if(count($ids)>1) {
        $message= __('only one item expected.');
        if($abort_on_failure) {
            $PH->abortWarning($message,ERROR_NOTE);
        }
        else {
            $PH->messages[]= $message;
            return;
        }
    }
    return $ids[0];
}




/**
* translate string into another language
*
* - translation is done over assoc. arrays
* - each string that should be translated hase to be writte like ("word","used in this context")
* - in english, or if not translated, only "word" will be written
* - the "context"-string is used to clarify the current meaning like...
*   - ("work for","some company") should be translated different than ("work for","new effort for a person")
* -
*/
global $g_lang;
$g_lang="en";
function __ ( $str, $context=NULL ) {
    global $g_lang;

    if (!isset($g_lang) or $g_lang == "en") {
        return $str;
    }

    global $g_lang_table;

    ### first try clarified phrase ###
    if($context && isset($g_lang_table[$str."|".$context]) && $g_lang_table[$str."|".$context]!="" ) {
        return preg_replace('/\|.*/','',$g_lang_table[$str."|".$context]);
    }

    ### then try general phrase ###
    if(isset($g_lang_table[$str]) && $g_lang_table[$str] != "") {
        return preg_replace('/\|.*/','',$g_lang_table[$str]);
    }

    ### not found -> keep in not-found-list for later output ###
    global $g_lang_new;
    if(!isset($g_lang_new)) {
        $g_lang_new=array();
    }
    $g_lang_new[$str."|".$context]="?";

    return $str;
}


/**
* set language
*
* This will include a big assoc. array as translation-table.
*
* Setting setLanguage twice might work, since the language-file
* is NOT "require(d)_once"
*/
function setLang($lang) {
    global $g_lang;
    if($lang == $g_lang) {
        return;
    }
    if($lang == 'en') {
        $g_lang= 'en';
    }
    else {
        $filepath= "lang/{$lang}.inc.php";
        if(file_exists($filepath)) {
            require($filepath);
            $g_lang= $lang;
        }
        else {
            trigger_error("Undefined language '$lang'", E_USER_NOTICE);
            return;
        }
    }

    /*
    * reset time format
    */
    clearCachedTimeFormats();

    $locale = confGet('DEFAULT_LOCALE');

    if($locale != 'C') {
        // setlocale() is used to set the proper locale for date formatting
        // As locale identifiers are platform dependent, PHP allows to specify more than one,
        // they are tried in order until a supported one is found. Most *nix-based platforms
        // use "xx_XX.encoding", while Windows platforms use three letter forms. The more
        // locales are listed, the more compatible the code will be.
        // Please refer to documentation of function setlocale() for details.
        // TODO: should we set the locale also for LC_CTYPE and/or LC_COLLATE?

        if( $locale == 'USE_TRANSLATION') {
            $locale = __('en_US.utf8,en_US,enu', 'list of locales');
        }

        $res = setlocale(LC_TIME, explode(',', $locale));

        # this warning might be annoying, but we need a way to detect that setlocale failed
        # eventually the list of locales will be long enough to include all supported platforms
        # 
        # pixtur: changed from warning to log_message that will only be displayed when
        # 
        
        if($res === FALSE) {
            log_message("Could not set locale to '$locale'", E_USER_WARNING);
        }
    }
}





/**
* readfile for very large files
* by from flobee@gmail.com
*/
function readfile_chunked($filename, $retbytes=true) {
    $chunksize = 1*(1024*1024); // how many bytes per chunk
    $buffer = '';
    $cnt =0;
    // $handle = fopen($filename, 'rb');
    $handle = fopen($filename, 'rb');
    if ($handle === false) {
        return false;
    }
    while (!feof($handle)) {
        $buffer = fread($handle, $chunksize);
        echo $buffer;
        if(ob_get_length()) {
            ob_flush();
        }
        flush();
        if ($retbytes) {
           $cnt += strlen($buffer);
        }
    }
    $status = fclose($handle);

    if ($retbytes && $status) {
       return $cnt; // return num. bytes delivered like readfile() does.
    }
    return $status;

}


function createRandomString() {
    return  md5( time().microtime() . rand(12312,time()) . rand(234423,123213));
}



/**
* removes all non-alpha numeric characters
* - all user-data from user-input that a used to build up sql-queries
*   should be filtered by this
*
*/
function asAlphaNumeric($str) {
    return preg_replace("/[^0-9A-Z_]/i",'',$str);
}


function asSearchQuery($str) {
    return preg_replace("/[\[\]<>;$\t \/(),\*+:\"'.=]/"," ",$str);
}

function asMatchString($str) {
    #return preg_replace("/[^0-9A-Z_]/i",' ', $str); 
    return preg_replace("/[\/\<\>\`\´_%&?\"\'()\[\]%]/",' ', $str); 
}

function asIdentifier($str) {
    return strtolower( preg_replace("/[^0-9A-Z_]/i",'_', $str) ); 
}

/**
* this function is used for cleaning strings that might be passed as parameters
* to the database. With 0.093 we switched from stripping dangerous characters to
* whitelisting only basic alpha-numeric chars.
*/
function asCleanString($str)
{
    return preg_replace("/[^\w ,.]/","",$str);  
    //return preg_replace("/[\\\<\>\`\´\"']/",'',$str);
}


function asSecureString($str)
{
    global $sql_obj;
    if(!is_object($sql_obj)) {
        trigger_error("sql_obj not defined", E_USER_ERROR);
    }
    return $sql_obj->secure($str);

}


function getOrderByString($f_order_str=NULL, $default='')
{
    if($tmp= asCleanString($f_order_str)) {
        return 'ORDER BY '. $tmp;
    }
    else if($tmp= asCleanString($default)) {
        return 'ORDER BY '. $tmp;
    }
    return '';
}


/**
* to prevent code injection all user-entered text should be printed asHtml()
*/
function asHtml($str) {

    #$str= str_replace("\\\"", '"',$str);

    return htmlSpecialChars($str, ENT_QUOTES,'UTF-8' );
}

/**
* removes all non alphanumerics
*/
function asKey($str) {
    return preg_replace("/[^0-9a-z_]/",'',strtolower($str));
}







/**
* note: the strToTime-function is useful for converting SQL-Timestrings like 2005-05-02 23:23:32
* into seconds. But this conversion is always into local time -- not GMT. This functions adds the user's
* time-shift to adjust this behavior.
*/
function strToGMTime($str)
{
    return (strToTime($str. " GMT") );
}


/**
* converts a time string like 2005-05-02 23:23:32 from the client's timezone to database GMT-String
*/
function clientTimeStrToGMTString($str)
{
    global $auth;
    $time_offset= 0;
    if(isset($auth->cur_user)) {
        $time_offset= $auth->cur_user->time_offset;
    }
    return getGMTString( strToGMTime($str) - $time_offset  -  confGet('SERVER_TIME_OFFSET'));
}


/**
* converts a time in seconds from the client's timezone to database GMT-String
*/
function clientTimeToGMTString($time)
{
    global $auth;
    $time_offset= 0;
    if(isset($auth->cur_user)) {
        $time_offset= $auth->cur_user->time_offset;
    }
    return getGMTString( $time - $time_offset -  confGet('SERVER_TIME_OFFSET'));
}



/**
* returns GMT-date formated as Y-m-d H:i:s
* - if no argument given, Now is used.
*/
function getGMTString($time=NULL)
{
    if(is_null($time)) {
        $time = time();
    }
    return gmdate("Y-m-d H:i:s", $time);
}


/**
* converts GMT time string (e.g. from database) to client time in seconds
*/
function strToClientTime($str)
{
    if($str == '0000-00-00 00:00:00' || $str == '0000-00-00') {
        return 0;
    }
    global $auth;
    $time_offset= 0;
    if(isset($auth->cur_user)) {
        $time_offset= $auth->cur_user->time_offset;
    }
    return strToTime($str . " GMT")  + $time_offset +  confGet('SERVER_TIME_OFFSET');
}


/**
* converts GMT (in seconds) to Client time (in seconds)
*/
function GMTToClientTime($time)
{
    global $auth;
    $time_offset= 0;
    if(isset($auth->cur_user)) {
        $time_offset= $auth->cur_user->time_offset;
    }
    return $time + $time_offset + confGet('SERVER_TIME_OFFSET');
}






/**
* Rollout a tree structure in a list
*
* - This function is used for comments, but it is object independant, as long as:
*   Objects have children and level attributes
*
* @params:
* - $obj_with_children - reference to object (e.g. of type Comment)
* - $list - reference to resulting, flat list of objects
* - $level recursion depth
*/
function sortObjectsRecursively(&$obj_with_children, &$list, $level=0)
{

    $obj_with_children->level= $level;
    $list[]= $obj_with_children;

    foreach($obj_with_children->children as $id => $child) {
        if($child->id) {
            sortObjectsRecursively($child, $list, $level+1);
        }
    }
    return $list;
}

/**
* returns spam probability as float from 0 .. 1 (or higher for very likely)
*
* - uses confGet('SPAM_WORDS')
* - see conf.inc.php for settings
*/
function getSpamProbability($str) {
    $cleaned= preg_replace("/[^a-z]/",'', strtolower($str));
    $count= 0;
    $count_matched_words=0;
    foreach(confGet('SPAM_WORDS') as $word => $value) {

        if($tmp= substr_count($cleaned, $word)) {
            $count_matched_words += $value;
            $count+= $tmp * $value;
        }
    }
    if(str_word_count($str)) {
        $rate= $count * $count_matched_words/ str_word_count($str) / count(confGet('SPAM_WORDS'));
    }
    else {
        $rate= 0;
    }
    return $rate;
}


function isSpam($str) 
{
    $probability = getSpamProbability($str);
    if( $probability > confGet('REJECT_SPAM_CONTENT') )  {
        return $probability;
    }
    else {
        return 0;
    }
}


function validateNotSpam($str) 
{
    global $PH;
    global $auth;
    
    if(     confGet('REJECT_SPAM_CONTENT')  
        && $auth->cur_user->id == confGet('ANONYMOUS_USER') 
        && isSpam($str)
    ) {
        log_message(sprintf("rejected spam comment from %s with %s", getServerVar('REMOTE_ADDR'), getSpamProbability($str)),  LOG_MESSAGE_HACKING_ALERT);
        $PH->abortWarning(__("Comment has been rejected, because it looks like spam.") );
    }
}

/**
* helper function to clear global variables used in render_misc time rendering.
*/
function clearCachedTimeFormats() 
{
    global $g_userFormatTimestamp;
    $g_userFormatTimestamp = NULL;

    global $g_userFormatTime;
    $g_userFormatDate = NULL;

    global $g_userFormatDate;
    $g_userFormatDate = NULL;
}

/**
* Map firephp trace function for easy disabling
*/
function trace($message, $options= '')
{
    if (confGet('USE_FIREPHP')) {
        global $g_firephp;
        if (!isset($g_firephp)) {
            require_once('lib/firephp/FirePHP.class.php');
            #require_once('lib/firephp/fb.php');
            $g_firephp = FirePHP::getInstance(true);
            $options = array('maxObjectDepth' => 1,
                 'maxArrayDepth' => 1,
                 'useNativeJsonEncode' => true,
                 'includeLineNumbers' => true
                 );
 
             $g_firephp->setOptions($options);
        }
        $g_firephp->trace($message, $options);
    }
    else {
        debugMessage($message);
    }
}

?>
