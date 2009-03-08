<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html


require_once(confGet('DIR_STREBER') . './db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . './db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . './db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . './db/db_item.inc.php');
require_once(confGet('DIR_STREBER') . './db/db_itemperson.inc.php');
//require_once(confGet('DIR_STREBER') . 'render/render_misc.inc.php');


class Notifier
{

    /**
    * go through all accounts and collect information
    *
    * returns array of count of... [$num_notification_sent, $num_warnings]
    */
    public function sendNotifications()
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
                        $result= $this->sendNotifcationForPerson($p);
                        if($result) {
                            ### reset activation-flag ###
                            $p->settings &= USER_SETTING_SEND_ACTIVATION ^ RIGHT_ALL;
                            $p->notification_last= gmdate("Y-m-d H:i:s");
                            $p->update();
                            if($result === true) {
                                $num_notifications_sent++;
                            }
                            else {
                                $num_warnings++;
                                new FeedbackWarning(sprintf(__('Failure sending mail: %s'), $result));
                            }
                        }
                    }
                }
            }
        }
        return array($num_notifications_sent, $num_warnings);
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
		$subject = sprintf(__('Updates at %s','notification mail subject'), confGet('SELF_DOMAIN'));
		
		### message ###
        $message_txt= '';
        $message_html= '';

		$message_html.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\r\n<html>\r\n"
                . "<head>\r\n"
                . "<meta content=\"text/html;charset=UTF-8\" http-equiv=\"Content-Type\">\r\n"
                . "<title>$subject</title>\r\n"
                . "<style>\r\n \r\n\r\n h4 {font-size:11pt;}\r\n li{ margin-bottom:0.2em; } ul {margin:0; padding:0px 0px 0px 1em;}li span.details { font-size: 10pt; color: #888}\r\n</style>\r\n"
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
            $headline_html= "<h3>\r\n"
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
		
		### changed and unchanged items ###
		{
			## All changed items ##
		 	$changes_headline_html = '';
        	$changes_headline_txt = '';
			$changes_message_html = '';
        	$changes_message_txt = '';
			
			$monitored_items = ItemPerson::getAll(array(
			                   'is_bookmark'=>1,
							   'notify_on_change'=>1,
							   'person'=>$person->id));
							   
			if($monitored_items){
				$changes_headline_html = "<h3>"
                     . __('Changed monitored items:','notification')
                     . "</h3>"
                     . "<ul>";
            	$changes_headline_txt = "\n". __('Changed monitored items:','notification')."\n";
								
				foreach($monitored_items as $mi){
					if($pi = DbProjectItem::getById($mi->item)){
						if(strToGMTime($pi->modified) > strToGMTime($person->notification_last)){
							if($pi->modified_by != $auth->cur_user->id){
								$information_count++;
								$p = Person::GetVisibleById($pi->modified_by);
								$object = DbProjectItem::getObjectById($pi->id);
								$changes_message_html .= '<li>' . sprintf(__("%s edited > %s"), $p->nickname, $object->name) . '</li>';
								$changes_message_txt .= '- ' . sprintf(__("%s edited > %s"), $p->nickname, $object->name) . '\n';
							}
						}
					}
				}
				if($changes_message_html != ''){
					$changes_message_html .= "</ul>";
					$changes_message_txt .= "\n";
				}
			}
			
			## All unchanged items ##
			$unchanged_headline_html = '';
        	$unchanged_headline_txt = '';
			$unchanged_message_html = '';
        	$unchanged_message_txt = '';
			
			$monitored_items_unchanged = ItemPerson::getAll(array(
			                           'is_bookmark'=>1,
							           'notify_if_unchanged_min'=>NOTIFY_1DAY,
							           'person'=>$person->id));
							   
			if($monitored_items_unchanged){
				
				$unchanged_headline_html = "<h3>"
                     . __('Unchanged monitored items:','notification')
                     . "</h3>" 
                     . "<ul>";
            	$unchanged_headline_txt = "\n". __('Unchanged monitored items:','notification')."\n";
												
				foreach($monitored_items_unchanged as $miu){
					## reminder period ##
					$period = '';
					switch($miu->notify_if_unchanged){
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
					
					$date = $miu->notify_date;
					
					if($pi = DbProjectItem::getVisibleById($miu->item)){
						#if(strToGMTime($pi->modified) > strToGMTime($person->notification_last)){
							$mod_date = $pi->modified;
							if($date != '0000-00-00 00:00:00'){
								$date = strToGMTime($date) + $period;
								$date = date('Y-m-d H:i:s',$date);
								if(($date >= $mod_date) && (strToGMTime($date) <= time())){
									$diff = strToGMTime($date) - strToGMTime($mod_date);
									if($diff >= $period){
										### diff in days ###
										$information_count++;
										$days = round((time() - strToGMTime($miu->notify_date)) / 60 / 60 / 24);
										$object = DbProjectItem::getObjectById($pi->id);
										
										$unchanged_message_html .= '<li>' . sprintf(__("%s (not touched since %s day(s))"), asHtml($object->name), $days) . '</li>';
										$unchanged_message_txt .= '- ' . sprintf(__("%s (not touched since %s day(s))"), $object->name, $days) . '\n';
									}
								}
							}
						#}
					}
				}
				if($unchanged_message_html != ''){
					$unchanged_message_html .= "</ul>";
					$unchanged_message_txt .= "\n";
				}
			}
		}
		if($changes_message_html != ''){
			$message_html .= $changes_headline_html . $changes_message_html;
			$message_txt .= $changes_headline_txt . $changes_message_txt;
		}
		if($unchanged_message_html != ''){
			$message_html .= $unchanged_headline_html . $unchanged_message_html;
			$message_txt .= $unchanged_headline_txt . $unchanged_message_txt;
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

                    ### task
                    if($c->item && $c->item->type == ITEM_TASK) {
                        $task= $c->item;
                        //@TODO is to expensive to call this function in a for each loop. I suggest a local variable at mail.inc.php#line76
                        if(confGet('USE_MOD_REWRITE')) {
                		  $updates_html.= "<a href='$url{$task->id}'>". asHtml($task->name). "</a>";
                		}
                		else {
                		  $updates_html.= "<a href='$url?go=taskView&amp;tsk={$task->id}'>". asHtml($task->name). "</a>";
                		}
                        $updates_txt.= $task->name;
                    }
                    else if ($c->item && $c->item->type == ITEM_FILE) {
                        $file= $c->item;
                        if(confGet('USE_MOD_REWRITE')) {
                		  $updates_html.= "<a href='$url{$file->id}'>". asHtml($file->name). "</a>";
                		}
                		else {
                		  $updates_html.= "<a href='$url?go=fileView&amp;tsk={$file->id}'>". asHtml($file->name). "</a>";
                		}
                        $updates_txt.= $file->name;                        
                    }

                    $updates_html.= '<br><span class="details">';		# invisible user
                    $updates_txt.= "\r\n";		# invisible user
                    
                    ### what...
                    if($c->html_what) {
                        $updates_html.= $c->html_what. ' ';
                        $updates_txt.= isset($c->txt_what)
                                    ? $c->txt_what
                                    : strip_tags($c->html_what);
                    }

                    $updates_html.= ' ' . __("by") . ' ';		# invisible user
                    $updates_txt .= ' ' . __("by") . ' ';		# invisible user

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
                        	$updates_txt .= '???: ';		# invisible user
                        }
                    }

                    ### when...
                    if($c->timestamp) {
                        $updates_html.=  ' - ' . renderTimestamp($c->timestamp);
                        $updates_txt .=  ' - ' . renderTimestamp($c->timestamp);
                    }

                    ### to...
                    /**
                    * @@@ bug: this contains internal links that can be viewed from mail
                    **/
                    if($c->html_assignment) {
                        $updates_html.= ' ('.$c->html_assignment. ') ';
                        #$updates_txt.= ' '.$c->html_assignment. ' ';
                    }
                    $updates_html.="</span></li>\r\n";
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
              "<br><span class=\"details\">\r\n"
              .__('Forgot your password or how to log in?','notification'). '<br>'
              . "<a href='$url?go=loginForgotPasswordSubmit&amp;login_name={$person->nickname}'>"
              . __('Request a mail to change your account settings.','notification')
              . "</a></span>"
              . "."
              . "<br>\r\n"
              . "<br>\r\n"
              .__('Thanks for your time','notification') . "<br>\r\n"
              .__('the management', 'notification') . "\r\n";

            $message_txt.= ''
              .__('Forgot your password or how to log in?','notification'). ' '
              .__("Click here:") . ' ' . "$url?go=loginForgotPasswordSubmit&amp;login_name={$person->nickname}"
              . "\n"
              . "\n"
              .'  ' . __('Thanks for your time','notification') . "\n"
              .'  ' . __('the management', 'notification');

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
        //@TODO this must display APP_NAME title.
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
        $subject = __('Your account at','notification') . " " . $from_domain;

        ### message ###
        $message= "";

        $html_format = true;
        if($html_format) {
            $message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\r\n"
            ."<html>\r\n"
            ."<head>\r\n"
            ."<title>$subject</title>\r\n"
            . "</head>\r\n"
            ."<body text=\"#000000\" link=\"#163075\" alink=\"#ff0000\" vlink=\"#2046AA\">\r\n"
            . sprintf(__('Hello %s,','notification'), asHtml($person->name)) . "<br><br>\r\n";

            ### new account ###
            $message.= sprintf(__('Your account at %s is still active.','notification'), "<a href='" . $url ."'>" . confGet('SELF_DOMAIN')."</a>") . "<br>\r\n"
            .__('Your login name is','notification') . " '" . $person->nickname . "'<br>\r\n"
            . __('Please use this link to') 
            .' ' 
            . "<a href=\"" . $url . "?go=activateAccount&tuid=" . $person->identifier . "\">"
            . __('update your account settings')
            . "</a>...<br>\r\n";

            ### footer ####
            {
                $message.= "<br>\r\n"
                ."<br>\r\n"
                .__('Thanks for your time','notification') . "<br>\r\n"
                .__('the management', 'notification') . "\r\n";
            }

            $message.="\r\n"
            ."</body>\r\n"
            ."</html>";
        }

        ### headers  ###
        $headers="";
        if($html_format) {
            $headers .= "From: $from\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
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
 
}

?>
