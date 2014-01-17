<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * Pages under Home
 *
 * @author Thomas Mann
 */


require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');

require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');

/**
* export selected efforts as a CSV ready for copy and paste into a spread-sheet  @ingroup pages
**
*/
function effortShowAsCSV()
{
    global $PH;
    global $g_effort_status_names;

    $effort_ids = getPassedIds('effort','efforts_*');

    if(!$effort_ids) {
        $PH->abortWarning(__("Select some efforts(s) to show"));
        exit();
    }
    
    $efforts = array();
    $different_fields=array();
    
    $edit_fields = array(
        'status',
        'pub_level',
        'task'
    );
    
    foreach($effort_ids as $id){
        if($effort = Effort::getEditableById($id)) {
        
            $efforts[] = $effort;
            
            ### check project for first task
            if(count($efforts) == 1) {

                ### make sure all are of same project ###
                if(!$project = Project::getVisibleById($effort->project)) {
                    $PH->abortWarning('could not get project');
                }
            }
            else {
                if($effort->project != $efforts[0]->project) {
                    $PH->abortWarning(__("For editing all efforts must be of same project."));
                }
                
                foreach($edit_fields as $field_name) {
                    if($effort->$field_name != $efforts[0]->$field_name) {
                        $different_fields[$field_name] = true;
                    }
                }
            }
        }
    }
    
    ### set up page and write header ####
    {
        $page = new Page(array('use_jscalendar'=>true));
        $page->cur_tab = 'projects';

        $page->options[] = new naviOption(array(
            'target_id'  =>'effortEdit',
        ));

        $page->type = __("Edit multiple efforts","Page title");
        $page->title = sprintf(__("%s efforts for copy and pasting into a spread-sheet","Page title"), count($efforts));

        echo(new PageHeader);
    }
    echo (new PageContentOpen);
    
    {

        $block = new PageBlock(array('id'=>'functions','reduced_header' => true,));
        $block->render_blockStart();
        
        $format="[Date][Weekday][Task][Comment][Duration]";
        
        preg_match_all("/\[(.*?)\]/", $format, $matches);
        
        $overallDuration=0;
        
        echo "<textarea style='width:96%; height:300px;'>";        
            echo join("\t",$matches[1])."\n";
            foreach($efforts as $e) {
                preg_match_all("/\[(.*?)\]/", $format, $matches);
                $separator= "";
                foreach($matches[1] as $matchedFormat) {
                    echo $separator;
                    switch( $matchedFormat) {
                        case "Date":        
                            echo gmstrftime("%Y-%m-%d", strToGMTime($e->time_start)); 
                            break;
                        case "Weekday":
                            echo gmstrftime("%a", strToGMTime($e->time_start)); 
                            break;
                            
                        case "Task":        
                            if( $t= Task::getVisibleById($e->task)) {
                                echo $t->name;
                            }
                            break;
                            
                        case "Comment":     
                            echo $e->name;
                            break;
                            
                        case "Duration":    
                            $durationInMinutes=round( ( (strToGMTime($e->time_end) - strToGMTime($e->time_start))/60),0);
                            $roundUpTo15 =  ceil($durationInMinutes / 15)*15/60;
                            $overallDuration += $roundUpTo15;
                            echo number_format ( $roundUpTo15 , 2 , $dec_point = ',' ,'' );
                            break;
                    }
                    $separator="\t";                    
                }
                echo "\n";                
            }        
        
        echo "</textarea>";
        echo "<br>";
        echo __("Overall Duration:") . $overallDuration . "h";
        
        
        $block->render_blockEnd();
    }
    
    echo (new PageContentClose);
    echo (new PageHtmlEnd);

    exit();

}

?>
