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
require_once(confGet('DIR_STREBER') . 'db/db_itemchange.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');

/**
* Remove items of certain type and autho
*
* This method can be used to remove spam comments or attachments
* 
* person - id of person who did the changes
* data - date to with revert changes
* delete_history  (Default off) - Reverting can't be undone! The person's modification are lost forever!
*                                 This can be useful on massive changes to avoid sending huge
*                                 notification mails.
*/
function itemsRemoveMany()
{
    global $PH;
    global $auth;
    
    
    
    ### set up page and write header ####
    {
        $PH->go_submit='itemsRemoveManyPreview';
        $page = new Page();
        $page->cur_tab = 'home';

        $page->title = __('Remove many items');
        $page->title_minor = '';
       
        echo(new PageHeader);
    }
    
    echo (new PageContentOpen);

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . "render/render_form.inc.php");

        $form=new PageForm();
        $form->button_cancel=true;
        
        
        ### author
        $people= array(0 => 'anybody');
        foreach(Person::getPersons() as $p) {
            $people[$p->id] = $p->nickname;
        }

        $form->add(new Form_Dropdown('person',
                                    __("Created by"),
                                    array_flip($people),
                                    0
        ));
        
        ### object types
        {
            $form->add(new Form_Checkbox('type_comment',
                                        __("Comments"),
                                        true
            ));

            $form->add(new Form_Checkbox('only_spam_comments',
                                        __("Only comments that look like spam"),
                                        true
            ));


            $form->add(new Form_Checkbox('type_task',
                                        __("Tasks"),
                                        false
            ));
        
            $form->add(new Form_Checkbox('type_topic',
                                        __("Topic"),
                                        false
            ));
        }
        
        ### time frame
        {
            $form->add( new Form_DateTime(
                'time_start',
                __('starting at','label for time filter'),
                getGMTString(time() - 7*24*60*60)
            ));

            $form->add( new Form_DateTime(
                'time_end',
                __('ending at','label for time filter'),
                getGMTString(time() + 60*60)
            ));
        }
        echo ($form);

    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd);

}



?>
