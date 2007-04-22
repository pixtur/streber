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
*
* @Note
* - The names are taken from the handle definition
*/
function build_home_options()
{
    return array(

        new NaviOption(array(
                'target_id'=>'home',
        )),
        new NaviOption(array(
            'target_id'     =>'homeTasks',
        )),

        new NaviOption(array(
            'target_id'     =>'homeBookmarks',
        )),

        new NaviOption(array(
            'target_id'     =>'homeEfforts',
        )),

        new NaviOption(array(
            'target_id'     =>'homeAllChanges',
        )),

    );
}


define('MAX_CHANGELINES_PER_PROJECT', 4);
define('MAX_CHANGELINES', 16);
define('MORE_CHANGELINES', 20);


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

        ### page functions ###
        $page->add_function(new PageFunction(array(
            'target' =>'personEdit',
            'params' =>array('person'=>$auth->cur_user->id),
            'icon'  =>'edit',
            'tooltip' =>__('Edit your profile'),
            'name'  =>__('Edit your Profile')
        )));

        ### page functions ###
        $page->add_function(new PageFunction(array(
            'target' =>'personAllItemsViewed',
            'params' =>array('person'=>$auth->cur_user->id),
            'icon'  =>'edit',
            'tooltip' =>__('Edit your profile'),
            'name'  =>__('Mark all items as viewed')
        )));        

        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);
    measure_stop('init2');


    #--- functions block ------------
    /*
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
        $function_links[]=$PH->getLink('homeEfforts',__('View your efforts'),array('person'=>$auth->cur_user->id));
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
    */

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


    #--- project dashboard ----
    {
        
        require_once(confGet('DIR_STREBER') . 'std/class_changeline.inc.php');
        
        #$list= new ListBlock_dashboard();
        #$list->print_automatic();


        $block=new PageBlock(array(
            'title' =>__('Recently changed projects'),
            'id'    =>'dashboard'
        ));
        $block->render_blockStart();

        if(!$projects= Project::getAll(array(
            'order_by' => 'modified DESC',
            'limit'     => MAX_CHANGELINES / MAX_CHANGELINES_PER_PROJECT,
            
        ))) {
            echo __("No active projects");
        }
        else {
            
            /**
            * first get all changelines for projects to filter out projects without changes
            */
            $projects_with_changes= array();    # array with projects
            $project_changes= array();          # hash with project id and changelist

            foreach($projects as $project) {
                
                /**
                * first query all unviewed changes
                */
                if($changes= ChangeLine::getChangeLines(array(
                    'not_modified_by'   => $auth->cur_user->id,
                    'project'           => $project->id,
                    'unviewed_only'     => false,
                    'limit'             => MAX_CHANGELINES + 1,      # increased by 1 to get "more link"
                    'limit_start'       => 0,
                    'type'              => ITEM_TASK,
                ))) {
                    $projects_with_changes[]= $project;
                    $project_changes[$project->id]= $changes;
                }
            }            
            
            
            $changelines_per_project= MAX_CHANGELINES_PER_PROJECT;
            if(count($projects_with_changes) < MAX_CHANGELINES / MAX_CHANGELINES_PER_PROJECT) {
                $changelines_per_project = MAX_CHANGELINES / count($projects_with_changes)  - 1;
            }

            /**
            * count printed changelines to keep size of list
            */
            $printed_changelines = 0;
            foreach($projects_with_changes as $project) {
                $changes= $project_changes[$project->id];

                echo '<h4>'.  $PH->getLink('projView', $project->name, array('prj'=>$project->id)) . "</h4>";

                echo "<ul id='changesOnProject_$project->id'>";
                $lines= 0;
                foreach($changes as $c) {
                    printChangeLine($c);

                    $printed_changelines++;
                    if($lines++ >= $changelines_per_project - 1) {
                        break;                            
                    };
                }
                echo "</ul>";
                if($lines <= count($changes)) {
                    echo "<p class=more>"
                    . "<a href='javascript:getMoreChanges($project->id, $lines, 20);' "
                    . '>'
                    . __('Show more')
                    . '</a>'
                    ."</p>";
                    
                }

                
                /**
                * limit number of projects
                */
                if($printed_changelines >= MAX_CHANGELINES - MAX_CHANGELINES_PER_PROJECT) {
                    break;
                }
            }            
        }
        $block->render_blockEnd();
    }

    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}


/**
* get recent changes for ajax request from home @ingroup pages
*
* @Params
* - prj
* - start
* - count
*/

function homeDashboardAjaxMore()
{
    require_once(confGet('DIR_STREBER') . 'std/class_changeline.inc.php');

    global $auth;
    header("Content-type: text/html; charset=utf-8");

    if(!$project= Project::getVisibleById(get('prj'))) {
        return;
    }
    $start= is_null(get('start'))
          ? 0
          : intval(get('start'));

    $count= is_null(get('count'))
          ? 20
          : intval(get('count'));
        
    /**
    * first query all unviewed changes
    */
    if($changes= ChangeLine::getChangeLines(array(
        'not_modified_by'   => $auth->cur_user->id,
        'project'           => $project->id,
        'unviewed_only'     => false,
        'limit'             => $count,
        'limit_start'       => $start,
        'type'              => ITEM_TASK,
    ))) {
        $lines= 0;
        foreach($changes as $c) {
            $lines ++;
            if($lines > $start + $count) {
                break;
            }

            if($lines <= $start) {
                continue;
            }
            printChangeLine($c);
        }
    }
}


/**
* writes a changeline as html
*/
function printChangeLine($c)
{
    echo '<li>' . $c->task->getLink(false);
    
    
    /**
    * not viewed
    */
    if($c->task) {
        if($new= $c->task->isChangedForUser()) {
            if($new == 1) {
                echo '<span class=new> (' . __('New') . ') </span>';
            }
            else {
                echo '<span class=new>  (' . __('Updated') . ') </span>';
            }
        }
    }
    
    echo "<span class=sub>$c->txt_what";
    
    if($person= Person::getVisibleById($c->person_by)) {
        echo ' ' . __('by') . ' <span class=person>' . asHtml($person->name) ."</span>";
    }
    echo ' ' . renderTimeAgo($c->timestamp);
    
    echo "</span>";
    
    echo '</li>';    
    return;
}



/**
* render bookmarks @ingroup pages
*/
function homeBookmarks() 
{
    global $PH;
    global $auth;

    ### create from handle ###
    $PH->defineFromHandle(array());

    ### set up page ####
    {
        $page= new Page();
        $page->cur_tab='home';
        $page->options=build_home_options();

        $page->title=__("Your Bookmarks"); # $auth->cur_user->name;
        $page->type=__("At Home");
        echo(new PageHeader);
    }
    echo (new PageContentOpen);
    measure_stop('init2');

    ### list bookmarks ###
    {
        require_once(confGet('DIR_STREBER') . 'lists/list_bookmarks.inc.php');
        $list_bookmarks = new ListBlock_bookmarks();
        $list_bookmarks->reduced_header = true;
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




/**
* list all tasks assigned to person @ingroup pages
*/
function homeTasks()
{
    global $PH;
    global $auth;

    ### set up page ####
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
	$preset_location = 'homeTasks';

    ### get preset-id ###
    {
        $preset_id= 'open_tasks';                           # default value
        if($tmp_preset_id= get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_homeTasks_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id= get('STREBER_homeTasks_preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }
        }
    }


    $page= new Page();

    ### init known filters for preset ###
    $list= new ListBlock_tasks(array(
        'active_block_function'=>'list',

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


    ### create from handle ###
    $PH->defineFromHandle(array('preset_id'=>$preset_id));


    ### setup page details ###
    $page->cur_tab = 'home';
    $page->options = build_home_options();

    $page->title = __("Your Tasks");
    $page->type = __('List','page type');
    $page->title_minor = renderTitleDate(time());

    echo(new PageHeader);
    echo (new PageContentOpen);

    $page->print_presets(array(
        'target'        => $preset_location,
        'project_id'    => '',
        'preset_id'     => $preset_id,
        'presets'       => $presets,
        'person_id'     => ''
    ));

    ### remove assigned column (we know, who they are assigned to) ###
    unset($list->columns['assigned_to']);
    unset($list->columns['efforts']);
    unset($list->columns['project']);
    unset($list->columns['pub_level']);
    unset($list->columns['planned_start']);
    unset($list->block_functions['tree']);

    $list->print_automatic();

    echo (new PageContentClose);
    echo (new PageHtmlEnd);

}




/**
* display efforts for current user  @ingroup pages
*
* @NOTE 
* - actually this is an excact copy for personViewEfforts
* - this is of course not a good solution, but otherwise the breadcrumbs would change
*
*/
function homeEfforts()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
    require_once(confGet('DIR_STREBER') . 'lists/list_efforts.inc.php');

    
    ### get current project ###
    $person= $auth->cur_user;
        
    $presets= array(
        ### all ###
        'all_efforts' => array(
            'name'=> __('all'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_NEW,
                    'max'       => EFFORT_STATUS_BALANCED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),

        ### new efforts ###
        'new_efforts' => array(
            'name'=> __('new'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_NEW,
                    'max'       => EFFORT_STATUS_NEW,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### open efforts ###
        'open_efforts' => array(
            'name'=> __('open'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_OPEN,
                    'max'       => EFFORT_STATUS_OPEN,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### discounted efforts ###
        'discounted_efforts' => array(
            'name'=> __('discounted'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_DISCOUNTED,
                    'max'       => EFFORT_STATUS_DISCOUNTED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### not chargeable efforts ###
        'notchargeable_efforts' => array(
            'name'=> __('not chargeable'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_NOTCHARGEABLE,
                    'max'       => EFFORT_STATUS_NOTCHARGEABLE,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### balanced efforts ###
        'balanced_efforts' => array(
            'name'=> __('balanced'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_BALANCED,
                    'max'       => EFFORT_STATUS_BALANCED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
    );

    ## set preset location ##
    $preset_location = 'homeEfforts';
    
    ### get preset-id ###
    {
        $preset_id= 'all_efforts';                           # default value
        if($tmp_preset_id= get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_homeEfforts_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id= get('STREBER_homeEfforts_preset')) {
            if(isset($presets[$tmp_preset_id])) {

                $preset_id= $tmp_preset_id;
            }
        }
    }
    ### create from handle ###
    $PH->defineFromHandle(array('person'=>$person->id, 'preset_id' =>$preset_id));

    ### set up page ####
    {
        $page= new Page();
        $page->cur_tab='home';
        $page->title=__("Your efforts");
        $page->title_minor=__('Efforts','Page title add on');
        $page->type=__("Person");

        #$page->crumbs = build_person_crumbs($person);
        $page->options= build_home_options($person);

        echo(new PageHeader);
    }
    echo (new PageContentOpen);



    #--- list efforts --------------------------------------------------------------------------
    {
        $order_by=get('sort_'.$PH->cur_page->id."_efforts");

        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
        /*$efforts= Effort::getAll(array(
            'person'    => $person->id,
            'order_by'  => $order_by,
        ));*/

        $list= new ListBlock_efforts();
        unset($list->functions['effortNew']);
        unset($list->functions['effortNew']);
        $list->no_items_html= __('no efforts yet');
        
        $list->filters[] = new ListFilter_efforts();
        {
            $preset = $presets[$preset_id];
            foreach($preset['filters'] as $f_name=>$f_settings) {
                switch($f_name) {
                    case 'effort_status':
                        $list->filters[]= new ListFilter_effort_status_min(array(
                            'value'=>$f_settings['min'],
                        ));
                        $list->filters[]= new ListFilter_effort_status_max(array(
                            'value'=>$f_settings['max'],
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
        
        $page->print_presets(array(
        'target' => $preset_location,
        'project_id' => '',
        'preset_id' => $preset_id,
        'presets' => $presets,
        'person_id' => $person->id));
        
        $list->query_options['order_by'] = $order_by;
        $list->query_options['person'] = $person->id;
        $list->print_automatic();
        
        //$list->render_list(&$efforts);
    }
    
    echo '<input type="hidden" name="person" value="'.$person->id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}
?>