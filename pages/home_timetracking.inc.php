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

        $page->extra_header_html  = '<script type="text/javascript" src="js/ninja.js"></script>';
        $page->extra_header_html .= '<script type="text/javascript" src="js/ninja-autocomplete.js"></script>';
        $page->extra_header_html .= '<script type="text/javascript" src="js/timetracking.js'  . "?v=" . confGet('STREBER_VERSION'). '"></script>';
        $page->extra_header_html .= '<link rel="stylesheet" href="themes/clean/ninja-autocomplete.css" />';

        $page->extra_onload_js .= "new TimeTrackingTable();";        
        $page->extra_onload_js .= "new TimeTrackingForm();";
                
        $page->type=__("Person");
        $page->options= build_home_options($person);

        echo(new PageHeader);
        build_history_table();
        build_effort_edit_form();

        
    }
    echo (new PageContentOpen);
    
    echo '<input type="hidden" name="person" value="'.$person->id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}

function build_history_table() {
    echo "<div class='doclear'></div>";
    echo "<div class=timetable>";
        echo '<canvas id="myCanvas" width="100%" height="100"></canvas>';
        echo "<div class=container>Container</div>";        
        echo "<div class=currentTime></div>";
    echo "</div>";
}


function build_effort_edit_form() 
{
    $effort = new Effort();
    global $g_effort_status_names;
    global $PH;
    global $auth;
    
    echo "<h3>" . __("New Effort") . "</h3>"
            . "<div class='timetracking'>"
            . "<p>"
            . "<p>"
            .  "<input placeholder='Start' class='time start' id='effort_start' >"
            .  "<input placeholder='Time' class='time duration' id='effort_duration' >"
            .  "<input placeholder='Now' class='time end' id='effort_end' >"
            . "</p><p>"
            .  "<input placeholder='Project' class='project' id='effort_project' >"
            .  "<input placeholder='Task' class='task' id='effort_task'>"
            .  "</p>"
            .  "<p><textarea name='description' id='description' placeholder='Comment'></textarea></p>"
            . "</div>";
    
    require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');    

    $PH->go_submit='newEffortFromTimeTracking';
    echo "<input type=hidden id='effort_project_id' name='effort_project_id' value=''>";
    echo "<input type=hidden id='effort_task_id'  name='effort_task_id' value=''>";
    echo "<input type=hidden id='effort_start_seconds' name='effort_start_seconds' value=''>";
    echo "<input type=hidden id='effort_end_seconds'  name='effort_end_seconds' value=''>";
    echo "<input type=submit>";
}


function ajaxUserEfforts()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
    
    $result = array();
    foreach( $auth->cur_user->getEfforts() as $e ) {
        $p= Project::getById($e->project);
        
        $result[$e->id] = array('start'=>strToClientTime($e->time_start), 
                                'duration'=> (strToClientTime($e->time_end) - strToClientTime($e->time_start)) , 
                                'id'=> $e->id,
                                'title'=> $p->name);
    }
    echo json_encode($result);
}


function ajaxUserProjects()
{
    global $PH;
    global $auth;
    if($q= getOnePassedId("q")) {
         $projects = Project::getAll(array('search'=>$q))   ;
    }
    else {
         $projects = Project::getAll();
    }
    
    $result = array();
    foreach($projects  as $t) {        
        $result[] = array('name'=> $t->name, 'id'=>$t->id);    
    }
    echo json_encode($result);
}



function ajaxUserTasks()
{
    $q= asCleanString(getOnePassedId("q"));
    $prj= intval(getOnePassedId("prj"));
    
    if ($prj == 0) $prj = NULL;
    if ($q == "") $q = NULL;
    
    $tasks = Task::getAll(array('search'=>$q, 'project'=>$prj));

    $result = array();
    foreach( $tasks as $t) {        
        $result[] = array('name'=> $t->name, 'id'=>$t->id);    
    }
    echo json_encode($result);
}



function newEffortFromTimeTracking() 
{    
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
    
    $time_end = intval(get('effort_end_seconds'));
    if( $time_end == 0) {
        $time_end = null;
    }

    $new_effort= new Effort(array(
            'id'=>0,
            'time_start'=> getGMTString(get('effort_start_seconds')),
            'time_end'=> getGMTString($time_end),
            'name'=> get('description'),
    ));
        
    ### link to task ###
    $task_id = get('effort_task_id');
    if(!is_null($task_id)){
        if($task_id == 0) {
            $new_effort->task = 0;
        }
        else{
            if($task= Task::getVisibleById($task_id)) {
                $new_effort->task = $task->id;
            }
        }
    }

    ### get project ###
    $new_effort->project=get('effort_project_id');
    if(!$project = Project::getVisibleById($new_effort->project)) {
        $PH->abortWarning(__("Could not get project of effort"));
    }

    if(!$project->isPersonVisibleTeamMember($auth->cur_user)) {
        $PH->abortWarning("ERROR: Insufficient rights");        
    }

    ### get person ###
    $new_effort->person= $auth->cur_user->id;
    
    ### go back to from if validation fails ###
    $failure= false;
    if(strToGMTime($new_effort->time_end) - strToGMTime($new_effort->time_start) < 0) {
        $failure= true;
        new FeedbackWarning(__("Cannot start before end."));
    }

    ### write to db ###
    $new_effort->insert();

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('projView',array('prj'=>$effort->project));
    }
}

?>
