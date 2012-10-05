<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * Timetracking
 Some notes
 
 
 *
 * @author Thomas Mann
 */


require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_project_team.inc.php');


/**
* display efforts for current user  @ingroup pages
*
* @NOTE 
* - actually this is an excact copy for personViewEfforts
* - this is of course not a good solution, but otherwise the breadcrumbs would change
*
*/
function homeTimetracking()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
    require_once(confGet('DIR_STREBER') . 'lists/list_efforts.inc.php');

    
    ### get current project ###
    $person= $auth->cur_user;
        


    ### create from handle ###
    $PH->defineFromHandle(array('person'=>$person->id));

    ### set up page ####
    {
        $page= new Page();
        $page->cur_tab='home';
        $page->title=__("Time tracking");
        //$page->title_minor=__('Efforts','Page title add on');
        $page->type=__("Person");

        #$page->crumbs = build_person_crumbs($person);
        $page->options= build_home_options($person);

        echo(new PageHeader);
        build_history_table();

        
    }
    echo (new PageContentOpen);
    
    echo '<input type="hidden" name="person" value="'.$person->id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}

function build_history_table() {
    DEFINE("START_HOUR", 7);
    DEFINE("END_HOUR", 25);
    echo "<div id=timetable>";
    echo "<div class=timeblocks>";
    echo "<table class='timetracking'>";
    for($day=3; $day>=0;$day--) {
        echo "<tr>";
        echo "<td class=day>";
        echo renderDateHtml( time() - $day*60*60*24);
        echo "</td>";
        for($hour=7; $hour < END_HOUR; $hour++) {
            echo "<td>.</td>";
        }        
        echo "</tr>";
    }
    
    echo "<tr class=timeline>";
    echo "<td></td>";
    for($hour=7; $hour < END_HOUR; $hour++) {
        echo "<td class=hour>$hour</td>";
    }        
    echo "</tr>";
    
    echo "</tr>";
    
    echo "</table>";
    echo "<div>bla</div>";
    echo "</div>";
    echo "</div>";
}


?>
