<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_taskfolders.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_comments.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');

/**\file
* Renders item and all children into a single html file
*/

/**
* view task a documentation page @ingroup pages
*/
function TopicExportAsHtml()
{
    global $PH;
    global $auth;

    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');
    require_once(confGet('DIR_STREBER') . 'db/db_itemperson.inc.php');

    ### get task ####
    $tsk=get('tsk');


    if(!$task=Task::getVisibleById($tsk)) {
        $PH->abortWarning("invalid task-id",ERROR_FATAL);
    }

    if(!$project= Project::getVisibleById($task->project)) {
        $PH->abortWarning("this task has an invalid project id", ERROR_DATASTRUCTURE);
    }

    global $g_wiki_task;
    $g_wiki_task= $task;

    $complete_buffer = "<html><head>";
    $complete_buffer .= '<link rel="stylesheet" type="text/css" href="themes/clean/documentation.css" media="all">';
    $complete_buffer .= "</head>";
    $complete_buffer .= "<body>";
    

    $subtasks= $task->getSubtasksRecursive();
    array_unshift($subtasks, $task);

    $url= confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');   # url part of the link to the task

    foreach($subtasks as $t) {
        $complete_buffer .= ("<h1>" . $t->name . "</h1>");
        $wiki_as_html = wikifieldAsHtml($t, 'description');
        $complete_buffer .= $wiki_as_html;
    }
    $complete_buffer.= "</body></html>";

    echo extractToc2($complete_buffer);
    //echo $complete_buffer;
}


function extractToc2($code)
{
    $doc = new DOMDocument();
    $doc->loadHTML($code);

    // create document fragment
    $frag = $doc->createDocumentFragment();

    // create initial list
    $xpath = new DOMXPath($doc);

    $url= confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');   # url part of the link to the task
    foreach($doc->getElementsByTagName('a') as $linkElement ) {
        $orgHref= $linkElement->getAttribute("href");
        $parameterString = preg_replace('/(.*index\.php)(.*)/', "$url/index.php$2", $orgHref);
    }

    $last_h_level = 1;
    $frag->appendChild($doc->createElement('ol'));
    $head = &$frag->firstChild;

    # get all H1, H2, …, H6 elements
    foreach ($xpath->query('//*[self::h1 or self::h2 or self::h3 or self::h4 or self::h5 or self::h6]') as $h_tag) {
        
        list($current_h_level) = sscanf($h_tag->tagName, 'h%u');
        
        if ($current_h_level  < $last_h_level) {
            # move upwards
            for ($i=$current_h_level ; $i<$last_h_level; $i++) {
                if($head->tagName == "li")
                    $head = &$head->parentNode;
                if($head->tagName == "ol")
                    $head = &$head->parentNode;
            }
        } 
        else if ($current_h_level  > $last_h_level && $head->lastChild) {
            # move downwards and create new lists
            for ($i=$last_h_level; $i<$current_h_level ; $i++) {
                if(!$head->hasChildren) {
                    $head->appendChild($doc->createElement('ol'));    
                    $head = &$head->lastChild;
                }
                else {
                    $head->lastChild->appendChild($doc->createElement('ol'));
                    $head = &$head->lastChild->lastChild;
                }
            }
        }
        $last_h_level = $current_h_level ;

        # add list item
        $li = $doc->createElement('li');
        $head->appendChild($li);

        $link_node = $doc->createElement('a',  $h_tag->firstChild->textContent);
        $head->lastChild->appendChild($link_node);

        # build ID
        $levels = array();
        $tmp = &$head;

        # walk subtree up to fragment root node of this subtree
        while (!is_null($tmp) && $tmp != $frag) {
            $levels[] = $tmp->childNodes->length;
            $tmp = &$tmp->parentNode->parentNode;
        }

        $id = 'sect'.implode('.', array_reverse($levels));
        # set destination
        $link_node->setAttribute('href', '#'.$id);

        # add anchor to headline
        $anchor = $doc->createElement('a');
        $anchor->setAttribute('name', $id);
        $anchor->setAttribute('id', $id);

        # Fix edit links
        if($current_h_level  > 1) {
            $h_tag->lastChild->nodeValue= " ⇗";
            $h_tag->insertBefore($a, $h_tag->firstChild);            
        }
    }

    # append fragment to document
    $bodyNode = $doc->getElementsByTagName('body')->item(0);
    $bodyNode->insertBefore($frag, $bodyNode->firstChild);
    return   $doc->saveHTML();
}




?>