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
require_once(confGet('DIR_STREBER') . 'render/render_misc.inc.php');


/**
* Delete a person
*/
function personDelete()
{
    global $PH;

    ### get person ####
    $ids= getPassedIds('person','persons_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some persons to delete"));
        return;
    }

    $counter=0;
    $errors=0;
    foreach($ids as $id) {
        if(!$person= Person::getEditableById($id)) {
            $PH->abortWarning("Invalid person-id!");
        }

        ### persons in project can't be deleted ###
        if($pps = $person->getProjectPersons(array(
            'alive_only' => false,
            'visible_only' => false 
        ))) {
            new FeedbackWarning(sprintf(__('<b>%s</b> has been assigned to projects and can not be deleted. However, we deativated his right to login and removed him from all projects.'), $person->getLink()));
            
            ### delete from projects          
            foreach($pps as $pp) {
                if(!$pp->delete()) {
                    new FeedbackWarning("Failed to delete project assignment.");
                }              
            }
            
            ### disable account
            $person->can_login= 0;
            $person->update();
        }
        else {
            if($person->delete()) {
                $counter++;
            }
            else {
                $errors++;
            }
        }
    }
    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to delete %s persons"), $errors));
    }
    else {
        new FeedbackMessage(sprintf(__("Moved %s persons to trash"),$counter));
    }

    ### display personList ####
    $PH->show('personList');

}

?>