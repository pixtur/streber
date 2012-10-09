<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * Timetracking 
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
        $page->extra_header_html = '<script type="text/javascript" src="js/timetracking.js'  . "?v=" . confGet('STREBER_VERSION'). '"></script>';

//        $page->extra_header_html .= '<script src="http://code.jquery.com/jquery-1.8.2.js"></script>';
        $page->extra_header_html .= '<script src="js/jquery-ui-1.9.0.custom"></script>';
        $page->extra_header_html .= '<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />';
        
        $page->extra_onload_js .= "var timetracking = new TimeTracking();";
        $page->extra_onload_js .= "var timetracking_form = new TimetrackingForm();";
                
        //$page->title_minor=__('Efforts','Page title add on');
        $page->type=__("Person");

        #$page->crumbs = build_person_crumbs($person);
        $page->options= build_home_options($person);

        echo(new PageHeader);
        build_history_table();
        build_effort_edit_form();

        
    }
    echo (new PageContentOpen);
    
    echo '<input type="hidden" name="person" value="'.$person->id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}

function build_history_table() {
    echo "<div class='doclear'></div>";
    echo "<div class=timetable>";
        echo '<canvas id="myCanvas" width="100%" height="400"></canvas>';
        echo "<div class=container>Container</div>";        
        echo "<div class=currentTime></div>";
    echo "</div>";
}


function build_effort_edit_form() 
{
    
    echo "<h3>" . __("New Effort") . "</h3>";
        
    
    renderProjectDropdown();
    
    
    echo "<input id='effort_task'>";
    
    
    $effort = new Effort();
    global $g_effort_status_names;
    global $PH;
    global $auth;
    
    require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');    
    {
        $form=new PageForm();
        $form->button_cancel=true;

        ### automatically write fields ###
#   foreach($effort->fields as $field) {
#    $form->add($field->getFormElement($effort));
#   }
/*
        $form->add($effort->fields['name']->getFormElement($effort));
        
        $form->add($effort->fields['description']->getFormElement($effort));
        $form->add(new Form_Dropdown("effort_status", __('Status'), array_flip($g_effort_status_names), $effort->status));

        ### get meta-tasks / folders ###
        #$folders= $project->getFolders();
        $folders= Task::getAll(array(
            'sort_hierarchical'=>true,
            'parent_task'=> 0,
            'show_folders'=>true,
            'folders_only'=>false,
            'status_min'=> STATUS_UPCOMING,
            'status_max'=> STATUS_CLOSED,
            'project'=> $project->id,

        ));
        if($folders) {
            $folder_list= array("undefined"=>"0");

            if($effort->task) {
                if($task= Task::getVisibleById($effort->task)) {
                    ### add, if normal task (folders will added below) ###
                    if(! $task->category == TCATEGORY_FOLDER) {
                        $folder_list[$task->name]= $task->id;
                    }
                }
            }

            foreach($folders as $f) {
                $str= '';
                foreach($f->getFolder() as $pf) {
                    $str.=$pf->getShort(). " > ";
                }
                $str.=$f->name;

                $folder_list[$str]= $f->id;

            }
            $form->add(new Form_Dropdown('effort_task',  __("For task"),$folder_list, $effort->task));

        }

        ### public-level ###
        if(($pub_levels= $effort->getValidUserSetPublicLevels())
            && count($pub_levels)>1) {
            $form->add(new Form_Dropdown('effort_pub_level',  __("Publish to"),$pub_levels,$effort->pub_level));
        }


        echo ($form);
        */
        //$block->render_blockEnd();

        $PH->go_submit='effortEditSubmit';
        echo "<input type=hidden name='effort_id' value='0'>";
        echo "<input type=hidden name='effort_project' value=''>";
        echo "<input type=hidden name='effort_person' value='" . $auth->cur_user->id . "'>";
        echo "<input type=submit>";
    }
}


function renderProjectDropdown() 
{
    $prj_num = '-1';

    $prj_names = array();
    $prj_names['-1'] = __('- no -');

    ## get all projects ##
    if($projects = Project::getAll()){
        foreach($projects as $p){
            $prj_names[$p->id] = $p->name;
        }
        echo "<button onclick='alert(\"here\");return false;'>bls</button>";
        echo "<select size='1' name='project' id='project'>";
        foreach($prj_names as $key => $value) {
//            $str_selected= ($this->value==$value)
//                 ? "selected='selected'"
//                :"";
            $str_selected="";

            echo '<option ' . $str_selected .' value="' . asHtml($key) . '" >' . asHtml($value) . '</option>';
        }
        echo "</select>";        
    } 
}


/**
* return efforts for current user  @ingroup pages
*
* @NOTE 
* - actually this is an excact copy for personViewEfforts
* - this is of course not a good solution, but otherwise the breadcrumbs would change
*
*/
function ajaxUserEfforts()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
    #require_once(confGet('DIR_STREBER') . 'lists/list_efforts.inc.php');
    
    $result = array();
    foreach( $auth->cur_user->getEfforts() as $e ) {
        $p= Project::getById($e->project);
        
        $result[$e->id] = array('start'=>strToClientTime($e->time_start), 
                                'duration'=> (strToClientTime($e->time_end) - strToClientTime($e->time_start)) , 
                                'id'=> $e->id,
                                'title'=> $p->name);
    }
    echo json_encode($result);
}


/**
* return tasks for selected project  @ingroup pages
*
* @NOTE 
* - actually this is an excact copy for personViewEfforts
* - this is of course not a good solution, but otherwise the breadcrumbs would change
*
*/
function ajaxUserTasks()
{
    global $PH;
    global $auth;
    
    $result = array();
    foreach( $tasks = Task::getAll() as $t) {        
        $result[] = array('label'=> $t->name, 'value'=>$t->id);    
    }
    echo json_encode($result);
}



?>
