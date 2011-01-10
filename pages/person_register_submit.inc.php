<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file
 * remove items of certain types and own
 *
 * @author Thomas Mann
 *
 */

require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . 'db/db_itemchange.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');



/**
* Submit data of a newly registered person @ingroup pages
*/
function personRegisterSubmit()
{
    global $PH;
    global $auth;

    ### cancel ? ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('home',array());
        }
        exit();
    }

    if(!validateFormCrc()) {
        $PH->abortWarning(__('Invalid checksum for hidden form elements'));
    }


    $person= new Person(array('id'=>0));
    $person->user_rights= RIGHT_PERSON_EDIT_SELF;

    ### person category ###
    $pcategory = get('pcategory');
    if($pcategory != NULL)
    {
        if($pcategory == -1)
        {
            $person->category = PCATEGORY_STAFF;
        }
        else if ($pcategory == -2)
        {
            $person->category = PCATEGORY_CONTACT;
        }
        else
        {
            $person->category = $pcategory;
        }
    }
    

    $flag_ok=true;      # update valid?

    # retrieve all possible values from post-data
    # NOTE:
    # - this could be an security-issue.
    # - TODO: as some kind of form-edit-behaviour to field-definition
    foreach($person->fields as $f) {
        $name=$f->name;
        $f->parseForm($person);
    }

    $person->can_login= 1;

    ### notifications ###
    {
        $period= get('person_notification_period');

        ### turn off ###
        if($period === 0 || $period === "0") {
            $person->settings &= USER_SETTING_NOTIFICATIONS ^ RIGHT_ALL;
            $person->notification_period= 0;
        }
        else {
            $person->settings |= USER_SETTING_NOTIFICATIONS;

            $person->notification_period= $period;

            if($person->can_login && !$person->personal_email && !$person->office_email) {
                $flag_ok = false;
                $person->fields['office_email']->required=true;
                $person->fields['personal_email']->required=true;
                new FeedbackWarning(__("Sending notifactions requires an email-address."));
            }

        }

        if(get('person_html_mail')) {
            $person->settings |= USER_SETTING_HTML_MAIL;

        }
        else {
            $person->settings &= USER_SETTING_HTML_MAIL ^ RIGHT_ALL;
        }
    }


    ### time zone ###
    {
        $zone= get('person_time_zone');
        if($zone != NULL && $person->time_zone != (1.0 * $zone)) {
            $person->time_zone = 1.0 * $zone;

            if($zone == TIME_OFFSET_AUTO) {
                new FeedbackMessage(__("Using auto detection of time zone requires this user to relogin."));
            }
            else{
                $person->time_offset= $zone * 60.0 * 60.0;
                if($person->id == $auth->cur_user->id) {
                    $auth->cur_user->time_offset= $zone * 60.0 * 60.0;
                }
            }
        }
    }

    ### theme and lanuage ###
    {
        $theme= get('person_theme');
        if($theme != NULL) {
            $person->theme= $theme;

            ### update immediately / without page-reload ####
            if($person->id == $auth->cur_user->id) {
                $auth->cur_user->theme = $theme;
            }
        }

        $language= get('person_language');
        global $g_languages;
        if(isset($g_languages[$language])) {
            $person->language= $language;

            ### update immediately / without page-reload ####
            if($person->id == $auth->cur_user->id) {
                $auth->cur_user->language =$language;
                setLang($language);
            }
        }
    }

    if(!$person->name) {
        new FeedbackWarning(__("Login-accounts require a full name."));
        $person->fields['name']->required=true;
        $person->fields['name']->invalid=true;
        $flag_ok=false;
        
    }



    if(!$person->office_email) {
        new FeedbackWarning(__("Please enter an e-mail address."));
        $person->fields['office_email']->required=true;
        $person->fields['office_email']->invalid=true;
        $flag_ok=false;        
    }


    $t_nickname= get('person_nickname');
    if(!$person->nickname) {
        new FeedbackWarning(__("Login-accounts require a unique nickname"));
        $person->fields['nickname']->required=true;
        $person->fields['nickname']->invalid=true;

        $flag_ok=false;
    }


    ### check if changed nickname is unique
    if($person->can_login || $person->nickname != "") {

        /**
        * \todo actually this should be mb_strtolower, but this is not installed by default
        */
        if($person->nickname != strtolower($person->nickname)) {
            new FeedbackMessage(__("Nickname has been converted to lowercase"));
            $person->nickname = strtolower($person->nickname);
        }

        if($p2= Person::getByNickname($t_nickname)) { # another person with this nick?
            if($p2->id != $person->id) {
                new FeedbackWarning(__("Nickname has to be unique"));
                $person->fields['nickname']->required=true;
                $flag_ok = false;
            }
        }
    }

    ### password entered? ###
    $t_password1= get('person_password1');
    $t_password2= get('person_password2');
    $flag_password_ok=true;

    
    if(($t_password1 || $t_password2) && $t_password1!="__dont_change__") {

        ### check if password match ###
        if($t_password1 !== $t_password2) {
            new FeedbackWarning(__("Passwords do not match"));
            $person->fields['password']->required=true;
            $flag_ok = false;
            $flag_password_ok = false;
            $person->cookie_string= $auth->cur_user->calcCookieString();
        }
    }
    

    ### check if password is good enough ###
    $password_length= strlen($t_password1);
    $password_count_numbers= strlen(preg_replace('/[^\d]/','',$t_password1));
    $password_count_special= strlen(preg_replace('/[^\wd]/','',$t_password1));

    $password_value= -7 + $password_length + $password_count_numbers*2 + $password_count_special*4;
    if($password_value < confGet('CHECK_PASSWORD_LEVEL')){
        new FeedbackWarning(__("Password is too weak (please add numbers, special chars or length)"));
        $flag_ok= false;
        $flag_password_ok = false;
    }

    if($flag_password_ok) {
        $person->password= md5($t_password1);
    }


    if(! validateFormCaptcha()) {
        new FeedbackWarning(__("Please copy the text from the image."));
        $flag_ok=false;
    }



    ### repeat form if invalid data ###
    if(!$flag_ok) {
        $PH->show('personRegister',NULL,$person);
        exit();
    }
    
    /**
    * store indentifier-string for login from notification & reminder - mails
    */
    $person->identifier= $person->calcIdentifierString();

    ### insert new object ###

    if(($person->settings & USER_SETTING_NOTIFICATIONS) && $person->can_login) {
        $person->settings |= USER_SETTING_SEND_ACTIVATION;
        new FeedbackHint(sprintf(__("A notification / activation  will be mailed to <b>%s</b> when you log out."), $person->name). " " . sprintf(__("Read more about %s."), $PH->getWikiLink('notifications')));
    }

    $person->notification_last = getGMTString(time() - $person->notification_period * 60*60*24 - 1);

    $person->cookie_string= $person->calcCookieString();

    if($person->insert()) {
        new FeedbackHint(__("Thank you for registration! After your request has been approved by a moderator, you will can an email."));
        ### link to a company ###
        if($c_id= get('company')) {
            require_once(confGet('DIR_STREBER') . 'db/class_company.inc.php');

            if($c= Company::getVisibleById($c_id)) {
                require_once(confGet('DIR_STREBER') . 'db/class_employment.inc.php');
                $e= new Employment(array(
                    'id'=>0,
                    'person'=>$person->id,
                    'company'=>$c->id
                ));
                $e->insert();
            }
        }

        ## assigne to project ##
        require_once(confGet('DIR_STREBER') . 'db/class_projectperson.inc.php');
        $prj_num = confGet('REGISTER_NEW_USERS_TO_PROJECT');

        global $g_user_profile_names;
        if(isset($prj_num)){
            if($prj_num != -1){
                if($p= Project::getVisibleById($prj_num)){
                    $prj_person = new ProjectPerson(array(
                            'person' => $person->id,
                            'project' => $p->id,
                            'name' => $g_user_profile_names[$person->profile],
                            ));
                    $prj_person->insert();
                }
            }
        }


        new FeedbackMessage(sprintf(__('Person %s created'), $person->getLink()));

        ### automatically login ###
        $foo= array(
            'login_name' => $person->nickname,
            'login_password_md5' => $person->password,
        );
        addRequestVars($foo);
        $PH->show('loginFormSubmit',array());
        exit();
    }
    else {
        new FeedbackError(__("Could not insert object"));
    }

    ### display fromPage ####
    if(!$PH->showFromPage()) {
        $PH->show('home',array());
    }
}




?>
