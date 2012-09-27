<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
/**
* check the current version of php, mysql and streber
*
* this prevents from mysql-exceptions provides propper error-messages
*
*/


/**
* check propper php-version
*/
function testPhpVersion() {
    $version=phpversion();
    if($version < confGet('PHP_VERSION_REQUIRED')) {
        $buffer=
    	"<h1>Problem</h1>"
    	."streber requires php version ".confGet('PHP_VERSION_REQUIRED'). ' to work.<br>'
    	."current version is '$version' <br>"
    	."Read more about the minimal requirements of streber:"
    	.'<ul>'
    	.'<li><a href="http://streber.sourceforge.net">streber</a></li>'
    	#.'<li><a href="http://wiki.pixtur.de/index.php/Installation">wiki / installation guide"</a>'
    	.'<li><a href="http://www.streber-pm.org/index.php?go=search&query=installation!">installation guide</a></li>'
    	.'</ul>';
        return $buffer;
    }
    return true;
}


/**
* Test if db is online?
* - returns string, if error or true on success
*/
function testDb() {
    require_once(dirname(__FILE__)."/../db/db.inc.php");
    $db= new DB_Mysql();
    if($db=$db->getVersion()) {
        if($db['version'] < confGet('STREBER_VERSION')) {
            return "the version of current database (". $db['version'] .") does not match the current version of streber (". confGet('STREBER_VERSION'). ")<br><a href='install/install.php'>try upgrading</a>";
        }
        if($db['version_streber_required'] > confGet('STREBER_VERSION')) {
            return "the version of current database (". $db['version'] .") requires at least version ". $db['version_streber_required'] ." of streber to be installed. This is version (". confGet('STREBER_VERSION'). ")";
        }
    }
    else {
        return "could not connect to database.";
    }
    return true;
}


/**
* check if install-directory exists...
*/
function testInstallDirectoryExists() {
    if(confGet('STOP_IF_INSTALL_DIRECTORY_EXISTS')) {
        if(file_exists('install')) {
            $buffer= "<h2>Install-directory still present</h2>"
                  . "<ul>"
                  . "<li>For security reasons it needs to be removed before you can proceed. (<a href='" . confGet('STREBER_WIKI_URL') . "3385'>read more</a>)."
                  . "<li>You can try <a href='install/remove_install_dir.php'>remove install directory now</a>. If this fails, please use your FTP-client to delete it manually.</ul>";
            return $buffer;
        }
    }
    return true;
}



/**
* do some checks before doing anything serious
*
* This file is assumed to be php4 valid.
* - will exit script on errors!
*/
function validateEnvironment()
{
    # NOTE: it's weird that we have to use strings for referring to functions...
    foreach( array('testPhpVersion', 'testDb', 'testInstallDirectoryExists' ) as $test_function) {
        $result = $test_function();
    
        if(
            $result !== true 
        ) {
            ### Set uft8
            header("Content-type: text/html; charset=utf-8");

            ### Disable page caching ###
            header("Expires: -1");
            header("Cache-Control: post-check=0, pre-check=0");
            header("Pragma: no-cache");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

            echo sprintf(confGet( 'MESSAGE_OFFLINE'), confGet('EMAIL_ADMINISTRATOR'), confGet('EMAIL_ADMINISTRATOR'));

            echo $result;
            exit();
        }
    }
    return true;
}





