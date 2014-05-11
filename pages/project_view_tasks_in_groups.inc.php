<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file
 * Updated version of the task list
 *
 * @author Thomas Mann
 *
 */

require_once(confGet('DIR_STREBER') . "db/class_task.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_project.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_projectperson.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_person.inc.php");
require_once(confGet('DIR_STREBER') . "db/db_itemperson.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_taskfolders.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_comments.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_tasks.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_project_team.inc.php");


/**
* list tasks of a project @ingroup pages
*/
function projViewTasks()
{
    global $PH;
    global $auth;

    ### get current project ###
    $id=getOnePassedId('prj','projects_*');
    if(!$project=Project::getVisibleById($id)) {
        $PH->abortWarning("invalid project-id");
        return;
    }

    $page= new Page();
    $page->extra_header_html  = '<script type="text/javascript" src="js/jquery.event.drop-2.2.js"></script>';
    $page->extra_header_html .= '<script type="text/javascript" src="js/jquery.event.drag-2.2.js"></script>';
    $page->extra_header_html .= '<script type="text/javascript" src="js/tasklist.js"></script>';

    ### init known filters for preset ###
    $list= new ListBlock_tasks(array(
        'active_block_function'=>'tree',

    ));

    ### set up page ####
    {
        $page->cur_tab='projects';

        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);

        $page->title= $project->name;

        if(isset($preset['name'])) {
            $page->title_minor= $preset['name'];
            if($preset_id == 'next_milestone' && isset($milestone) && isset($milestone->name)) {
                $page->title_minor = __('Milestone') .' '. $milestone->name;
            }
        }
        else {
            $page->title_minor= __("Tasks");
        }


        if($project->status == STATUS_TEMPLATE) {
            $page->type=__("Project Template");
        }
        else if ($project->status >= STATUS_COMPLETED){
            $page->type=__("Inactive Project");
        }
        else {
            $page->type=__("Project","Page Type");
        }

        ### page functions ###
        $new_task_options = isset($preset['new_task_options'])
                          ? $preset['new_task_options']
                          : array();

        if($project->isPersonVisibleTeamMember($auth->cur_user)) {


            #$page->add_function(new PageFunctionGroup(array(
            #    'name'=>__('new'),
            #)));

        }

        ### render title ###
        echo(new PageHeader);
        echo "<div class='details-container'>";
        echo "<div class='page-functions'>blabla bla</div>";
        echo "here be dragons";
        echo "</div>";
    }
    echo (new PageContentOpen);



    #--- without milestone ------------------------------------
    $tasks = Task::getAll(array(
        //'is_milestone'=>true,
        'project' => $project->id,
        'category' => TCATEGORY_TASK,
        'status_min'=> 0,
        'status_max'=> 10,
        'for_milestone' => 0,
        'order_by'=>'order_id',
    ));

    renderTaskGroup($tasks, "Without Group", 0, $project->id);


    #--- for milestones -------------------------------------
    $milestones = Task::getAll(array(
        //'is_milestone'=>true,
        'project' => $project->id,
        'category' => TCATEGORY_MILESTONE,
        'status_min'=> 0,
        'status_max'=> 10,
    ));

    
    $l = count($milestones);
    foreach($milestones as $milestone) {
        $tasks = Task::getAll(array(
            //'is_milestone'=>true,
            'project' => $project->id,
            'category' => TCATEGORY_TASK,
            'status_min'=> 0,
            'status_max'=> 10,
            'for_milestone' => $milestone->id,
            'order_by' => 'order_id',
        ));        
        renderTaskGroup($tasks, $milestone->name, $milestone->id, $project->id);
    }


    #echo "<a href=\"javascript:document.my_form.go.value='tasksMoveToFolder';document.my_form.submit();\">move to task-folder</a>";
    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}

function renderTaskGroup($tasks, $title, $milestone_id, $project_id)
{
    echo "<div class='task-group' data-milestone-id='$milestone_id'  data-project-id='$project_id'>";
    echo "<h2>$title</h2>";
    echo "<ol class='sortable'>";
    foreach($tasks as $task ) {
        echo buildListEntryForTask($task);
    }
    echo "</ol>";
    echo "<a class='new-task'>".__("Add task") . "</a>";
    echo "</div>";
}

function buildListEntryForTask($task) 
{
    $classIsDone = $task->isDone() ? "isDone":'';

    $additionalInfo = $task->buildTypeText();
    $comments = $task->getComments();
    if( count($comments) ) {
        $additionalInfo.= " / ". sprintf(__("%s comments"), count($comments));
    }
    return 
     "<li data-id='{$task->id}' class='$classIsDone'>"
    ."<section class='itemfield' item_id='{$task->id}'' field_name='name'>$task->name</section>"
    ."<small>$additionalInfo</small>"
    ."</li>";
}


?>
