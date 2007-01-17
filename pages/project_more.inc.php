<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}

# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * pages relating to listing and modifying projects
 *
 * @author: Thomas Mann
 * @uses:
 * @usedby:
 *
 */

require_once(confGet('DIR_STREBER') . "db/class_task.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_project.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_projectperson.inc.php");
require_once(confGet('DIR_STREBER') . "db/db_itemperson.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_taskfolders.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_comments.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_tasks.inc.php");
require_once(confGet('DIR_STREBER') . "lists/list_project_team.inc.php");



/**
* list active projects
*/
function projList()
{
    require_once(confGet('DIR_STREBER') . "lists/list_projects.inc.php");

    global $PH;
    global $auth;


    ### create from handle ###
    $PH->defineFromHandle();

    ### set up page and write header ####
    {
        $page= new Page();
    	$page->cur_tab='projects';
        $page->title=__("Your Active Projects");
        if(!($auth->cur_user->user_rights & RIGHT_PROJECT_EDIT)) {
            $page->title_minor=sprintf(__("relating to %s"), $page->title_minor=$auth->cur_user->name);
        }
        else {
            $page->title_minor=__("admin view");
        }
        $page->type=__('List','page type');

        $page->options=build_projList_options();

        ### page functions ###
        $page->add_function(new PageFunction(array(
            'target'=>'projNew',
            'icon'=>'new',
        )));

    	### render title ###
        echo(new PageHeader);



    }
    echo (new PageContentOpen);

	#--- list projects --------------------------------------------------------
    {

    	#$projects=Project::getActive($order_str);
        $list= new ListBlock_projects();
        $list->reduced_header= true;

		$format = get('format');
		if($format == FORMAT_HTML|| $format == ''){
		    $list->footer_links[]= $PH->getCSVLink();
		}


        unset($list->functions['projNewFromTemplate']);

        $list->title= $page->title;
        $list->query_options['status_min']= STATUS_UNDEFINED;
        $list->query_options['status_max']= STATUS_OPEN;


        if($auth->cur_user->user_rights & RIGHT_VIEWALL) {
            $warning="";
            if(! ($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
                $warning=__("<b>NOTE</b>: Some projects are hidden from your view. Please ask an administrator to adjust you rights to avoid double-creation of projects");
            }

            $list->no_items_html= $PH->getLink('projNew',__('create new project'),array()). $warning;
        }
        else {
            $list->no_items_html= __("not assigned to a project");
        }

        $list->print_automatic();

	}

    echo(new PageContentClose);
	echo(new PageHtmlEnd);
}


#---------------------------------------------------------------------------
# listProjects (closed)
#---------------------------------------------------------------------------
function ProjListClosed()
{
    require_once(confGet('DIR_STREBER') . "lists/list_projects.inc.php");

    global $PH;
    global $auth;


    ### create from handle ###
    $PH->defineFromHandle();

    ### set up page and write header ####
    {
        $page= new Page();
    	$page->cur_tab='projects';
        $page->title=__("Your Closed Projects");
        if(!($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
            $page->title_minor=sprintf(__("relating to %s"), $page->title_minor=$auth->cur_user->name);
        }
        else {
            $page->title_minor=__("admin view");
        }
        $page->type=__('List','page type');

        $page->options = build_projList_options();

    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

	#--- list projects --------------------------------------------------------
	{
        $list= new ListBlock_projects();
        $list->reduced_header=true;

		## Link to start cvs export ##
		$format = get('format');
		if($format == FORMAT_HTML || $format == ''){
		    $list->footer_links[]= $PH->getCSVLink();
		}


        unset($list->functions['effortNew']);
        unset($list->functions['projNew']);
        unset($list->functions['projNewFromTemplate']);

        $list->title= $page->title;
        $list->query_options['status_min']= STATUS_BLOCKED;
        $list->query_options['status_max']= STATUS_CLOSED;

        $list->no_items_html= __("not assigned to a closed project");

        $list->print_automatic();

	}

    echo(new PageContentClose);
	echo(new PageHtmlEnd);

}

#---------------------------------------------------------------------------
# listProjects (Templates)
#---------------------------------------------------------------------------
function ProjListTemplates()
{
    require_once(confGet('DIR_STREBER') . "lists/list_projects.inc.php");

    global $PH;
    global $auth;

    ### create from handle ###
    $PH->defineFromHandle();

    ### set up page and write header ####
    {
        $page= new Page();
    	$page->cur_tab='projects';
        $page->title=__("Project Templates");
        if(!($auth->cur_user->user_rights & RIGHT_PROJECT_EDIT)) {
            $page->title_minor= sprintf(__("relating to %s"), $page->title_minor=$auth->cur_user->name);
        }
        else {
            $page->title_minor= __("admin view");
        }
        $page->type=__('List','page type');

        $page->options= build_projList_options();

    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

	#--- list projects --------------------------------------------------------
	{
        $list= new ListBlock_projects();
        $list->reduced_header=true;

		## Link to start cvs export ##
		$format = get('format');
		if($format == FORMAT_HTML|| $format == ''){
		    $list->footer_links[]= $PH->getCSVLink();
		}

        unset($list->functions['effortNew']);
        unset($list->functions['projNew']);
        unset($list->functions['projCreateTemplate']);
        unset($list->functions['projOpenClose']);

        $list->title= $page->title;
        $list->query_options['status_min']= STATUS_TEMPLATE;
        $list->query_options['status_max']= STATUS_TEMPLATE;

        $list->no_items_html= __("no project templates");

        $list->print_automatic();

	}


    echo(new PageContentClose);
	echo(new PageHtmlEnd);
}






/**
* list changes
*/
function ProjViewChanges()
{
    global $PH;
	global $auth;

	### get current project ###
    $id=getOnePassedId('prj','projects_*');
    if(!$project= Project::getVisibleById($id)) {
        $PH->abortWarning(__("invalid project-id"));
		return;
	}

	### sets the presets ###
	$presets= array(
        ### all ###
        'all_changes' => array(
            'name'=> __('all'),
            'filters'=> array(
			    'task_status'   =>  array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'    =>  STATUS_UNDEFINED,
					'max'    =>  STATUS_CLOSED,
                ),
			),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
		## modified by me ##
        'modified_by_me' => array(
            'name'=> __('modified by me'),
            'filters'=> array(
				'task_status'   =>  array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'    =>  STATUS_UNDEFINED,
					'max'    =>  STATUS_CLOSED,
                ),
                'modified_by'   =>  array(
                    'id'        => 'modified_by',
                    'visible'   => true,
                    'active'    => true,
                    'value'    =>  $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		## modified by others ##
		'modified_by_others' => array(
            'name'=> __('modified by others'),
            'filters'=> array(
				'task_status'   =>  array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'    =>  STATUS_UNDEFINED,
					'max'    =>  STATUS_CLOSED,
                ),
                'not_modified_by'   => array(
                    'id'        => 'not_modified_by',
                    'visible'   => true,
                    'active'    => true,
                    'value'    =>  $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		## last logout ##
		'last_logout' => array(
            'name'=> __('last logout'),
            'filters'=> array(
                'last_logout'   => array(
                    'id'        => 'last_logout',
                    'visible'   => true,
                    'active'    => true,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		## 1 week ##
		'last_week' => array(
            'name'=> __('1 week'),
            'filters'=> array(
                'last_week'   => array(
                    'id'        => 'last_week',
                    'visible'   => true,
                    'active'    => true,
					'factor'    => 7,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		## 2 week ##
		'last_two_weeks' => array(
            'name'=> __('2 weeks'),
            'filters'=> array(
                'last_two_weeks'   => array(
                    'id'        => 'last_two_weeks',
                    'visible'   => true,
                    'active'    => true,
					'factor'    => 14,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		## prior ##
    );

	## set preset location ##
	$preset_location = 'projViewChanges';

    ### get preset-id ###
    {
        $preset_id= 'last_two_weeks';                           # default value
        if($tmp_preset_id= get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_projViewChanges_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id= get('STREBER_projViewChanges_preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }
        }
    }

	### create from handle ###
    $PH->defineFromHandle(array('prj'=>$project->id, 'preset_id'=>$preset_id));

	## init known filters for preset ##
	require_once(confGet('DIR_STREBER') . './lists/list_projectchanges.inc.php');
	$page= new Page();
	$list = new ListBlock_projectchanges();

	$list->filters[] = new ListFilter_changes();
	{
		$preset = $presets[$preset_id];
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
				case 'modified_by':
					$list->filters[]= new ListFilter_modified_by(array(
						'value'=>$f_settings['value'],
					));
					break;
				case 'not_modified_by':
					$list->filters[]= new ListFilter_not_modified_by(array(
						'value'=>$f_settings['value'],
					));
					break;
				case 'last_logout':
					$list->filters[]= new ListFilter_last_logout(array(
						'value'=>$f_settings['value'],
					));
					break;
				case 'last_week':
					$list->filters[]= new ListFilter_min_week(array(
						'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
					));
					$list->filters[]= new ListFilter_max_week(array(
						'value'=>$f_settings['value'],
					));
					break;
				case 'last_two_weeks':
					$list->filters[]= new ListFilter_min_week(array(
						'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
					));
					$list->filters[]= new ListFilter_max_week(array(
						'value'=>$f_settings['value'],
					));
					break;
				default:
					trigger_error("Unknown filter setting $f_name", E_USER_WARNING);
					break;
			}
		}

		$filter_empty_folders =  (isset($preset['filter_empty_folders']) && $preset['filter_empty_folders'])
							  ? true
							  : NULL;
	}

    ### set up page ####
    {
    	$page->cur_tab  = 'projects';

        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);

        $page->title_minor  = __("Changes");
        $page->title= $project->name;

        if($project->status == STATUS_TEMPLATE) {
            $page->type=__("Project Template");
        }
        else if ($project->status >= STATUS_COMPLETED){
            $page->type=__("Inactive Project");
        }
        else {
            $page->type=__("Project","Page Type");
        }

    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

	$page->print_presets(array(
	    'target' => $preset_location,
		'project_id' => $project->id,
		'preset_id' => $preset_id,
		'presets' => $presets));

    #echo(new PageContentNextCol);

    #--- list changes --------------------------------------------------------------------------
    {
        #$list->query_options['date_min']= $auth->cur_user->last_logout;
        $list->print_automatic($project);
    }

    #--- list items --------------------------------------------------------------------------
    /*{
        require_once(confGet('DIR_STREBER') . "lists/list_projectchanges.inc.php");

        $order_str=get("sort_".$PH->cur_page->id ."_changes");

        $items= Project::getChanges(array(
            'order_by'=> $order_str,
        ));

        $list=new ListBlock_projectchanges();
        $list->title= __("changed project-items");
        $list->no_items_html= __("no changes yet");
        $list->render_list(&$items);

	}*/

    ### HACKING: 'add new task'-field ###
    $PH->go_submit='taskNew';
    echo '<input type="hidden" name="prj" value="'.$id.'">';

    #echo (new PageQuickNew);

    #echo "<a href=\"javascript:document.my_form.go.value='tasksMoveToFolder';document.my_form.submit();\">move to task-folder</a>";
    echo (new PageContentClose);
	echo (new PageHtmlEnd());
}



function ProjViewTasks()
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
    $for_milestone= 0;
    $milestone= NULL;
    if(!$for_milestone=get('for_milestone')) {
        if($milestone= $project->getNextMilestone()) {
            $for_milestone= $milestone->id;
        }
    }
    else {
        $milestone= Task::getVisibleById($for_milestone);
    }

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

    if($ms=get('for_milestone')) {
        ### create from handle ###
        $PH->defineFromHandle(array(
            'prj'      =>$project->id,
            'peset_id' =>$preset_id,
            'for_milestone'=>$ms
        ));

    }
    else {
        ### create from handle ###
        $PH->defineFromHandle(array(
            'prj'      =>$project->id,
            'peset_id' =>$preset_id
        ));
    }

    $page= new Page();

    ### init known filters for preset ###
    $list= new ListBlock_tasks(array(
        'active_block_function'=>'tree',

    ));
    $list->filters[]=new ListFilter_for_milestone();
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


        $page->add_function(new PageFunctionGroup(array(
            'name'=>__('new:'),
        )));
        if($preset_id != 'next_milestone') {
            $page->add_function(new PageFunction(array(
                'target'    =>'taskNewFolder',
                'params'    =>array('prj'=>$project->id)+ $new_task_options,
                'icon'      =>'new',
                'tooltip'   =>__('Create a new folder for tasks and files'),
                'name'      =>__('Folder')
            )));
        }

        $page->add_function(new PageFunction(array(
            'target'=>'taskNew',
            'params'=>array('prj'=>$project->id)+ $new_task_options,
            'icon'=>'new',
            'tooltip'=>__('new subtask for this folder'),
            'name'=>__('Task'),
        )));

        $page->add_function(new PageFunction(array(
            'target'    =>'taskNewBug',
            'params'    =>array('prj'=>$project->id,'add_issue'=>1)+ $new_task_options,
            'icon'      =>'new',
            'tooltip'   =>__('Create task with issue-report'),
            'name'      =>__('Bug')
        )));


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
			'presets'=> $presets));
	 }
    /*if($page->format != FORMAT_CSV) {
        echo "<div class=presets>";
        #echo __("Filter-Preset:");
        foreach($presets as $p_id=>$p_settings) {
            if($p_id == $preset_id) {
                echo $PH->getLink('projViewTasks',$p_settings['name'], array('prj'=>$project->id,'preset'=>$p_id),'current');;
            }
            else {
                echo $PH->getLink('projViewTasks',$p_settings['name'], array('prj'=>$project->id,'preset'=>$p_id));
            }
        }
        echo "</div>";
    }*/

    #echo(new PageContentNextCol);



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
        $list->reduced_header= true;
        #$list->filters[]= new ListFilter_status_max(array('value'=>STATUS_COMPLETED));

        #if($for_milestone=get('for_milestone')) {
        #    $list->filters['for_milestone']= intval($for_milestone);
        #}


        unset($list->columns['project']);
        unset($list->columns['planned_start']);

        /**
        * NOTE: pixtur 2006-10-13
        * for a clean version of this list with a AJAX-driven side board
        * following columns should be hidden:
        */
        #unset($list->columns['assigned_to']);
        #unset($list->columns['for_milestone']);
        #unset($list->columns['estimate_complete']);
        #unset($list->columns['pub_level']);
        #unset($list->columns['_select_col_']);
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










function ProjViewDocu()
{
    global $PH;
    global $auth;

	### get current project ###
    $id=getOnePassedId('prj','projects_*');
    if(!$project=Project::getVisibleById($id)) {
        $PH->abortWarning("invalid project-id");
		return;
	}

    ### create from handle ###
    $PH->defineFromHandle(array(
        'prj'      =>$project->id,
    ));

    ### set up page ####
    {
        $page= new Page();
    	$page->cur_tab='projects';

        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);

        $page->title= $project->name;
        $page->title_minor= __("Documentation");

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
        $page->add_function(new PageFunctionGroup(array(
            'name'=>__('new:'),
        )));
        $page->add_function(new PageFunction(array(
            'target'    =>'taskNew',
            'params'    =>array('prj'=>$project->id, 'task_category'=>TCATEGORY_DOCU),
            'icon'      =>'new',
            'tooltip'   =>__('Create a new page'),
            'name'      =>__('Page')
        )));

    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);




    #--- list documentation pages  --------------------------------------------------------------------------
    {
        ### init known filters for preset ###
        $list= new ListBlock_tasks(array(
            'active_block_function'=>'tree'
        ));

        $list->reduced_header= true;
        #$list->filters[]= new ListFilter_status_max(array('value'=>STATUS_COMPLETED));

        #if($for_milestone=get('for_milestone')) {
        #    $list->filters['for_milestone']= intval($for_milestone);
        #}
        $list->query_options['category']= TCATEGORY_DOCU;
        $list->query_options['status_min']= 0;
        $list->query_options['status_max']= 10;
        $list->query_options['order_by']= 'order_id';

        ### redefine columns ###
        $c_new = array();
        foreach($list->columns as $cname => $c) {
            if($cname == '_select_col_') {
                $c_new[$cname] = $c;
            }
        }
        $list->columns= $c_new;
        $list->add_col( new ListBlockCol_TaskAsDocu());

        /**
        * NOTE: pixtur 2006-10-13
        * for a clean version of this list with a AJAX-driven side board
        * following columns should be hidden:
        */
        #unset($list->columns['assigned_to']);
        #unset($list->columns['for_milestone']);
        #unset($list->columns['estimate_complete']);
        #unset($list->columns['pub_level']);
        #unset($list->columns['_select_col_']);
        unset($list->functions['taskNew']);
        unset($list->functions['taskNewBug']);
        unset($list->functions['tasksCompleted']);
        unset($list->functions['tasksApproved']);
        unset($list->functions['tasksClosed']);
        unset($list->functions['effortNew']);
        unset($list->functions['commentNew']);


        $list->no_items_html=__('No tasks');
        $list->print_automatic($project, NULL, true);
	}

    $PH->go_submit='taskNew';
    echo '<input type="hidden" name="prj" value="'.$id.'">';


    #echo "<a href=\"javascript:document.my_form.go.value='tasksMoveToFolder';document.my_form.submit();\">move to task-folder</a>";
    echo (new PageContentClose);
	echo (new PageHtmlEnd());
}












/**
* list files attached to project
*
*/
function ProjViewFiles()
{
    global $PH;

	### get current project ###
    $id=getOnePassedId('prj','projects_*');
    if(!$project=Project::getVisibleById($id)) {
        $PH->abortWarning("invalid project-id");
		return;
	}

    ### create from handle ###
    $PH->defineFromHandle(array('prj'=>$project->id));

    ### set up page ####
    {
        $page= new Page();
    	$page->cur_tab='projects';

        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);

        $page->title_minor= __("Uploaded Files");
        $page->title=$project->name;
        $page->type= $project->getStatusType();
        $PH->go_submit= $PH->getValidPage('filesUpload')->id;


        ### page functions ###
/*        $page->add_function(new PageFunction(array(
            'target'=>'effortNew',
            'params'=>array('prj'=>$project->id),
            'icon'=>'new',
            'name'=>__('new Effort'),
        )));
*/


    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

#    echo(new PageContentNextCol);


	### upload files ###
    {
        $block=new PageBlock(array('title'=>__('Upload file','block title'),'id'=>'summary'));
        $block->render_blockStart();

        echo "<div class=text>";
		echo '<input type="hidden" name="MAX_FILE_SIZE" value="'. confGet('FILE_UPLOAD_SIZE_MAX'). '" />';
		echo '<input id="userfile" name="userfile" type="file" size="40" accept="*" />';
        echo '<input type="submit" value="'.__('Upload').'" />';
        echo '</div>';

        $block->render_blockEnd();
		echo '<br />';
    }

	### list files ###
    {
        require_once(confGet('DIR_STREBER') . "lists/list_files.inc.php");
        $list= new ListBlock_files();
        $list->reduced_header= true;
        #$list->query_options['visible_only']= false;
        unset($list->columns['summary']);


        $list->print_automatic($project);
	}








#    echo "<a href=\"javascript:document.my_form.go.value='tasksMoveToFolder';document.my_form.submit();\">move to task-folder</a>";



    echo '<input type="hidden" name="prj" value="'.$id.'">';

    echo (new PageContentClose);
	echo (new PageHtmlEnd());
}





/**
* project roadmap (list milestones)
*
*/
function ProjViewMilestones()
{
    global $PH;
    global $auth;

	### get current project ###
    $id=getOnePassedId('prj','projects_*');
    if(!$project=Project::getVisibleById($id)) {
        $PH->abortWarning("invalid project-id");
		return;
	}

    ### create from handle ###
    $PH->defineFromHandle(array(
        'prj'=>$project->id,
        'preset'=> get('preset'),
    ));

    ### set up page ####
    {
        $page= new Page();
    	$page->cur_tab='projects';

        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);

        $page->type= $project->getStatusType();
        $page->title=$project->name;
        $page->title_minor= __("Milestones");


        ### page functions ###
        if($auth->cur_user->id != confGet('ANONYMOUS_USER')) {
            $page->add_function(new PageFunction(array(
                'target'=>'taskNewMilestone',
                'params'=>array('prj'=>$project->id),
                'icon'=>'new',
                'name'=>__('new Milestone'),
            )));
        }


    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

#    echo(new PageContentNextCol);


    #--- list milestones --------------------------------------------------------------------------
    {
        require_once(confGet('DIR_STREBER') . "lists/list_milestones.inc.php");
        $list= new ListBlock_milestones();

        $list->query_options['is_milestone']= 1;
        echo "<div class=milestone_views>";
        if(get('preset') == 'completed') {
            $list->query_options['status_min']= STATUS_COMPLETED;
            $list->query_options['status_max']= STATUS_CLOSED;

            echo $PH->getLink(
                        'projViewMilestones',
                        __('View open milestones'),
                        array('prj'=>$project->id));
        }
        else {
            echo $PH->getLink(
                        'projViewMilestones',
                        __('View closed milestones'),
                        array('prj'=>$project->id, 'preset'=>'completed'));
        }
        echo "</div>";

        $list->reduced_header= true;

        $list->print_automatic($project);
	}
    echo '<input type="hidden" name="prj" value="'.$id.'">';

    echo (new PageContentClose);
	echo (new PageHtmlEnd());
}




function ProjViewEfforts()
{
    global $PH;

    require_once(confGet('DIR_STREBER') . "lists/list_efforts.inc.php");

	### get current project ###
    $id=getOnePassedId('prj','projects_*');
    if(!$project=Project::getVisibleById($id)) {
        $PH->abortWarning("invalid project-id");
		return;
	}

    ### create from handle ###
    $PH->defineFromHandle(array('prj'=>$project->id));

    ### set up page ####
    {
        $page= new Page();
    	$page->cur_tab='projects';

        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);

        $page->title_minor= __("Project Efforts");
        $page->title=$project->name;

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
        $page->add_function(new PageFunction(array(
            'target'=>'effortNew',
            'params'=>array('prj'=>$project->id),
            'icon'=>'new',
            'name'=>__('new Effort'),
        )));


    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    #--- list efforts --------------------------------------------------------------------------
    {


        $order_by=get('sort_'.$PH->cur_page->id."_efforts");

        require_once(confGet('DIR_STREBER') . "db/class_effort.inc.php");
        $efforts= Effort::getAll(array(
            'project'=> $project->id,
            'order_by'=> $order_by,

        ));
        $list= new ListBlock_efforts();
        $list->reduced_header= true;

		### Link to start cvs export ###
    	$format = get('format');
    	if($format == FORMAT_HTML || $format == ''){
    		$list->footer_links[]=  $PH->getCSVLink();
    	}


        unset($list->columns['p.name']);

        $list->render_list(&$efforts);

	}

	### 'add new task'-field ###
	$PH->go_submit='taskNew';
	echo '<input type="hidden" name="prj" value="'.$id.'">';

    echo (new PageContentClose);
	echo (new PageHtmlEnd());
}



function ProjViewVersions()
{
    global $PH;
    global $auth;

    require_once(confGet('DIR_STREBER') . "lists/list_versions.inc.php");

	### get current project ###
    $id =getOnePassedId('prj','projects_*');
    if(!$project=Project::getVisibleById($id)) {
        $PH->abortWarning("invalid project-id");
		return;
	}

    ### create from handle ###
    $PH->defineFromHandle(array('prj'=>$project->id));

    ### set up page ####
    {
        $page= new Page();
    	$page->cur_tab='projects';

        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);

        $page->title_minor= __("Released Versions");
        $page->title=$project->name;

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
        if($auth->cur_user->id != confGet('ANONYMOUS_USER')) {
            $page->add_function(new PageFunction(array(
                'target'=>'taskNewVersion',
                'params'=>array('prj'=>$project->id),
                'icon'=>'new',
                'name'=>__('New released Milestone'),
            )));
        }


    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);


    ### list versions ###
    {

        $list= new ListBlock_versions();
        $list->reduced_header= true;

        $list->query_options['project']= $project->id;

        $list->print_automatic($project);
	}


	### list changes for upcomming version ###
	{

	    if($tasks= Task::getAll(array(
	        'project'           => $project->id,
	        'status_min'        => STATUS_COMPLETED,
	        'status_max'        => STATUS_CLOSED,
	        'resolved_version'  => RESOLVED_IN_NEXT_VERSION,
	        'resolve_reason_min'=> RESOLVED_DONE,                          # @@@ this is not the best solution (should be IS NOT)
	    ))) {

            $block=new PageBlock(array(
                'title'=>__("Tasks resolved in upcomming version"),
                'id'=>'resolved_tasks',
            ));
            $block->render_blockStart();
            echo "<div class=text>";
	        echo '<ul>';
	        foreach($tasks as $t) {
	            global $g_resolve_reason_names;
                if($t->resolve_reason && isset($g_resolve_reason_names[$t->resolve_reason])) {
                    $reason= $g_resolve_reason_names[$t->resolve_reason] .": ";
                }
                else {
                    $reason= "";
                }

	            echo '<li>' . $reason . $t->getLink(false) . '</li>';
	        }
	        echo '</ul>';

            $block->render_blockEnd();
	    }
	}

    echo (new PageContentClose);
	echo (new PageHtmlEnd());
}




function projNew() {
    global $PH;

    $company=get('company');

    ### build dummy form ###
    $newproject= new Project(array(
        'id'        => 0,
        'name'      => __('New Project'),
        'state'     => 1,
        'company'   => $company,
        'pub_level' => 100,
        )
    );

    $PH->show('projEdit',array('prj'=>$newproject->id),$newproject);
}



function projEdit($project=NULL)
{
    global $PH;
    global $auth;
    require_once ("./db/class_company.inc.php");

    if(!$project) {

        $prj=getOnePassedId('prj','projects_*');

        ### get project ####
        if(!$project= Project::getEditableById($prj)) {
            $PH->abortWarning("could not get Project");
            return;
        }
    }

    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>true,'autofocus_field'=>'project_name'));
    	$page->cur_tab='projects';
        $page->type= __("Edit Project");
        $page->title=$project->name;
        $page->title_minor=$project->short;

        $page->crumbs= build_project_crumbs($project);
        $page->options[]= new NaviOption(array(
            'target_id' => 'projEdit',
        ));

        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form #####
    {
        global $g_status_names;
        global $g_prio_names;
        require_once(confGet('DIR_STREBER') . "render/render_form.inc.php");

        ### form background ###
        $block=new PageBlock(array(
            'id'    =>'project_edit',
            'reduced_header' => true,
        ));
        $block->render_blockStart();

        $form=new PageForm();
        $form->button_cancel=true;


        $form->add($project->fields['name']->getFormElement(&$project));


        $form->add($tab_group=new Page_TabGroup());

        ### main attributes ###
        {
            $tab_group->add($tab=new Page_Tab("project",__("Project")));
            $tab->add(new Form_Dropdown('project_status',  "Status",array_flip($g_status_names),$project->status));

            ### build company-list ###
            $companies=Company::getAll();
            $cl_options= array('undefined'=>0);
            foreach($companies as $c) {
                $cl_options[$c->name]= $c->id;
            }
            $tab->add(new Form_Dropdown('project_company',__('Company','form label'),$cl_options,$project->company));

            $tab->add(new Form_Dropdown('project_prio',  "Prio",array_flip($g_prio_names),$project->prio));

            $tab->add($project->fields['projectpage']->getFormElement(&$project));
            $tab->add($project->fields['date_start']->getFormElement(&$project));
            $tab->add($project->fields['date_closed']->getFormElement(&$project));

        }

        ### description ###
        {
            $tab_group->add($tab=new Page_Tab("description",__("Description")));

            $e= $project->fields['description']->getFormElement(&$project);
            $e->rows=20;
            $tab->add($e);

        }

        ### Display ###
        {
            global $g_project_setting_names;
            $tab_group->add($tab=new Page_Tab("tab3",__("Display")));
            $tab->add($project->fields['short']->getFormElement(&$project));
            $tab->add($project->fields['status_summary']->getFormElement(&$project));

            $tab->add(new Form_checkbox('project_setting_efforts',      $g_project_setting_names[PROJECT_SETTING_EFFORTS], $project->settings & PROJECT_SETTING_EFFORTS));
            $tab->add(new Form_checkbox('project_setting_milestones',   $g_project_setting_names[PROJECT_SETTING_MILESTONES], $project->settings & PROJECT_SETTING_MILESTONES));
            $tab->add(new Form_checkbox('project_setting_versions',     $g_project_setting_names[PROJECT_SETTING_VERSIONS], $project->settings & PROJECT_SETTING_VERSIONS));
            #$tab->add(new Form_checkbox('project_setting_only_pm_may_close',     $g_project_setting_names[PROJECT_SETTING_ONLY_PM_MAY_CLOSE], $project->settings & PROJECT_SETTING_ONLY_PM_MAY_CLOSE));

        }


        #$form->add($project->fields['prio']->getFormElement(&$project));


        #$form->add($project->fields['show_in_home']->getFormElement(&$project));
        #$form->add($project->fields['color']->getFormElement(&$project));
        #$form->add($project->fields['wikipage']->getFormElement(&$project));



        #$form->add(new Form_Dropdown('status',  "Status",array(),0));

        #$form->add(new Form_Date('prj_date_start', 'Started',$project->fields['date_start']->db2value($project->date_start)));
        #$form->add(new Form_Date('prj_date_closed','Closed',$project->fields['date_closed']->db2value($project->date_closed)));
        #$form->add(new Form_Edit('prj_description', 'Description', $project->description));





        ### create another one ###
        if($auth->cur_user->user_rights & RIGHT_PROJECT_CREATE && $project->id == 0) {
            $checked= get('create_another')
            ? 'checked'
            : '';

            $form->form_options[]="<span class=option><input name='create_another' class='checker' type=checkbox $checked>".__("Create another project after submit")."</span>";
        }


        #echo "<input type=hidden name='prj' value='$project->id'>";
        $form->add(new Form_Hiddenfield('prj','',$project->id));


        echo($form);

        $block->render_blockEnd();

        $PH->go_submit='projEditSubmit';

        if($return=get('return')) {
            echo "<input type=hidden name='return' value='$return'>";
        }
    }
    echo (new PageContentClose);
	echo (new PageHtmlEnd());

}




#---------------------------------------------------------------------------
# projEditSubmit
#---------------------------------------------------------------------------
function projEditSubmit()
{
    global $PH;
    global $auth;

    ### cancel ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('projView',array('prj'=>$project->id));
        }
        exit;
    }

    log_message("projEditSubmit()", LOG_MESSAGE_DEBUG);

    if(!validateFormCrc()) {
        $PH->abortWarning(__('Invalid checksum for hidden form elements'));
    }


    ### get project ####
    $project_id = getOnePassedId('prj');
    if($project_id == 0) {
        $project= new Project(array());
    }
    else {
        if(!$project= Project::getEditableById($project_id)) {
            $PH->abortWarning("Could not get project");
            return;
        }
    }

    $project->validateEditRequestTime();

    log_message(" :edit request time validated()", LOG_MESSAGE_DEBUG);


    # retrieve all possible values from post-data
    # NOTE:
    # - this could be an security-issue.
    # - TODO: as some kind of form-edit-behaviour to field-definition
    foreach($project->fields as $f) {
        $name=$f->name;
        $f->parseForm(&$project);
    }

    ### project company ###
    if(!is_null(get('project_company'))) {
        $project->company = intval(get('project_company'));
    }

    /**
    * settings
    *
    * NOTE: all settings have to be rendered in projEdit as ForM-checkboxes.
    * Missing checkboxes will clear the setting!
    */
    {
        foreach( array(
            'project_setting_efforts'           =>  PROJECT_SETTING_EFFORTS,
            'project_setting_milestones'        =>  PROJECT_SETTING_MILESTONES,
            'project_setting_versions'          =>  PROJECT_SETTING_VERSIONS,
            'project_setting_only_pm_may_close' =>  PROJECT_SETTING_ONLY_PM_MAY_CLOSE,
        ) as $form_name => $setting) {
            if(!is_null(get($form_name))) {
                $project->settings |= $setting;
            }
            else {
                $project->settings &= $setting ^ PROJECT_SETTING_ALL;
            }
        }
    }


    log_message(" :validated", LOG_MESSAGE_DEBUG);


    ### write to db ###
    if($project->id ==0) {
        $project->insert();

        ### if new project add creator to team ###
        if($person= Person::getVisibleById($project->created_by)) {

            ### effort-style
            $adjust_effort_style= ($person->settings & USER_SETTING_EFFORTS_AS_DURATION)
                                ? EFFORT_STYLE_DURATION
                                : EFFORT_STYLE_TIMES;

            $pp_new= new ProjectPerson(array(
                'id'                    => 0,
                'person'                => $person->id,
                'project'               => $project->id,
                'adjust_effort_style'   => $adjust_effort_style,
                'pub_level' =>PUB_LEVEL_CLIENT,             # the creator should be visible to client
            ));

            ### add project-right ###
            $pp_new->initWithUserProfile(PROFILE_ADMIN);

            log_message(" :inserting...", LOG_MESSAGE_DEBUG);
            $pp_new->insert();
            log_message(" :inserted", LOG_MESSAGE_DEBUG);
        }
        else {
            trigger_error("creator of person not visible?",E_USER_WARNING);
        }

    }
    else {
        log_message(" :updating...", LOG_MESSAGE_DEBUG);
        $project->update();
        log_message(" :updated", LOG_MESSAGE_DEBUG);
    }

	### notify on change ###
	$project->nowChangedByUser();

    ### automatically view new project ###
    if($project_id == 0) {
        ### create another person ###
        if(get('create_another')) {
            $PH->show('projNew');
            exit;
        }
        else {
            $PH->show('projView',array('prj'=>$project->id));
            exit;
        }
    }
    ### otherwise return to from-page
    else {
        ### display taskView ####
        if(!$PH->showFromPage()) {
            $PH->show('projView',array('prj'=>$project->id));
        }
    }
}


#=====================================================================================================
# project delete
#=====================================================================================================
function projDelete()
{
    global $PH;

    $ids= getPassedIds('prj','projects_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some projects to delete"));
        return;
    }

    $counter=0;
    $errors=0;
    foreach($ids as $id) {
        if(!$p= Project::getEditableById($id)) {
            $errors++;
        }
        else {
			if($p->delete()) {
				$counter++;
			}
			else {
				$errors++;
			}
        }
    }
    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to delete %s projects"), $errors));
    }
    else {
        new FeedbackMessage(sprintf(__("Moved %s projects to trash"),$counter));
    }

    ### display projList ####
    $PH->show('projList');

}

/**
* project Change status
*
* actually toggles status between open /closed
*/
function projChangeStatus()
{
    global $PH;

    $ids= getPassedIds('prj','projects_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some projects..."));
        return;
    }

    $count_opened=0;
    $count_closed=0;
    $errors=0;
    foreach($ids as $id) {
        $e= Project::getEditableById($id);
        if(!$e || $e->state ==-1) {
            $PH->abortWarning(__("Invalid project-id!"));
        }

        if($e->status <= STATUS_OPEN) {
            $e->status= STATUS_CLOSED;
            $e->date_closed=  date(__("Y-m-d"),time());
            $count_closed++;
        }
        else if($e->status > STATUS_OPEN) {
            $e->status= STATUS_OPEN;
            $count_opened++;
        }
        $e->update();
    }
    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to change %s projects"),$errors));
    }
    else {
        if($count_closed) {
            new FeedbackMessage(sprintf(__("Closed %s projects"),$count_closed));
        }
        else if($count_opened) {
            new FeedbackMessage(sprintf(__("Reactivated %s projects"),$count_opened));
        }
    }

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('projList');
    }
}

/**
* select new people from a list
*
* userRights have been validated by pageHandler()
*
* @@@ add additional project-specific check here?
*/
function projAddPerson()
{
    global $PH;

    $id= getOnePassedId('prj','');   # WARNS if multiple; ABORTS if no id found
    if(!$project= Project::getEditableById($id)) {
        $PH->abortWarning("ERROR: could not get Project");
    }



    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>false, 'autofocus_field'=>'company_name'));
    	$page->cur_tab='projects';
        $page->type= __("Edit Project");
        $page->title="$project->name";
        $page->title_minor=__("Select new team members");

        $page->crumbs= build_project_crumbs($project);

        $page->options[]= new NaviOption(array(
            'target_id'     =>'projAddPerson',

        ));

        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . "pages/person.inc.php");
        require_once(confGet('DIR_STREBER') . "render/render_form.inc.php");

        ### write list of persons ###
        {
            ### build hash of already added person ###
            $pps= $project->getProjectPersons('', true,false);
            $pp_hash=array();
            foreach($pps as $pp) {
                $pp_hash[$pp->person]= true;
            }

            ### filter already added persons ###
            $persons= array();
            foreach(Person::getPersons() as $p) {
                if(!isset($pp_hash[$p->id])) {
                    $persons[]=$p;
                }
            }

            $list= new ListBlock_persons();

            unset($list->columns['personal_phone']);
            unset($list->columns['office_phone']);
            unset($list->columns['mobile_phone']);
            unset($list->columns['companies']);
            unset($list->columns['changes']);
            unset($list->columns['last_login']);
            $list->functions=array();
            $list->no_items_html=__("Found no persons to add. Go to `People` to create some.");

            $list->render_list(&$persons);
        }



        #@@@ probably add dropdown-list with new project-role here

        $PH->go_submit='projAddPersonSubmit';
        echo "<input type=hidden name='project' value='$project->id'>";
        echo "<div class=formbuttons>";
        $name=__('Add');
        echo "<input class=button type=submit value='$name'>";
        echo "</div>";
    }
    echo (new PageContentClose);
	echo (new PageHtmlEnd());
}


function projAddPersonSubmit()
{
    global $PH;

    require_once(confGet('DIR_STREBER') . "db/class_person.inc.php");

    $id= getOnePassedId('project','');
    if(!$project= Project::getEditableById($id)) {
        $PH->abortWarning("Could not get object...",ERROR_FATAL);
    }

    ### get persons ###
    $person_ids= getPassedIds('person','persons*');
    if(!$person_ids) {
        $PH->abortWarning(__("No persons selected..."),ERROR_NOTE);
    }

    ### get team (including inactive members)  ###
    $ppersons= $project->getProjectPersons('',false,false); # also  PP with state !=1

    ### go through selected people ###
    foreach($person_ids as $pid) {
        if(!$person= Person::getVisibleById($pid)) {
            $PH->abortWarning(__("Could not access person by id"));
            return;
        }

        #### person already employed? ###
        $already_in=false;
        $pp=NULL;
        foreach($ppersons as $pp) {
            if($pp->person == $person->id) {
                $already_in= true;
                break;
            }
        }

        ### effort-style
        $adjust_effort_style= ($person->settings & USER_SETTING_EFFORTS_AS_DURATION)
                            ? EFFORT_STYLE_DURATION
                            : EFFORT_STYLE_TIMES;

        ### add ###
        if(!$already_in) {
            $pp_new= new ProjectPerson(array(
                'id'                    => 0,
                'person'                => $person->id,
                'project'               => $project->id,
                'adjust_effort_style'   => $adjust_effort_style,
            ));

            ### add project-right ###
            global $g_user_profile_names;
            if($g_user_profile_names[$person->profile]) {
                $profile_id= $person->profile;

                $pp_new->initWithUserProfile($profile_id);
            }
            else {
                trigger_error("person '$person->name' has undefined profile", E_USER_WARNING);
            }


            $pp_new->insert();
        }
        ### reanimate ###
        else if($pp->state != 1) {
            $pp->state=1;
            $pp->update();
            new FeedbackMessage(__("Reanimated person as team-member"));
        }
        ### skip ###
        else {
            new FeedbackMessage(__("Person already in project"));
        }
    }
    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('projView',array('prj'=>$project->id));
    }
}


/**
* create template from existing project
*
* - duplicates all projects items
* - adjusts..
*   - name, short-name, status
* - opens a projEdit to finetune the settings.
*/
function projCreateTemplate() {

    global $PH;
    global $auth;

    $count_items=0;

    $project_id= getOnePassedId('prj','projects_*'); # aborts on failure

    /**
    * get project, just to be sure rights are ok
    */
    if(!$org_project= Project::getVisibleById($project_id)) {
        $PH->abortWarning("could not get Project");
        return;
    }

    if(!$new_project = projDuplicate($project_id)) {
        $PH->abortWarning("duplicating project failed.", ERROR_DATASTRUCTURE);
        return;
    }
    $new_project->status= STATUS_TEMPLATE;
    $new_project->name= "- ".$new_project->name." - ". __("Template","as addon to project-templates");
    $new_project->update(array('status','name'),false);

    $PH->show('projEdit',array('prj'=>$new_project->id),$new_project);
}



/**
* create normal project from template
*
* - duplicates all projects items
* - adjusts..
*   - name, short-name, status
* - opens a projEdit to finetune the settings.
*/
function projNewFromTemplate() {

    global $PH;
    global $auth;

    $count_items=0;

    $project_id= getOnePassedId('prj','projects_*'); # aborts on failure

    /**
    * get project, just to be sure rights are ok
    */
    if(!$org_project= Project::getVisibleById($project_id)) {

        $PH->abortWarning("could not get Project");
        return;
    }

    if(!$new_project = projDuplicate($project_id)) {
        $PH->abbortWarning("duplicating project failed.", ERROR_DATASTRUCTURE);
        return;
    }
    $new_project->status= STATUS_NEW;


    ### remove  template-string ###
    $matches= array();
    if(preg_match("/- (.*) ".__("Template","as addon to project-templates")."/", $new_project->name,$matches)) {
        if(count($matches)==2) {
            $new_project->name = $matches[1];
        }
    }

    $PH->show('projEdit',array('prj'=>$new_project->id),$new_project);
}


/**
* duplicate a project including all belonging items (tasks, efforts, etc.)
*
* - This function is a massive database-process and should be protected
*   from parallel database accesses. Failure of this procedure can lead to
*   inconsistent db-structures. Maybe we should add a db-structure validation
*   somewhere
* - all items (even the already deleted) are duplicated because there might
*   be some relationships (like effort on an deleted task, is still an effort)
* - does NOT change the name of the project. The caller has to change this to "copy of ..."
*
* returns...
*    - On Success: new project-object (which has already been added to db) for fine
*      tuning of fields.
*    - On Failure: NULL (error's have been triggered)
*/
function projDuplicate($org_project_id=NULL)
{
    require_once(confGet('DIR_STREBER') . "db/class_effort.inc.php");
    require_once(confGet('DIR_STREBER') . "db/class_file.inc.php");
    require_once(confGet('DIR_STREBER') . "db/class_issue.inc.php");

    global $PH;
    global $auth;

    $count_items=0;

    if(!$org_project_id) {
        trigger_error("projDuplicate() called without project-id",E_USER_WARNING);
        return;
    }

    /**
    * normally the project-id is already been checked by caller, but just to be sure...
    */
    if(!$org_project= Project::getEditableById($org_project_id)) {
        trigger_error("could not get Project",E_USER_NOTICE);
        return;
    }

    /**
    * @Warning: getting the project a second time might give a reference to
    * the first one. Since caching of project-requests has not yet be activated
    * this works for now. Later be sure to use array_clone().
    */
    if(!$new_project= Project::getEditableById($org_project_id)) {
        trigger_error("could not get Project", E_USER_NOTICE);
        return;
    }


    ### duplicate project ###
    $new_project->id=0;

    $new_project->created_by= $auth->cur_user->id;
    $new_project->modified_by= $auth->cur_user->id;
    $new_project->date_start= getGMTString();
    $new_project->status= 3;    #@@@ avoid majic numbers

    $new_project->state=1;      # be sure project is no deleted
    if(!$new_project->insert()) {
        trigger_error("Failed to insert new project. Datastructure might have been corrupted", E_USER_WARNING);
        return;
    }


    $flag_cur_user_in_project=false;

    ### copy projectpersons ###
    if($org_ppersons= $org_project->getProjectPersons(
                                     NULL,  # $order_by=NULL,
                                     false, # $alive_only=true,
                                     false  # $visible_only= true
    )){
        foreach($org_ppersons as $pp){
            $pp->id=0;
            $pp->project= $new_project->id;

            ### make current user project admin ###
            if($pp->person == $auth->cur_user->id) {

                $pp->initWithUserProfile(PROFILE_ADMIN);
                $flag_cur_user_in_project= true;
            }

            if(!$pp->insert()) {
                trigger_error(__("Failed to insert new project person. Data structure might have been corrupted"),E_USER_WARNING);
                return;
            }
            $count_items++;
        }
    }


    ### be sure, current user is admin ###
    if(!$flag_cur_user_in_project) {
        $pp_new= new ProjectPerson(array(
            'id'        =>0,
            'person'    =>$auth->cur_user->id,
            'project'   =>$new_project->id,
        ));
        $pp_new->initWithUserProfile(PROFILE_ADMIN);
        if(!$pp_new->insert()) {
            trigger_error(__("Failed to insert new project person. Data structure might have been corrupted"),E_USER_WARNING);
            return;
        }
    }


    ### copy issues ###
    $dict_issues=array(0=>0);

    $org_issues= $org_project->getIssues(NULL,false,false);

    foreach($org_issues as $i) {

        $org_issue_id= $i->id;

        $i->project= $new_project->id;
        $i->id =0;
        if(!$i->insert()) {
            trigger_error(__("Failed to insert new issue. DB structure might have been corrupted."),E_USER_WARNING);
            return;
        }

        $count_items++;
        $dict_issues[$org_issue_id]= $i->id;
    }


    ### copy tasks
    {
        ### pass1 ###
        $dict_tasks=array(0=>0);    # assoc array of old / new task-ids

        $new_tasks=array();

        if($org_tasks= $org_project->getTasks(array(
            'show_folders'  =>true,
            'status_min'    =>0,
            'status_max'    =>10,
            'visible_only'  =>false,
            'alive_only'    =>false,
            ))) {
            foreach($org_tasks as $t) {

                $org_task_id= $t->id;
                $t->id= 0;
                $t->project= $new_project->id;
                if(!isset($dict_issues[$t->issue_report])) {
                    trigger_error("undefined issue-id $t->issue_report. DB structure might have been corrupted.", E_USER_NOTICE);
                }
                else {
                    $t->issue_report = $dict_issues[$t->issue_report];
                }

                if(!$t->insert()) {
                    trigger_error("Failed to insert new task. DB structure might have been corrupted.",E_USER_WARNING);
                    return;
                }

                $count_items++;
                $dict_tasks[$org_task_id]= $t->id;
                $new_tasks[]=$t;
            }
        }

        ### pass2: tasks / parent_task ###
        foreach($new_tasks as $nt) {
            if(isset($dict_tasks[$nt->parent_task])) {
                $nt->parent_task= $dict_tasks[$nt->parent_task];
            }
            else {
                trigger_error("undefined task-id $nt->parent_task",E_USER_WARNING);
            }
            if(!$nt->update()) {
                trigger_error(__("Failed to update new task. DB structure might have been corrupted."),E_USER_WARNING);
                return;
            }
        }
    }


    ### copy efforts ###
    $dict_efforts=array(0 => 0);

    if($org_efforts= Effort::getAll(array(
        'project'       => $org_project->id,
        'visible_only'  => false,
        'alive_only'    => false
    ))) {
        foreach($org_efforts as $e) {

            $org_effort_id= $e->id;

            if(isset($dict_tasks[$e->task])) {
                $e->task= $dict_tasks[$e->task];
            }
            else {
                trigger_error("undefined task-id $e->task", E_USER_NOTICE);
            }
            $e->id= 0;
            $e->project= $new_project->id;
            if(!$e->insert()) {
                trigger_error("Failed to insert new effort. DB structure might have been corrupted.",E_USER_WARNING);
                return;
            }

            $count_items++;
            $dict_efforts[$org_effort_id]= $e->id;
        }
    }

    ### copy task_assigments ###
    $dict_taskpersons=array(0 => 0);                        # this hash is not required

    if($org_taskpersons= $org_project->getTaskPersons(
                                      "",  # $order_by=NULL,
                                      false,  # $visible_only=true,
                                      false  # $alive_only=true
    )) {
        foreach($org_taskpersons as $tp) {

            $org_taskperson_id= $tp->id;

            if(isset($dict_tasks[$tp->task])) {
                $tp->task= $dict_tasks[$tp->task];
            }
            else {
                trigger_error("undefined task-id $e->task", E_USER_WARNING);
            }

            $tp->id= 0;
            $tp->project= $new_project->id;
            if(!$tp->insert()) {
                trigger_error("Failed to insert new taskperson. DB structure might have been corrupted.",E_USER_WARNING);
                return;
            }

            $count_items++;
            $dict_taskpersons[$org_taskperson_id]= $tp->id;
        }
    }

    ### copy comments ###
    {
        $dict_comments=array(0 => 0);
        $new_comments=array();

        if($org_comments= $org_project->getComments(
                                            "",      # $order_by=NULL,
                                            false,   # $visible_only=true,
                                            false    # $alive_only=true
        )) {
            foreach($org_comments as $c) {

                $org_comment_id= $c->id;


                if(isset($dict_tasks[$c->task])) {
                    $c->task= $dict_tasks[$c->task];
                }
                if(isset($dict_efforts[$c->effort])) {
                    $c->effort= $dict_efforts[$c->effort];
                }
                if(isset($dict_effort[$c->effort])){
                    $c->effort= $dict_efforts[$c->effort];
                }

                $c->id= 0;
                $c->project = $new_project->id;

                if(!$c->insert()) {
                    trigger_error(__("Failed to insert new comment. DB structure might have been corrupted."),E_USER_WARNING);
                    return;
                }

                $count_items++;

                $dict_comments[$org_comment_id]= $c->id;
                $new_comments[]=$c;
            }
        }

        ### pass2: comment / on comment ###
        foreach($new_comments as $nc) {
            $nc->comment= $dict_comments[$nc->comment];
            if(!$nc->update()) {
                trigger_error("Failed to update new comment. DB structure might have been corrupted.",E_USER_WARNING);
                return;
            }
        }
    }

    #new FeedbackMessage(sprintf(__("Project duplicated (including %s items)"), $count_items));
    #if(!$new_project->insert()) {
    #    trigger_error("Inserting new project failed. DB structure might have been corrupted.", E_USER_WARNING);
    #    return;
    #}
    return $new_project;
    #$PH->show('projEdit',array('prj'=>$new_project->id),$new_project);
}



function projViewAsRSS()
{    
    require_once(confGet('DIR_STREBER') . "std/class_rss.inc.php");
    
    global $PH;
    global $auth;

    $project_id= getOnePassedId('prj','projects_*'); # aborts on failure
    
    if(!$project= Project::getVisibleById($project_id)) {
        echo "Project is not readable. Anonymous user active?";
        exit();
    }


    ### used cached? ###
    $filepath = "_rss/proj_$project->id.xml";
    if(file_exists($filepath) || getGMTString(filemtime($filepath)) ."<". $project->modified) {
        RSS::updateRSS($project);
    }
    readfile_chunked($filepath);

    exit();    
}




?>
