<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
require_once("db/class_task.inc.php");
require_once("db/class_project.inc.php");

/**
* contains functions for querying and editing items with ajax
*
* read more at: http://www.streber-pm.org/3695
*/


/**
* get field value of an item for inplace editing
*/
function itemLoadField()
{
    header("Content-type: text/html; charset=utf-8");
    if(!$item_id=get('item')) {
        return NULL;
    }
    if(!$item= DbProjectItem::getVisibleById($item_id)) {
        return NULL;
    }
    if(!$object= DbProjectItem::getObjectById($item_id)) {
        return NULL;
    }

    $field_name= 'description';
    if(get('field')) {
        $field_name= get('field');
    }

    
    if(!isset($object->fields[$field_name])) {
        return NULL;
    }
    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');
    
    $chapter= get('chapter');
    if(is_null($chapter)) {
        print $object->$field_name;        
    }
    else {        
        print getOneWikiChapter($object->$field_name, $chapter);
    }
}

/**
* save field value of an item which has been edited inplace
* and return formatted html code.
* 
* If only a chapter has been edited,  number defined in "chapter"
*/
function itemSaveField()
{
    header("Content-type: text/html; charset=utf-8");
    $value= get('value');
    if(is_null($value)) {
        return;
    }

    if(!$item_id=get('item')) {
        print "Failure";
        return;
    }
    global $g_wiki_project;

    if(!$item= DbProjectItem::getEditableById($item_id)) {
        print "Failure";
        return;
    }
    if(!$object= DbProjectItem::getObjectById($item_id)) {
        print "Failure";
        return;
    }
    
    if($item->type ==  ITEM_PROJECT) {
        if(!$project= Project::getVisibleById($item->id)) {
            print "Failure getting project";
            return;
        }
    }
    else if(!$project= Project::getVisibleById($item->project)) {
        print "Failure getting project";
        return;
    }
    $g_wiki_project= $project;

    $field_name= 'description';
    if(get('field')) {
        $field_name= get('field');
    }
    if(!isset($object->fields[$field_name])) {
        return NULL;
    }
    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

    $chapter= get('chapter');
    
    ### only replace chapter ###
    if(! is_null($chapter)) {

        require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');
        
        /**
        * split originial wiki block into chapters
        * start with headline and belonging text
        */
        
        $org= $object->$field_name;
        $org= str_replace("\\", "\\\\", $org);

        $parts= getWikiChapters($org);
                
        ### replace last line return (added by textarea) ###
        if(!preg_match("/\n$/",$value)) {
            $value.="\n";
        }
        $value= str_replace("\\'", "'", $value);
        $value= str_replace('\\"', "\"", $value);
        
        $parts[$chapter]= $value;

        $new_wiki_text= implode('', $parts);
        
        $object->$field_name = $new_wiki_text;
        $object->update(array($field_name));

        #$new_wiki_text =stripslashes($new_wiki_text);

        $result= wiki2purehtml($new_wiki_text);
        print $result;
    }
    ### replace complete field ###
    else {

        $object->$field_name = $value;
        $object->update(array($field_name));

        print wiki2purehtml($object->$field_name); 
    }    
}


/**
* get recent changes for ajax request from home @ingroup pages
*
* @Params
* - prj
* - start
* - count
*
* @NOTE
* This page function was formerly a part of home.inc.php but since it will
* be used in other places as well, item_ajax might be a better place for it.
*/
function AjaxMoreChanges()
{
    require_once(confGet('DIR_STREBER') . 'std/class_changeline.inc.php');
    require_once(confGet('DIR_STREBER') . 'lists/list_recentchanges.inc.php');

    global $auth;
    header("Content-type: text/html; charset=utf-8");

    if(!$project= Project::getVisibleById(get('prj'))) {
        return;
    }
    $start= is_null(get('start'))
          ? 0
          : intval(get('start'));

    $count= is_null(get('count'))
          ? 20
          : intval(get('count'));
        
    /**
    * first query all unviewed changes
    */
    if($changes= ChangeLine::getChangeLines(array(
        'not_modified_by'   => $auth->cur_user->id,
        'project'           => $project->id,
        'unviewed_only'     => false,
        'limit_rowcount'    => $count,
        'limit_offset'      => $start,
        'type'              => array(ITEM_TASK, ITEM_FILE),
    ))) {
        $lines= 0;
        foreach($changes as $c) {
            printChangeLine($c);
        }
    }
}


?>