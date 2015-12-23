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
require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_project_team.inc.php');

/**
* display all booked efforts for a month as a TSV list
*
* @NOTE 
* - actually this is an excact copy for personViewEfforts
* - this is of course not a good solution, but otherwise the breadcrumbs would change
*
*/
function homeMonthlyReport()
{
global $PH;
    global $g_effort_status_names;

    $time_start_of_months = time();
    

    $month= get('month', date('m'));
    $year= get('year', date('Y'));

    $efforts = Effort::getAll(array(
        'effort_time_min' => date("$year-$month-01 00:00:01"),
        'effort_time_max' => date("$year-$month-t 23:59:59")
    ));

    $projects_with_efforts = array();
    $people = array();
    
    foreach($efforts as $e) {
        $project_id = $e->project;

        if(!isset($people[$e->person])) {
            $people[$e->person] = Person::getVisibleById($e->person);
        }

        if(!isset($projects_with_efforts[$project_id])) {
            $projects_with_efforts[$project_id] = array();
        }

        if(!isset($projects_with_efforts[$project_id][$e->person] )) {
            $projects_with_efforts[$project_id][$e->person] = 0;
        }

        $projects_with_efforts[$project_id][$e->person] += $e->getRoundedDurationInMinutes();
    }

    #echo json_encode($projects_with_efforts);

    
    ### set up page and write header ####
    {
        $page = new Page(array('use_jscalendar'=>true));
        $page->cur_tab = 'projects';

        $page->options[] = new naviOption(array(
            'target_id'  =>'effortEdit',
        ));

        $page->type = __("Edit multiple efforts","Page title");
        $page->title = sprintf(__("Monthly effort report","Page title"), count($efforts));

        echo(new PageHeader);
    }
    echo (new PageContentOpen);
    
    {

        $block = new PageBlock(array('id'=>'functions','reduced_header' => true,));
        $block->render_blockStart();
        

        $sorted_people_ids = array_keys($people);
        asort($sorted_people_ids);

        echo "<textarea style='width:96%; height:300px;'>";

        ### list header with people
        echo "projects\t";
        foreach( $sorted_people_ids as $person_id) {
            $person= $people[$person_id];
            echo $person->nickname . "\t";
        
        }
        echo "\n";

        ### list projects with each person's effort
        foreach($projects_with_efforts as $project_id => $project_member_efforts) {

            $project= Project::getById( $project_id);
            echo $project->name;
            echo "\t";


            foreach($sorted_people_ids as $person_id) {
                if( isset( $project_member_efforts[ $person_id] )) {
                    $hours = $project_member_efforts[ $person_id];
                    echo number_format ( $hours , 2 , $dec_point = ',' ,'' );
                }
                else {
                    echo "";
                }
                echo "\t";
            }
            echo "\n";
        }

        echo "</textarea>";
        
        $block->render_blockEnd();
    }
    
    echo (new PageContentClose);
    echo (new PageHtmlEnd);

    exit();
}
?>
