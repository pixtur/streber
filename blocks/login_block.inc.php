<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * block for rendering the login form
 *
 * included by: @render_page
 * @author     Thomas Mann
 */

require_once(confGet('DIR_STREBER') . "render/render_page.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list_column.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list_column_special.inc.php");


class LoginBlock extends PageBlock
{

    public function __toString()
    {
        global $PH;
        
        $this->title = sprintf( __("Please login"));
        $this->id = 'login';

        $this->render_blockStart();
        $this->render_blockEnd();

        return '';
    }


    function render_blockFooter() 
    {
        global $PH;
        global $g_valid_login_params;
        
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
        #$this->render_blockEnd();

        $PH->go_submit='loginFormSubmit';
    }
}


?>