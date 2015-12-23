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
    if ($q == "") 
        return "[]";

    $sanitized_query = asSearchQuery( $q );

    if($results= SearchResult::getForQuery($sanitized_query))
    {
        usort($results,  array("SearchResult", "cmp"));
        $results= array_reverse($results);
    }
    else {
        return "[]";
    }

    $resultList = array();
    $count = 0;
    foreach($results as $r) {
        $annotation = "";
        $project_id = $r->item->project;
        $item_type_name;

        $item_type = DbItem::getItemType($r->item->id);

        if( $item_type == ITEM_TASK) {
            $t = Task::getVisibleById($r->item->id);
            $item_type_name = $t->getLabel();
        }
        else {
            global $g_item_type_names;        
            $item_type_name = $g_item_type_names[$item_type] ;
            $annotation = $item_type_name;
        }

        if( $project_id) {
            if($project = Project::getVisibleById($project_id)) {
                $annotation = $item_type_name . " in " . $project->name;
            }
            else {
                $annotation = __('unknown project');
            }
        }

        $resultList[] = array('name'=> $r->name ." – "  . $annotation , 'id'=>$r->item->id);
        if(++$count > 15) {
            $resultList[] = array( 'name' => __("Show all results"), 'id' => -1);            
            break;
        }
    }
    echo json_encode($resultList);
}

?>