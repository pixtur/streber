<?

 /**
  *
  * cron.php
  * 30-April-08
  * @author Cody A.W. Somerville <cody@redcow.ca>
  *
  * This file will do tasks/chores that should be completed on a
  * regular basis. It is up to the site administrator to setup a
  * crontab or other mechanism to visit this page at a desired
  * interval.
  *
  */

require_once("std/common.inc.php");
require_once('std/errorhandler.inc.php');
require_once('conf/defines.inc.php');
require_once("conf/conf.inc.php");  

$db_type = confGet('DB_TYPE');
if(file_exists("db/db_".$db_type."_class.php")){
    require_once(confGet('DIR_STREBER') . "db/db_".$db_type."_class.php");
}
else{
    trigger_error("Datebase handler not found for db-type '$db_type'", E_USER_ERROR);
}

require_once("std/mail.inc.php");

 /**
 *
 * Bogus function so that std/mail.inc.php doesn't redirect us to index.php
 *
 */
function startedIndexPhp() 
{ 
	 return false;
}

$notifier = new Notifier();
if(is_object($notifier))
{
	$notifier->sendNotifications();
	echo("<p>::std::Notifier->sendNotifications() called.</p>\n");
}

echo("<p>::cron.php run complete.</p>\n");
  
  
