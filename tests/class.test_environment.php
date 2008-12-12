<?php

/*
 setup test database
*/

class TestEnvironment extends BaseObject {
    
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

        if(!parse_mysql_dump($sql_setup_file, confGet('DB_TABLE_PREFIX_UNITTEST'), $sql_obj) ) {
            print "error setting up database structure";
            print "mySQL-Error[" . __LINE__ . "]:<pre>".$sql_obj->error."</pre>";
        }
    }
}

function validatePage($handle) {
    foreach( split(",", "error_list") as $p) {
        $handle->assertNoUnwantedPattern('/' . $p . '/i');
    }
    $handle->assertNoUnwantedPattern('/<x>/', 'check unescaped data');
    $handle->assertNoUnwantedPattern('/&amp;lt;x&amp;gt;/',     'check double escaped data (%s)');
    $handle->assertValidHtmlStucture('login');

}


?>