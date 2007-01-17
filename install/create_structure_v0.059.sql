-- phpMyAdmin SQL Dump
-- version 2.6.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Apr 22, 2006 at 03:04 PM
-- Server version: 5.0.18
-- PHP Version: 5.1.1
-- 
-- Database: `streber_alpha`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `comment`
-- 

CREATE TABLE `comment` (
  `id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `occasion` tinyint(4) NOT NULL default '1',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `person` int(11) NOT NULL default '0',
  `comment` int(11) NOT NULL default '0',
  `effort` int(11) NOT NULL default '0',
  `file` int(11) NOT NULL default '0',
  `starts_discussion` tinyint(4) NOT NULL default '0',
  `description` longtext,
  `task` int(11) NOT NULL default '0',
  `view_collapsed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `name` (`name`,`description`),
  FULLTEXT KEY `name_2` (`name`,`description`)
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `company`
-- 

CREATE TABLE `company` (
  `id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `tagline` varchar(255) NOT NULL default '',
  `short` varchar(64) NOT NULL default '',
  `phone` varchar(64) NOT NULL default '',
  `fax` varchar(64) NOT NULL default '',
  `street` varchar(255) NOT NULL default '',
  `zipcode` varchar(255) NOT NULL default '',
  `homepage` varchar(255) NOT NULL default '',
  `intranet` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `comments` longtext,
  `state` tinyint(4) NOT NULL default '1',
  `pub_level` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`),
  KEY `stated` (`state`),
  KEY `pub_level` (`pub_level`),
  FULLTEXT KEY `comments` (`comments`),
  FULLTEXT KEY `comments_2` (`comments`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `comments_3` (`comments`)
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `db`
-- 

CREATE TABLE `db` (
  `id` int(11) NOT NULL default '0',
  `version` varchar(12) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime default NULL,
  `version_streber_required` varchar(12) NOT NULL default ''
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `effort`
-- 

CREATE TABLE `effort` (
  `id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `time_start` datetime default NULL,
  `time_end` datetime default NULL,
  `person` int(10) unsigned NOT NULL default '0',
  `project` int(11) NOT NULL default '0',
  `description` text NOT NULL,
  `task` int(11) NOT NULL default '0',
  `as_duration` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `project` (`project`)
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `employment`
-- 

CREATE TABLE `employment` (
  `id` int(11) NOT NULL default '0',
  `person` int(11) NOT NULL default '0',
  `company` int(11) NOT NULL default '0',
  `comment` varchar(255) NOT NULL default '',
  `pub_level` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `person` (`person`),
  KEY `client` (`company`),
  KEY `pub_level` (`pub_level`)
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `file`
-- 

CREATE TABLE `file` (
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
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `issue`
-- 

CREATE TABLE `issue` (
  `id` int(11) NOT NULL default '0',
  `task` int(11) NOT NULL default '0',
  `reproducibility` tinyint(4) NOT NULL default '0',
  `severity` tinyint(4) NOT NULL default '0',
  `plattform` varchar(255) NOT NULL default '',
  `os` varchar(255) NOT NULL default '',
  `version` varchar(32) NOT NULL default '',
  `production_build` varchar(32) NOT NULL default '',
  `steps_to_reproduce` text,
  `expected_result` text,
  `suggested_solution` text,
  PRIMARY KEY  (`id`),
  KEY `task` (`task`),
  KEY `task_2` (`task`),
  KEY `task_3` (`task`),
  FULLTEXT KEY `plattform` (`plattform`,`os`,`version`,`production_build`,`steps_to_reproduce`,`expected_result`,`suggested_solution`)
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `item`
-- 

CREATE TABLE `item` (
  `id` int(11) NOT NULL auto_increment,
  `pub_level` tinyint(4) NOT NULL default '4',
  `type` tinyint(4) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `deleted` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_by` int(11) NOT NULL default '0',
  `deleted_by` int(11) NOT NULL default '0',
  `project` int(11) default NULL,
  `state` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`),
  KEY `project` (`project`),
  KEY `state` (`state`)
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `itemchange`
-- 

CREATE TABLE `itemchange` (
  `id` int(11) NOT NULL auto_increment,
  `item` int(11) NOT NULL default '0',
  `modified_by` int(11) NOT NULL default '0',
  `modified` datetime NOT NULL,
  `field` varchar(32) NOT NULL,
  `value_old` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `item` (`item`,`modified_by`),
  KEY `modified` (`modified`)
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `person`
-- 

CREATE TABLE `person` (
  `id` int(11) NOT NULL default '0',
  `state` tinyint(4) NOT NULL default '1',
  `name` varchar(255) NOT NULL default '',
  `nickname` varchar(64) NOT NULL default '',
  `tagline` varchar(255) NOT NULL default '',
  `mobile_phone` varchar(128) NOT NULL default '',
  `personal_phone` varchar(128) NOT NULL default '',
  `personal_fax` varchar(128) NOT NULL default '',
  `personal_email` varchar(255) NOT NULL default '',
  `personal_street` varchar(255) NOT NULL default '',
  `personal_zipcode` varchar(255) NOT NULL default '',
  `personal_homepage` varchar(255) NOT NULL default '',
  `office_phone` varchar(20) NOT NULL default '',
  `office_fax` varchar(20) NOT NULL default '',
  `office_email` varchar(60) NOT NULL default '',
  `office_street` varchar(128) NOT NULL default '',
  `office_zipcode` varchar(60) NOT NULL default '',
  `office_homepage` varchar(128) NOT NULL default '',
  `comments` longtext,
  `password` varchar(255) NOT NULL default '',
  `security_question` varchar(128) NOT NULL default '',
  `security_answer` varchar(20) NOT NULL default '',
  `user_rights` int(11) NOT NULL default '0',
  `cookie_string` varchar(64) NOT NULL default '',
  `ip_address` varchar(15) NOT NULL,
  `can_login` tinyint(4) NOT NULL default '0',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_logout` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_level_view` tinyint(4) NOT NULL default '0',
  `user_level_create` tinyint(4) NOT NULL default '0',
  `user_level_edit` tinyint(4) NOT NULL default '0',
  `user_level_reduce` tinyint(4) NOT NULL default '0',
  `pub_level` tinyint(4) NOT NULL default '0',
  `color` varchar(6) NOT NULL default '000000',
  `profile` tinyint(4) NOT NULL default '0',
  `theme` tinyint(4) NOT NULL default '0',
  `identifier` varchar(64) default NULL,
  `birthdate` date NOT NULL default '0000-00-00',
  `show_tasks_at_home` tinyint(4) NOT NULL default '1',
  `language` varchar(5) NOT NULL default '',
  `settings` int(11) NOT NULL default '0',
  `notification_last` datetime NOT NULL default '0000-00-00 00:00:00',
  `notification_period` tinyint(4) NOT NULL default '7',
  PRIMARY KEY  (`id`),
  KEY `state` (`state`),
  KEY `id` (`id`),
  KEY `nickname` (`nickname`),
  KEY `cookie_string` (`cookie_string`),
  KEY `can_login` (`can_login`),
  KEY `pub_level` (`pub_level`),
  FULLTEXT KEY `name` (`name`,`nickname`,`tagline`,`comments`),
  FULLTEXT KEY `name_2` (`name`,`nickname`,`tagline`,`comments`),
  FULLTEXT KEY `name_3` (`name`,`nickname`,`tagline`,`comments`)
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `project`
-- 

CREATE TABLE `project` (
  `id` int(11) NOT NULL default '0',
  `state` int(11) NOT NULL default '1',
  `name` varchar(255) NOT NULL default '',
  `short` varchar(64) NOT NULL default '',
  `wikipage` varchar(128) NOT NULL default '',
  `projectpage` varchar(128) NOT NULL default '',
  `date_start` date NOT NULL default '0000-00-00',
  `date_closed` date NOT NULL default '0000-00-00',
  `company` int(4) NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '0',
  `prio` tinyint(4) NOT NULL default '0',
  `description` longtext NOT NULL,
  `labels` varchar(255) NOT NULL default '0',
  `show_in_home` tinyint(4) NOT NULL default '1',
  `pub_level` tinyint(4) NOT NULL default '0',
  `default_pub_level` tinyint(4) NOT NULL default '4',
  `color` varchar(6) NOT NULL default '000000',
  `status_summary` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pub_level` (`pub_level`),
  FULLTEXT KEY `name` (`name`,`status_summary`,`description`),
  FULLTEXT KEY `name_2` (`name`,`status_summary`,`description`),
  FULLTEXT KEY `name_3` (`name`,`status_summary`,`description`)
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `projectperson`
-- 

CREATE TABLE `projectperson` (
  `id` int(11) NOT NULL default '0',
  `state` tinyint(4) NOT NULL default '1',
  `project` int(11) NOT NULL default '0',
  `name` varchar(64) NOT NULL default '',
  `person` int(11) NOT NULL default '0',
  `proj_rights` int(11) NOT NULL default '0',
  `level_view` tinyint(4) NOT NULL default '0',
  `level_edit` tinyint(4) NOT NULL default '0',
  `level_create` tinyint(4) NOT NULL default '0',
  `level_reduce` tinyint(4) NOT NULL default '0',
  `level_delete` tinyint(4) NOT NULL default '4',
  `role` varchar(12) NOT NULL default '',
  `adjust_effort_style` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `project` (`project`),
  KEY `state` (`state`),
  KEY `person` (`person`),
  KEY `proj_rights` (`proj_rights`)
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `task`
-- 

CREATE TABLE `task` (
  `id` int(11) NOT NULL default '0',
  `estimated` int(11) default '0',
  `estimated_max` int(11) NOT NULL,
  `completion` tinyint(4) NOT NULL default '0',
  `parent_task` int(11) NOT NULL default '0',
  `is_folder` tinyint(4) NOT NULL default '0',
  `is_milestone` tinyint(4) NOT NULL,
  `label` tinyint(4) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `short` varchar(64) NOT NULL default '',
  `date_start` date NOT NULL default '0000-00-00',
  `for_milestone` int(11) default '0',
  `resolved_version` int(11) NOT NULL,
  `planned_start` datetime NOT NULL default '0000-00-00 00:00:00',
  `planned_end` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_closed` date NOT NULL default '0000-00-00',
  `status` tinyint(4) NOT NULL default '0',
  `prio` tinyint(4) NOT NULL default '0',
  `description` longtext,
  `issue_report` int(11) NOT NULL default '0',
  `view_collapsed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `parent_task` (`parent_task`),
  KEY `is_folder` (`is_folder`),
  KEY `status` (`status`),
  KEY `is_milestone` (`is_milestone`),
  KEY `milestone` (`for_milestone`),
  KEY `resolved_version` (`resolved_version`),
  KEY `is_milestone_2` (`is_milestone`),
  KEY `for_milestone` (`for_milestone`),
  KEY `resolved_version_2` (`resolved_version`),
  FULLTEXT KEY `name` (`name`,`short`,`description`),
  FULLTEXT KEY `name_2` (`name`,`short`,`description`),
  FULLTEXT KEY `name_3` (`name`,`short`,`description`)
) TYPE=MyISAM; 

-- --------------------------------------------------------

-- 
-- Table structure for table `taskperson`
-- 

CREATE TABLE `taskperson` (
  `id` int(11) NOT NULL auto_increment,
  `person` int(11) NOT NULL default '0',
  `task` int(11) NOT NULL default '0',
  `comment` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `person` (`person`,`task`)
) TYPE=MyISAM; 
        