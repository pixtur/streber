<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file
 * remove items of certain types and own
 *
 * @author Thomas Mann
 *
 */

require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_comment.inc.php');
require_once(confGet('DIR_STREBER') . 'db/db_itemchange.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');

/**
* Remove items of certain type and autho
*/
function itemsRemoveManySubmit()
{
    global $PH;
    global $auth;
    
    $ids = array();
    $count = 0;
    $error = 0;
    $changes = false;
    
    ### cancel ? ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('home',array());
        }
        exit();
    }

    $options = array(
        'date_min'=> getDateTimeFieldValue('time_start'),
        'date_max'=> getDateTimeFieldValue('time_end')
    );
    
    ### author
    if (intval( get('person')) ) {
        $options['modified_by']= get('person');
    }
    
    ### Object types
    $types= array();
    if(get('type_task') || get('type_topic')) {
        $types[]= ITEM_TASK;
    }
    if(get('type_comment')) {
        $types[]= ITEM_COMMENT;
    }
    $options['type']= $types;
    

    debugMessage($options);
    $items= DbProjectItem::getAll($options);
    
    echo "<ol>";
    foreach($items as $item) {
        echo "<li>{$item->id} Type:{$item->type}";
        
        if($item->type == ITEM_COMMENT) {
            $comment= Comment::getById($item->id);
            
            if(get('only_spam_comments') && !isSpam($comment->name . " " . $comment->description) ) {
                continue;
            }
            
            #if(get('only_comments_with_links')) {
            #    $matches="";
            #    if(!preg_match("/https?:\/\//i",$comment->description, $matches)) {
            #        continue;
            #    }
            #}
            revertDateOfCommentParent($comment);
            $comment->deleteFromDb();
        }
    }
    echo "</ol>";
    

    #if($count){
    #    new FeedbackMessage(sprintf(__("Edited %s effort(s)."),$count));
    #}
    #
    #if($error){
    #    new FeedbackWarning(sprintf(__('Error while editing %s effort(s).'), $error));
    #}
    
    ### return to from-page? ###
    #if(!$PH->showFromPage()) {
    #    $PH->show('home');
    #}
}

/**
*
*/
function revertDateOfCommentParent($comment) 
{
    if($parent_task= Task::getById($comment->task)) {
        revertDateOfCommentParentItem($parent_task, $comment);
    }
}


function revertDateOfCommentParentItem($item, $comment) 
{
    if($versions= ItemVersion::getFromItem($item)) {
        $last_version = end($versions);
        echo "last parent version= {$last_version->version_number}   {$last_version->date_from} <br>";
        echo "comment: {$comment->created}";
        if($last_version->date_from < $comment->created) {
            $item->modified= $last_version->date_from;
            $item->modified_by= $last_version->author;
            $item->update(array('modified','modified_by'), false, false);
        }
    }    
}

?>
