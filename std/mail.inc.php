<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html


require_once(confGet('DIR_STREBER') . './db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . './db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . './db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . './db/db_item.inc.php');
require_once(confGet('DIR_STREBER') . './db/db_itemperson.inc.php');
require_once(confGet('DIR_STREBER') . './std/class_email_notification.inc.php');
//require_once(confGet('DIR_STREBER') . 'render/render_misc.inc.php');

define('LINE_BREAK', "\n");

class Notifier
{
    /**
    * go through all accounts and collect information
    *
    * returns array of count of... [$num_notification_sent, $num_warnings]
    */
    public static function sendNotifications()
    {
        global $PH;
        $persons=Person::getPersons(array('visible_only'=>false, 'can_login'=>true));

        $num_notifications_sent = 0;
        $num_warnings = 0;
        foreach($persons as $p) {
            if($p->settings & USER_SETTING_NOTIFICATIONS) {
                if($p->office_email  || $p->personal_email )  {
                    $now= time();
                    $last= strToGMTime($p->notification_last);
                    $period= $p->notification_period * 60*60*24;

                    if(strToGMTime($p->notification_last) + $period  < time() || $period == -1) {
                        $email= new EmailNotification($p);
                        $result= $email->send();
                        if($result === true ) {
                            ### reset activation-flag ###
                            $p->settings &= USER_SETTING_SEND_ACTIVATION ^ RIGHT_ALL;
                            $p->notification_last= gmdate("Y-m-d H:i:s");
                            $p->update();
                            $num_notifications_sent++;
                        }
                        else if ($result !== false) {
                            $num_warnings++;
                            new FeedbackWarning(sprintf(__('Failure sending mail: %s'), $result));
                        }
                    }
                }
            }
        }
        return array($num_notifications_sent, $num_warnings);
    }
}

?>
