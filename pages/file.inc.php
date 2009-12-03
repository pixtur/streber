<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file
* pages relating to files
*
* @author         Thomas Mann
*/



require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_file.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');

/**
* View details of a file (versions, etc) @ingroup pages
*/
function fileView()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

    ### get object ####
    $file_id= getOnePassedId('file');
    if(!$file= File::getVisibleById($file_id)) {
        $PH->abortWarning("invalid file-id",ERROR_FATAL);
    }

    $file_org= $file->getOriginal();

    if($file->is_latest) {
        $file_latest= $file;
    }
    else {
        $file_latest= $file->getLatest();
    }

    if(!$project= Project::getVisibleById($file->project)) {
        $PH->abortWarning("invalid project-id",ERROR_FATAL);
    }

    /**
    * parent item (not implemented yet)
    */
    $parent_task = NULL;
    if($file->parent_item) {
        #trigger_error('@@@not implemented yet', E_USER_ERROR);

        if(!$parent_task = Task::getVisibleById(intval($file->parent_item))) {
            $PH->messages[]=sprintf(__("Could not access parent task Id:%s"), $file->parent_item);
        }
    }

    ### create from handle ###
    $from_handle= $PH->defineFromHandle(array('file'=>$file->id));

    ## is viewed by user ##
    $file->nowViewedByUser();

    ### set up page and write header ####
    {
        $page= new Page();
        initPageForFile($page, $file, $project);

        #$page->title_minor=sprintf('#%d', $file_org->id);;
        
        if($file->state== -1) {
            $page->title_minor=sprintf(__('(deleted %s)','page title add on with date of deletion'),renderTimestamp($file->deleted));
        }

        ### page functions ###
        $page->add_function(new PageFunction(array(
            'target'=>'fileEdit',
            'params'=>array('file'=>$file->id),
            'icon'=>'edit',
            'tooltip'=>__('Edit this file'),
            'name'=>__('Edit')
        )));

        $page->add_function(new PageFunction(array(
            'target'=>'filesMoveToFolder',
            'params'=>array("file"=>$file->id),
            'tooltip'=>__('Move this file to another task'),
            'name'=>__('Move')
        )));
        
        if($auth->cur_user->settings & USER_SETTING_ENABLE_BOOKMARKS) {
            $item = ItemPerson::getAll(array('person'=>$auth->cur_user->id,'item'=>$file->id));
            if((!$item) || ($item[0]->is_bookmark == 0)){
                $page->add_function(new PageFunction(array(
                    'target'    =>'itemsAsBookmark',
                    'params'    =>array('file'=>$file->id),
                    'tooltip'   =>__('Mark this file as bookmark'),
                    'name'      =>__('Bookmark'),
                )));
            }
            else{
                $page->add_function(new PageFunction(array(
                    'target'    =>'itemsRemoveBookmark',
                    'params'    =>array('file'=>$file->id),
                    'tooltip'   =>__('Remove this bookmark'),
                    'name'      =>__('Remove Bookmark'),
                )));
            } 
        }


        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);


    #--- upload new versions --------
    {
        $block=new PageBlock(array('title'=>__('Upload new version','block title'),'id'=>'summary'));
        $block->render_blockStart();

        echo "<div class=text>";
        echo '<input type="hidden" name="MAX_FILE_SIZE" value="'. confGet('FILE_UPLOAD_SIZE_MAX'). '" />';
        echo '<input id="userfile" name="userfile" type="file" size="40" accept="*" />';
        echo '<input type="submit" value="'.__('Upload').'" />';
        echo '</div>';

        $block->render_blockEnd();

    }


    #--- summary ----------------------------------------------------------------
    {
        $block=new PageBlock(array(
            'title'=>sprintf(__('Version #%s (current): %s'), $file_latest->version, $file_latest->name),
            'id'=>'description'
        ));
        $block->render_blockStart();

        echo "<div class=text>";

        ### show thumbnail
        if($file_latest->mimetype == "image/png" || $file_latest->mimetype == "image/x-png" || $file_latest->mimetype == "image/jpeg" || $file_latest->mimetype == "image/gif") {
            echo "<div class=image style='float:right;'><a href='index.php?go=fileDownloadAsImage&amp;file=$file_latest->id'>";
            echo "<img src='index.php?go=fileDownloadAsImage&amp;file=$file_latest->id&amp;max_size=128'>";
            echo "</a></div>";
        }

        if($parent_task)  {
            echo "<div class=labeled><label>" . __('For task') .  "</label><span>".$parent_task->getLink(false). "</span></div>";
        }
        echo "<div class=labeled><label>" . __('Filesize') .  "</label><span>$file_latest->filesize bytes</span></div>";
        echo "<div class=labeled><label>" . __('Type') .  "</label><span>$file_latest->mimetype</span></div>";
        echo "<div class=labeled><label>" . __('Uploaded') .  "</label><span>". renderDateHtml($file_latest->created) ."</span></div>";
        if($uploader = Person::getVisibleById($file->created_by)) {
            echo "<div class=labeled><label>" . __('Uploaded by') .  "</label><span>". $uploader->getLink()  ."</span></div>";
        }
        if($file_latest->created != $file_latest->modified) {
            echo "<div class=labeled><label>" . __('Modified') .  "</label><span>". renderDateHtml($file_latest->created) ."</span></div>";
        }
        echo "<div class=labeled><label>". __('Download'). "</label><span>". $PH->getLink('fileDownload', $file_latest->org_filename ,array('file'=>$file_latest->id))."</span></div>";

        $str= wikifieldAsHtml($file_latest, 'description');
        echo "<br>";
        echo "$str";

        echo "</div>";



        $block->render_blockEnd();
    }

    ### list previous versions ###
    {
        /**
        * build list of old versions,
        * because org_file is zero for the original file, with have to append it
        */
        $old_files= File::getAll(array(
            'latest_only'   =>false,
            'org_file'      =>$file_org->id,
            'order_by'      =>'version DESC',
            'project'       =>$project->id,
        ));
        if($file_latest->id != $file_org->id) {
            $old_files[] = $file_org;
        }

        foreach($old_files as $of) {
            if($of->id != $file_latest->id) {

                $block=new PageBlock(array(
                    'title'=>sprintf(__('Version #%s : %s'),$of->version, $of->name),
                    'id'=>'version_'.$of->id,
                ));
                $block->render_blockStart();

                echo "<div class=text>";

                ### show thumbnail
                if($of->mimetype == "image/png" || $of->mimetype == "image/x-png"  || $of->mimetype == "image/jpeg" || $of->mimetype == "image/gif") {
                    echo "<div class=image style='float:right;'><a href='index.php?go=fileDownloadAsImage&file=$of->id'>";
                    echo "<img src='index.php?go=fileDownloadAsImage&file=$of->id&max_size=128'>";
                    echo "</a></div>";
                }

                $str= wikifieldAsHtml($of, 'description');
                echo "$str";

                echo "<div class=labeled><label>" . __('Filesize') .  "</label><span>$of->filesize bytes</span></div>";
                echo "<div class=labeled><label>" . __('Type') .  "</label><span>$of->mimetype</span></div>";
                echo "<div class=labeled><label>" . __('Uploaded') .  "</label><span>". renderDateHtml($of->created) ."</span></div>";

                #echo "<div class=labeled><label>" . __('Version') .  "</label><span>". intval($of->version) ."</span></div>";
                echo "<div class=labeled>". $PH->getLink('fileDownload','',array('file'=>$of->id))."</div>";

                echo "</div>";

                $block->render_blockEnd();
            }
        }
    }



    $PH->go_submit='fileUpdate';


    /**
    * list comments
    * NOTE: can files have comments?
    */

    /*
    {
        $comments= $file->getComments();
        $list=new ListBlock_comments();
        $list->no_items_html=$PH->getLink('commentNew','',array('parent_task'=>$task->id));
        $list->render_list($comments);
    }
    */

    echo '<input type="hidden" name="prj"  value="'.$file->project.'">';
    echo '<input type="hidden" name="org_file" value="'.$file->id.'">';

    /**
    * give parameter for create of new items (subtasks, efforts, etc)
    */
    #echo '<input type="hidden" name="parent_task" value="'.$task->id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}


/**
* Upload a new version of a file @ingroup pages
*
* read more at http://www.streber-pm.org/3658
*/
function fileUpdate()
{
    global $PH;

    ### first try single project-id ###
    $project=NULL;
    if($ids=getPassedIds('prj','projects_*')) {
        if(!$project= Project::getVisibleById($ids[0])) {
            $PH->abortWarning("ERROR: could not get Project", E_USER_WARNING);
            return;
        }
    }


    ### get original file ###
    if(!$updated_file= File::getEditableById(get('org_file'))) {
        $PH->abortWarning("ERROR: Can not find old file", E_USER_WARNING);
    }
    if(!$file_org= $updated_file->getOriginal()) {
        $PH->abortWarning("ERROR: Can not find old file", E_USER_WARNING);
    }
    if(!$file_latest= $updated_file->getLatest()) {
        $PH->abortWarning("ERROR: Can not find old file", E_USER_WARNING);
    }

    if(!$project) {
        if(!$project= Project::getVisibleById($file_org->project)) {
            $PH->abortWarning("Invalid project for task?", ERROR_BUG);
        }
    }

    $new_file= File::getUploaded();
    if(!$new_file) {
        $PH->abortWarning("Nothing uploaded");
    }

    ### build new object ###
    $new_file->project      = $project->id;
    $new_file->parent_item  = $file_org->parent_item;
    $new_file->org_file     = $file_org->id;
    $new_file->version      = $file_latest->version + 1;

    $PH->show('fileEdit',array('file'=>$new_file->id),$new_file);

}


/**
* Upload files @ingroup pages
*
* read more at http://www.streber-pm.org/3658
*/
function filesUpload()
{
    global $PH;

    $new_file= File::getUploaded();
    if(!$new_file) {
        $PH->abortWarning("Nothing uploaded");
    }

    ### first try single project-id ###
    $project=NULL;
    if($ids=getPassedIds('prj','projects_*')) {
        if(!$project= Project::getVisibleById($ids[0])) {
            $PH->abortWarning("ERROR: could not get Project");
            return;
        }
    }


    ### try to get task ###
    $task_id=0;
    if($task_ids= getPassedIds('parent_task','tasks_*')) {
        if(count($task_ids) > 1) {
            $PH->messages[] = __("only expected one task. Used the first one.");
        }
        $task_id= $task_ids[0];
    }


    ### try to get folder ###
    else if($task_ids= getPassedIds('','folders_*')) {
        if(count($task_ids) > 1) {
            $PH->messages[] = __("only expected one task. Used the first one.");
        }
        $task_id= $task_ids[0];
    }
    if($task_id) {
        if($task= Task::getEditableById($task_id)) {
            $new_file->parent_item= $task->id;
        }
        else {
            $PH->abortWarning(__('Could not edit task'), ERROR_RIGHTS);
        }
    }

    if(!$project) {
        if( !$task_id) {
            $PH->abortWarning("Could not get project",ERROR_NOTE);
        }
        if(!$task= Task::getVisibleById($task_id)) {
            $PH->abortWarning("Invalid task id?", ERROR_BUG);
        }
        if(!$project= Project::getVisibleById($task->project)) {
            $PH->abortWarning("Invalid project for task?", ERROR_BUG);
        }
    }

    ### build new object ###
    $new_file->project = $project->id;
    $PH->show('fileEdit',array('file'=>$new_file->id),$new_file);
}



/**
* Edit meta information of a file
*
* read more at http://www.streber-pm.org/3658
*/
function fileEdit($file=NULL)
{
    global $PH;

    if(!$file) {
        $id= getOnePassedId('file','files_*');   # WARNS if multiple; ABORTS if no id found
        if(!$file= File::getEditableById($id)) {
            $PH->abortWarning("ERROR: could not get File");
            return;
        }
    }

    if(!$project=Project::getVisibleById($file->project)) {
        $PH->abortWarning("ERROR: could not get Project",ERROR_BUG);
    }

    ### set up page and write header ####
    {


        $page= new Page(array('use_jscalendar'=>true, 'autofocus_field'=>'file_name'));
        initPageForFile($page, $file, $project);

        if($file->id) {
            $page->title=__('Edit File','page title');
        }
        else {
            $page->title=__('New file','page title');
        }

        #$page->title_minor= sprintf(__('On project %s','page title add on'),$project->name);


        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    $block=new PageBlock(array(
        'id'    =>'edit',
    ));
    $block->render_blockStart();

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');

        $form=new PageForm();
        $form->button_cancel=true;

        $form->add($file->fields['name']->getFormElement(&$file));

        $form->add($file->fields['description']->getFormElement(&$file));

        /**
        * until new file is added to database keep details in hiddenfields
        */
        if($file->id == 0) {
            $form->add(new Form_HiddenField('file_mimetype',        '',urlencode($file->mimetype)));
            $form->add(new Form_HiddenField('file_filesize',        '',intval($file->filesize)));
            $form->add(new Form_HiddenField('file_org_filename',    '',urlencode($file->org_filename)));
            $form->add(new Form_HiddenField('file_tmp_filename',    '',urlencode($file->tmp_filename)));
            $form->add(new Form_HiddenField('file_tmp_dir',         '',$file->tmp_dir));
            $form->add(new Form_HiddenField('file_is_image',        '',$file->is_image));
            $form->add(new Form_HiddenField('file_version',         '',$file->version));
            $form->add(new Form_HiddenField('file_parent_item',     '',$file->parent_item));
            $form->add(new Form_HiddenField('file_org_file',        '',$file->org_file));
        }
        $form->add(new Form_HiddenField('file',             '',$file->id));
        $form->add(new Form_HiddenField('file_project',     '',$file->project));



        ### status ###
        {
            $st=array();
            global $g_status_names;
            foreach($g_status_names as $s=>$n) {
                if($s >= STATUS_NEW) {
                    $st[$s]=$n;
                }
            }
            $form->add(new Form_Dropdown('file_status',"Status",array_flip($st),  $file->status));
        }

        ### public-level ###
        if(($pub_levels= $file->getValidUserSetPublicLevels())
            && count($pub_levels)>1) {
            $form->add(new Form_Dropdown('file_pub_level',  __("Publish to"),$pub_levels,$file->pub_level));
        }

        echo ($form);

        $PH->go_submit='fileEditSubmit';
    }
    $block->render_blockEnd();

    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}


/**
* Submit information to a file @ingroup pages
*
* read more at http://www.streber-pm.org/3658
*/
function fileEditSubmit()
{
    global $PH;

    ### Validate form crc
    if(!validateFormCrc()) {
        $PH->abortWarning(__('Invalid checksum for hidden form elements'));
    }

    $id=getOnePassedId('file');

    ### temp new file-object ####
    if($id == 0) {
        $file= new File(array('id'=>0));

        $file->mimetype= get('file_mimetype')
            ? urldecode(get('file_mimetype'))
            : NULL;

        $file->org_filename= get('file_org_filename')
                        ? urldecode(get('file_org_filename'))
                        : NULL;

        $file->tmp_filename= get('file_tmp_filename')
                        ? urldecode(get('file_tmp_filename'))
                        : NULL;

        $file->tmp_dir= get('file_tmp_dir')
                        ? get('file_tmp_dir')
                        : NULL;


        ### make sure file is not already uploaded ###
        #if(!file_exists("_uploads/". $file->tmp_dir)) {
        #    $PH->abortWarning("Not again");
        #}


        $file->filesize= intval(get('file_filesize'));

        $file->is_image     = intval(get('file_is_image'));
        $file->version      = intval(get('file_version'));
        $file->parent_item  = intval(get('file_parent_item'));
        $file->org_file     = intval(get('file_org_file'));
    }
    ### from database ###
    else {
        $file= File::getEditableById($id);
        if(!$file) {
            $PH->abortWarning(__("Could not get file"));
            return;
        }
    }

    ### cancel ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('projView',array('prj'=>$file->project));
        }
        exit();
    }



    $file->project=get('file_project');
    if(!$project = Project::getVisibleById($file->project)) {
        $PH->abortWarning(__("Could not get project of file"));
    }


    if(!is_null(get('file_name'))) {
        $file->name= get('file_name');
    }

    if(!is_null(get('file_description'))) {
        $file->description= get('file_description');
    }

    if(!is_null(get('file_status'))) {
        $file->status= get('file_status');
    }

    ### pub level ###
    if($pub_level=get('file_pub_level')) {

        ### not a new file ###
        if($file->id) {
             if($pub_level > $file->getValidUserSetPublicLevels() ) {
                 $PH->abortWarning('invalid data',ERROR_RIGHTS);
             }
        }
        else {
            #@@@ check for person create rights
            $foo= true;
        }
        $file->pub_level = $pub_level;
    }


    ### go back to from if validation fails ###
    $failure= false;
    if($file->name == "") {
        $failure= true;
        $PH->messages[]=__("Please enter a proper filename");
    }

    if($failure) {
        $PH->show('fileEdit',NULL,$file);
        exit();
    }

    ### write to db ###
    if($file->id == 0) {

        $latest_file= NULL;
        if($file->org_file) {
            if(!$org_file= File::getEditableById($file->org_file)) {                
                $PH->abortWarning("unable to write parent file", ERROR_RIGHTS);
            }
            if(!$latest_file= $org_file->getLatest()) {
                $PH->abortWarning("unable to get latest file", ERROR_RIGHTS);
            }            
        }

        if(!$file->insert()) {
            $PH->abortWarning("Could not insert file to db");
        }

        ### updated former latest file? ###
        if($latest_file) {                
            $latest_file->is_latest= 0;
            $latest_file->update();                    
            new FeedbackMessage(sprintf(__("Uploaded new version of file with Id %s"), $file->id));
        }
        else {
            new FeedbackMessage(sprintf(__("Uploaded new file with Id %s"), $file->id));            
        }
    }
    else {
        new FeedbackMessage(sprintf(__("Updated file with Id %s"), $file->id));            
        $file->update();
    }

    ### update date of parent items ? ###
    if($item= DbProjectItem::getEditableById($file->parent_item)) {
        $item->update(array());        
    }

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('projView',array('prj'=>$file->project));
    }
}


/**
* Delete some files @ingroup pages
*/
function filesDelete()
{
    global $PH;

    ### get file ####
    $ids= getPassedIds('file','files_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some files to delete"));
        return;
    }

    $counter=0;
    $errors=0;
    foreach($ids as $id) {
        $f= file::getEditableById($id);
        if(!$f) {
            $PH->abortWarning("Invalid file-id!");
        }
        if($f->delete()) {
            $counter++;
        }
        else {
            $errors++;
        }
    }
    if($errors) {
        $PH->messages[]=sprintf(__("Failed to delete %s files"), $errors);
    }
    else {
        $PH->messages[]=sprintf(__("Moved %s files to trash"),$counter);
    }

    if(!$PH->showFromPage()) {
        $PH->show('projView',array('prj'=>$file->project));
    }
}


/**
* downloads a file @ingroup pages
*
*/
function fileDownload()
{

    ### get file ####
    $id= getOnePassedId('file','files_*');

    if(!$file= File::getVisibleById($id)) {
        global $PH;
        $PH->abortWarning(__("Select some file to display"));
        return;
    }
    $file->download();
}

/**
* downloads a file as image @ingroup pages
*
*/
function fileDownloadAsImage()
{

    ### get file ####
    $id= getOnePassedId('file','files_*');

    if(!$file= File::getVisibleById($id)) {
        $PH->abortWarning(__("Select some file to display"));
        return;
    }

    if($max_size = get('max_size')) {
        if($max_size > 200) {
            $file->nowViewedByUser();
        }
        $file->viewAsImage($max_size);
            
    }
    else {
        $file->view();
        $file->nowViewedByUser();
    }
}










/**
* move files to folder...
*
* NOTE: this works either...
* - directly by passing a target folder in 'folder' or 'folders_*'
* - in two steps, whereas
*   - the passed task-ids are keept as hidden fields,
*   - a list with folders is been rendered
*   - a flag 'from_selection' is set
*   - after submit, the kept tasks are moved to 'folders_*'
*
*/
function FilesMoveToFolder()
{
    global $PH;

    $file_ids= getPassedIds('file','files_*');

    if(!$file_ids) {
        $PH->abortWarning(__("Select some files to move"));
        exit();
    }



    /**
    * by default render list of folders...
    */
    $target_id=-1;

    /**
    * ...but, if folder was given, directly move files...
    */
    $folder_ids= getPassedIds('folder','folders_*');
    if(count($folder_ids) == 1) {
        if($folder_task= Task::getVisibleById($folder_ids[0])) {
            $target_id= $folder_task->id;
        }
    }

    /**
    * if no folders was selected, move files to project root
    */
    else if(get('from_selection')) {
        $target_id= 0;
    }


    if($target_id != -1) {


        if($target_id != 0){
            if(!$target_task= Task::getEditableById($target_id)) {
                $PH->abortWarning(__("insufficient rights"));

            }
            ### get path of target to check for cycles ###
            $parent_tasks= $target_task->getFolder();
            $parent_tasks[]= $target_task;
        }
        else {
            $parent_tasks=array();
        }


        $count=0;
        foreach($file_ids as $id) {
            if($file= File::getEditableById($id)) {

                $file->parent_item= $target_id;
                $file->update();
            }
            else {
                $PH->messages[]= sprintf(__("Can not edit file %s"), $file->name);
            }
        }

        ### return to from-page? ###
        if(!$PH->showFromPage()) {
            $PH->show('home');
        }
        exit();
    }
    #else if($target_id != -1) {
    #    $PH->abortWarning(__("insufficient rights to edit any of the selected items"));
    #}




    /**
    * build page folder lists...
    */

    ### get project ####
    if(!$file= File::getVisibleById($file_ids[0])) {
        $PH->abortWarning("could not get file", ERROR_BUG);
    }

    if(!$project= Project::getVisibleById($file->project)) {
        $PH->abortWarning("file without project?", ERROR_BUG);
    }


    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>false, 'autofocus_field'=>'company_name'));
        $page->cur_tab='projects';
        $page->type= __("Edit files");
        $page->title="$project->name";
        $page->title_minor=__("Select folder to move files into");

        $page->crumbs= build_project_crumbs($project);

        $page->options[]= new NaviOption(array(
            'target_id'     =>'filesMoveToFolder',
        ));

        echo(new PageHeader);
    }
    echo (new PageContentOpen);


    ### write form #####
    {
        ### write files as hidden entry ###
        foreach($file_ids as $id) {
            if($file= File::getEditableById($id)) {
                echo "<input type=hidden name='files_{$id}_chk' value='1'>";
            }
        }


        ### write list of folders ###
        {
            require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');
            $list= new ListBlock_tasks();
            $list->query_options['show_folders']= true;
            #$list->query_options['folders_only']= true;
            $list->query_options['project']= $project->id;
            $list->groupings= NULL;
            $list->block_functions= NULL;
            $list->id= 'folders';
            $list->no_items_html= __('No folders available');
            unset($list->columns['status']);
            unset($list->columns['date_start']);
            unset($list->columns['days_left']);
            unset($list->columns['created_by']);
            unset($list->columns['label']);
            unset($list->columns['project']);

            $list->functions= array();

            $list->active_block_function = 'tree';


            $list->print_automatic($project,NULL);
        }

        echo __("(or select nothing to move to project root)"). "<br> ";

        echo "<input type=hidden name='from_selection' value='1'>";             # keep flag to ungroup files
        echo "<input type=hidden name='project' value='$project->id'>";
        $button_name=__("Move items");
        echo "<input class=button2 type=submit value='$button_name'>";

        $PH->go_submit='filesMoveToFolder';

    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd());

}

?>
