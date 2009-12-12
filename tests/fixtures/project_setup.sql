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
INSERT INTO comment (id, name, occasion, time, person, comment, effort, file, starts_discussion, description, task, view_collapsed) VALUES (39, 'this will be easy', 1, '2009-01-13 08:53:26', 0, 0, 0, 0, 0, 'A piece of cake.\r\n', 30, 0);

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
INSERT INTO company (id, name, tagline, short, phone, fax, street, zipcode, homepage, intranet, email, comments, state, category, pub_level) VALUES (8, 'kgb <x>', 'we trust nobody <x>', 'kgb <x>', 'kgb phone <x>', 'kgb fax <x>', 'kgb street <x>', 'kgb zip <x>', 'kgb site <x>', 'kgb intra <x>', 'kgb mail <x>', 'Comment on kgb <x>', 1, 10, 0);
INSERT INTO company (id, name, tagline, short, phone, fax, street, zipcode, homepage, intranet, email, comments, state, category, pub_level) VALUES (9, 'cia <x>', 'we trust in us <x>', 'cia <x>', 'cia phone <x>', 'cia fax <x>', 'cia street <x>', 'cia zip <x>', 'cia site <x>', 'cia intra <x>', 'cia mail <x>', 'Comments on CIA', 1, 10, 0);

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
INSERT INTO db (id, version, created, updated, version_streber_required) VALUES (1, '0.0911', '2009-12-12 15:41:37', NULL, '0.0902');

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
INSERT INTO effort (id, name, time_start, time_end, person, project, description, task, as_duration, status) VALUES (35, 'Got some weapons <x>', '2008-12-12 11:00:00', '2008-12-12 15:25:00', 5, 10, 'This should made be visible to Stalin', 32, 0, 1);
INSERT INTO effort (id, name, time_start, time_end, person, project, description, task, as_duration, status) VALUES (36, 'Got some weapons <x>', '2008-12-12 11:00:00', '2008-12-12 15:25:00', 5, 10, 'This should made be visible to Stalin', 0, 0, 1);
INSERT INTO effort (id, name, time_start, time_end, person, project, description, task, as_duration, status) VALUES (37, 'Thought', '2008-12-12 15:25:00', '2008-12-12 15:26:00', 5, 10, 'This should be private\r\n', 0, 0, 4);

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
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (1, 4, 3, '0000-00-00 00:00:00', '2009-01-13 08:51:31', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (2, 4, 3, '2008-12-12 14:44:56', '2009-01-13 08:52:23', '0000-00-00 00:00:00', 1, 2, 0, 0, 1);
#INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (3, 4, 3, '2008-12-12 14:47:40', '2008-12-12 14:47:40', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (4, 4, 3, '2008-12-12 14:51:03', '2008-12-12 15:05:19', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (5, 4, 3, '2008-12-12 14:54:44', '2008-12-12 15:29:34', '0000-00-00 00:00:00', 1, 5, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (6, 4, 3, '2008-12-12 14:57:30', '2008-12-12 14:57:30', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (7, 4, 3, '2008-12-12 15:03:02', '2008-12-12 15:12:25', '0000-00-00 00:00:00', 1, 2, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (8, 4, 5, '2008-12-12 15:06:36', '2008-12-12 15:06:36', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (9, 4, 5, '2008-12-12 15:07:38', '2008-12-12 15:07:38', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (10, 4, 1, '2008-12-12 15:09:40', '2009-01-13 08:53:26', '0000-00-00 00:00:00', 1, 2, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (11, 5, 4, '2008-12-12 15:09:40', '2008-12-12 15:09:40', '0000-00-00 00:00:00', 1, 1, 0, 10, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (12, 4, 1, '2008-12-12 15:10:41', '2008-12-12 15:10:41', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (13, 5, 4, '2008-12-12 15:10:41', '2008-12-12 15:10:41', '0000-00-00 00:00:00', 1, 1, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (14, 4, 4, '2008-12-12 15:13:04', '2008-12-12 15:13:04', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (15, 4, 4, '2008-12-12 15:13:04', '2008-12-12 15:13:04', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (16, 4, 4, '2008-12-12 15:13:04', '2008-12-12 15:13:04', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (17, 4, 4, '2008-12-12 15:13:04', '2008-12-12 15:13:04', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (18, 4, 2, '2008-12-12 15:14:31', '2008-12-12 15:14:31', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (19, 4, 2, '2008-12-12 15:15:19', '2008-12-12 15:15:19', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (20, 4, 15, '2008-12-12 15:15:19', '2008-12-12 15:15:19', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (21, 3, 2, '2008-12-12 15:16:06', '2008-12-12 15:16:06', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (22, 4, 15, '2008-12-12 15:16:06', '2008-12-12 15:16:06', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (23, 4, 2, '2008-12-12 15:21:23', '2008-12-12 15:21:23', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (24, 4, 15, '2008-12-12 15:21:23', '2008-12-12 15:21:23', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (25, 5, 2, '2008-12-12 15:22:06', '2008-12-12 15:22:06', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (26, 4, 15, '2008-12-12 15:22:06', '2008-12-12 15:22:06', '0000-00-00 00:00:00', 2, 2, 0, 12, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (27, 4, 4, '2008-12-12 15:22:59', '2008-12-12 15:22:59', '0000-00-00 00:00:00', 2, 2, 0, 10, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (28, 4, 4, '2008-12-12 15:22:59', '2008-12-12 15:22:59', '0000-00-00 00:00:00', 2, 2, 0, 10, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (29, 4, 4, '2008-12-12 15:22:59', '2008-12-12 15:22:59', '0000-00-00 00:00:00', 2, 2, 0, 10, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (30, 5, 2, '2008-12-12 15:23:18', '2009-01-13 08:53:26', '0000-00-00 00:00:00', 2, 2, 0, 10, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (31, 4, 15, '2008-12-12 15:23:18', '2009-01-13 08:53:26', '0000-00-00 00:00:00', 2, 2, 0, 10, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (32, 4, 2, '2008-12-12 15:23:36', '2008-12-12 15:23:36', '0000-00-00 00:00:00', 2, 2, 0, 10, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (33, 4, 15, '2008-12-12 15:23:36', '2008-12-12 15:23:36', '0000-00-00 00:00:00', 2, 2, 0, 10, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (34, 1, 2, '2008-12-12 15:25:13', '2008-12-12 15:25:13', '0000-00-00 00:00:00', 5, 5, 0, 10, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (35, 4, 8, '2008-12-12 15:26:29', '2008-12-12 15:27:34', '0000-00-00 00:00:00', 5, 5, 0, 10, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (36, 4, 8, '2008-12-12 15:26:29', '2008-12-12 15:26:38', '2008-12-12 15:26:38', 5, 5, 5, 10, -1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (37, 1, 8, '2008-12-12 15:27:11', '2008-12-12 15:27:11', '0000-00-00 00:00:00', 5, 5, 0, 10, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (38, 4, 3, '2009-01-11 21:26:54', '2009-01-11 21:28:12', '0000-00-00 00:00:00', 1, 1, 0, 0, 1);
INSERT INTO item (id, pub_level, type, created, modified, deleted, created_by, modified_by, deleted_by, project, state) VALUES (39, 4, 10, '2009-01-13 08:53:26', '2009-01-13 08:53:26', '0000-00-00 00:00:00', 2, 2, 0, 10, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (1, 7, 1, '2008-12-12 15:03:23', 'personal_email', 'roosevelt <x>');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (2, 7, 1, '2008-12-12 15:04:13', 'personal_phone', 'roosevelt <x>');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (3, 7, 1, '2008-12-12 15:04:13', 'personal_fax', 'roosevelt <x>');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (4, 7, 1, '2008-12-12 15:04:13', 'personal_street', 'roosevelt <x>');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (5, 7, 1, '2008-12-12 15:04:13', 'personal_zipcode', 'roosevelt <x>');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (6, 7, 1, '2008-12-12 15:04:13', 'personal_homepage', 'roosevelt <x>');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (7, 7, 1, '2008-12-12 15:04:13', 'description', '');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (8, 7, 1, '2008-12-12 15:04:30', 'name', 'Roosevelt');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (9, 4, 1, '2008-12-12 15:05:19', 'description', 'Alans description <x>');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (10, 4, 1, '2008-12-12 15:05:19', 'profile', '3');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (11, 4, 1, '2008-12-12 15:05:19', 'category', '0');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (12, 7, 2, '2008-12-12 15:12:25', 'profile', '3');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (13, 30, 2, '2008-12-12 15:24:00', 'pub_level', '4');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (14, 30, 2, '2008-12-12 15:24:00', 'status', '2');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (15, 36, 5, '2008-12-12 15:26:38', 'state', '1');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (16, 38, 1, '2009-01-11 21:27:10', 'user_rights', '268435456');
INSERT INTO itemchange (id, item, modified_by, modified, field, value_old) VALUES (17, 2, 2, '2009-01-13 08:52:23', 'user_rights', '268435455');

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (1, 2, 12, 1, '2009-01-13 08:52:32', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (2, 2, 7, 1, '2008-12-12 15:12:25', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (3, 2, 10, 1, '2009-01-13 08:52:46', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (4, 2, 30, 1, '2009-01-13 08:53:27', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (5, 5, 10, 1, '2008-12-12 15:25:13', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (6, 1, 12, 1, '2009-01-11 21:25:49', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (7, 38, 12, 1, '2009-01-11 21:28:30', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (8, 38, 18, 1, '2009-01-11 21:28:53', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (9, 5, 30, 0, '0000-00-00 00:00:00', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 2);
INSERT INTO itemperson (id, person, item, viewed, viewed_last, view_count, notify_if_unchanged, is_bookmark, notify_on_change, notify_date, comment, created, feedback_requested_by) VALUES (10, 2, 39, 1, '2009-01-13 08:53:27', 1, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0);

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
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (1, 1, 'admin', 'admin', '', '', '', '', '', '', '', '', '', '', 'admin@localhost', '', '', '', NULL, 'd41d8cd98f00b204e9800998ecf8427e', '', '', 268435455, '0f2284e50c558640640ad6b81a67b18c', '::1', 1, '2009-01-13 08:51:31', '2009-01-13 08:51:31', 0, 0, 0, 0, 0, '000000', 1, 0, NULL, '0000-00-00', 1, '0000-00-00 00:00:00', 'en', 0, '0000-00-00 00:00:00', 7, 3600, 0, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (2, 1, 'Peter Manage <x>', 'pm', '', 'pm mobile <x>', 'pm personal phone <x>', 'pm personal fax <x>', 'pm personal email <x>', 'pm personal street <x>', 'pm personal zipcode <x>', 'pm peronal page <x>', 'pm office phone <x>', 'pm office fax <x>', 'pm@nowhere <x>', 'pm office street <x>', 'pm office zipcode <x>', 'pm office page <x>', 'Comments on pm <x>', '567a70fc4346365d94156a9d8a103bee', '0', '0', 268431263, '003380f4b47576457fc406f71ed87e67', '::1', 1, '2009-01-13 08:53:26', '2008-12-12 15:24:04', 0, 0, 0, 0, 0, '', 1, 0, '1fd0fd6021e9cb31a56dc15524d8eaea', '2008-12-18', 1, '2008-12-12 14:44:56', 'en', 202, '2009-01-11 21:27:37', 3, 3600, 10, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (4, 1, 'Alan <x>', 'alan', '', 'alan mobile ph <x>', 'alan personal phone <x>', 'alan personal fax <x>', 'alan personal mail <x>', 'alan personal street <x>', 'alan personal zipcode <x>', 'alan personal page <x>', 'alan office ph <x>', 'alan office fax <x>', 'alans@nowhere', 'alan office street <x>', 'alan office zipcode <x>', 'alan office page <x>', 'Alan is a freelance artist <x>', '7c7d4f201ac729cff3e1cbafb80ee302', '0', '0', 8192, 'fbc89e31d849ee9d7c84d58a0ea7403c', '0', 1, '0000-00-00 00:00:00', '2008-12-12 14:51:03', 0, 0, 0, 0, 0, '', 4, 0, '27954e38172d1c0c26499b5b0d9002be', '0000-00-00', 1, '2008-12-12 14:51:03', 'en', 202, '2009-01-11 21:27:37', 3, 0, 11, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (5, 1, 'Bob <x>', 'bob', '', 'bob mobile <x>', 'bob phone2 <x>', 'bob pfax <x>', 'bob mail <x>', 'bob pstreet <x>', 'bob zip <x>', 'bob ppage <x>', 'bob phone <x>', 'bob fax <x>', 'bob@nowhere <x>', 'bob street <x>', 'bob zip <x>', 'bob page <x>', 'Description on bob <x>', '383a87f21dcda2c6b7c32e6f8b2e9460', '0', '0', 8192, '4c9b73cbacfef20de32b3d429c66cc2a', '::1', 1, '2008-12-12 15:29:34', '2008-12-12 15:29:34', 0, 0, 0, 0, 0, '', 3, 0, 'b3613dde116458e3b718c3150159e06e', '0000-00-00', 1, '2008-12-12 14:54:44', 'en', 74, '2009-01-11 21:27:37', 3, 3600, 10, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (6, 1, 'Joseph Stalin <x>', 'stalin', '', 'stalin phone <x>', 'stalin phone <x>', 'stalin pfax <x>', 'stalin mail <x>', 'stalin street <x>', 'stalin zip <x>', 'staline ppage <x>', 'stalin phone <x>', 'stalin fax <x>', 'stalin@nowhere.com', 'stalin street <x>', 'stalin zip <x>', 'stalin page <x>', 'description on stalin <x>', 'dca0b0e3be9d001b25b45007ac293e2a', '0', '0', 8192, '09a32c4a12cfbc2c5cc35b5a37987737', '0', 1, '0000-00-00 00:00:00', '2008-12-12 14:57:30', 0, 0, 0, 0, 0, '', 6, 0, 'c22de9083647119800455c4b0e08fc4b', '0000-00-00', 1, '2008-12-12 14:57:30', 'de', 10, '2008-12-12 15:10:48', 3, 0, 20, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (7, 1, 'Roosevelt <x>', 'roosevelt', '', 'roosevelt mobile<x>', 'roosevelt pphone<x>', 'roosevelt pfax<x>', 'roosevelt pmail<x>', 'roosevelt pstreet<x>', 'roosevelt pzip<x>', 'roosevelt ppage<x>', 'roosevelt phone<x>', 'roosevelt office<x>', 'roosevelt omail<x>', 'roosevelt steet<x>', 'roosevelt zip<x>', 'roosevelt page<x>', 'Description on Roosevelt', '91f637a1d8ffe84ad3c5ad74988b57c8', '0', '0', 8192, 'ca876a9100e7d67041bfdc4f2546d135', '0', 1, '0000-00-00 00:00:00', '2008-12-12 15:03:02', 0, 0, 0, 0, 0, '', 7, 0, '1ab6866bb22d389990c90fbbd7a70cc2', '0000-00-00', 1, '2008-12-12 15:03:02', 'en', 138, '2009-01-11 21:27:37', 3, 0, 0, '25', '0', 0);
INSERT INTO person (id, state, name, nickname, tagline, mobile_phone, personal_phone, personal_fax, personal_email, personal_street, personal_zipcode, personal_homepage, office_phone, office_fax, office_email, office_street, office_zipcode, office_homepage, description, password, security_question, security_answer, user_rights, cookie_string, ip_address, can_login, last_login, last_logout, user_level_view, user_level_create, user_level_edit, user_level_reduce, pub_level, color, profile, theme, identifier, birthdate, show_tasks_at_home, date_highlight_changes, language, settings, notification_last, notification_period, time_offset, category, time_zone, salary_per_hour, ldap) VALUES (38, 1, 'guest', 'guest', '', '', '', '', '', '', '', '', '', '', 'guest@heaven.org', '', '', '', '', '4fadf02c3b96598fc94a0f973b8fcb06', '0', '0', 32, '23e33136d1bdfcd6d052b4639117d338', '::1', 1, '2009-01-11 21:28:53', '2009-01-11 21:26:54', 0, 0, 0, 0, 0, '', 8, 0, '9962145bfdde62f186450d07256e0d42', '0000-00-00', 1, '2009-01-11 21:26:54', 'en', 10, '2009-01-11 21:27:37', 3, 3600, 0, '25', '0', 0);

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
INSERT INTO project (id, state, name, short, wikipage, projectpage, date_start, date_closed, company, status, prio, description, labels, show_in_home, pub_level, default_pub_level, settings, color, status_summary) VALUES (10, 1, 'win war', 'ww <x>', '', 'win war.com <x>', '2008-12-12', '0000-00-00', 8, 3, 3, 'Win war and defeat Adolf.', 'Bug,Feature,Enhancement,Refactor,Idea,Research,Organize,Wiki,Docu', 0, 0, 4, 65519, '', 'in progess <x>');
INSERT INTO project (id, state, name, short, wikipage, projectpage, date_start, date_closed, company, status, prio, description, labels, show_in_home, pub_level, default_pub_level, settings, color, status_summary) VALUES (12, 1, 'manhatten <x>', 'm <x>', '', 'bomb.com <x>', '2008-12-12', '0000-00-00', 9, 3, 1, 'Uh oh <x>', 'Bug,Feature,Enhancement,Refactor,Idea,Research,Organize,Wiki,Docu', 0, 0, 4, 65519, '', 'almost finished <x>');

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
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (11, 1, 10, 'Admin', 1, 0, 2, 2, 6, 1, 2, 1, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (13, 1, 12, 'Admin', 1, 0, 2, 2, 6, 1, 2, 1, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (14, 1, 12, 'Artist', 4, 0, 4, 4, 4, 4, 1, 4, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (15, 1, 12, 'Developer', 5, 0, 4, 4, 4, 4, 1, 3, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (16, 1, 12, 'Admin', 2, 0, 2, 2, 6, 1, 2, 1, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (17, 1, 12, 'Client trusted', 7, 0, 4, 6, 2, 127, 6, 7, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (27, 1, 10, 'Developer', 5, 0, 4, 4, 4, 4, 1, 3, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (28, 1, 10, 'Client', 6, 0, 5, 6, 2, 127, 127, 6, 1, '0');
INSERT INTO projectperson (id, state, project, name, person, proj_rights, level_view, level_edit, level_create, level_reduce, level_delete, role, adjust_effort_style, salary_per_hour) VALUES (29, 1, 10, 'Admin', 2, 0, 2, 2, 6, 1, 2, 1, 1, '0');

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
INSERT INTO task (id, order_id, estimated, estimated_max, completion, parent_task, is_folder, category, is_milestone, is_released, time_released, label, name, short, date_start, for_milestone, resolved_version, resolve_reason, planned_start, planned_end, date_closed, status, prio, description, issue_report, view_collapsed, calculation, is_news, show_folder_as_documentation) VALUES (18, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 'defeat hitler <x>', 'dh <x>', '2008-12-12', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 2, 3, 'Send some troops <x>', 0, 0, '0', 0, 0);
INSERT INTO task (id, order_id, estimated, estimated_max, completion, parent_task, is_folder, category, is_milestone, is_released, time_released, label, name, short, date_start, for_milestone, resolved_version, resolve_reason, planned_start, planned_end, date_closed, status, prio, description, issue_report, view_collapsed, calculation, is_news, show_folder_as_documentation) VALUES (19, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 'build bomb <x>', '', '2008-12-12', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 2, 3, 'should look nice', 0, 0, '0', 0, 0);
INSERT INTO task (id, order_id, estimated, estimated_max, completion, parent_task, is_folder, category, is_milestone, is_released, time_released, label, name, short, date_start, for_milestone, resolved_version, resolve_reason, planned_start, planned_end, date_closed, status, prio, description, issue_report, view_collapsed, calculation, is_news, show_folder_as_documentation) VALUES (21, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 'drop bomb <x>', '', '2008-12-12', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 2, 3, 'Handle with care <x>', 0, 0, '0', 0, 0);
INSERT INTO task (id, order_id, estimated, estimated_max, completion, parent_task, is_folder, category, is_milestone, is_released, time_released, label, name, short, date_start, for_milestone, resolved_version, resolve_reason, planned_start, planned_end, date_closed, status, prio, description, issue_report, view_collapsed, calculation, is_news, show_folder_as_documentation) VALUES (23, 0, 0, 0, 0, 0, 0, 2, 0, 0, '0000-00-00 00:00:00', 0, 'why i love the bomb', '', '2008-12-12', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 2, 3, 'Headline', 0, 0, '0', 0, 0);
INSERT INTO task (id, order_id, estimated, estimated_max, completion, parent_task, is_folder, category, is_milestone, is_released, time_released, label, name, short, date_start, for_milestone, resolved_version, resolve_reason, planned_start, planned_end, date_closed, status, prio, description, issue_report, view_collapsed, calculation, is_news, show_folder_as_documentation) VALUES (25, 0, 0, 0, 0, 0, 0, 2, 0, 0, '0000-00-00 00:00:00', 0, 'we will win', 'win!', '2008-12-12', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 2, 3, 'This is big news for everybody.', 0, 0, '0', 1, 0);
INSERT INTO task (id, order_id, estimated, estimated_max, completion, parent_task, is_folder, category, is_milestone, is_released, time_released, label, name, short, date_start, for_milestone, resolved_version, resolve_reason, planned_start, planned_end, date_closed, status, prio, description, issue_report, view_collapsed, calculation, is_news, show_folder_as_documentation) VALUES (30, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 'win war', '', '2008-12-12', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 3, 3, '', 0, 0, '0', 0, 0);
INSERT INTO task (id, order_id, estimated, estimated_max, completion, parent_task, is_folder, category, is_milestone, is_released, time_released, label, name, short, date_start, for_milestone, resolved_version, resolve_reason, planned_start, planned_end, date_closed, status, prio, description, issue_report, view_collapsed, calculation, is_news, show_folder_as_documentation) VALUES (32, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 'get weapons', '', '2008-12-12', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 2, 3, '', 0, 0, '0', 0, 0);
INSERT INTO task (id, order_id, estimated, estimated_max, completion, parent_task, is_folder, category, is_milestone, is_released, time_released, label, name, short, date_start, for_milestone, resolved_version, resolve_reason, planned_start, planned_end, date_closed, status, prio, description, issue_report, view_collapsed, calculation, is_news, show_folder_as_documentation) VALUES (34, 0, 0, 0, 0, 0, 0, 2, 0, 0, '0000-00-00 00:00:00', 0, 'escape from gulag', '', '2008-12-12', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 2, 3, 'This should nobody know.\r\n', 0, 0, '0', 0, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
INSERT INTO taskperson (id, person, task, comment, assigntype, forward, forward_comment) VALUES (20, 4, 19, '', 1, 0, '');
INSERT INTO taskperson (id, person, task, comment, assigntype, forward, forward_comment) VALUES (22, 5, 21, '', 1, 0, '');
INSERT INTO taskperson (id, person, task, comment, assigntype, forward, forward_comment) VALUES (24, 5, 23, '', 1, 0, '');
INSERT INTO taskperson (id, person, task, comment, assigntype, forward, forward_comment) VALUES (26, 5, 25, '', 1, 0, '');
INSERT INTO taskperson (id, person, task, comment, assigntype, forward, forward_comment) VALUES (31, 5, 30, '', 1, 0, '');
INSERT INTO taskperson (id, person, task, comment, assigntype, forward, forward_comment) VALUES (33, 5, 32, '', 1, 0, '');

