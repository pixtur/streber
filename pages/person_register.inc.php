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
* Register a new Person @ingroup pages
*
*/
function personRegister($person=NULL)
{
    global $PH;
    global $auth;

    if(!confGet('REGISTER_NEW_USERS')) {
        $PH->abortWarning(__("Registering is not enabled"));
    }
    $person=new Person(array(
        'id'=>0,
        'description'=> __('Because we are afraid of spam bots, please provide some information about you and why you want to register.')
                      . __('The staff will then review your request and approve your account as soon as possible.'),
    ));

    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>true, 'autofocus_field'=>'person_name'));
        $page->cur_tab='people';
        $page->type=__('Edit Person','Page type');
        $page->title= __("Register as a new user");
        $page->title_minor='';

        $page->crumbs= build_person_crumbs($person);
        $page->options=array(
            new NaviOption(array(
                'target_id' => 'personEdit',
            )),
        );
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
        global $g_pcategory_names;

        $form=new PageForm();
        $form->button_cancel=true;

        $form->add($person->fields['name']->getFormElement($person));

        $f= $person->fields['office_email']->getFormElement($person);
        $f->required= true;
        $form->add($f);

        $fnick=$person->fields['nickname']->getFormElement($person);
        $fnick->required= true;
        $form->add($fnick);

        ### show password-fields if can_login ###
        /**
        * since the password as stored as md5-hash, we can initiate current password,
        * but have have to make sure the it is not changed on submit
        */
        $fpw1=new Form_password('person_password1',__('Password','form label'),"", $person->fields['password']->tooltip);
        $fpw1->required= true;
        $form->add($fpw1);

        $fpw2=new Form_password('person_password2',__('confirm Password','form label'),"",  $person->fields['password']->tooltip);
        $fpw2->required= true;
        $form->add($fpw2);

        ### dropdown menu for person category ###
        if($p= get('perscat')){
            $perscat = $p;
        }
        else {
            $perscat = $person->category;
        }
        $form->add(new Form_Dropdown('pcategory',  __('Category','form label'),array_flip($g_pcategory_names), $perscat));

        ### notification ###
        {
            $a=array(
                sprintf(__('daily'),  1)        =>1,
                sprintf(__('each 3 days'), 3)   =>3,
                sprintf(__('each 7 days'), 7)   =>7,
                sprintf(__('each 14 days'), 14)  =>14,
                sprintf(__('each 30 days'), 30)  =>30,
                __('Never')                     =>0,
            );
            $p= $person->notification_period;
            if(!$person->settings & USER_SETTING_NOTIFICATIONS) {
                $p= 0;
            }
            $form->add(new Form_Dropdown('person_notification_period',  __("Send notifications","form label"), $a, $p));
            #$form->add(new Form_checkbox("person_html_mail",__('Send mail as html','form label'),$person->settings & USER_SETTING_HTML_MAIL));
        }


        ### theme and language ###
        {

            global $g_theme_names;
            if(count($g_theme_names)> 1) {
                $form->add(new Form_Dropdown('person_theme',  __("Theme","form label"), array_flip($g_theme_names), $person->theme));
            }

            global $g_languages;
            $form->add(new Form_Dropdown('person_language', __("Language","form label"), array_flip($g_languages), $person->language));
        }


        ### time zone ###
        {
            global $g_time_zones;

            $form->add(new Form_Dropdown('person_time_zone', __("Time zone","form label"), $g_time_zones, $person->time_zone));

        }
        $form->add($person->fields['description']->getFormElement($person));

        $form->addCaptcha();

        echo ($form);

        $PH->go_submit= 'personRegisterSubmit';


        ### pass company-id? ###
        if($c= get('company')) {
            echo "<input type=hidden name='company' value='$c'>";
        }
    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}




?>
