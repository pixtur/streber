<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php5 based project management system  (c) 2005 Thomas Mann / thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in lang/license.html


require_once(confGet('DIR_STREBER') . './db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . './db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . './db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . './db/db_itemperson.inc.php');
//require_once(confGet('DIR_STREBER') . 'render/render_misc.inc.php');


class Notifier
{

    /**
    * go through all accounts and collect information
    */
    public function sendNotifications()
    {
        global $PH;
    	$persons=Person::getPersons(array('visible_only'=>false, 'can_login'=>true));

        foreach($persons as $p) {

            if($p->settings & USER_SETTING_NOTIFICATIONS) {

                if($p->office_email  || $p->personal_email )  {
                    $now= time();
                    $last= strToGMTime($p->notification_last);
                    $period= $p->notification_period * 60*60*24;

                    if(strToGMTime($p->notification_last) + $period  < time()) {

                        $result= $this->sendNotifcationForPerson($p);
                        if($result) {
                            if($result === true) {
                                $p->notification_last= gmdate("Y-m-d H:i:s");

                                ### reset activation-flag ###
                                $p->settings &= USER_SETTING_SEND_ACTIVATION ^ RIGHT_ALL;
                                $p->notification_last= gmdate("Y-m-d H:i:s");
                                $p->update();

                            }
                            else  {
                                ### reset activation-flag ###
                                $p->settings &= USER_SETTING_SEND_ACTIVATION ^ RIGHT_ALL;
                                $p->notification_last= gmdate("Y-m-d H:i:s");
                                $p->update();
	                            new FeedbackWarning(sprintf(__('Failure sending mail: %s'), $result));
                            }
                        }
                    }
                }
            }
        }
    }



    /**
    * returns:
    *   number of changes since notification_last
    *   0 - if nothing happend and no mail has been send
    *
    * person->last_notification is NOT been updated
    *
    * NOTE some tips used from Jon Webb [Madrid&London]
    *                          http://www.php.net/manual/en/ref.mail.php#61644
    *
    */
    public function sendNotifcationForPerson($person)
    {
        $information_count = 0;
        $from_domain = confGet('SELF_DOMAIN');
        $url= confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');

        /**
        * remove script name if clean urls.
        */
        if(confGet('USE_MOD_REWRITE')) {
            $url= str_replace('index.php','',$url);
        }

        /**
        * temporary overwrite the current-user to obey item-visibility
        * MUST BE RESET BEFORE LEAVING THIS FUNCTION!
        */
        global $auth;
        $keep_cur_user= $auth->cur_user;
        $auth->cur_user= $person;

        setLang($person->language);


        ### from-address  ###
        $from = __('Streber Email Notification','notifcation mail from') . " <do-not-reply@".$from_domain.">";

		### reply-addres? ###
		$reply="do-not-reply@$from_domain";

        if($person->office_email) {
            $to= $person->office_email;
        }
        else if($person->personal_email) {
            $to= $person->personal_email;
        }
        else {
            if(isset($auth->cur_user->language)) {
                setLang($auth->cur_user->language);
            }
            $auh->cur_user = $keep_cur_user;
            return _('no mail for person','notification');
        }

		### subject ###
		$subject = sprintf(__('Updates at %s','notication mail subject'), confGet('SELF_DOMAIN'));

		### message ###
        $message_txt= '';
        $message_html= '';

		$message_html.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\r\n<html>\r\n"
                . "<head>\r\n"
                . "<meta content=\"text/html;charset=UTF-8\" http-equiv=\"Content-Type\">\r\n"
                . "<title>$subject</title>\r\n"
                . "<style>\r\n body {background-color:#ffffff; color:#000000; font-family:\"Trebuchet MS\", Tahoma, Arial, Verdana,sans-serif; font-size:10pt;}\r\n a {color:#163075; text-decoration:none;}\r\n a:hover{color:#ff0000; text-decoration:underline;}\r\n h3 {font-size:12pt;}\r\n h4 {font-size:11pt;}\r\n ul {margin:0; padding:0px 0px 0px 1em;}\r\n</style>\r\n"
                . "</head>\r\n"
                . "<body text=\"#000000\" link=\"#163075\" alink=\"#ff0000\" vlink=\"#2046AA\">\r\n"
                . sprintf(__('Hello %s,','notification'), asHtml($person->name))
                . "<br><br>\r\n"
                . __('with this automatically created e-mail we want to inform you that', 'notification')
                . "<br>\r\n";
        $message_txt.= sprintf(__('Hello %s,','notification'), $person->name)
                    . "\n\n"
                    . __('with this automatically created e-mail we want to inform you that', 'notification')
                    . "\n";

        if($person->notification_last) {
            $message_html.= sprintf(__('since %s'), renderDate($person->notification_last, false) ). ' ';
            $message_txt.= sprintf(__('since %s'), renderDate($person->notification_last, false) ). ' ';
        }

        $message_html.= sprintf(__('following happened at %s ','notification'),
                         "<a href='" . $url ."'>" . confGet('SELF_DOMAIN')."</a>"
                   )
                . "<br>\r\n";
        $message_txt.= sprintf(__('following happened at %s ','notification'),confGet('SELF_DOMAIN'))
                    ."\n";

        ### new account ###
        if($person->settings & USER_SETTING_SEND_ACTIVATION) {
            $message_html.= __('Your account has been created.','notification')
                    . "<a href='$url?go=activateAccount&tuid={$person->identifier}'>"
                    . __('Please set a password to activate it.','notification')
                    . "</a><br>\r\n";

            $message_txt.= __('Your account has been created.','notification')
                    . " "
                    . __('Please set a password to activate it.','notification')
                    . "\n "
                    . $url."?go=activateAccount&tuid={$person->identifier}"
                    . "\n\n";

            $information_count++;
        }

        ### recently assigned to projects ###
        $projects= array();
        {
            $headline_html= "<h3>/r/n"
                     . __('You have been assigned to projects:','notification')
                     . "</h3>\r\n"
                     . "<ul>\r\n";
            $headline_txt= "\n". __('You have been assigned to projects:','notification')."\n";

            $close_list_html= '';
            $close_list_txt= '';


            $pps= $person->getProjectPersons();
            foreach($pps as $pp) {
                if($project= Project::getVisibleById($pp->project)) {
                    if($project->state) {
                        $projects[]= $project;
                        if(strToGMTime($pp->created) > strToGMTime($person->notification_last)) {
                            $message_html.= $headline_html;
                            $message_txt.= $headline_txt;
                            $message_html.="<li>";
                            if(confGet('USE_MOD_REWRITE')) {
                                $message_html.= "<a href='$url{$pp->project}'>". asHtml($project->name) ."</a>";
                            }
                            else {
                                $message_html.= "<a href='$url?go=projView&prj={$pp->project}'>". asHtml($project->name) ."</a>";
                            }
                            $message_html. "</li>\r\n";
                            $message_txt.= "- ". $project->name. "\n";

                            $headline_html='';
                            $headline_txt='';
                            $close_list_html= "</ul>\r\n";
                            $close_list_txt= "\n";
                            $information_count++;
                        }
                    }
                }
            }
            $message_html.= $close_list_html;
            $message_txt.= $close_list_txt;
        }


        ### list project changes ###
        require_once(confGet('DIR_STREBER') . './lists/list_changes.inc.php');

        $updates_html='';
        $updates_txt='';

        foreach($projects as $p) {
            if($changes= ChangeLine::getChangeLinesForPerson($person,$p, $person->notification_last)) {
                $information_count++;
                $updates_html.= "<h4>\r\n";
                if(confGet('USE_MOD_REWRITE')) {
                    $updates_html.="<a href='$url{$p->id}'>". asHtml($p->name) ."</a>";
                }
                else {
                    $updates_html.="<a href='$url?go=projView&amp;prj={$p->id}'>". asHtml($p->name) ."</a>";
                }


                $updates_html.= "</h4>\r\n<ul>\r\n";
                $updates_txt.= "\n". $p->name."\n";

                foreach($changes as $c) {
                    $updates_html.="<li>";
                    $updates_txt.="\n- ";

                    ### who...
                    if($c->person_by) {
                        if($p_who= Person::getVisibleById($c->person_by)) {
                    		$updates_html.= "<b>". asHtml($p_who->nickname) ."</b>"
                    		      ." ";
                    		$updates_txt.= $p_who->nickname
                    		      .": ";

                        }
                        else {
                        	$updates_html.= '??? ';		# invisible user
                        	$updates_txt.= '???: ';		# invisible user
                        }
                    }

                    ### what...
                    if($c->html_what) {
                        $updates_html.= $c->html_what. ' ';
                        $updates_txt.= isset($c->txt_what)
                                    ? $c->txt_what
                                    : strip_tags($c->html_what);
                    }

                    ### when...
                    if($c->timestamp) {
                        $updates_html.= renderTimestamp($c->timestamp) . ': ';
                        $updates_txt.= isset($c->timestamp)
                                    ? ' ' . renderTimestamp($c->timestamp)
                                    : ' ' . strip_tags(renderTimestamp($c->timestamp));
                        $updates_txt.=' > ';
                    }

                    ### task
                    if($task= Task::getVisibleById($c->task_id)) {
                        if(confGet('USE_MOD_REWRITE')) {
                		  $updates_html.= "<a href='$url{$task->id}'>". asHtml($task->name). "</a>";
                		}
                		else {
                		  $updates_html.= "<a href='$url?go=taskView&amp;tsk={$task->id}'>". asHtml($task->name). "</a>";
                		}
                        $updates_txt.= $task->name;
                    }

                    ### to...
                    /**
                    * @@@ bug: this contains internal links that can be viewed from mail
                    **/
                    if($c->html_assignment) {
                        $updates_html.= ' ('.$c->html_assignment. ') ';
                        #$updates_txt.= ' '.$c->html_assignment. ' ';
                    }
                    $updates_html.="</li>\r\n";
                    $updates_txt.="\n";

                }
                $updates_html.="</ul>\r\n";
                $updates_txt.="\n";
            }
        }
        if($updates_html) {
            $message_html.="<h3>". __('Project Updates'). "</h3>\r\n"
                    . $updates_html;
            $message_txt.= "\n== ". __('Project Updates'). " ==\n"
                    . $updates_txt;

        }


        ### footer ####
        {
            $message_html.=
              "<br>\r\n"
              .__('If you do not want to get further notifications or you forgot your password feel free to','notification'). ' '
              . "<a href='$url/index.php?go=activateAccount&amp;tuid={$person->identifier}'>"
              . __('adjust your profile','notification')
              . "</a>"
              . "."
              . "<br>\r\n"
              . "<br>\r\n"
              .__('Thanks for your time','notication') . "<br>\r\n"
              .__('the management', 'notication') . "\r\n";

            $message_txt.= ''
              . __('If you do not want to get further notifications or you forgot your password feel free to','notification')
              . ' '
              . __('adjust your profile','notification')
              . ":\n"
              . $url."/index.php?go=activateAccount&tuid={$person->identifier}"
              . "\n"
              . "\n"
              .'  ' . __('Thanks for your time','notication') . "\n"
              .'  ' . __('the management', 'notication');

        }

        $message_html.="</body>\r\n"
                . "</html>";


        if($smtp= confGet('SMTP')) {
            ini_set('SMTP', $smtp);
        }
        if($information_count) {


            /**
            *
            * using some t
            */
            if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
              $eol="\r\n";
            }
            elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
              $eol="\r";
            }
            else {
              $eol="\n";
            }


            $boundary= "-streber--------------------------------------";
    		### headers  ###
    		#$headers = "Return-Path: <$reply>\r\n";
    		$headers="";
		    #$headers .= "Content-Type: text/html; charset=UTF-8\r\n"
            #$headers .= "Content-Type: multipart/related; boundary=\"".$boundary."\"".$eol;
            $headers .= "Content-Type: multipart/alternative; boundary=\"".$boundary."\"".$eol;
		    #$headers .= "Content-type: multipart/alternative;". $eol
            #         .  " boundary=\"$boundary\"". $eol;
            $headers .= "From: $from". $eol;
            $headers .= 'MIME-Version: 1.0'.$eol;

            $msg     = "Content-Type: multipart/alternative".$eol;
            $msg    .= "This is a multipart message".$eol
                    . "--".$boundary. $eol
                    . "Content-Type: text/plain; charset=UTF-8". $eol. $eol
                    . $message_txt
                    . $eol
                    . "--".$boundary.$eol
                    . "Content-Type: text/html; charset=UTF-8". $eol
                    . $eol
                    . $message_html
                    . $eol
                    . "--".$boundary."--". $eol.$eol
                    ;


    		### just do it ###
    		/**
    		* NOTE: capturing error-output of mail is done in errorhandler.inc,
    		* it sets the global variable $g_error_mail
    		*/

            if(isset($auth->cur_user->language)) {
                setLang($auth->cur_user->language);
            }

            mail($to, $subject, $msg, $headers);

            global $g_error_mail;
            if(isset($g_error_mail)) {
                $error= $g_error_mail. ' ("'. $to. '" <'. $person->name .'>)';
                $error=asHtml($error);
                $g_error_mail=NULL;
                $auth->cur_user= $keep_cur_user;
                return $error;
            }
            else {
                $auth->cur_user= $keep_cur_user;
                return true;
            }
    	}
    	else {
    	   new FeedbackMessage(sprintf(__('No news for <b>%s</b>'), $person->name));
            if(isset($auth->cur_user->language)) {
                setLang($auth->cur_user->language);
            }
    	}
        $auth->cur_user= $keep_cur_user;
        return NULL;
    }


    /**
    * returns:
    *   number of changes since notification_last
    *   0 - if nothing happend and no mail has been send
    */
    public function sendPasswordReminder($person)
    {
        $url= confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');
        $from_domain = confGet('SELF_DOMAIN');;

        /**
        * temporary overwrite the current-user to obey item-visibility
        * MUST BE RESET BEFORE LEAVING THIS FUNCTION!
        */
        global $auth;
        $keep_cur_user= $auth->cur_user;
        $auth->cur_user= $person;

        setLang($person->language);

        ### from-address  ###
        $from = __('Streber Email Notification','notifcation mail from') . " <do-not-reply@".$from_domain.">";

        ### reply-addres? ###
        $reply="do-not-reply@$from_domain";

        $to ="";
        if($person->office_email) {
            $to= $person->office_email;
        }
        else if($person->personal_email) {
            $to= $person->personal_email;
        }
        else {
            if(isset($auth->cur_user->language)) {
                setLang($auth->cur_user->language);
            }
            $auh->cur_user = $keep_cur_user;
            return _('no mail for person','notification');
        }

        ### subject ###
        $subject = __('Your account at','notification') . " " . $url;

        ### message ###
        $message= "";

        $html_format = true;
        if($html_format) {
            $message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\r\n"
            ."<html>\r\n"
            ."<head>\r\n"
            ."<title>$subject</title>\r\n"
            ."<style>\r\n body {background-color:#ffffff; color:#000000; font-family:\"Trebuchet MS\", Tahoma, Arial, Verdana,sans-serif; font-size:10pt;}\r\n a {color:#163075; text-decoration:none;}\r\n a:hover{color:#ff0000; text-decoration:underline;}\r\n h3 {font-size:12pt;}\r\n h4 {font-size:11pt;}\r\n ul {margin:0; padding:0px 0px 0px 1em;}\r\n</style>\r\n"
            . "</head>\r\n"
            ."<body text=\"#000000\" link=\"#163075\" alink=\"#ff0000\" vlink=\"#2046AA\">\r\n"
            .sprintf(__('Hello %s,','notification'), asHtml($person->name)) . "<br><br>\r\n";

            ### new account ###
            $message.= sprintf(__('Your account at %s is still active.','notification'), "<a href='" . $url ."'>" . confGet('SELF_DOMAIN')."</a>") . "<br>\r\n"
            .__('Your login name is','notification') . " " . $person->nickname . "<br>\r\n"
            .sprintf(__('Maybe you want to %s set your password','notification'), "<a href=\"" . $url . "?go=activateAccount&tuid=" . $person->identifier . "\">") . "</a>...<br>\r\n";

            ### footer ####
            {
                $message.= "<br>\r\n"
                ."<br>\r\n"
                .__('Thanks for your time','notication') . "<br>\r\n"
                .__('the management', 'notication') . "\r\n";
            }

            $message.="\r\n"
            ."</body>\r\n"
            ."</html>";
        }

        ### headers  ###
        $headers="";
        if($html_format) {
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: $from\r\n";
        }


        ### just do it ###
        mail($to, $subject, $message, $headers);

        global $g_error_mail;
        if(isset($g_error_mail))         {
            trigger_error($g_error_mail, E_USER_WARNING);
            $auth->cur_user= $keep_cur_user;
            return $g_error_mail;
        }
        $auth->cur_user= $keep_cur_user;
    }
    
     public function outputNotifcationForPersonTXT($person)
     {
        $information_count = 0;
        $url= confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');
     
        /**
        * temporary overwrite the current-user to obey item-visibility
        * MUST BE RESET BEFORE LEAVING THIS FUNCTION!
        */
        global $auth;
        $keep_cur_user= $auth->cur_user;
        $auth->cur_user= $person;

        setLang($person->language);


       	### message ###
        $message_txt= '';
        $message_html= '';

        ### recently assigned to projects ###
        $projects= array();
        {
            $headline_html= '<h3>'
                     . __('You have been assigned to projects:','notification')
                     . '</h3>'
                     . '<ul>';
            $headline_txt= "\n". __('You have been assigned to projects:','notification')."\n";

            $close_list_html= '';
            $close_list_txt= '';


            $pps= $person->getProjectPersons();
            foreach($pps as $pp) {
                if($project= Project::getVisibleById($pp->project)) {
                    if($project->state) {
                        $projects[]= $project;
                        if(strToGMTime($pp->created) > strToGMTime($person->notification_last)) {
                            $message_html.= $headline_html;
                            $message_txt.= $headline_txt;
                            $message_html.="<li>"
                                    . "<a href='$url?go=projView&prj={$pp->project}'>". asHtml($project->name) ."</a>"
                                    . "</li>";
                            $message_txt.= "- ". $project->name. "\n";

                            $headline_html='';
                            $headline_txt='';
                            $close_list_html= '</ul>';
                            $close_list_txt= "\n";
                            $information_count++;
                        }
                    }
                }
            }
            $message_html.= $close_list_html;
            $message_txt.= $close_list_txt;
        }


        ### list project changes ###
        require_once('lists/list_changes.inc.php');

        $updates_html='';
        $updates_txt='';

        foreach($projects as $p) {
            if($changes= ChangeLine::getChangeLinesForPerson($person,$p, $person->notification_last)) {
                $information_count++;
                $updates_html.= '<h4>'
                        . "<a href='$url?go=projView&amp;prj={$p->id}'>". asHtml($p->name) ."</a>"
                        . '</h4><ul>';

                $updates_txt.= "\n". $p->name."\n";

                foreach($changes as $c) {
                    $updates_html.='<li>';
                    $updates_txt.="\n- ";

                    ### who...
                    if($c->person_by) {
                        if($p_who= Person::getVisibleById($c->person_by)) {
                    		$updates_html.= "<b>". asHtml($p_who->nickname) ."</b>"
                    		      ." ";
                    		$updates_txt.= $p_who->nickname
                    		      .": ";

                        }
                        else {
                        	$updates_html.= '??? ';		# invisible user
                        	$updates_txt.= '???: ';		# invisible user
                        }
                    }

                    ### what...
                    if($c->html_what) {
                        $updates_html.= $c->html_what. ' ';
                        $updates_txt.= isset($c->txt_what)
                                    ? $c->txt_what
                                    : strip_tags($c->html_what);
                        $updates_txt.=' > ';
                    }



                    ### task
                    if($task= Task::getVisibleById($c->task_id)) {
                		$updates_html.= "<a href='$url?go=taskView&amp;tsk={$task->id}'>". asHtml($task->name). "</a>";
                        $updates_txt.= $task->name;
                    }

                    ### to...
                    /**
                    * @@@ bug: this contains internal links that can be viewed from mail
                    **/
                    if($c->html_assignment) {
                        $updates_html.= ' ('.$c->html_assignment. ') ';
                        #$updates_txt.= ' '.$c->html_assignment. ' ';
                    }
                }
                $updates_html.='</ul>';
                $updates_txt.="\n\n";
            }
        }
        if($updates_html) {
            $message_html.='<h3>'. __('Project Updates'). '</h3>'
                    . $updates_html;
            $message_txt.= "\n== ". __('Project Updates'). " ==\n"
                    . $updates_txt;

        }

        if($information_count) {
			return $message_txt;
			// NEWS
    	} else {
    		return NULL;
    	   // no news
    	}
        $auth->cur_user= $keep_cur_user;
        return NULL;
    }
	
	/*
	* Check if a notification email should be send
	*/
	public function checkItemNotification(){
		if($ip = ItemPerson::getAll(array('notify_if_unchanged_min'=>NOTIFY_1DAY))){
			foreach($ip as $p){
				if($i = DbProjectItem::getById($p->item)){
					$mod_date = $i->modified;
					$period = '';
					switch($p->notify_if_unchanged){
						case NOTIFY_1DAY:
							$period = 24*60*60;
							break;
						case NOTIFY_2DAYS:
							$period = 2*24*60*60;
							break;
						case NOTIFY_3DAYS:
							$period = 3*24*60*60;
							break;
						case NOTIFY_4DAYS:
							$period = 4*24*60*60;
							break;
						case NOTIFY_5DAYS:
							$period = 5*24*60*60;
							break;
						case NOTIFY_1WEEK:
							$period = 7*24*60*60;
							break;
						case NOTIFY_2WEEKS:
							$period = 2*7*24*60*60;
							break;
						case NOTIFY_3WEEKS:
							$period = 3*7*24*60*60;
							break;
						case NOTIFY_1MONTH:
							$period = 4*7*24*60*60;
							break;
						case NOTIFY_2MONTH:
							$period = 2*4*7*24*60*60;
							break;
					}
					
					$date = $p->notify_date;
					
					if($date != '0000-00-00 00:00:00'){
						$date = strToGMTime($date) + $period;
						$date = date('Y-m-d H:i:s',$date);
						
						if(($date >= $mod_date) && (strToGMTime($date) <= time())){
							$diff = strToGMTime($date) - strToGMTime($mod_date);
							if($diff >= $period){
								$this->sendReminderOnItem($i, $p->notify_date);
							}
						}
					}
				}
			}
		}
		else{
			return NULL;
		}
	}
	
	public function sendReminderOnItem($item, $date){
		global $auth;
		
		$from_domain = confGet('SELF_DOMAIN');
		$url = confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');
	
		/**
		* remove script name if clean urls.
		*/
		if(confGet('USE_MOD_REWRITE')) {
			$url = str_replace('index.php','',$url);
		}
		
		### gets the name of the item ###
		$itemname = '';
		$item_type = $item->type;
		switch($item_type){
			case ITEM_TASK:
				require_once("db/class_task.inc.php");
				if($task = Task::getVisibleById($item->id)) {
					$itemname = $task->name;
				}
				break;

			case ITEM_COMMENT:
				require_once("db/class_comment.inc.php");
				if($comment = Comment::getVisibleById($item->id)) {
					$itemname = $comment->name;
				}
				break;

			case ITEM_PERSON:
				require_once("db/class_person.inc.php");
				if($person = Person::getVisibleById($item->id)) {
					$itemname = $person->name;
				}
				break;

			case ITEM_EFFORT:
				require_once("db/class_effort.inc.php");
				if($e = Effort::getVisibleById($item->id)) {
					$itemname = $e->name;
				}
				break;

			case ITEM_FILE:
				require_once("db/class_file.inc.php");
				if($f = File::getVisibleById($item->id)) {
					$itemname = $f->org_filename;
				}
				break;

			case ITEM_PROJECT:
				require_once("db/class_project.inc.php");
				if($prj = Project::getVisibleById($item->id)) {
					$itemname = $prj->name;
				}
				break;

			case ITEM_COMPANY:
				require_once("db/class_company.inc.php");
				if($c = Company::getVisibleById($item->id)) {
					$itemname = $c->name;
				}
				break;

			case ITEM_VERSION:
				require_once("db/class_task.inc.php");
				if($tsk = Task::getVisibleById($item->id)) {
					$itemname = $tsk->name;
				}
				break;

			default:
				break;
		}
		
		### diff in days ###
		$days = round((time() - strToGMTime($date)) / 60 / 60 / 24);
		
		### from-address  ###
		$from = __('Unchanged item','notifcation mail from') . " <do-not-reply@".$from_domain.">";
		
		### reply-address ###
		$reply = "do-not-reply@$from_domain";
		
		### to-address ###
		$to = '';
		$ok = false;
		
		if($p = Person::getById($auth->cur_user->id)){
			if($p->office_email){
				$to .= $p->office_email;
				$ok = true;
			}
			else if ($p->personal_email){
				$to .= $p->personal_email;
				$ok = true;
			}
		}
		else{
			new FeedbackMessage(__('No emails sent.'));
			return;
		}
		
		if($to != ''){
			### subject ###
			$subject = sprintf(__('No changes since %s (%s day(s)) on: %s','notification mail subject'), $date, $days, $itemname);
	
			### message text ###
			$message_txt= '';
			$message_html= '';
			
			$message_html.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\r\n<html>\r\n"
					. "<head>\r\n"
					. "<meta content=\"text/html;charset=UTF-8\" http-equiv=\"Content-Type\">\r\n"
					. "<title>$subject</title>\r\n"
					. "<style>\r\n body {background-color:#ffffff; color:#000000; font-family:\"Trebuchet MS\", Tahoma, Arial, Verdana,sans-serif; font-size:10pt;}\r\n a {color:#163075; text-decoration:none;}\r\n a:hover{color:#ff0000; text-decoration:underline;}\r\n h3 {font-size:12pt;}\r\n h4 {font-size:11pt;}\r\n ul {margin:0; padding:0px 0px 0px 1em;}\r\n</style>\r\n"
					. "</head>\r\n"
					. "<body text=\"#000000\" link=\"#163075\" alink=\"#ff0000\" vlink=\"#2046AA\">\r\n"
					. __('The following item is unchanged:', 'notification')
					. "<li>" .$itemname. "</li>\n"
					. "<br>\r\n";
			$message_txt.= __('The following item is unchanged:', 'notification')
						. "- " .$itemname. ""
						. "\n";
						
			### mail ###
			if($smtp= confGet('SMTP')) {
				ini_set('SMTP', $smtp);
			}
			
			/**
			*
			* using some t
			*/
			if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
			  $eol="\r\n";
			}
			elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
			  $eol="\r";
			}
			else {
			  $eol="\n";
			}
	
			$boundary= "-streber--------------------------------------";
			### headers  ###
			$headers="";
			$headers .= "Content-Type: multipart/alternative; boundary=\"".$boundary."\"".$eol;
			$headers .= "From: $from". $eol;
			$headers .= 'MIME-Version: 1.0'.$eol;
	
			$msg     = "Content-Type: multipart/alternative".$eol;
			$msg    .= "This is a multipart message".$eol
					. "--".$boundary. $eol
					. "Content-Type: text/plain; charset=UTF-8". $eol. $eol
					. $message_txt
					. $eol
					. "--".$boundary.$eol
					. "Content-Type: text/html; charset=UTF-8". $eol
					. $eol
					. $message_html
					. $eol
					. "--".$boundary."--". $eol.$eol
					;
	
			mail($to, $subject, $msg, $headers);
		}
	}
	
	/*
	* If an monitored item get changed
	*/
	public function sendNotificationOnItem($item){ 
		global $auth;
		
		$from_domain = confGet('SELF_DOMAIN');
		$url = confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');
	
		/**
		* remove script name if clean urls.
		*/
		if(confGet('USE_MOD_REWRITE')) {
			$url = str_replace('index.php','',$url);
		}
		
		$itemname = $item->name;
		
		### from-address  ###
		$from = __('Notification on changed item','notification mail from') . " <do-not-reply@".$from_domain.">";
		
		### reply-address ###
		$reply = "do-not-reply@$from_domain";
		
		### to-address ###
		$to = '';
		$ok = false;
		
		if($ip = ItemPerson::getPersons($item->id,true)){
			for($i = 0; $i < count($ip); $i++){
				if($ip[$i]['person'] != $auth->cur_user->id){
					if(($i > 0) && ($ok = true)){
						$to .= ', ';
					}
					if($ip[$i]['office_email']){
						$to .= $ip[$i]['office_email'];
						$ok = true;
					}
					else if ($ip[$i]['personal_email']){
						$to .= $ip[$i]['personal_email'];
						$ok = true;
					}
					else{
						$to .= '';
						$ok = false;
					}
				}
			}
		}
		else{
			new FeedbackMessage(__('No emails sent.'));
			return;
		}
		
		if($to != ''){
			### subject ###
			$subject = sprintf(__('Changes on: %s','notification mail subject'), $itemname);
	
			### message text ###
			$message_txt= '';
			$message_html= '';
			
			$message_html.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\r\n<html>\r\n"
					. "<head>\r\n"
					. "<meta content=\"text/html;charset=UTF-8\" http-equiv=\"Content-Type\">\r\n"
					. "<title>$subject</title>\r\n"
					. "<style>\r\n body {background-color:#ffffff; color:#000000; font-family:\"Trebuchet MS\", Tahoma, Arial, Verdana,sans-serif; font-size:10pt;}\r\n a {color:#163075; text-decoration:none;}\r\n a:hover{color:#ff0000; text-decoration:underline;}\r\n h3 {font-size:12pt;}\r\n h4 {font-size:11pt;}\r\n ul {margin:0; padding:0px 0px 0px 1em;}\r\n</style>\r\n"
					. "</head>\r\n"
					. "<body text=\"#000000\" link=\"#163075\" alink=\"#ff0000\" vlink=\"#2046AA\">\r\n"
					. __('The following item was changed:', 'notification')
					. "<li>" .$itemname. "</li>\n"
					. "<br>\r\n";
			$message_txt.= __('The following item was changed:', 'notification')
						. "- " .$itemname. ""
						. "\n";
						
			### mail ###
			if($smtp= confGet('SMTP')) {
				ini_set('SMTP', $smtp);
			}
			
			/**
			*
			* using some t
			*/
			if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
			  $eol="\r\n";
			}
			elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
			  $eol="\r";
			}
			else {
			  $eol="\n";
			}
	
			$boundary= "-streber--------------------------------------";
			### headers  ###
			#$headers = "Return-Path: <$reply>\r\n";
			$headers="";
			#$headers .= "Content-Type: text/html; charset=UTF-8\r\n"
			#$headers .= "Content-Type: multipart/related; boundary=\"".$boundary."\"".$eol;
			$headers .= "Content-Type: multipart/alternative; boundary=\"".$boundary."\"".$eol;
			#$headers .= "Content-type: multipart/alternative;". $eol
			#         .  " boundary=\"$boundary\"". $eol;
			$headers .= "From: $from". $eol;
			$headers .= 'MIME-Version: 1.0'.$eol;
	
			$msg     = "Content-Type: multipart/alternative".$eol;
			$msg    .= "This is a multipart message".$eol
					. "--".$boundary. $eol
					. "Content-Type: text/plain; charset=UTF-8". $eol. $eol
					. $message_txt
					. $eol
					. "--".$boundary.$eol
					. "Content-Type: text/html; charset=UTF-8". $eol
					. $eol
					. $message_html
					. $eol
					. "--".$boundary."--". $eol.$eol
					;
	
			mail($to, $subject, $msg, $headers);
		}
	}
	
	/*
	* If an monitored item is not changed
	*/
	public function sendNotificationOnUnChangedItems(){ 
		global $auth;
		
		$from_domain = confGet('SELF_DOMAIN');
		$url = confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');
	
		/**
		* remove script name if clean urls.
		*/
		if(confGet('USE_MOD_REWRITE')) {
			$url = str_replace('index.php','',$url);
		}
		
		$itemname = $item->name;
		
		### from-address  ###
		$from = __('Notification on changed item','notification mail from') . " <do-not-reply@".$from_domain.">";
		
		### reply-address ###
		$reply = "do-not-reply@$from_domain";
		
		### to-address ###
		$to = '';
		$ok = false;
		if($ip = ItemPerson::getPersons($item->id,true)){
			for($i = 0; $i < count($ip); $i++){
				if($ip[$i]['person'] != $auth->cur_user->id){
					if(($i > 0) && ($ok = true)){
						$to .= ', ';
					}
					if($ip[$i]['office_email']){
						$to .= $ip[$i]['office_email'];
						$ok = true;
					}
					else if ($ip[$i]['personal_email']){
						$to .= $ip[$i]['personal_email'];
						$ok = true;
					}
					else{
						$to .= '';
						$ok = false;
					}
				}
			}
		}
		else{
			new FeedbackMessage(__('No emails sent.'));
			return;
		}
		
		if($to != ''){
			### subject ###
			$subject = sprintf(__('Changes on: %s','notification mail subject'), $itemname);
	
			### message text ###
			$message_txt= '';
			$message_html= '';
			
			$message_html.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\r\n<html>\r\n"
					. "<head>\r\n"
					. "<meta content=\"text/html;charset=UTF-8\" http-equiv=\"Content-Type\">\r\n"
					. "<title>$subject</title>\r\n"
					. "<style>\r\n body {background-color:#ffffff; color:#000000; font-family:\"Trebuchet MS\", Tahoma, Arial, Verdana,sans-serif; font-size:10pt;}\r\n a {color:#163075; text-decoration:none;}\r\n a:hover{color:#ff0000; text-decoration:underline;}\r\n h3 {font-size:12pt;}\r\n h4 {font-size:11pt;}\r\n ul {margin:0; padding:0px 0px 0px 1em;}\r\n</style>\r\n"
					. "</head>\r\n"
					. "<body text=\"#000000\" link=\"#163075\" alink=\"#ff0000\" vlink=\"#2046AA\">\r\n"
					. __('The following item was changed:', 'notification')
					. "<li>" .$itemname. "</li>\n"
					. "<br>\r\n";
			$message_txt.= __('The following item was changed:', 'notification')
						. "- " .$itemname. ""
						. "\n";
						
			### mail ###
			if($smtp= confGet('SMTP')) {
				ini_set('SMTP', $smtp);
			}
			
			/**
			*
			* using some t
			*/
			if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
			  $eol="\r\n";
			}
			elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
			  $eol="\r";
			}
			else {
			  $eol="\n";
			}
	
			$boundary= "-streber--------------------------------------";
			### headers  ###
			#$headers = "Return-Path: <$reply>\r\n";
			$headers="";
			#$headers .= "Content-Type: text/html; charset=UTF-8\r\n"
			#$headers .= "Content-Type: multipart/related; boundary=\"".$boundary."\"".$eol;
			$headers .= "Content-Type: multipart/alternative; boundary=\"".$boundary."\"".$eol;
			#$headers .= "Content-type: multipart/alternative;". $eol
			#         .  " boundary=\"$boundary\"". $eol;
			$headers .= "From: $from". $eol;
			$headers .= 'MIME-Version: 1.0'.$eol;
	
			$msg     = "Content-Type: multipart/alternative".$eol;
			$msg    .= "This is a multipart message".$eol
					. "--".$boundary. $eol
					. "Content-Type: text/plain; charset=UTF-8". $eol. $eol
					. $message_txt
					. $eol
					. "--".$boundary.$eol
					. "Content-Type: text/html; charset=UTF-8". $eol
					. $eol
					. $message_html
					. $eol
					. "--".$boundary."--". $eol.$eol
					;
	
			mail($to, $subject, $msg, $headers);
		}
	}

}

?>