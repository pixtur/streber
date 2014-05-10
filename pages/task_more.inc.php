<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file   pages for working with tasks */

require_once(confGet('DIR_STREBER') . 'db/class_issue.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_taskfolders.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_comments.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_taskperson.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . 'db/db_itemperson.inc.php');


/**
* Create a task as bug
*
* @ingroup pages
*/
function taskNewBug()
{
    $foo=array(
        'add_issue'=>1,
        'task_category' =>TCATEGORY_BUG
        );
    addRequestVars($foo);
    TaskNew();
    exit();
}

/**
* Create a task as docu page
*
* @ingroup pages
*/
function taskNewDocu()
{
    $foo=array(
        'task_category' =>TCATEGORY_DOCU,
        'show_folder_as_documentation' => 1,
        );
    addRequestVars($foo);
    TaskNew();
    exit();
}


/**
* Create a new milestone
*
* @ingroup pages
*/
function TaskNewMilestone()
{
    global $PH;

    $prj_id=getOnePassedId('prj','',true,__('No project selected?')); # aborts with error if not found
    if(!$project= Project::getVisibleById($prj_id)) {
        $PH->abortWarning("invalid project-id",ERROR_FATAL);
    }


    ### build dummy form ###
    $newtask= new Task(array(
        'id'        =>0,
        'name'      =>__("New Milestone"),
        'project'   =>$prj_id,
        'category' =>TCATEGORY_MILESTONE,
        'status'    =>STATUS_OPEN,
        )
    );
    $PH->show('taskEdit',array('tsk'=>$newtask->id),$newtask);

}


/**
* Create a task as Version
*
* @ingroup pages
*/
function TaskNewVersion()
{
    global $PH;

    $prj_id=getOnePassedId('prj','',true,__('No project selected?')); # aborts with error if not found
    if(!$project= Project::getVisibleById($prj_id)) {
        $PH->abortWarning("invalid project-id",ERROR_FATAL);
    }

    ### build dummy form ###
    $newtask= new Task(array(
        'id'            => 0,
        'name'          => __("New Version"),
        'project'       => $prj_id,
        'status'        => STATUS_APPROVED,
        'completion'    => 100,
        'category' =>TCATEGORY_VERSION,
        'is_released'   => RELEASED_PUBLIC,
        'time_released' => getGMTString(),
        )
    );
    $PH->show('taskEdit',array('tsk'=>$newtask->id),$newtask);
}





/**
* create new folder
*
* @ingroup pages
*/
function TaskNewFolder()
{
    global $PH;

    $prj_id=getOnePassedId('prj','',true,__('No project selected?')); # aborts with error if not found
    if(!$project= Project::getVisibleById($prj_id)) {
        $PH->abortWarning("invalid project-id",ERROR_FATAL);
    }

    ### for milestone ###
    if( $milestone= Task::getVisibleById(get('for_milestone'))) {
        $for_milestone= $milestone->id;
    }
    else {
        $for_milestone= 0;
    }


    ### get id of parent_task
    $parent_task_id=0;
    {
        $task_ids= GetPassedIds('parent_task','folders_*'); # aborts with error if not found
        if(count($task_ids) >= 1) {
            $parent_task_id= $task_ids[0];
        }
    }

    ### build dummy form ###
    $newtask= new Task(array(
        'id'        =>0,
        'name'      =>__("New folder"),
        'project'   =>$prj_id,
        'is_folder' =>1,                                    #@@@ depreciated!
        'category' =>TCATEGORY_FOLDER,
        'parent_task'=>$parent_task_id,
        'for_milestone'=>$for_milestone,
        )
    );
    $PH->show('taskEdit',array('tsk'=>$newtask->id),$newtask);
}


/**
* start taskEdit-form with a new task
* - figure out prio,label and estimated time from name
*
* @ingroup pages
*/
function TaskNew()
{
    global $PH;

    $parent_task = NULL;
    $parent_task_id =0;

    ### try to figure out parent_task ###
    if($task_ids=getPassedIds('parent_task','tasks_*|folders_*',false)) {

        if(count($task_ids) != 1) {
            $PH->abortWarning(__("Please select only one item as parent"),ERROR_NOTE);
        }
        if($task_ids[0] != 0) {
            if(!$parent_task = Task::getVisibleById($task_ids[0])) {
                $PH->abortWarning(__("Insufficient rights for parent item."),ERROR_NOTE);
            }
            $parent_task_id= $parent_task->id;
        }
        else {
            $parent_task_id= 0;
        }
    }
    else {
        $parent_task_id= 0;
    }

    ### figure out project ###
    $prj_id= getOnePassedId('prj','projects_*',false);          # NOT aborts with error if not found
    if(!$prj_id) {
        if(!$parent_task) {
            $PH->abortWarning(__("could not find project"),ERROR_NOTE);
        }
        $prj_id= $parent_task->project;

    }
    if(!$project= Project::getVisibleById($prj_id)) {
        $PH->abortWarning(__("could not find project"),ERROR_NOTE);
    }

    ### make sure parent_task is valid ###
    if($parent_task_id && !$parent_task = Task::getVisibleById($parent_task_id)) {
        $PH->abortWarning(__("Parent task not found."), ERROR_NOTE);
    }


    $name= html_entity_decode(get('new_name'));  # @@@ hack to get rid of slashed strings
    $estimated='00:00:00';

    ### for milestone ###
    $for_milestone_id= 0;
    if( $milestone= Task::getVisibleById(get('for_milestone'))) {
        $for_milestone_id= $milestone->id;
    }

    ### if parent-task is milestone for some reason, avoid parenting ###
    if($parent_task && ($parent_task->category == TCATEGORY_MILESTONE || $parent_task->category == TCATEGORY_VERSION)) {
        $parent_task_id=0;
        if(!$for_milestone_id) {
            $for_milestone_id= $parent_task->id;

        }
    }

    ### category ###
    $category= TCATEGORY_TASK;
    if(!is_null($cat= get('task_category'))) {
        global $g_tcategory_names;
        if(!isset($g_tcategory_names[$cat])) {
            $category= TCATEGORY_TASK;
        }
        else {
            $category= $cat;
        }
    }

    $folder_as_docu= get('task_show_folder_as_documentation',
        ($category == TCATEGORY_DOCU) ? 1 : 0);

    ### build dummy form ###
    $newtask= new Task(array(
        'id'        =>0,
        'name'      =>$name,
        'project'   =>$prj_id,
        'state'     =>1,
        'estimated' =>$estimated,
        'category'  =>$category,
        'parent_task'=>$parent_task_id,
        'for_milestone'=>$for_milestone_id,
        'show_folder_as_documentation' =>intval($folder_as_docu)
    ));

    ### set a valid create-level ###
    $newtask->pub_level= $project->getCurrentLevelCreate();

    ### insert without editing ###
    if((get('noedit'))) {

        $newtask->insert();
        if(!$PH->showFromPage()) {
            $PH->show('projView',array('prj'=>$prj));
        }
    }

    ### pass newobject to edit-page ###
    else {
        $PH->show('taskEdit',array('tsk'=>$newtask->id),$newtask);
    }
}


/**
* tasksDelete
*
* @ingroup pages
*
* \NOTE sub-tasks of tasks are not deleted but ungrouped
*/
function TasksDelete()
{
    global $PH;
    $tsk=get('tsk');
    $tasks_selected=get('tasks_*');
    $ids=getPassedIds('tsk','tasks_*');

    $tasks= array();

    if(count($ids)==1) {
        $tsk=$ids[0];
        if(!$task= Task::getEditableById($tsk)) {
            $PH->abortWarning(__('insufficient rights'),ERROR_RIGHTS);
            $PH->show('home');
            return;
        }
        $tasks[]= $task;
    }
    else if($ids) {
       #--- get tasks ----

        $num_tasks=count($tasks);
        foreach($ids as $id) {
            if(!$task= Task::getEditableById($id)) {
                $PH->abortWarning("invalid task-id");
            }
            $tasks[]= $task;
        }
    }

    if($tasks) {

        $num_subtasks = 0;
        $num_tasks= 0;

        foreach($tasks as $task) {

            $num_subtasks+= $task->ungroupSubtasks();

            if(!$task->delete()) {
                new FeedbackWarning(sprintf(__("Failed to delete task %s"), $task->name));
            }
            else {
                $num_tasks++;
            }
        }
        new FeedbackMessage(sprintf(__("Moved %s tasks to trash"),$num_tasks));

        if($num_subtasks) {
            new FeedbackMessage(sprintf(__(" ungrouped %s subtasks to above parents."),$num_subtasks));
        }

        ### return to from-page? ###
        if(!$PH->showFromPage()) {
            $PH->show('home');
        }
    }
    else {
        new FeedbackHint(__("No task(s) selected for deletion..."));
        if(!$PH->showFromPage()) {
            $PH->show('home');
        }
    }
}

/**
* Restore deleted task
*
* @ingroup pages
*/
function TasksUndelete()
{
    global $PH;
    $tsk=get('tsk');
    $tasks_selected=get('tasks_*');
    $ids=getPassedIds('tsk','tasks_*');


    if(count($ids)==1) {
        $tsk=$ids[0];
        $task= Task::getEditableById($tsk);
        if(!$task) {
            new FeedbackWarning(__("Could not find task"));
            $PH->show('home');
            return;
        }

        ### check user-rights ###
        if(!$project= Project::getVisibleById($task->project)) {
            $PH->abortWarning("task without project?", ERROR_BUG);
        }

        ### delete task ###
        if($task->state!= -1) {
            new FeedbackHint(sprintf(__("Task <b>%s</b> does not need to be restored"),$task->name));
        }
        else {
            $task->state=1;
            if($task->update()) {
                new FeedbackMessage(sprintf(__("Task <b>%s</b> restored"),$task->name));
                $task->nowChangedByUser();
            }
            else {
                new FeedbackMessage(sprintf(__("Failed to restore Task <b>%s</b>"),$task->name));
            }
        }

        ### go to project view ###
        ### return to from-page? ###
        if(!$PH->showFromPage()) {
            $PH->show('projView',array('prj'=>$project->id));
        }
    }
    else if($ids) {
       #--- get tasks ----
        $tasks=array();
        $num_tasks=count($tasks);
        $num_subtasks=0;

        foreach($ids as $id) {

            if(!$task = Task::getEditableById($id)) {
                new FeedbackWarning("Could not find task");
                $PH->show('home');
                return;
            }

            ### delete task ###
            if($task->state!= -1) {
                new FeedbackHint(sprintf(__("Task <b>%s</b> do not need to be restored"), $task->name));
            }
            else {
                $task->state=1;
                if($task->update()) {
                    new FeedbackMessage(sprintf(__("Task <b>%s</b> restored"),$task->name));
                }
                else {
                    new FeedbackWarning(sprintf(__("Failed to restore Task <b>%s</b>"),$task->name));
                }
            }
        }

        ### return to from-page? ###
        if(!$PH->showFromPage()) {
            $PH->show('home');
        }
    }
    else {
        new FeedbackHint(__("No task(s) selected for restoring..."));
        if(!$PH->showFromPage()) {
            $PH->show('home');
        }
    }
}


/**
* Mark tasks as being completed
*
* @ingroup pages
*/
function TasksComplete()
{
    global $PH;

    $ids= getPassedIds('tsk','tasks_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some task(s) to mark as completed"), ERROR_NOTE);
        return;
    }

    $count=0;
    $count_subtasks=0;
    $num_errors=0;

    foreach($ids as $id) {
        if($task= Task::getEditableById($id)) {

            $count++;
            $task->status=5;
            $task->date_closed= gmdate("Y-m-d", time());
            $task->completion=100;
            $task->update();
            $task->nowChangedByUser();

            ### get all subtasks ###
            if($subtasks= $task->getSubtasks()) {
                foreach($subtasks as $st) {
                    if($subtask_editable= Task::getEditableById($st->id)) {
                        $count_subtasks++;
                        $subtask_editable->status=  STATUS_COMPLETED;
                        $subtask_editable->date_closed= gmdate("Y-m-d", time());
                        $subtask_editable->completion=100;
                        $subtask_editable->update();
                        $subtask_editable->nowChangedByUser();
                        $subtask_editable->resolved_version= RESOLVED_IN_NEXT_VERSION;
                    }
                    else {
                        $num_errors++;
                    }
                }
            }
        }
        else {
            $num_errors++;
        }
    }
    $str_subtasks= $count_subtasks
     ? "(including $count_subtasks subtasks)"
     : "";

    new FeedbackMessage(sprintf(__("Marked %s tasks (%s subtasks) as completed."),$count,$str_subtasks)) ;
    if($num_errors) {
        new FeedbackWarning(sprintf(__("%s error(s) occured"), $num_errors));
    }

    ### return to from-page ###
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}

/**
* Create a task as being approved
*
* @ingroup pages
*/
function TasksApproved()
{
    global $PH;

    $ids= getPassedIds('tsk','tasks_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some task(s) to mark as approved"), ERROR_NOTE);
        return;
    }

    $count=0;
    $num_errors=0;
    foreach($ids as $id) {
        if($task= Task::getEditableById($id)) {

            $count++;
            $task->status = STATUS_APPROVED;
            $task->date_closed = gmdate("Y-m-d", time());
            $task->completion = 100;
            $task->update();
            $task->nowChangedByUser();
        }
        else {
            $num_errors++;
        }

    }
    new FeedbackMessage(sprintf(__("Marked %s tasks as approved and hidden from project-view."),$count));
    if($num_errors) {
        new FeedbackWarning(sprintf(__("%s error(s) occured"), $num_errors));
    }

    ### return to from-page ###
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}


/**
* Create a task as closed
*
* @ingroup pages
*/
function TasksClosed()
{
    global $PH;

    $ids= getPassedIds('tsk','tasks_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some task(s) to mark as closed"), ERROR_NOTE);
        return;
    }

    $count=0;
    $num_errors=0;
    foreach($ids as $id) {
        if($task= Task::getEditableById($id)) {

            $count++;
            $task->status = STATUS_CLOSED;
            $task->date_closed = gmdate("Y-m-d", time());
            $task->completion = 100;
            $task->update();
            $task->nowChangedByUser();
        }
        else {
            $num_errors++;
        }

    }
    new FeedbackMessage(sprintf(__("Marked %s tasks as closed."),$count));
    if($num_errors) {
        new FeedbackWarning(sprintf(__("Not enough rights to close %s tasks."), $num_errors));
    }

    ### return to from-page ###
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}

/**
* Reopen tasks
*
* @ingroup pages
*/
function TasksReopen()
{
    global $PH;

    $ids= getPassedIds('tsk','tasks_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some task(s) to reopen"), ERROR_NOTE);
        return;
    }

    $count  =0;
    $num_errors =0;
    foreach($ids as $id) {
        if($task= Task::getEditableById($id)) {

            $count++;
            $task->status=STATUS_OPEN;
            $task->update();
            $task->nowChangedByUser();
        }
        else {
            $num_errors++;
        }

    }
    new FeedbackMessage(sprintf(__("Reopened %s tasks."),$count));
    if($num_errors) {
        new FeedbackWarning(sprintf(__("%s error(s) occured"), $num_errors));
    }

    ### return to from-page ###
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}




/**
* Toggle task folders
*
* @ingroup pages
*/
function TaskToggleViewCollapsed()
{
    global $PH;
    global $auth;

    $ids= getPassedIds('tsk','tasks_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some task(s)"), ERROR_NOTE);
        return;
    }

    $count  = 0;
    $num_errors = 0;
    foreach($ids as $id) {
        if($task= Task::getVisibleById($id)) {

            if($task->view_collapsed) {
                $task->view_collapsed= 0;
            }
            else {
                $task->view_collapsed= 1;
            }
            if(!$task->update(array('view_collapsed'),false)) {
                new FeedbackError(__("Could not update task"));
                $num_errors++;
            }
            else {
                $count++;
            }
        }
        else {
            $num_errors++;
        }
    }
    if($num_errors) {
        new FeedbackWarning(sprintf(__("%s error(s) occured"), $num_errors));
    }

    ### return to from-page ###
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}



/**
* add an issue-report to an existing task
*
* @ingroup pages
*/
function TaskAddIssueReport()
{
    global $PH;


    $id= getOnePassedId('tsk','tasks_*',true,__('No task selected to add issue-report?'));

    if($task= Task::getEditableById($id)) {
        if($task->issue_report) {
            $PH->abortWarning(__("Task already has an issue-report"));
            exit();
        }

        ### check user-rights ###
        if(!$project= Project::getVisibleById($task->project)) {
            $PH->abortWarning(__("task without project?"), ERROR_BUG);
        }

        $task->issue_report= -1;
        new FeedbackHint(__("Adding issue-report to task"));
        $PH->show('taskEdit',array('tsk'=>$task->id),$task);
        exit();

    }
    else {
        new FeedbackWarning(__("Could not find task"));
    }

    ### return to from-page ###
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}


/**
* Edit description of a task
*
* @ingroup pages
*/
function taskEditDescription($task=NULL)
{
    global $PH;

    ### object or from database? ###
    if(!$task) {

        $id= getOnePassedId('tsk','tasks_*');

        if(!$task = Task::getEditableById($id)) {
            $PH->abortWarning(__("Select a task to edit description"), ERROR_NOTE);
            return;
        }
    }

    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>false, 'autofocus_field'=>'task_name'));

        initPageForTask($page, $task);

        $page->title_minor= __("Edit description");

        echo(new PageHeader);
    }
    echo (new PageContentOpen);


    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');

        $block=new PageBlock(array(
            'id'    =>'edit',
        ));
        $block->render_blockStart();

        $form=new PageForm();
        $form->button_cancel=true;


        $form->add(new Form_HiddenField('task_id','',$task->id));
        $form->add($task->fields['name']->getFormElement($task));
        $e= $task->fields['description']->getFormElement($task);
        $e->rows=22;
        $form->add($e);

        echo ($form);

        $block->render_blockEnd();

        $PH->go_submit= 'taskEditDescriptionSubmit';
    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd);


}

/**
* Submit changes to the description of a task
*
* @ingroup pages
*/
function taskEditDescriptionSubmit()
{
    global $PH;

    ### cancel? ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('taskView',array('tsk'=>$task->id));
        }
        exit();
    }

    if(!$task = Task::getEditableById(intval(get('task_id')))) {
        $PH->abortWarning("unknown task-id");
    }

    $name= get('task_name');
    if(!is_null($name)) {
        $task->name= $name;
    }

    $description= get('task_description');
    if(!is_null($description)) {
        $task->description= $description;
    }


    ### validate ###
    if(!$task->name) {
        new FeedbackWarning(__("Task requires name"));
    }

    ### repeat form if invalid data ###
    if(!$task->name) {
        $PH->show('taskEditDescription',NULL,$task);

        exit();
    }


    ### write to db ###
    $task->update(array('name','description'));

    ### return to from-page? ###
    if(!$PH->showFromPage()) {
        $PH->show('taskView',array('tsk'=>$task->id));
    }
}




/**
* View efforts for a task
*
* @ingroup pages
*/
function TaskViewEfforts()
{
    global $PH;

    require_once(confGet('DIR_STREBER') . 'lists/list_efforts.inc.php');

    ### get current project ###
    $id=getOnePassedId('task','tasks_*');
    if(!$task=Task::getVisibleById($id)) {
        $PH->abortWarning("invalid task-id");
        return;
    }

    ### create from handle ###
    $PH->defineFromHandle(array('task'=>$task->id));

    if(!$project= Project::getVisibleById($task->project)) {
        $PH->abortWarning("not enough rights");
    }

    ### set up page ####
    {
        $page= new Page();
        initPageForTask($page, $task, $project);

        $page->title_minor= __("Task Efforts");

        ### page functions ###
        $page->add_function(new PageFunction(array(
            'target'=>'effortNew',
            'params'=>array('task'=>$task->id),
            'icon'=>'new',
            'name'=>__('new Effort'),
        )));


        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    #--- list efforts --------------------------------------------------------------------------
    {
        $order_by=get('sort_'.$PH->cur_page->id."_efforts");

        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
        $efforts= Effort::getAll(array(
            'task'      => $task->id,
            'order_by'  => $order_by,

        ));
        $list= new ListBlock_efforts();
        $list->render_list($efforts);
    }

    ### 'add new task'-field ###
    $PH->go_submit='effortNew';
    echo '<input type="hidden" name="task" value="'.$id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}


/**
* Edit multiple tasks
*
* @ingroup pages
*/
function TaskEditMultiple()
{
    global $PH;

    $task_ids= getPassedIds('tsk','tasks_*');

    if(!$task_ids) {
        $PH->abortWarning(__("Select some tasks to move"));
        exit();
    }

    $count  = 0;
    $count_subtasks = 0;
    $errors = 0;

    $last_milestone_id=NULL;
    $different_milestones=false;

    $last_status=NULL;
    $different_status=false;

    $project= NULL;

    $tasks= array();

    $task_assignments = array();
    $task_assignments_count = array();
    $different_assignments = false;

    $edit_fields=array(
        'category',
        'prio',
        'status',
        'for_milestone',
        'resolved_version',
        'resolve_reason',
        'label',
        'pub_level'
    );
    $different_fields=array();  # hash containing fieldnames which are different in tasks

    $count=0;

    foreach($task_ids as $id) {
        if($task= Task::getEditableById($id)) {

            $tasks[]= $task;

            ## get assigned people ##
            if($task_people = $task->getAssignedPeople(false))
            {
                $counter = 0;
                foreach($task_people as $tp){
                    $task_assignments[$task->id][$counter++] = $tp->id;
                }
                $task_assignments_count[$task->id] = count($task_people);
            }
            ## if nobody is assigned
            else{
                $task_assignments[$task->id][0] = '__none__';
                $task_assignments_count[$task->id] = 0;
            }

            ### check project for first task
            if(count($tasks) == 1) {

                ### make sure all are of same project ###
                if(!$project = Project::getVisibleById($task->project)) {
                    $PH->abortWarning('could not get project');
                }
            }
            else {
                if($task->project != $tasks[0]->project) {
                    $PH->abortWarning(__("For editing all tasks must be of same project."));
                }

                foreach($edit_fields as $field_name) {
                    if($task->$field_name !== $tasks[0]->$field_name) {
                        $different_fields[$field_name]= true;
                    }
                }

                ## check if tasks have different people assigned ##
                if($task_assignments_count[$tasks[0]->id] != $task_assignments_count[$task->id]){
                    $different_assignments = true;
                }
                else{
                    for($i = 0; $i < $task_assignments_count[$tasks[0]->id]; $i++){
                        if($task_assignments[$tasks[0]->id][$i] != $task_assignments[$task->id][$i]){
                            $different_assignments = true;
                        }
                    }
                }
            }
        }
    }


    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>true));
        $page->cur_tab='projects';


        $page->options[]= new naviOption(array(
            'target_id'     =>'taskEdit',
        ));

        $page->type= __("Edit multiple tasks","Page title");

        $page->title= sprintf(__("Edit %s tasks","Page title"), count($tasks));

        echo(new PageHeader);
    }
    echo (new PageContentOpen);


    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');

        global $g_status_names;

        echo "<ol>";
        foreach($tasks as $t) {
            echo "<li>" . $t->getLink(false). "</li>";
        }
        echo "</ol>";

        $form=new PageForm();
        $form->button_cancel=true;


        ### category ###
        {
            $a= array();
            global $g_tcategory_names;
            foreach($g_tcategory_names as $s=>$n) {
                $a[$s]=$n;
            }
            if(isset($different_fields['category'])) {
                $a['__dont_change__']= ('-- ' . __('keep different'). ' --');
                $form->add(new Form_Dropdown('task_category',__("Category"),array_flip($a),  '__dont_change__'));
            }
            else {
                $form->add(new Form_Dropdown('task_category',__("Category"),array_flip($a),  $tasks[0]->category));
            }
        }


        ### status ###
        {
            $st=array();
            foreach($g_status_names as $s => $n) {
                if($s >= STATUS_NEW) {
                    $st[$s]=$n;
                }
            }
            if(isset($different_fields['status'])) {
                $st['__dont_change__']= ('-- ' . __('keep different'). ' --');
                #$st[('-- ' . __('keep different'). ' --')]=  '__dont_change__';
                $form->add(new Form_Dropdown('task_status',__("Status"),array_flip($st),  '__dont_change__'));
            }
            else {
                $form->add(new Form_Dropdown('task_status',__("Status"),array_flip($st),  $tasks[0]->status));
            }
        }


        ### public-level ###
        if(($pub_levels=$task->getValidUserSetPublicLevels())
            && count($pub_levels)>1) {
            if(isset($different_fields['pub_level'])) {
                $pub_levels[('-- ' . __('keep different'). ' --')]= '__dont_change__';
                $form->add(new Form_Dropdown('task_pub_level',  __("Publish to"),$pub_levels, '__dont_change__'));
            }
            else {
                $form->add(new Form_Dropdown('task_pub_level',  __("Publish to"),$pub_levels,$tasks[0]->pub_level));
            }

        }

        ### labels ###
        $labels=array(__('undefined') => 0);
        $counter= 1;
        foreach(explode(",",$project->labels) as $l) {
            $labels[$l]=$counter++;
        }
        if(isset($different_fields['label'])) {
            $labels[('-- ' . __('keep different'). ' --')]= '__dont_change__';
            $form->add(new Form_Dropdown('task_label',  __("Label"),$labels, '__dont_change__'));
        }
        else {
            $form->add(new Form_Dropdown('task_label',  __("Label"),$labels,$tasks[0]->label));
        }



        ### prio ###
        {
            global $g_prio_names;
            $pr= array();
            foreach($g_prio_names as $key => $value) {
                $pr[$key]= $value;
            }
            if(isset($different_fields['prio'])) {
                $pr['__dont_change__']= ('-- ' . __('keep different'). ' --');
                $form->add(new Form_Dropdown('task_prio',__("Prio"),array_flip($pr),  '__dont_change__'));
            }
            else {
                $form->add(new Form_Dropdown('task_prio',__("Prio"),array_flip($pr),  $tasks[0]->prio));
            }
        }


        ### milestone ###
        {
            $grouped_milestone_options= $project->buildPlannedForMilestoneList();
            if(isset($different_fields['for_milestone'])) {                
                $grouped_milestone_options[NO_OPTION_GROUP]['__dont_change__']= ('-- ' . __('keep different'). ' --');
                $form->add(new Form_DropdownGrouped(
                                'task_for_milestone',
                                 __('For Milestone'), 
                                 $grouped_milestone_options,
                                 '__dont_change__'
                               ));
            }
            else {
                $form->add(new Form_DropdownGrouped(
                                'task_for_milestone', 
                                __('For Milestone'), 
                                $grouped_milestone_options,
                                $tasks[0]->for_milestone
                                ));
            }
        }

        ### resolved_version ###
        {
            $grouped_resolve_options= $project->buildResolvedInList();
            if(isset($different_fields['resolved_version'])) {
                $grouped_resolve_options[NO_OPTION_GROUP]['__dont_change__']= ('-- ' . __('keep different'). ' --');
                $form->add(new Form_DropdownGrouped(
                                'task_resolved_version', 
                                __('resolved in Version'), 
                                $grouped_resolve_options,
                                '__dont_change__'
                                ));
            }
            else {
                $form->add(new Form_DropdownGrouped(
                            'task_resolved_version', 
                            __('resolved in Version'), 
                            $project->buildResolvedInList(), 
                            $tasks[0]->resolved_version
                            ));
            }
        }



        ### resolve reason ###
        {
            global $g_resolve_reason_names;
            $rr= array();
            foreach($g_resolve_reason_names as $key => $value) {
                $rr[$key]= $value;
            }
            if(isset($different_fields['resolve_reason'])) {
                $rr['__dont_change__']= ('-- ' . __('keep different') . ' --');
                $form->add(new Form_Dropdown('task_resolve_reason',__("Resolve Reason"),array_flip($rr),  '__dont_change__'));
            }
            else {
                $form->add(new Form_Dropdown('task_resolve_reason',__("Resolve Reason"),array_flip($rr),  $tasks[0]->resolve_reason));
            }
        }

        ## assignement ##
        {
            $ass = array();
            $ass_also = array();

            ## get project team ##
            if($proj_people = $project->getPeople()){
                foreach($proj_people as $pp){
                    $ass[$pp->id] = $pp->name;
                    $ass_also[$pp->id] = $pp->name;
                }
            }

            ## different people assigend? ##
            if($different_assignments){
                $ass['__dont_change__'] = ('-- ' . __('keep different') . ' --');
                $form->add(new Form_Dropdown('task_assignement_diff', __('Assigned to'), array_flip($ass), '__dont_change__'));

                $ass_also['__select_person__'] = ('-- ' . __('select person') . ' --');
                $form->add(new Form_Dropdown('task_assignement_also_diff', __('Also assigned to'), array_flip($ass_also), '__select_person__'));
            }
            else{
                $ass['__none__'] = ('-- ' . __('none') . ' --');
                foreach($task_assignments[$tasks[0]->id] as $key=>$value)
                {
                    $form->add(new Form_Dropdown('task_assign_to_'.$task_assignments[$tasks[0]->id][$key], __('Assigned to'), array_flip($ass), $task_assignments[$tasks[0]->id][$key]));
                }

                $ass_also['__select_person__'] = ('-- ' . __('select person') . ' --');
                $form->add(new Form_Dropdown('task_assign_to_0', __('Also assigned to'), array_flip($ass_also), '__select_person__'));
            }
        }

        foreach($tasks as $t) {
            $form->add(new Form_HiddenField("tasks_{$t->id}_chk",'',1));
        }
        $form->add(new Form_HiddenField('different_ass','',$different_assignments));
        #$form->add(new Form_HiddenField('task_project','',$project->id));

        echo($form);

        $PH->go_submit= 'taskEditMultipleSubmit';
        if($return=get('return')) {
            echo "<input type=hidden name='return' value='$return'>";
        }
    }

    echo (new PageContentClose);
    echo (new PageHtmlEnd);

    exit();
}



/**
* Submit changes to multiple tasks
*
* @ingroup pages
*/
function taskEditMultipleSubmit()
{
    global $PH;

    $ids= getPassedIds('tsk','tasks_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some task(s) to mark as approved"), ERROR_NOTE);
        return;
    }

    $count=0;
    $errors=0;
    $number = get('number');

    ### cancel? ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('home');
        }
        exit();
    }

    foreach($ids as $id) {
        if($task= Task::getEditableById($id)) {
            $count++;
            $change= false;;

            $status_old= $task->status;


            ### status ###
            if($count == 1){
                if(!$project = Project::getVisibleById($task->project)) {
                    $PH->abortWarning('could not get project');
                }

                $team= array();
                foreach($project->getPeople() as $p) {
                    $team[$p->id]= $p;
                }
            }

            ### assignment ###
            {
                $task_assigned_people = array();
                $task_assignments = array();
                $task_people_overwrite = array();
                $task_people_new = array();
                $task_people_delete = array();

                ## previous assigend people ##
                if($task_people = $task->getAssignedPeople(false))
                {
                    foreach($task_people as $tp){
                        $task_assigned_people[$tp->id] = $tp;
                    }
                }

                ## previous assignements ##
                if($task_assign = $task->getAssignments())
                {
                    foreach($task_assign as $ta){
                        $task_assignments[$ta->person] = $ta;
                    }
                }

                ## different assigned people ##
                ## overwrite ?? ##
                $ass1 = get('task_assignement_diff');
                if($ass1 && $ass1 != '__dont_change__'){
                    $task_people_overwrite[] = $ass1;
                    foreach($task_assignments as $key=>$value){
                        $task_people_delete[] = $value;
                    }
                    $change = true;
                }

                ## new ?? ##
                $ass2 = get('task_assignement_also_diff');
                if($ass2 && $ass2 != '__select_person__'){
                    $task_people_new[] = $ass2;
                    $change = true;
                }

                $different = get('different_ass');
                if(isset($different) && !$different){
                    if(isset($task_assignments) && count($task_assignments) != 0){
                        foreach($task_assignments as $tid=>$t_old){
                            $id_new = get('task_assign_to_'.$tid);
                            ## no changes ##
                            if($tid == $id_new){
                                continue;
                            }

                            if($id_new == '__none__'){
                                if(!$t_old){
                                    continue;
                                }
                                $task_people_delete[] = $t_old;
                                continue;
                            }

                            $task_people_delete[] = $t_old;
                            $task_people_overwrite[] = $id_new;
                        }
                    }
                    else{
                        $id_new = get('task_assign_to___none__');
                        if($id_new && $id_new != '__none__'){
                            $task_people_new[] = $id_new;
                        }
                    }

                    $id_new = get('task_assign_to_0');
                    if($id_new != '__select_person__'){
                        if(!isset($task_assignments[$id_new])){
                            $task_people_new[] = $id_new;
                        }
                    }

                    $change = true;
                }
            }


            ### category ###
            $v= get('task_category');
            if(!is_null($v) && $v != '__dont_change__' && $v != $task->category) {
                $task->category= $v;
                $change= true;
            }


            ### status ###
            $status= get('task_status');
            if($status && $status != '__dont_change__' && $status != $task->status) {
                $task->status= $status;
                $change= true;
            }

            ### prio ###
            $prio= get('task_prio');
            if($prio && $prio != '__dont_change__' && $prio != $task->prio) {
                $task->prio= $prio;
                $change= true;
            }

            ### pub level ###
            $pub_level= get('task_pub_level');
            if($pub_level && $pub_level != '__dont_change__' && $pub_level != $task->pub_level) {


               if($pub_level > $task->getValidUserSetPublicLevel() ) {
                   $PH->abortWarning('invalid data',ERROR_RIGHTS);
               }
               $task->pub_level= $pub_level;
               $change= true;
            }

            ### label ###
            $label= get('task_label');
            if($label && $label != '__dont_change__' && $label != $task->label) {
                $task->label= $label;
                $change= true;
            }

            ### for milestone ###
            $fm= get('task_for_milestone');
            if(!is_null($fm) && $fm != '__dont_change__' && $task->for_milestone != $fm) {
                if($fm) {
                    if(($m= Task::getVisibleById($fm)) && $m->isMilestoneOrVersion()) {
                        $task->for_milestone= $fm;
                        $change= true;
                    }
                    else {
                        continue;
                    }
                }
                else {
                    $task->for_milestone= 0;
                    $change= true;
                }
            }

            ### resolve version ###
            $rv= get('task_resolved_version');

            if((!is_null($rv)) && ($rv != '__dont_change__') && ($task->resolved_version != $rv)) {
                if($rv && $rv != -1) {
                    if($v= Task::getVisibleById($rv)) {
                        if($v->isMilestoneOrVersion()) {
                            $task->resolved_version= $rv;
                            $change= true;
                        }
                    }
                    else {
                        continue;
                    }
                }
                else {
                    if($rv == -1) {
                        $task->resolved_version= $rv;
                        $change= true;
                    }
                    else {
                        $task->resolved_version= 0;
                        $change= true;
                    }
                }
            }

            ### resolve reason ###
            $rs= get('task_resolve_reason');
            if($rs && $rs != '__dont_change__' && $rs != $rs->resolve_reason) {
                $task->resolve_reason= $rs;
                $change= true;
            }


            if($change) {

                ### Check if now longer new ###
                if($status_old == $task->status && $task->status == STATUS_NEW) {
                    global $auth;
                    if($task->created < $auth->cur_user->last_login) {
                        $task->status = STATUS_OPEN;
                    }
                }
                ## overwrite assigend people ##
                if(isset($task_people_overwrite)){
                    if(isset($task_people_delete)){
                        foreach($task_people_delete as $tpd){
                            $tpd->delete();
                            
                        }
                    }
                    foreach($task_people_overwrite as $tpo)
                    {
                        $task_pers_over = new TaskPerson(array(
                                        'person'=> $team[$tpo]->id,
                                        'task'  => $task->id,
                                        'comment'=>'',
                                        'project'=>$project->id,
                                        ));
                        $task_pers_over->insert();
                    }
                }

                ## add new person ##
                if(isset($task_people_new)){
                    foreach($task_people_new as $tpn){
                        if(!isset($task_assigned_people[$tpn]))
                        {
                            $task_pers_new = new TaskPerson(array(
                                         'person'=> $team[$tpn]->id,
                                         'task'  => $task->id,
                                         'comment'=>'',
                                         'project'=>$project->id,
                                          ));
                           $task_pers_new->insert();
                        }
                    }

                }

                ##update##
                $task->update();
                $task->nowChangedByUser();
            }
        }
        else {
            $errors++;
        }
    }

    ### compose message ###
    if($errors) {
        new FeedbackWarning(sprintf(__('%s tasks could not be written'), $errors));
    }
    else if($count) {
        new FeedbackMessage(sprintf(__('Updated %s tasks tasks'), $count));
    }

    ### return to from-page? ###
    if(!$PH->showFromPage()) {
        $PH->show('taskView',array('tsk'=>$task->id));
    }

}






/**
* Collapse all comments of a tasks
*
* @ingroup pages
*/
function taskCollapseAllComments()
{
    global $PH;


    /**
    * because there are no checkboxes left anymore, we have to get the comment-ids
    * directly from the task with the getComments-function
    **/
    ### get task ###
    $tsk=get('tsk');

    ### check sufficient user-rights ###
    if($task=Task::getEditableById($tsk)) {
        $ids= $task->getComments();

        foreach($ids as $obj) {
            if(!$comment=Comment::getEditableById($obj->id)) {
                $PH->abortWarning('undefined comment','warning');
            }
            if(! $comment->view_collapsed) {
                $comment->view_collapsed=1;
                $comment->update();
            }
        }
    }
    else {
        /**
        * a better way should be not to display this function
        * if user has not enough rights
        **/
        ### abort, if not enough rights ###
        $PH->abortWarning(__('insufficient rights'),ERROR_RIGHTS);
    }

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}

/**
* Expand all comments of a task
*
* @ingroup pages
*/
function taskExpandAllComments()
{
    global $PH;

    /**
    * because there are no checkboxes left anymore, we have to get the comment-ids
    * directly from the task with the getComments-function
    **/
    ### get task ###
    $tsk= get('tsk');

    ### check sufficient user-rights ###
    if($task=Task::getEditableById($tsk)) {
        $ids= $task->getComments();

        foreach($ids as $obj) {
            if(!$comment=Comment::getEditableById($obj->id)) {
                $PH->abortWarning('undefined comment','warning');
            }

            ### get all comments including all sub-comments
            $list= $comment->getAll();
            $list[]= $comment;

            foreach($list as $c) {
                if($c->view_collapsed) {
                    $c->view_collapsed=0;
                    $c->update();
                }
            }
        }
    }
    else {
        /**
        * a better way should be not to display this function
        * if user has not enough rights
        **/
        ### abort, if not enough rights ###
        $PH->abortWarning(__('insufficient rights'),ERROR_RIGHTS);
    }

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}


/** @} */

?>
