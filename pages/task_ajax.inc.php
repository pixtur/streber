<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

require_once("db/class_task.inc.php");
require_once("db/class_project.inc.php");


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
        echo "<h3>". asHtml($task->name)."</h3>";

        echo  wikifieldAsHtml($task, 'description');
    }
}


?>