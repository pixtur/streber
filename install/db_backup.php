<?php

/**
* send gzipped backup of a database (c) thomas@pixtur.de
*
* Released under the terms of GPL
*
* This script is based on mySQLAdmin (c) 2001. It provides an easy way to
* backup databases without having a shell-account. The backup will be sent as
* gzip-file and named after the hostname, databasename and time.
*
* You have to manually adjust the connect information.
* Make sure this script is not made available at a public location.
*
*
*/

error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_STRICT|E_PARSE|E_CORE_ERROR|E_CORE_WARNING|E_COMPILE_ERROR);

ini_set("max_execution_time",300);

$dumper= new MySQLDumper();
$dumper->use_gzip = false;

if($dumper->connect(
        'localhost',	    # hostname
        'root',	            # DB-username
        '',	                # DB-password
        'streber'	    # DB-name
)) {
   $dumper->use_gzip= false;
   $dumper->dump();
   #$dumper->executeFromFile("streber-pm.sql");
}


/*if($dumper->connect(
        'localhost',	    # hostname
        'user',	            # DB-username
        'password',	        # DB-password
        'database'	        # DB-name
)) {
   $dumper->dump();
   #$dumper->executeFromFile("streber.pixtur.de.sql");
}
*/



/**
* MySQLDumper - class
*
*/
class MySQLDumper {

    var $dbh                = NULL;
    var $add_drop_statement = true;
    var $crlf               ="\n";
    var $use_backquotes     = true;
    var $use_gzip           = true;
    var $line_buffer        = array();

    function connect($hostname,$db_username,$db_password,$db_name) {

        $this->hostname     = $hostname;
        $this->db_username  = $db_username;
        $this->db_password  = $db_password;
        $this->db_name      = $db_name;

    	$this->dbh = mysql_pconnect(
            $this->hostname,        # hostname
            $this->db_username,     # db_username
            $this->db_password      # db_password
        );

        if(!$this->dbh || !is_resource($this->dbh)) {
            echo "mysql-error:<pre>".mysql_error()."</pre>";
            return NULL;
        }

        ### select db ###
        if(!mysql_select_db($this->db_name, $this->dbh)) {
            echo "mysql-error:<pre>".mysql_error()."</pre>";
            return NULL;
        }
        return true;
    }

    function write($string)
    {
        if($this->use_gzip) {
            $this->line_buffer[]= $string;
        }
        else {
            echo $string;
        }
    }

    function dump( ) 
    {
        /**
         * Increase time limit for script execution and initializes some variables
         */
        set_time_limit(0);

        $hostname="";
        if(isset($_SERVER["HTTP_HOST"])) {
    	    $hostname= $_SERVER["HTTP_HOST"];
        }

        if($this->use_gzip) {
            $filename   = $hostname . "_". $this->db_name.'_'. gmdate("Y-m-d_H:i"). '.gzip';
            $mime_type  ='application/x-gzip';
        } 
        else {
            $filename   = $hostname . "_". $this->db_name.'_'. gmdate("Y-m-d_H:i"). '.sql';
            $mime_type  ='';            
        }

        ### Send headers
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Expires: 0');
        header('Pragma: no-cache');

        ### IE need specific headers
        #if(getBrowserAgent() == 'IE') {
        #    #header('Content-Disposition: inline; filename="' . $filename . '.' . $ext . '"');
        #    header('Expires: 0');
        #    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        #    header('Pragma: public');
        #}


        ### Builds the dump
        $tables     = mysql_list_tables($this->db_name);

        if(!$num_tables = mysql_numrows($tables)) {
            echo "mysql-error:<pre>".mysql_error()."</pre>";
            trigger_error("no tables found", E_USER_ERROR);
            exit(0);
        }

        $this->write("# slim phpMyAdmin MySQL-Dump\n");

        for($i=0; $i < $num_tables; $i++) {

            $table_name = mysql_tablename($tables, $i);
            $this->write( $this->crlf
                        .  '#' . $this->crlf
                        .  '#' . $this->backquote($table_name) . $this->crlf
                        .  '#' . $this->crlf . $this->crlf
                        .  $this->getTableDef($table_name) . ';' . $this->crlf
                        .  $this->getTableContentFast($table_name)
            );
        }

        $this->write($this->crlf);

        ### Displays the dump as gzip-file
        if($this->use_gzip) {            
            if (function_exists('gzencode')) {
                echo gzencode(implode("",$this->line_buffer));                    # without the optional parameter level because it bugs
            }
            else {
                trigger_error("gzencode() not defined. Saving backup failed", E_USER_ERROR);
            }
        }
    }



    function executeFromFile($filename) 
    {
        /**
         * Increase time limit for script execution and initializes some variables
         */
        set_time_limit(0);
        $handle = @fopen("$filename", "r");
        if ($handle) {
            $exec_buffer= '';
            while (!feof($handle)) {
            
                $line_buffer = fgets($handle, 4096);
                $exec_buffer.= $line_buffer;

                if(preg_match("/;\s*\n$/s", $line_buffer))     {
                    $result= mysql_query($exec_buffer);
                    if($result == FALSE) {
                        echo "<pre>" . mysql_error() . "</pre>";                        
                        echo "<pre>$exec_buffer</pre>";
                    }
                    $exec_buffer="";
                }
           }
           fclose($handle);
        }
    }



    function getTableDef($table)
    {
        $schema_create = '';

        if($this->add_drop_statement) {
            $schema_create .= 'DROP TABLE IF EXISTS ' . $this->backquote($table) . ';' . $this->crlf;
        }

        // Whether to quote table and fields names or not
        if ($this->use_backquotes) {
            mysql_query('SET SQL_QUOTE_SHOW_CREATE = 1');
        }
        else {
            mysql_query('SET SQL_QUOTE_SHOW_CREATE = 0');
        }

        $result = mysql_query('SHOW CREATE TABLE ' . $this->backquote($this->db_name) . '.' . $this->backquote($table));

        if ($result != FALSE &&  mysql_num_rows($result) > 0) {
            $tmpres        = mysql_fetch_array($result);
            $schema_create .= $tmpres[1];

            mysql_free_result($result);
            return $schema_create;

        }
        else {
            echo "<pre>".mysql_error()."</pre>";

            trigger_error("SHOW CREATE TABLE failed", E_USER_ERROR);
        }
    }


    /**
     * php >= 4.0.5 only : get the content of $table as a series of INSERT
     * statements.
     *
     * @author  staybyte
     */
    function getTableContentFast($table)
    {
        $buffer='';


        $local_query = 'SELECT * FROM ' . '.' . $this->backquote($table);
        $result      = mysql_query($local_query);
        if ($result) {
            $fields_cnt = mysql_num_fields($result);
            $rows_cnt   = mysql_num_rows($result);

            ### Checks whether the field is an integer or not
            for ($j = 0; $j < $fields_cnt; $j++) {
                $field_set[$j] = $this->backquote(mysql_field_name($result, $j));
                $type          = mysql_field_type($result, $j);
                if ($type == 'tinyint' || $type == 'smallint' || $type == 'mediumint' || $type == 'int' ||
                    $type == 'bigint'  ||$type == 'timestamp') {
                    $field_num[$j] = TRUE;
                }
                else {
                    $field_num[$j] = FALSE;
                }
            }

            ### Sets the scheme
            $fields        = implode(', ', $field_set);
            $schema_insert = 'INSERT INTO ' . $this->backquote($table) . ' (' . $fields . ') VALUES (';


            $search       = array("\x00", "\x0a", "\x0d", "\x1a"); //\x08\\x09, not required
            $replace      = array('\0', '\n', '\r', '\Z');
            $current_row  = 0;

            while ($row = mysql_fetch_row($result)) {

                $values= array();
            	$current_row++;
                for ($j = 0; $j < $fields_cnt; $j++) {
                    if (!isset($row[$j])) {
                        $values[]     = 'NULL';
                    }
                    else if ($row[$j] == '0' || $row[$j] != '') {

                        ### a number
                        if ($field_num[$j]) {
                            $values[] = $row[$j];
                        }
                        ### a string
                        else {
                            $values[] = "'" . str_replace($search, $replace, $this->sqlAddslashes($row[$j])) . "'";
                        }
                    }
                    else {
                        $values[]     = "''";
                    }
                }

                $insert_line      = $schema_insert . implode(', ', $values) . ');'."\n";

                $buffer.= $insert_line;


                ### loic1: send a fake header to bypass browser timeout if data are bufferized
                if (!empty($GLOBALS['ob_mode'])) {
                    header('Expires: 0');
                }
            }
        }
        mysql_free_result($result);
        return $buffer;
    }


    /**
    * Adds backquotes on both sides of a database, table or field name.
    * Since MySQL 3.23.6 this allows to use non-alphanumeric characters in
    * these names.
    */
    function backquote($a_name)
    {
        if (!$a_name && $a_name != '*') {
            return '`' . $a_name . '`';
        }
        else {
            return $a_name;
        }
    }

    function sqlAddslashes($a_string = '')
    {
        if ($this->use_backquotes) {
            $a_string = str_replace('\\', '\\\\\\\\', $a_string);
        } else {
            $a_string = str_replace('\\', '\\\\', $a_string);
        }
        $a_string = str_replace('\'', '\\\'', $a_string);

        return $a_string;
    }

}




?>
