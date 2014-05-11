<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

require_once(confGet('DIR_STREBER') . "db/class_task.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_project.inc.php");


/**\file
* pages relating to AJAX interacting with tasks
*/


/**
* test function for development @ingroup pages
*
* the output of this function could be requested with jquery like:
*
*       $('#sideboard div').load('index.php?go=taskAjax',{
*        go: 'taskAjax',
*        tsk: id
*       });
*/
function taskAjax()
{
    if($task_id=intval(get('tsk'))) {
        require_once("render/render_wiki.inc.php");

        ### headline ###


        $editable= false;                           # flag, if this task can be edited

        if($task= Task::getEditableById($task_id)) {
            $editable= true;
        }
        else if(!$task=Task::getVisibleById($task_id)) {
            echo "Failure";
            return;
        }
        echo "<div class='content'>";
        echo "<h3 item_id='$task_id' field_name='name' class='editable'>". asHtml($task->name)."</h3>";

        echo  wikifieldAsHtml($task, 'description');
        echo "</div>";
    }
}




/**
* Creates a new task from...
*       $.post('index.php',{
*        go: 'taskAjaxCreateNewTask',
*        task_id: -,
*        order_id: -,
*        project_id: 
*        milestone_id: - ,
*       });
*/
function taskAjaxCreateNewTask() 
{
    require_once(confGet('DIR_STREBER') . "pages/project_view_tasks_in_groups.inc.php");

    $new_task = new Task(array(
            'id'            => 0,
            'project'       => intval(get('project_id')),
            'for_milestone' => intval(get('milestone_id')),
            'order_id'      => intval(get('order_id')),
            'name'          => get('name'),
        ));

    if(!$new_task->insert()) {
        print json_encode(array("error" => "Failed to create new task"));
        return;
    }
    print buildListEntryForTask($new_task);    
    return true;
}



/**
* Sets the order inside a group
*       $('#sideboard div').post('index.php',{
*        go: 'taskSetOrderId',
*        task_id: id,
*        order_id: ,
*        milestone_id: ,
*       });
* true on success / error-message on failure
* Returns
*/
function taskSetOrderId() 
{
    $milestone_id   = intval(get('milestone_id'));
    $task_id        = intval(get('task_id'));
    $order_id       = intval(get('order_id'));

    if($task_id == 0) {
        echo json_encode( array( 'error' => "Task Id missing" ));
        return false;
    }
    
    if(!$task = Task::getVisibleById($task_id)) {
        echo json_encode(array( 'error' => "Task inaccessible" ));    
        return false;
    }

    $tasks = Task::getAll(array(
        'project'       => $task->project,
        'for_milestone' => $milestone_id,
        'order_by'      => 'order_id',
        'category'      => $task->category,
    ));

    $index=0;
    foreach( $tasks as $task_entry )
    {
        if( $index == $order_id)
        {
            $task->order_id = $order_id;
            $task->for_milestone = $milestone_id;
            $task->update(array('order_id','for_milestone'), false);
            $index++; 
        }

        if( $task_entry->id == $task->id) {
            continue;
        }
        else {
            $task_entry->order_id = $index;            
            $task_entry->update(array('order_id'), false);
            $index++;     
        }         
    }
    
    echo json_encode(array('succes'=> "updated $index elements"));    
    return true;
}

?>