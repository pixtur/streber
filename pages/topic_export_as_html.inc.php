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
    $complete_buffer .= '<link rel="stylesheet" type="text/css" href="themes/clean/documentation.css" media="screen">';
    $complete_buffer .= "</head>";
    $complete_buffer .= "<body>";
    
    $subtasks = $subtasks= $task->getSubtasksRecursive();

    $url= confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');   # url part of the link to the task

    foreach($subtasks as $t) {
        $complete_buffer .= ("<h1>" . $t->name . "</h1>");
        
        $wiki_as_html = wikifieldAsHtml($t, 'description');
        $with_local_links = preg_replace("/href='/", "href='" . $t->getUrl() , $wiki_as_html);

        $complete_buffer .= $with_local_links;
    }
    $complete_buffer.= "</body></html>";

    echo extractToc2($complete_buffer);
}


function extractToc2($code)
{
    $doc = new DOMDocument();
    $doc->loadHTML($code);

    // create document fragment
    $frag = $doc->createDocumentFragment();

    // create initial list
    $frag->appendChild($doc->createElement('ol'));
    $head = &$frag->firstChild;
    $xpath = new DOMXPath($doc);
    $last = 1;

    $url= confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');   # url part of the link to the task
    foreach($doc->getElementsByTagName('a') as $linkElement ) {
        $orgHref= $linkElement->getAttribute("href");
        $parameterString = preg_replace('/(.*index\.php)(.*)/', "$url/index.php$2", $orgHref);

        //$newHref = "" . $parameterString;
    }


    # get all H1, H2, …, H6 elements
    foreach ($xpath->query('//*[self::h1 or self::h2 or self::h3 or self::h4 or self::h5 or self::h6]') as $headline) {
        # get level of current headline
        sscanf($headline->tagName, 'h%u', $curr);

        # move head reference if necessary
        if ($curr < $last) {
            # move upwards
            for ($i=$curr; $i<$last; $i++) {
                $head = &$head->parentNode->parentNode;
            }
        } else if ($curr > $last && $head->lastChild) {
            # move downwards and create new lists
            for ($i=$last; $i<$curr; $i++) {
                if($head->lastChild) {
                    $head->lastChild->appendChild($doc->createElement('ol'));
                    $head = &$head->lastChild->lastChild;

                }
            }
        }
        $last = $curr;

        # add list item
        $li = $doc->createElement('li');
        $head->appendChild($li);
        //$a = $doc->createElement('a',  $headline->textContent);
        $a = $doc->createElement('a',  $headline->firstChild->textContent);
        $head->lastChild->appendChild($a);

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
        $a->setAttribute('href', '#'.$id);
        # add anchor to headline
        $a = $doc->createElement('a');
        $a->setAttribute('name', $id);
        $a->setAttribute('id', $id);

        # Fix edit links
        if($curr > 1) {
            $headline->lastChild->nodeValue= " ⇗";
            $headline->insertBefore($a, $headline->firstChild);            
        }

    }

    # append fragment to document
    $bodyNode = $doc->getElementsByTagName('body')->item(0);
    $bodyNode->insertBefore($frag, $bodyNode->firstChild);
    return   $doc->saveHTML();
}




?>