# slim phpMyAdmin MySQL-Dump

#
#comment
#

DROP TABLE IF EXISTS comment;
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
  KEY `comment` (`comment`),
  KEY `task` (`task`),
  FULLTEXT KEY `name` (`name`,`description`),
  FULLTEXT KEY `name_2` (`name`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
#company
#

DROP TABLE IF EXISTS company;
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
  `category` tinyint(4) NOT NULL default '0',
  `pub_level` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`),
  KEY `stated` (`state`),
  KEY `pub_level` (`pub_level`),
  FULLTEXT KEY `comments` (`comments`),
  FULLTEXT KEY `comments_2` (`comments`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `comments_3` (`comments`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO company (id, name, tagline, short, phone, fax, street, zipcode, homepage, intranet, email, comments, state, category, pub_level) VALUES (8, 'kgb', '', '', '', '', '', '', '', '', '', '', 1, 10, 0);
INSERT INTO company (id, name, tagline, short, phone, fax, street, zipcode, homepage, intranet, email, comments, state, category, pub_level) VALUES (9, 'cia', '', '', '', '', '', '', '', '', '', '', 1, 10, 0);

#
#db
#

DROP TABLE IF EXISTS db;
CREATE TABLE `db` (
  `id` int(11) NOT NULL default '0',
  `version` varchar(12) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime default NULL,
  `version_streber_required` varchar(12) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO db (id, version, created, updated, version_streber_required) VALUES (1, '0.08094', '2008-12-06 13:58:01', NULL, '0.08094');
INSERT INTO db (id, version, created, updated, version_streber_required) VALUES (1, '0.08094', '2008-12-06 13:58:01', NULL, '0.08094');

#
#effort
#

DROP TABLE IF EXISTS effort;
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
  `status` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `project` (`project`),
  KEY `task` (`task`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
#employment
#

DROP TABLE IF EXISTS employment;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO employment (id, person, company, comment, pub_level) VALUES (10, 6, 9, '', 0);
INSERT INTO employment (id, person, company, comment, pub_level) VALUES (11, 5, 8, '', 0);

#
#file
#

DROP TABLE IF EXISTS file;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
#issue
#

DROP TABLE IF EXISTS issue;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
#item
#

DROP TABLE IF EXISTS item;
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
  `project` int(11) NOT NULL default '0',
  `state` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`),
  KEY `project` (`project`),
  KEY `state` (`state`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (1, 4, 3, '0000-00-00 00:00:00', '2008-12-06 13:22:45', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (2, 4, 3, '2008-12-06 13:09:55', '2008-12-06 13:09:55', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (3, 4, 3, '2008-12-06 13:11:15', '2008-12-06 13:11:15', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (4, 4, 3, '2008-12-06 13:11:48', '2008-12-06 13:11:48', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (5, 4, 3, '2008-12-06 13:12:49', '2008-12-06 13:12:49', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (6, 4, 3, '2008-12-06 13:14:57', '2008-12-06 13:14:57', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (7, 4, 3, '2008-12-06 13:16:13', '2008-12-06 13:16:13', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (8, 4, 5, '2008-12-06 13:17:02', '2008-12-06 13:17:02', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (9, 4, 5, '2008-12-06 13:17:15', '2008-12-06 13:17:15', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (10, 4, 6, '2008-12-06 13:17:28', '2008-12-06 13:17:28', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (11, 4, 6, '2008-12-06 13:17:47', '2008-12-06 13:17:47', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (12, 4, 1, '2008-12-06 13:20:09', '2008-12-06 13:20:09', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (13, 5, 4, '2008-12-06 13:20:09', '2008-12-06 13:20:09', '0000-00-00 00:00:00', 1, 1, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (14, 4, 4, '2008-12-06 13:20:34', '2008-12-06 13:20:34', '0000-00-00 00:00:00', 1, 1, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (15, 4, 4, '2008-12-06 13:20:34', '2008-12-06 13:20:34', '0000-00-00 00:00:00', 1, 1, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (16, 4, 4, '2008-12-06 13:20:34', '2008-12-06 13:20:34', '0000-00-00 00:00:00', 1, 1, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (17, 4, 1, '2008-12-06 13:21:02', '2008-12-06 13:21:02', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (18, 5, 4, '2008-12-06 13:21:02', '2008-12-06 13:21:02', '0000-00-00 00:00:00', 1, 1, 0, 17, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (19, 4, 4, '2008-12-06 13:21:27', '2008-12-06 13:21:27', '0000-00-00 00:00:00', 1, 1, 0, 17, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (20, 4, 4, '2008-12-06 13:21:27', '2008-12-06 13:21:27', '0000-00-00 00:00:00', 1, 1, 0, 17, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (21, 4, 4, '2008-12-06 13:21:27', '2008-12-06 13:21:27', '0000-00-00 00:00:00', 1, 1, 0, 17, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (22, 4, 2, '2008-12-06 13:22:11', '2008-12-06 13:22:11', '0000-00-00 00:00:00', 1, 1, 0, 17, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (23, 2, 2, '2008-12-06 13:22:41', '2008-12-06 13:22:41', '0000-00-00 00:00:00', 1, 1, 0, 17, 1);

#
#itemchange
#

DROP TABLE IF EXISTS itemchange;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
#itemperson
#

DROP TABLE IF EXISTS itemperson;
CREATE TABLE `itemperson` (
  `id` int(11) NOT NULL auto_increment,
  `person` int(11) NOT NULL default '0',
  `item` int(11) NOT NULL default '0',
  `viewed` tinyint(4) NOT NULL default '0',
  `viewed_last` datetime NOT NULL default '0000-00-00 00:00:00',
  `view_count` int(11) NOT NULL default '1',
  `notify_if_unchanged` int(11) NOT NULL default '0',
  `is_bookmark` tinyint(4) NOT NULL default '0',
  `notify_on_change` tinyint(4) NOT NULL default '0',
  `notify_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment` longtext,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `feedback_requested_by` int(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `item` (`item`,`person`),
  KEY `feedback_requested_by` (`feedback_requested_by`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (1, 1, 9, 1, '2008-12-06 13:17:28', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (2, 1, 8, 1, '2008-12-06 13:17:47', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (3, 1, 12, 1, '2008-12-06 13:20:34', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (4, 1, 17, 1, '2008-12-06 13:21:27', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (5, 2, 17, 1, '2008-12-06 13:22:50', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (6, 2, 3, 1, '2008-12-06 13:23:11', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);

#
#person
#

DROP TABLE IF EXISTS person;
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
  `description` longtext,
  `password` varchar(255) NOT NULL default '',
  `security_question` varchar(128) NOT NULL default '',
  `security_answer` varchar(20) NOT NULL default '',
  `user_rights` int(11) NOT NULL default '0',
  `cookie_string` varchar(64) NOT NULL default '',
  `ip_address` varchar(15) NOT NULL default '',
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
  `date_highlight_changes` datetime NOT NULL default '0000-00-00 00:00:00',
  `language` varchar(5) NOT NULL default '',
  `settings` int(11) NOT NULL default '0',
  `notification_last` datetime NOT NULL default '0000-00-00 00:00:00',
  `notification_period` tinyint(4) NOT NULL default '7',
  `time_offset` int(11) NOT NULL default '0',
  `category` tinyint(4) NOT NULL default '0',
  `time_zone` float default '25',
  `salary_per_hour` float NOT NULL default '0',
  `ldap` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `state` (`state`),
  KEY `id` (`id`),
  KEY `nickname` (`nickname`),
  KEY `cookie_string` (`cookie_string`),
  KEY `can_login` (`can_login`),
  KEY `pub_level` (`pub_level`),
  FULLTEXT KEY `name` (`name`,`nickname`,`tagline`,`description`),
  FULLTEXT KEY `name_2` (`name`,`nickname`,`tagline`,`description`),
  FULLTEXT KEY `name_3` (`name`,`nickname`,`tagline`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (1, 1, 'admin', 'admin', '', '', '', '', '', '', '', '', '', '', 'admin@localhost', '', '', '', NULL, 'd41d8cd98f00b204e9800998ecf8427e', '', '', 268435455, '8802cb162ddab55c0ad67747ca5992e1', '::1', 1, '2008-12-06 13:22:45', '2008-12-06 13:22:45', 0, 0, 0, 0, 0, '000000', 1, 0, NULL, '0000-00-00', 1, '0000-00-00 00:00:00', 'en', 0, '0000-00-00 00:00:00', 7, 3600, 0, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (2, 1, 'Peter Manage <x>', 'pm', '', 'pm mobile phone <x>', 'pm personal phone <x>', 'pm personal fax <x>', 'pm personal email <x>', 'pm personal street <x>', 'pm personal zipcode <x>', 'pm peronal page <x>', 'pm office phone <x>', 'pm office fax <x>', 'pm@nowhere.com <x>', 'pm office street <x>', 'pm office zipcode <x>', 'pm office page <x>', 'PM personal descriptions.', '567a70fc4346365d94156a9d8a103bee', '0', '0', 268431327, '8bf5531a8822505f0bf0a35ba02bdbe2', '::1', 1, '2008-12-06 13:23:11', '2008-12-06 13:09:55', 0, 0, 0, 0, 0, '', 2, 0, '1fd0fd6021e9cb31a56dc15524d8eaea', '2008-12-16', 1, '2008-12-06 13:09:55', 'en', 202, '2008-12-06 13:22:45', 3, 3600, 10, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (3, 1, 'Alan <x>', 'alan', '', '', '', '', '', '', '', '', '', '', 'alans@nowhere.com', '', '', '', 'Alans description\r\n', '', '0', '0', 8192, '94ab77df367c919bf3f5056769384ec7', '0', 1, '0000-00-00 00:00:00', '2008-12-06 13:11:15', 0, 0, 0, 0, 0, '', 3, 0, '86544d6bf33a2c45dc24ec57afa484f5', '0000-00-00', 1, '2008-12-06 13:11:15', 'en', 202, '2008-12-06 13:22:45', 3, 0, 10, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (4, 1, 'Bob <x>', 'bob', '', '', '', '', '', '', '', '', '', '', 'bob@nowhere.com', '', '', '', '', '383a87f21dcda2c6b7c32e6f8b2e9460', '0', '0', 8192, '1049c9ecd95b3b2150c1834b3be7b09f', '0', 1, '0000-00-00 00:00:00', '2008-12-06 13:11:48', 0, 0, 0, 0, 0, '', 3, 0, 'b3613dde116458e3b718c3150159e06e', '0000-00-00', 1, '2008-12-06 13:11:48', 'en', 202, '2008-12-06 13:22:45', 3, 0, 11, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (5, 1, 'Stalin', 'stalin', '', '', '', '', '', '', '', '', '', '', 'stalin@nowhere.com', '', '', '', '', 'dca0b0e3be9d001b25b45007ac293e2a', '0', '0', 8192, 'c9d996f25dc19b4aab76bbcb7001db16', '0', 1, '0000-00-00 00:00:00', '2008-12-06 13:12:49', 0, 0, 0, 0, 0, '', 6, 0, 'c871e40b582b1f3aa887a121dd76bf29', '0000-00-00', 1, '2008-12-06 13:12:49', 'en', 202, '2008-12-06 13:22:46', 3, 0, 0, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (6, 1, 'Roosevelt', 'roosevelt', '', '', '', '', '', '', '', '', '', '', 'roosevelt@nowhere', '', '', '', '', '91f637a1d8ffe84ad3c5ad74988b57c8', '0', '0', 8192, 'd3c4b5ddb4cbbc9c43fcef274add23fc', '0', 1, '0000-00-00 00:00:00', '2008-12-06 13:14:57', 0, 0, 0, 0, 0, '', 3, 0, '5b6733f220c471c9c09125311a7d7af1', '0000-00-00', 1, '2008-12-06 13:14:57', 'en', 10, '2008-12-06 13:22:46', 3, 0, 20, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (7, 1, 'Kennedy <x>', 'kennedy', '', '', '', '', '', '', '', '', '', '', 'kennedy@heaven', '', '', '', '', '37b524a943365945edc869480f301a88', '0', '0', 8192, 'ce12521c3213c2a728e86678431cb4d3', '0', 1, '0000-00-00 00:00:00', '2008-12-06 13:16:13', 0, 0, 0, 0, 0, '', 3, 0, '07d84390b96fcc6ea9135ed46a18ff1a', '0000-00-00', 1, '2008-12-06 13:16:13', 'en', 202, '2008-12-06 13:22:45', 3, 0, 20, '25', '0', 0);

#
#project
#

DROP TABLE IF EXISTS project;
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
  `labels` varchar(255) NOT NULL default 'Bug,Feature,Enhancement,Refacture,Idea,Research,Organize,Wiki,Docu,News',
  `show_in_home` tinyint(4) NOT NULL default '1',
  `pub_level` tinyint(4) NOT NULL default '0',
  `default_pub_level` tinyint(4) NOT NULL default '4',
  `settings` int(4) default '65535',
  `color` varchar(6) NOT NULL default '000000',
  `status_summary` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pub_level` (`pub_level`),
  FULLTEXT KEY `name` (`name`,`status_summary`,`description`),
  FULLTEXT KEY `name_2` (`name`,`status_summary`,`description`),
  FULLTEXT KEY `name_3` (`name`,`status_summary`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO project (id, state, name, short, wikipage, projectpage, date_start, date_closed, company, status, prio, description, labels, show_in_home, pub_level, default_pub_level, settings, color, status_summary) VALUES (12, 1, 'New Deal', 'new deal short <x>', '', '', '2008-12-06', '0000-00-00', 0, 3, 3, 'description <x>', 'Bug,Feature,Enhancement,Refactor,Idea,Research,Organize,Wiki,Docu', 0, 0, 4, 65519, '', 'over <x>');
INSERT INTO project (id, state, name, short, wikipage, projectpage, date_start, date_closed, company, status, prio, description, labels, show_in_home, pub_level, default_pub_level, settings, color, status_summary) VALUES (17, 1, 'Gulag <x>', '', '', '', '2008-12-06', '0000-00-00', 8, 3, 3, '', 'Bug,Feature,Enhancement,Refactor,Idea,Research,Organize,Wiki,Docu', 0, 0, 4, 65519, '', '');

#
#projectperson
#

DROP TABLE IF EXISTS projectperson;
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
  `role` tinyint(4) NOT NULL default '0',
  `adjust_effort_style` tinyint(4) NOT NULL default '1',
  `salary_per_hour` float NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `project` (`project`),
  KEY `state` (`state`),
  KEY `person` (`person`),
  KEY `proj_rights` (`proj_rights`),
  KEY `person_2` (`person`,`project`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (13, 1, 12, 'Admin', 1, 0, 2, 2, 6, 1, 2, 1, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (14, 1, 12, 'Developer', 3, 0, 4, 4, 4, 4, 1, 3, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (15, 1, 12, 'Developer', 4, 0, 4, 4, 4, 4, 1, 3, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (16, 1, 12, 'Developer', 6, 0, 4, 4, 4, 4, 1, 3, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (18, 1, 17, 'Admin', 1, 0, 2, 2, 6, 1, 2, 1, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (19, 1, 17, 'Developer', 3, 0, 4, 4, 4, 4, 1, 3, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (20, 1, 17, 'Project manager', 2, 0, 2, 2, 6, 1, 2, 2, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (21, 1, 17, 'Client', 5, 0, 5, 6, 2, 127, 127, 6, 1, '0');

#
#task
#

DROP TABLE IF EXISTS task;
CREATE TABLE `task` (
  `id` int(11) NOT NULL default '0',
  `order_id` int(11) NOT NULL default '0',
  `estimated` int(11) default '0',
  `estimated_max` int(11) default '0',
  `completion` tinyint(4) NOT NULL default '0',
  `parent_task` int(11) NOT NULL default '0',
  `is_folder` tinyint(4) NOT NULL default '0',
  `category` tinyint(4) NOT NULL default '0',
  `is_milestone` tinyint(4) NOT NULL default '0',
  `is_released` tinyint(4) NOT NULL default '0',
  `time_released` datetime NOT NULL,
  `label` tinyint(4) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `short` varchar(64) NOT NULL default '',
  `date_start` date NOT NULL default '0000-00-00',
  `for_milestone` int(11) default '0',
  `resolved_version` int(11) default '0',
  `resolve_reason` tinyint(4) NOT NULL default '0',
  `planned_start` datetime NOT NULL default '0000-00-00 00:00:00',
  `planned_end` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_closed` date NOT NULL default '0000-00-00',
  `status` tinyint(4) NOT NULL default '0',
  `prio` tinyint(4) NOT NULL default '0',
  `description` longtext,
  `issue_report` int(11) NOT NULL default '0',
  `view_collapsed` tinyint(4) NOT NULL default '0',
  `calculation` float NOT NULL default '0',
  `is_news` tinyint(1) NOT NULL default '0',
  `show_folder_as_documentation` int(1) NOT NULL default '0',
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
  KEY `is_released` (`is_released`),
  KEY `time_released` (`time_released`),
  FULLTEXT KEY `name` (`name`,`short`,`description`),
  FULLTEXT KEY `name_2` (`name`,`short`,`description`),
  FULLTEXT KEY `name_3` (`name`,`short`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO task (id, order_id, estimated, estimated_max, completion, parent_task, is_folder, category, is_milestone, is_released, time_released, label, name, short, date_start, for_milestone, resolved_version, resolve_reason, planned_start, planned_end, date_closed, status, prio, description, issue_report, view_collapsed, calculation, is_news, show_folder_as_documentation) VALUES (22, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 'enslave', '', '2008-12-06', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 2, 3, '', 0, 0, '0', 0, 0);
INSERT INTO task (id, order_id, estimated, estimated_max, completion, parent_task, is_folder, category, is_milestone, is_released, time_released, label, name, short, date_start, for_milestone, resolved_version, resolve_reason, planned_start, planned_end, date_closed, status, prio, description, issue_report, view_collapsed, calculation, is_news, show_folder_as_documentation) VALUES (23, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 'prepare escape', '', '2008-12-06', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 2, 3, '', 0, 0, '0', 0, 0);

#
#taskperson
#

DROP TABLE IF EXISTS taskperson;
CREATE TABLE `taskperson` (
  `id` int(11) NOT NULL auto_increment,
  `person` int(11) NOT NULL default '0',
  `task` int(11) NOT NULL default '0',
  `comment` text NOT NULL,
  `assigntype` tinyint(4) NOT NULL default '0',
  `forward` tinyint(1) NOT NULL default '0',
  `forward_comment` text,
  PRIMARY KEY  (`id`),
  KEY `person` (`person`,`task`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

