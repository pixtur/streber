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
* list active projects @ingroup pages
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

        if($auth->cur_user->user_rights & RIGHT_PROJECT_CREATE) {

            ### page functions ###
            $page->add_function(new PageFunctionGroup(array(
                    'name'      => __('New project from')
                )));
        
            $page->add_function(new PageFunction(array(
                'target'=> 'projListTemplates',
                'name'  => __("template"),
                'icon'  => 'new',
            )));
            $page->add_function(new PageFunction(array(
                'target'=> 'projNew',
                'name'  => __("scratch"),
                'icon'  => 'new',
            )));
        }
    
        ### render title ###
        echo(new PageHeader);



    }
    echo (new PageContentOpen);

    #--- list projects --------------------------------------------------------
    {

        #$projects=Project::getActive($order_str);
        $list= new ListBlock_projects();

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


/**
* List closed Projects @ingroup pages
*/
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


/**
* List project templates @ingroup pages
*/
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
* list changes of a project @ingroup pages
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
    require_once(confGet('DIR_STREBER') . './lists/list_changes.inc.php');
    $page= new Page();
    $list = new ListBlock_changes();
    $list->query_options['project']= $project->id;

    $list->filters[] = new ListFilter_changes();
    {
        $preset = $presets[$preset_id];
        foreach($preset['filters'] as $f_name=>$f_settings) {
            switch($f_name) {
                case 'task_status':
                    $list->filters[]= new ListFilter_status_min(array(
                        'value'=>$f_settings['min'],
                    ));
                    #$list->filters[]= new ListFilter_status_max(array(
                    #    'value'=>$f_settings['max'],
                    #));
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
                    #$list->filters[]= new ListFilter_max_week(array(
                    #   'value'=>$f_settings['value'],
                    #));
                    break;
                case 'last_two_weeks':
                    $list->filters[]= new ListFilter_min_week(array(
                        'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
                    ));
                    #$list->filters[]= new ListFilter_max_week(array(
                    #   'value'=>$f_settings['value'],
                    #));
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
        'presets' => $presets,
        'person_id' => ''));

    #echo(new PageContentNextCol);

    #--- list changes --------------------------------------------------------------------------
    {
        $list->print_automatic($project);
    }



    ### HACKING: 'add new task'-field ###
    $PH->go_submit='taskNew';
    echo '<input type="hidden" name="prj" value="'.$id.'">';

    #echo "<a href=\"javascript:document.my_form.go.value='tasksMoveToFolder';document.my_form.submit();\">move to task-folder</a>";
    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}



/**
* list documentation of a project @ingroup pages
*/
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
        $page->title_minor= __("Topics");

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
        if($project->isPersonVisibleTeamMember($auth->cur_user))  {
            $page->add_function(new PageFunction(array(
                'target'    =>'taskNew',
                'params'    =>array('prj'=>$project->id, 'task_category'=>TCATEGORY_DOCU, 'task_show_folder_as_documentation'=>1),
                'icon'      =>'new',
                'tooltip'   =>__('Create a new page'),
                'name'      =>__('New topic')
            )));
        }
    
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
        $list->title= __('Topics');

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

        ### redefine list functions ###
        unset($list->functions['taskNew']);
        unset($list->functions['taskNewBug']);
        unset($list->functions['tasksCompleted']);
        unset($list->functions['tasksApproved']);
        unset($list->functions['tasksClosed']);
        if(! ($project->settings & PROJECT_SETTING_ENABLE_EFFORTS)) {
            unset($list->functions['effortNew']);
        }
        #unset($list->functions['commentNew']);


        $list->no_items_html= __('No topics yet');
        $list->print_automatic($project, NULL, false);
    }

    $PH->go_submit='taskNew';
    echo '<input type="hidden" name="prj" value="'.$id.'">';


    #echo "<a href=\"javascript:document.my_form.go.value='tasksMoveToFolder';document.my_form.submit();\">move to task-folder</a>";
    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}




/**
* list files attached to project @ingroup pages
*/
function ProjViewFiles()
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


        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### upload files ###
    if($project->isPersonVisibleTeamMember($auth->cur_user))  {
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
* project roadmap (list milestones) @ingroup pages
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
        if($project->isPersonVisibleTeamMember($auth->cur_user)) {
            if($auth->cur_user->id != confGet('ANONYMOUS_USER')) {
                $page->add_function(new PageFunction(array(
                    'target'=>'taskNewMilestone',
                    'params'=>array('prj'=>$project->id),
                    'icon'=>'new',
                )));
            }
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


        $list->print_automatic($project);
    }
    echo '<input type="hidden" name="prj" value="'.$id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}



/**
* List efforts booked for a Project  @ingroup pages
*/
function ProjViewEfforts()
{
    global $PH;
    global $auth;
    
    require_once(confGet('DIR_STREBER') . "lists/list_efforts.inc.php");
    require_once(confGet('DIR_STREBER') . "lists/list_effortsperson.inc.php");
    require_once(confGet('DIR_STREBER') . "lists/list_effortstask.inc.php");

    
    ### get current project ###
    $id=getOnePassedId('prj','projects_*');
    if(!$project=Project::getVisibleById($id)) {
        $PH->abortWarning("invalid project-id");
        return;
    }
    
    $presets= array(
        ### all ###
        'all_efforts' => array(
            'name'=> __('all','Filter preset'),
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
            'name'=> __('new','Filter preset'),
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
            'name'=> __('open','Filter preset'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_NEW,
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
            'name'=> __('discounted','Filter preset'),
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
            'name'=> __('not chargeable','Filter preset'),
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
            'name'=> __('balanced','Filter preset'),
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
        
        ## last logout ##
        'last_logout' => array(
            'name'=> __('last logout','Filter preset'),
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
            'name'=> __('1 week','Filter preset'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
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
            'name'=> __('2 weeks','Filter preset'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
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
        
        ## 3 weeks ##
        'last_three_weeks' => array(
            'name'=> __('3 weeks','Filter preset'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
                    'visible'   => true,
                    'active'    => true,
                    'factor'    => 21,
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
        
        ## 1 month ##
        'last_month' => array(
            'name'=> __('1 month','Filter preset'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
                    'visible'   => true,
                    'active'    => true,
                    'factor'    => 28,
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
        'prior' => array(
            'name'=> __('prior','Filter preset'),
            'filters'=> array(
                'prior'    => array(
                    'id'        => 'prior',
                    'visible'   => true,
                    'active'    => true,
                    'factor'    => 29,
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
    );

    ## set preset location ##
    $preset_location = 'projViewEfforts';
    
    ### get preset-id ###
    {
        $preset_id= 'all_efforts';                           # default value
        if($tmp_preset_id= get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_projViewEfforts_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id= get('STREBER_projViewEfforts_preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }
        }
    }

    ### create from handle ###
    $PH->defineFromHandle(array(
        'prj'      =>$project->id,
        'preset_id' =>$preset_id
    ));
    
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
        if($project->isPersonVisibleTeamMember($auth->cur_user)) {
            $page->add_function(new PageFunction(array(
                'target'    => 'effortNew',
                'params'    => array('prj'=>$project->id),
                'icon'      => 'new',
                'name'      => __('new Effort'),
            )));
        }
        
        $page->add_function(new PageFunction(array(
            'target'    => 'projViewEffortCalculations',
            'params'    => array('prj'=>$project->id),
            'name'      => __('View calculation'),
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
        
        $list->filters[] = new ListFilter_efforts();
        {
            $preset = $presets[$preset_id];
            foreach($preset['filters'] as $f_name=>$f_settings) {
                switch($f_name) {
                    case 'effort_status':
                        $list->filters[]= new ListFilter_effort_status_min(array(
                            'value'=>$f_settings['min'],
                        ));
                        $val1 = $f_settings['min'];
                        $list->filters[]= new ListFilter_effort_status_max(array(
                            'value'=>$f_settings['max'],
                        ));
                        $val2 = $f_settings['max'];
                        break;
                    case 'last_logout':
                        $list->filters[]= new ListFilter_last_logout(array(
                            'value'=>$f_settings['value'],
                        ));
                        break;
                    case 'last_weeks':
                        $list->filters[]= new ListFilter_min_week(array(
                            'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
                        ));
                        break;
                    case 'prior':
                        $list->filters[]= new ListFilter_max_week(array(
                            'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
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
        
        ### Link to start cvs export ###
        $format = get('format');
        if($format == FORMAT_HTML || $format == ''){
            $list->footer_links[]=  $PH->getCSVLink();
        }


        unset($list->columns['p.name']);
        
        $page->print_presets(array(
            'target' => $preset_location,
            'project_id' => $project->id,
            'preset_id' => $preset_id,
            'presets' => $presets,
            'person_id' => ''));
            
            
        $list->query_options['order_by'] = $order_by;
        $list->query_options['project'] = $project->id;
        $list->print_automatic();
    }
    
    
    ### 'add new task'-field ###
    $PH->go_submit='taskNew';
    echo '<input type="hidden" name="prj" value="'.$id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}

/**
* Effort calculations for a Project  @ingroup pages
*/
function projViewEffortCalculations()
{
    global $PH;
    global $auth;
    
    require_once(confGet('DIR_STREBER') . "lists/list_efforts.inc.php");
    require_once(confGet('DIR_STREBER') . "lists/list_effortsperson.inc.php");
    require_once(confGet('DIR_STREBER') . "lists/list_effortstask.inc.php");
    require_once(confGet('DIR_STREBER') . "lists/list_effortstaskcalculation.inc.php");
    require_once(confGet('DIR_STREBER') . "lists/list_effortspersoncalculation.inc.php");
    require_once(confGet('DIR_STREBER') . "lists/list_effortsprojectcalculation.inc.php");
    
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

        $page->title_minor= __("Effort calculations");
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

        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    if(($auth->cur_user->user_rights & RIGHT_VIEWALL) && ($auth->cur_user->user_rights & RIGHT_EDITALL)){
        #--- list effort summary on team members --------------------------------------------------------------------
        {
            $list_effort_person = new ListBlock_effortsPerson();
            $list_effort_person->query_options['project'] = &$project->id;
            $list_effort_person->print_automatic();
        }
        
        #--- list effort summary on tasks --------------------------------------------------------------------
        {
            $list_effort_tasks = new ListBlock_effortsTask();
            $list_effort_tasks->query_options['project'] = &$project->id;
            $list_effort_tasks->print_automatic();
        }
        
        #--- list cost overview on person --------------------------------------------------------------------
        {
            if((confGet('INTERNAL_COST_FEATURE'))){
                $list_effort_person_calc = new ListBlock_effortsPersonCalculation();
                $list_effort_person_calc->query_options['project'] = &$project->id;
                $list_effort_person_calc->print_automatic();
            }
        }
        
        #--- list cost overview on task --------------------------------------------------------------------
        {       
            if((confGet('INTERNAL_COST_FEATURE'))){
                $list_effort_tasks_calc = new ListBlock_effortsTaskCalculation();
                $list_effort_tasks_calc->query_options['project'] = &$project->id;
                $list_effort_tasks_calc->print_automatic();
            }
        }
        
        #--- list cost overview for project --------------------------------------------------------------------
        {       
            if((confGet('INTERNAL_COST_FEATURE'))){
                $list_effort_proj_calc = new ListBlock_effortsProjectCalculation();
                $list_effort_proj_calc->print_automatic($project);
            }
        }
    }
    
    ### 'add new task'-field ###
    $PH->go_submit='taskNew';
    echo '<input type="hidden" name="prj" value="'.$id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}

/**
* List released versions of a project @ingroup pages
*/
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

        $page->title_minor= __("Released versions");
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
        if($project->isPersonVisibleTeamMember($auth->cur_user)) {
            if($auth->cur_user->id != confGet('ANONYMOUS_USER')) {
                $page->add_function(new PageFunction(array(
                    'target'=>'taskNewVersion',
                    'params'=>array('prj'=>$project->id),
                    'icon'=>'new',
                    'name'=>__('New released Version'),
                )));
            }
        }

        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);


    ### list versions ###
    {

        $list= new ListBlock_versions();

        $list->query_options['project']= $project->id;


        $list->print_automatic($project);
    }


    ### list changes for upcoming version ###
    {

        if($tasks= Task::getAll(array(
            'project'           => $project->id,
            'status_min'        => STATUS_COMPLETED,
            'status_max'        => STATUS_CLOSED,
            'resolved_version'  => RESOLVED_IN_NEXT_VERSION,
            'resolve_reason_min'=> RESOLVED_DONE,                          # @@@ this is not the best solution (should be IS NOT)
        ))) {

            $block=new PageBlock(array(
                'title'=>__("Tasks resolved in upcoming version"),
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



/**
* Create a new project @ingroup pages
*/
function projNew() {
    global $PH;

    $company=get('company');

    ### build dummy form ###
    $newproject= new Project(array(
        'id'        => 0,
        'name'      => __('New project'),
        'state'     => 1,
        'company'   => $company,
        'pub_level' => 100,
        )
    );

    $PH->show('projEdit',array('prj'=>$newproject->id),$newproject);
}


/**
* Edit a project @ingroup pages
*/
function projEdit($project=NULL)
{
    global $PH;
    global $auth;
    require_once (confGet('DIR_STREBER')."db/class_company.inc.php");

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
        ));
        $block->render_blockStart();

        $form=new PageForm();
        $form->button_cancel=true;


        $form->add($project->fields['name']->getFormElement($project));


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

            $tab->add($project->fields['projectpage']->getFormElement($project));
            $tab->add($project->fields['date_start']->getFormElement($project));
            $tab->add($project->fields['date_closed']->getFormElement($project));

        }

        ### description ###
        {
            $tab_group->add($tab=new Page_Tab("description",__("Description")));

            $e= $project->fields['description']->getFormElement($project);
            $e->rows=20;
            $tab->add($e);

        }

        ### Display ###
        {
            global $g_project_setting_names;
            $tab_group->add($tab=new Page_Tab("tab3",__("Display")));
            $tab->add($project->fields['short']->getFormElement($project));
            $tab->add($project->fields['status_summary']->getFormElement($project));

            $tab->add(new Form_checkbox('PROJECT_SETTING_ENABLE_TASKS',         $g_project_setting_names[PROJECT_SETTING_ENABLE_TASKS], $project->settings & PROJECT_SETTING_ENABLE_TASKS));
            $tab->add(new Form_checkbox('PROJECT_SETTING_ENABLE_FILES',         $g_project_setting_names[PROJECT_SETTING_ENABLE_FILES], $project->settings & PROJECT_SETTING_ENABLE_FILES));
            $tab->add(new Form_checkbox('PROJECT_SETTING_ENABLE_BUGS',         $g_project_setting_names[PROJECT_SETTING_ENABLE_BUGS], $project->settings & PROJECT_SETTING_ENABLE_BUGS));
            $tab->add(new Form_checkbox('PROJECT_SETTING_ENABLE_EFFORTS',      $g_project_setting_names[PROJECT_SETTING_ENABLE_EFFORTS], $project->settings & PROJECT_SETTING_ENABLE_EFFORTS));
            $tab->add(new Form_checkbox('PROJECT_SETTING_ENABLE_MILESTONES',   $g_project_setting_names[PROJECT_SETTING_ENABLE_MILESTONES], $project->settings & PROJECT_SETTING_ENABLE_MILESTONES));
            $tab->add(new Form_checkbox('PROJECT_SETTING_ENABLE_VERSIONS',     $g_project_setting_names[PROJECT_SETTING_ENABLE_VERSIONS], $project->settings & PROJECT_SETTING_ENABLE_VERSIONS));
            $tab->add(new Form_checkbox('PROJECT_SETTING_ENABLE_NEWS',     $g_project_setting_names[PROJECT_SETTING_ENABLE_NEWS], $project->settings & PROJECT_SETTING_ENABLE_NEWS));
        }

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




/**
* Submit changes to a project @ingroup pages
*/
function projEditSubmit()
{
    global $PH;
    global $auth;


    log_message("projEditSubmit()", LOG_MESSAGE_DEBUG);

    ### Validate form integrity ###
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


    ### cancel ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('projView',array('prj'=>$project->id));
        }
        exit();
    }

    $project->validateEditRequestTime();

    log_message(" :edit request time validated()", LOG_MESSAGE_DEBUG);


    # retrieve all possible values from post-data
    # NOTE:
    # - this could be an security-issue.
    # - TODO: as some kind of form-edit-behaviour to field-definition
    foreach($project->fields as $f) {
        $name=$f->name;
        $f->parseForm($project);
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
            'PROJECT_SETTING_ENABLE_TASKS'          =>  PROJECT_SETTING_ENABLE_TASKS,
            'PROJECT_SETTING_ENABLE_BUGS'          =>  PROJECT_SETTING_ENABLE_BUGS,
            'PROJECT_SETTING_ENABLE_FILES'          =>  PROJECT_SETTING_ENABLE_FILES,
            'PROJECT_SETTING_ENABLE_EFFORTS'       =>  PROJECT_SETTING_ENABLE_EFFORTS,
            'PROJECT_SETTING_ENABLE_MILESTONES'    =>  PROJECT_SETTING_ENABLE_MILESTONES,
            'PROJECT_SETTING_ENABLE_VERSIONS'      =>  PROJECT_SETTING_ENABLE_VERSIONS,
            'PROJECT_SETTING_ENABLE_NEWS'           =>  PROJECT_SETTING_ENABLE_NEWS,
            'project_setting_only_pm_may_close'    =>  PROJECT_SETTING_ONLY_PM_MAY_CLOSE,
            
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
            exit();
        }
        else {
            $PH->show('projView',array('prj'=>$project->id));
            exit();
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


/**
* Delete a project @ingroup pages
*/
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
* Change status of a project @ingroup pages
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
* select new people from a list @ingroup pages
*
* userRights have been validated by pageHandler()
*
* \TODO add additional project-specific check here?
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
        $page= new Page(array('use_jscalendar'=>false));
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

        ### write list of people ###
        {
            ### build hash of already added person ###
            $pps= $project->getProjectPeople(array(
                'alive_only' => true,
                'visible_only' => false
            ));
            $pp_hash=array();
            foreach($pps as $pp) {
                $pp_hash[$pp->person]= true;
            }

            ### filter already added people ###
            $people = array();
        if($pers = Person::getPeople())
            {
                foreach($pers as $p) {
                    if(!isset($pp_hash[$p->id])) {
                         $people[]=$p;
                    }
                }
            }

            $list= new ListBlock_people();

            unset($list->columns['personal_phone']);
            unset($list->columns['office_phone']);
            unset($list->columns['mobile_phone']);
            unset($list->columns['companies']);
            unset($list->columns['changes']);
            unset($list->columns['last_login']);
            $list->functions=array();
            $list->no_items_html=__("Found no people to add. Go to `People` to create some.");

            $list->render_list($people);
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


/**
* Submit new teammember to a project @ingroup pages
*/
function projAddPersonSubmit()
{
    global $PH;

    require_once(confGet('DIR_STREBER') . "db/class_person.inc.php");

    $id= getOnePassedId('project','');
    if(!$project= Project::getEditableById($id)) {
        $PH->abortWarning("Could not get object...",ERROR_FATAL);
    }

    ### get people ###
    $person_ids= getPassedIds('person','people*');
    if(!$person_ids) {
        $PH->abortWarning(__("No people selected..."),ERROR_NOTE);
    }

    ### get team (including inactive members)  ###
    $ppeople= $project->getProjectPeople(array(
        'alive_only' => false,
        'visible_only' => false,
        'person_id' => NULL,
    ));
    

    ### go through selected people ###
    foreach($person_ids as $pid) {
        if(!$person= Person::getVisibleById($pid)) {
            $PH->abortWarning(__("Could not access person by id"));
            return;
        }

        #### person already employed? ###
        $already_in=false;
        $pp=NULL;
        foreach($ppeople as $pp) {
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
                'salary_per_hour'       => $person->salary_per_hour,
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
            new FeedbackMessage(sprintf(__("Reanimated person %s as team-member"), asHtml($person->name)));
        }
        ### skip ###
        else {
            new FeedbackMessage(sprintf(__("Person %s already in project"), asHtml($person->name)));
        }
    }
    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('projView',array('prj'=>$project->id));
    }
}


/**
* create template from existing project @ingroup pages
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
* create normal project from template @ingroup pages
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
* duplicate a project including all belonging items (tasks, efforts, etc.) @ingroup pages
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

    ### copy projectpeople ###
    if($org_ppeople= $org_project->getProjectPeople(array(
         'alive_only' => false, 
         'visible_only' => false
    ))){
        foreach($org_ppeople as $pp){
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
                $nt->for_milestone= $dict_tasks[$nt->for_milestone];
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
    $dict_taskpeople=array(0 => 0);                        # this hash is not required

    if($org_taskpeople= $org_project->getTaskPeople(
                                      "",  # $order_by=NULL,
                                      false,  # $visible_only=true,
                                      false  # $alive_only=true
    )) {
        foreach($org_taskpeople as $tp) {

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
            $dict_taskpeople[$org_taskperson_id]= $tp->id;
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



/**
* Show an RSS Feed of the latest changes on a project @ingroup pages
*/
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
