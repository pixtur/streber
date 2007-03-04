<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
* Customized project for www.streber-pm.org
*/

require_once(confGet('DIR_STREBER') . "db/class_task.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_project.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_projectperson.inc.php");
require_once(confGet('DIR_STREBER') . "db/db_itemperson.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_taskfolders.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_comments.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_tasks.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_project_team.inc.php");


function projViewFiles() 
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . "render/render_wiki.inc.php");


	### get current project ###
    $id=getOnePassedId('prj','projects_*');
    $project= Project::getVisibleById($id);
	if(!$project || !$project->id) {
        $PH->abortWarning(__("invalid project-id"));
		return;
	}

    ### define from-handle ###
    $PH->defineFromHandle(array('prj'=>$project->id));

	## is viewed by user ##
	$project->nowViewedByUser();

	## next milestone ##
    $next=$project->getNextMilestone();

    ### set up page ####
    {
        $page= new Page();

        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);

    	$page->cur_tab='projects';
        $page->title=$project->name;
        $page->title_minor=__("Downloads");

        if($project->status == STATUS_TEMPLATE) {
            $page->type=__("Project Template");
        }
        else if ($project->status >= STATUS_COMPLETED){
            $page->type=__("Inactive Project");
        }
        else {
            $page->type=__("Project","Page Type");
        }


    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    measure_stop('init2');
    measure_start('info');


    {
        $block=new PageBlock(array('id'=>'support'));
        $block->render_blockStart();
        echo "<div class=text>";

        if($task= Task::getVisibleById(3645)) {
            echo wiki2html($task->description, $project);
        }

        echo "</div>";

        $block->render_blockEnd();

        
    }

    echo (new PageContentClose);
	echo (new PageHtmlEnd());
    
}



?>
