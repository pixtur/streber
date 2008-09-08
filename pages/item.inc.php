<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file 
* pages relating to Items 
*/


require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/db_itemperson.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_taskfolders.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_comments.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');


/**
* Channels the view an item to correct page @ingroup pages
*
* This Page is required for SEF-Urls. With the ID it get the request Item from the database and depending
* on its type it renders the appropriate view page.
*/
function itemView()
{
    global $PH;
    if(!$id= intval(get('item'))) {
        $id= intval(get('id'));        
    }

    if($item= DbProjectItem::getVisibleById($id)) {
        switch($item->type) {
            case ITEM_TASK:
                $PH->show('taskView',array('tsk'=>$id));
                return;
            case ITEM_FILE:
                $PH->show('fileView',array('file'=>$id));
                return;
            case ITEM_COMMENT:
                $PH->show('commentView',array('comment'=>$id));
                return;
            case ITEM_EFFORT:
                $PH->show('effortView',array('effort'=>$id));
                return;
            case ITEM_PERSON:
                $PH->show('personView',array('person'=>$id));
                return;
            case ITEM_PROJECT:
                $PH->show('projView',array('prj'=>$id));
                return;
            case ITEM_COMPANY:
                $PH->show('companyView',array('company'=>$id));
                return;
            default:
                $PH->abortWarning("Unknown item");
                return;
        }
    }
    else {
        $PH->abortWarning("Unknown item");
    }
}



function itemsSetPubLevel()
{
    global $PH;

    $ids= getPassedIds('item','items_*');
    global $g_pub_level_names;

    if(!$ids) {
        $PH->abortWarning(__("Select some items(s) to change pub level"), ERROR_NOTE);
        return;
    }
    if(!($new_pub_level= get('item_pub_level'))
        ||
        !isset($g_pub_level_names[$new_pub_level])
    ) {
        $PH->abortWarning("itemsSetPubLevel requires item_pub_level", ERROR_NOTE);
        return;
    }

    $count      = 0;
    $num_errors = 0;

    foreach($ids as $id) {
        if($item = DbProjectItem::getEditableById($id)) {

            $count++;
            $item->pub_level = $new_pub_level;
            $item->update();
        }
        else {
            $num_errors++;
        }
    }
    new FeedbackMessage(sprintf(__("Made %s items public to %s"),$count, $g_pub_level_names[$new_pub_level]));
    if($num_errors) {
        new FeedbackWarning(sprintf(__("%s error(s) occured"), $num_errors));
    }

    ### return to from-page ###
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}


/**
* add some items to bookmarks of current user @ingroup pages
*/
function itemsAsBookmark()
{
	global $PH;
	global $auth;
	
	$count = 0;
	$valid = false;

	if($ids = getPassedIds('task', 'tasks_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('person', 'persons_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('company', 'companies_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('proj', 'projects_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('effort', 'efforts_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('comment', 'comments_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('file', 'files_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('version', 'versions_*')){
		$valid = true;
	}
	else{
		$PH->abortWarning(__("No item(s) selected."), ERROR_NOTE);
	}
		
	## not a nice solution with 'bookmark'=>$ids[0], but the more important value is the '$ids' value ##
	if($valid){
		$PH->show('itemBookmarkEdit', array('bookmark'=>$ids[0]), $ids);
	}
}

/**
* Remove some items from bookmarks of current user @ingroup pages
*/
function itemsRemoveBookmark()
{
	global $PH;
	global $auth;

	$count = 0;
	$error = 0;
	$valid = false;
	
	$ids = getPassedIds('bookmark', 'bookmarks_*');
	
	if(!$ids){
		if($ids = getPassedIds('task', 'tasks_*')){
			$valid = true;
		}
		elseif($ids = getPassedIds('person', 'persons_*')){
			$valid = true;
		}
		elseif($ids = getPassedIds('company', 'companies_*')){
			$valid = true;
		}
		elseif($ids = getPassedIds('proj', 'projects_*')){
			$valid = true;
		}
		elseif($ids = getPassedIds('effort', 'efforts_*')){
			$valid = true;
		}
		elseif($ids = getPassedIds('comment', 'comments_*')){
			$valid = true;
		}
		elseif($ids = getPassedIds('file', 'files_*')){
			$valid = true;
		}
		elseif($ids = getPassedIds('version', 'versions_*')){
			$valid = true;
		}
	}
	
	if(!$ids){
		$PH->abortWarning(__("Select one or more bookmark(s)"), ERROR_NOTE);
        return;
	}
	else{
		foreach($ids as $id){
			if($item = ItemPerson::getAll(array(
			        'person'=>$auth->cur_user->id,
			        'item'=>$id)
			    )){
				$item[0]->is_bookmark = false;
				$item[0]->update();
				$count++;
			}
			else{
				$error++;
			}
		}

		if($count){
			new FeedbackMessage(sprintf(__("Removed %s bookmark(s)."),$count));
		}

		if($error){
			new FeedbackMessage(sprintf(__('ERROR: Cannot remove %s bookmark(s). Please try again.'),$error));
		}
	}

	if(!$PH->showFromPage()){
		$PH->show('home');
	}
}

/**
* Edit one bookmarks @ingroup pages
*/
function itemBookmarkEdit($bookmark=NULL)
{
	global $PH;
	global $auth;
	global $g_notitychange_period;
	
	$is_already_bookmark = FALSE;
	
	### if you edit bookmarks from bookmark list ###
	if(!$bookmark){
		$ids = getPassedIds('bookmark', 'bookmarks_*');
		if(!$ids){
			$PH->abortWarning(__("Select one or more bookmark(s)"), ERROR_NOTE);
			return;
		}
		elseif(count($ids) > 1) {
			$PH->show('itemBookmarkEditMultiple');
			exit();
		}
		
		if(!$bookmark = ItemPerson::getAll(array('item'=>$ids[0], 'person'=>$auth->cur_user->id, 'is_bookmark'=>1))) {
            $PH->abortWarning(__("An error occured"), ERROR_NOTE);
        }
		else{
			$editbookmark = $bookmark[0];
		
			if(!$item = DbProjectItem::getById($editbookmark->item)) {
				$PH->abortWarning("FATAL error! Related information cannot be opened.");
			}
			
			$is_already_bookmark = TRUE;
		}
	}
	### if you add new bookmarks ###
	else{
		if(!$bookmark){
			$PH->abortWarning(__("An error occured"), ERROR_NOTE);
			return;
		}
		elseif(count($bookmark) > 1)
		{
			## not a nice solution with 'bookmark'=>$ids[0], but the more important value is the '$ids' value ##
			$PH->show('itemBookmarkEditMultiple', array('bookmark'=>$bookmark[0]), $bookmark);
			exit();
		}
				
		if($bookmarkitem = ItemPerson::getAll(array('person'=>$auth->cur_user->id, 'item'=>$bookmark[0], 'is_bookmark'=>0))){
			$editbookmark = $bookmarkitem[0];
			
			if(!$item = DbProjectItem::getById($editbookmark->item)){
				$PH->abortWarning("FATAL error! Related information cannot be opened.");
			}
			$is_already_bookmark = FALSE;
		}
		elseif($bookmarkitem = ItemPerson::getAll(array('person'=>$auth->cur_user->id, 'item'=>$bookmark[0], 'is_bookmark'=>1))){
			$editbookmark = $bookmarkitem[0];
			
			if(!$item = DbProjectItem::getById($editbookmark->item)){
				$PH->abortWarning("FATAL error! Related information cannot be opened.");
			}
			$is_already_bookmark = TRUE;
		}
		else{
			$date = getGMTString();
			$editbookmark = new ItemPerson(array(
			'id'=>0,
			'item'=>$bookmark[0],
			'person'=>$auth->cur_user->id,
			'is_bookmark'=>1,
			'notify_on_change'=>false,
			'notify_if_unchanged'=>false,
			'created'=>$date));
			
			if(!$item = DbProjectItem::getById($bookmark[0])){
				$PH->abortWarning("FATAL error! Related information cannot be opened.");
			}
			$is_already_bookmark = FALSE;
		}
	}
		
	## edit form ##
	{
		## get item name ##
		$str_name = '';
		if($type = $item->type){
			switch($type) {
				case ITEM_TASK:
					require_once("db/class_task.inc.php");
					if($task = Task::getVisibleById($item->id)) {
						$str_name = $task->name;
					}
					break;
	
				case ITEM_COMMENT:
					require_once("db/class_comment.inc.php");
					if($comment = Comment::getVisibleById($item->id)) {
						$str_name = $comment->name;
					}
					break;
	
				case ITEM_PERSON:
					require_once("db/class_person.inc.php");
					if($person = Person::getVisibleById($item->id)) {
						$str_name = $person->name;
					}
					break;
	
				case ITEM_EFFORT:
					require_once("db/class_effort.inc.php");
					if($e = Effort::getVisibleById($item->id)) {
						$str_name = $e->name;
					}
					break;
	
				case ITEM_FILE:
					require_once("db/class_file.inc.php");
					if($f = File::getVisibleById($item->id)) {
						$str_name = $f->org_filename;
					}
					break;
	
				case ITEM_PROJECT:
					require_once("db/class_project.inc.php");
					if($prj = Project::getVisibleById($item->id)) {
						$str_name = $prj->name;
					}
					break;
	
				case ITEM_COMPANY:
					require_once("db/class_company.inc.php");
					if($c = Company::getVisibleById($item->id)) {
						$str_name = $c->name;
					}
					break;
	
				case ITEM_VERSION:
					require_once("db/class_task.inc.php");
					if($tsk = Task::getVisibleById($item->id)) {
						$str_name = $tsk->name;
					}
					break;
	
				default:
					break;
	
			}
		}
		
		### set up page and write header ####
		{
			$page = new Page();
			$page->cur_tab = 'home';
	
			$page->options = array(new NaviOption(array('target_id'=>'itemBookmarkEdit','name'=>__('Edit bookmark'))));
	
			$page->type= __('Bookmark');
			$page->title = __('Edit bookmark');
			$page->title_minor = $str_name;
		   
			echo(new PageHeader);
		}
		
		echo (new PageContentOpen);
		
		### write form #####
		{
			require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
	
			$block = new PageBlock(array('id'=>'functions','reduced_header' => true,));
			$block->render_blockStart();
	
			$form = new PageForm();
			$form->button_cancel = true;
	
			$form->add($editbookmark->fields['comment']->getFormElement(&$editbookmark));
			$form->add(new Form_checkbox("notify_on_change", __('Notify on change'), $editbookmark->notify_on_change));
			
			$form->add(new Form_Dropdown("notify_period", __('Notify if unchanged in'), array_flip($g_notitychange_period), $editbookmark->notify_if_unchanged));
			
			$form->add(new Form_HiddenField('bookmark','',$editbookmark->item));
			$form->add(new Form_HiddenField('bookmark_id','',$editbookmark->id));
			$form->add(new Form_HiddenField('is_already_bookmark','',$is_already_bookmark));
			
			echo($form);
			
			$PH->go_submit = 'itemBookmarkEditSubmit';
			
			$block->render_blockEnd();
		}
		
		echo (new PageContentClose);
		echo (new PageHtmlEnd);
	}

}

/**
* submit changes to one bookmark @ingroup pages
*/
function itemBookmarkEditSubmit()
{
	global $PH;
    global $auth;

    ### cancel ? ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('home',array());
        }
        exit();
    }

    ### get bookmark ####
    $id = getOnePassedId('bookmark');
	$bm_id = getOnePassedId('bookmark_id');
	$is_already_bookmark = getOnePassedId('is_already_bookmark');
	$count = 0;
	if(($bm_id != 0) && ($is_already_bookmark)){
		if(!$bookmark = ItemPerson::getAll(array('item'=>$id, 'person'=>$auth->cur_user->id, 'is_bookmark'=>1))) {
			$PH->abortWarning(__('Could not get bookmark'));
			return;
		}
	}
	elseif(($bm_id != 0) && (!$is_already_bookmark)){
		if(!$bookmark = ItemPerson::getAll(array('item'=>$id, 'person'=>$auth->cur_user->id))) {
			$PH->abortWarning(__('Could not get bookmark'));
			return;
		}
	}
	elseif($bm_id == 0){
		$date = getGMTString();
		$bookmark = new ItemPerson(array(
			'id'=>0,
			'item'=>$id,
			'person'=>$auth->cur_user->id,
			'is_bookmark'=>1,
			'created'=>$date));
	}
	
	if($bm_id != 0){
		$bookmark = $bookmark[0];
	}
	
	# retrieve all possible values from post-data
	# NOTE:
	# - this could be an security-issue.
	# - TODO: as some kind of form-edit-behaviour to field-definition
	foreach($bookmark->fields as $f) {
		$f->parseForm(&$bookmark);
	}
	
	$notify_on_change = get('notify_on_change');
	
	if($notify_on_change){
		$bookmark->notify_on_change = true;
		$bookmark->notify_date = getGMTString();
	}
	else{
		$bookmark->notify_on_change = false;
	}
	
	$notify_period = get('notify_period');
	
	if(!is_null($notify_period)){
		$bookmark->notify_if_unchanged = $notify_period;
	}
	
	if(($bm_id != 0) && ($is_already_bookmark)){
		$bookmark->update();
	}
	elseif(($bm_id != 0) && (!$is_already_bookmark)){
		$bookmark->is_bookmark = true;
		$bookmark->created = getGMTString();
		$bookmark->update();
		$count++;
	}
	elseif($bm_id == 0){
		$bookmark->insert();
		$count++;
	}
	
	if($count){
		new FeedbackMessage(sprintf(__("Added %s bookmark(s)."),$count));
	}
	
	### display fromPage ####
	if(!$PH->showFromPage()) {
		$PH->show('home',array());
	}
}

/**
* edit several bookmarks @ingroup pages
*/
function itemBookmarkEditMultiple($thebookmarks=NULL)
{
	global $PH;
	global $auth;
	global $g_notitychange_period;
	
	$is_already_bookmark = array();
	$bookmarks = array();
	$items = array();
	
	$edit_fields=array(
        'notify_if_unchanged',
		'notify_on_change'
    );
    $different_fields=array();  # hash containing fieldnames which are different in bookmarks
	
	if(!$thebookmarks){
		$item_ids = getPassedIds('bookmark', 'bookmarks_*');
		
		foreach($item_ids as $is)
		{
			if($bookmark = ItemPerson::getAll(array('item'=>$is, 'person'=>$auth->cur_user->id))){
				if($item = DbProjectItem::getById($bookmark[0]->item)){
					$bookmarks[] = $bookmark[0];
					$items[] = $item;
					$is_already_bookmark[$bookmark[0]->id] = true;
				}
			}			
		}
	}
	else{
		$item_ids = $thebookmarks;
		
		foreach($item_ids as $is){
			if($bookmark = ItemPerson::getAll(array('item'=>$is, 'person'=>$auth->cur_user->id, 'is_bookmark'=>0))){
				if($item = DbProjectItem::getById($bookmark[0]->item)){
					$bookmarks[] = $bookmark[0];
					$items[] = $item;
					$is_already_bookmark[$bookmark[0]->id] = false;
				}
			}
			elseif($bookmark = ItemPerson::getAll(array('item'=>$is, 'person'=>$auth->cur_user->id, 'is_bookmark'=>1))){
				if($item = DbProjectItem::getById($bookmark[0]->item)){
					$bookmarks[] = $bookmark[0];
					$items[] = $item;
					$is_already_bookmark[$bookmark[0]->id] = true;
				}
			}
			else{
				$date = getGMTString();
				$bookmark = new ItemPerson(array(
					'id'=>0,
					'item'=>$is,
					'person'=>$auth->cur_user->id,
					'is_bookmark'=>1,
					'notify_if_unchanged'=>0,
					'notify_on_change'=>0,
					'created'=>$date));
					
				if($item = DbProjectItem::getById($is)){
					$bookmarks[] = $bookmark;
					$items[] = $item;
					$is_already_bookmark[$bookmark->id] = false;
				}
			}
		}
	}
	
	## edit form ##
	{
		### set up page and write header ####
		{
			$page = new Page();
			$page->cur_tab = 'home';
	
			$page->options = array(new NaviOption(array('target_id'=>'itemBookmarkEdit','name'=>__('Edit bookmarks'))));
	
			$page->type= __('Edit multiple bookmarks', 'page title');
			$page->title = sprintf(__('Edit %s bookmark(s)'), count($items));
			$page->title_minor = __('Edit');
			
			echo(new PageHeader);
		}
		
		echo (new PageContentOpen);
		
		echo "<ol>";
		foreach($items as $item){
			
			## get item name ##
			$str_link = '';
			if($type = $item->type){
				switch($type) {
					case ITEM_TASK:
						require_once("db/class_task.inc.php");
						if($task = Task::getVisibleById($item->id)) {
							$str_link = $task->getLink(false);
						}
						break;
		
					case ITEM_COMMENT:
						require_once("db/class_comment.inc.php");
						if($comment = Comment::getVisibleById($item->id)) {
							$str_link = $comment->getLink(false);
						}
						break;
		
					case ITEM_PERSON:
						require_once("db/class_person.inc.php");
						if($person = Person::getVisibleById($item->id)) {
							$str_link = $person->getLink(false);
						}
						break;
		
					case ITEM_EFFORT:
						require_once("db/class_effort.inc.php");
						if($e = Effort::getVisibleById($item->id)) {
							$str_link = $e->getLink(false);
						}
						break;
		
					case ITEM_FILE:
						require_once("db/class_file.inc.php");
						if($f = File::getVisibleById($item->id)) {
							$str_link = $f->getLink(false);
						}
						break;
		
					case ITEM_PROJECT:
						require_once("db/class_project.inc.php");
						if($prj = Project::getVisibleById($item->id)) {
							$str_link = $prj->getLink(false);
						}
						break;
		
					case ITEM_COMPANY:
						require_once("db/class_company.inc.php");
						if($c = Company::getVisibleById($item->id)) {
							$str_link = $c->getLink(false);
						}
						break;
		
					case ITEM_VERSION:
						require_once("db/class_task.inc.php");
						if($tsk = Task::getVisibleById($item->id)) {
							$str_link = $tsk->getLink(false);
						}
						break;
		
					default:
						break;
		
				}
			}
			
			echo "<li>" . $str_link . "</li>";
		}
		echo "</ol>";
		
		foreach($bookmarks as $bookmark){
			foreach($edit_fields as $field_name) {
				if($bookmark->$field_name != $bookmarks[0]->$field_name) {
					$different_fields[$field_name]= true;
				}
			}
		}
		
		$block = new PageBlock(array('id'=>'functions','reduced_header' => true,));
		$block->render_blockStart();
		
		$form = new PageForm();
        $form->button_cancel = true;
		
		### notify on change ###
        {
            $b = array();
            $b[0] = __('no');
			$b[1] = __('yes');
            if(isset($different_fields['notify_on_change'])) {
                $b[-1]= '-- ' . __('keep different') . ' --';
                $form->add(new Form_Dropdown('notify_on_change',__("Notify on change"),array_flip($b),  -1));
            }
            else {
                $form->add(new Form_Dropdown('notify_on_change',__("Notify on change"),array_flip($b),  $bookmarks[0]->notify_on_change));
            }
        }
		
		### notify if unchanged ###
        {
            $a = array();
            foreach($g_notitychange_period as $key=>$value) {
                $a[$key] = $value;
            }
            if(isset($different_fields['notify_if_unchanged'])) {
                $a[-1]=  '-- ' . __('keep different') . ' --';
                $form->add(new Form_Dropdown('notify_if_unchanged',__("Notify if unchanged in"),array_flip($a),  -1));
            }
            else {
                $form->add(new Form_Dropdown('notify_if_unchanged',__("Notify if unchanged in"),array_flip($a),  $bookmarks[0]->notify_if_unchanged));
            }
        }
		
		$number = 0;
		foreach($bookmarks as $bm){
			$form->add(new Form_HiddenField("bookmark_id_{$number}",'',$bm->id));
			$form->add(new Form_HiddenField("bookmark_item_{$number}",'',$bm->item));
			$form->add(new Form_HiddenField("is_already_bookmark_{$number}",'',$is_already_bookmark[$bm->id]));
			$number++;
		}
		
		$form->add(new Form_HiddenField("number",'',$number));
		
		echo($form);
		
		$block->render_blockEnd();
		
		$PH->go_submit = 'itemBookmarkEditMultipleSubmit';
		
		echo (new PageContentClose);
		echo (new PageHtmlEnd);
	}
}

/**
* submit changes to several bookmarks @ingroup pages
*/
function itemBookmarkEditMultipleSubmit()
{
	global $PH;
    global $auth;
	
    ### cancel ? ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('home',array());
        }
        exit();
    }
	
	$count = 0;
    $error = 0;
	$edit = 0;
	$bookmark_array = array();
	$is_bookmark = array();
	
	$number = get('number');
			
	for($i = 0; $i < $number; $i++)
	{
		$bm_id = get('bookmark_id_'.$i);
		$bm_item = get('bookmark_item_'.$i);
		$is_already_bookmark = get('is_already_bookmark_'.$i);
		$is_bookmark[$bm_id] =  $is_already_bookmark;
		
		if(($bm_id != 0) && ($is_already_bookmark)){
			if(!$bookmark = ItemPerson::getAll(array('id'=>$bm_id, 'person'=>$auth->cur_user->id, 'is_bookmark'=>1))) {
				$error++;
			}
			else{
				$bookmark_array[] = $bookmark[0];
			}
		}
		elseif(($bm_id != 0) && (!$is_already_bookmark)){
			if(!$bookmark = ItemPerson::getAll(array('id'=>$bm_id, 'person'=>$auth->cur_user->id, 'is_bookmark'=>0))) {
				$error++;
			}
			else{
				$bookmark_array[] = $bookmark[0];
			}
		}
		elseif($bm_id == 0){
			$date = getGMTString();
			$bookmark = new ItemPerson(array(
				'id'=>0,
				'item'=>$bm_item,
				'person'=>$auth->cur_user->id,
				'is_bookmark'=>1,
				'created'=>$date));
			$bookmark_array[] = $bookmark;
		}
	}
	
	foreach($bookmark_array as $bma){
		#$change = false;
		
		### notify on change ###
		$noc = get('notify_on_change');
		if(!is_null($noc) && $noc != -1 && $noc != $bma->notify_on_change) {
			$bma->notify_on_change = $noc;
			#$change= true;
		}
		
		### notify if unchanged ###
		$niu = get('notify_if_unchanged');
		if(!is_null($niu) && $niu != -1 && $niu != $bma->notify_if_unchanged) {
			$bma->notify_if_unchanged = $niu;
			#$change= true;
		}
	
		#if($change){
			if(($bma->id != 0) && ($is_bookmark[$bma->id])){
				$bma->update();
				$edit++;
			}
			elseif(($bma->id != 0) && (!$is_bookmark[$bma->id])){
				$bma->is_bookmark = true;
				$bma->created = getGMTString();
				$bma->update();
				$count++;
			}
			elseif($bma->id == 0){
				$bma->insert();
				$count++;
			}
		#}
	}
	
	if($count){
		new FeedbackMessage(sprintf(__("Added %s bookmark(s)."),$count));
	}
	
	if($edit){
		new FeedbackMessage(sprintf(__("Edited %s bookmark(s)."),$edit));
	}
	
	if($error){
		new FeedbackWarning(sprintf(__('%s bookmark(s) could not be added.'), $error));
	}
	### display fromPage ####
	if(!$PH->showFromPage()) {
		$PH->show('home',array());
	}
}

/**
* send immediate notification of an monitored item has been edited @ingroup pages
*/
function itemsSendNotification()
{
	global $PH;
	global $auth;
	$valid = false;
	
	if($ids = getPassedIds('task', 'tasks_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('person', 'persons_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('company', 'companies_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('proj', 'projects_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('effort', 'efforts_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('comment', 'comments_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('file', 'files_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('version', 'versions_*')){
		$valid = true;
	}
	else{
		$PH->abortWarning(__("No item(s) selected."), ERROR_NOTE);
	}
	
	if($valid){
		foreach($ids as $id){
			if($item = ItemPerson::getAll(array('person'=>$auth->cur_user->id, 'item'=>$id))){
				$item[0]->notify_on_change = true;
				$item[0]->update();
			}
			else{
				$new_view = new ItemPerson(array(
				'item'=>$id,
				'person'=>$auth->cur_user->id,
				'notify_on_change'=>1));
				
				$new_view->insert();
			}
		}
	}
	
	if(!$PH->showFromPage()){
		$PH->show('home');
	}
}

/**
* remove items from user's notification list @ingroup pages
*/
function itemsRemoveNotification()
{
	global $PH;
	global $auth;
	$valid = false;
	
	if($ids = getPassedIds('task', 'tasks_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('person', 'persons_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('company', 'companies_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('proj', 'projects_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('effort', 'efforts_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('comment', 'comments_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('file', 'files_*')){
		$valid = true;
	}
	elseif($ids = getPassedIds('version', 'versions_*')){
		$valid = true;
	}
	else{
		$PH->abortWarning(__("No item(s) selected."), ERROR_NOTE);
	}
	
	if($valid){
		foreach($ids as $id){
			if($item = ItemPerson::getAll(array('item'=>$id, 'notify_on_change'=>true))){
				$item[0]->notify_on_change = false;
				$item[0]->update();
			}
		}
	}
	
	if(!$PH->showFromPage()){
		$PH->show('home');
	}
}



/**
* renders a comparision between two versions of an item @ingroup pages
*/
function itemViewDiff()
{
    global $PH;
    global $auth;

    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');





    ### get task ####
    $item_id=get('item');

    if(!$item= DbProjectItem::getObjectById($item_id)) {
        $PH->abortWarning("invalid item-id",ERROR_FATAL);
    }
    
    if(!$project= Project::getVisibleById($item->project)) {
        $PH->abortWarning("this item has an invalid project id", ERROR_DATASTRUCTURE);
    }

    require_once(confGet('DIR_STREBER') . "db/db_itemchange.inc.php");
    $versions= ItemVersion::getFromItem($item);

    $date1= get('date1');
    $date2= get('date2');
    
    
    if(!$date1) {
        #if(count($versions) > 1) {
        #    if($auth->cur_user->last_logout < $versions[count($versions)-2]->date_to)
        #    {
        #        $date1 = $auth->cur_user->last_logout;
        #    }
        #    else {
        #        $date1 = $versions[count($versions)-2]->date_from;
        #    }
        #}
        #else {            
        foreach(array_reverse($versions) as $v) {
            if ($v->author == $auth->cur_user->id) {
                $date1= $v->date_from;
                break;
            }
        }
        #}
    }

    if(!$date2) {
        $date2 = getGMTString();
    }
    #}

    ### set up page and write header ####
    {
        $page= new Page();
    	$page->cur_tab='projects';

        
        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);

        $page->title = $item->name;
        $page->title_minor= __('changes');


        ### page functions ###
        {

            $page->add_function(new PageFunction(array(
                'target'=>'itemView',
                'params'=>array('item' => $item->id),
                'icon'=>'edit',
                'name'=>__('View item')
            )));
        }

    	### render title ###
        echo(new PageHeader);
    }


    echo (new PageContentOpen);

    ### list changes ###
    {
        if($date1 > $date2) {
            new FeedbackMessage(__("date1 should be smaller than date2. Swapped"));
            $t= $date1;
            $date1= $date2;
            $date2= $t;
        }


        if(count($versions) == 1) {
            echo __("item has not been edited history");
        }
        else {
            $old_version= NULL;
            $version_right= NULL;
            $version_left= $versions[0];

            foreach($versions as $v) {
                if($v->date_from <= $date1) {
                    $version_left= $v;
                }
                if($v->date_from >= $date2) {

                    if(isset($version_right)) {
                        if($version_right->date_from > $v->date_from) {
                            $version_right= $v;
                        }
                    }
                    else {
                        $version_right= $v;
                    }
                }
            }
            if(!isset($version_right)) {
                $version_right = $versions[count($versions)-1];
            }

            $options_left = array();
            $options_right= array();


            ### list versions left ###
            for($i=0; $i< count($versions)-1; $i++) {

                $v= $versions[$i];

                if($person = Person::getVisibleById($v->author)) {
                    $author= $person->name;
                }
                else {
                    $author= __('unknown');
                }

                if($v->version_number == $version_left->version_number) {

                    $str_link= $PH->getUrl('itemViewDiff', array('item'=>$item->id, 'date1'=> $versions[$i]->date_from, 'date2'=> $versions[$i]->date_to));
                    $name= ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; v.'.$v->version_number . ' -- '. $author. " -- ". $v->date_from ;
                    $options_left[]="<option selected=1 value='".$str_link ."'>". $name. "</option>";
                }
                else if($v->version_number > $version_left->version_number) {

                    if($v->version_number < $version_right->version_number) {
                        $str_link= $PH->getUrl('itemViewDiff', array('item'=>$item->id, 'date1'=> $versions[$i]->date_from, 'date2'=> $versions[$i]->date_to));
                        $name= '&gt; &nbsp;&nbsp; v.'.$v->version_number . ' -- '. $author. " -- ". renderDate($v->date_from) ;
                    }
                    else {
                        $str_link= $PH->getUrl('itemViewDiff', array('item'=>$item->id, 'date1'=> $versions[$i]->date_from, 'date2'=> $version_right->date_to));
                        $name= '&gt;&gt;&nbsp;&nbsp; v.'.$v->version_number . ' -- '. $author. " -- ". renderDate($v->date_from) ;
                    }
                    $options_left[]="<option  value='".$str_link ."'>". $name. "</option>";
                }
                else {
                    $str_link= $PH->getUrl('itemViewDiff', array('item'=>$item->id, 'date1'=> $versions[$i]->date_from, 'date2'=> $version_right->date_from));
                    $name= '&lt; &nbsp;&nbsp; v.'.$v->version_number . ' -- '. $author. " -- ". renderDate($v->date_from) ;
                    $options_left[]="<option  value='".$str_link ."'>". $name. "</option>";
                }
            }


            ### list versions right ###
            for($i=1; $i< count($versions); $i++) {

                $v= $versions[$i];

                if($person = Person::getVisibleById($v->author)) {
                    $author= $person->name;
                }
                else {
                    $author= __('unknown');
                }

                if($v->version_number == $version_right->version_number) {

                    $str_link= $PH->getUrl('itemViewDiff', array('item'=>$item->id, 'date1'=> $versions[$i]->date_from, 'date2'=> $versions[$i]->date_to));
                    $name= ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; v.'.$v->version_number . ' -- '. $author. " -- ". $v->date_from ;
                    $options_right[]="<option selected=1 value='".$str_link ."'>". $name. "</option>";
                }
                else if($v->version_number > $version_right->version_number) {
                    $str_link= $PH->getUrl('itemViewDiff', array('item'=>$item->id, 'date1'=> $version_left->date_from, 'date2'=> $versions[$i]->date_from));
                    $name= '&gt; &nbsp;&nbsp; v.'.$v->version_number . ' -- '. $author. ' -- ' . renderDate($v->date_from);
                    $options_right[]="<option  value='".$str_link ."'>". $name. "</option>";

                }
                else {
                    if($v->version_number > $version_left->version_number) {
                        $str_link= $PH->getUrl('itemViewDiff', array('item'=>$item->id, 'date1'=> $version_left->date_from, 'date2'=> $versions[$i]->date_from));
                        $name= '&lt; &nbsp;&nbsp; v.'.$v->version_number . ' -- ' . $author. " -- ". renderDate($v->date_from);
                    }
                    else {
                        $str_link= $PH->getUrl('itemViewDiff', array('item'=>$item->id, 'date1'=> $versions[$i]->date_from, 'date2'=> $versions[$i]->date_to));
                        $name= '&lt;&lt;&nbsp;&nbsp; v.'.$v->version_number .  ' -- ' . $author. ' -- '. renderDate($v->date_from);
                    }

                    $options_right[]="<option  value='".$str_link ."'>". $name. "</option>";
                }
            }


            ### prev ###
            if($version_left->version_number > 1) {
                $link_prev= $PH->getLink(
                    'itemViewDiff',
                    '&lt;&lt; ' . __('prev change'),
                    array(
                        'item'=>$item->id,
                        'date1'=>$versions[$version_left->version_number - 2]->date_from,
                        'date2'=>$versions[$version_left->version_number - 2]->date_to,
                   ), NULL, true
                   );
            }
            else {
                $link_prev ='';
            }

            ### next ###
            if($version_right->version_number < count($versions)) {
                $link_next= $PH->getLink(
                    'itemViewDiff',
                    __('next') .  '&gt;&gt;',
                    array(
                        'item'=>$item->id,
                        'date1'=>$versions[$version_right->version_number-1]->date_from,
                        'date2'=>$versions[$version_right->version_number-1]->date_to,
                   ), NULL, true);
            }
            else {
                $link_next ='';
            }

            ### summary ###
            $link_summary= $PH->getLink(
                'itemViewDiff',
                __('summary'),
                array(
                    'item'=>$item->id,
                    'date1'=>$auth->cur_user->last_logout,
                    'date2'=> getGMTString(),
               ), NULL, true);


            echo "<div class=diff>";

            echo "<table class=nav><tr>";
            echo "<td class=older>"
                . "<select onChange='location.href=this.options[this.selectedIndex].value'>"
                . join(array_reverse($options_left))
                . "</select>"
                . '<br><b class=doclear></b>'
                . $link_prev
                . "</td>";


            echo "<td class=newer>"
                . "<select onChange='location.href=this.options[this.selectedIndex].value'>"
                . join(array_reverse($options_right))
                . "</select>"
                . '<br><b class=doclear></b>'
                . $link_next
                . $link_summary
                . "</td>";
            echo "</table>";


            #if(!$date2 || !$date1) {
            #    echo sprintf(__("Item did not exists at %s"), renderTime($date2));
            #}
            if($old_version == $version_right) {
                echo sprintf(__('no changes between %s and %s'), renderTime($date1), renderTime($date2));
            }



            ### collect changes ###
            $old_field_values=array();
            $new_field_values=array();
            foreach($versions as $v) {
                if($v->version_number <=  $version_left->version_number) {
                    foreach($v->values as $name=>$value) {
                        $old_field_values[$name]= $value;
                    }
                }

                if($v->version_number >= $version_left->version_number
                   &&
                   $v->version_number < $version_right->version_number
                ) {
                    foreach($v->values_next as $name=>$value) {
                        $new_field_values[$name]= $value;
                    }
                }
            }

            foreach($new_field_values as $field_name=>$value) {

                echo "<h2>$field_name</h2>";

                $old_value= isset($old_field_values[$field_name])
                                ? $old_field_values[$field_name]
                                : "";
                $new_value= isset($new_field_values[$field_name])
                                ? $new_field_values[$field_name]
                                : '';

                $field_type= $item->fields[$field_name]->type;
                if($field_type == 'FieldText') {
                    echo render_changes($old_value, $new_value);
                }
                else if($field_type == 'FieldOption'){
                    if($field_name == 'status') {
                        global $g_status_names;
                        $old_value= isset($g_status_names[$old_value])
                                  ? $g_status_names[$old_value]
                                  : __('undefined');
                        $new_value= isset($g_status_names[$new_value])
                                  ? $g_status_names[$new_value]
                                  : __('undefined');
                    }
                    else if($field_name == 'label') {
                        if($project = Project::getVisibleById($item->project)) {
                            $labels=split(",",$project->labels);

                            $old_value= isset($labels[$old_value-1])
                                      ? $labels[$old_value-1]
                                      : __('undefined');

                            $new_value= isset($labels[$new_value-1])
                                      ? $labels[$new_value-1]
                                      : __('undefined');
                        }
                    }
                    echo render_changes($old_value, $new_value);
                }
                else if($field_type == 'FieldInternal') {

                    if($field_name == 'parent_item') {
                        if($task_parent_old= Task::getVisibleById($old_value)) {
                            $ar= array();
                            foreach($task_parent_old->getFolder() as $f) {
                                $ar[]=$f->name;
                            }
                            $ar[]= $task_parent_old->name;
                            $old_value= join($ar," > ");
                        }
                        if($task_parent_new= Task::getVisibleById($new_value)) {
                            $ar= array();
                            foreach($task_parent_new->getFolder() as $f) {
                                $ar[]=$f->name;
                            }
                            $ar[]= $task_parent_new->name;
                            $new_value= join($ar," > ");
                        }
                    }

                    else if($field_name == 'state') {
                            $old_value= ($old_value == -1)
                                      ? __('deleted')
                                      : __('ok');
                            $new_value= ($new_value == -1)
                                      ? __('deleted')
                                      : __('ok');
                    }
                    else if($field_name == 'pub_level') {
                        global $g_pub_level_names;
                        $old_value= isset($g_pub_level_names[$old_value])
                                  ? $g_pub_level_names[$old_value]
                                  : __('undefined');
                        $new_value= isset($g_pub_level_names[$new_value])
                                  ? $g_pub_level_names[$new_value]
                                  : __('undefined');

                    }
                    echo render_changes($old_value, $new_value);

                }
                else if($field_type == 'FieldPercentage') {
                    echo render_changes($old_value, $new_value);
                }
                else if($field_type == 'FieldInt') {

                    echo render_changes($old_value, $new_value);
                }
                else if($field_type == 'FieldString') {
                    echo render_changes($old_value, $new_value);
                }
                else if($field_type == 'FieldDate') {
                    echo render_changes(renderDate($old_value), renderDate($new_value));
                }
                else if($field_type == 'FieldDatetime') {
                    echo render_changes(renderTimestamp($old_value), renderTimestamp($new_value));
                }

            }
        }
    }
    echo "</div>";

    echo (new PageContentClose);
	echo (new PageHtmlEnd);

}
?>
