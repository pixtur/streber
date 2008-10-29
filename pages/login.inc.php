<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * pages relating login and account-handling
 *
 * @author Thomas Mann
 */


require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');


global $g_tabs_login;
$g_tabs_login= array(
            "login" =>array(
                'target'=>"index.php?go=loginForm",
                'title'=>__('Login','tab in top navigation'),
                'bg'=>"misc"       ,
                'tooltip'=>__('Go to your home. Alt-h / Option-h'),
            ),
            "license"   =>array(
                'target'=>"index.php?go=helpLicense",
                'title'=>__('License','tab in top navigation'),
                'tooltip'=>__('Your projects. Alt-P / Option-P'),
                'bg'=>"projects",
                'accesskey'=>'p'
            )
        );


/**
* Specials pages (like a certain task) might be url-requested if the user is not login in yet.
* In this case we have to keep the paramters in this url and keep in during the login page as
* hidden paramter. The following list defines the valid paramters for this.
*/
global $g_valid_login_params;
$g_valid_login_params= array('prj','task','tsk','comment','effort','person','client');

/**
* Render login form 
*
* @ingroup pages
*/
function loginForm() {
    global $PH;
    global $auth;
    global $g_valid_login_params;

    if(isset($auth->cur_user)) {
        $auth->cur_user=NULL;
    }

    /**
    * \TODO this page should not create a from-handle, because
    * the last stored from-handle still contains the recently view site
    */

    ### warn if install-dir present ###
    if(file_exists('install')) {
        new FeedbackWarning("<b>Install-directory still present.</b> This is a massive security issue (<a href='".confGet('STREBER_WIKI_URL')."installation'>read more</a>)"
            .'<ul><li><a href="install/remove_install_dir.php">remove install directory now.</a></ul>');
    }


    ### set up page and write header ###
    {
        $page= new Page(array('autofocus_field'=>'login_name'));
        global $g_tabs_login;
        $page->tabs= $g_tabs_login;

        $page->cur_tab='login';
        $page->type="";
        $page->title= sprintf( __("Welcome to %s", 'Notice after login'), confGet('APP_NAME'));

        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form ###
    {
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');

        if($msg= confGet('LOGIN_MESSAGE')) {
            echo
            "<div class=text>"
            .$msg
            ."</div>";
        }

        $block=new PageBlock(array(
            'title' =>__('please login'),
            'id'    =>'functions',
            'reduced_header' => true,
        ));
        $block->render_blockStart();


        $form=new PageForm();
        $form->add(new Form_Input('login_name',         __('Nickname',    'label in login form'),'') );
        $form->add(new Form_Password('login_password',  __('Password','label in login form'),'') );
        #$form->form_options[]="<span class=option><input name='login_forgot_password' class='checker' type=checkbox>".__("I forgot my password")."</span>";
        $form->form_options[]=$PH->getLink('loginForgotPassword');

        if(confGet('ANONYMOUS_USER')) {
            $form->form_options[]= $PH->getLink('home',__("Continue anonymously"));
        }

        ### add probably go-values as hidden fields ###
        $go_after= NULL;
        if(    confGet('USE_MOD_REWRITE')
            && get('go') == 'globalView'
        ) {
            $go_after= get('id');
            if($go_after =='login') {
                $go_after= '';
            }

        }
        else {
            $go_after= get('go');
        }

        if(    $go_after != ""
            && $go_after != 'logout'
            && $go_after != 'loginForm'
            && $go_after != 'loginFormSubmit'
        ) {
            $form->add(new Form_Hiddenfield('go_after','', $go_after));
            foreach($g_valid_login_params as $var) {
                if($value= get($var)) {
                    $form->add(new Form_Hiddenfield($var,'', $value));
                }
            }
        }

        ### guess user's local time with javascript ###
        echo "<input type=hidden id=user_timeoffset name=user_timeoffset>";
        echo '<script type="text/javascript">
        var now = new Date();document.getElementById("user_timeoffset").value= (now.getHours() + ":" + now.getMinutes() +":"+ now.getSeconds());
        </script>';

        echo ($form);
        $block->render_blockEnd();

        $PH->go_submit='loginFormSubmit';
    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd);

}

/**
* global time offset from gmt to client time in second
* - init by loginFormSubmit() if person->time_zone == 25
* - stored in person->time_offset
*/
global $g_time_offset;  # in seconds
$g_time_offset = 0;

/**
* Submit login data
* @ingroup pages
* - check login / password
* - probably send notification-mail
*/
function loginFormSubmit()
{
    global $PH;
    global $auth;
    global $g_languages;
    global $g_valid_login_params;

    ### get formdata ####
    $name = get('login_name');
    $password = get('login_password');
	
    if(!is_null(get('login_password'))) {
        $password_md5= md5(get('login_password'));
    }
    
    else if(!is_null(get('login_password_md5'))) {                  # required for auto login
        $password_md5= get('login_password_md5');
    }
	
	/**
	* try to login using ldap
	*/
	if($auth->checkLdapOption($name)){
		if($auth->tryLoginUserByLdap($name,$password)){
			$PH->messages= array();
	
			$auth->storeUserCookie();
	
			if(isset($g_languages[$auth->cur_user->language])) {
				setLang($auth->cur_user->language);
			}
	
			### display taskView ####
			$projects=$auth->cur_user->getProjects();
					
			### if go-parameter was present before logging in
			if($go_after= get('go_after')) {
				$params=array();
				foreach($g_valid_login_params as $var) {
					if(get($var)) {
						$params[$var]= get($var);
					}
				}
				log_message("show(go_after=".get('go_after').")", LOG_MESSAGE_DEBUG);
				$PH->show(get('go_after'),$params);
			}
			### if user has only one project go there ###
			else if(count($projects) == 1) {
				$PH->messages[]= sprintf(confGet('MESSAGE_WELCOME_ONEPROJECT'), asHtml($auth->cur_user->name),asHtml($projects[0]->name));
				$PH->show('projView',array('prj'=>$projects[0]->id));
			}
			else {
				$PH->messages[] = sprintf( __("Welcome to %s", "Notice after login"), confGet('APP_NAME'));
				$PH->show('home',array());
			}
		}
		else{
			log_message("invalid login. Show loginForm again", LOG_MESSAGE_DEBUG);
			$PH->messages[]=__('invalid login','message when login failed');
			$PH->show('loginForm');
		}
	}
	else{
		/**
		* try to login with nickname / password
		*/
		if(
			$auth->tryLoginUser($name,$password_md5)
	
		) {
			$PH->messages= array();
	
			$auth->storeUserCookie();
	
			if(isset($g_languages[$auth->cur_user->language])) {
				setLang($auth->cur_user->language);
			}
	
			### display taskView ####
			$projects=$auth->cur_user->getProjects();
					
			### if go-parameter was present before logging in
			if($go_after= get('go_after')) {
				$params=array();
				foreach($g_valid_login_params as $var) {
					if(get($var)) {
						$params[$var]= get($var);
					}
				}
				log_message("show(go_after=".get('go_after').")", LOG_MESSAGE_DEBUG);
				$PH->show(get('go_after'),$params);
			}
			### if user has only one project go there ###
			else if(count($projects) == 1) {
				$PH->messages[]= sprintf(confGet('MESSAGE_WELCOME_ONEPROJECT'), asHtml($auth->cur_user->name),asHtml($projects[0]->name));
				$PH->show('projView',array('prj'=>$projects[0]->id));
			}
			else {
				$PH->messages[] = sprintf( __("Welcome to %s", "Notice after login"), confGet('APP_NAME'));
				$PH->show('home',array());
			}
		}
		else {
			log_message("invalid login. Show loginForm again", LOG_MESSAGE_DEBUG);
			$PH->messages[]=__('invalid login','message when login failed');
			$PH->show('loginForm');
		}
	}
}


/**
* Logout the current user and remove cookies @ingroup pages
*/
function logout(){
    global $PH;
    global $auth;

    ### kill cookie ###
    $auth->removeUserCookie();
    $PH->cur_page_md5=NULL;

    /**
    * keep date of last logout
    * NOTE: the cur_user-object might be no longer up to date (think about person submit).
    * so we get the latest version from the database to update the last_login-field
    */
    if($cur_user= Person::getById($auth->cur_user->id)) {
        $cur_user->cookie_string= $auth->cur_user->calcCookieString();
        $cur_user->last_logout= getGMTString();
        $cur_user->update();
    }



    ### go to login-page ####
    $PH->messages[]="Logged out";
    $PH->show('loginForm');
    #header("location:index.php");


    if($auth->cur_user) {
        $nickname= $auth->cur_user->nickname;
    }
    else {
        $nickname= '_nobody_';
    }
    log_message("'".$nickname."' logged out from:". $_SERVER["REMOTE_ADDR"], LOG_MESSAGE_LOGOUT);

    /**
    * send notifications
    */
    {
        require_once(confGet('DIR_STREBER') . 'std/mail.inc.php');
        $n= new Notifier();
        $n->sendNotifications();
    }
}





/**
* Display forgot password page @ingroup pages
*/
function loginForgotPassword()
{
    global $PH;
    global $auth;
    global $g_valid_login_params;

    if(isset($auth->cur_user)) {
        $auth->cur_user=NULL;
    }


    ### set up page and write header ###
    {
        $page= new Page(array('autofocus_field'=>'login_name'));
        global $g_tabs_login;
        $page->tabs= $g_tabs_login;

        $page->cur_tab='login';
        $page->type="";
        $page->title=__('Password reminder','Page title');

        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form ###
    {
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');


        $block=new PageBlock(array(
            'title' =>__('Please enter your nickname'),
            'id'    =>'functions',
            'reduced_header' => true,
        ));
        $block->render_blockStart();


        $form=new PageForm();
        $form->button_cancel=true;

        $msg= __("We will then sent you an E-mail with a link to adjust your password."). " ";
        if($mail= confGet('EMAIL_ADMINISTRATOR')) {
            $msg.= sprintf(__("If you do not know your nickname, please contact your administrator: %s.") , "<a href='mailto:$mail'>$mail</a>");
        }

        $form->add(new Form_Text($msg));

        $form->add(new Form_Input('login_name',         __('Nickname',    'label in login form'),'') );
        #$form->form_options[]="<span class=option><input name='login_forgot_password' class='checker' type=checkbox>".__("I forgot my password")."</span>";


        echo ($form);
        $block->render_blockEnd();

        $PH->go_submit='loginForgotPasswordSubmit';
    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}




/**
* submit Forgot password data @ingroup pages
*/
function loginForgotPasswordSubmit()
{
    global $PH;
    global $auth;


    ### cancel? ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('loginForm');
        }
        exit();
    }

    if(!$name= get('login_name')) {
        $PH->messages[]=__('If you remember your name, please enter it and try again.');
        $PH->show('loginForgotPassword');
        exit();
    }
    else {
        if($person=Person::getByNickname(get('login_name'))) {
            if($person->can_login) {

                if($person->office_email || $person->personal_email) {


                    require_once(confGet('DIR_STREBER') . 'std/mail.inc.php');
                    $n= new Notifier();
                    $n->sendPasswordReminder($person);

                    $person->settings |= USER_SETTING_NOTIFICATIONS;
                    $person->settings |= USER_SETTING_SEND_ACTIVATION;

                }
            }
        }

        $PH->messages[]=__('A notification mail has been sent.');
        $PH->show('loginForm');
        exit();
    }
}




/**
* Activate account from notification mail @ingroup pages
*/
function activateAccount()
{
    global $auth;
    global $PH;
    $auth->removeUserCookie();
    if($tuid= get('tuid')) {
        $tuid = asKey($tuid);    # clean string
        if($user= $auth->setCurUserByIdentifier($tuid)) {
            $auth->storeUserCookie();
            $PH->messages[]=sprintf(__("Welcome %s. Please adjust your profile and insert a good password to activate your account."), asHtml($user->name));
            global $g_person_fields;
            $PH->show('personEdit',array('person'=>$user->id));
            exit();
        }
    }
    $PH->messages[]=__("Sorry, but this activation code is no longer valid. If you already have an account, you could enter your name and use the <b>forgot password link</b> below.");
    $PH->show('loginForm');
}





/**
* Display license @ingroup pages
*/
function helpLicense()
{
    global $PH;

    ### create from handle ###

    ### set up page and write header ####
    {
        $page= new Page(array());

        global $g_tabs_login;
        $page->tabs=$g_tabs_login;

        $page->cur_tab='license';
        $page->type="";
        $page->title=__('License','page title');

        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    require_once(confGet('DIR_STREBER') . 'lang/license.html');

    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}

?>
