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
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_project_team.inc.php');

/**
* build the page-links under home
*/
function build_home_options()
{
    return array(

        new NaviOption(array(
                'target_id'=>'home',
                'name'=>__('Today')
            )),
            new NaviOption(array(
                'target_id'     =>'homeAllChanges',
                'name'=>__('Changes'),
            ))
    );
}




/**
* render home view @ingroup pages
*/
function home() {
    global $PH;
    global $auth;

    ### create from handle ###
    $PH->defineFromHandle(array());

    ### set up page ####
    {
        $page= new Page();
        $page->cur_tab='home';
        $page->options=build_home_options();

        $page->title=__("Today"); # $auth->cur_user->name;
        $page->type=__("At Home");
        $page->title_minor=renderTitleDate(time());
        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);
    measure_stop('init2');


    #--- functions block ------------
    {
        $block=new PageBlock(array(
            'title' =>__('Functions'),
            'id'    =>'functions'
        ));
        $block->render_blockStart();
        echo "<div class=text>";

        ### write functions ###
        $function_links=array();
        $function_links[]=$PH->getLink('projNew','',array());
        $function_links[]=$PH->getLink('companyNew','',array());
        $function_links[]=$PH->getLink('personNew','',array());
        $function_links[]=$PH->getLink('personViewEfforts',__('View your efforts'),array('person'=>$auth->cur_user->id));
        $function_links[]=$PH->getLink('personEdit',__('Edit your profile'),array('person'=>$auth->cur_user->id));
        $function_links[]=$PH->getLink('personAllItemsViewed','',array('person' => $auth->cur_user->id));

        if($function_links) {

            echo "<ul>";
            foreach($function_links as $f){
                if($f) {
                    echo "<li>$f" ;
                }
            }
            echo "</ul>";
        }
        echo "</div>";

        $block->render_blockEnd();
    }

    #--- list projects --------------------------------------------------------
    {
        require_once(confGet('DIR_STREBER') . 'lists/list_projects.inc.php');
        #$projects=Project::getActive($order_str);
        $list= new ListBlock_projects();
        $list->reduced_header= true;

        unset($list->functions['projNewFromTemplate']);
        unset($list->columns['status']);
        unset($list->columns['persons']);
        unset($list->columns['status_summary']);
        unset($list->columns['efforts']);
        unset($list->columns['date_start']);
        unset($list->columns['date_closed']);
        $list->show_functions=false;
        $list->title=__('Projects');
        $list->reduced_header= false;

        $list->query_options['status_min']= STATUS_UPCOMING;
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

    echo(new PageContentNextCol);

    #--- list tasks -------------------------------------------------------------
    if($show_tasks = $auth->cur_user->show_tasks_at_home) {
        measure_start('get_tasks');

        $order_str=get('sort_'.$PH->cur_page->id.'_home_tasks');
        $tasks= Task::getHomeTasks($order_str);

        measure_stop('get_tasks');
        measure_start('list_tasks');


        $list_tasks= new ListBlock(array(
            'id' => 'tasks'
        ));
        $list_tasks->show_functions=false;
        $list_tasks->no_items_html=__("You have no open tasks");

        switch($show_tasks) {
            case SHOW_NOTHING:
            case SHOW_ASSIGNED_ONLY:
                $list_tasks->title=__("Open tasks assigned to you");
                break;
            case SHOW_ALSO_UNASSIGNED:
                $list_tasks->title=__("Open tasks (including unassigned)");
                break;
            case SHOW_ALL_OPEN:
                $list_tasks->title=__("All open tasks");
                break;

            default:
                trigger_error("Undefined value '$show_tasks' for show tasks at home", E_USER_WARNING);
        }

        #--- columns ---
        $list_tasks->add_col( new ListBlockColSelect());
        #$list_tasks->add_col( new ListBlockCol(array(
        #   'key'=>'_select_col_',
        #   'name'=>"S",
        #   'tooltip'=>__("Select lines to use functions at end of list"),
        #)));
        $list_tasks->add_col( new ListBlockColPrio(array(
            'key'=>'prio',
            'name'=>__('P','column header'),
            'tooltip'=>__('Priority'),
            'sort'=>1,
            'width'=>1,
        )));
        #$list_tasks->add_col( new ListBlockColStatus(array(
        #   'key'=>'status',
        #   'name'=>__('S','column header'),
        #   'tooltip'=>__('Task-Status'),
        #   'sort'=>0,
        #    'width'=>1,
        #)));
        $list_tasks->add_col( new ListBlockCol_TaskLabel);
        $list_tasks->add_col(new ListBlockColMethod(array(
            'key'=>'project',
            'name'=>__('Project','column header'),
            'func'=>'getProjectLink'
        )));
        $list_tasks->add_col(new ListBlockColMethod(array(
            'key'=>'parent_task',
            'name'=>__('Folder','column header'),
            'func'=>'getFolderLinks',
            'width'=>'30%'
        )));
        /*$list_tasks->add_col( new ListBlock_ColHtml(array(
            'key'=>'name',
            'name'=>"Task",
            'tooltip'=>"Task name. More Details as tooltips",
            'width'=>'90%',
            'sort'=>0,
            'format'=>'<a href="index.php?go=taskView&tsk={?id}">{?name}</a>'
        )));*/

        $list_tasks->add_col( new ListBlockCol_TaskName);
        #$list_tasks->add_col( new ListBlockCol_TaskCreatedBy(array('use_short_names'=>false,'indention'=>true)));

        $list_tasks->add_col( new listBlockColDate(array(
            'key'=>'modified',
            'name'=>__('Modified','column header')
        )));



        $list_tasks->add_col( new ListBlockCol_DaysLeft);
        #$list_tasks->add_col( new ListBlockColTime(array(
        #   'key'=>'estimated',
        #   'name'=>__('Est.','column header estimated time'),
        #   'tooltip'=>__('Estimated time in hours'),
        #)));

        /* functions don't work
        $list_tasks->add_col( new ListBlockColFormat(array(
            'name'=>"FN",
            'tooltip'=>"Function for tasks.",
            'width'=>'1',
            'sort'=>0,
            'format'=>'<nobr><a href="index.php?go=tasksDelete&tsk={?id}" title="Delete this task"> X </a>'.
            '<a href="index.php?go=taskEdit&tsk={?id}" title="Edit this task"> E </a>'.
            '<a href="index.php?go=tasksComplete&tsk={?id}" title="Mark as done"> � </a></nobr>'
        )));
        */

        #--- functions -------
        $list_tasks->add_function(new ListFunction(array(
            'target'=>$PH->getPage('taskEdit')->id,
            'name'  =>__('Edit','context menu function'),
            'id'    =>'taskEdit',
            'icon'  =>'edit',
            'context_menu'=>'submit',
        )));
        $list_tasks->add_function(new ListFunction(array(
            'target'=>$PH->getPage('tasksComplete')->id,
            'name'  =>__('status->Completed','context menu function'),
            'id'    =>'tasksCompleted',
            'icon'  =>'complete',
            'context_menu'=>'submit',
        )));

        $list_tasks->add_function(new ListFunction(array(
            'target'=>$PH->getPage('tasksApproved')->id,
            'name'  =>__('status->Approved','context menu function'),
            'id'    =>'tasksApproved',
            'icon'  =>'approve',
            'context_menu'=>'submit',
        )));

        $list_tasks->add_function(new ListFunction(array(
            'target'=>$PH->getPage('tasksClosed')->id,
            'name'  =>__('status->Closed','context menu function'),
            'id'    =>'tasksClosed',
            'icon'  =>'close',
            'context_menu'=>'submit',
        )));

        /*
        $list_tasks->add_function(new ListFunction(array(
            'target'=>$PH->getPage('tasksDelete')->id,
            'name'  =>__('Delete','context menu function'),
            'id'    =>'tasksDelete',
            'icon'  =>'delete',
            'context_menu'=>'submit',
        )));
        */
        $list_tasks->add_function(new ListFunction(array(
            'target'=>$PH->getPage('effortNew')->id,
            'name'  =>__('Log hours for select tasks','context menu function'),
            'id'    =>'effortNew',
            'icon'    =>'loghours',
            'context_menu'=>'submit'
        )));


        $list_tasks->render_header();
        if($tasks || !$list_tasks->no_items_html) {
            $list_tasks->render_thead();
            if($tasks) {
                $count_estimated=0;
                foreach($tasks as $t) {
                    $style="";
                    $style.=($t->category == TCATEGORY_FOLDER)
                        ?' isFolder'
                        :'';

                    ### done ###
                    if($t->status>3) {
                        $style.='isDone';
                    }
                    else {
                        $count_estimated+=$t->estimated/60/60 * 1.0;
                    }
                    $list_tasks->render_trow(&$t,$style);
                }
            }
            $list_tasks->summary=sprintf(__("%s tasks with estimated %s hours of work"),count($tasks),$count_estimated);
            $list_tasks->render_tfoot();
        }
        else {
            $list_tasks->render_tfoot_empty();
        }
        measure_stop('list_tasks');
    }

    ### list bookmarks ###
    {
        require_once(confGet('DIR_STREBER') . 'lists/list_bookmarks.inc.php');
        $list_bookmarks = new ListBlock_bookmarks();
        $list_bookmarks->print_automatic();
    }

    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}



/**
* list all changes on server @ingroup pages
*/
function homeAllChanges()
{
    global $PH;
    global $auth;

    ### create from handle ###
    //$PH->defineFromHandle();

    ### sets the presets ###
    $presets= array(
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
        ## today ##
        'today' => array(
            'name'=> __('today'),
            'filters'=> array(
                'today'   => array(
                    'id'        => 'today',
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
        ## yesterday ##
        'yesterday' => array(
            'name'=> __('yesterday'),
            'filters'=> array(
                'yesterday'   => array(
                    'id'        => 'yesterday',
                    'visible'   => true,
                    'active'    => true,
                    'factor'    => 1,
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
        ## 2 weeks ##
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
        )
    );

    ## set preset location ##
    $preset_location = 'homeAllChanges';

     ### get preset-id ###
    {
        $preset_id = 'last_two_weeks';                           # default value
        if($tmp_preset_id = get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id = $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_homeAllChanges_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id = get('STREBER_homeAllChanges_preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id = $tmp_preset_id;
            }
        }
    }

    ### create from handle ###
    $PH->defineFromHandle(array('preset_id'=>$preset_id));

    ### set up page ####

    $page= new Page();

    #$list = new ListBlock_AllChanges();
    require_once(confGet('DIR_STREBER') . 'lists/list_changes.inc.php');
    $list = new ListBlock_Changes();
    #$list->query_options['']
    #require_once(confGet('DIR_STREBER') . './lists/list_changes.inc.php');

    #$list= new ListBlock_changes();


    $list->filters[] = new ListFilter_changes();
    {
        $preset = $presets[$preset_id];
        foreach($preset['filters'] as $f_name=>$f_settings) {
            switch($f_name) {
                case 'last_logout':
                    $list->filters[]= new ListFilter_last_logout(array(
                        'value'=>$f_settings['value'],
                    ));
                    break;
                /*case 'today':
                    $list->filters[]= new ListFilter_today(array(
                        'value'=>$f_settings['value'],
                    ));
                    break;*/
                case 'today':
                    $list->filters[]= new ListFilter_min_week(array(
                        'value'=>$f_settings['value'], 'factor'=>0
                    ));
                    $list->filters[]= new ListFilter_max_week(array(
                        'value'=>$f_settings['value'],
                    ));
                    break;
                case 'yesterday':
                    $list->filters[]= new ListFilter_min_week(array(
                        'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
                    ));
                    $list->filters[]= new ListFilter_max_week(array(
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



    $page->cur_tab = 'home';
    $page->options = build_home_options();

    $page->title = __("Changes");
    $page->type = __('List','page type');
    $page->title_minor = renderTitleDate(time());

    echo(new PageHeader);
    echo (new PageContentOpen);

    $page->print_presets(array(
    'target' => $preset_location,
    'project_id' => '',
    'preset_id' => $preset_id,
    'presets' => $presets,
    'person_id' => ''));

    #echo(new PageContentNextCol);


    $list->print_automatic();

    echo (new PageContentClose);
    echo (new PageHtmlEnd);

}


?>