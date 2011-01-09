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


require_once(confGet('DIR_STREBER') . 'db/class_issue.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_block.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_block.inc.php');


/**
* Edit a task
*
* @ingroup pages
*/
function taskEdit($task=NULL)
{
    global $PH;



    ### object or from database? ###
    if(!$task) {

        $ids= getPassedIds('tsk','tasks_*');

        if(!$ids) {
            $PH->abortWarning(__("Select some task(s) to edit"), ERROR_NOTE);
            return;
        }
        else if(count($ids) > 1) {
            $PH->show('taskEditMultiple');
            exit();
        }
        else if(!$task= Task::getEditableById($ids[0])) {
            $PH->abortWarning(__("You do not have enough rights to edit this task"), ERROR_RIGHTS);

        }
    }

    ### get parent project ####
    if(!$project= Project::getVisibleById($task->project)) {
        $PH->abortWarning("FATAL error! parent project not found");
    }

    ### abort, if not enough rights ###
    $project->validateEditItem($task);

    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>true,'autofocus_field'=>'task_name'));

        initPageForTask($page, $task, $project);
        
        if($task->id) {
            $page->title=$task->name;
            $page->title_minor=$task->short;
        }
        else {
            if($task->category == TCATEGORY_MILESTONE) {
                $page->title=__("New milestone");
            }            
            else if($task->category == TCATEGORY_VERSION) {
                $page->title=__("New version");
            }            
            else if($task->category == TCATEGORY_DOCU) {
                $page->title=__("New topic");
            }
            else if($task->category == TCATEGORY_FOLDER) {
                $page->title=__("New folder");
            }
            else {
                $page->title=__("New task");
                if($task->parent_task && $parent_task= Task::getVisibleById($task->parent_task)) {
                    $page->title_minor= sprintf(__('for %s','e.g. new task for something'), $parent_task->name);
                }
                else {
                    $page->title_minor= sprintf(__('for %s','e.g. new task for something'), $project->name);
                }
            }
        }

        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
        
        global $auth;
        global $REPRODUCIBILITY_VALUES;

        global $g_prio_names;
        global $g_status_names;

        $block=new PageBlock(array(
            #'title' =>__('Edit Task'),
            'id'    =>'functions',
        ));
        $block->render_blockStart();


        $form=new PageForm();
        $form->button_cancel=true;

        $form->add($task->fields['name']->getFormElement($task));

        ### task category ###
        {
            $list= array();                       
            if($task->category == TCATEGORY_MILESTONE ||  $task->category == TCATEGORY_VERSION) {
                $list= array(TCATEGORY_MILESTONE, TCATEGORY_VERSION);

                ### make sure it's valid
                if($task->category != TCATEGORY_MILESTONE || $task->category != TCATEGORY_VERSION) {
                    if($task->is_released > RELEASED_UPCOMMING) {
                        $task->category= TCATEGORY_VERSION;
                    }
                    else {
                        $task->category= TCATEGORY_MILESTONE;
                    }
                }
            }
            else {
                $list=array();
                if($project->settings & PROJECT_SETTING_ENABLE_TASKS) {
                    $list[]= TCATEGORY_TASK;
                }
                if($project->settings & PROJECT_SETTING_ENABLE_BUGS) {
                    $list[]= TCATEGORY_BUG;
                }
                $list[]= TCATEGORY_DOCU;
                $list[]= TCATEGORY_FOLDER;
            }
            global $g_tcategory_names;
            $cats= array();
            foreach($list as $c) {
                $cats[$c]= $g_tcategory_names[$c];
            }
            $form->add(new Form_Dropdown('task_category',  __("Display as"),array_flip($cats),$task->category));

            ### warning if folder with subtasks ###
            if($task->id && $task->category == TCATEGORY_FOLDER && ($num_subtasks= count($task->getSubtasks()))) {
                $form->add(new Form_CustomHtml('<p><label></label>'. sprintf(__("This folder has %s subtasks. Changing category will ungroup them."), $num_subtasks) . '</p>'));
            }
        }

        $form->add($tab_group= new Page_TabGroup());

        ### task attributes ###
        {
            $tab_group->add($tab= new Page_Tab('task', __("Task")));

            ### normaltasks and folders ##
            if(!$task->isMilestoneOrVersion()) {
                if($project->settings & PROJECT_SETTING_ENABLE_MILESTONES) {
                    $tab->add( new Form_DropdownGrouped('task_for_milestone', 
                                                    __('For Milestone'), 
                                                    $project->buildPlannedForMilestoneList(), 
                                                    $task->for_milestone
                                                 ));

                    
                }

                ### prio ###
                if($task->category != TCATEGORY_MILESTONE && $task->category != TCATEGORY_VERSION) {
                    $tab->add(new Form_Dropdown('task_prio',  __("Prio","Form label"),  array_flip($g_prio_names), $task->prio));
                }
            }

            ### assigned to ###
            {
                ### for existing tasks, get already assigned
                if($task->id) {
                    $assigned_persons = $task->getAssignedPersons();
                    #$task_assignments = $task->getAssignments();
                }

                ### for new tasks get the assignments from parent task ###

                /**
                * Some notes on assigning persons
                *
                * Passing this information is tricky because:
                * - multiple persons could be assigned to a task
                * - task-assignments for new tasks can't be stored to database until the task
                *   has finally been validated and stored itself. Therefore this information has
                *   to be passed in hiddenfields named "task_assign_to_#" whereas # is an integer counting
                *   up from 0.
                * - additionally all persons have to be checked for visibility and if they are already
                *   assigned to this task.
                *
                *   To automatically assign new tasks to persons there are two possibilites:
                *   1. pass 'task_assign_to_#" - parameters
                *   2. pass 'parent_task' - parameter which is been assigned to a person
                *
                *   The first options beats the second.
                */
                else {
                    ### check new assigments ###
                    $count=0;

                    while($id_new= get('task_assign_to_'.$count)) {
                        $count++;

                        ### check if already assigned ###
                        if($p= Person::getVisibleById($id_new)) {
                            $assigned_persons[]= $p;
                        }
                    }

                    if(!$count) {
                        $parents= $task->getFolder();

                        if($parents) {
                            $parents= array_reverse($parents);

                            foreach($parents as $p) {
                                if($ap= $p->getAssignedPersons()) {
                                    $assigned_persons= $ap;
                                    break;

                                }
                            }
                        }
                    }
                }

                $team=array(__('- select person -')=>0);

                ### create team-list ###
                foreach($project->getPersons() as $p) {
                    $team[$p->name]= $p->id;
                }


                ### create drop-down-lists ###
                $count_new=0;
                $count_all=0;
                if(isset($assigned_persons)) {
                    foreach($assigned_persons as $ap) {
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


            ### completion ###
            if(!$task->is_released > RELEASED_UPCOMMING) {
                #$form->add($task->fields['estimated'    ]->getFormElement($task));
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

                $field_status=new Form_Dropdown('task_status',"Status",array_flip($st),  $task->status);
                if($task->fields['status']->invalid) {
                    $field_status->invalid= true;
                }
                $tab->add($field_status);
            }

            if(!$task->isMilestoneOrVersion()) {

                if($project->settings & PROJECT_SETTING_ENABLE_MILESTONES) {

                    ### resolved version ###
                    $tab->add(new Form_DropdownGrouped('task_resolved_version', __('Resolved in'), $project->buildResolvedInList(), $task->resolved_version));
                }

                ### resolved reason ###
                global $g_resolve_reason_names;
                $tab->add(new Form_Dropdown('task_resolve_reason', __('Resolve reason'),array_flip($g_resolve_reason_names), $task->resolve_reason));
            }


        }

        ### bug report ###
        {
            $tab_group->add($tab= new Page_Tab("bug",__("Bug Report")));

            ### use issue-report ###
            global $g_severity_names;
            global $g_reproducibility_names;

            ### create new one ###
            if($task->issue_report <= 0) {
                $issue= new Issue(array('id'=>0));

                ### get recent issue-reports ###
                if($recent_ir=Issue::getCreatedRecently()) {
                    $default_version='';
                    $default_plattform='';
                    $default_production_build='';
                    $default_os='';

                    foreach($recent_ir as $ir){
                        if($ir->project == $project->id) {
                            if(!$issue->version && $ir->version) {
                                $issue->version= $ir->version;
                            }
                            if(! $issue->plattform && $ir->plattform) {
                                $issue->plattform= $ir->plattform;
                            }
                            if(! $issue->os && $ir->os) {
                                $issue->os= $ir->os;
                            }
                            if(! $issue->production_build && $ir->production_build) {
                                $issue->production_build= $ir->production_build;
                            }
                        }
                    }
                }
            }
            else {
                /**
                * note: if task is visible ignore visibility of issue report
                */
                $issue= Issue::getById($task->issue_report);

            }

            if($issue) {

                $tab->add(new Form_Dropdown('issue_severity',       __("Severity","Form label, attribute of issue-reports"),        array_flip($g_severity_names),        $issue->severity));
                $tab->add(new Form_Dropdown('issue_reproducibility',__("Reproducibility","Form label, attribute of issue-reports"), array_flip($g_reproducibility_names), $issue->reproducibility));
                foreach($issue->fields as $field) {
                    $tab->add($field->getFormElement($issue));
                }
                $tab->add(new Form_HiddenField('task_issue_report','',$task->issue_report));
            }
            else {
                trigger_error("could not get Issue with id ($task->issue-report)", E_USER_NOTICE);
            }
        }

        ### timing ###
        {
            $tab_group->add($tab= new Page_Tab("timing",__("Timing")));

            ### estimated ###
            if(!$task->isMilestoneOrVersion()){
                #$tab->add($task->fields['estimated'    ]->getFormElement($task));
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
                    #__('1,5 Weeks')=> 1.5 * confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60,
                    __('2 Weeks')  =>   2 * confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60,
                    __('3 Weeks')  =>   3 * confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60,
                );
                $tab->add(new Form_Dropdown('task_estimated',__("Estimated time"),$ar,  $task->estimated));
                $tab->add(new Form_Dropdown('task_estimated_max',__("Estimated worst case"),$ar,  $task->estimated_max));

            }


            ### planned time ###
            if(!$task->isMilestoneOrVersion()) {
                $tab->add($task->fields['planned_start'     ]->getFormElement($task));
            }
            $tab->add($task->fields['planned_end' ]->getFormElement($task));

            if($task->isMilestoneOrVersion()) {
                global $g_released_names;
                $tab->add(new Form_Dropdown('task_is_released',       __("Release as version","Form label, attribute of issue-reports"),        array_flip($g_released_names),        $task->is_released));

                $tab->add($task->fields['time_released']->getFormElement($task));
            }

        }

        ### description attributes ###
        {
            $tab_group->add($tab= new Page_Tab('description', __("Description")));

            $e= $task->fields['description']->getFormElement($task);
            $e->rows=20;
            $tab->add($e);
        }

        ### display attributes ###
        {
            $tab_group->add($tab= new Page_Tab('display',__("Display")));


            ### short ###
            $tab->add($task->fields['short']->getFormElement($task));


            ### order id ###
            $tab->add($task->fields['order_id']->getFormElement($task));

            ### Shows as news ###
            $tab->add($task->fields['is_news']->getFormElement($task));

            ### Shows Folder as documentation ###
            $tab->add($task->fields['show_folder_as_documentation']->getFormElement($task));

            ### public-level ###
            if(($pub_levels=$task->getValidUserSetPublicLevels())
                && count($pub_levels)>1) {
                $tab->add(new Form_Dropdown('task_pub_level',  __("Publish to"),$pub_levels,$task->pub_level));
            }


            ### label ###
            if(!$task->isOfCategory(TCATEGORY_VERSION, TCATEGORY_MILESTONE, TCATEGORY_FOLDER)) {
                $labels=array(__('undefined') => 0);
                $counter= 1;
                foreach(explode(",",$project->labels) as $l) {
                    $labels[$l]=$counter++;
                }
                $tab->add(new Form_Dropdown('task_label',  __("Label"),$labels,$task->label));
            }
        }

        ## internal area ##
        {
            if((confGet('INTERNAL_COST_FEATURE')) && ($auth->cur_user->user_rights & RIGHT_VIEWALL) && ($auth->cur_user->user_rights & RIGHT_EDITALL)){
                $tab_group->add($tab=new Page_Tab("internal",__("Internal")));
                $tab->add($task->fields['calculation']->getFormElement($task));
            }
        }


        /**
        * to reduce spam, enforce captcha test for guests
        */
        global $auth;
        if($auth->cur_user->id == confGet('ANONYMOUS_USER')) {
            $form->addCaptcha();
        }


        $form->add($task->fields['parent_task']->getFormElement($task));


        #echo "<input type=hidden name='tsk' value='$task->id'>";
        $form->add(new Form_HiddenField('tsk','',$task->id));

        #echo "<input type=hidden name='task_project' value='$project->id'>";
        $form->add(new Form_HiddenField('task_project','',$project->id));

        ### create another task ###
        if($task->id == 0) {
            $checked= get('create_another')
            ? 'checked'
            : '';

            $form->form_options[]="<input id='create_another' name='create_another' type=checkbox $checked><label for='create_another'>" . __("Create another task after submit") . "</label>";     ;
        }

        echo($form);

        $PH->go_submit= 'taskEditSubmit';
        if($return=get('return')) {
            echo "<input type=hidden name='return' value='$return'>";
        }

        $block->render_blockEnd();

        #@@@ passing project-id is an security-issue, because it might allow to add tasks to unverified projects.
        # Double-checking project-rights in taskEditSubmit() required
    }

    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}
?>