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
                    $assigned_people = $task->getAssignedPeople();
                    #$task_assignments = $task->getAssignments();
                }

                ### for new tasks get the assignments from parent task ###

                /**
                * Some notes on assigning people
                *
                * Passing this information is tricky because:
                * - multiple people could be assigned to a task
                * - task-assignments for new tasks can't be stored to database until the task
                *   has finally been validated and stored itself. Therefore this information has
                *   to be passed in hiddenfields named "task_assign_to_#" whereas # is an integer counting
                *   up from 0.
                * - additionally all people have to be checked for visibility and if they are already
                *   assigned to this task.
                *
                *   To automatically assign new tasks to people there are two possibilites:
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
                            $assigned_people[]= $p;
                        }
                    }

                    if(!$count) {
                        $parents= $task->getFolder();

                        if($parents) {
                            $parents= array_reverse($parents);

                            foreach($parents as $p) {
                                if($ap= $p->getAssignedPeople()) {
                                    $assigned_people= $ap;
                                    break;

                                }
                            }
                        }
                    }
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



/**
* Submit changes to a task
*
* @ingroup pages
*/
function taskEditSubmit()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'db/class_taskperson.inc.php');

    /**
    * keep a list of items linking to this task, task is new
    * we have to change the linking id after(!) inserting the task
    */
    $link_items=array();


    ### temporary object or from database? ###
    $tsk_id=getOnePassedId('tsk','',true,'invalid id');
    if($tsk_id == 0) {
        $task= new Task(array(
            'id'=>0,
            'project'=>get('task_project'),
        ));
        $was_category= 0;                       # undefined category for new tasks
        $was_resolved_version= 0;
    }
    else {
        if(!$task= Task::getVisiblebyId($tsk_id)) {
            $PH->abortWarning("invalid task-id");
        }
        $was_category=$task->category;
        $was_resolved_version= $task->resolved_version;
        $task->validateEditRequestTime();
    }


    ### cancel? ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('taskView',array('tsk'=>$task->id));
        }
        exit();
    }

    ### Validate integrety ###
    if(!validateFormCrc()) {
        $PH->abortWarning(__('Invalid checksum for hidden form elements'));
    }
    
    validateFormCaptcha(true);



    $was_a_folder= ($task->category == TCATEGORY_FOLDER)
                 ? true
                 : false;
    $was_released_as= $task->is_released;


    ### get project ###
    if(!$project= Project::getVisiblebyId($task->project)) {
        $PH->abortWarning("task without project?");
    }

    /**
    * adding comment (from quick edit) does only require view right...
    */
    $added_comment= false;
    {
        ### check for request feedback
        if($request_feedback= get('request_feedback')) {
            $team_members_by_nickname = array();

            foreach($project->getProjectPeople() as $pp) {
                $team_members_by_nickname[ $pp->getPerson()->nickname ] = $pp->getPerson();
            }
            $requested_people= array();

            foreach( explode('\s*,\s*', $request_feedback) as $nickname) {
                
                ### now check if this nickname is a team member
                if ($nickname = trim($nickname)) {
                    if ( isset( $team_members_by_nickname[$nickname] )) {
                        $person = $team_members_by_nickname[$nickname];

                        ### update to itemperson table...
                        if($view = ItemPerson::getAll(array('person'=>$person->id, 'item'=>$task->id))){
                            $view[0]->feedback_requested_by = $auth->cur_user->id;
                            $view[0]->update();
                        }
                        else{
                            $new_view = new ItemPerson(array(
                            'item'          =>$task->id,
                            'person'        =>$person->id,
                            'feedback_requested_by'=> $auth->cur_user->id ));
                            $new_view->insert();
                        }
                        $requested_people[]= "<b>". asHtml($nickname) ."</b>";
                    }
                    else {
                        new FeedbackWarning(sprintf(__("Nickname not known in this project: %s"), "<b>". asHtml($nickname) ."</b>"));
                    }
                } 
            }
            if( $requested_people ) {
                new FeedbackMessage(sprintf(__('Requested feedback from: %s.'), join($requested_people, ", ")));
            }
        }

        ### only insert the comment, when comment name or description are valid
        if(get('comment_name') || get('comment_description')) {

            require_once(confGet('DIR_STREBER') . 'pages/comment.inc.php');
            $valid_comment= true;

            ### new object? ###
            $comment= new Comment(array(
                'name'=> get('comment_name'),
                'description' =>get('comment_description'),
                'project' => $task->project,
                'task' => $task->id
            ));
            validateNotSpam($comment->name . $comment->description);

            ### write to db ###
            if($valid_comment) {
                if(!$comment->insert()) {
                    new FeedbackWarning(__("Failed to add comment"));
                }
                else {
                    ### change task update modification date ###
                    if(isset($task)) {
                        ### Check if now longer new ###
                        if($task->status == STATUS_NEW) {
                            global $auth;
                            if($task->created < $auth->cur_user->last_login) {
                                $task->status = STATUS_OPEN;
                            }
                        }
                        $task->update(array('modified','status'));
                    }

                    $added_comment= true;
                }
            }
        }
    }



    if($task->id != 0 && ! Task::getEditableById($task->id)) {

        if($added_comment) {
            ### display taskView ####
            if(!$PH->showFromPage()) {
                $PH->show('home',array());
            }
            exit();
        }
        else {
            $PH->abortWarning(__("Not enough rights to edit task"));
        }
    }


    $task->validateEditRequestTime();
    $status_old = $task->status;

    # retrieve all possible values from post-data (with field->view_in_forms == true)
    # NOTE:
    # - this could be an security-issue.
    # @@@ TODO: as some kind of form-edit-behaviour to field-definition
    foreach($task->fields as $f) {
        $name=$f->name;
        $f->parseForm($task);
    }

    $task->fields['parent_task']->parseForm($task);

    ### category ###
    $was_of_category = $task->category;
    if(!is_null($c= get('task_category'))) {
        global $g_tcategory_names;
        if(isset($g_tcategory_names[$c])) {
            $task->category= $c;
        }
        else {
            trigger_error("ignoring unknown task category '$c'", E_USER_NOTICE);
        }
    }
    /**
    * @@@pixtur 2006-11-17: actually this has been depreciated. is_folder updated
    * for backward compatibility only.
    */
    $task->is_folder = ($task->category == TCATEGORY_FOLDER)
                     ? 1
                     : 0;

    ### Check if now longer new ###
    if($status_old == $task->status && $task->status == STATUS_NEW) {
        global $auth;
        if($task->created < $auth->cur_user->last_login) {
            $task->status = STATUS_OPEN;
        }
    }


    /**
    * assigned to...
    * - assigments are stored in form-fiels named 'task_assign_to_??' and 'task_assigned_to_??"...
    *   ... where ?? being the id of the last assigned person(s)
    *
    * - builds up multiple arrays of person-objects (reusing the same objects due to caching)
    *   - get already assigned people into  dict. of person_id => Person
    *   - get assignments into dict. of person_id => Person
    *   - get current project-team as dict of person_id => Person
    * - checks for double-assigments
    *
    */
    {

        $assigned_people = array();
        $task_assignments = array();

        if($task->id) {
            foreach($task->getAssignedPeople() as $p) {
                $assigned_people[$p->id] = $p;
            }

            foreach($task->getAssignments() as $ta) {
                $task_assignments[$ta->person]= $ta;
            }
        }

        $team= array();
        foreach($project->getPeople() as $p) {
            $team[$p->id]= $p;
        }

        $new_task_assignments= array();                     # store assigments after(!) validation
        $forwarded = 0;
        $forward_comment = '';
        $old_task_assignments = array();
        
        if(isset($task_assignments)) {
            foreach($task_assignments as $id=>$t_old) {
                $id_new= get('task_assigned_to_'.$id);
                $forward_state = get('task_forward_to_'.$id);
                if($forward_state){
                    $forwarded = 1;
                }
                else{
                    $forwarded = 0;
                }
                $forward_comment = get('task_forward_comment_to_'.$id);
                
                if($id_new === NULL) {
                    log_message("failure. Can't change no longer existing assigment (person-id=$id item-id=$t_old->id)", LOG_MESSAGE_DEBUG);
                    #$PH->abortWarning("failure. Can't change no longer existing assigment",ERROR_NOTE);
                    continue;
                }
                
                if($id == $id_new) {
                    if($tp = TaskPerson::getTaskPeople(array('person'=>$id, 'task'=>$task->id))){
                        $tp[0]->forward = $forwarded;
                        $tp[0]->forward_comment = $forward_comment;
                        $old_task_assignments[] = $tp[0];
                    }
                    #echo " [$id] {$team[$id]->name} still assigned<br>";
                    continue;
                }

                if($id_new == 0) {
                    if(!$t_old) {
                        continue;
                    }
                    #echo " [$id] {$team[$id]->name} unassigned<br>";
                    $t_old->delete();
                    continue;
                }

                #$t_new= $task_assignments[$id_new];
                $p_new = @$team[$id_new];
                if(!isset($p_new)) {
                    $PH->abortWarning("failure during form-value passing",ERROR_BUG);
                }
                #echo " [$id] assignment changed from {$team[$id]->name} to {$team[$id_new]->name}<br>";
    
                $t_old->comment = sprintf(__("unassigned to %s","task-assignment comment"),$team[$id_new]->name);
                $t_old->update();
                $t_old->delete();
                $new_assignment= new TaskPerson(array(
                    'person'=> $team[$id_new]->id,
                    'task'  => $task->id,
                    'comment'=>sprintf(__("formerly assigned to %s","task-assigment comment"), $team[$id]->name),
                    'project'=>$project->id,
                    'forward'=>$forwarded,
                    'forward_comment'=>$forward_comment,
                ));

                $new_task_assignments[]=$new_assignment;
                $link_items[]=$new_assignment;
            }
        }

        ### check new assigments ###
        $count=0;
        while($id_new= get('task_assign_to_'.$count)) {
            
            $forward_state = get('task_forward_to_'.$count);
            if($forward_state){
                $forwarded = 1;
            }
            else{
                $forwarded = 0;
            }
            $forward_comment = get('task_forward_comment_to_'.$count);
            
            $count++;
            
            ### check if already assigned ###
            if(isset($task_assignments[$id_new])) {
                if($tp = TaskPerson::getTaskPeople(array('person'=>$id_new,'task'=>$task->id))){
                    $tp[0]->forward = $forwarded;
                    $tp[0]->forward_comment = $forward_comment;
                    $old_task_assignments[] = $tp[0];
                }

                #new FeedbackMessage(sprintf(__("task was already assigned to %s"),$team[$id_new]->name));
            }
            else {
                if(!isset($team[$id_new])) {
                    $PH->abortWarning("unknown person id $id_new",ERROR_DATASTRUCTURE);
                }

                $new_assignment= new TaskPerson(array(
                    'person'=> $team[$id_new]->id,
                    'task'  => $task->id,
                    'comment'=>"",
                    'project'=>$project->id,
                    'forward'=>$forwarded,
                    'forward_comment'=>$forward_comment,
                ));

                /**
                * BUG?
                * - inserting the new assigment before sucessfully validating the
                *   task will lead to double-entries in the database.
                */
                $new_task_assignments[] = $new_assignment;

                #$new_assignment->insert();
                $link_items[]=$new_assignment;
            }
        }
    }
    
    if($task->isOfCategory(array(TCATEGORY_VERSION, TCATEGORY_MILESTONE))) {
        if($is_released=get('task_is_released')) {
            if(!is_null($is_released)) {
                $task->is_released = $is_released;
            }
        }
    }

    ### pub level ###
    if($pub_level=get('task_pub_level')) {
        if($task->id) {
             if($pub_level > $task->getValidUserSetPublicLevels() ) {
                 $PH->abortWarning('invalid data',ERROR_RIGHTS);
             }
        }
        #else {
        #    #@@@ check for person create rights
        #}
        $task->pub_level = $pub_level;
    }

    ### check project ###
    if($task->id == 0) {
        if(!$task->project=get('task_project')) {
            $PH->abortWarning("task requires project to be set");
        }
    }

    ### get parent_task ###
    $is_ok= true;
    $parent_task= NULL;
    if($task->parent_task) {
        $parent_task= Task::getVisibleById($task->parent_task);
    }

    ### validate ###
    if(!$task->name) {
        new FeedbackWarning(__("Task requires name"));
        $task->fields['name']->required=true;
        $task->fields['name']->invalid=true;
        $is_ok= false;
    }
    ### task-name already exist ###
    else if($task->id == 0){
        $other_tasks = array();

        if($parent_task) {
            $other_tasks= Task::getAll(array(
                'project' => $project->id,
                'parent_task'=> $parent_task->id,
                'status_min'=> STATUS_NEW,
                'status_max'=> STATUS_CLOSED,
                'visible_only' => false,
            ));
        }
        else {
            $other_tasks= Task::getAll(array(
                'project' => $project->id,
                'parent_task'=> 0,
                'status_min'=> STATUS_NEW,
                'status_max'=> STATUS_CLOSED,
                'visible_only' => false,
            ));
        }
        foreach($other_tasks as $ot) {
            if(!strcasecmp($task->name, $ot->name)) {
                $is_ok = false;
                new FeedbackWarning(sprintf(__('Task called %s already exists'), $ot->getLink(false)));
                break;
            }
        }
    }

    ### automatically close resolved tasks ###
    if($task->resolve_reason && $task->status < STATUS_COMPLETED) {
        $task->status = STATUS_COMPLETED;
        new FeedbackMessage(sprintf(__('Because task is resolved, its status has been changed to completed.')));
    }


    ### Check if resolved tasks should be completed ###
    if($task->resolved_version != 0 && $task->status < STATUS_COMPLETED) {
        new FeedbackWarning(sprintf(__('Task has resolved version but is not completed?')));
        $task->fields['resolved_version']->invalid= true;
        $task->fields['status']->invalid= true;
        $is_ok = false;
    }

    ### Check if completion should be 100% ###
    if ($task->status >= STATUS_COMPLETED) {
        $task->completion = 100;
    }


    ### repeat form if invalid data ###
    if(!$is_ok) {
        $PH->show('taskEdit',NULL,$task);
        exit();
    }

    #--- write to database -----------------------------------------------------------------------

    #--- be sure parent-task is folder ---
    if($parent_task) {

        if($parent_task->isMilestoneOrVersion()) {
            if($parent_task->is_folder) {
                $parent_task->is_folder= 0;
                $parent_task->update(array('is_folder'),false);
            }
            $PH->abortWarning(__("Milestones may not have sub tasks"));
        }
        else if($parent_task->category != TCATEGORY_FOLDER) {
            $parent_task->category= TCATEGORY_FOLDER;
            $parent_task->is_folder= 1;
            if($parent_task->update()) {
                new FeedbackMessage(__("Turned parent task into a folder. Note, that folders are only listed in tree"));
            }
            else {
                trigger_error(__("Failed, adding to parent-task"),E_USER_WARNING);
                $PH->abortWarning(__("Failed, adding to parent-task"));

            }
        }
    }

    ### ungroup child tasks? ###
    if($was_a_folder && $task->category != TCATEGORY_FOLDER) {

        $num_subtasks= $task->ungroupSubtasks();            # @@@ does this work???


        /**
        * note: ALSO invisible tasks should be updated, so do not check for visibility here.
        */
        $parent= Task::getById($task->parent_task);
        $parent_str= $parent
            ? $parent->name
            : __('Project');

        if($num_subtasks) {
            new FeedbackMessage(sprintf(__("NOTICE: Ungrouped %s subtasks to <b>%s</b>"),$num_subtasks, $parent_str));
        }
    }

    if($task->id && !get('task_issue_report')) {
        $task_issue_report = $task->issue_report;
    }
    else if($task->issue_report != get('task_issue_report')) {
        trigger_error("Requesting invalid issue report id for task!", E_USER_WARNING);
        $task_issue_report= get('task_issue_report');
    }
    else {
        $task_issue_report = 0;
    }
    
        
    ### consider issue-report? ###
    #$task_issue_report= get('task_issue_report');
    if( $task->category == TCATEGORY_BUG || (isset($task_issue_report) && $task_issue_report) ) {


        ### new report as / temporary ###
        if($task_issue_report == 0 || $task_issue_report == -1) {

            $issue= new Issue(array(
                'id'=>0,
                'project'   => $project->id,
                'task'      => $task->id,
            ));

            ### querry form-information ###
            foreach($issue->fields as $f) {
                $name=$f->name;
                $f->parseForm($issue);
            }

            global $g_reproducibility_names;
            if(!is_null($rep= get('issue_reproducibility'))) {
                if(isset($g_reproducibility_names[$rep])) {
                    $issue->reproducibility= intval($rep);
                }
                else {
                    $issue->reproducibility= REPRODUCIBILITY_UNDEFINED;
                }
            }

            global $g_severity_names;
            if(!is_null($sev= get('issue_severity'))) {
                if(isset($g_severity_names[$sev])) {
                    $issue->severity= intval($sev);
                }
                else {
                    $issue->severity= SEVERITY_UNDEFINED;
                }
            }

            ### write to db ###
            if(!$issue->insert()) {
                trigger_error("Failed to insert issue to db",E_USER_WARNING);
            }
            else {
                $link_items[]= $issue;
                $task->issue_report= $issue->id;
            }
        }
        ### get from database ###
        else if($issue= Issue::getById($task_issue_report)) {

            ### querry form-information ###
            foreach($issue->fields as $f) {
                $name=$f->name;
                $f->parseForm($issue);
            }

            global $g_reproducibility_names;
            if(!is_null($rep= get('issue_reproducibility'))) {
                if(isset($g_reproducibility_names[$rep])) {
                    $issue->reproducibility= intval($rep);
                }
                else {
                    $issue->reproducibility= REPRODUCIBILITY_UNDEFINED;
                }
            }

            global $g_severity_names;
            if(!is_null($sev= get('issue_severity'))) {
                if(isset($g_severity_names[$sev])) {
                    $issue->severity= intval($sev);
                }
                else {
                    $issue->severity= SEVERITY_UNDEFINED;
                }
            }


            ### write to db ###
            if(!$issue->update()) {
                trigger_error("Failed to write issue to DB (id=$issue->id)", E_USER_WARNING);
            }

            if($task->issue_report != $issue->id) {         # additional check, actually not necessary
                trigger_error("issue-report as invalid id ($issue->id). Should be ($task->issue_report) Please report this bug.",E_USER_WARNING);
            }
        }
        else {
            trigger_error("Could not get issue with id $task->issue_report from database",E_USER_WARNING);
        }
    }

    ### write to db ###
    if($task->id == 0) {
        $task->insert();

        ### write task-assigments ###
        foreach($new_task_assignments as $nta) {
            $nta->insert();
        }

        ### now we now the id of the new task, link the other items
        foreach($link_items as $i) {
            $i->task= $task->id;
            $i->update();
        }        
        new FeedbackMessage(sprintf(__("Created %s %s with ID %s","Created <type> <name> with ID <id>..."),  
                $task->getLabel(),
                $task->getLink(false),
                $task-> id)
            );
    }
    else {

        ### write task-assigments ###
        foreach($new_task_assignments as $nta) {
            $nta->insert();
        }
        
        foreach($old_task_assignments as $ota){
            $ota->update();
        }

        new FeedbackMessage(sprintf(__("Changed %s %s with ID %s","type,link,id"),  $task->getLabel(), $task->getLink(false),$task->id));
        $task->update();
        $project->update(array(), true);
    }


    ### add any recently resolved tasks if this is a just released version  ###
    if($task->category == TCATEGORY_VERSION && $was_category != TCATEGORY_VERSION) {
        if($resolved_tasks= Task::getAll(array(
            'project'           => $task->project,
            'status_min'        => 0,
            'status_max'        => 10,
            'resolved_version'  => RESOLVED_IN_NEXT_VERSION,
        ))) {
            foreach($resolved_tasks as $rt) {
                $rt->resolved_version= $task->id;
                $rt->update(array('resolved_version'));
            }
            new FeedbackMessage(sprintf(__('Marked %s tasks to be resolved in this version.'), count($resolved_tasks)));
        }
    }

    ### notify on change ###
    $task->nowChangedByUser();

    ### create another task ###
    if(get('create_another')) {


        ### build dummy form ###
        $newtask= new Task(array(
            'id'        =>0,
            'name'      =>__('Name'),
            'project'   =>$task->project,
            'state'     =>1,
            'prio'      =>$task->prio,
            'label'     =>$task->label,
            'parent_task'=>$task->parent_task,
            'for_milestone'=>$task->for_milestone,
            'category'  =>$task->category,
        ));


        $PH->show('taskEdit',array('tsk'=>$newtask->id),$newtask);
    }
    else {

        ### go to task, if new
        if($tsk_id == 0) {
            $PH->show('taskView',array('tsk' => $task->id));
            exit();
        }
        ### display taskView ####
        else if(!$PH->showFromPage()) {
            $PH->show('home',array());
        }
    }
}











?>