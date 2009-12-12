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
        $page->title_minor=__("Project overview");

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
        if($project->isPersonVisibleTeamMember($auth->cur_user)) {
            if($editable) {
                $page->add_function(new PageFunction(array(
                    'target'    =>'projEdit',
                    'params'    =>array('prj'=>$project->id),
                    'icon'      =>'edit',
                    'tooltip'   =>__('Edit this project'),
                    'name'      => __('Edit project')
    
                )));
            }

            /*
            $item = ItemPerson::getAll(array(
                'person'=>$auth->cur_user->id,
                'item'=>$project->id
            ));
            if((!$item) || ($item[0]->is_bookmark == 0)){
                $page->add_function(new PageFunction(array(
                    'target'    =>'itemsAsBookmark',
                    'params'    =>array('proj'=>$project->id),
                    'tooltip'   =>__('Mark this project as bookmark'),
                    'name'      =>__('Bookmark'),
                )));
            }
            else{
                $page->add_function(new PageFunction(array(
                    'target'    =>'itemsRemoveBookmark',
                    'params'    =>array('proj'=>$project->id),
                    'tooltip'   =>__('Remove this bookmark'),
                    'name'      =>__('Remove Bookmark'),
                )));
            }
            */

            /*
            if($project->state == 1) {
                    $page->add_function(new PageFunction(array(
                        'target'=>'projDelete',
                        'params'=>array('prj'=>$project->id),
                        'icon'=>'delete',
                        'tooltip'=>__('Delete this project'),
                        'name'=>__('Delete')
                    )));
            }
            */


            #$page->add_function(new PageFunctionGroup(array(
            #    'name'      => __('new')
            #)));
            /*
            $page->add_function(new PageFunction(array(
                'target'    =>'projAddPerson',
                'params'    =>array('prj'=>$project->id),
                'icon'      =>'add',
                'tooltip'   =>__('Add person as team-member to project'),
                'name'      =>__('Team member')
            )));
            */
            if($project->settings & PROJECT_SETTING_ENABLE_TASKS) {
                $page->add_function(new PageFunction(array(
                    'target'    =>'taskNew',
                    'params'    =>array('prj'=>$project->id),
                    'icon'      =>'new',
                    'tooltip'   =>__('Create task'),
                    'name'      =>__('New task')
                )));
            }

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
        }

        $url= $PH->getUrl("projViewAsRSS", array('prj' => $project->id));
        $page->extra_header_html.=
                '<link rel="alternate" type="application/rss+xml" title="' .asHtml($project->name) .' '. __("News")  . '"'
                .' href="' . $url . '" />';

        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);


    #--- write info-block ------------
    {
        measure_stop('current milestone');
        require_once(confGet('DIR_STREBER') . 'blocks/current_milestone_block.inc.php');        
        $block= new CurrentMilestoneBlock($project);
        $block->render();
        measure_stop('current milestone');
    }


    measure_start('team');





    ### write docu structure ###
    {
        require_once(confGet('DIR_STREBER') . 'lists/list_docustructure.inc.php');
        if(Task::getDocuTasks($project->id,0)) {
            $list=new Block_DocuNavigation(array(
                'project_id' => $project->id
            ));
            $list->print_all();
        }
    }


    #--- list team -----------------------------------------------------------
    /*
    {

        $list= new ListBlock_projectTeam();
        $list->title= __('Team members');
        $list->show_icons=true;
        $list->active_block_function = 'list';
        $list->print_automatic($project);
    }
    measure_stop('team');
    */

    echo(new PageContentNextCol);


    #--- description ----------------------------------------------------------------
    {

        echo "<div class=description>";

        echo wikifieldAsHtml($project, 'description', 
                            array(
                                'empty_text'=> "[quote]" . __("This project does not have any text yet.\nDoubleclick here to add some.") . "[/quote]",
                                'editable' => 'false',
                            ));

        echo "</div>";
    }


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

/*
    measure_start('changes');
    {
        require_once(confGet('DIR_STREBER') . './lists/list_changes.inc.php');

        $list= new ListBlock_changes();
        $list->query_options['date_min']= $auth->cur_user->last_logout;
        $list->query_options['not_modified_by']= $auth->cur_user->id;
        $list->query_options['project']= $project->id;
        //$list->print_automatic($project);
        $list->print_automatic();
    }
    measure_stop('changes');
    */




    echo "<br><br>";                                        # @@@ hack for firefox overflow problems
    ### HACKING: 'add new task'-field ###
    $PH->go_submit='taskNew';
    echo '<input type="hidden" name="prj" value="'.$project->id.'">';


    ### rss link ###
    {
        #$rss_url = confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');
        #$rss_url = str_replace("index.php", "rss/", $rss_url);
        #$prj_id  = $this->page->options[0]->target_params['prj'];
        $url= $PH->getUrl('projViewAsRSS',array('prj'=> $project->id));
        echo  "<a style='margin:0px; border-width:0px;' href='{$url}' target='_blank'>"
                ."<img style='margin:0px; border-width:0px;' src='" . getThemeFile("icons/rss_icon.gif") ."'>"
                ."</a>";
    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}








?>
