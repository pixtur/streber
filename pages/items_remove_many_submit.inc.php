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


/**
* Remove items of certain type and autho
*/
function itemsRemoveManySubmit()
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
    $count_removed_items= 0;
    $item_ids= get('item_*');
    
    foreach($item_ids as $id) {
        if($item= DbProjectItem::getById($id)) {
            if($item->type == ITEM_COMMENT) {
                if($comment= Comment::getById($id)) {
                    revertDateOfCommentParent($comment);
                    $comment->deleteFromDb();
                    $count_removed_items++;
                }
            }
        }
    }

    new FeedbackMessage(sprintf(__("Removed %s items"), $count_removed_items));

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}


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
        if($last_version->date_from < $comment->created) {
            $item->modified= $last_version->date_from;
            $item->modified_by= $last_version->author;
            $item->update(array('modified','modified_by'), false, false);
        }
    }    
}

?>
