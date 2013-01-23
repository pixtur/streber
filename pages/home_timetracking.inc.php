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
        $page= new Page(array('use_jscalendar'=>true));
        $page->cur_tab='home';
        $page->title=__("Time tracking");

        $page->extra_header_html  = '<script type="text/javascript" src="js/ninja.js"></script>';
        $page->extra_header_html .= '<script type="text/javascript" src="js/ninja-autocomplete.js"></script>';
        $page->extra_header_html .= '<script type="text/javascript" src="js/timetracking.js'  . "?v=" . confGet('STREBER_VERSION'). '"></script>';
        $page->extra_header_html .= '<script type="text/javascript" src="js/jquery.rating.js'  . "?v=" . confGet('STREBER_VERSION'). '"></script>';
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
    
    $last_end_time = '';
    if($last=Effort::getDateCreatedLast()) {
        $seconds_since_last_effort = strToGMTime('') - strToGMTime($last);
        if ($seconds_since_last_effort < 15*60*60) {
            $last_end_time = strToGMTime($last);            
        }        
    }
    
    echo "<h3>" . __("New Effort") . "</h3>"
            . "<div class='timetracking'>"
            . "<p>"
            . "<p>"
            .  "<input type=hidden placeholder='Date' class='time date' id='effort_date' >"
            //.  "<a id='previous_date'>◀</a>"
            .  "<a href='' id='trigger_date'>Today</a>"
            //.  "<a id='next_date'>▶</a>"
            .  "<input placeholder='Start' class='time start' id='effort_start' >"
            .  "<input placeholder='Time' class='time duration' id='effort_duration' >"
            .  "<input placeholder='Now' class='time end' id='effort_end' >"
            . '<span class="rating">'
            .  '<input name="productivity" type="radio" class="star required" value="1"/>'
            .  '<input name="productivity" type="radio" class="star" value="2"/>'
            .  '<input name="productivity" type="radio" class="star" value="3"/>'
            .  '<input name="productivity" type="radio" class="star" value="4"/>'
            .  '<input name="productivity" type="radio" class="star" value="5"/>'
            . '</span>'
            . "</p>"
            . "<p>"
            .  "<input placeholder='Project' class='project' id='effort_project' >"
            .  "<input placeholder='Task' class='task' id='effort_task' name='task_name' >"
            .  "</p>"
            . "<p>"
            . "<select name='billing'>"
            . "<option value='" . EFFORT_IS_BILLABLE     . "'>Billable</option>"
            . "<option value='" . EFFORT_IS_NOT_BILLABLE . "'>Not Billable</option>"
            . "<option value='" . EFFORT_IS_REDUCED      . "'>Reduced</option>"
            . "<option value='" . EFFORT_IS_TRAVEL       . "'>Travel</option>"
            . "<option value='" . EFFORT_IS_CHARGE_EXTRA . "'>Extra Charge</option>"
            . "</select>"
            . "</p>"

            .  "<p><textarea name='description' id='description' placeholder='Comment'></textarea></p>"
            . "</div>";
    
    require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');    

    $PH->go_submit='newEffortFromTimeTracking';
    echo "<input type=hidden id='effort_project_id' name='effort_project_id' value=''>";
    echo "<input type=hidden id='effort_task_id'  name='effort_task_id' value=''>";
    echo "<input type=hidden id='effort_start_seconds' name='effort_start_seconds' value='" . $last_end_time . "'>";
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
                                'productivity'=> $e->productivity,
                                'color'=> ($p->color ? ("#".$p->color) : "#ff8080"),
                                'title'=> $p->name,
                                'tooltip'=> $e->name
                                );
    }
    echo json_encode($result);
}


function ajaxUserProjects()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'db/class_company.inc.php');
    
    $projects = array();
    
    if($q= getOnePassedId("q")) {
         $all_projects = Project::getAll();
         foreach($all_projects as $p) {

             if(stristr( $p->name, $q) !== false ) {
                 $projects[]= $p;
             }
         }
    }
    else {
         $projects = Project::getAll();
    }
    
    $result = array();
    foreach($projects  as $p) {        
        
        $result[] = array('name'=> $p->name ." – "  . $company->name , 'id'=>$p->id);
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
            'billing' => get('billing'),
            'productivity' => get('productivity'),
    ));

    ### get project ###
    $new_effort->project=get('effort_project_id');
    if(!$project = Project::getVisibleById($new_effort->project)) {
        $PH->abortWarning(__("Could not get project of effort"));
    }

    if(!$project->isPersonVisibleTeamMember($auth->cur_user)) {
        $PH->abortWarning("ERROR: Insufficient rights");        
    }

            
    ### link to task ###
    $task_id = get('effort_task_id');
    if(!(is_null($task_id) || $task_id == 0)){
        if($task_id == 0) {
            $new_effort->task = 0;
        }
        else {
            if($task= Task::getVisibleById($task_id)) {
                $new_effort->task = $task->id;
            }
        }
    }
    else if ('task_name' != ""){
        ### create new task
        $newtask= new Task(array(
            'id'=>0,
            'name'=> get('task_name'),
            'project' => $project->id,
        ));
        $newtask->insert();        
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
