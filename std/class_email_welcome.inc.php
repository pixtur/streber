<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * This class composes a activation and welcome email for a person
 *
 *
 * @author         Thomas Mann
 * @uses:           ListChanges
 * @usedby:
**/

require_once(confGet('DIR_STREBER') . './std/class_email.inc.php');


class EmailWelcome extends Email
{
    public      $information_count;
    protected   $projects;
    protected   $projects_new;

    
    protected function initSubject() {
        $this->subject = confGet('WELCOME_EMAIL_SUBJECT')
                       ? confGet('WELCOME_EMAIL_SUBJECT')
                       : sprintf(__('Updates at %s','notification mail subject'), confGet('SELF_DOMAIN'));
    }
        

    protected function initBody()
    {
        $this->information_count=0;

        if($this->recipientNeedsActivation()) {        
            $this->addIntroductionText();        
            $this->addInvitationForNewAccounts();
            $this->addFooter();

            $this->information_count++;
        }
        
        if($smtp= confGet('SMTP')) {
            ini_set('SMTP', $smtp);
        }
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

                     . "<p>". sprintf(__('Hello %s,','notification'), asHtml($this->recipient->name)) . "</p>";

        $this->body_plaintext.= sprintf(__('Hello %s,','notification'), $this->recipient->name) . LINE_BREAK . LINE_BREAK;
    }


    private function addInvitationForNewAccounts()
    {
        ### NOTE: you can override this text by setting ACTIVATION_MAIL* config variables in customize.inc.php
        # In requires a %s for the url
        #
        if(confGet("ACTIVATION_MAIL_PLAIN_BODY")) {
            $this->body_plaintext.= sprintf(confGet("ACTIVATION_MAIL_PLAIN_BODY"), $this->buildActivationUrl() );

            # use plaintext as fallback 
            $htmlOrPlaintext = confGet("ACTIVATION_MAIL_HTML_BODY") 
                             ? confGet("ACTIVATION_MAIL_HTML_BODY") 
                             : confGet("ACTIVATION_MAIL_PLAIN_BODY");

            $this->body_html.= sprintf($htmlOrPlaintext, $this->buildActivationUrl() );
        }
        else {
            $this->body_html.= __('Your account has been created.','notification')
                    . "<a href='". $this->buildActivationUrl() ."'>"
                    . __('Please set a password to activate it.','notification')
                    . "</a><br>";

            $this->body_plaintext.= __('Your account has been created.','notification')
                    . " "
                    . __('Please set a password to activate it.','notification')
                    . "\n\r"
                    . $this->buildActivationUrl()
                    . "\n\r\n\r";

        }

        $this->information_count++;
    }




    private function addFooter()
    {
        $this->body_html.=
                "</body>\n\r"
              . "</html>";        
    }   
}    
?>