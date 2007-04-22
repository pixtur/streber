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
        $page->add_function(new PageFunction(array(
            'target'    =>'projEdit',
            'params'    =>array('prj'=>$project->id),
            'icon'      =>'edit',
            'tooltip'   =>__('Edit this project'),
            'name'      => __('Edit Project')

        )));

		if($project->state == 1) {
				$page->add_function(new PageFunction(array(
					'target'=>'projDelete',
					'params'=>array('prj'=>$project->id),
					'icon'=>'delete',
					'tooltip'=>__('Delete this project'),
					'name'=>__('Delete')
				)));
		}


        $page->add_function(new PageFunctionGroup(array(
            'name'      => __('new')
        )));
        $page->add_function(new PageFunction(array(
            'target'    =>'projAddPerson',
            'params'    =>array('prj'=>$project->id),
            'icon'      =>'add',
            'tooltip'   =>__('Add person as team-member to project'),
            'name'      =>__('Team member')
        )));
        $page->add_function(new PageFunction(array(
            'target'    =>'taskNew',
            'params'    =>array('prj'=>$project->id),
            'icon'      =>'new',
            'tooltip'   =>__('Create task'),
            'name'      =>__('Task')
        )));
        $page->add_function(new PageFunction(array(
            'target'    =>'taskNewBug',
            'params'    =>array('prj'=>$project->id,'add_issue'=>1),
            'icon'      =>'new',
            'tooltip'   =>__('Create task with issue-report'),
            'name'      =>__('Bug'),
        )));

        $url= $PH->getUrl("projViewAsRSS", array('prj' => $project->id));

        $page->extra_header_html.=
                '<link rel="alternate" type="application/rss+xml" title="' .asHtml($project->name) .' '. __("News")  . '"'
                .' href="' . $url . '" />';

    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);

    measure_stop('init2');
    measure_start('info');


    #--- description ----------------------------------------------------------------
    if($project->description!="") {
        $block=new PageBlock(array(
            'title'=>__('Description'),
            'id'=>'description',
            #'reduced_header'=>true,

        ));
        $block->render_blockStart();

        #echo $str;


        echo "<div class=text>";

        echo wiki2html($project->description, $project);

        ### update task if relative links have been converted to ids ###
        global $g_wiki_auto_adjusted;
        if(isset($g_wiki_auto_adjusted) && $g_wiki_auto_adjusted) {
            $project->description= $g_wiki_auto_adjusted;
            $project->update(array('description'),false);
        }

        echo "</div>";

        $block->render_blockEnd();
    }

    #--- supported by  ------------
    {
        $block=new PageBlock(array('title'=>"Supported by",'id'=>'support'));
        $block->render_blockStart();
        echo "<div class=text>";
        #echo "<ul><a href='phpBB2/index.php'>Forum</a>";
        #echo "<ul><a href=''>Forum</a>";

        echo '<a href="http://sourceforge.net"><img src="http://sourceforge.net/sflogo.php?group_id=145255&amp;type=1" width="88" height="31" border="0" alt="SourceForge.net Logo" /></a>';

        echo "</div>";

        $block->render_blockEnd();

        
    }

    echo(new PageContentNextCol);
    measure_stop('team');



    
    
    #--- news -----------------------------------------------------------
    {
        if($news= Task::getAll(array(
            'category'  => TCATEGORY_DOCU,
            'label'     => 1,
            'order_by'  => 'created DESC',
        ))) {
            
            $block=new PageBlock(array(
                'title'=>__('News'),
                'id'=>'news',
                #'reduced_header'=>true,
    
            ));
            $block->render_blockStart();
    
            #echo $str;
    
            echo "<div class='text'>";
            
            $count = 0;
            foreach($news as $n) {
                if($count++ > 3) {
                    break;
                };
                echo "<div class='newsBlock'>";
                if($creator= Person::getVisibleById($n->created_by)) {
                    $link_creator= ' by '. $creator->getLink();
                }
                echo "<div class=newsTitle><h3>".$PH->getLink('taskView', $n->name , array('tsk' => $n->id)) ."</h3><span class=author>". renderDateHtml($n->created) . $link_creator . "</span></div>";
                echo wiki2html($n->description, $project);
                
                echo "<span class=comments>";
                if($comments= $n->getComments()) {
                     echo  $PH->getLink('taskViewAsDocu', sprintf(__("%s comments"),count($comments)), array('tsk'=> $n->id));
                }
                echo " | ";
                echo $PH->getLink("commentNew", __("Add comment"), array('parent_task' => $n->id) );
                echo "</span>";
                
                echo "</div>";                
            }   
            echo "</div>";
    
            $block->render_blockEnd();
        }

    }
    


    #--- list changes (new) -----------------------------------------------------------
    measure_start('changes');
    if(!Auth::isAnonymousUser()) {
        require_once(confGet('DIR_STREBER') . './lists/list_changes.inc.php');

        $list= new ListBlock_changes();
        $list->query_options['date_min']= $auth->cur_user->last_logout;
        $list->query_options['not_modified_by']= $auth->cur_user->id;
        $list->print_automatic($project);
    }
    measure_stop('changes');


    echo "<br><br>";                                        # @@@ hack for firefox overflow problems

    ### HACKING: 'add new task'-field ###
    $PH->go_submit='taskNew';
    #echo '<input type="hidden" name="prj" value="'.$project->id.'">';
    echo (new PageContentClose);
	echo (new PageHtmlEnd());
}





?>
