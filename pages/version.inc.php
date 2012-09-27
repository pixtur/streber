<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file
 * pages relating to versions
 *
 * @author         Thomas Mann
 */


require_once("db/class_task.inc.php");
require_once("db/class_project.inc.php");
#require_once("db/class_version.inc.php");
require_once("render/render_list.inc.php");

/**
* versionNew @ingroup pages
* - requires prj
*/
function versionNew()
{
    global $PH;
    global $auth;

    $name=get('new_name')
        ? get('new_name')
        :__("New Version");

    ### first try single project-id ###
    $project=NULL;
    if($ids=getPassedIds('prj','projects_*')) {
        $project= Project::getVisibleById($ids[0]);
    }


    if(!$project) {
        $PH->abortWarning("ERROR: could not get Project");
        exit;
    }

    ### build new object ###
    $newVersion= new Version(array(
        'id'        =>0,
        'name'      =>$name,
        'project'   =>$project->id,
        )
    );
    $PH->show('versionEdit',array('version'=>$newVersion->id),$newVersion);
}


/**
* version edit @ingroup pages
*/
function versionEdit($version=NULL) {
    global $PH;

    if(!$version) {
        $id= getOnePassedId('version','versions_*');   # WARNS if multiple; ABORTS if no id found
        if(!$version= Version::getEditableById($id)) {
            $PH->abortWarning("ERROR: could not get Version");
            return;
        }
    }

    if(!$project=Project::getVisibleById($version->project)) {
            $PH->abortWarning("ERROR: could not get Project",ERROR_BUG);
    }

    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>true, 'autofocus_field'=>'version_name'));
    	$page->cur_tab='projects';
        $page->type=__('Edit Version','page type');
        $page->title=$version->name;

        $page->crumbs= build_project_crumbs($project);
        $page->crumbs[]= new NaviCrumb(array(
            'target_id' => 'versionEdit',
        ));

        if($version->id) {
            $page->title=__('Edit Version','page title');
        }
        else {
            $page->title=__('New Version','page title');
        }

        $page->title_minor= sprintf(__('On project %s','page title add on'),$project->name);


        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form #####
    {
        require_once("render/render_form.inc.php");

        $form=new PageForm();
        $form->button_cancel=true;

        $form->add($version->fields['name']->getFormElement($version));

        $form->add($version->fields['time_released']->getFormElement($version));
        $form->add($version->fields['description']->getFormElement($version));

        ### released ###


        ### public-level ###
        if(($pub_levels= $version->getValidUserSetPublicLevels())
            && count($pub_levels)>1) {
            $form->add(new Form_Dropdown('version_pub_level',  __("Publish to"),$pub_levels,$version->pub_level));
        }


        echo ($form);

        $PH->go_submit='versionEditSubmit';
        echo "<input type=hidden name='version' value='$version->id'>";
        echo "<input type=hidden name='version_project' value='$version->project'>";
    }
    echo (new PageContentClose);
	echo (new PageHtmlEnd);
}


/**
* Submitting changes to version @ingroup pages
*/
function versionEditSubmit()
{
    global $PH;

    ### get version ####
    $id= getOnePassedId('version');

    if($id == 0) {
        $version= new Version(array('id'=>0));
    }
    else {
        $version= Version::getEditableById($id);
        if(!$version) {
            $PH->abortWarning(__("Could not get version"));
            return;
        }
    }

    ### cancel ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('projView',array('prj'=>$version->project));
        }
        exit;
    }

    ### Validate integrety ###
    if(!validateFormCrc()) {
        $PH->abortWarning(__('Invalid checksum for hidden form elements'));
    }
    
    validateFormCaptcha(true);


    ### get project ###
    $version->project=get('version_project');
    if(!$project = Project::getVisibleById($version->project)) {
        $PH->abortWarning(__("Could not get project of version"));
    }

    # retrieve all possible values from post-data
    # NOTE:
    # - this could be an security-issue.
    # - TODO: as some kind of form-edit-behaviour to field-definition
    foreach($version->fields as $f) {
        $name=$f->name;
        $f->parseForm($version);
    }


    ### pub level ###
    if($pub_level=get('version_pub_level')) {

        ### not a new version ###
        if($version->id) {
             if($pub_level > $version->getValidUserSetPublicLevels() ) {
                 $PH->abortWarning('invalid data',ERROR_RIGHTS);
             }
        }
        #else {
        #    #@@@ check for person create rights
        #}
        $version->pub_level = $pub_level;
    }



    ### go back to from if validation fails ###
    $failure= false;
    if(!$version->name) {
        $failure= true;
        new FeedbackWarning(__("Name required"));
    }
    if($failure) {
        $PH->show('versionEdit',NULL,$version);
        exit;
    }


    ### write to db ###
    if($version->id == 0) {
        $version->insert();
    }
    else {
        $version->update();
    }

    if(!$PH->showFromPage()) {
        $PH->show('projView',array('prj'=>$version->project));
    }
}


/**
* Deleting version(s) @ingroup pages
*/
function versionsDelete()
{
    global $PH;

    ### get versions ####
    $ids= getPassedIds('version','versions_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some versions to delete"));
        return;
    }

    $counter=0;
    $errors=0;
    foreach($ids as $id) {
        $e= Version::getEditableById($id);
        if(!$e) {
            $PH->abortWarning("Invalid version-id!");
        }
        if($e->delete()) {
            $counter++;
        }
        else {
            $errors++;
        }
    }
    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to delete %s versions"), $errors));
    }
    else {
        new FeedbackMessage(sprintf(__("Moved %s versions to trash"),$counter));
    }

    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}


/**
* view details of a version @ingroup pages
*/
function versionView(){
    global $PH;
	global $auth;
    require_once("render/render_wiki.inc.php");

    ### get task ####
    if(!$version=Version::getVisibleById(get('version'))) {
        $PH->abortWarning("invalid version-id",ERROR_FATAL);
    }

    if(!$project= Project::getVisibleById($version->project)) {
        $PH->abortWarning("invalid project-id",ERROR_FATAL);
    }

    ### create from handle ###
    $from_handle= $PH->defineFromHandle(array('version'=>$version->id));
	
	## is viewed by user ##
	$version->isViewedByUser($auth->cur_user);

    ### set up page and write header ####
    {
        $page= new Page();
    	$page->cur_tab='projects';

        $page->cur_crumb= 'projViewTasks';
        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);

        $type= __('Version','page type');

        if($task) {
             $folder= $task->getFolderLinks() ."<em>&gt;</em>". $task->getLink();
             $page->type= $folder." > ". $type;
        }
        else {
             $page->type= $type;
        }

        $page->title=$version->name;
        $page->title_minor="";;
        if($version->state== -1) {
            $page->title_minor=sprintf(__('(deleted %s)','page title add on with date of deletion'),renderTimestamp($version->deleted));
        }

        ### page functions ###
        $page->add_function(new PageFunction(array(
            'target'    =>'versionEdit',
            'params'    =>array('version'=>$version->id),
            'icon'      =>'edit',
            'tooltip'   =>__('Edit this version'),
            'name'      =>__('Edit')
        )));
		
		$item = ItemPerson::getAll(array('person'=>$auth->cur_user->id,'item'=>$version->id));
		if((!$item) || ($item[0]->is_bookmark == 0)){
			$page->add_function(new PageFunction(array(
				'target'    =>'itemsAsBookmark',
				'params'    =>array('version'=>$version->id),
				'tooltip'   =>__('Mark this version as bookmark'),
				'name'      =>__('Bookmark'),
			)));
		}
		else{
			$page->add_function(new PageFunction(array(
				'target'    =>'itemsRemoveBookmark',
				'params'    =>array('version'=>$version->id),
				'tooltip'   =>__('Remove this bookmark'),
				'name'      =>__('Remove Bookmark'),
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
        $str= wikifieldAsHtml($version, 'description');

        echo "<div class=text>";
        echo "$str";
        echo "</div>";

        $block->render_blockEnd();
    }

    echo '<input type="hidden" name="prj" value="'.$version->project.'">';

    /**
    * give parameter for create of new items (subtasks, efforts, etc)
    */
    #echo '<input type="hidden" name="parent_task" value="'.$task->id.'">';

    echo (new PageContentClose);
	echo (new PageHtmlEnd);
}



?>
