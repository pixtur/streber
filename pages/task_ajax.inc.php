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
*       $('#sideboard div').load('index.php',{
*        go: 'taskRenderDetailsViewResponse',
*        tsk: id
*       });
*/
function taskRenderDetailsViewResponse()
{
    global $PH;

    if($task_id=intval(get('tsk'))) {
        require_once("render/render_wiki.inc.php");

        ### headline ###


        $editable= false;                           # flag, if this task can be edited

        if($task= Task::getEditableById($task_id)) {
            $editable= true;
        }
        else if(!$task=Task::getVisibleById($task_id)) {
            echo "Error: Can read Task #$task_id";
            return;
        }

        echo "<div class='page-functions'>";
        echo $PH->getLink('taskEdit',  __("Edit"), array('tsk'=>$task->id, 'from'=> get('from_handle')) );
        echo $PH->getLink('tasksDelete',  __("Delete"), array('tsk'=>$task->id, 'from'=> get('from_handle')) );
        echo "</div>";

        ### Headline and status ###
        echo "<div class='content-section'>";
        echo $task->getLabel();
        echo " <a href='{$task->getUrl()}'>#{$task->id}</a>";

        ### Note: the task_id of the following h2 is also used for the comment form
        echo "<h2 item_id='$task_id' field_name='name' class='editable'>". asHtml($task->name)."</h2>";

        echo  wikifieldAsHtml($task, 'description', array(
                                'empty_text'=> "[quote]" . __("This task does not have any text yet.\nDoubleclick here to add some.") . "[/quote]",
                            ));
        echo "</div>";

        renderComments($task);
    }
    return true;
}

function renderComments($task)
{
    global $PH;
    global $auth;
    
    require_once(confGet('DIR_STREBER') . "db/db_itemchange.inc.php");

    $comments = $task->getComments(array('order_by'=>'created'  ));
    echo "<div class='content-section'>";
    echo "<h3>";
    echo __("Discussion");
    echo "</h3>";
                
    foreach($comments as $c) {                        
        $is_comment_editable= ($auth->cur_user->user_rights & RIGHT_EDITALL) || ($c->created_by == $auth->cur_user->id);

        if(! $creator= Person::getVisibleById($c->created_by) ) {
            continue;
        }
                    
        echo "<div class='post_list_entry'>";
        echo "<h4>";
        echo "<span class='author'>";
        if($c->created_by == $auth->cur_user->id) {
            echo $creator->nickname;
        } 
        else {
            echo $creator->getLink();
        }
        echo "</span>";
        echo ", ";
        
        $newOrChanged = $c->isChangedForUser();
        $versions= ItemVersion::getFromItem($c);
        $hasBeenEdited = count($versions) > 1;

        /**
        * timestamp is either...
        *  rainer, 54 min ago                     (the timestamp in orange if new)
        *  rainer, 54 min ago (editted just now)  (the 2nd timestamp in orange if new)
        */
        $newClass = $newOrChanged ? "new":'';

        if(!$hasBeenEdited) {
            echo "<span class='$newClass'>";
            echo renderTimeAgo($c->created); 
            echo "</span>";
        }
        else {
            echo renderTimeAgo($c->created); 
            
            echo "<span class='additional'> (" . $PH->getLink('itemViewDiff', 
                __("editted"), 
                array('item' => $c->id)
            ); 
            echo " <span class='$newClass'>". renderTimeAgo($c->modified) . "</span>";
            echo ") ";    
            echo "</span>";
        }

        
        if($c->pub_level != PUB_LEVEL_OPEN)
        {
            echo ' - '. sprintf(__("visible as %s"), renderPubLevelName($c->pub_level));

            ### publish ###
            if( 
                ($parent_task= Task::getEditableById($c->task))
                && ($c->pub_level < PUB_LEVEL_OPEN) 
            ) {
                echo " - " .  $PH->getLink('itemsSetPubLevel', __('Publish'), array( 'item'=>$c->id, 'item_pub_level'=>PUB_LEVEL_OPEN));
            }
        }

        ### delete
        if( $is_comment_editable) {
            echo "<span class='additional'> - " .  $PH->getLink('commentsDelete', __('Delete'), array('comment'=>$c->id)) . "</span>";
        }
        //echo "</p>";
        echo "</h4>";
        
        if($is_comment_editable) {
            echo wikifieldAsHtml($c, 'description');
        }
        else {
            echo wikifieldAsHtml($c, 'description', array('editable'=>false));
        }
    
        echo "</div>";
        $c->nowViewedByUser();
    }   

    echo "<div class='new-comment'>";
    if($task->isEditable()){
        echo "<textarea placeholder='Add comment'></textarea>";        
    }
    echo "<button>" . __("Add Comment").  "</button>";
    echo "</div>";
        
        
    echo "</div>";
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
* Adds a comment to a task
*       $.post('index.php',{
*        go: 'taskAddComment',
*        task_id: id,
*        text: ,
*       });
*/
function taskAddComment() 
{
    require_once(confGet('DIR_STREBER') . 'db/class_comment.inc.php');

    $task_id = intval( get('task_id'));
    if(!$task = Task::getEditableById($task_id)) {
        echo json_encode(array('error' => "Task #$task_id is not editiable"));
        return;
    }

    if(!$text = get('text')) {
        echo json_encode(array('error' => "Text cannot be empty"));
        return;
    }
    
    $new_comment= new Comment(array(
        'id'=>0,
        'name'=>'',
        'task' => $task_id,
        'project' => $task->project,
        'description' => $text,
    ));

    if($new_comment->insert()) {
        echo json_encode(array('success'=>true));
    }
    else {
        echo json_encode(array('error'=>"Unable to create comment"));
    }
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
        'status_min'=> 0,
        'status_max'=> 10,        
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
        
        $task_entry->order_id = $index;            
        $task_entry->update(array('order_id'), false);
        $index++;             
    }
    
    echo json_encode(array('succes'=> "updated $index elements"));    
    return true;
}

?>