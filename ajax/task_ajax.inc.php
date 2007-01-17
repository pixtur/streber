<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
require_once("db/class_task.inc.php");
require_once("db/class_project.inc.php");

/**
* test function for development
*
* the output of this function could be requested with jquery like:
*
*       $('#sideboard div').load('index.php?go=taskAjax',{
*        go: 'taskAjax',
*        tsk: id
*       });
*/
function taskAjax()
{
    trigger_error('blub');
    if($task_id=intval(get('tsk'))) {
        require_once("render/render_wiki.inc.php");

        ### headline ###

        echo "<h3>". asHtml($task->name)."</h3>";

        $task=Task::getVisibleById($task_id);

        echo wiki2html($task->description);
    }
    exit();
}


/**
* get field value of an item for inplace editing
*/
function itemLoadField() 
{
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
    print $object->$field_name;
}

/**
* save field value of an item which has been edited inplace
*/
function itemSaveField() 
{
    $value= get('value');
    if(is_null($value)) {
        return;
    }
    
    if(!$item_id=get('item')) {
        print "Failure";
        return;
    }
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
    $object->$field_name = $value;
    $object->update(array($field_name));
    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');
    
    print wiki2html($value);
}


?>