<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * functions and definitions related to handling errors
 *
 * do not confuse with...
 * - pages/error.inc (display an error-page)
 * - std/exceptions.inc (defines php-exceptions)
 *
 * requires: php4
 *
 * called from: index.php
 *
 * @author Thomas Mann
 * @uses:   nothing
 * @usedby: render_page.inc -> PageFooter()
 *
 */

DEFINE('ERROR_NOTE',        1);
DEFINE('ERROR_WARNING',     2);
DEFINE('ERROR_FATAL',       3);
DEFINE('ERROR_BUG',         4);
DEFINE('ERROR_RIGHTS',      5);
DEFINE('ERROR_DATASTRUCTURE', 6);


global $g_error_list;
$g_error_list=array();

function customHandler($number, $error_string, $file, $line, $context)
{
    global $g_error_list;

    ### strip absolute path from filenames
    $path= dirname(__FILE__)
         ? str_replace('std', '', dirname(__FILE__))
         : '';

    $file= str_replace($path, '', $file);


    ### special-handler of mail()-errors ###
    if(preg_match("/^mail\(\)/",$error_string, $matches)) {
        global $g_error_mail;
        $g_error_mail= str_replace("[<a href='function.mail'>function.mail</a>]",'',$error_string);
        log_message($g_error_mail);
        return;
    }

    switch ($number){
        case E_USER_ERROR:
            $error_type= "ERROR";
            $stop = true;
            break;

        case E_WARNING:
        case E_USER_WARNING:
            $error_type= "WARNING";
            $stop = false;
            break;

        case E_NOTICE:
        case E_USER_NOTICE:
            $error_type= "NOTICE";
            $stop = false;
            break;
        default:
            $error_type= "UNHANDLED ERROR";
            $stop = false;
    }


    ### build error-buffer for log-file
    $error_buffer  = "\n";
    $error_buffer .= sprintf("%s: %20s :%4s %s\n", $error_type, $file, $line,$error_string); # $str_line -> $str_function()";

    ### render backtrace
    $trace = debug_backtrace();                                                  # Get a backtrace of the function calls
    $errous_function=-1;

    {
        for($x=1; $x < count($trace); $x++) {                                        # Start at 2 -- ignore this function (0) and the customHandler() (1)
            $str_function= isset($trace[$x]['function'])
                         ?       $trace[$x]['function']
                         : '';

            if($str_function == 'trigger_error') {
                $errous_function= $x;
                continue;
            }

            $str_file    = isset($trace[$x]['file'])
                         ? str_replace($path, '', $trace[$x]['file'])
                         : '';

            $str_class   = isset($trace[$x]['class'])
                         ? $trace[$x]['class']."::"
                         : '';

            $str_line    = isset($trace[$x]['line'])
                         ?       $trace[$x]['line']
                         : '';

            $str_args    = isset($trace[$x]['args'])
                         ? implodeArgs($trace[$x]['args'])
                         : '';

            $error_buffer .= sprintf("%29s :%4s -> %s%s(%s)\n", $str_file, $str_line, $str_class,$str_function, $str_args); # $str_line -> $str_function()";
        }

        ### render variables ####
        if(isset($trace[2]['function'])) {
            $error_buffer .= "\n     Variables in {$trace[2]['function']}():\n";
            foreach($context as $name => $value) {
                if (!empty($value)) {
                    if(is_object($value)) {
                        $value= "OBJECT";                   # this is a hack for php5.2.0 which would otherwise break without any warning
                    }

                    $error_buffer .= sprintf("%29s = %s\n", $name, $value);
                }
                else {
                    $error_buffer .= sprintf("%29s = NULL\n", $name, $value);
                }
            }
        }
    }

    ### collect additional information
    {
        $infos=array();
        if(function_exists('confGet')) {
            $infos[]='v'. confGet('STREBER_VERSION');
        }
        global $PH;
        if(isset($PH->cur_page_id)) {
            $infos[]= $PH->cur_page_id;
        }

        $infos[]='from '. $_SERVER["REMOTE_ADDR"];

        if(isset($_SERVER["REQUEST_URI"])) {
            $infos[]=' uri:'. $_SERVER["REQUEST_URI"];
        }

        if(count($infos)) {
            $error_buffer.= "   ".implode(", ",$infos)."\n";
        }
    }

    ### prepend date and add line add beginning
    $prepend = "\nError " . @gmdate("YmdHis") . " ";
    $error_buffer   = "\n" . preg_replace("/\n/", $prepend, $error_buffer);

    ### render complete output?
    if(function_exists('confGet') && confGet('DISPLAY_ERROR_FULL')) {
        print "<pre>{$error_buffer}</pre>";
    }

    ### Log to a user-defined filename
    error_log($error_buffer, 3, dirname(__FILE__)."/../_tmp/errors.log.php");

    ### html output ###
    if(function_exists('confGet') && confGet('DISPLAY_ERROR_LIST')=='LIST') {
        $g_error_list[]= sprintf("%s: %s", $error_type, $error_string);
    }

    else if(function_exists('confGet') && confGet('DISPLAY_ERROR_LIST')=='DETAILS') {
        $file_good= isset($trace[$errous_function]['file'])
                        ? $trace[$errous_function]['file']
                        : $file;

        $line_good= isset($trace[$errous_function]['line'])
                        ? $trace[$errous_function]['line']
                        : $line;

        $file_good= str_replace($path, '', $file_good);

        $g_error_list[]= sprintf("%s %s : %s: %s", $file_good, $line_good, $error_type, $error_string);
    }

    ### exit php?
    if ($stop == true) {
        print "<h1>A fatal error occured</h1>";
        if(confGet('DISPLAY_ERROR_LIST')) {
            print "<pre>$error_string</pre>";
        }
        print "<p>Sorry, but ".confGet('APP_NAME')." aborted.</p>";
        print "<p>If you are the administrator of this installation, <br>please help use by sending the errors.log.php file to<br> <a href='http://www.streber-pm.org/phpBB2/viewforum.php?f=3'>www.streber-pm.org</a></p>";
        die();

    }
}


/**
* implodes argument-list
*/
function implodeArgs($args)
{
    $arr= array();
    foreach($args as $a) {
        $out= '';
        switch(gettype($a)) {
        case 'boolean':
            $out= $a
                ? 'true'
                : 'false';
            break;
        case 'array':
            $out= '['.count($a). ']';
            break;

        case 'integer':
        case 'float':
        case 'double':
            $out= 'int'.$a;
            break;

        case 'string':
            $a= str_replace("\n", '\n', $a);
            $a= str_replace("\r", '\r', $a);
            $a= str_replace("\t", '\t', $a);
            $a= substr($a, 0, 30);                          # trim string to certain length

            $out= '"'.$a.'"';
            break;

        case 'NULL':
            $out= 'NULL';
            break;

        case 'resouce':
            $out= "".$a;
            break;

        case 'object':
            $out= '*' . get_class($a);
            break;

        }
        $arr[]= $out;
    }
    return implode(', ', $arr);
}

set_error_handler("customHandler");



/**
* add additional message to log-file
*/
function log_message($message, $level= false, $traceback= false)
{
    if((!$level) || (confGet('LOG_LEVEL') & $level) ) {

        $message ="\n".$message;

        $prepend = "\nLog " . @gmdate("YmdHis") . " ";
        $message = preg_replace("/\n/", $prepend, $message);


        if(!error_log($message, 3, dirname(__FILE__)."/../_tmp/errors.log.php")) {
            trigger_error("log message failed",E_USER_NOTICE);
        }
    }
}





?>