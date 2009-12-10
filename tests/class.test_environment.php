<?php

/*
 setup test database
*/

class TestEnvironment extends BaseObject {
    
    /**
    * execute sql file with unit_test_table_prefix
    */
    static public function prepare($sql_setup_file)
    {
        ### prepare test database
        require_once( dirname(__FILE__) . '/../_settings/db_settings.php');
        
        
        ### Create database ###
        ### included database handler ###
        $db_type = confGet('DB_TYPE');
        if(file_exists("../db/db_".$db_type."_class.php")){
            require_once(dirname(__FILE__) . "/../db/db_".$db_type."_class.php");
        }
        else{
            trigger_error("Datebase handler not found for db-type '$db_type'", E_USER_ERROR);
        }

        #$sql_obj = new sql_class($f_hostname, $f_db_username, $f_db_password, $f_db_name);
        require_once( dirname(__FILE__) . '/../db/db.inc.php');

        ### trigger db request ###
        $dbh = new DB_Mysql;
        $sql_obj= $dbh->connect();

        if(!parse_mysql_dump($sql_setup_file, confGet('DB_TABLE_PREFIX_UNITTEST') . confGet('DB_TABLE_PREFIX'), $sql_obj) ) {
            #trace("error");
            print "error setting up database structure";
            print "mySQL-Error[" . __LINE__ . "]:<pre>".$sql_obj->error."</pre>";
        }
    }


    static public function initStreberUrl()
    {
        global $g_streber_url;
        $directory = explode("/tests/", $_SERVER['SCRIPT_NAME']);
        $g_streber_url= confGet('SELF_PROTOCOL') . "://" . asCleanString($_SERVER['HTTP_HOST'])  . $directory[0] ;
    }

}

function validatePage($handle) {
    foreach( array("error:", "Error:", "error_list", "NOTICE:") as $p) {
        $handle->assertNoUnwantedText($p);
    }
    $handle->assertNoUnwantedPattern('/<x>/', 'check unescaped data (%s)');
    $handle->assertNoUnwantedPattern('/&amp;lt;x&amp;gt;/',     'check double escaped data (%s)');
    $handle->assertValidHtmlStucture('login');
}

?>