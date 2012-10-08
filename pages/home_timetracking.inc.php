<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * Timetracking 
 *
 * @author Thomas Mann
 */


require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_project_team.inc.php');


/**
* display efforts for current user  @ingroup pages
*
* @NOTE 
* - actually this is an excact copy for personViewEfforts
* - this is of course not a good solution, but otherwise the breadcrumbs would change
*
*/
function homeTimetracking()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
    require_once(confGet('DIR_STREBER') . 'lists/list_efforts.inc.php');

    
    ### get current project ###
    $person= $auth->cur_user;
        


    ### create from handle ###
    $PH->defineFromHandle(array('person'=>$person->id));

    ### set up page ####
    {
        $page= new Page();
        $page->cur_tab='home';
        $page->title=__("Time tracking");
        $page->extra_header_html = '<script type="text/javascript" src="js/timetracking.js'  . "?v=" . confGet('STREBER_VERSION'). '"></script>';
        $page->extra_onload_js = "var timetracking = new TimeTracking();";
        
        //$page->title_minor=__('Efforts','Page title add on');
        $page->type=__("Person");

        #$page->crumbs = build_person_crumbs($person);
        $page->options= build_home_options($person);

        echo(new PageHeader);
        build_history_table();

        
    }
    echo (new PageContentOpen);
    
    echo '<input type="hidden" name="person" value="'.$person->id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}

function build_history_table() {
    echo "<div class='doclear'></div>";
    echo "<div class=timetable>";
        echo '<canvas id="myCanvas" width="100%" height="400"></canvas>';
        echo "<div class=container>Container</div>";        
        echo "<div class=currentTime></div>";
    echo "</div>";
}


/**
* display efforts for current user  @ingroup pages
*
* @NOTE 
* - actually this is an excact copy for personViewEfforts
* - this is of course not a good solution, but otherwise the breadcrumbs would change
*
*/
function ajaxUserEfforts()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
    require_once(confGet('DIR_STREBER') . 'lists/list_efforts.inc.php');
    
    #echo '{    "23": { "start": 1349698900879, "duration" : 2342342 , "id":23 },        "43": { "start": 1349692900879, "duration" : 8342342 , "id":23 }}';
    $result = array();
    foreach( $auth->cur_user->getEfforts() as $e ) {
        $result[$e->id] = array('start'=>strToClientTime($e->time_start), 
                                'duration'=> (strToClientTime($e->time_end) - strToClientTime($e->time_start)) , 
                                'id'=> $e->id,
                                'title'=> $e->name);
    }
    echo json_encode($result);
}


?>
