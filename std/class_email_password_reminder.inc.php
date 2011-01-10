<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

require_once(confGet('DIR_STREBER') . './std/class_email.inc.php');

class EmailPasswordReminder extends Email 
{

    protected function initSubject() {
        $this->subject = __('Your account at','notification') . " " . $this->from_domain;
    }

    protected function initBody()
    {
        $this->body_html= $this->getHtmlBody();
        $this->body_plaintext= $this->getPlaintextBody();
    }

    
    protected function getHtmlBody()
    {
        return "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n\r"
        ."<html>"
        ."<head>"
        ."<title>$this->subject</title>"
        . "</head>"
        ."<body text='#000000' link='#163075' alink='#ff0000' vlink='#2046AA'>"
        . sprintf(__('Hello %s,','notification'), asHtml($this->recipient->name)) . "<br><br>"
        . sprintf(__('Your account at %s is still active.','notification'), "<a href='" . $this->url ."'>" . confGet('SELF_DOMAIN')."</a>") . "<br>"
        . __('Your login name is','notification') . " <b>" . asHtml($this->recipient->nickname) . "</b>.<br><br>"
        . __('Please use the following link to') 
        .' ' 
        . "<a href=\"" . $this->url . "?go=activateAccount&tuid=" . $this->recipient->identifier . "\">"
        . __('update your account settings')
        . "</a>...<br>"
        . "<br>"
        . "<br>"
        . __('Thanks for your time','notification') . "<br>"
        . __('the management', 'notification')
        . "</body>"
        . "</html>";
    }

    protected function getPlaintextBody()
    {
        return   sprintf(__('Hello %s,','notification'), $this->recipient->name) . "\n\n"
                . sprintf(__('Your account at %s is still active.','notification'), "<a href='" . $this->url ."'>" . confGet('SELF_DOMAIN')."</a>") . "\n"
                . __('Your login name is','notification') . " '" . asHtml($this->recipient->nickname) . "'.\n"
                . "\n"
                . __('Please use the following link to update your account settings:')  . "\n"
                . $this->url . "?go=activateAccount&tuid=" . $this->recipient->identifier . "\n"
                . "\n"
                . "\n"
                . "   " . __('Thanks for your time','notification') . "\n"
                . "   " . __('the management', 'notification') . "\n";
    }
}
?>