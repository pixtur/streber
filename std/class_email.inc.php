<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

require_once(confGet('DIR_STREBER') . './std/mail.inc.php');

/**
 * This base class handles the necessary work to sent a Email to a given recipient:
 * - temporarily changing current user
 * - rendering of correct links to items
 * - providing correct linebreaks
 * 
 * Deriving classes should overwrite buildSubject and buildBody
 *
 * Example usage:
 * $e= new Email($current_user);
 * $e->send();
 *
 * @author      Thomas Mann
*/

class Email
{
    protected $keep_cur_user;
    protected $recipient;
    protected $body_html;
    protected $body_plaintext;
    protected $from_domain;
    protected $url;
    public    $errors;
    protected $from;
    public      $to;
    
    public function __construct($person)
    {
        $this->errors= Array();
        $this->recipient= $person;
        $this->url= confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');
        $this->from_domain = confGet('SELF_DOMAIN');;
        $this->from = __('Streber Email Notification','notifcation mail from') . " <do-not-reply@".$this->from_domain.">";
        $this->reply =         ### reply-addres? ###
        $this->reply="do-not-reply@$this->from_domain";
        $this->to = $person->getValidEmailAddress();
        if(!$this->to) {
            $this->errors[]= _('no person does not have an Email-address','notification');
        }
        
        $this->setRecipient($person);
        $this->initSubject();
        $this->initBody();
        $this->resetCurrentUser();
    }
    
    
    protected function initBody()
    {
        $this->body_plaintext = $this->body_html = "...insert text here...";
    }
    
    
    /**
    * Sends the mail
    *
    * @returns
    * - true on success
    * - html-error on failure
    *
    * NOTE some tips used from Jon Webb [Madrid&London]
    *                          http://www.php.net/manual/en/ref.mail.php#61644
    */
    public function send()
    {
        if($this->errors) {
            return false;
        }

        $eol= "\n"; #getEndOfLine();

        $boundary= "-streber--------------------------------------";

        ### headers  ###
        $headers="";
        $headers .= "Content-Type: multipart/alternative; boundary=\"".$boundary."\"".$eol;
        $headers .= "From: $this->from". $eol;
        $headers .= 'MIME-Version: 1.0'.$eol;

        $msg     = "Content-Type: multipart/alternative".$eol
                . "--".$boundary. $eol
                . "Content-Type: text/plain; charset=UTF-8". $eol. $eol
                . $this->body_plaintext
                . $eol
                . "--".$boundary.$eol
                . "Content-Type: text/html; charset=UTF-8". $eol
                . $eol
                . $this->body_html
                . $eol
                . $eol
                . "--".$boundary."--". $eol.$eol
                ;
                

        /**
        * NOTE: capturing error-output of mail is done in errorhandler.inc,
        * it sets the global variable $g_error_mail
        */
        mail($this->to, $this->subject, $msg, $headers);
        
        global $g_error_mail;
        if(isset($g_error_mail)) {
            $error= asHtml( $g_error_mail. ' ("'. $to. '" <'. $this->recipient->name .'>)' );
            $g_error_mail= NULL;
            return $error;
        }
        return true;
    }

    private function getEndOfLine()
    {
        if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
            $eol="\n\r";
        }
        elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
            $eol="\n\r";
        }
        else {
            $eol="\n\r";
        }
    }

    /**
    * Temporary overwrite the current-user to obey item-visibility and current language settings
    * MUST BE RESET BEFORE LEAVING THIS FUNCTION by calling resetCurrentUser
    */
    private function setRecipient($person) 
    {
        global $auth;
        $this->keep_cur_user= $auth->cur_user;
        $auth->cur_user= $person;
        $this->recipient= $person;
        setLang($person->language);        
    }
        
    private function resetCurrentUser()
    {
        global $auth;
        $auth->cur_user = $this->keep_cur_user;        
        if(isset($auth->cur_user->language)) {
            setLang($auth->cur_user->language);
        }
    }
    
    protected function getItemLink($id, $title)
    {
        return "<a href='" . $this->getUrlToItem($id) . "'>". asHtml($title) . "</a>";
    }

    /**
    * Depending on the MOD_REWRITE-setting, urls inside the Email have to look differently
    */
    protected function getUrlToItem($id)
    {
        $url= confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL'); # returns something like http://localhost/streber/index.php
        
        if(confGet('USE_MOD_REWRITE')) {
            $url= str_replace('index.php','',$url);  
            return $url . "/" . intval($id);
        }
        else {
            return $url . "?go=itemView&id=" . intval($id);
        }
    }
}
