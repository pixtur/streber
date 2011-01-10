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
*
*/
function itemsRemoveManyPreview()
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
    
    ### set up page and write header ####
    {
        $PH->go_submit='itemsRemoveManySubmit';
        $page = new Page();
        $page->cur_tab = 'home';

        $page->title = __('Following items will be removed');
        $page->title_minor = '';
       
        echo(new PageHeader);
    }
    
    echo (new PageContentOpen);

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . "render/render_form.inc.php");

        $form=new PageForm();
        $form->button_cancel=true;
                
        renderPreviewList();

        echo ($form);

    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd);

}

function renderPreviewList() 
{

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
    
    $items= DbProjectItem::getAll($options);
    
    echo "<ol>";
    foreach($items as $item) {
        
        if($item->type == ITEM_COMMENT) {
            $comment= Comment::getById($item->id);
            
            if(get('only_spam_comments') && !isSpam($comment->name . " " . $comment->description) ) {
                continue;
            }
        }
        renderRemovalPreviewItem($comment);        
    }
    echo "</ol>";
    
}


function renderRemovalPreviewItem($comment)
{
    $name = asHtml($comment->name);
    if(!$name) { $name = __("Untitled"); }
    echo "<li>";
    echo "<input checked type=checkbox value='{$comment->id}' name='item_{$comment->id}'>";
    echo "<label for='item_{$comment->id}'>";
    echo $comment->getLink(); 

    if( $creator= Person::getVisibleById($comment->created_by) ) {
        echo sprintf( __("by %s", "as in created by"), $creator->getLink());        
    }
    echo "<br>";
    echo " <small>" . asHtml($comment->description) . "</small>";
    echo "</label>";
    echo "</li>";
}

?>
