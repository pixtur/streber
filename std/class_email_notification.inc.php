<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * This class composes a notification mail for a person
 *
 *
 * @author         Thomas Mann
 * @uses:           ListChanges
 * @usedby:

*/

require_once(confGet('DIR_STREBER') . './std/class_email.inc.php');


class EmailNotification extends Email
{
    public   $information_count;
    protected   $projects;
    protected   $projects_new;

    
    protected function initSubject() {
        $this->subject = sprintf(__('Updates at %s','notification mail subject'), confGet('SELF_DOMAIN'));
    }
        

    protected function initBody()
    {
        $this->information_count=0;

        $this->addIntroductionText();

        $this->addInvitationForNewAccounts();
        $this->initRecipientProjects();
        $this->addRecententAssignedProjects();
        
        $this->addChangesToBookmarkedItems();
        $this->addUntouchedMonitoredItems();
        $this->addRecentChanges();

        $this->addFooter();

        if($smtp= confGet('SMTP')) {
            ini_set('SMTP', $smtp);
        }
        else {
            new FeedbackMessage(sprintf(__('No news for <b>%s</b>'), $this->recipient->name));
        }
        #$this->resetCurrentUser();
    }
    

    private function addIntroductionText()
    {
        $this->body_html.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">"
                     . "<html>"
                     . "<head>"
                     . "<meta content=\"text/html;charset=UTF-8\" http-equiv=\"Content-Type\">"
                     . "<title>$this->subject</title>"
                     . "<style> div.details{color:#888888; font-size: 80%;} h4 {font-size:110%;} li{ margin-bottom:0.2em; } ul {margin:0; padding:0px 0px 0px 1em;} li span.details { font-size: 80%; color: #888} </style>"
                     . "</head>"
                     . "<body text=\"#000000\" link=\"#163075\" alink=\"#ff0000\" vlink=\"#2046AA\">"
                     . "<h2>". sprintf(__('Hello %s,','notification'), asHtml($this->recipient->name)) . "</h2>"
                     . __('with this automatically created e-mail we want to inform you that', 'notification')
                     . "<br>";

        $this->body_plaintext.= sprintf(__('Hello %s,','notification'), $this->recipient->name)
                    . LINE_BREAK
                    . __('with this automatically created e-mail we want to inform you that', 'notification') . LINE_BREAK
                    . LINE_BREAK;

        if($this->recipient->notification_last) {
            $this->body_html.= sprintf(__('since %s'), renderDate($this->recipient->notification_last, false) ). ' ';
            $this->body_plaintext.=  sprintf(__('since %s'), renderDate($this->recipient->notification_last, false) ). ' ';
        }

        $this->body_html.= sprintf(__('following happened at %s ','notification'), confGet('SELF_DOMAIN')) . "<br>";
        $this->body_plaintext.= sprintf(__('following happened at %s ','notification'), confGet('SELF_DOMAIN')) . LINE_BREAK;
    }


    private function addInvitationForNewAccounts()
    {
        ### new account ###
        if($this->recipient->settings & USER_SETTING_SEND_ACTIVATION) {
            $this->body_html.= __('Your account has been created.','notification')
                    . "<a href='$this->url?go=activateAccount&tuid={$this->recipient->identifier}'>"
                    . __('Please set a password to activate it.','notification')
                    . "</a><br>";

            $this->body_plaintext.= __('Your account has been created.','notification')
                    . " "
                    . __('Please set a password to activate it.','notification')
                    . "\n\r"
                    . $this->url."?go=activateAccount&tuid={$this->recipient->identifier}"
                    . "\n\r\n\r";

            $this->information_count++;
        }
    }


    private function initRecipientProjects()
    {
        ### recently assigned to projects ###
        $this->projects     = array(); # keep for later reference
        $this->projects_new = array();
        
        foreach($this->recipient->getProjectPersons() as $pp) {
            if($project= Project::getVisibleById($pp->project)) {
                if($project->state) {
                    $this->projects[]= $project;
                    if(strToGMTime($pp->created) > strToGMTime($this->recipient->notification_last)) {
                        $this->projects_new[] = $project;
                    }
                }
            }
        }
    }
    

    private function addRecententAssignedProjects()
    {            
        if($this->projects_new) {
            $this->information_count++;

            $this->body_html .= "<h3>"
                            . __('You have been assigned to projects:','notification')
                            . "</h3>"
                            . "<ul>";
                            
            $this->body_plaintext.= "\n\r"
                                 . __('You have been assigned to projects:','notification') . "\n\r"
                                 . str_repeat("=", strlen(__('You have been assigned to projects:','notification'))) . "\n\r"
                                 ;

            foreach($this->projects_new as $p) {
                $this->body_html     .= "<li>" . $this->getItemLink($p->id, $p->name) . "</li>";
                $this->body_plaintext.= "- ". $p->name. "\n\r";
            }

            $this->body_html.= "</ul>\n\r";
            $this->body_plaintext.= "\n\r";
        }        
    }


    private function addChangesToBookmarkedItems()
    {
        ## All changed items ##
        $changes_headline_html = '';
        $changes_headline_txt = '';
        $changes_body_html = '';
        $changes_body_plaintext = '';
        
        $monitored_items = ItemPerson::getAll(array(
                           'is_bookmark'=>1,
                           'notify_on_change'=>1,
                           'person'=>$this->recipient->id));
                           
        if(!$monitored_items) {
            return;
        }
                           
        foreach($monitored_items as $mi){
            if($pi = DbProjectItem::getById($mi->item)){
                if(strToGMTime($pi->modified) > strToGMTime($this->recipient->notification_last)){
                    if($pi->modified_by != $this->recipient->id){
                        $p = Person::GetVisibleById($pi->modified_by);
                        $object = DbProjectItem::getObjectById($pi->id);
                        $changes_body_html .= '<li>' . sprintf(__("%s edited > %s"), $p->nickname, $object->name) . '</li>';
                        $changes_body_plaintext .= '- ' . sprintf(__("%s edited > %s"), $p->nickname, $object->name) . '\n\r';
                    }
                }
            }
        }

        if($changes_body_html){
            $this->information_count++;
            
            $this->body_html .= "<h3>" . __('Changed monitored items:','notification') . "</h3>"
                             . "<ul>"
                             . $changes_body_html
                             . "</ul>";
            
            $this->body_plaintext .= "\n\r". __('Changed monitored items:','notification') . "\n\r"
                                 . str_repeat("=", strlen(__('Changed monitored items:','notification'))) . "\n\r"
                                  . $changes_body_plaintext;
        }
    }
    
    private function addUntouchedMonitoredItems()
    {        
        $unchanged_headline_html = '';
        $unchanged_headline_txt = '';
        $unchanged_body_html = '';
        $unchanged_body_plaintext = '';
        
        $monitored_items_unchanged = ItemPerson::getAll(array(
                                   'is_bookmark'=>1,
                                   'notify_if_unchanged_min'=>NOTIFY_1DAY,
                                   'person'=>$this->recipient->id));
                           
        if(!$monitored_items_unchanged) {
            return;
        }
        
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
                            
                            $unchanged_body_html .= '<li>' . sprintf(__("%s (not touched since %s day(s))"), asHtml($object->name), $days) . '</li>';
                            $unchanged_body_plaintext .= '- ' . sprintf(__("%s (not touched since %s day(s))"), $object->name, $days) . '\n\r';
                        }
                    }
                }
            }
        }
        
        if($unchanged_body_html) {
            $this->information_count++;
            $this->body_html.= "<h3>" . __('Unchanged monitored items:','notification'). "</h3>" 
                            . "<ul>"
                            . $unchanged_body_html
                            . "</ul>";
                            
            $this->body_plaintext .= "\n\r". __('Unchanged monitored items:','notification')."\n\r"
                                    . $unchanged_body_plaintext;
        }
    }
    
    
    private function addRecentChanges()
    {
        ### list project changes ###
        require_once(confGet('DIR_STREBER') . './lists/list_changes.inc.php');

        $updates_html='';
        $updates_txt='';

        foreach($this->projects as $p) {
            if($changes= ChangeLine::getChangeLinesForPerson($this->recipient,$p, $this->recipient->notification_last)) {
                $this->information_count++;
                $updates_html.= "<h4>";
                $updates_html.= $this->getItemLink($p->id, $p->name);

                $updates_html.= "</h4><ul>";
                $updates_txt.= "\n\r". $p->name."\n\r";

                foreach($changes as $c) {
                    $updates_html.="<li>";
                    $updates_txt.="\n\r- ";

                    ### task
                    if($c->item && $c->item->type == ITEM_TASK) {
                        $task= $c->item;
                        $updates_html  .= $this->getItemLink( $task->id, $task->name );
                        $updates_txt   .= $task->name;
                    }
                    else if ($c->item && $c->item->type == ITEM_FILE) {
                        $file= $c->item;
                        $updates_html .= $this->getItemLink($file->id, $file->name);
                        $updates_txt  .= $file->name;                        
                    }

                    $updates_html.= '<br><span class="details">';       # invisible user
                    $updates_txt.= "\n\r";      # invisible user
                    
                    ### what...
                    if($c->html_what) {
                        $updates_html.= $c->html_what. ' ';
                        if($c->txt_what) {
                            $updates_txt.= '  ' . $c->txt_what;
                        }
                        else {
                            $updates_txt.= '  ' . strip_tags($c->html_what);
                        }
                    }

                    $updates_html.= ' ' . __("by") . ' ';       # invisible user
                    $updates_txt .= ' ' . __("by") . ' ';       # invisible user

                    ### who...
                    if($c->person_by) {
                        if($p_who= Person::getVisibleById($c->person_by)) {
                            $updates_html.= "<b>". asHtml($p_who->nickname) ."</b>"
                                  ." ";
                            $updates_txt.= $p_who->nickname;

                        }
                        else {
                            $updates_html.= '??? ';     # invisible user
                            $updates_txt .= '???: ';        # invisible user
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
                    }
                    $updates_html.="</span>";
                    $updates_html.="<div class='details'>" . $c->html_details . "</div>";
                    $updates_html.="</li>";
                    $updates_txt.="\n\r";
                }
                $updates_html.="</ul>";
                $updates_txt.="\n\r";
            }
        }
        if($updates_html) {
            $this->body_html.="<h3>". __('Project Updates'). "</h3>"
                            . $updates_html;
            $this->body_plaintext.="\n\r"
                                 .  __('Project Updates'). "\n\r"
                                 . str_repeat("=", strlen(__('Project Updates'))) . "\n\r"
                    . $updates_txt;

        }
        
    }


    private function addFooter()
    {
        $this->body_html.=
              "<br><span class=\"details\">"
              .__('Forgot your password or how to log in?','notification'). '<br>'
              . "<a href='$this->url?go=loginForgotPasswordSubmit&amp;login_name={$this->recipient->nickname}'>"
              . __('Request a mail to change your account settings.','notification')
              . "</a></span>"
              . "."
              . "<br>"
              . "<br>"
              . __('Thanks for your time','notification') . "<br>"
              . __('the management', 'notification')
              . "</body>\n\r"
              . "</html>";

        $this->body_plaintext.= 
               __('Forgot your password or how to log in?','notification') . ' '
              . __("Click here:") . ' ' . "$this->url?go=loginForgotPasswordSubmit&amp;login_name={$this->recipient->nickname}"
              . "\n\r"
              . "\n\r"
              .'  ' . __('Thanks for your time','notification') . "\n\r"
              .'  ' . __('the management', 'notification');

        }
    }
    
    
?>