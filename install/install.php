<?php
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html


/**
*
* installation
*
*/
error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_STRICT
                |E_PARSE|E_CORE_ERROR|E_CORE_WARNING|E_COMPILE_ERROR
);

/**
* create a function to make sure we are starting from a valid entry points (all other php-files check this)
*/
function startedIndexPhp() {return true; }                     # define function

### bypassing date & timezone-related warnings with php 5.1
if (function_exists('date_default_timezone_set')) {
    $tz= @date_default_timezone_get();
    date_default_timezone_set($tz);
    #echo $tz;
}

/**
*
* Add here new supported databases (the first being the default)
*
*/
$g_supported_db_types= array();

if(function_exists('mysql_connect')){
    $g_supported_db_types[]='mysql';
}

if(function_exists('mysqli_connect')){
    $g_supported_db_types[]='mysqli';
}


require_once(dirname(__FILE__)."/../std/common.inc.php");
#require_once(dirname(__FILE__)."/../std/errorhandler.inc.php");
require_once(dirname(__FILE__)."/../conf/defines.inc.php");
require_once(dirname(__FILE__)."/../conf/conf.inc.php");

require_once(dirname(__FILE__)."/install_forms.inc.php");

clearRequestVars();
addRequestVars($_GET);
addRequestVars($_POST);
addRequestVars($_COOKIE);



print_InstallationHTMLOpen();

if(!get('install_step')) {
    step_01_checkEvironment();
}
else {
    step_02_form_submit();
}

print_InstallationHTMLClose();


exit();


/**
* STEP WELCOME TO INSTALLATION
*/
function step_01_checkEvironment() {
    global $g_supported_db_types;

    $flag_errors=false;
    echo "<h1>Welcome to installing streber ".confGet('STREBER_VERSION')."</h1>";
    echo "<h2>Checking environment...</h2>";

    ### check php version ###
    {
        print_testStart("PHP-Version...");
        $php_version=phpversion();
        if($php_version > confGet('PHP_VERSION_REQUIRED')) {
            print_testResult(RESULT_GOOD,"is $php_version");
        }
        else {
            print_testResult(RESULT_FAILED,"Insufficient php version $php_version. Streber requires php v".confGet('PHP_VERSION_REQUIRED').".
             You find additional information on how to get the latest php-version or a service provider
            with php5 at the ".getStreberWikiLink('installation','installation guide'));
            $flag_errors= true;
        }
    }

    ### check mysql-installed ###
    {
        print_testStart("Database installed?");
        if(count($g_supported_db_types)) {
            #$sql_obj = new sql_class('mysqli');                #@@@pixtur 2005-01-04: would creating the obj be better???
            #if($sql_obj -> error == false){
            print_testResult(RESULT_GOOD, "Database support available.");
        }
        else{
            #print_testResult(RESULT_FAILED, $sql_obj->error);
            print_testResult(RESULT_FAILED, "No mysql or mysqli supported");
            $flag_errors= true;
        }
        #unset($sql_obj);
    }

    ### check _settings-directory writeable ###
    {
        print_testStart("check write-permissions for settings directory '<b>". confGet('DIR_SETTINGS') ."</b>'?");
        if(!is_writeable('../'. confGet('DIR_SETTINGS'))) {
            if(!is_dir('../'. confGet('DIR_SETTINGS'))){
                @mkdir('../'. confGet('DIR_SETTINGS'));
            }
            @chmod('../'. confGet('DIR_SETTINGS'), 0777);
            if(!is_writeable('../'. confGet('DIR_SETTINGS'))){
                print_testResult(RESULT_FAILED,"Please grant write-permissions for this directory.");
              $flag_errors= true;
            }else{
                print_testResult(RESULT_GOOD, 'Folder written by Streber, please check permissions rights with your root account.');
            }
        }
        else {
            print_testResult(RESULT_GOOD, "Directory has required permissions set.");
        }
    }

    ### check _tmp-directory writeable ###
    {
        print_testStart("check write-permissions for temporary files directory '<b>". confGet('DIR_TEMP') ."</b>'?");
        if(!is_writeable('../'. confGet('DIR_TEMP'))) {
            if(!is_dir('../'. confGet('DIR_TEMP'))){
                @mkdir('../'. confGet('DIR_TEMP'));
            }
            @chmod('../'. confGet('DIR_TEMP'), 0777);
            if(!is_writeable('../'. confGet('DIR_TEMP'))){
                print_testResult(RESULT_FAILED,"Please grant write-permissions for this directory.");
                $flag_errors= true;
            }
            else
            {
                if($FO = fopen("../" . confGet('DIR_TEMP') . "/errors.log.php", "w")) 
                {
                    @fputs($FO,'<? header("Location: ../index.php");exit(); ?>');
                }    
                print_testResult(RESULT_GOOD, 'Folder written by Streber, please check permissions rights with your root account.');
            }
        }
        else
        {
            if($FO = fopen("../" . confGet('DIR_TEMP') . "/errors.log.php", "w")) 
            {
                @fputs($FO,'<? header("Location: ../index.php");exit(); ?>');
            } 
            
            print_testResult(RESULT_GOOD, "Directory has required permissions set.");
        }
    }

    ### check _files-directory writeable ###
    {
        print_testStart("check write-permissions for files directory '<b>". confGet('DIR_FILES') ."</b>'?");
        if(!is_writeable('../'. confGet('DIR_FILES'))) {
            if(!is_dir('../'. confGet('DIR_FILES'))){
                @mkdir('../'. confGet('DIR_FILES'));
            }
            @chmod('../'. confGet('DIR_FILES'), 0777);
            if(!is_writeable('../'. confGet('DIR_FILES'))){
                print_testResult(RESULT_FAILED,"Please grant write-permissions for this directory. Although you can proceed with installation, you will get warnings later.");
                $flag_errors= true;
            }
            else{
                print_testResult(RESULT_GOOD, 'Folder written by Streber, please check permissions rights with your root account.');
            }
        }
        else {
            print_testResult(RESULT_GOOD, "Directory has required permissions set.");
        }
    }

    ### check _rss-directory writeable ###
    {
        print_testStart("check write-permissions for RSS directory '<b>". confGet('DIR_RSS') ."</b>'?");
        if(!is_writeable('../'. confGet('DIR_RSS'))) {
            if(!is_dir('../'. confGet('DIR_RSS'))){
                @mkdir('../'. confGet('DIR_RSS'));
            }
            @chmod('../'. confGet('DIR_RSS'), 0777);
            if(!is_writeable('../'. confGet('DIR_RSS'))){
                print_testResult(RESULT_FAILED,"Please grant write-permissions for this directory. Although you can proceed with installation, you will get warnings later.");
                $flag_errors= true;
            }
            else{
                print_testResult(RESULT_GOOD, 'Folder written by Streber, please check permissions rights with your root account.');
            }
        }
        else {
            print_testResult(RESULT_GOOD, "Directory has required permissions set.");
        }
    }
    ### check db-setting exists ###
    {
        print_testStart("check previous db-settings in'<b>". confGet('DIR_SETTINGS') ."</b>'...");
        $filepath_db_settings= '../'. confGet('DIR_SETTINGS'). confGet('FILE_DB_SETTINGS');

        if(file_exists($filepath_db_settings)) {
            print_testResult(RESULT_GOOD,"use settings of previous installation.");
            require_once($filepath_db_settings);

        }
        ### check if old style .inc setting exists...
        else if(file_exists('../'. confGet('DIR_SETTINGS'). "db_settings.inc.php")) {
            require_once('../'. confGet('DIR_SETTINGS'). "db_settings.inc.php");
            print_testResult(RESULT_PROBLEM,"'db_settings.inc.php' found. This extension has been depreciated. Trying to rename to ".confGet('DIR_SETTINGS'));
            if(!rename('../'. confGet('DIR_SETTINGS'). "db_settings.inc.php",
                   '../'. confGet('DIR_SETTINGS'). confGet('FILE_DB_SETTINGS'))
            ) {
                print_testResult(RESULT_PROBLEM,"Renaming failed. Please remove manually.");
            }
        }
        
        else print_testResult(RESULT_GOOD,"does not exists. Fresh installation");
        
        global $g_form_fields;
        $g_form_fields['db_username']['value']=     confGet('DB_USERNAME') ? confGet('DB_USERNAME') : NULL;
        $g_form_fields['db_password']['value']=     confGet('DB_PASSWORD') ? confGet('DB_PASSWORD') : NULL;
        $g_form_fields['db_name']['value']=         confGet('DB_NAME')     ? confGet('DB_NAME') : NULL;
        $g_form_fields['db_table_prefix']['value']= confGet('DB_TABLE_PREFIX') ? confGet('DB_TABLE_PREFIX') : NULL;
    }

    ### abort on errors... ##
    if($flag_errors) {
        echo "<h2>Installation failed</h2>";
        echo "You may find help at ".getStreberWikiLink('installation','the wiki-installation guide');

        return false;
    }
    ### ...or render the configuration-form ###
    else {
        print_setup_form();
        return true;
    }
}


/**
* check form-fields
*/
function step_02_form_submit()
{

    ### check params passed ###
    global $g_form_fields;

    $errors=false;

    foreach($g_form_fields as $key=>$value) {
        $f= &$g_form_fields[$key];
        $value=get($f['id']);

        if(isset($value)) {
            $f['value']= $value;
        }
        else if($f['type'] == 'checkbox') {
            $f['value']= false;
        }
        if(isset($f['required']) && $f['required'] && !$value ) {
            $errors=true;
            $f['error']= true;
        }
    }

    ### reshow form if errors ###
    if($errors) {
         echo "<h2>Note: some fields are required</h2>";
         print_setup_form();
         return;
    }

    ### if no error continue ###
    if(step_02_proceed()) {
        echo "<h2>Installation finished successfully</h2>";
        echo "NOTE: If you don't remove the install-directory now, other people can spy out your database-settings!<br>";

        echo "Please proceed by either...";
        echo "<ul>";
        echo "<li><a href='remove_install_dir.php'>try to delete installation-directory</a> now";
        echo "<li>".getStreberWikiLink('first steps','read a fast tutorial about first steps');
        echo "<li><a href='../index.php'>login</a>";
        echo "</ul>";
    }
    else {
        echo "<h2>Installation failed</h2>";
        echo "You may find help at ".getStreberWikiLink('installation','the wiki-installation guide');
    }
}

/**
* proceed with installation
* - returns true on success
*/
function step_02_proceed()
{
    global $g_form_fields, $sql_obj;



    echo "<h2>Proceeding...</h2>";

    $f_db_type =                $g_form_fields['db_type']['value'];
    $f_hostname =               $g_form_fields['hostname']['value'];
    $f_db_name =                $g_form_fields['db_name']['value'];
    $f_db_username =            $g_form_fields['db_username']['value'];
    $f_db_password =            $g_form_fields['db_password']['value'];
    $f_db_table_prefix =        $g_form_fields['db_table_prefix']['value'];
    $f_user_admin_name =        $g_form_fields['user_admin_name']['value'];
    $f_user_admin_password =    $g_form_fields['user_admin_password']['value'];
    $f_continue_on_sql_errors = $g_form_fields['continue_on_sql_errors']['value'];
    
    require_once(dirname(__FILE__)."/../db/db_".$f_db_type."_class.php");

    ### check mysql-connection ###
    {

        print_testStart("checking mysql connecting to '$f_hostname'...");

        $sql_obj = new sql_class($f_hostname, $f_db_username, $f_db_password, $f_db_name);
        if($sql_obj->error == false){

            # Connection DB
            if(!$sql_obj->connect()) {
                $hint= 'This could be a problem with incorrect setup of your sql-server. <a href="http://www.streber-pm.org/1176">Read more...</a>';
                print_testResult(RESULT_FAILED,"mySQL-Error[" . __LINE__ . "]:<pre>".$sql_obj->error."</pre><br>$hint");
                return false;
            }
            else{
                print_testResult(RESULT_GOOD, $sql_obj->error);
            }
        }
        else{
            print_testResult(RESULT_FAILED, $sql_obj->error);
            return false;
        }
    }

    ### does database already exists? ###
    {
        print_testStart("Make sure to not overwrite existing streber-db called '$f_db_name'");

        ### db does NOT exists ###
        if(!$sql_obj->selectdb()) 
        {
            print_testResult(RESULT_GOOD, $sql_obj->error);

            ### create new database ###
            print_testStart("create database");
            if(!$sql_obj->execute("CREATE DATABASE $f_db_name")) {
                print_testResult(RESULT_FAILED,"<pre>".$sql_obj->error."</pre>");
                return false;
            }
            else {
                if(!$sql_obj->selectdb()) {
                    print_testResult(RESULT_FAILED, $sql_obj->error);
                    return false;
                }
                else {
                    print_testResult(RESULT_GOOD, 'Database '.$f_db_name.' created.');
                }
            }
        }

        ### db exists / upgrade ###
        else 
        {
            print_testResult(RESULT_PROBLEM,"DB '$f_db_name' already exists");

            ### check version of existing database ###
            print_testStart("checking version of existing database");
            if($sql_obj->execute("SELECT * FROM {$f_db_table_prefix}db 
           		WHERE `updated` IS NULL ORDER BY `version` ASC")) 
           	{
                $count=0;
                $db_version=NULL;
                $streber_version_required=NULL;
                while ($row = $sql_obj->fetchArray()) {
                    $db_version= $row['version'];
                    $streber_version_required= $row['version_streber_required'];
                    $count++;
                }
                /**
                * there should be excactly one row with updated == NULL. Otherwise we a have a problem
                */
                
                if($count < 1)
                {
                	/* Ugh oh. Lets see if we can get the row with the highest
                	   version instead. */
                	print_testResult(RESULT_PROBLEM, "Streber has detected a problem with db-version but is attempting to work around it.\n");
                	if($sql_obj->execute("SELECT * FROM {$f_db_table_prefix}db ORDER BY `version` DESC LIMIT 1"))
                	{
                		while ($row = $sql_obj->fetchArray()) 
                		{
							$db_version= $row['version'];
							$streber_version_required= $row['version_streber_required'];
							$count++;
						}
                	}
                	
                	if($count < 1)
                	{
		            	print_testResult(RESULT_FAILED, "Streber is unable to detect your current installed version.<br/>\n"
		            		. "You can work around this by manually adding this information to the db table in your Streber database.");
		            	return false;
                	}
                	
                	print_testResult(RESULT_PROBLEM, "Taking best guess at currently installed version.\n");
                }
                
                if($count > 1) 
                {
                	/* Doh. It appears that our user is the victim of an installer bug
                	 * found in older versions of Streber (we hope). */
                    print_testResult(RESULT_PROBLEM, "Streber has detected a problem with db-version but is now fixing. Upgrade history lost.");
                    $sql_obj->execute("TRUNCATE TABLE {$f_db_table_prefix}db"); 
					$sql_obj->execute("INSERT INTO {$f_db_table_prefix}db SET version = " 
						. $db_version . ", version_streber_required = " . $streber_version_required
						. ", id = 1, updated = ");
                }
                
                if($db_version < confGet('DB_VERSION_REQUIRED')) {

                    ### update ###
                    print_testResult(RESULT_PROBLEM,"version is $db_version. Upgrading...");

                    $result= upgrade(array(
                        'db_type'       => $f_db_type,
                        'hostname'      => $f_hostname,
                        'db_username'   => $f_db_username,
                        'db_password'   => $f_db_password,
                        'db_table_prefix'=> $f_db_table_prefix,
                        'db_name'       => $f_db_name,
                        'db_version'    => $db_version,                    # autodetect
                        'continue_on_sql_errors'=>$f_continue_on_sql_errors,
                    ));
                    return $result;

                }
                else if($streber_version_required > confGet('STREBER_VERSION')) {
                    print_testResult(RESULT_PROBLEM,"version is $db_version. It's requires Version " .confGet('DB_VERSION_REQUIRED'). " of Streber. Current Version is ".confGet('STREBER_VERSION').". Please download and install the latest version.");
                    return false;
                }
                else 
                {
                    $filename= '../'. confGet('DIR_SETTINGS').  confGet('FILE_DB_SETTINGS');
                    print_testStart("writing configuration file '$filename'...");
                    $write_ok = writeSettingsFile($filename, array(
                        'DB_TYPE'       => $f_db_type,
                        'HOSTNAME'      => $f_hostname,
                        'DB_USERNAME'   => $f_db_username,
                        'DB_PASSWORD'   => $f_db_password,
                        'DB_TABLE_PREFIX'=> $f_db_table_prefix,
                        'DB_NAME'       => $f_db_name,
                        'DB_VERSION'    => confGet('DB_CREATE_VERSION'),
                    ));
                    
                    if($write_ok) {
                        print_testResult(RESULT_GOOD, "Current database (version $db_version) looks fine. Installation finished with database setting rewritten to file. Please view ".getStreberWikiLink('installation','Installation Guide')." on how to fix unsolved problems.");
                    }
                    else {
                        print_testResult(RESULT_PROBLEM, "Current database (version $db_version) looks fine. Installation finished with no change (unable to rewrite database setting to file). Please view ".getStreberWikiLink('installation','Installation Guide')." on how to fix unsolved problems.");
                    }                
                    return true;
                }
                print_testResult(RESULT_PROBLEM,"Installation aborted due to unknown reason.");
                return false;
            }

            ### no version / fresh installation ###
            else {
                print_testResult(RESULT_GOOD,
                                "Could not query streber-db version. Assuming fresh installation");
            }
        }



        ### creating database-structure ###
        print_testStart("creating tables...");

        $filename= "./create_structure_v".confGet('DB_CREATE_VERSION').".sql";
        $upgradeFromVersion = NULL;

        if(!file_exists($filename)) {
            $filenames = glob("./create_structure_v*.sql");
            if($filenames) {
                rsort($filenames);
                print_testResult(RESULT_PROBLEM,"Required file $filename is missing, trying to use $filenames[0] instead and then upgrade.");
                $filename = $filenames[0];
                ereg("create_structure_v(.*)\.sql", $filename, $matches);
                $upgradeFromVersion = $matches[1];
            }
            else {
                print_testResult(RESULT_FAILED,"Getting sql-code failed. This is an internal error. Look at ". getStreberWikiLink('installation','Installation Guide') ." for clues. ");
                return false;
            }
        }    
        if(!parse_mysql_dump($filename, $f_db_table_prefix)) {
            print_testResult(RESULT_FAILED,"SQL-Error[" . __LINE__ . "]:<br><pre>".$sql_obj->error."</pre>");
            return false;
        }
        
        if($upgradeFromVersion) {
            $result= upgrade(array(
                'db_type'       => $f_db_type,
                'hostname'      => $f_hostname,
                'db_username'   => $f_db_username,
                'db_password'   => $f_db_password,
                'db_table_prefix'=> $f_db_table_prefix,
                'db_name'       => $f_db_name,
                'continue_on_sql_errors'=>$f_continue_on_sql_errors,
                'db_version'    => $upgradeFromVersion,
            ));
            if(!$result) {
                print_testResult(RESULT_FAILED,"Upgrading failed. This is an internal error. Look at ". getStreberWikiLink('installation','Installation Guide') ." for clues. ");
                return false;
            }
        }
        
        print_testResult(RESULT_GOOD);

        ### create db-version entry ###
        print_testStart("add db-version entry");
        $db_version = confGet('DB_CREATE_VERSION');
        $streber_version_required = confGet('DB_CREATE_STREBER_VERSION_REQUIRED');
        $str_query = "INSERT into {$f_db_table_prefix}db (id,version,version_streber_required,created) VALUES(1,'$db_version','$streber_version_required',NOW() )";
        if(!$sql_obj->execute($str_query)) {
            print_testResult(RESULT_FAILED,"SQL-Error[" . __LINE__ . "]:<pre>".$sql_obj->error. "</pre>");
            return false;
        }
        else {
            print_testResult(RESULT_GOOD);
        }
        
        ### create admin entry entry ###
        print_testStart("add admin-user entry 1/2");
        $password_md5=md5($f_user_admin_password);
        $str_query= "INSERT into {$f_db_table_prefix}person
                          (id,
                          name,
                          nickname,
                          password,
                          user_rights,
                          can_login,
                          profile,
                          language,
                          ip_address,
                          office_email
                          )
                          VALUES(
                          1,
                          '$f_user_admin_name',
                          '$f_user_admin_name',
                          '$password_md5',
                          268435455, /* all rights */
                          1,
                          1,
                          '".confGet('DEFAULT_LANGUAGE')."',
                          '',
                          '" . $g_form_fields["site_email"]["value"] . "'
                          )";
        if(!$sql_obj->execute($str_query)) {
            print_testResult(RESULT_FAILED,"SQL-Error[" . __LINE__ . "]:<br><pre>".$sql_obj->error."</pre>");
            return false;
        }
        else {
            print_testResult(RESULT_GOOD);
        }

        ### create admin entry entry ###
        print_testStart("add admin-user entry 2/2");
        $str_query= "INSERT into {$f_db_table_prefix}item
                          (id,
                          type,
                          state,
                          created_by,
                          modified_by
                          )
                          VALUES(
                          1,
                          ".ITEM_PERSON.",
                          ".ITEM_STATE_OK.",
                          1,
                          1
                          )";
        if(!$sql_obj->execute($str_query)) {
            print_testResult(RESULT_FAILED,"SQL-Error[" . __LINE__ . "]:<br><pre>".$sql_obj->error."</pre>");
            return false;
        }
        else {
            print_testResult(RESULT_GOOD);
        }


        ### settings-directory already exists? ###
        if(!file_exists('../'. confGet('DIR_SETTINGS'))) {
            print_testStart("try to create ".confGet('DIR_SETTINGS')."...");
            if(!mkdir('../'. confGet('DIR_SETTINGS'))) {
                print_testResult(RESULT_FAILED,"could not create directory. This could be a file permission problem...");
            }
            else {
                print_testResult(RESULT_GOOD);
            }
        }

        ### writing setting-file ###
        /* This block should be rewritten into a function to remove duplication.
         * -- Cody Somerville <cody@redcow.ca> 01-MAY-08
         */
        {
        	
        	/* Write general site settings */
        	
        	$filename = "../" . confGet("DIR_SETTINGS") . confGet("SITE_SETTINGS");
        	print_testStart("writing configuration file '" . $filename . "'...");
        	$settings = array(
        		"APP_NAME"	          => $g_form_fields["site_name"]["value"],
        		"EMAIL_ADMINISTRATOR" => $g_form_fields["site_email"]["value"],
        		'APP_TITLE_HEADER'    => $g_form_fields["site_name"]["value"] . "<span class=extend>PM</span>",
        	);
        	
        	$write_ok= writeSettingsFile($filename, $settings);

            if(!$write_ok) 
            {
                print_testResult(RESULT_FAILED, "can not write '" . $filename
                	. "'. Please create it with this content:<br><pre>&lt;?php"
                	. buildSettingsFile($settings) . "?&gt;</pre>");
                return false;
            }
            else print_testResult(RESULT_GOOD);
            
        		
        
        	/* Write database settings */
        	
            $filename='../'. confGet('DIR_SETTINGS').  confGet('FILE_DB_SETTINGS');
            print_testStart("writing configuration file '$filename'...");
            $settings= array(
                'DB_TYPE'       => $f_db_type,
                'HOSTNAME'      => $f_hostname,
                'DB_USERNAME'   => $f_db_username,
                'DB_PASSWORD'   => $f_db_password,
                'DB_TABLE_PREFIX'=> $f_db_table_prefix,
                'DB_NAME'       => $f_db_name,
                'DB_VERSION'    => confGet('DB_CREATE_VERSION'),
            );

            $write_ok= writeSettingsFile($filename, $settings);

            if(!$write_ok) {
                print_testResult(RESULT_FAILED,"can not write '$filename'. Please create it with this content:<br><pre>&lt;?php".buildSettingsFile($settings)."?&gt;</pre>");
                return false;
            }
            else {
                print_testResult(RESULT_GOOD);
            }
        }

        ### tmp-directory already exists? ###
        if(!file_exists('../'. confGet('DIR_TEMP'))) {
            print_testStart("try to create directory of tempory files ".confGet('DIR_TEMP')."...");
            if(!mkdir('../'. confGet('DIR_TEMP'))) {
                print_testResult(RESULT_FAILED,"could not create directory. This could be a file permission problem...");
            }
            else {
                print_testResult(RESULT_GOOD);
            }
        }
        return true;
    }
}


/**
* upgrades
*/
function upgrade($args=NULL) 
{
	global $g_form_fields;

    $db_type=          $args['db_type'];
    $hostname=          $args['hostname'];
    $db_username=       $args['db_username'];
    $db_password=       $args['db_password'];
    $db_table_prefix=   $args['db_table_prefix'];
    $db_name=           $args['db_name'];
    $flag_continue_on_sql_errors= $args['continue_on_sql_errors'];
    $db_version=        $args['db_version'];            # set to NULL if autodetect

    require_once(dirname(__FILE__)."/../db/db_".$db_type."_class.php");

    echo "<h2>Upgrading...</h2>";

    ### connect db ###
    $sql_obj = new sql_class($hostname, $db_username, $db_password, $db_name);

    if($sql_obj -> error != false) {
        print_testResult(RESULT_FAILED,"mySQL-Error[" . __LINE__ . "]:<pre>".$sql_obj -> error."</pre>");
        return false;
    }

    ### select db? ###
    if(!$sql_obj->selectdb()) {
        print_testResult(RESULT_FAILED,"Database does not exists mySQL-Error[" . __LINE__ . "]:<pre>".$sql_obj -> error."</pre>");
        return false;
    }

    ### get version ###
    if(!$db_version)
    {
        print_testStart("getting original version for upgrading database '$db_name' at '$hostname'...");

        if(!$result=$sql_obj->execute("SELECT *
                                   FROM {$db_table_prefix}db
                                  WHERE updated is NULL")
        ) {
            print_testResult(RESULT_FAILED,"Count not get version:<pre>".$sql_obj -> error."</pre>");
            return false;
        }

        $count= 0;
        while ($row = $sql_obj->fetchArray()) {
            $db_version= $row['version'];
            $streber_version_required= $row['version_streber_required'];
            $count++;
        }
        if( $count!=1 ) {
            print_testResult(RESULT_FAILED,"could not get propper db-version table entry. Please view ".getStreberWikiLink('installation','Installation Guide')." on hints how to proceed.");
            return false;
        }
        if($db_version < 0.044) {
            print_testResult(RESULT_FAILED,"Sorry upgrading is supoorted since v0.044");
            return false;
        }
        print_testResult(RESULT_GOOD,"v $db_version");

    }
    else {
        print_testResult(RESULT_GOOD,"assuming v$db_version");
    }


    $update_queries=array();
    require(dirname(__FILE__)."/db_updates.inc.php");








    print_testStart("doing " .count($update_queries). " changes to database...");
    foreach($update_queries as $q) {

        ### strict mode for development ###
        #if($result= $sql_obj->execute('SET session sql_mode = "STRICT_ALL_TABLES,STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"')){
        #  }
        #}

        if(!$result=$sql_obj->execute($q)){
            if(function_exists('mysql_error') && mysql_error()) {
                $mysql_error= mysql_error();
            }
            else if(function_exists('mysqli_error') && mysqli_error()) {
                $mysql_error= mysql_error();
            }
            else {
                $mysql_error = $sql_obj->error;
            }
            print_testResult(RESULT_FAILED,"Failed:<pre>".$sql_obj -> error."</pre><br>Error:<pre>". $mysql_error . "</pre>");

            if(isset($flag_continue_on_sql_errors) && $flag_continue_on_sql_errors) {
                print_testStart("proceeding upgrade...");
            }
            else {
                return false;
            }
        }
    }

    ### update the db-version ###
    print_testStart("update db-version information");
    $str_query= "UPDATE {$db_table_prefix}db
                SET  updated = now();
                ";
    if(!$sql_obj->execute($str_query)) {
        print_testResult(RESULT_FAILED,"SQL-Error[" . __LINE__ . "]:<br><pre>".$sql_obj -> error."</pre><br><br>Querry was:<br>$str_query");
        return false;
    }
    
    ### create new db-version ###
    $db_version_new= confGet('DB_CREATE_VERSION');
    $streber_version_required= confGet('DB_CREATE_STREBER_VERSION_REQUIRED');
    $str_query= "INSERT IGNORE into {$db_table_prefix}db (id,version,version_streber_required,created) VALUES(1,'$db_version_new','$streber_version_required',NOW() )";
    if(!$sql_obj->execute($str_query)) {
        print_testResult(RESULT_FAILED,"SQL-Error[" . __LINE__ . "]:<pre>".$sql_obj -> error."</pre>Query was:<pre>$str_query</pre>");
        return false;
    }
    else {
        print_testResult(RESULT_GOOD);
    }
    
    ### rewrite setting-file ###
    {
    
    	$filename = "../" . confGet("DIR_SETTINGS") . confGet("SITE_SETTINGS");
    	print_testStart("writing configuration file '" . $filename . "'...");
    	$write_ok= writeSettingsFile($filename, $settings = array(
    		"APP_NAME"	          => $g_form_fields["site_name"]["value"],
    		"EMAIL_ADMINISTRATOR" => $g_form_fields["site_email"]["value"],
    		'APP_TITLE_HEADER'    => $g_form_fields["site_name"]["value"] . "<span class=extend>PM</span>",
    	));
    	
		if(!$write_ok) 
		{
            print_testResult(RESULT_FAILED, "can not write '" . $filename . "'.");
            /**
            * note: because settings-file is now written by a function, we no longer
            * have content to display when creation fails
            */
            # Please create it with this content:<br><pre>&lt;?php".$buffer."?&gt;</pre>");
            return false;
        }
        else {
            print_testResult(RESULT_GOOD);
        }
    	
        $filename='../'. confGet('DIR_SETTINGS').  confGet('FILE_DB_SETTINGS');
        print_testStart("writing configuration file '$filename'...");
        $write_ok= writeSettingsFile($filename, array(
            'DB_TYPE'       => $db_type,
            'HOSTNAME'      => $hostname,
            'DB_USERNAME'   => $db_username,
            'DB_PASSWORD'   => $db_password,
            'DB_TABLE_PREFIX'=> $db_table_prefix,
            'DB_NAME'       => $db_name,
            'DB_VERSION'    => confGet('DB_CREATE_VERSION'),
        ));

        if(!$write_ok) {
            print_testResult(RESULT_FAILED,"can not write '$filename'.");
            /**
            * note: because settings-file is now written by a function, we no longer
            * have content to display when creation fails
            */
            # Please create it with this content:<br><pre>&lt;?php".$buffer."?&gt;</pre>");
            return false;
        }
        else {
            print_testResult(RESULT_GOOD);
        }
    }
    return true;
}


/**
* build settings file
* - the setting file is also been written on upgrades (because the
*   location of the settings can change.
*/
function buildSettingsFile($args) {

    $buffer='
#--- streber db-configuration file ---
# this file has automatically been created and might be
# overwritten be installation procedures. If you want
# to overwrite any of these settings add lines to
# "customize.inc.php" in streber-root directory
';
    foreach($args as $key=>$value) {
        $buffer.='confChange("' . $key . '","' . $value .'");
';
    }
    return $buffer;
}




/**
* write setting file
* - the setting file is also been written on upgrades (because the
*   location of the settings can change.
*/
function writeSettingsFile($filename, $args) {

    $buffer= buildSettingsFile($args);

    $FH= @fopen ($filename,"w");
    if(!$FH) {
        return false;
    }
    else if(!fputs ($FH, "<"."?php".$buffer."?".">")) {
        return false;
    }
    fclose ($FH);

    return true;

}


/**
* parse a mysql-dump with multiple queries and sent it to mysql
*
* - adds table-prefix to all select and create-statements
* - This function is a hack to quicky set up the db-structure. Sooner
*   or later it will be replaces with a reall table-creation-function.
*
*
*/
function parse_mysql_dump($url,$table_prefix="")
{
    global $sql_obj;
    $file_content = file($url);
    $query = "";

    foreach($file_content as $sql_line){
        if(trim($sql_line) != "" && strpos($sql_line, "--") === false){
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

                ### send query ###
                if(!$result = $sql_obj->execute($query)) {
                    return false;
                }
                $query = "";
            }
         }
    }
    return true;
}

