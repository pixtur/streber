<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
require_once("db/class_task.inc.php");
require_once("db/class_project.inc.php");

/**
* test function for development
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
    trigger_error('blub');
    if($task_id=intval(get('tsk'))) {
        require_once("render/render_wiki.inc.php");

        ### headline ###

        echo "<h3>". asHtml($task->name)."</h3>";

        $editable= false;                           # flag, if this task can be edited

        if($task= Task::getEditableById($task_id)) {
            $editable= true;
        }
        else if(!$task=Task::getVisibleById($task_id)) {
            echo "Failure";
        }


        if($editable) {
            echo  wiki2html($task->description, $project, $task->id, 'description');
        }
        else {
            echo  wiki2html($task->description, $project);
        }
    }
}




?>