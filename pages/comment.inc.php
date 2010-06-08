<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file  pages related to comments  */

require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_comment.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_misc.inc.php');


/**
* View a comment
* 
* @ingroup pages
*/
function commentView(){
    global $PH;
    global $auth;
    
    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

    ### get task ####
    if(!$comment=Comment::getVisibleById(get('comment'))) {
        $PH->abortWarning("invalid comment-id",ERROR_FATAL);
    }

    if(!$project= Project::getVisibleById($comment->project)) {
        $PH->abortWarning("invalid project-id",ERROR_FATAL);
    }

    $task = $comment->task
    ? Task::getVisibleById($comment->task)
    : NULL;

    ### create from handle ###
    $from_handle= $PH->defineFromHandle(array('comment'=>$comment->id));

    ## is viewed by user ##
    $comment->nowViewedByUser();

    ### set up page and write header ####
    {
        $page= new Page();
        initPageForComment($page, $comment, $project);

        if($comment->state== -1) {
            $page->title_minor=sprintf(__('(deleted %s)','page title add on with date of deletion'),renderTimestamp($comment->deleted));
        }

        ### page functions ###
        $page->add_function(new PageFunction(array(
            'target'    =>'commentEdit',
            'params'    =>array('comment'=>$comment->id),
            'icon'      =>'edit',
            'tooltip'   =>__('Edit this comment'),
            'name'      =>__('Edit')
        )));
        
        $item = ItemPerson::getAll(array('person'=>$auth->cur_user->id,'item'=>$comment->id));
        if((!$item) || ($item[0]->is_bookmark == 0)){
            $page->add_function(new PageFunction(array(
                'target'    =>'itemsAsBookmark',
                'params'    =>array('comment'=>$comment->id),
                'tooltip'   =>__('Mark this comment as bookmark'),
                'name'      =>__('Bookmark'),
            )));
        }
        else{
            $page->add_function(new PageFunction(array(
                'target'    =>'itemsRemoveBookmark',
                'params'    =>array('comment'=>$comment->id),
                'tooltip'   =>__('Remove this bookmark'),
                'name'      =>__('Remove Bookmark'),
            )));
        } 
        
        if($comment->state == ITEMSTATE_DELETED) {

            $page->add_function(new PageFunction(array(
                'target'    =>'commentsUndelete',
                'params'    =>array('comment'=>$comment->id),
                'icon'      =>'delete',
                'tooltip'   =>__('Delete this comment'),
                'name'      =>__('Restore')
            )));
        }
        else {
            $page->add_function(new PageFunction(array(
                'target'    =>'commentsDelete',
                'params'    =>array('comment'=>$comment->id),
                'icon'      =>'delete',
                'tooltip'   =>__('Delete this comment'),
                'name'      =>__('Delete')
            )));

        }


        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);


    #--- summary ----------------------------------------------------------------
    {
        $block=new PageBlock(array(
            'title'     =>__('Description'),
            'id'        =>'description',
            'noshade'   =>true,
        ));
        $block->render_blockStart();
        $str= wikifieldAsHtml($comment, 'description');

        echo "<div class=text>";
        echo "$str";
        echo "</div>";

        $block->render_blockEnd();
    }

    echo '<input type="hidden" name="prj" value="'.$comment->project.'">';
    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}





/**
* Create new comment 
* 
* New comments have to be attached to an option. So the major part of this code
* deals with finding out, to what the comment belongs to.
* 
* @ingroup pages
*
*
*  - requires comment, task or comments_* - param
*/
function commentNew() {
    global $PH;
    global $COMMENTTYPE_VALUES;

    $project=NULL;

    $name=get('new_name')
        ? get('new_name')
        :__('New Comment','Default name of new comment');


    ### build new object ###
    $newComment= new Comment(array(
        'id'=>0,
        'name'=>$name,
    ));

    ### try single project-id ###
    if($id=getOnePassedId('prj','projects_*',false)) { #no not abort if not found
        if($project= Project::getVisibleById($id)) {
            $newComment->project= $project->id;
        }
    }
    
    ### try single task-id ###
    $task=NULL;
    $comment = NULL;
    if($id=getOnePassedId('tsk','tasks_*',false)) { #no not abort if not found
        if($task= Task::getVisibleById($id)) {
            $newComment->task= $task->id;

            ### try to figure project-id from task ###
            if(!$newComment->project) {
                $newComment->project= $task->getProject()->id;
            }
        }
    }


    ### subtask? ###
    if(!$task) {
        if($task_id= get('parent_task')) {
            if($task= Task::getVisibleById($task_id)) {
                $newComment->task= $task->id;

                ### try to figure project-id from task ###
                if(!$newComment->project) {
                    $newComment->project= $task->getProject()->id;
                }
            }
        }
    }

    ### try single company-id ###
    if($id=getOnePassedId('company','companies_*',false)) { #no not abort if not found
        if($company= Company::getVisibleById($id)) {
            $newComment->company= $company->id;
        }
    }

    ### try single person-id ###
    if($id=getOnePassedId('person','persons_*',false)) { #no not abort if not found
        if($person= Person::getVisibleById($id)) {
            $newComment->person= $person->id;
        }
    }

    ### try comment on comment ###
    if($id=getOnePassedId('comment','comments_*',false)) { #no not abort if not found
        if($comment= Comment::getById($id)) {
            $newComment->comment= $comment->id;
            switch (confGet('REPLY_ON_COMMENT_PREFIX')) {
                case 0: 
                    $newComment->name='';
                    break;
                case 1: 
                    $newComment->name=__('Re: ').$comment->name;
                    break;
                case 2: 
                    $newComment->name=__('Reply to ','prefix for name of new comment on another comment').$comment->name;
                    break;
                default: 
                    $newComment->name=__('Re: ').$comment->name;
                    break;
            }
            $newComment->occasion=$COMMENTTYPE_VALUES['Reply'];

        }
    }

    ### get current project ###
    if(!$project) {
        if($task) {
            if(!$project= Project::getVisibleById($task->project)) {
                $PH->abortWarning('invalid project id',ERROR_FATAL);
            }
        }
        else {
            $PH->abortWarning('can´t access project',ERROR_BUG);
        }
    }
    if(!$task && !$comment) {
        $PH->abortWarning('need at least comment or task',ERROR_WARNING);
    }


    ### set a valid create-level ###
    $newComment->pub_level= $project->getCurrentLevelCreate();
    if($newComment->pub_level < 1) {

        ### abort, if not enough rights ###
        $PH->abortWarning(__('insufficient rights'),ERROR_RIGHTS);

    }

    ### render form ###
    $PH->show('commentEdit',array('comment'=>$newComment->id), $newComment);
}


/**
* Edit a comment 
*
* @ingroup pages
*/
function commentEdit($comment=NULL)
{
    global $PH;
    global $auth;

    ### edit existing object or get from database ? ###
    if(!$comment) {
        $id= getOnePassedId('comment','comments*');   # WARNS if multiple; ABORTS if no id found
        $comment= Comment::getVisibleById($id);
        if(!$comment) {
            $PH->abortWarning("could not get Comment", ERROR_FATAL);
            return;
        }
    }


    ### check user-rights ###
    if(!$project= Project::getVisibleById($comment->project)) {
        $PH->abortWarning("comment without project?", ERROR_BUG);
    }
    $project->validateEditItem($comment);   # aborts if not enough rights to edit
    $task= Task::getVisibleById($comment->task);

    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>true, 'autofocus_field'=>'comment_name'));
        initPageForComment($page, $comment, $project);


        if($comment->id) {
            $page->title=__("Edit Comment","Page title");
        }
        else {
            $page->title=__("New Comment","Page title");
        }

        echo(new PageHeader);
    }
    echo (new PageContentOpen);


    ### write form #####
    {
        global $COMMENTTYPE_VALUES;
        global $PUB_LEVEL_VALUES;
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');

        $block=new PageBlock(array(
            'id'    =>'edit',
        ));
        $block->render_blockStart();


        $form=new PageForm();
        $form->button_cancel=true;


        $form->add($comment->fields['name']->getFormElement(&$comment));
        $e= $comment->fields['description']->getFormElement(&$comment);
        $e->rows=22;
        $form->add($e);

        $form->add(new Form_HiddenField('comment_project', '', $comment->project));

        $form->add(new Form_HiddenField('comment_task', '', $comment->task));
        $form->add(new Form_HiddenField('comment_comment', '', $comment->comment));

        ### public-level ###
        if(($pub_levels=$comment->getValidUserSetPublicLevels())
            && count($pub_levels)>1) {
            $form->add(new Form_Dropdown('comment_pub_level',  __('Publish to','form label'),$pub_levels,$comment->pub_level));
        }

        if($auth->cur_user->id == confGet('ANONYMOUS_USER')) {
            $form->addCaptcha();
        }

        echo ($form);

        $block->render_blockEnd();

        $PH->go_submit= 'commentEditSubmit';
        echo "<input type=hidden name='comment' value='$comment->id'>";
    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}


/**
* Submit changes to a comment @ingroup pages
*/
function commentEditSubmit(){
    global $PH;
    global $auth;

    ### cancel ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('home');
        }
        exit();
    }

    ### Validate integrety ###
    if(!validateFormCrc()) {
        $PH->abortWarning(__('Invalid checksum for hidden form elements'));
    }

    ### get comment ####
    $id= getOnePassedId('comment');

    ### new object? ###
    if($id == 0) {
        $comment= new Comment(array());
    }
    ### ...or from db ###
    else {
        $comment= Comment::getVisibleById($id);
        if(!$comment) {
            $PH->abortWarning("Could not get comment");
            return;
        }
        $comment->validateEditRequestTime();
    }

    validateFormCaptcha(true);

    # retrieve all possible values from post-data
    # NOTE:
    # - this could be an security-issue.
    # - TODO: as some kind of form-edit-behaviour to field-definition
    foreach($comment->fields as $f) {
        $name=$f->name;
        $f->parseForm(&$comment);
    }
    if($tmp= get('comment_project')) {
        $comment->project= $tmp;
    }
    
    $task= NULL;
    if($tmp= get('comment_task')) {
        if($task = Task::getVisibleById($tmp)) {
            $comment->task= $task->id;
            $comment->project = $task->project;
        }
    }
    if($tmp= get('comment_occasion')) {
        $comment->occasion= $tmp;
    }


    ### be sure the comment is connected somewhere ###
    #
    # Comments to comments are deprecated
    if(!$comment->project || !$comment->task) {
        $PH->abortWarning("ERROR:Comment not connected anywhere. This is an internal error and should be reported");
    }

    ### change task update modification date ###
    if($task) {
        ### Check if now longer new ###
        if($task->status == STATUS_NEW) {
            global $auth;
            if($task->created < $auth->cur_user->last_login) {
                $task->status = STATUS_OPEN;
                $task->update(array('modified','status'));
            }
        }
        $task->nowChangedByUser();
    }


    ### detect spam
    validateNotSpam($comment->description ." " . $comment->name);

    ### get pub-level
    $pub_level= intval(get('comment_pub_level'));
    if(!$pub_level) {
        $pub_level = PUB_LEVEL_OPEN;
    }
    
    $pp= $task->getProjectPerson();
    if($pub_level > $pp->level_create) {
        $pub_level= $pp->level_create;
    }
    $comment->pub_level= $pub_level;

    ### write to db ###
    if($comment->id == 0) {
        $comment->insert();
    }
    else  {
        $comment->update();
    }

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }


}


/**
* Delete comments @ingroup pages
*/
function commentsDelete()
{
    global $PH;

    ### get comment ####
    $ids= getPassedIds('comment','comments_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some comments to delete"));
        return;
    }

    $counter=0;
    $errors=0;
    foreach($ids as $id) {
        $c= Comment::getEditableById($id);
        if(!$c) {
            $PH->abortWarning("Not enought rights");
        }

        /**
        * move sub comments
        */
        if($c->delete()) {
            if($sub_comments= $c->getSubComments()) {
                foreach($sub_comments as $sc) {
                    /**
                    * set parent of sub-comment to own parent (might be 0 for root)
                    */
                    $sc->comment= $c->comment;
                    $sc->update();
                }
            }
            $counter++;
        }
        else {
            $errors++;
        }
    }
    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to delete %s comments"),$errors));
    }
    else {
        new FeedbackMessage(sprintf(__("Moved %s comments to trash"), $counter));
    }

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}



/**
* Restore deleted comments @ingroup pages
*/
function commentsUndelete()
{
    global $PH;

    ### get comment ####
    $ids= getPassedIds('comment','comments_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some comments to restore"));
        return;
    }

    $counter=0;
    $errors=0;
    foreach($ids as $id) {
        $c= Comment::getEditableById($id);
        if(!$c) {
            $PH->abortWarning("Not enought rights");
        }

        if($c->state == ITEMSTATE_DELETED) {
            $c->state = ITEMSTATE_NORMAL;
            if($c->update()) {
                $counter++;
            }
            else {
                $errors++;
            }
        }
        else {
            $errors++;
        }
    }
    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to restore %s comments"),$errors));
    }
    else {
        new FeedbackMessage(sprintf(__("Restored %s comments"), $counter));
    }

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}


/**
* Toggle comment collapsing @ingroup pages
*/
function commentToggleViewCollapsed()
{
    global $PH;

    ### get comment ####
    $id= getOnePassedId('comment','comments_*');

    if(!$comment=Comment::getEditableById($id)) {
        $PH->abortWarning("undefined comment");
    }
    if($comment->view_collapsed) {
        $comment->view_collapsed=0;
    }
    else {
        $comment->view_collapsed=1;
    }
    $comment->update();

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}


/**
* Collapse comment view
* 
* @ingroup pages
*/
function commentsCollapseView()
{
    global $PH;

    ### get comment ####
    #$ids= getPassedIds('comment','comments_*');

    /**
    * because there are no checkboxes left anymore, we have to get the comment-ids
    * directly from the task with the getComments-function
    **/
    $tsk=get('tsk');
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

function commentsExpandView()
{
    global $PH;

    /**
    * because there are no checkboxes left anymore, we have to get the comment-ids
    * directly from the task with the getComments-function
    **/
    $tsk= get('tsk');
    if($task=Task::getEditableById($tsk)) {
        $ids= $task->getComments();

        foreach($ids as $obj) {
            if(!$comment=Comment::getEditableById($obj->id)) {
                $PH->abortWarning('undefined comment','warning');
            }
            $list= $comment->getSubComments();
            $list[]= $comment;

            foreach($list as $c) {
                if( $c->view_collapsed) {
                    $c->view_collapsed= 0;
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




/**
* move comments to folder...
*/
function commentsMoveToFolder()
{
    global $PH;

    $comment_ids= getPassedIds('comment','comments_*');

    if(!$comment_ids) {
        $PH->abortWarning(__("Select some comments to move"));
        return;
    }

    /**
    * if folder was given, directly move tasks...
    */
    $target_id=-1;                                          # target is unknown
    $folder_ids= getPassedIds('folder','folders_*');

    if(count($folder_ids) == 1) {
        if($folder_task= Task::getVisibleById($folder_ids[0])) {
            $target_id= $folder_task->id;
        }
    }
    else if(get('from_selection')) {
        $target_id=0;                                       # to ungrout to root?
    }
    if($target_id != -1) {

        if($target_id != 0){
            if(!$target_task= Task::getEditableById($target_id)) {
                $PH->abortWarning(__("insufficient rights"));
            }
        }

        $count=0;
        foreach($comment_ids as $id) {
            if($comment= Comment::getEditableById($id)) {

                $comment->task= $target_id;

                /**
                * @@@ do we have to reset ->comment as well?
                *
                * this splits discussions into separate comments...
                */
                $comment->comment= 0;
                $comment->update();
            }
            else {
                new FeedbackWarning(sprintf(__("Can not edit comment %s"), asHtml($comment->name)));
            }
        }

        ### return to from-page? ###
        if(!$PH->showFromPage()) {
            $PH->show('home');
        }
        exit();
    }


    /**
    * build page folder list to select target...
    */
    require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');

    ### get project ####
    if(!$comment= Comment::getVisibleById($comment_ids[0])) {
        $PH->abortWarning("could not get comment", ERROR_BUG);
    }

    if(!$project= Project::getVisibleById($comment->project)) {
        $PH->abortWarning("task without project?", ERROR_BUG);
    }


    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>false, 'autofocus_field'=>'company_name'));
        $page->cur_tab='projects';
        $page->type= __("Edit tasks");
        $page->title= $project->name;
        $page->title_minor=__("Select one folder to move comments into");

        $page->crumbs= build_project_crumbs($project);

        $page->options[]= new NaviOption(array(
            'target_id'     =>'commentsMoveToFolder',
        ));

        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    echo __("... or select nothing to move to project root");

    ### write form #####
    {
        ### write selected comments as hidden fields ###
        foreach($comment_ids as $id) {
            if($comment= Comment::getEditableById($id)) {
                echo "<input type=hidden name='comments_{$id}_chk' value='1'>";
            }
        }


        ### write list of folders ###
        {
            $list= new ListBlock_tasks();
            $list->reduced_header= true;
            $list->query_options['show_folders']= true;
            $list->query_options['folders_only']= true;
            $list->query_options['project']= $project->id;
            $list->groupings= NULL;
            $list->block_functions= NULL;
            $list->id= 'folders';
              unset($list->columns['project']);
            unset($list->columns['status']);
            unset($list->columns['date_start']);
            unset($list->columns['days_left']);
            unset($list->columns['created_by']);
            unset($list->columns['label']);
            $list->no_items_html=__("No folders in this project...");

            $list->functions= array();

            $list->active_block_function = 'tree';


            $list->print_automatic($project);
        }


        echo "<input type=hidden name='from_selection' value='1'>";             # keep flag to ungroup comments
        echo "<input type=hidden name='project' value='$project->id'>";
        $button_name=__("Move items");
        echo "<input class=button2 type=submit value='$button_name'>";

        $PH->go_submit='commentsMoveToFolder';

    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd());

}



?>