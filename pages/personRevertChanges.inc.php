<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file
 * pages relating to persons
 *
 * @author Thomas Mann
 *
 */

require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . 'db/db_itemchange.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');

/**
* revert changes of a person
*
* Notes:
* - This function is only available of people with RIGHT_PROJECT_EDIT.
* - This will only effect changes to fields.
* - Following changes will not be reverted:
*   - Creation of new items (Tasks, Topis, Efforts, Projects, etc.)
*   - Task-assignments
*   - Uploading of files
* 
* person - id of person who did the changes
* data - date to with revert changes
* delete_history  (Default off) - Reverting can't be undone! The person's modification are lost forever!
*                                 This can be useful on massive changes to avoid sending huge
*                                 notification mails.
*/
function personRevertChanges()
{
    global $PH;
    global $auth;
    
    ### check rights ###
    if(!$auth->cur_user->user_rights & RIGHT_PROJECT_EDIT) {
        $PH->abortWarning("You require the right to edit projects.");
    }
    
    ### get person ###
    $person_id = getOnePassedId('person','persons_*');
    
    if(!$person = Person::getVisibleById($person_id)) {
        $PH->abortWarning( sprintf(__("invalid Person #%s"), $person_id) );
        return;
    }

    ### set up page ####
    {
        $page= new Page();

        $page->tabs['admin']=  array('target'=>"index.php?go=systemInfo",     'title'=>__('Admin','top navigation tab'), 'bg'=>"misc");
    	$page->cur_tab='admin';
    	$page->crumbs[]=new NaviCrumb(array(
    	    'target_id'=>'systemInfo'
    	));

        $page->title=__("Reverting user changes");
        $page->type=__("Admin");
        #$page->title_minor=get('go');
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    $block=new PageBlock(array('title'=>__('Overview'),'id'=>'overview'));
    $block->render_blockStart();

    echo "<div class=text>";
    echo "<ul>";
    ### get changes of person ###
    $count_reverted_fields = 0;
    $changes = ItemChange::getItemChanges(array('person' => $person_id, 'order_by' => 'id DESC'));
    foreach( $changes as $c) {
        if(!$project_item = DbProjectItem::getObjectById($c->item)) {
            #print "unable to get item %s" % $c->item;
        }
        else {
            ### Only revert changes, if item has not be editted by other person
            if( $project_item->modified_by == $person_id) {
                $field_name = $c->field;
                echo "<li>"
                    . "<strong>" . asHtml($project_item->name) . "." . asHtml($field_name) . "</strong>"
                    . " '" . asHtml($project_item->$field_name) . "' = '" . asHtml($c->value_old) . "'"
                    . "</li>";
                $count_reverted_fields++;

                if($field_name == 'state') {
                    if($project_item->state == -1 && $c->value_old == 1) {
                        $project_item->deleted_by = "0";
                        $project_item->deleted = "0000-00-00 00-00-00";
                    }
                }
                $project_item->$field_name = $c->value_old;
                $project_item->update(array($field_name, 'deleted_by', 'deleted'), false, false);
            }
            else {
                echo "<li>"
                    . sprintf(__("Skipped recently editted item #%s: <b>%s<b>"), $project_item->id, asHtml($project_item->name))
                    . "</li>";
            }
            $c->deleteFull();
        }
    }
    echo "</ul>";
    echo "<p>"
        . sprintf( __("Reverted all changes (%s) of user %s") , $count_reverted_fields, asHtml( $person->nickname))
        . "</p>";
    echo "<p>". __("newly created items by this user remain unaffected.") . "</p>";
    echo "</div>";

    $block->render_blockEnd();

    ### close page
    echo (new PageContentClose);
	echo (new PageHtmlEnd);
}

?>
