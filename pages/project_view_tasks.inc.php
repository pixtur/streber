<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file
 * pages relating to listing and modifying projects
 *
 * @author Thomas Mann
 *
 */

require_once(confGet('DIR_STREBER') . "db/class_task.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_project.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_projectperson.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_person.inc.php");
require_once(confGet('DIR_STREBER') . "db/db_itemperson.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_taskfolders.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_comments.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_tasks.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_project_team.inc.php");


/**
* list tasks of a project @ingroup pages
*/
function projViewTasks()
{
    global $PH;
    global $auth;

    ### get current project ###
    $id=getOnePassedId('prj','projects_*');
    if(!$project=Project::getVisibleById($id)) {
        $PH->abortWarning("invalid project-id");
        return;
    }

    ### get upcoming or selected milestone ###
    /*
    pixtur: 2008-09-60
    WARNING: Selecting a milestone directly to limit the viewed tasks
    does not work because editing a task with a milestone will compromize
    the following task list. I have no idea, why this code is in here,
    or weather it is required at all.
    */
    $for_milestone= intval(get("for_milestone"));
    $milestone= NULL;
    if($for_milestone) {
        $milestone= Task::getVisibleById($for_milestone);
    }
    #if($milestone= $project->getNextMilestone()) {
    #    $for_milestone= $milestone->id;
    #}
    

    $presets= array(
        ### all ###
        'all_tasks' => array(
            'name'=> __('all'),
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => STATUS_NEW,
                    'max'       => STATUS_CLOSED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'tree',
                )
            )
        ),

        ### open tasks ###
        'open_tasks' => array(
            'name'=> __('open'),
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'values'    => array(STATUS_NEW, STATUS_OPEN,STATUS_BLOCKED, STATUS_COMPLETED),
                    'min'       => STATUS_NEW,
                    'max'       => STATUS_COMPLETED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            )
        ),
        ### my open tasks ###
        'my_open_tasks' => array(
            'name'=> __('my open'),
            'filter_empty_folders'=>true,
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'values'    => array( STATUS_NEW, STATUS_OPEN,STATUS_BLOCKED),
                    'min'       => STATUS_NEW,
                    'max'       => STATUS_BLOCKED,
                ),
                'assigned_to'   => array(
                    'id'        => 'assigned_to',
                    'visible'   => true,
                    'active'    => true,
                    'value'    =>  $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            ),
            'new_task_options'=> array(
                'task_assign_to_0'=> $auth->cur_user->id,
            ),

        ),



        ### next milestone ###
        'next_milestone' => array(
            'name'=> __('for milestone'),
            'filter_empty_folders'=>true,
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => false,
                    'active'    => true,
                    'values'    => array( STATUS_NEW, STATUS_OPEN,STATUS_BLOCKED, STATUS_COMPLETED),
                    'min'       => STATUS_NEW,
                    'max'       => STATUS_COMPLETED,
                ),
                'for_milestone'   => array(
                    'id'        => 'for_milestone',
                    'visible'   => true,
                    'active'    => true,
                    'value'     => $for_milestone,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            ),
            'new_task_options'=> array(
                'for_milestone'=> $for_milestone,
            ),
        ),

        ### need Feedback ###
        'needs_feedback' => array(
            'name'=> __('modified'),
            'filter_empty_folders'=>true,
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'values'    => array( STATUS_COMPLETED),
                    'min'       => STATUS_NEW,
                    'max'       => STATUS_COMPLETED,
                ),
                'not_modified_by'=> $auth->cur_user->id,
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            )
        ),


        ### to be approved ###
        'approve_tasks' => array(
            'name'=> __('needs approval'),
            'filter_empty_folders'=>true,
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'values'    => array( STATUS_COMPLETED),
                    'min'       => STATUS_COMPLETED,
                    'max'       => STATUS_COMPLETED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            )
        ),

        ### without milestone ###
        'without_milestone' => array(
            'name'=> __('without milestone'),
            'filter_empty_folders'=>true,
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'values'    => array( STATUS_COMPLETED),
                    'min'       => STATUS_NEW,
                    'max'       => STATUS_COMPLETED,
                ),
                'for_milestone'   => array(
                    'id'        => 'for_milestone',
                    'visible'   => true,
                    'active'    => true,
                    'value'     => 0,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            )
        ),

        ### closed tasks ###
        'closed_tasks' => array(
            'name'=> __('closed'),
            'filter_empty_folders'=>false,
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'values'    => array( STATUS_APPROVED, STATUS_CLOSED),
                    'min'       => STATUS_APPROVED,
                    'max'       => STATUS_CLOSED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            )
        ),
    );

    ## set preset location ##
    $preset_location = 'projViewTasks';

    ### get preset-id ###
    {
        $preset_id= 'open_tasks';                           # default value
        if($tmp_preset_id= get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_projViewTasks_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id= get('STREBER_projViewTasks_preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }
        }
    }

    if($milestone) {
        ### create from handle ###
        $PH->defineFromHandle(array(
            'prj'      =>$project->id,
            'preset_id' =>$preset_id,
            'for_milestone'=>$milestone->id
        ));

    }
    else {
        ### create from handle ###
        $PH->defineFromHandle(array(
            'prj'      =>$project->id,
            'preset_id' =>$preset_id
        ));
    }

    $page= new Page();

    ### init known filters for preset ###
    $list= new ListBlock_tasks(array(
        'active_block_function'=>'tree',

    ));

    $list->filters[]=new ListFilter_category_in(array(
        'value'=> array(TCATEGORY_TASK,TCATEGORY_BUG)
    ));
    {

        $preset= $presets[$preset_id];
        foreach($preset['filters'] as $f_name=>$f_settings) {
            switch($f_name) {

                case 'task_status':
                    $list->filters[]= new ListFilter_status_min(array(
                        'value'=>$f_settings['min'],
                    ));
                    $list->filters[]= new ListFilter_status_max(array(
                        'value'=>$f_settings['max'],
                    ));
                    break;

                case 'assigned_to':
                    $list->filters[]= new ListFilter_assigned_to(array(
                        'value'=>$f_settings['value'],
                    ));
                    break;

                case 'for_milestone':
                    $list->filters[]= new ListFilter_for_milestone(array(
                        'value'=>$f_settings['value'],
                    ));
                    break;

                case 'not_modified_by':
                    $list->filters[]= new ListFilter_not_modified_by(array(
                        'value'=>$f_settings['value'],
                    ));
                    break;


                default:
                    trigger_error("Unknown filter setting $f_name", E_USER_WARNING);
                    break;
            }
        }

        $filter_empty_folders=  (isset($preset['filter_empty_folders']) && $preset['filter_empty_folders'])
                             ? true
                             : NULL;
    }



    ### set up page ####
    {
        $page->cur_tab='projects';

        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);

        $page->title= $project->name;

        if(isset($preset['name'])) {
            $page->title_minor= $preset['name'];
            if($preset_id == 'next_milestone' && isset($milestone) && isset($milestone->name)) {
                $page->title_minor = __('Milestone') .' '. $milestone->name;
            }
        }
        else {
            $page->title_minor= __("Tasks");
        }


        if($project->status == STATUS_TEMPLATE) {
            $page->type=__("Project Template");
        }
        else if ($project->status >= STATUS_COMPLETED){
            $page->type=__("Inactive Project");
        }
        else {
            $page->type=__("Project","Page Type");
        }

        ### page functions ###
        $new_task_options = isset($preset['new_task_options'])
                          ? $preset['new_task_options']
                          : array();

        if($project->isPersonVisibleTeamMember($auth->cur_user)) {


            #$page->add_function(new PageFunctionGroup(array(
            #    'name'=>__('new'),
            #)));
            if($preset_id != 'next_milestone') {
                $page->add_function(new PageFunction(array(
                    'target'    =>'taskNewFolder',
                    'params'    =>array('prj'=>$project->id)+ $new_task_options,
                    'icon'      =>'new',
                    'tooltip'   =>__('Create a new folder for tasks and files'),
                    #'name'      =>__('New folder')
                )));
            }

            $page->add_function(new PageFunction(array(
                'target'=>'taskNew',
                'params'=>array('prj'=>$project->id)+ $new_task_options,
                'icon'=>'new',
                'tooltip'=>__('new subtask for this folder'),
                #'name'=>__('Task'),
            )));

            if($project->settings & PROJECT_SETTING_ENABLE_BUGS) {
                $page->add_function(new PageFunction(array(
                    'target'    =>'taskNewBug',
                    'params'    =>array('prj'=>$project->id,'add_issue'=>1)+ $new_task_options,
                    'icon'      =>'new',
                    'tooltip'   =>__('Create task with issue-report'),
                    #'name'      =>__('Bug')
                )));
            }
        }

        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### list available presets ###
    if($page->format != FORMAT_CSV){
        $page->print_presets(array(
            'target'=> $preset_location,
            'project_id'=> $project->id,
            'preset_id'=> $preset_id,
            'presets'=> $presets,
            'person_id' => ''));
     }



    if($page->format == FORMAT_HTML) {
        $PH->go_submit='taskNew';
        echo '<input type="hidden" name="prj" value="'.$id.'">';

        /**
        * add preset specific options (like milestone,etc) as hidden fields
        * e.i. if we list tasks for a milestone, new tasks require to belong to this
        * milestone, otherwise they are not visible after creation
        */
        foreach($new_task_options as $name=>$value) {
            echo "<input type=hidden name='$name' value='$value'>";
        }

        ### Link to start cvs export ###
        $format = get('format');
        if($format == FORMAT_HTML || $format == ''){
            $list->footer_links[]= $PH->getCSVLink();
        }
    }



    #--- list tasks --------------------------------------------------------------------------
    {   
        if($for_milestone) {
            $list->filters[]= new ListFilter_for_milestone(array(
                            'value'=>$for_milestone,
                    ));
        }
        $list->show_project_folder= false;

        unset($list->columns['project']);
        unset($list->columns['planned_start']);

        /**
        * NOTE: pixtur 2006-10-13
        * for a clean version of this list with a AJAX-driven side board
        * following columns should be hidden:
        */
        if(confGet('TASKDETAILS_IN_SIDEBOARD')) {
            unset($list->columns['assigned_to']);
            #unset($list->columns['for_milestone']);
            unset($list->columns['estimate_complete']);
            unset($list->columns['pub_level']);
            #unset($list->columns['_select_col_']);
            unset($list->columns['label']);
        }
        if(!confGet('TASK_LIST_EFFORT_COLUMN')) {
            unset($list->columns['efforts']);
        }

        $list->no_items_html=__('No tasks');
        $list->print_automatic($project, NULL, $filter_empty_folders);
    }

    #echo "<a href=\"javascript:document.my_form.go.value='tasksMoveToFolder';document.my_form.submit();\">move to task-folder</a>";
    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}




?>
