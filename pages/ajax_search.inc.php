<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
require_once(confGet('DIR_STREBER') . './db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . './db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . './pages/search.inc.php');

/**
* contains functions for querying and editing items with ajax
*
* read more at: http://www.streber-pm.org/3695
*/

function ajaxSearch()
{
    $q= asCleanString(getOnePassedId("q"));
    if ($q == "") $q = NULL;

    $sanitized_query = asSearchQuery( $q );

    if($results= SearchResult::getForQuery($sanitized_query))
    {
        usort($results,  array("SearchResult", "cmp"));
        $results= array_reverse($results);
    }
    else {
        return "{}";
    }

    $resultList = array();
    $count = 0;
    foreach($results as $r) {
        $type_name = "foo";

        $resultList[] = array('name'=> $r->name ." – "  . $type_name , 'id'=>$r->item->id);
        if(++$count > 15) {
            $resultList[] = array( 'name' => __("Show all results"), 'id' => -1);            
            break;
        }
    }
    echo json_encode($resultList);
}

?>