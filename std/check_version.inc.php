<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
/**
* check the current version of php, mysql and streber
*
* this prevents from mysql-exceptions provides propper error-messages
*
*/



/**
* do some checks before doing anything serious
*
* This file is assumed to be php4 valid.
*/
function validateEnvironment()
{

    $flag_errors= false;
    if(($result= testPhpVersion()) !== true) {

        echo confGet('MESSAGE_OFFLINE');
        echo $result;
        exit();
    }

    if(($result= testDbConnection()) !== true) {
        echo confGet('MESSAGE_OFFLINE');
        echo $result;
        exit();
    }

    #if(($result= testInstallDirectoryExists()) != true) {
    #    echo $result;
    #    $flag_errors= true;
    #}



    if($flag_errors){
        return false;
    }
    return true;
}




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
* is db online?
*/
function testDbConnection() {
    require_once(dirname(__FILE__)."/../db/db.inc.php");
    $db= new DB_Mysql();
    if($db=$db->getVersion()) {
        if($db['version'] < confGet('DB_VERSION_REQUIRED')) {

            return "the version of current database (". $db['version'] .")does not match the current version of streber (". confGet('STREBER_VERSION'). ")<br><a href='install/install.php'>try upgrading</a>";
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

    if(file_exists('install')) {
        echo "<h2>Install-directory still present.</h2> This is a massive security issue (<a href='".confGet('STREBER_WIKI_URL')."installation'>read more</a>).";
        echo '<ul><li><a href="install/remove_install_dir.php">remove install directory now.</a></ul>';
        return false;
    }
    return true;
}


