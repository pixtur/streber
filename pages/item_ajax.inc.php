<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
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
* and return formatted html code
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

    $field_name= 'description';
    if(get('field')) {
        $field_name= get('field');
    }
    if(!isset($object->fields[$field_name])) {
        return NULL;
    }
    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

    $chapter= get('chapter');
    
    ### replace complete field ###
    if(is_null($chapter)) {
        $object->$field_name = $value;
        $object->update(array($field_name));

        print wiki2purehtml($object->$field_name); 
    }
    
    ### only replace chapter ###
    else {

        require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');
        
        /**
        * split originial wiki block into chapters
        * start with headline and belonging text
        */
        $parts= getWikiChapters($object->$field_name);
        
        if(!preg_match("/\n$/",$value)) {
            $value.="\n";
        }
        $parts[$chapter]= $value;
        
        $new_wiki_text= implode('', $parts);

        $object->$field_name = $new_wiki_text;
        $object->update(array($field_name));

        print wiki2purehtml($new_wiki_text);
    }
}


?>