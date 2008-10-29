<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

/**
*
* definitions of fundatamental constants and settings
*
*
* @requiredby:conf.inc, index.php *
* @requires: nothing,  php4-valid
*/


/**
* database object types for item-table
*
* @@@ move somewhere else (but remind that it is required by "install/install.php"
*/
DEFINE('ITEM_PROJECT',      1);
DEFINE('ITEM_TASK',         2);
DEFINE('ITEM_PERSON',       3);
DEFINE('ITEM_PROJECTPERSON', 4);
DEFINE('ITEM_COMPANY',      5);
DEFINE('ITEM_EMPLOYMENT',   6);
DEFINE('ITEM_ISSUE',        7);
DEFINE('ITEM_EFFORT',       8);
DEFINE('ITEM_TASK_EFFORT',  9);
DEFINE('ITEM_COMMENT',      10);
DEFINE('ITEM_FILE',         11);
#DEFINE('ITEM_DEADLINE',     12);                           # reservated
DEFINE('ITEM_VERSION',      13);
DEFINE('ITEM_APPOINTMENT',  14);
DEFINE('ITEM_TASKPERSON',   15);

DEFINE('ITEM_STATE_OK',     1);
DEFINE('ITEM_STATE_DELETED',-1);


DEFINE('MAX_STORED_FROM_HANDLES',50);  # how many from-handles are stored in one file for each user in _tmp


define('PROFILE_USER',0);
define('PROFILE_ADMIN',1);
define('PROFILE_PM',2);
define('PROFILE_DEVELOPER',3);
define('PROFILE_ARTIST',4);
define('PROFILE_TESTER',5);
define('PROFILE_CLIENT',6);
define('PROFILE_CLIENT_TRUSTED',7);
define('PROFILE_GUEST',8);
define('PROFILE_ANONYMOUS',9);


define('RIGHT_PROJECT_CREATE',      1<<1);
define('RIGHT_PROJECT_EDIT',        1<<2);
define('RIGHT_PROJECT_ASSIGN',      1<<3);
define('RIGHT_PROJECT_DELETE',      1<<4);
define('RIGHT_VIEWALL',             1<<5);      # implies view all other projects
define('RIGHT_EDITALL',             1<<6);      # implies editing anything!

define('RIGHT_PERSON_CREATE',       1<<9);      # creating persons includes right-editing
define('RIGHT_PERSON_EDIT',         1<<9);
define('RIGHT_PERSON_DELETE',       1<<10);
define('RIGHT_PERSON_VIEWALL',      1<<11);
define('RIGHT_PERSON_EDIT_RIGHTS',  1<<12);
define('RIGHT_PERSON_EDIT_SELF',    1<<13);

define('RIGHT_COMPANY_CREATE',      1<<16);
define('RIGHT_COMPANY_EDIT',        1<<17);
define('RIGHT_COMPANY_DELETE',      1<<18);
define('RIGHT_COMPANY_VIEWALL',     1<<19);

define('RIGHT_ALL',                 0xfffffff);
define('RIGHT_NONE',                1<<28);     # dummy setting to make default-rights always true

/**
* possible tasks-filters for home
* @usedin in person>>show_tasks_at_home
*/
define('SHOW_NOTHING',         0);
define('SHOW_ASSIGNED_ONLY',   1);
define('SHOW_ALSO_UNASSIGNED', 2);
define('SHOW_ALL_OPEN',        3);




/**
* @@@ problem araises on how to deal with comments: Everyone should
*     add comments with public level, but not anybody should edit them
*/
define('PUB_LEVEL_NONE',        0);
define('PUB_LEVEL_PRIVATE',     1);
define('PUB_LEVEL_SUGGESTED',   2);
define('PUB_LEVEL_INTERNAL',    3);
define('PUB_LEVEL_OPEN',        4);
define('PUB_LEVEL_CLIENT',      5);
define('PUB_LEVEL_CLIENTEDIT',  6);
define('PUB_LEVEL_ASSIGNED',    100);
define('PUB_LEVEL_OWNED',       101);
define('PUB_LEVEL_NOTHING',     127);



define('RESOLVED_IN_NEXT_VERSION'  ,-1);


define('RESOLVED_UNDEFINED'        ,0);
define('RESOLVED_DONE'             ,1);
define('RESOLVED_FIXED'            ,2);
define('RESOLVED_WORKS_FOR_ME'     ,3);
define('RESOLVED_DUPLICATE'        ,4);
define('RESOLVED_BOGUS'            ,5);
define('RESOLVED_REJECTED'         ,6);
define('RESOLVED_DEFERRED'         ,7);


define('RELEASED_UNDEFINED',       0);
define('RELEASED_NOT_PLANNED',     1);
define('RELEASED_UPCOMMING',       2);  # reserved
define('RELEASED_INTERNAL',        10);
define('RELEASED_PUBLIC',          11);
define('RELEASED_WITHOUT_SUPPORT',    20);
define('RELEASED_NO_LONGER_SUPPORTED',   21);


define('SEVERITY_UNDEFINED'        ,0);
define('SEVERITY_NITPICKY'         ,1);
define('SEVERITY_FEATURE'          ,2);
define('SEVERITY_TRIVIAL'          ,3);
define('SEVERITY_TEXT'             ,4);
define('SEVERITY_TWEAK'            ,5);
define('SEVERITY_MINOR'            ,6);
define('SEVERITY_MAJOR'            ,7);
define('SEVERITY_CRASH'            ,8);
define('SEVERITY_BLOCK'            ,9);
define('SEVERITY_SECURITY'         ,10);




define('REPRODUCIBILITY_UNDEFINED'  ,0);
define('REPRODUCIBILITY_ALWAYS'     ,2);    # note: not available (1) has been depreciated
define('REPRODUCIBILITY_SOMETIMES'  ,3);
define('REPRODUCIBILITY_HAVE_NOT_TRIED',4);
define('REPRODUCIBILITY_UNABLE_TO_REPRODUCE',5);

/**
* LOG_DEBUG is already reservate by syslog... ;-(
*/

define('LOG_MESSAGE_ALL',           0xfffffff);
define('LOG_MESSAGE_DEBUG',         1 << 1);
define('LOG_MESSAGE_LOGIN_SUCCESS', 1 << 2);
define('LOG_MESSAGE_LOGIN_FAILURE', 1 << 3);
define('LOG_MESSAGE_LOGOUT',        1 << 4);
define('LOG_MESSAGE_DB_INSERT',     1 << 5);
define('LOG_MESSAGE_DB_UPDATE',     1 << 6);
define('LOG_MESSAGE_HACKING_ALERT', 1 << 7);                # stuff regarding to intrusion / hacking attempts
define('LOG_MESSAGE_MISSING_FILES', 1 << 8);



define('STATUS_TEMPLATE', -1);
define('STATUS_UNDEFINED',0);
define('STATUS_UPCOMING', 1);
define('STATUS_NEW',      2);
define('STATUS_OPEN',     3);
define('STATUS_BLOCKED',  4);
define('STATUS_COMPLETED',5);
define('STATUS_APPROVED', 6);
define('STATUS_CLOSED',   8);



$COMMENTTYPE_VALUES=array(
'undefined'=>0,
'Comment'=>1,
'Reply'=>2,
'Conversation'=>3,
'Phone'=>4,
'Meeting'=>5,
'Idea'=>6,
);
$COMMENTTYPE_NAMES=array_flip($COMMENTTYPE_VALUES);



define('PRIO_UNDEFINED', 0);
define('PRIO_URGENT',1);
define('PRIO_HIGH', 2);
define('PRIO_NORMAL', 3);
define('PRIO_LOWER',4);
define('PRIO_LOWEST', 5);


define('PROJECT_SETTING_ENABLE_EFFORTS',           1<<1);
define('PROJECT_SETTING_ENABLE_MILESTONES',        1<<2);
define('PROJECT_SETTING_ENABLE_VERSIONS',          1<<3);
define('PROJECT_SETTING_ONLY_PM_MAY_CLOSE',        1<<4);
define('PROJECT_SETTING_ENABLE_BUGS',              1<<5);
define('PROJECT_SETTING_ENABLE_TASKS',             1<<6);
define('PROJECT_SETTING_ENABLE_FILES',             1<<7);
define('PROJECT_SETTING_ENABLE_NEWS',              1<<8);

define('PROJECT_SETTING_ALL',               0xffff);

define('USER_SETTING_NOTIFICATIONS',                1<<1);  #
define('USER_SETTING_HTML_MAIL',                    1<<2);  # obsolete
define('USER_SETTING_NOTIFY_ASSIGNED_TO_PROJECT',   1<<3);  # obsolete
define('USER_SETTING_SEND_ACTIVATION',              1<<4);  # flag if next notification should include activiation
define('USER_SETTING_EFFORTS_AS_DURATION',          1<<5);  #
define('USER_SETTING_ENABLE_EFFORTS',               1<<6);  #
define('USER_SETTING_ENABLE_BOOKMARKS',             1<<7);  #
define('USER_SETTING_FILTER_OWN_CHANGES',           1<<8);  # filter items changed by current user from recent changes list

define('EFFORT_STYLE_TIMES',1);
define('EFFORT_STYLE_DURATION',2);

$g_security_questions=array(
'in your youth you wanted to become a...',
'person you would like to kick in the ass...',
'your favorit car is a...',
'your best vacation was in...',
);

/**
* company types
* for translated words see std/constant_names.inc -> g_ccategory_names
*/
define('CCATEGORY_UNDEFINED',0);
define('CCATEGORY_CLIENT',10);
define('CCATEGORY_PROSCLIENT',11);
define('CCATEGORY_SUPPLIER',12);
define('CCATEGORY_PARTNER',13);

/**
* person types
* for translated words see std/constant_names.inc -> g_pcategory_names
*/
define('PCATEGORY_UNDEFINED',0);
define('PCATEGORY_EMPLOYEE',-1);
define('PCATEGORY_STAFF',10);
define('PCATEGORY_FREELANCER',11);
define('PCATEGORY_STUDENT',12);
define('PCATEGORY_APPRENTICE',13);
define('PCATEGORY_INTERN',14);
define('PCATEGORY_EXEMPLOYEE',15);
define('PCATEGORY_CONTACT',-2);
define('PCATEGORY_CLIENT',20);
define('PCATEGORY_PROSCLIENT',21);
define('PCATEGORY_SUPPLIER',22);
define('PCATEGORY_PARTNER',23);


define('FSTATE_UNKNOWN',1);
define('FSTATE_CHANGED',2);
define('FSTATE_SAVED',3);

define('ITEMSTATE_DELETED',-1);
define('ITEMSTATE_NORMAL',1);

define('FDOWNLOAD_ALWAYS',  0);
define('FDOWNLOAD_ONDEMAND',1);
define('FDOWNLOAD_NEVER',   2); # reserved


define('TCATEGORY_TASK',            0);
define('TCATEGORY_BUG',             1);
define('TCATEGORY_DOCU',            2);
define('TCATEGORY_FOLDER',          3);     # reserved
define('TCATEGORY_FOLDER_AND_DOCU', 4);     # reserved
define('TCATEGORY_EVENT',           5);     # reserved
define('TCATEGORY_MILESTONE',       10);    # reserved
define('TCATEGORY_VERSION',         11);    # reserved

define('FORMAT_HTML', 'html');
define('FORMAT_CSV', 'csv');

define('NOTIFY_NEVER', 0);
define('NOTIFY_ASAP',  -1);
define('NOTIFY_1DAY', 1);
define('NOTIFY_2DAYS', 2);
define('NOTIFY_3DAYS', 3);
define('NOTIFY_4DAYS', 4);
define('NOTIFY_5DAYS', 5);
define('NOTIFY_1WEEK', 10);
define('NOTIFY_2WEEKS', 11);
define('NOTIFY_3WEEKS', 12);
define('NOTIFY_1MONTH', 20);
define('NOTIFY_2MONTH', 21);

define('EFFORT_STATUS_NEW', 1);
define('EFFORT_STATUS_OPEN', 2);
define('EFFORT_STATUS_DISCOUNTED', 3);
define('EFFORT_STATUS_NOTCHARGEABLE', 4);
define('EFFORT_STATUS_BALANCED', 5);

/**
* default-initialisation of fields...
*
* - the initilization is done in the db->__construct()
* - actually this mapping just makes sure, that inital-values are valid
*
*/
define('FINIT_REQUIRED','__FIELD_REQUIRED__');
define('FINIT_TODAY',   '__TODAY_');
define('FINIT_NOW',     '__TIMENOW__');
define('FINIT_NEVER',   '0000-00-00 00:00:00');
define('FINIT_CUR_USER',   '__CUR_USER__');
define('FINIT_RAND_MD5',   '__rand_md5__');


/**
* default value for estimating clien'ts time zone offset with javascript
*/
define('TIME_OFFSET_AUTO', 25);

global $g_time_zones;
$g_time_zones=array(
    "-- ".__("autodetect"). " --"          =>  TIME_OFFSET_AUTO,
    'GMT -12 : Dateline Standard'               => -12,
    'GMT -11 : Samoa'                           => -11,
    'GMT -10 : Hawaiian'                        => -10,
    'GMT -8 : Pacific'                          => -8,
    'GMT -7 : Mexican, Mountain'               => -7,
    'GMT -6 : Central, Mexico'                 => -6,
    'GMT -5 : Eastern  Eastern Time, SA Pacific'=> -5,
    'GMT -4 : Atlantic, SA Western , Pacific SA'=>-4,
    'GMT -3.5 : Newfoundland'                   => -3.5,
    'GMT -3 : SA Eastern, E. South America'    => -3,
    'GMT -2 : Mid:Atlantic'                     => -2,
    'GMT -1 : Azores, Cape Verde'              => -1,
    'GMT : Universal Coordinated Time, Greenwich Mean Time' => 0,
    'GMT +1 : Central European, Romance, Central Africa' => 1,
    'GMT +2 : Egypt, South Africa, E. Europe , FLE , GTB'  => 2,
    'GMT +3 : Arab, E. Africa, Arabic, Russian'  => 3,
    'GMT +3.5 : Iran '                              => 3.5,
    'GMT +4 : Arabian, Caucasus, Afghanistan'     => 4,
    'GMT +5 : West Asia'                            => 5,
    'GMT +5.5 : India'                              => 5.5,
    'GMT +5.75 : Nepal'                             => 5.75,
    'GMT +6 : Central Asia'                     => 6,
    'GMT +6.5 : Myanmar'                        => 6.5,
    'GMT +7 : SE Asia, North Asia'             => 7,
    'GMT +8 : China, W. Australia, Singapore, Taipei, North Asia East'=> 8,
    'GMT +9 : Tokyo, Korea , Yakutsk'          => 9,
    'GMT +9.5 : AUS Central, Cen. Australia'   => 9.5,
    'GMT +10 : AUS Eastern, E. Australia . West Pacific, Tasmania, Vladivostok'=> 10,
    'GMT +11 : Central Pacific'                 => 11,
    'GMT +12 : Fiji, New Zealand'              => 12,
    'GMT +13 : Tonga'                           => 13
);


/**
* convert text to html-format (add line-breaks)
*
* if project has wiki-link, solve links
*/
global $g_wiki_project;
$g_wiki_project= NULL;                                      # dirty hack to pass project for linking of wiki-pages

?>
