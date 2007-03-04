<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * playground for development
 *
 * There is no direct link to this page, but it can be requested
 * with url http://your.domain.com/playground. Use this to play with rendering etc.
 */


require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');




#header('WWW-Authenticate: Basic realm="blabl"');

#echo "username='" . $username ."'<br>";
#echo "password='" . $password ."'<br>";

/*if (!isset($_SERVER['PHP_AUTH_USER'])) {
   header('WWW-Authenticate: Basic realm="My Realm"');
   header('HTTP/1.0 401 Unauthorized');
   echo 'Text to send if user hits Cancel button';
   exit();
} else {
   echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
   echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
}
*/







/*

some questions

on documentation-tasks:
=======================
1. Is is ok to hide Details-Box and Attach Files box, if tasks is a documentation
   page, and replace it with documentation hierarachy and prev/next navigation?
   -> do a mockup for this.

2. not sure with "Docu" or "Documentation"



history
=======
- deleted comments should be visible in page history (tricky but important)
- It might be help to "see" the item version of a certain date, eg. to check what comments were refering too.



Task labels and Categories
==========================
We have:

  CATEGORIES        FLAGS                LABELS
  Task              is_folder            Bug
  Milestone         deleted              Feature
  Version           completed            Idea
  Documentation                          Discussion
  Event

If might be a good idea to completely split taskView() into several functions to avoid cascaded if-constructs:
- taskViewAsMilestone
- taskViewAsTask
- taskViewAsVersion
- taskViewAsDocumentation
- taskViewAsEvent

We should go through the complete code and replace all depencies from Task->label to Task.category


Refactor
=========

Version/Releases
----------------
Not sure, if "Version" is not a good name. Better might be "Release" but der are probably more projects with internal versions than Projects with "real releases". Either way: "Versions" and "Released Milestones" should not be used synonymously, as it is done in rev171.


Project Rights
=======
Currently the rights of team members are only defined by two things:

1. Their project profile which is been resolved into rights of regarting to items of different pub_levels:
  - read
  - write
  - delete
  - create items with pub-level
  - reduce pub_level
2. Some global user settings:
  - RIGHT_VIEW_ALL (admin view, see items and team members even if not assigned to project)
  - RIGHT_EDIT_PROJECTS (edit team, change rights, etc)

This does not cover all possible situations:

1. We sometimes need to finetune the rights to access items:
 - Anonymous guests should not be able to edit items of other guests.
2. We might reduce the certain rights like:
   - Viewing efforts of other team members.
   - Uploading Files.
   - Seeing other team members
3. We might provide give special rights like:
   - Approve / Close / Confirm / Delete items
*/


/**
* playground @ingroup pages
*/
function playground() {
    global $PH;
    global $auth;
    if(
        !isset($_SERVER['REMOTE_USER']) 
        && 
        !isset($_SERVER['REDIRECT_REDIRECT_REMOTE_USER']) 
        && 
        !isset($_SERVER['PHP_AUTH_USER']) 
        &&
        !get('HTTP_AUTHORIZATION')
    ){
       header('WWW-Authenticate: Basic realm="blabl"');
       header('HTTP/1.0 401 Unauthorized');
       echo 'Sorry. You need to authenticate';
    print("<pre>");
    print_r($_SERVER);
    print("</pre>");
       exit();

    }
    else {
        $username='';
        $password= '';
        if(isset($_SERVER['PHP_AUTH_USER'])) {
            $username=asCleanString($_SERVER['PHP_AUTH_USER']);        
            if(isset($_SERVER['PHP_AUTH_PW'])) {
                $password=asCleanString($_SERVER['PHP_AUTH_PW']);        
            }
        }
    
        /**
        * if php runs in CGI-mode we need mod_rewrite to enable HTTP-auth:
        * read more at http://www.php.net/manual/en/features.http-auth.php#70864
        */
        else  {
            $ha='';
            if(isset($_SERVER['REDIRECT_REDIRECT_REMOTE_USER'])) {
                $ha= $_SERVER['REDIRECT_REDIRECT_REMOTE_USER'];                
            }
            else if(isset($_SERVER['REMOTE_USER'])) {
                $ha= $_SERVER['REMOTE_USER'];                
            }
            
            $tmp= base64_decode( substr($ha,6));
            list($username, $password) = explode(':', $tmp);
        }
        print("<br>username='" . $username . "'");       
        print("<br>password='" . $password . "'");

    print("<pre>");
    print_r($_SERVER);
    print("</pre>");


    }
    





    ### create from handle ###
    $PH->defineFromHandle(array());

    ### set up page ####
    {
        $page= new Page();
    	$page->cur_tab='home';
    	$page->options=array(
            new NaviOption(array(
                'target_id'=>'home',
                'name'=>__('Today')
            )),
            #new NaviOption(array(
            #    'target_id'     =>'personViewEfforts',
            #    'target_params' =>array('person' =>  $auth->cur_user->id),
            #    'name'=>__('Personal Efforts'),
            #
            #)),

    	);

        $page->title=__("Today"); # $auth->cur_user->name;
        $page->type=__("At Home");
        $page->title_minor=renderTitleDate(time());
        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);
    measure_stop('init2');

    echo "Column-Right";

    echo(new PageContentNextCol);

    ### some tabs ###
    {
        ?>
        <div id="pm3">

        <style type="text/css">

        .form_tabgroup {
         display:table;
        }
        .form_tabgroup UL {
         margin:0;
         padding:0;
         list-style:none;
        }
        .form_tabgroup LI.form_tab A {
         color:#777;
         border:0;
         display:block;
         padding:.3em .6em;
        }
        .form_tabgroup LI.form_tab {
         background-color:#eee;
         float:left;
         margin-right:.3em;
        }
        .form_tabgroup LI.Active {
         background-color:#ddd;
        }
        .form_tabgroup LI.Active A {
         color:#000;
        }
        .form_tabgroup DIV {
         padding:.5em .7em;
         background-color:#ddd;
         clear:both;
        }
        </style>

          <div class="form_tabgroup">
            <ul>
              <li class="form_tab" id="tab1"><a href="#">One</a></li>
              <li class="form_tab" id="tab2"><a href="#">Two</a></li>
              <li class="form_tab" id="tab3"><a href="#">Three</a></li>
            </ul>
            <div id="tab1-body">I'm the one's tab content.</div>
            <div id="tab2-body">I'm the two's tab content<br />and a 2nd line.</div>
            <div id="tab3-body">Guess who am I -- says the three's tab content.</div>
          </div>
          <div class="form_tabgroup">
            <ul>
              <li class="form_tab" id="tab1a"><a href="#">One</a></li>
              <li class="form_tab" id="tab2a"><a href="#">Two</a></li>
              <li class="form_tab" id="tab3a"><a href="#">Three</a></li>
            </ul>
            <div id="tab1a-body">I'm the one's tab content.</div>
            <div id="tab2a-body">I'm the two's tab content<br />and a 2nd line.</div>
            <div id="tab3a-body">Guess who am I -- says the three's tab content.</div>
          </div>
        </div>


    <?php
    }

    echo (new PageContentClose);
	echo (new PageHtmlEnd);

}

?>