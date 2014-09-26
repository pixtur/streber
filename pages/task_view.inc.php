<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_taskfolders.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_comments.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');

/**\file
* Pages related to displaying Tasks
*
* \NOTE additional Pages for tasks are placed in task_more.inc.php
*/

/**
* view a task @ingroup pages
*/
function TaskView()
{
    global $PH;
    global $auth;


    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');
    require_once(confGet('DIR_STREBER') . 'db/db_itemperson.inc.php');


    ### get task ####
    $tsk=get('tsk');
    $editable= false;                           # flag, if this task can be edited

    if($task= Task::getEditableById($tsk)) {
        $editable= true;
    }
    else if(!$task=Task::getVisibleById($tsk)) {
        $PH->abortWarning("invalid task-id",ERROR_FATAL);
    }

    if($task->category == TCATEGORY_DOCU || ($task->category == TCATEGORY_FOLDER && $task->show_folder_as_documentation)) {
        TaskViewAsDocu($task, $editable);
        exit();
    }

    if(!$project= Project::getVisibleById($task->project)) {
        $PH->abortWarning("this task has an invalid project id", ERROR_DATASTRUCTURE);
    }

    ### create from handle ###
    $from_handle= $PH->defineFromHandle(array('tsk'=>$task->id));


    global $g_wiki_task;
    $g_wiki_task= $task;

    ### set up page and write header ####
    {
        $page= new Page();

        $page->use_autocomplete = true;
        initPageForTask($page, $task, $project);

        $page->title_minor_html=$PH->getLink('taskView', sprintf('#%d', $task->id), array('tsk'=>$task->id));
        if($task->state== -1) {
            $page->title_minor_html .= ' ' . sprintf(__('(deleted %s)','page title add on with date of deletion'),renderTimestamp($task->deleted));
        }


        ### page functions ###
        if($project->isPersonVisibleTeamMember($auth->cur_user)) {
            if($editable) {
                $page->add_function(new PageFunction(array(
                    'target'=>'taskEdit',
                    'params'=>array('tsk'=>$task->id),
                    'icon'=>'edit',
                    'tooltip'=> sprintf(__('Edit this %s'), $task->getLabel()),
                    'name'=> __('Edit'),
                )));

            }

            $page->add_function(new PageFunction(array(
                'target'=>'tasksMoveToFolder',
                'params'=>array('tsk'=>$task->id),
                'icon'=>'edit',
                'name'=>__('Move', 'page function to move current task'),
            )));


            if($editable) {
                if($task->state == 1) {
                    $page->add_function(new PageFunction(array(
                        'target'=>'tasksDelete',
                        'params'=>array('tsk'=>$task->id),
                        'icon'=>'delete',
                        'tooltip'=>__('Delete this task'),
                        'name'=>__('Delete')
                    )));
                }
                if($task->state == -1) {
                    $page->add_function(new PageFunction(array(
                        'target'=>'tasksUndelete',
                        'params'=>array('tsk'=>$task->id),
                        'icon'=>'undelete',
                        'tooltip'=>__('Restore this task'),
                        'name'=>__('Undelete')
                    )));
                }
            }

            ### folder ###
            if($task->category == TCATEGORY_FOLDER) {

                $page->add_function(new PageFunctionGroup(array(
                    'name'=>__('new'),
                )));

                $page->add_function(new PageFunction(array(
                    'target'=>'taskNew',
                    'params'=>array('parent_task'=>$task->id),
                    'icon'=>'new',
                    'tooltip'=>__('new subtask for this folder'),
                    'name'=>__('Task'),
                )));

                $page->add_function(new PageFunction(array(
                    'target'=>'taskNewBug',
                    'params'=>array('parent_task'=>$task->id),
                    'icon'=>'new',
                    'tooltip'=>__('new bug for this folder'),
                    'name'=>__('Bug'),
                )));
            }

            ### milestone ###
            else if($task->isMilestoneOrVersion()) {
                $page->add_function(new PageFunctionGroup(array(
                    'name'=>__('new'),
                )));

                $page->add_function(new PageFunction(array(
                    'target'=>'taskNew',
                    'params'=>array('parent_task'=>$task->id, 'for_milestone'=>$task->id),
                    'icon'=>'new',
                    'tooltip'=>__('new task for this milestone'),
                    'name'=>__('Task'),
                )));

                $page->add_function(new PageFunction(array(
                    'target'=>'taskNewBug',
                    'params'=>array('parent_task'=>$task->id),
                    'icon'=>'new',
                    'tooltip'=>__('new bug for this folder'),
                    'name'=>__('Bug'),
                )));
            }

            ### normal task ###
            #else {
            #    if($editable) {
            #        $page->add_function(new PageFunction(array(
            #            'target'=>'tasksMoveToFolder',
            ##            'params'=>array('tsk'=>$task->id),
            #            'icon'=>'edit',
            #            'name'=>__('Move', 'page function to move current task'),
            #        )));
            #    }
#
            #}

            if($auth->cur_user->settings & USER_SETTING_ENABLE_BOOKMARKS) {
                $item = ItemPerson::getAll(array('person'=>$auth->cur_user->id,'item'=>$task->id));
                if((!$item) || ($item[0]->is_bookmark == 0)){
                    $page->add_function(new PageFunction(array(
                        'target'    =>'itemsAsBookmark',
                        'params'    =>array('task'=>$task->id),
                        'tooltip'   =>__('Mark this task as bookmark'),
                        'name'      =>__('Bookmark'),
                    )));
                }
                else{
                    $page->add_function(new PageFunction(array(
                        'target'    =>'itemsRemoveBookmark',
                        'params'    =>array('task'=>$task->id),
                        'tooltip'   =>__('Remove this bookmark'),
                        'name'      =>__('Remove Bookmark'),
                    )));
                }
            }

            if(
               ($auth->cur_user->settings & USER_SETTING_ENABLE_EFFORTS)
                && 
                ($project->settings & PROJECT_SETTING_ENABLE_EFFORTS)
            ) {
                $page->add_function(new PageFunction(array(
                    'target'=>'effortNew',
                    'params'=>array(
                        'parent_task'=>$task->id,

                    ),
                    'icon'=>'effort',
                    'name'=>__('Book Effort'),
                )));
            }

        }


        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);


    #--- write info-block ------------
    if($task->isMilestoneOrVersion()){
        measure_stop('current milestone');
        require_once(confGet('DIR_STREBER') . 'blocks/current_milestone_block.inc.php');        
        $block= new CurrentMilestoneBlock($project);
        $block->current_milestone= $task;
        $block->title= __("Open milestone");
        $block->render();
        measure_stop('current milestone');
    }


    #--- info block ------------
    {
        $block=new PageBlock(array(
            'title'=>__("Summary","Block title"),
            'id'=>'summary',
        ));
        $block->render_blockStart();

        echo "<div class=text>";


        ### milestones and versions ###
        if($task->isMilestoneOrVersion()) {
            global $g_released_names;
            if($task->is_released && isset($g_released_names[$task->is_released])) {
                echo "<div class=labeled><label>".__("Released as","Label in Task summary")."</label>".$g_released_names[$task->is_released] ." / ". renderDateHtml($task->time_released). "</div>";
            }



        }
        ### normal tasks ###
        else {

            if($task->for_milestone) {
                if($milestone= Task::getVisibleById($task->for_milestone)) {
                    echo "<div class=labeled><label>".__("For Milestone","Label in Task summary")."</label>".$milestone->getLink(false)."</div>";
                }
            }


            global $g_status_names;
            if($status=$g_status_names[$task->status]) {
                echo "<div class=labeled><label>".__("Status","Label in Task summary")."</label>$status</div>";
            }


            echo "<div class=labeled><label>".__("Opened","Label in Task summary")."</label>".renderDateHtml($task->date_start)."</div>";

            if($task->estimated) {
                echo "<div class=labeled><label>".__("Estimated","Label in Task summary")."</label>".renderDuration($task->estimated). ' ';

                if($task->estimated_max) {
                    echo " ... ". renderDuration($task->estimated_max);
                }
                echo "</div>";
            }

            if($task->completion) {
                echo "<div class=labeled><label>".__("Completed","Label in Task summary")."</label>".$task->completion."%</div>";
            }

            if($task->planned_start && $task->planned_start != "0000-00-00 00:00:00") {
                echo "<div class=labeled><label>".__("Planned start","Label in Task summary")."</label>".renderTimestamp($task->planned_start)."</div>";
            }

            if($task->planned_end && $task->planned_end != "0000-00-00 00:00:00") {
                echo "<div class=labeled><label>".__("Planned end","Label in Task summary")."</label>".renderTimestamp($task->planned_end)."</div>";
            }

            if($task->date_closed !="0000-00-00") {
                echo "<div class=labeled><label>".__("Closed","Label in Task summary")."</label>". renderDateHtml($task->date_closed) . "</div>";
            }
        }

        if($person_creator= Person::getVisibleById($task->created_by)) {
            echo "<div class=labeled><label>".__("Created","Label in Task summary")."</label>". renderDateHtml($task->created) . ' / ' . $person_creator->getLink().'</div>' ;
        }

        if($person_modify= Person::getVisibleById($task->modified_by)) {
            echo "<div class=labeled><label>".__("Modified","Label in Task summary")."</label>". renderDateHtml($task->modified) . ' / ' .  $person_modify->getLink() . '</div>' ;
        }

        ### get version ###
        {
            require_once(confGet('DIR_STREBER') . "db/db_itemchange.inc.php");
            $versions= ItemVersion::getFromItem($task);
            if(count($versions) > 1) {
                $str_version=     $PH->getLink('itemViewDiff',
                                    sprintf(__("View previous %s versions"), count($versions)),
                                    array('item' => $task->id)
                                );
                echo "<div class=labeled><label></label>$str_version</div>";
            }
        }


        #}

        $sum_efforts= $task->getSumEfforts();
        if($sum_efforts) {
            echo "<div class=labeled><label>".__("Open effort","Label in task-summary")."</label>".
            $PH->getLink('taskViewEfforts',round($sum_efforts/60/60,1), array('task'=>$task->id))
            ."</div>" ;
        }

        if($tps= $task->getAssignedPeople()) {
            $value="";
            $sep="";
            foreach($tps as $tp) {
                $value.= $sep . $tp->getLink();
                $sep=", ";
            }
            $label=__("Assigned to");
            echo "<div class=labeled><label>$label</label>$value</div>" ;


        }

        ### publish to ###
        global $g_pub_level_names;
        if($task->pub_level != PUB_LEVEL_OPEN && isset($g_pub_level_names[$task->pub_level])) {
            echo "<div class=labeled><label>".__("Publish to","Label in Task summary")."</label>".$g_pub_level_names[$task->pub_level] ;
            if($editable) {
                echo '<br>('
                    . $PH->getLink('itemsSetPubLevel',__('Set to Open'), array('item' => $task->id,'item_pub_level' => PUB_LEVEL_OPEN))
                    . ')';
            }
            echo "</div>";
        }


        echo "</div>";

        $block->render_blockEnd();
    }

    #--- navigation structure for documentation --------------------------------------------
    if($task->category == TCATEGORY_FOLDER) {
        require_once(confGet('DIR_STREBER') . 'lists/list_docustructure.inc.php');
        $list=new Block_DocuNavigation(array(
            'current_task'=> $task,
            'root'          => $task,
        ));

        $list->title = __("Further Documentation");


        $list->print_all();
    }


    #--- list files --------------------------------------------------------------------------
    {
        require_once(confGet('DIR_STREBER') . 'lists/list_files.inc.php');
        $list= new ListBlock_files();
        #$list->query_options['visible_only']= false;
        $list->query_options['parent_item']= $task->id;
        $list->show_functions=false;

        unset($list->columns['status']);
        unset($list->columns['mimetype']);
        unset($list->columns['filesize']);
        unset($list->columns['created_by']);
        #unset($list->columns['download']);
        unset($list->columns['version']);
        unset($list->columns['_select_col_']);
        unset($list->columns['modified']);
        unset($list->columns['name']);
        unset($list->columns['thumbnail']);

        unset($list->block_functions['list']);
        unset($list->block_functions['grouped']);
        unset($list->functions['fileEdit']);
        unset($list->functions['filesDelete']);

        $list->title=__('Attached files');

        if($editable) {
            $list->summary= buildFileUploadForm( $task );
        }

        $list->print_automatic($project);
        $PH->go_submit= $PH->getValidPage('filesUpload')->id;
    }

    echo(new PageContentNextCol);

    #--- feedback notice ------------------------------------------------------------
    {
        if($view = ItemPerson::getAll(array('person'=>$auth->cur_user->id, 'item'=>$task->id, 'feedback_requested_by'=>true))){
            if ($requested_by= Person::getPeople( array( 'id' => $view[0]->feedback_requested_by ) )) {
                echo "<div class=item_notice>";
                echo "<h3>" . sprintf(__("Your feedback is requested by %s."), asHtml($requested_by[0]->nickname) ) . "</h3>";
                echo __("Please edit or comment this item.");
                echo "</div>";
            }
        } 
    }  

    #--- description ----------------------------------------------------------------
    {
        #$descriptionWithUpdates= $task->getTextfieldWithUpdateNotes('description');
        echo "<div class=description>";
        echo  wikifieldAsHtml($task, 'description',
                            array(
                                'empty_text'=> "[quote]" . __("This task does not have any text yet.\nDoubleclick here to add some.") . "[/quote]",
                            ));

        echo "</div>";

        ### Apply automatic link conversions
        if( checkAutoWikiAdjustments() ) {            
            $task->description= applyAutoWikiAdjustments( $task->description );
            $task->update(array('description'),false);
        }
    }


    #--- issue report -------------------------------------------------------------
    if($task->category == TCATEGORY_BUG && $task->issue_report) {
        require_once(confGet('DIR_STREBER') . 'db/class_issue.inc.php');
        $issue= new Issue($task->issue_report);


        $buffer="";

        if($issue->severity) {
            global $g_severity_names;
            if(isset($g_severity_names[$issue->severity])) {
                $buffer.= '<div class=labeled><label>' . __("Severity","label in issue-reports") . '</label>'. $g_severity_names[$issue->severity]. '</div>';
            }
        }

        if($issue->severity) {
            global $g_reproducibility_names;
            if(isset($g_reproducibility_names[$issue->reproducibility])) {
                $buffer.= '<div class=labeled><label>' . __("Reproducibility","label in issue-reports") . '</label>'. $g_reproducibility_names[$issue->reproducibility]. '</div>';
            }
        }


        if($issue->plattform) {
            $buffer.= '<div class="labeled"><label>' . __('Platform') . '</label>'.asHtml($issue->plattform).'</div>';
        }
        if($issue->os) {
            $buffer.= '<div class=labeled><label>' . __('OS') . '</label>'. asHtml($issue->os).'</div>';
        }
        if($issue->version) {
            $buffer.= '<div class=labeled><label>' . __('Version') . '</label>'. asHtml($issue->version).'</div>';
        }
        if($issue->production_build) {
            $buffer.= '<div class=labeled><label>' . __('Build') . '</label>'. asHtml($issue->production_build). '</div>';
        }

        if($issue->steps_to_reproduce) {
            $text= wikifieldAsHtml($issue, 'steps_to_reproduce');
            $buffer.= '<div class="labeled separated"><label>' . __("Steps to reproduce","label in issue-reports") . "</label>$text</div>";
        }
        if($issue->expected_result) {
            $text= wikifieldAsHtml($issue, 'expected_result');
            $buffer.= '<div class="labeled separated"><label>' . __("Expected result","label in issue-reports") . "</label>$text</div>";
        }
        if($issue->suggested_solution) {
            $text= wikifieldAsHtml($issue, 'suggested_solution');
            $buffer.= '<div class="labeled separated"><label>' . __("Suggested Solution","label in issue-reports") . "</label>$text</div>";
        }


        if($buffer) {

            $block=new PageBlock(array(
                'title'=>__('Issue report'),
                'id'=>'issue_report'

            ));
            $block->render_blockStart();

            echo "<div class=text>";
            echo $buffer;
            echo "<b class=doclear></b>";
            echo "</div>";

            $block->render_blockEnd();
        }
    }


    #--- list tasks -------------------------------------------------------------
    if($task->category== TCATEGORY_FOLDER || $task->getNumSubtasks() > 0 ) {

        $list= new ListBlock_tasks(array(
            'active_block_function'=>'tree',
            'title'=>__('Sub tasks'),

        ));
        unset($list->columns['project']);
        unset($list->columns['created_by']);
        unset($list->columns['planned_start']);
        unset($list->columns['modified']);
        unset($list->columns['estimate_complete']);
        unset($list->columns['pub_level']);
        $list->filters[]= new ListFilter_status_max(array(
            'value'=>STATUS_COMPLETED,
        ));
        $list->filters[]= new ListFilter_category_in(array(
            'value'=>array(TCATEGORY_FOLDER, TCATEGORY_TASK, TCATEGORY_BUG),
        ));
        $list->print_automatic($project, $task);

    }

    #--- list milestone-tasks ---------------------------------------------------
    if($task->isOfCategory(array(TCATEGORY_MILESTONE, TCATEGORY_VERSION))) {
        $list= new ListBlock_tasks(array(
            'active_block_function'=>'tree',
            'title'=> __('Open tasks for milestone'),
        ));

        $list->no_items_html=__('No open tasks for this milestone');
        unset($list->columns['project']);
        unset($list->columns['created_by']);
        unset($list->columns['planned_start']);
        unset($list->columns['modified']);
        unset($list->columns['for_milestone']);
        unset($list->columns['pub_level']);
        $list->query_options['status_max'] = STATUS_COMPLETED;
        $list->query_options['for_milestone'] = $task->id;
        
        $list->print_automatic($project, NULL, true);
    }

    #--- list change log ---------------
    if ($task->category== TCATEGORY_VERSION)
    {

        ### get resolved tasks ###
        if($resolved= Task::getAll(array(
            'project'               => $task->project,
            'resolved_version'      => $task->id,
            'status_min'            => 0,
            'status_max'            => 200,
            'order_by'              => 'resolve_reason',
        ))) {
            $block=new PageBlock(array(
                'title'=>__("Resolved tasks","Block title"),
                'id'=>'resolved_tasks',
            ));
            $block->render_blockStart();

            echo "<div class=text>";

            $buffer= "<ul>";
            foreach($resolved as $r) {
                if($r->resolve_reason && isset($g_resolve_reason_names[$r->resolve_reason])) {
                    $reason= $g_resolve_reason_names[$r->resolve_reason] .": ";
                }
                else {
                    $reason= "";
                }
                $buffer.='<li>'. $reason . $r->getLink(false) .'</li>';
            }
            $buffer.="</ul>";
            echo $buffer;

            echo "</div>";

            $block->render_blockEnd();
        }
    }




    #--- list comments --------
    {
        require_once(confGet('DIR_STREBER') . 'blocks/comments_on_item_block.inc.php');
        print new CommentsOnItemBlock($task);
    }



    #--- task quickedit form -------------------------------------------------------------
    echo (new PageContentClose);
    echo (new PageHtmlEnd);

    ## is viewed by user ##
    $task->nowViewedByUser();

}



/**
* Renders a quick edit form for one task
*
* @author         Tino Beirau
*/
class Block_task_quickedit extends PageBlock
{

    public function __construct($args=NULL)
    {
        global $PH;
        $this->id='quick_edit';
        $this->title= __("Comment / Update");
    }

    public function render_quickedit($task)
    {
        global $PH;

        $editable= false;

        ### make sure it's editable ###
        if(Task::getEditableById($task->id)) {
            $editable= true;
        }
        else if(! Task::getVisibleById($task->id)) {
            return false;
        }

        ### get parent project ####
        if(!$project= Project::getVisibleById($task->project)) {
            return;
        }

        $this->render_blockStart();

        ### write form #####
        {
            require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');

            global $REPRODUCIBILITY_VALUES;

            global $g_prio_names;
            global $g_status_names;


            $form=new PageForm();
            $form->button_cancel = false;

            $form->add($tab_group = new Page_TabGroup());

            ### add comment ###
            {
                $tab_group->add($tab = new Page_Tab("comment",__("Add comment")));

                ### Comment ###
                $comment_name= '';
                $comment= new Comment(array(
                    'id'=>0,
                    'name'=>$comment_name,
                ));

                $tab->add($comment->fields['name']->getFormElement($comment,__('Comment')));
                $e= $comment->fields['description']->getFormElement($comment);
                $e->rows=8;
                $tab->add($e);

                ### request feedback
                $tab->add(buildRequestFeedbackInput($project));
            }

            ### update ###
            if($editable && $task->isOfCategory(array(TCATEGORY_TASK,  TCATEGORY_BUG))) {
                $tab_group->add($tab=new Page_Tab("update",__("Update")));

                #$tab->add(new Form_Dropdown('task_for_milestone', __('For Milestone'), $project->buildPlannedForMilestoneList(), $task->for_milestone));
                $tab->add( new Form_DropdownGrouped('task_for_milestone', 
                            __('For Milestone'), 
                            $project->buildPlannedForMilestoneList(), 
                            $task->for_milestone
                         ));

                $tab->add(new Form_DropdownGrouped('task_resolved_version', 
                            __('Resolved in'), 
                            $project->buildResolvedInList(), 
                            $task->resolved_version
                        ));

                global $g_resolve_reason_names;
                $tab->add(new Form_Dropdown('task_resolve_reason', __('Resolve reason'),array_flip($g_resolve_reason_names), $task->resolve_reason));


                ### public-level ###
                #{
                #   if(($pub_levels=$task->getValidUserSetPublicLevels()) && count($pub_levels)>1) {
                #       $form->add(new Form_Dropdown('task_pub_level',  __("Public to"),$pub_levels,$task->pub_level));
                #   }
                #}

                ### assigned to ###
                {
                    ### for existing tasks, get already assigned
                    if($task->id) {
                        $assigned_people = $task->getAssignedPeople();
                    }

                    ### for new tasks get the assignments from parent task ###
                    else {
                        trigger_error("view a task with zero id?");
                    }

                    $team=array(__('- select person -')=>0);

                    ### create team-list ###
                    foreach($project->getPeople() as $p) {
                        $team[$p->name]= $p->id;
                    }

                    ### create drop-down-lists ###
                    $count_new=0;
                    $count_all=0;
                    if(isset($assigned_people)) {
                        foreach($assigned_people as $ap) {
                            if(!$p= Person::getVisibleById($ap->id)) {
                                continue;                               # skip if invalid person
                            }

                            if($task->id) {
                                $tab->add(new Form_Dropdown('task_assigned_to_'.$ap->id, __("Assigned to"),$team, $ap->id));
                            }
                            else {
                                $tab->add(new Form_Dropdown('task_assign_to_'.$count_new, __("Assign to"),$team, $ap->id));
                                $count_new++;
                            }
                            $count_all++;
                            unset($team[$ap->name]);
                        }
                    }

                    ### add empty drop-downlist for new assignments ###
                    $str_label  = ($count_all == 0)
                                ? __("Assign to","Form label")
                                : __("Also assign to","Form label");
                    $tab->add(new Form_Dropdown("task_assign_to_$count_new",  $str_label,$team, 0));
                }


                ### priority ###
                {
                    if(!$task->isMilestoneOrVersion()) {
                        $tab->add(new Form_Dropdown('task_prio',  __("Prio","Form label"),  array_flip($g_prio_names), $task->prio));
                    }
                }

                ### estimated ###
                {
                    $ar= array(
                        __('undefined')=> 0,
                        __('30 min')    => 30*60,
                        __('1 h')  => 60*60,
                        __('2 h') => 2*60*60,
                        __('4 h') => 4*60*60,
                        __('1 Day')     =>   1 * confGet('WORKHOURS_PER_DAY') * 60 * 60,
                        __('2 Days')    =>   2 * confGet('WORKHOURS_PER_DAY') * 60 * 60,
                        __('3 Days')    =>   3 * confGet('WORKHOURS_PER_DAY') * 60 * 60,
                        __('4 Days')    =>   4 * confGet('WORKHOURS_PER_DAY') * 60 * 60,
                        __('1 Week')   =>   1 * confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60,
                        __('2 Weeks')  =>   2 * confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60,
                        __('3 Weeks')  =>   3 * confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60,
                    );
                    $tab->add(new Form_Dropdown('task_estimated',__("Estimated time"),$ar,  $task->estimated));
                    $tab->add(new Form_Dropdown('task_estimated_max',__("Estimated worst case"),$ar,  $task->estimated_max));
                }

                ### completion ###
                {
                    $ar= array(
                        __('undefined')=> -1,
                        '0%'    => 0,
                        '10%'    => 10,
                        '20%'    => 20,
                        '30%'    => 30,
                        '40%'    => 40,
                        '50%'    => 50,
                        '60%'    => 60,
                        '70%'    => 70,
                        '80%'    => 80,
                        '90%'    => 90,
                        '95%'    => 95,
                        '98%'    => 98,
                        '99%'    => 99,
                        '100%'   => 100,
                    );
                    $tab->add(new Form_Dropdown('task_completion',__("Completed"),$ar,  $task->completion));
                }

                $tab->add($task->fields['parent_task']->getFormElement($task));


                ### status ###
                {
                    $st=array();
                    foreach($g_status_names as $s=>$n) {
                        if($s >= STATUS_NEW) {
                            $st[$s]=$n;
                        }
                    }
                    if($task->isMilestoneOrVersion()) {
                        unset($st[STATUS_NEW]);
                    }

                    $tab->add(new Form_Dropdown('task_status',"Status",array_flip($st),  $task->status));
                }
            }

            /**
            * to reduce spam, enforce captcha test for guests
            */
            global $auth;
            if($auth->cur_user->id == confGet('ANONYMOUS_USER')) {
                $form->addCaptcha();
            }

            ### some required hidden fields for correct data passing ###
            $form->add(new Form_HiddenField('tsk','',$task->id));
            $form->add(new Form_HiddenField('comment','',$comment->id));

            if($return=get('return')) {
                $form->add(new Form_HiddenField('return','', asHtml($return)));
            }

            echo($form);

            $PH->go_submit= 'taskEditSubmit';


            $this->render_blockEnd();
        }
    }
}

/**
* view task a documentation page @ingroup pages
*/
function taskViewAsDocu()
{
    global $PH;
    global $auth;

    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');
    require_once(confGet('DIR_STREBER') . 'db/db_itemperson.inc.php');

    ### get task ####
    $tsk=get('tsk');


    $editable= false;                           # flag, if this task can be edited

    if($task= Task::getEditableById($tsk)) {
        $editable= true;
    }
    else if(!$task=Task::getVisibleById($tsk)) {
        $PH->abortWarning("invalid task-id",ERROR_FATAL);
    }

    if(!$project= Project::getVisibleById($task->project)) {
        $PH->abortWarning("this task has an invalid project id", ERROR_DATASTRUCTURE);
    }

    ### create from handle ###
    $from_handle= $PH->defineFromHandle(array('tsk'=>$task->id));

    global $g_wiki_task;
    $g_wiki_task= $task;

    ### set up page and write header ####
    measure_start("page_render");
    {
        $page= new Page();
        $page->use_autocomplete= true;

        initPageForTask($page, $task, $project);


        $page->title_minor_html=$PH->getLink('taskView', sprintf('#%d', $task->id), array('tsk'=>$task->id));
        if($task->state == -1) {
            $page->title_minor_html .= ' ' . sprintf(__('(deleted %s)','page title add on with date of deletion'),renderTimestamp($task->deleted));
        }

        ### page functions ###
        if($project->isPersonVisibleTeamMember($auth->cur_user)) {
            ### edit ###
            if($editable) {

                $page->add_function(new PageFunction(array(
                    'target'=>'taskEdit',
                    'params'=>array('tsk'=>$task->id),
                    'icon'=>'edit',
                    'tooltip'=>__('Edit this task'),
                    'name'=>__('Edit')
                )));
                $page->add_function(new PageFunction(array(
                    'target'=>'tasksMoveToFolder',
                    'params'=>array('tsk'=>$task->id),
                    'icon'=>'edit',
                    'name'=>__('Move', 'page function to move current task'),
                )));

                if($task->state == 1) {
                    $page->add_function(new PageFunction(array(
                        'target'=>'tasksDelete',
                        'params'=>array('tsk'=>$task->id),
                        'icon'=>'delete',
                        'tooltip'=>__('Delete this task'),
                        'name'=>__('Delete')
                    )));
                }
                else if($task->state == -1) {
                    $page->add_function(new PageFunction(array(
                        'target'=>'tasksUndelete',
                        'params'=>array('tsk'=>$task->id),
                        'icon'=>'undelete',
                        'tooltip'=>__('Restore this task'),
                        'name'=>__('Undelete')
                    )));
                }
                $page->add_function(new PageFunction(array(
                    'target'=>'topicExportAsHtml',
                    'params'=>array('tsk'=>$task->id),
                    'name'=>__('Export')
                )));
            }

            if(
               ($auth->cur_user->settings & USER_SETTING_ENABLE_EFFORTS)
                && 
                ($project->settings & PROJECT_SETTING_ENABLE_EFFORTS)
            ) {
                $page->add_function(new PageFunction(array(
                    'target'=>'effortNew',
                    'params'=>array(
                        'parent_task'=>$task->id,

                    ),
                    'icon'=>'effort',
                    'name'=>__('Book Effort'),
                )));
            }

            ### new ###
            if($task->category == TCATEGORY_FOLDER) {

                $page->add_function(new PageFunction(array(
                    'target'=>'taskNew',
                    'params'=>array(
                        'parent_task'=>$task->id,
                        'task_category' =>TCATEGORY_DOCU,
                        'task_show_folder_as_documentation' => 1,
                    ),
                    'icon'=>'edit',
                    'name'=>__('New topic'),
                )));
            }
            else if($task->parent_task) {
                $page->add_function(new PageFunction(array(
                    'target'=>'taskNew',
                    'params'=>array(
                        'parent_task' => $task->parent_task,
                        'task_category' =>TCATEGORY_DOCU,
                        'task_show_folder_as_documentation' => 1,
                    ),
                    'icon'=>'edit',
                    'name'=>__('New topic'),
                )));
            }
            else {
                $page->add_function(new PageFunction(array(
                    'target'=>'taskNew',
                    'params'=>array(
                        'prj'=>$task->project,
                        'task_category' =>TCATEGORY_DOCU,
                    ),
                    'icon'=>'edit',
                    'name'=>__('New topic'),
                )));
            }

            if($auth->cur_user->settings & USER_SETTING_ENABLE_BOOKMARKS) {
                require_once(confGet('DIR_STREBER') . 'db/db_itemperson.inc.php');

                $item = ItemPerson::getAll(array('person'=>$auth->cur_user->id,'item'=>$task->id));
                if((!$item) || ($item[0]->is_bookmark == 0)){
                    $page->add_function(new PageFunction(array(
                        'target'    =>'itemsAsBookmark',
                        'params'    =>array('task'=>$task->id),
                        'tooltip'   =>__('Mark this task as bookmark'),
                        'name'      =>__('Bookmark'),
                    )));
                }
                else{
                    $page->add_function(new PageFunction(array(
                        'target'    =>'itemsRemoveBookmark',
                        'params'    =>array('task'=>$task->id),
                        'tooltip'   =>__('Remove this bookmark'),
                        'name'      =>__('Remove Bookmark'),
                    )));
                }
            }
        }

        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);


    #--- navigation structure for documentation --------------------------------------------
    {
        require_once(confGet('DIR_STREBER') . 'lists/list_docustructure.inc.php');
        $list=new Block_DocuNavigation(array(
            'current_task'=> $task
        ));

        $list->print_all();
    }

    #--- info block ------------
    {
        $block=new PageBlock(array(
            'id'=>'summary',
            'reduced_header'=>true,
        ));
        $block->render_blockStart();

        echo "<div class=text>";

        if($person_creator= Person::getVisibleById($task->created_by)) {
            echo "<div class=labeled><label>".__("Created","Label in Task summary")."</label>". renderDateHtml($task->created) . ' / ' . $person_creator->getLink().'</div>' ;
        }

        if($person_modify= Person::getVisibleById($task->modified_by)) {
            echo "<div class=labeled><label>".__("Modified","Label in Task summary")."</label>". renderDateHtml($task->modified) . ' / ' .  $person_modify->getLink() . '</div>' ;
        }

        ### get version ###
        {
            require_once(confGet('DIR_STREBER') . "db/db_itemchange.inc.php");
            $versions= ItemVersion::getFromItem($task);
            if(count($versions) > 1) {
                $str_version=     $PH->getLink('itemViewDiff',
                                    sprintf(__("View previous %s versions"), count($versions)),
                                    array('item' => $task->id)
                                );
                echo "<div class=labeled><label></label>$str_version</div>";
            }
        }


        ### publish to ###
        global $g_pub_level_names;
        if($task->pub_level != PUB_LEVEL_OPEN && isset($g_pub_level_names[$task->pub_level])) {
            echo "<div class=labeled><label>".__("Publish to","Label in Task summary")."</label>".$g_pub_level_names[$task->pub_level] ;
            if($editable) {
                echo '<br>('
                    . $PH->getLink('itemsSetPubLevel',__('Set to Open'), array('item' => $task->id,'item_pub_level' => PUB_LEVEL_OPEN))
                    . ')';
            }
            echo "</div>";
        }
        echo "</div>";

        $block->render_blockEnd();
    }


    #--- list files --------
    {
        require_once(confGet('DIR_STREBER') . 'blocks/files_attached_to_item.inc.php');
        print new FilesAttachedToItemBlock($task);
    }
    

    echo(new PageContentNextCol);


    #--- feedback notice ------------------------------------------------------------
    {
        require_once(confGet('DIR_STREBER') . 'db/db_itemperson.inc.php');        
        if($view = ItemPerson::getAll(array('person'=>$auth->cur_user->id, 'item'=>$task->id, 'feedback_requested_by'=>true))){
            if ($requested_by= Person::getPeople( array( 'id' => $view[0]->feedback_requested_by ) )) {
                echo "<div class=item_notice>";
                echo "<h3>" . sprintf(__("Your feedback is requested by %s."), asHtml($requested_by[0]->nickname) ) . "</h3>";
                echo __("Please edit or comment this item.");
                echo "</div>";
            }
        } 
    }  


    #--- description ----------------------------------------------------------------
    {
        #$descriptionWithUpdates= $task->getTextfieldWithUpdateNotes('description');
        echo "<div class=description>";
        echo wikifieldAsHtml($task, 'description', 
                            array(
                                'empty_text'=> "[quote]" . __("This topic does not have any text yet.\nDoubleclick here to add some.") . "[/quote]",
                            ));

        echo "</div>";

        ### Apply automatic link conversions
        if( checkAutoWikiAdjustments() ) {            
            $task->description= applyAutoWikiAdjustments( $task->description );
            $task->update(array('description'),false);
        }
    }


    #--- list comments --------
    {
        require_once(confGet('DIR_STREBER') . 'blocks/comments_on_item_block.inc.php');
        print new CommentsOnItemBlock($task);
    }


    echo (new PageContentClose);
    echo (new PageHtmlEnd);

    measure_stop("page_render");

    $task->nowViewedByUser();

}


/**
* initialize request feedback autocomplete field
*/
function buildRequestFeedbackInput( $project ) 
{
    $nicknames = array();
    $names = $project->getTeamMemberNames();
    foreach( $names as $nickname => $name) {
        $nicknames[] = asHtml($nickname) ;
    }
    
    return new Form_Input(
        'request_feedback',         # name
        __('Request feedback'),   # title
        '',                         # value
        NULL,                       # tooltip
        false,                      # required
        "request_feedback",         # id
        "",                         # display
        array(                      # input_attributes
            'class' => 'autocomplete',
            'autocomplete_list'=> join($nicknames, ','),
        )                           
    );
}


function buildFileUploadForm( $task )
{
    return
        '<div class=footer_form><h3>'. __('Attach new file').'</h3>'
        .'<input type="hidden" name="parent_task" value="' .$task->id. '">'
        .'<input type="hidden" name="MAX_FILE_SIZE" value="'.confGet('FILE_UPLOAD_SIZE_MAX').'" />'
        .'<input id="userfiletask" name="userfile" type="file" size="3" accept="*" /> '
        .'<input style="margin-top:5px;margin-bottom:5px;margin-left:20px;" class="button" type="button" value="' .__('Upload'). '" onclick=\'document.my_form.go.value="filesUpload";document.my_form.submit();\'/>'
        .'</div>';

}
?>
