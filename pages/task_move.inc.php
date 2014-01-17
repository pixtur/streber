<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * pages relating to viewing one project
 *
 * @author Thomas Mann
 * @uses:
 * @usedby:
 *
 */


require_once(confGet('DIR_STREBER') . 'db/class_issue.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_comment.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_issue.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_block.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_block.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');


/**
* to tasks to folder...
*
* @ingroup pages
*
* NOTE: this works either...
* - directly by passing a target folder in 'folder' or 'folders_*'
* - in two steps, whereas
*   - the passed task-ids are keept as hidden fields,
*   - a list with folders in been rendered
*   - a flag 'from_selection' is set
*   - after submit, the kept tasks are moved to 'folders_*'
*
* Also check the java-script part for the ajax-functionality in js/task-move.js
*
*
*
*/
function TasksMoveToFolder()
{
    global $PH;

    $task_ids= getPassedIds('tsk','tasks_*');

    if(!$task_ids) {
        $PH->abortWarning(__("Select some tasks to move"));
        exit();
    }

    /**
    * by default render list of folders...
    */
    $target_task_id=-1;


    /**
    * ...but, if folder was given, directly move tasks...
    */
    $folder_ids= getPassedIds('folder','folders_*');
    if(count($folder_ids) == 1) {
        if($folder_task= Task::getVisibleById($folder_ids[0])) {
            $target_task_id= $folder_task->id;
        }
    }
    else if(get('from_selection')) {
        $target_task_id= 0;  # if no folders was selected, move tasks to project root
    }

    if($target_task_id != -1) {

        $target_project_id = getOnePassedId("target_prj");
        
        foreach($task_ids as $task_id) {
            _moveTask($task_id, $target_project_id, $target_task_id) ;
        }

        ### return to from-page? ###
        if(!$PH->showFromPage()) {
            $PH->show('home');
        }
        exit();
    }



    /**
    * build page and folder lists...
    */
    if(!$task= Task::getVisibleById($task_ids[0])) {
        $PH->abortWarning("could not get task", ERROR_BUG);
    }

    $project_id= getOnePassedId($name='prj',$wild=false, $abort_on_failure=false);
    if(!$project_id) {
        $project_id = $task->project;
    }

    if(!$project= Project::getVisibleById($project_id)) {
        $PH->abortWarning("task without project?", ERROR_BUG);
    }


    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>false));


        $page->cur_tab='projects';
        $page->type= __("Edit tasks");
        $page->title=$project->name;
        $page->title_minor=__("Select folder to move tasks into");
        $page->extra_header_html .= '<script type="text/javascript" src="js/task-move.js'  . "?v=" . confGet('STREBER_VERSION'). '"></script>';
        $page->extra_onload_js .= ('getAjaxListProjectFolders('. $project_id .');initMoveTasksUI();');

        $page->crumbs= build_project_crumbs($project);

        $page->options[]= new NaviOption(array(
            'target_id'     =>'tasksMoveToFolder',
        ));


        echo(new PageHeader);
    }
    echo (new PageContentOpen);


    ### write form #####
    {


        ### write project-selector ###
        $prj_names = array();
        
        if($projects = Project::getAll()){
            foreach($projects as $p){
                $prj_names[$p->id] = $p->name;
            }

            ## assigne new person to ptoject ##
            $dropdown = new Form_Dropdown('target_prj', __('Target project','form label'), array_flip($prj_names), $project_id);
            echo($dropdown->render());
        }

        ### write tasks as hidden entry ###
        foreach($task_ids as $id) {
            if($task= Task::getEditableById($id)) {
                echo "<input type=hidden name='tasks_{$id}_chk' value='1'>";
            }
        }

        ### target container for lazy fetch with ajax ###
        echo("<div id='folder_list'></div>");   


        echo "<input type=hidden name='from_selection' value='1'>";             # keep flag to ungroup tasks
        $button_name=__("Move items");
        echo "<input class=button2 type=submit value='$button_name'>";

        $PH->go_submit='tasksMoveToFolder';

    }

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}


### HELPER FUNCTIONS ##############################################

function _moveTask($task_id, $target_project_id, $target_task_id)
{
    $task= Task::getEditableById($task_id);
    if(!$task) {
        new FeedbackWarning(sprintf(__("Can not edit tasks with ID %s"), $task_id));
        return false;
    }

    $target_parents = _getParentOfTaskId($target_task_id);
    if(_isTaskInList($task, $target_parents)) {
        new FeedbackWarning(sprintf(__("Can not move task <b>%s</b> to own child."), $task->name));
        return false;
    }

    $task->parent_task= $target_task_id;
    $task->update();    

    ### move task to another project
    if($target_project_id != $task->project) {
        $task->project = $target_project_id;

        ### move linked comments
        if($comments = Comment::getAll(array(   'visible_only'=>false,
                                                'alive_only'=>false,
                                                'task'=>$task->id)  ) 
        ){
            foreach($comments as $c){ 
                $c->project = $target_project_id;
                $c->update();
            }
        }

        ### move linked efforts
        if($efforts = Effort::getAll(array(   'visible_only'=>false,
                                                'alive_only'=>false,
                                                'task'=>$task->id)  ) 
        ){
            foreach($efforts as $e){ 
                $e->project = $target_project_id;
                $e->update();
            }
        }

        ### move linked issue
        if($task->issue_report) {
            $task->issue_report->project = $target_project_id;
        }
    }
    $task->update();
    $task->nowChangedByUser();
    
    return true;
}

function _getParentOfTaskId($task_id)
{
    global $PH;

    ### get path of target to check for cycles ###
    if($task_id != 0){
        if(!$task= Task::getEditableById($task_id)) {
            $PH->abortWarning(__("insufficient rights"));
        }
        $parents= $task->getFolder();
        $parents[]= $task;    
    }
    else {
        $parents=array();
    }
    return $parents;    
}


function _isTaskInList($task, $list_of_tasks) 
{
    foreach($list_of_tasks as $parent) {
        if($parent->id == $task->id) {
            return true;
        }
    }
    return false;
}




/**
* Returns a list of folders for the given project.
* This is used for picking the destination folder for moving tasks across
* projects.
*/

function ajaxListProjectFolders() 
{
    global $PH;
    global $auth;

    require_once(confGet('DIR_STREBER') . 'std/class_changeline.inc.php');
    require_once(confGet('DIR_STREBER') . 'lists/list_recentchanges.inc.php');
    require_once(confGet('DIR_STREBER') . 'render/render_block.inc.php');

    require_once(confGet('DIR_STREBER') . 'lists/list_taskfolders.inc.php');
    require_once(confGet('DIR_STREBER') . 'lists/list_comments.inc.php');
    require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');


    header("Content-type: text/html; charset=utf-8");

    ### get project ####

    $project_id= getOnePassedId('prj');
    if(!$project= Project::getVisibleById($project_id)) {
        echo __("requested invalid project");
        exit();
        //$PH->abortWarning("task without project?", ERROR_BUG);
    }

    ### write list of folders ###
    {
        $list= new ListBlock_tasks();
        $list->query_options['show_folders']= true;
        $list->query_options['folders_only']= true;
        $list->query_options['project']= $project->id;
        $list->groupings= NULL;
        $list->block_functions= NULL;
        $list->id= 'folders';
        unset($list->columns['status']);
        unset($list->columns['date_start']);
        unset($list->columns['days_left']);
        unset($list->columns['created_by']);
        unset($list->columns['label']);
        unset($list->columns['project']);

        $list->functions= array();

        $list->active_block_function = 'tree';


        $list->print_automatic($project,NULL);
    }

    echo __("(or select nothing to move to project root)"). "<br> ";
    echo "<input type=hidden name='project' value='$project->id'>";

}






?>