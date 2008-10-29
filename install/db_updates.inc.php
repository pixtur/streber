<?php
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

### update from 0.044 to 0.045
if($db_version < 0.045) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task`   ADD `view_collapsed` TINYINT NOT NULL";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}comment` ADD `view_collapsed` TINYINT NOT NULL";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}effort` ADD `task` INT NOT NULL";
}

### update from 0.045 auf 0.0451
if($db_version < 0.0451) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}project` CHANGE `company` `company` INT( 4 ) DEFAULT '0' NOT NULL ";
}

### update from 0.0451 auf 0.046
if($db_version < 0.046) {
    $update_queries[]="
    CREATE TABLE `{$db_table_prefix}taskperson` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `person` INT NOT NULL ,
    `task` INT NOT NULL ,
    `comment` TEXT NOT NULL ,
    PRIMARY KEY ( `id` ) ,
    INDEX ( `person` , `task` )
    );
    ";
    $update_queries[]="DROP TABLE `{$db_table_prefix}task_effort`;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `show_tasks_at_home` TINYINT DEFAULT '1' NOT NULL ;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `language` VARCHAR( 5 ) NOT NULL;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` CHANGE `date_due` `planned_start` DATETIME DEFAULT '0000-00-00' NOT NULL;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` CHANGE `date_due_end` `planned_end` DATETIME DEFAULT '0000-00-00' NOT NULL;";
}

### update from 0.046 to 0.047
if($db_version < 0.047){
    $update_queries[]="ALTER TABLE `{$db_table_prefix}company` DROP INDEX `name`";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}company` ADD FULLTEXT (`name`)";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}company` ADD FULLTEXT (`comments`)";

    $update_queries[]="ALTER TABLE `{$db_table_prefix}project` ADD FULLTEXT (name,status_summary,description)";

    $update_queries[]="ALTER TABLE `{$db_table_prefix}person`  ADD FULLTEXT (name,nickname,tagline,comments)";

    $update_queries[]="ALTER TABLE `{$db_table_prefix}task`  ADD FULLTEXT (name,short,description)";

    $update_queries[]="ALTER TABLE `{$db_table_prefix}comment` ADD PRIMARY KEY (id)";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}comment` ADD FULLTEXT (name,description)";

    $update_queries[]="ALTER TABLE `{$db_table_prefix}issue` DROP INDEX `steps_to_reproduce` ";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}issue` ADD FULLTEXT (plattform,os,version,production_build,steps_to_reproduce,expected_result,suggested_solution)";

    $update_queries[]="ALTER TABLE `{$db_table_prefix}issue` ADD `task` INT NOT NULL AFTER `id`" ;
    $update_queries[]="ALTER TABLE `{$db_table_prefix}issue` ADD INDEX ( `task` )" ;

    $update_queries[]="ALTER TABLE `{$db_table_prefix}projectperson` ADD `adjust_effort_style` TINYINT DEFAULT '1' NOT NULL" ;
    $update_queries[]="ALTER TABLE `{$db_table_prefix}effort` ADD `as_duration` TINYINT DEFAULT '0' NOT NULL ";
}

### update to v0.048
if($db_version <0.048) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}comment` CHANGE `description` `description` LONGTEXT";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}company` CHANGE `comments` `comments` LONGTEXT";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}issue` CHANGE `steps_to_reproduce` `steps_to_reproduce` TEXT, CHANGE `expected_result` `expected_result` TEXT, CHANGE `suggested_solution` `suggested_solution` TEXT";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` CHANGE `comments` `comments` LONGTEXT";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` CHANGE `description` `description` LONGTEXT";
}


### update to v0.049
if($db_version <0.049) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `settings` INT NOT NULL ;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `notification_last` DATETIME NOT NULL;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `notification_period` TINYINT DEFAULT '7' NOT NULL;";
}

### update to v0.05
if($db_version < 0.05) {
    $update_queries[]="CREATE TABLE `{$db_table_prefix}file` (
      `id` int(4) NOT NULL default '0',
      `name` varchar(128) NOT NULL default '',
      `mimetype` varchar(128) NOT NULL default '',
      `status` tinyint(4) NOT NULL default '0',
      `org_filename` varchar(255) NOT NULL default '',
      `tmp_filename` varchar(255) NOT NULL default '',
      `tmp_dir` varchar(64) NOT NULL default '',
      `filesize` int(11) NOT NULL default '0',
      `version` int(11) NOT NULL default '0',
      `parent_item` int(11) NOT NULL default '0',
      `org_file` int(11) NOT NULL default '0',
      `is_image` tinyint(4) NOT NULL default '0',
      `is_latest` tinyint(4) NOT NULL default '0',
      `thumbnail` varchar(255) NOT NULL default '',
      `description` tinytext NOT NULL,
      PRIMARY KEY  (`id`),
      KEY `parent_item` (`parent_item`),
      KEY `is_latest` (`is_latest`)
    ) TYPE=MyISAM;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}file`  ADD FULLTEXT (name,description,org_filename);";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `last_login` DATETIME NOT NULL AFTER `can_login`;" ;
}

if($db_version < 0.051) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `last_logout` DATETIME NOT NULL AFTER `last_login`;";
}

if($db_version < 0.056) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` CHANGE `identifier` `identifier` VARCHAR( 64 );";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `ip_address` varchar( 15 ) NOT NULL AFTER `cookie_string` ;";
}


if($db_version < 0.057) {
    $update_queries[]="
    CREATE TABLE `{$db_table_prefix}itemchange` (
        `id` INT NOT NULL AUTO_INCREMENT ,
        `item` INT DEFAULT '0' NOT NULL ,
        `modified_by` INT DEFAULT '0' NOT NULL ,
        `modified` DATETIME NOT NULL ,
        `field` VARCHAR( 32 ) NOT NULL ,
        `value_old` LONGTEXT NOT NULL ,
        PRIMARY KEY ( `id` ) ,
        INDEX ( `item` , `modified_by`,`modified` )
    );";
 }


if($db_version < 0.058) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD `is_milestone` TINYINT NOT NULL AFTER `is_folder` ;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD INDEX ( `is_milestone` ) ;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD `for_milestone` INT NOT NULL AFTER `date_start` ;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD INDEX ( `for_milestone` ) ;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD `resolved_version` INT NOT NULL AFTER `for_milestone` ;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD INDEX ( `resolved_version` ) ;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` CHANGE `estimated` `estimated` INT DEFAULT '0'";
}

if($db_version < 0.059) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD `estimated_max` INT NOT NULL DEFAULT 0 AFTER `estimated` ";
}

if($db_version < 0.063) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}taskperson` ADD `assigntype` TINYINT DEFAULT '0' NOT NULL ;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` CHANGE `comments` `description` LONGTEXT;";
}


if($db_version < 0.066) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `time_offset` INT DEFAULT '0' NOT NULL AFTER `notification_period`;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `time_zone`  TINYINT DEFAULT '25' NOT NULL AFTER `notification_period`;";
}

if($db_version < 0.0671) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD `resolve_reason` TINYINT DEFAULT '0' NOT NULL AFTER `resolved_version`;";
}


if($db_version < 0.068) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD `is_released` TINYINT DEFAULT '0' NOT NULL AFTER `is_milestone` ;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD INDEX ( `is_released` ) ;";

    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD `time_released` DATETIME NOT NULL AFTER `is_released` ;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD INDEX ( `time_released` ) ;";
}

if($db_version < 0.0681) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `category` TINYINT DEFAULT '0' NOT NULL AFTER `time_offset`;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}company` ADD `category` TINYINT DEFAULT '0' NOT NULL AFTER `state`;";
}

if($db_version < 0.0682) {
	$update_queries[]="ALTER TABLE `{$db_table_prefix}projectperson` CHANGE `role` `role` VARCHAR( 25 ) ;";
}

if($db_version < 0.0685) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}item` CHANGE `project` `project` INT( 11 ) DEFAULT '0' NOT NULL;";
}


if($db_version < 0.069) {
    /**
    * NOTE: this update might have side effects.
    */
    $update_queries[]="UPDATE `{$db_table_prefix}item` SET `type` = '3'  WHERE `type` = '0' ;";
}

if($db_version < 0.0701) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` CHANGE `is_milestone` `is_milestone` TINYINT( 4 ) DEFAULT '0' NOT NULL;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` CHANGE `resolved_version` `resolved_version` INT( 11 ) DEFAULT '0';";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` CHANGE `estimated_max` `estimated_max` INT( 11 ) DEFAULT '0';";

    /**
    * required to store timezones like  "+5.75 : Nepal Standard Time"
    */
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` CHANGE `time_zone` `time_zone` FLOAT( 4 ) DEFAULT '25';";
}

if($db_version < 0.0702) {
	$update_queries[]="UPDATE `{$db_table_prefix}projectperson` SET `role` = -1;";
	$update_queries[]="ALTER TABLE `{$db_table_prefix}projectperson` CHANGE `role` `role` TINYINT( 4 ) ;";
}

if($db_version < 0.0705) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD `category` TINYINT DEFAULT '". TCATEGORY_TASK."' NOT NULL AFTER `is_folder`;";
    $update_queries[]="ALTER TABLE `{$db_table_prefix}project` ADD `settings` TINYINT DEFAULT '127' NOT NULL AFTER `default_pub_level` ;";
}

if($db_version < 0.0706) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD `order_id` INT DEFAULT '0' NOT NULL AFTER `id` ;";
}


if($db_version < 0.0707) {
    $update_queries[]="UPDATE `{$db_table_prefix}task` SET `category` = '" .TCATEGORY_FOLDER. "'  WHERE `is_folder` = '1' ;";
    $update_queries[]="UPDATE `{$db_table_prefix}task` SET `category` = '" .TCATEGORY_BUG. "'  WHERE `issue_report` != '0' ;";
    $update_queries[]="UPDATE `{$db_table_prefix}task` SET `category` = '" .TCATEGORY_MILESTONE. "'  WHERE `is_milestone` = '1' ;";
    $update_queries[]="UPDATE `{$db_table_prefix}task` SET `category` = '" .TCATEGORY_VERSION. "'  WHERE `is_milestone` = '1' AND 'is_released' >= " . RELEASED_INTERNAL . ";";
}

if($db_version < 0.0708){
	$update_queries[]="
    CREATE TABLE `{$db_table_prefix}itemperson` (
        `id` INT(11) NOT NULL AUTO_INCREMENT ,
		`person` INT(11) DEFAULT '0' NOT NULL ,
        `item` INT(11) DEFAULT '0' NOT NULL ,
        `viewed` TINYINT(4) DEFAULT '0' NOT NULL ,
        `viewed_last` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL ,
        `remember_unchanged` INT(11) NULL ,
        `is_bookmark` TINYINT(4) DEFAULT '0' NOT NULL ,
		`notify_on_change` TINYINT(4) DEFAULT '0' NOT NULL ,
        PRIMARY KEY ( `id` )
    );";
}


if($db_version < 0.0709){
	$update_queries[]="
        ALTER TABLE `{$db_table_prefix}person`
        ADD `date_highlight_changes` DATETIME NOT NULL AFTER `show_tasks_at_home` ;";
}

if($db_version < 0.0710){
	$update_queries[]="
        ALTER TABLE `{$db_table_prefix}itemperson`        
        CHANGE `remember_unchanged` `notify_if_unchanged` INT( 11 ) DEFAULT NULL ;";

	$update_queries[]="
        ALTER TABLE `{$db_table_prefix}itemperson`
        ADD `view_count` INT(11) DEFAULT '1' NOT NULL AFTER `viewed_last`  ;";

}

if($db_version < 0.0711){

	$update_queries[]=
	    "ALTER TABLE `{$db_table_prefix}itemperson` ADD `comment` LONGTEXT NULL;";
	$update_queries[]=
	    "ALTER TABLE `{$db_table_prefix}itemperson` ADD `notify_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `notify_on_change`;";
	$update_queries[]=
	    "ALTER TABLE `{$db_table_prefix}itemperson` CHANGE `notify_if_unchanged` `notify_if_unchanged` INT( 11 ) DEFAULT '0' NOT NULL;";
}

if($db_version < 0.0781) {
    $update_queries[]=
        "ALTER TABLE `{$db_table_prefix}itemperson` ADD INDEX ( `item` , `person` ); ";

    $update_queries[]=
        "ALTER TABLE `{$db_table_prefix}projectperson` ADD INDEX ( `person` , `project` );  ";


}

if($db_version < 0.0782) {
	$update_queries[]=
	    "ALTER TABLE `{$db_table_prefix}itemperson` ADD `created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `comment`;";
}

if($db_version < 0.0783) {
    $update_queries[]=
        "ALTER TABLE `{$db_table_prefix}comment` ADD INDEX ( `comment` ) ;";
    $update_queries[]=
        "ALTER TABLE `{$db_table_prefix}comment` ADD INDEX ( `task` ) ;";
    $update_queries[]=
        "ALTER TABLE `{$db_table_prefix}effort` ADD INDEX ( `task` );";
}

if($db_version < 0.0793) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}person` CHANGE `ip_address` `ip_address` VARCHAR( 15 )  DEFAULT '' NOT NULL ;";
}

if($db_version < 0.0794) {
    $update_queries[]=" ALTER TABLE `{$db_table_prefix}person` 
                        CHANGE `ip_address` `ip_address` VARCHAR( 15 )  DEFAULT '' NOT NULL ;";

    $update_queries[]=" ALTER TABLE `{$db_table_prefix}itemperson` 
                        CHANGE `notify_if_unchanged` `notify_if_unchanged` INT( 11 )  DEFAULT 0 NOT NULL ;";

    $update_queries[]=" ALTER TABLE `{$db_table_prefix}person` 
                        CHANGE `date_highlight_changes` `date_highlight_changes` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL";


}

if($db_version < 0.0795) {
    $update_queries[]="ALTER TABLE `{$db_table_prefix}effort` ADD `status` TINYINT( 4 )  DEFAULT '1' NOT NULL ;";
}

if($db_version < 0.07972) {
	 $update_queries[]="ALTER TABLE `{$db_table_prefix}person` ADD `salary_per_hour` FLOAT  DEFAULT '0' NOT NULL ;";
	 $update_queries[]="ALTER TABLE `{$db_table_prefix}projectperson` ADD `salary_per_hour` FLOAT  DEFAULT '0' NOT NULL ;";
	 $update_queries[]="ALTER TABLE `{$db_table_prefix}task` ADD `calculation` FLOAT  DEFAULT '0' NOT NULL ;";
}

if($db_version < 0.07973){
	$update_queries[]="ALTER TABLE `{$db_table_prefix}projectperson` CHANGE `role` `role` TINYINT( 4 ) NOT NULL DEFAULT '0'";
}

if($db_version < 0.07991){
	$update_queries[]="UPDATE `{$db_table_prefix}project` SET settings = settings | " . (PROJECT_SETTING_ENABLE_BUGS) . ";";
	$update_queries[]="UPDATE `{$db_table_prefix}person` SET settings = settings | " . (USER_SETTING_ENABLE_BOOKMARKS| USER_SETTING_ENABLE_EFFORTS) . ";";
}

if($db_version < 0.07992){
	$update_queries[] = "ALTER TABLE `{$db_table_prefix}taskperson` ADD forward TINYINT( 1 ) DEFAULT 0 NOT NULL";
	$update_queries[] = "ALTER TABLE `{$db_table_prefix}taskperson` ADD forward_comment TEXT NULL";
	$update_queries[] = "ALTER TABLE `{$db_table_prefix}person` ADD ldap TINYINT( 1 ) DEFAULT 0 NOT NULL";
	$update_queries[] = "ALTER TABLE `{$db_table_prefix}project` CHANGE `labels` `labels` varchar( 255 )  DEFAULT 'Bug,Feature,Enhancement,Refacture,Idea,Research,Organize,Wiki,Docu,News' NOT NULL";
}

if($db_version < 0.0802) {
	$update_queries[] = "ALTER TABLE `{$db_table_prefix}project` CHANGE `settings` `settings` INT( 4 ) DEFAULT '65535'";
	$update_queries[]="UPDATE `{$db_table_prefix}project` SET settings = settings | " . (PROJECT_SETTING_ENABLE_TASKS) . ";";
	$update_queries[]="UPDATE `{$db_table_prefix}project` SET settings = settings | " . (PROJECT_SETTING_ENABLE_FILES) . ";";
}

if($db_version < 0.0803) {
	$update_queries[] = "ALTER TABLE `{$db_table_prefix}task` ADD `is_news` TINYINT ( 1 ) DEFAULT '0' NOT NULL ";
	$update_queries[]="UPDATE `{$db_table_prefix}project` SET settings = settings | " . (PROJECT_SETTING_ENABLE_NEWS) . ";";
}

if($db_version < 0.0807) {
 	$update_queries[] = "ALTER TABLE `{$db_table_prefix}itemperson` ADD `feedback_requested_by` INT ( 4 ) DEFAULT '0' NOT NULL ";
    $update_queries[] = "ALTER TABLE `{$db_table_prefix}itemperson` ADD INDEX ( `feedback_requested_by` );";
}


?>
