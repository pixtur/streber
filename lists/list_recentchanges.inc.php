<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * special functions for listing recent changes like in home->Dashboard
 *
 * @includedby:     pages/*
 *
 * @author         Thomas Mann
 * @uses:           ListBlock
 * @usedby:

*/

require_once(confGet('DIR_STREBER') . 'std/class_changeline.inc.php');


function printRecentChanges($projects, $print_project_headlines= true)
{
    global $PH;
    global $auth;
    /**
    * first get all changelines for projects to filter out projects without changes
    */
    $projects_with_changes= array();    # array with projects
    $project_changes= array();          # hash with project id and changelist

    foreach($projects as $project) {
                
        /**
        * first query all unviewed changes
        */
        if($changes= ChangeLine::getChangeLines(array(
            'not_modified_by'   => $auth->cur_user->id,
            'project'           => $project->id,
            'unviewed_only'     => false,
            'limit_rowcount'    => confGet('MAX_CHANGELINES')+ 1,  #increased by 1 to get "more link"
            'limit_offset'      => 0,
            'type'              => array(ITEM_TASK, ITEM_FILE),
        ))) {
            $projects_with_changes[]= $project;
            $project_changes[$project->id]= $changes;                    
        }
    }            
    
    if(count($projects_with_changes)) {

        $block=new PageBlock(array(
            'title' =>__('Recent changes'),
            'id'    =>'recentchanges'
        ));
        $block->render_blockStart();
        
        $changelines_per_project= confGet('MAX_CHANGELINES_PER_PROJECT');
        if(count($projects_with_changes) < confGet('MAX_CHANGELINES') / confGet('MAX_CHANGELINES_PER_PROJECT')) {
            $changelines_per_project = confGet('MAX_CHANGELINES') / count($projects_with_changes)  - 1;
        }

        
        /**
        * count printed changelines to keep size of list
        */
        $printed_changelines = 0;
        foreach($projects_with_changes as $project) {
            
            $changes= $project_changes[$project->id];

            if($print_project_headlines) {
                echo '<h4>'.  $PH->getLink('projView', $project->name, array('prj'=>$project->id)) . "</h4>";
            }

            echo "<ul id='changesOnProject_$project->id'>";
            $lines= 0;
            foreach($changes as $c) {
                $lines++;
                printChangeLine($c);

                $printed_changelines++;
                if($lines >= $changelines_per_project) {
                    break;                            
                };
            }
            echo "</ul>";
            if($lines < count($changes)) {
                echo "<p class=more>"
                . "<a href='javascript:getMoreChanges($project->id, ". ($lines - 1).", " . confGet('MORE_CHANGELINES') . ");' "
                . '>'
                . __('Show more')
                . '</a>'
                ."</p>";
                
            }
                
            /**
            * limit number of projects
            */
            if($printed_changelines >= confGet('MAX_CHANGELINES')) {
                break;
            }
        }            
        $block->render_blockEnd();
    }
}


/**
* writes a changeline as html
*
* 
*/
function printChangeLine($c)
{
    global $PH;
    
    if($c->item->type == ITEM_TASK) {
        echo '<li>' . $c->item->getLink(false);
    }
    else {
        echo '<li>' . $PH->getLink('fileView', $c->item->name, array('file' => $c->item->id));        
    }
    
    
    /**
    * not viewed
    */
    if($c->item) {
        if($new= $c->item->isChangedForUser()) {
            if($new == 1) {
                echo '<span class=new> (' . __('New') . ') </span>';
            }
            else {
                echo '<span class=new>  (' . __('Updated') . ') </span>';
            }
        }
    }
    
    echo "<span class=sub>$c->txt_what";
    
    if($person= Person::getVisibleById($c->person_by)) {
        echo ' ' . __('by') . ' <span class=person>' . asHtml($person->name) ."</span>";
    }
    echo ' ' . renderTimeAgo($c->timestamp);
    
    echo "</span>";
    
    echo '</li>';    
    return;
}

?>