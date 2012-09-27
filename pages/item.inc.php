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
    elseif($ids = getPassedIds('person', 'people_*')){
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
    elseif($ids = getPassedIds('person', 'people_*')){
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
                            $labels=explode(",",$project->labels);

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
