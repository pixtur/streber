<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file 
* pages relating to editing of bookmarks
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
                $item[0]->is_bookmark = 0;
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
            
            $form->add(new Form_HiddenField('is_already_bookmark','', $is_already_bookmark ? 1 : 0));
            
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

    ### Validate form crc
    if(!validateFormCrc()) {
        $PH->abortWarning(__('Invalid checksum for hidden form elements'));
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
        $bookmark->notify_on_change = 1;
        $bookmark->notify_date = getGMTString();
    }
    else{
        $bookmark->notify_on_change = 0;
    }
    
    $notify_period = get('notify_period');
    
    if(!is_null($notify_period)){
        $bookmark->notify_if_unchanged = $notify_period;
    }
    
    if(($bm_id != 0) && ($is_already_bookmark)){
        $bookmark->update();
    }
    elseif(($bm_id != 0) && (!$is_already_bookmark)){
        $bookmark->is_bookmark = 1;
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
    
    if(!$items) {
        $PH->abortWarning(__("Please select some items"));
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
        $bm_id = intval( get('bookmark_id_'.$i) );
        $bm_item = intval( get('bookmark_item_'.$i) );
        $is_already_bookmark = intval( get('is_already_bookmark_'.$i) );
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
        $noc = intval( get('notify_on_change') );
        if(!is_null($noc) && $noc != -1 && $noc != $bma->notify_on_change) {
            $bma->notify_on_change = $noc;
            #$change= true;
        }
        
        ### notify if unchanged ###
        $niu = intval( get('notify_if_unchanged') );
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
                $bma->is_bookmark = 1;
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
?>