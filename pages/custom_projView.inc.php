<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
* Customized project view for www.streber-pm.org
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




#---------------------------------------------------------------------------
# view Project
#---------------------------------------------------------------------------
function ProjView()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . "render/render_wiki.inc.php");

    $id=getOnePassedId('prj','projects_*');
    if($project= Project::getEditableById($id)) {
        $editable= true;        
    }
    else if ($project= Project::getVisibleById($id)) {
        $editable= false;        
    }
    else {
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
        $page->title_minor=__("Overview");

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
        
        if($editable) {
            $page->add_function(new PageFunction(array(
                'target'    =>'projEdit',
                'params'    =>array('prj'=>$project->id),
                'icon'      =>'edit',
                'tooltip'   =>__('Edit this project'),
                'name'      => __('Edit project')
    
            )));
        }

        $page->add_function(new PageFunction(array(
            'target'    =>'taskNew',
            'params'    =>array('prj'=>$project->id),
            'icon'      =>'new',
            'tooltip'   =>__('Create task'),
            'name'      =>__('New task')
        )));

        if($project->settings & PROJECT_SETTING_ENABLE_BUGS) {
            $page->add_function(new PageFunction(array(
                'target'    =>'taskNewBug',
                'params'    =>array('prj'=>$project->id,'add_issue'=>1),
                'icon'      =>'new',
                'tooltip'   =>__('Create task with issue-report'),
                'name'      =>__('New bug'),
            )));
        }
    
        $page->add_function(new PageFunction(array(
            'target'    =>'taskNewDocu',
            'params'    =>array('prj'=>$project->id),
            'icon'      =>'new',
            'tooltip'   =>__('Create wiki documentation page or start discussion topic'),
            'name'      =>__('New topic'),
        )));
        
        
        if($project->settings & PROJECT_SETTING_ENABLE_EFFORTS && $auth->cur_user->settings & USER_SETTING_ENABLE_EFFORTS) {
            $page->add_function(new PageFunction(array(
                'target'    =>'effortNew',
                'params'    =>array('prj'=>$project->id),
                'icon'      =>'loghours',
                'tooltip'   =>__('Book effort for this project'),
                'name'      =>__('Book effort'),
            )));
        }


        $url= $PH->getUrl("projViewAsRSS", array('prj' => $project->id));
        $page->extra_header_html.=
                '<link rel="alternate" type="application/rss+xml" title="' .asHtml($project->name) .' '. __("News")  . '"'
                .' href="' . $url . '" />';

    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);

    measure_stop('init2');


    #--- description ----------------------------------------------------------------
    if($project->description!="") {
        $block=new PageBlock(array(
            'title'=>__('Description'),
            'id'=>'description',
        ));
        $block->render_blockStart();

        echo "<div class=description>";
        echo  wikifieldAsHtml($project, 'description');
        echo "</div>";

        $block->render_blockEnd();

        ### update task if relative links have been converted to ids ###
        if( checkAutoWikiAdjustments() ) {
            $project->description= applyAutoWikiAdjustments( $project->description );
            $project->update(array('description'),false);
        }
    }
    
    measure_start('team');

    echo(new PageContentNextCol);
    measure_stop('team');


	#--- news -----------------------------------------------------------
    if ($project->settings & PROJECT_SETTING_ENABLE_NEWS) 
    {
        require_once(confGet('DIR_STREBER') . './blocks/project_news_block.inc.php');
        print new ProjectNewsBlock($project);
    }
	
    #--- list changes (new) -----------------------------------------------------------
    {
        require_once(confGet('DIR_STREBER') . './lists/list_recentchanges.inc.php');
        printRecentChanges(array($project), false);
    }

    echo "<br><br>";                                        # @@@ hack for firefox overflow problems
    ### HACKING: 'add new task'-field ###
    $PH->go_submit='taskNew';
    echo '<input type="hidden" name="prj" value="'.$project->id.'">';


    ### rss link ###
    {
		$url= $PH->getUrl('projViewAsRSS',array('prj'=> $project->id));
		echo  "<a style='margin:0px; border-width:0px;' href='{$url}' target='_blank'>"
		        ."<img style='margin:0px; border-width:0px;' src='" . getThemeFile("icons/rss_icon.gif") ."'>"
		        ."</a>";
	}
    echo (new PageContentClose);
   	echo (new PageHtmlEnd());

}





?>
