<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

/**\file 
* Define pages and there options
* 
* read more at...
* - http://www.streber-pm.org/3391
* - http://www.streber-pm.org/3392
*/

/**\defgroup pages Pages
*
* The framework splits user interaction into Pages which are defined as PageHandles in _handles.inc.php
*/


new PageHandle(array('id'=>'home',
    'req'=>'pages/home.inc.php',
    'title'=>__('Recent changes','Page option tab'),
    'test'=>'yes',

    'cleanurl'=>'home',
));
new PageHandle(array('id'=>'ajaxMoreChanges',
    'req'=>'pages/item_ajax.inc.php',
    'test'=>'no',
    'valid_for_crawlers'=>false,
    'valid_params'=> array('prj'=>'\d+', 'start'=>'\d+', 'count' => '\d+'),

));


new PageHandle(array('id'=>'homeTasks',
    'req'=>'pages/home.inc.php',
    'title'=>__('Your Tasks'),
    'test'=>'yes',
	
    'valid_for_crawlers'=>false,
));
new PageHandle(array('id'=>'homeBookmarks',
    'req'=>'pages/home.inc.php',
    'title'=>__('Bookmarks'),
    'test'=>'yes',
	
    'valid_for_crawlers'=>false,
));
new PageHandle(array('id'=>'homeEfforts',
    'req'=>'pages/home.inc.php',
    'title'=>__('Efforts'),
    'test'=>'yes',
	
    'valid_for_crawlers'=>false,
));


new PageHandle(array('id'=>'homeAllChanges',
    'req'=>'pages/home.inc.php',
    'title'=>__('Overall changes'),
    'test'=>'yes',
	
    'valid_for_crawlers'=>false,
));

new PageHandle(array('id'=>'playground',
    'req'=>'pages/playground.inc.php',
    'title'=>__('Playground'),
    'test'=>'no',

    'cleanurl'=>'playground',
    'valid_for_crawlers'=>false,
));


new PageHandle(array('id'=>'itemView',
    'req'=>'pages/item.inc.php',
    'title'=>__('View item'),
    'test'=>'yes',
    'valid_params'=>array('item'=>'\d+'),

    'cleanurl'=>'_ITEM_',
    'cleanurl_mapping'=>array('item' => '_ITEM_'),
));


new PageHandleFunc(array('id'=>'itemsSetPubLevel',
    'title'=>__('Set Public Level'),
    'req'=>'pages/item.inc.php',
    'test'=>'yes',
    'valid_params'=> array('item'=>'\d+', 'item_\d+'=>'\d+', 'from'=>'.*', 'item_pub_level' => '\d+'),
));

new PageHandleFunc(array('id'=>'itemsAsBookmark',
	'req'=>'pages/item.inc.php',
    'title'=>__('Mark as bookmark'),

    'test'=>'yes',
    'test_params'=>array('item'=>'_itemView_',),
));
new PageHandleFunc(array('id'=>'itemsRemoveBookmark',
	'req'=>'pages/item.inc.php',
    'title'=>__('Remove bookmark'),

    'test'=>'yes',
    'test_params'=>array('item'=>'_itemView_',),
));
new PageHandleFunc(array('id'=>'itemsSendNotification',
	'req'=>'pages/item.inc.php',
    'title'=>__('Send notification'),
    'test'=>'yes',
    'test_params'=>array('item'=>'_itemView_',),
));
new PageHandleFunc(array('id'=>'itemsRemoveNotification',
	'req'=>'pages/item.inc.php',
    'title'=>__('Remove notification'),
    'test'=>'yes',
    'test_params'=>array('item'=>'_itemView_',),
));
new PageHandleForm(array('id'=>'itemBookmarkEdit',
    'req'=>'pages/item.inc.php',
    'title'=>__('Edit bookmarks'),
	'valid_params'=>array(),
    'test'=>'yes',
    'test_params'=>array('id'=>'_ITEM_',),
));

new PageHandleSubm(array('id'=>'itemBookmarkEditSubmit',
    'req'=>'pages/item.inc.php',
    'valid_params'=>array(),
));

new PageHandleForm(array('id'=>'itemBookmarkEditMultiple',
    'req'=>'pages/item.inc.php',
    'title'=>__('Edit multiple bookmarks'),
	'valid_params'=>array(),
    'test'=>'yes',
    'test_params'=>array('id'=>'_ITEM_',),
));

new PageHandleSubm(array('id'=>'itemBookmarkEditMultipleSubmit',
    'req'=>'pages/item.inc.php',
    'valid_params'=>array(),
));

new PageHandle(array('id'=>'itemViewDiff',
    'req'=>'pages/item.inc.php',
    'title'=>__('view changes'),
    'valid_params'=>array(
           'from'=>'.*',
           'item'=>'\*',
           'date1'=>'\S*',
           'date2'=>'\S*',
    ),

    'test'=>'yes',
    'test_params'=>array('item'=>'_taskView_',),
    'valid_for_crawlers'=>false,
));


/**
* collector for global views like projList, personList, home, etc.
*/
new PageHandle(array('id'=>'globalView',
    'req'=>'pages/misc.inc.php',
    'test'=>'no',
    'valid_params'=>array('id'=>'\d+'),

    #'cleanurl'=>'_PAGE_',
    #'cleanurl_mapping'=>array('id' => '_ITEM_'),
));


/**
* project
*/
new PageHandle(array('id'=>'projList',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('Active Projects'),
    'valid_params'=>array(  'from'=>'.*', 'format'=>''
    ),
    'test'=>'yes',

));
new PageHandle(array('id'=>'projListClosed',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('Closed Projects'),
    'valid_params'=>array(  'from'=>'.*', 'format'=>''
    ),
    'test'=>'yes',

    'cleanurl' => 'projClosed',
    'valid_for_crawlers'=>false,
));
new PageHandle(array('id'=>'projListTemplates',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('Project Templates'),
    'rights_required'=>RIGHT_PROJECT_CREATE,
    'valid_params'=>array(  'from'=>'.*', 'format'=>''
    ),
    'test'=>'yes',
    'cleanurl' => 'projTemplates',
    'valid_for_crawlers'=>false,
));

new PageHandle(array('id'=>'projView',
    'req'=>'pages/project_view.inc.php',
    'title'=>__('View Project'),
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),

    'cleanurl'=>'_ITEM_',
    'cleanurl_mapping'=>array('prj'=>'_ITEM_'),

));
new PageHandle(array('id'=>'projViewAsRSS',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('View Project as RSS'),
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),
    'http_auth'=>true,                        # implements HTTP Authentification
));

new PageHandle(array('id'=>'projViewMilestones',
    'req'       =>'pages/project_more.inc.php',
    'title'     =>__('Milestones'),
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            'preset'=>'.*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),

));
new PageHandle(array('id'=>'projViewDocu',
    'req'       =>'pages/project_more.inc.php',
    'title'     =>__('Documentation'),
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),

));
new PageHandle(array('id'=>'projViewVersions',
    'req'       =>'pages/project_more.inc.php',
    'title'     =>__('Versions'),
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            'preset'=>'.*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),
));

new PageHandle(array('id'=>'projViewEfforts',
    'req'       =>'pages/project_more.inc.php',
    'title'     =>__('View Project'),
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
							'preset'=>'.*',
							'person'=>'.*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),
    'valid_for_crawlers'=>false,
));
new PageHandle(array('id'=>'projViewEffortCalculations',
    'req'       =>'pages/project_more.inc.php',
    'title'     =>__('View Project'),
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
							'preset'=>'.*',
							'person'=>'.*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),
    'valid_for_crawlers'=>false,
));
new PageHandle(array('id'=>'projViewFiles',
    'req'       =>'pages/project_more.inc.php',
    'title'     =>__('Uploaded Files'),
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),
));

new PageHandle(array('id'=>'projViewChanges',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('Changes'),
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
							'preset'=>'.*',
							'person'=>'.*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),
    'valid_for_crawlers'=>false,
));
new PageHandle(array('id'=>'projViewTasks',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('Tasks'),
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            'preset'=>'.*',
                            'for_milestone' => '\d*',
							'person' => '.*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),
));
new PageHandleFunc(array('id'=>'projNew',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('New project'),
    'rights_required'=>RIGHT_PROJECT_CREATE,
    'valid_params'=>array(  'from'=>'.*',
                            'company'=>'\d*',
                            ),
    'test'=>'yes',
    'valid_for_crawlers'=>false,
));
new PageHandleFunc(array('id'=>'projCreateTemplate',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('Create Template'),
    'rights_required'=>RIGHT_PROJECT_CREATE,
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            ),
    'valid_for_crawlers'=>false,
));
new PageHandleFunc(array('id'=>'projNewFromTemplate',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('Project from Template'),
    'rights_required'=>RIGHT_PROJECT_CREATE,
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            ),
    'valid_for_crawlers'=>false,
));


new PageHandleForm(array('id'=>'projEdit',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('Edit Project'),
    'rights_required'=>RIGHT_PROJECT_EDIT,
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectEdit_',),
    'valid_for_crawlers'=>false,
));
new PageHandleSubm(array('id'=>'projEditSubmit',
    'req'=>'pages/project_more.inc.php',
    'rights_required'=>RIGHT_PROJECT_EDIT,
    'valid_params'=>array(),
    'valid_for_crawlers'=>false,

));

new PageHandleFunc(array('id'=>'projDelete',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('Delete Project'),
    'rights_required'=>RIGHT_PROJECT_DELETE,
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            ),
    'valid_for_crawlers'=>false,
));
new PageHandleFunc(array('id'=>'projChangeStatus',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('Change Project Status'),
    'rights_required'=>RIGHT_PROJECT_EDIT,
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            ),
));
new PageHandleForm(array('id'=>'projAddPerson',
    'req'=>'pages/project_more.inc.php',
    'title'=>__('Add Team member'),
    'rights_required'=>RIGHT_PROJECT_EDIT,
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),
));
new PageHandleSubm(array('id'=>'projAddPersonSubmit',
    'req'=>'pages/project_more.inc.php',
    'rights_required'=>RIGHT_PROJECT_EDIT,
    'valid_params'=>array(),
));
new PageHandle(array('id'=>'projViewIssues',
    'req'=>'pages/project_more.inc.php',
    'valid_params'=>array(  'from'=>'.*',
                            'prj'=>'\d*',
                            ),
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),
));

/**
* team-members aka projectperson
*/
/*
* currently implemented with proj.inc->addPerson()
*
new PageHandleFunc(array('id'=>'projectPersonNew',
    'req'       =>'pages/projectperson.inc.php',
    'title'     =>__('Add Team member'),
    'rights_required'=>RIGHT_PROJECT_ASSIGN,
    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectView_',),
));
*/

new PageHandleForm(array('id'=>'projectPersonEdit',
    'req'       =>'pages/projectperson.inc.php',
    'title'     =>__('Edit Team member'),
    'rights_required'=>RIGHT_PROJECT_ASSIGN,
    'test'=>'yes',
    'test_params'=>array('projectperson'=>'_projectPersonEdit_',),
));
new PageHandleSubm(array('id'=>'projectPersonEditSubmit',
    'req'       =>'pages/projectperson.inc.php',
    'rights_required'=>RIGHT_PROJECT_ASSIGN,

));
new PageHandleFunc(array('id'=>'projectPersonDelete',
    'req'       =>'pages/projectperson.inc.php',
    'title'     =>__('Remove from team'),
    'rights_required'=>RIGHT_PROJECT_ASSIGN,

    'test'=>'complex',
    'test_params'=>array('projectperson'=>'_projectPersonEdit_',),
));




/**
* task
*/
new PageHandle(array('id'=>'taskView',
    'req'=>'pages/task_view.inc.php',
    'title'=>__('View Task'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskView_',),

    'cleanurl'=>'_ITEM_',
    'cleanurl_mapping'=>array('tsk' => '_ITEM_'),

));

new PageHandle(array('id'=>'taskViewAsDocu',
    'req'=>'pages/task_view.inc.php',
    'title'=>__('View Task As Docu'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskView_',),

    #'cleanurl'=>'_ITEM_',
    #'cleanurl_mapping'=>array('tsk' => '_ITEM_'),
));




new PageHandleForm(array('id'=>'taskEdit',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Edit Task'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskEdit_',),
));

new PageHandleForm(array('id'=>'taskEditMultiple',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Edit multiple Tasks'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskEdit_',),
));
new PageHandleSubm(array('id'=>'taskEditMultipleSubmit',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Edit multiple Tasks'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskEdit_',),
));


new PageHandle(array('id'=>'taskViewEfforts',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('View Task Efforts'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskView_',),
    'valid_for_crawlers'=>false,
    'valid_for_crawlers'=>false,
));

new PageHandleSubm(array('id'=>'taskEditSubmit',
    'req'=>'pages/task_more.inc.php',

));
new PageHandleFunc(array('id'=>'tasksDelete',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Delete Task(s)'),

));
new PageHandleFunc(array('id'=>'tasksUndelete',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Restore Task(s)'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskEdit_',),
));

new PageHandleFunc(array('id'=>'tasksMoveToFolder',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Move tasks to folder'),


    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskView_',),
));
new PageHandleFunc(array('id'=>'tasksComplete',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Mark tasks as Complete'),


    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskEdit_',),
));
new PageHandleFunc(array('id'=>'tasksApproved',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Mark tasks as Approved'),


    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskEdit_',),
));
new PageHandleFunc(array('id'=>'tasksClosed',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Mark tasks as Closed'),
    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskEdit_',),
));
new PageHandleFunc(array('id'=>'tasksReopen',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Mark tasks as Open'),


    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskEdit_',),
));


new PageHandleFunc(array('id'=>'taskNew',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('New task'),
    'valid_params'=>array(  'prj'=>'\d*',
                            'parent_task'=>'\d*',
                            'add_issue'=>'1',
                            'new_name'=>'.*',
                            'for_milestone'=>'\d*',
                            'task_category'=>'\d*',
                            'task_assign_to_0'=>'\d*',
                            'task_show_folder_as_documentation'=>'\d*',
    ),

    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectEdit_',),

));
new PageHandleFunc(array('id'=>'taskNewDocu',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('New task'),
    'valid_params'=>array(  'prj'=>'\d*',
                            'parent_task'=>'\d*',
                            'add_issue'=>'1',
                            'new_name'=>'.*',
                            'for_milestone'=>'\d*',
                            'task_assign_to_0'=>'\d*',
    ),

    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectEdit_',),

));


new PageHandleFunc(array('id'=>'taskNewBug',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('New bug'),
    'valid_params'=>array(  'prj'=>'\d*',
                            'parent_task'=>'\d*',
                            'add_issue'=>'1',
                            'for_milestone'=>'\d*',
                            'task_category'=>'\d*',
                            'task_assign_to_0'=>'\d*',
    ),

    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectEdit_',),
));


new PageHandleFunc(array('id'=>'taskNewFolder',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('New folder'),
    'valid_params'=>array(  'prj'=>'\d*',
                            'parent_task'=>'\d*',
                            'add_issue'=>'1',
                            'new_name'=>'.*',
                            'for_milestone'=>'\d*',
                            'task_assign_to_0'=>'\d*',
    ),


    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectEdit_',),
));

new PageHandleFunc(array('id'=>'taskNewMilestone',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('New milestone'),
    'valid_params'=>array(  'prj'=>'\d*',
                            'task_assign_to_0'=>'\d*',
    ),

    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectEdit_',),
));

new PageHandleFunc(array('id'=>'taskNewVersion',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('New released Version'),
    'valid_params'=>array(  'prj'=>'\d*',
                            'task_assign_to_0'=>'\d*',
    ),

    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectEdit_',),
));


new PageHandleFunc(array('id'=>'taskToggleViewCollapsed',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Toggle view collapsed'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskEdit_',),
));

new PageHandleFunc(array('id'=>'taskCollapseAllComments',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Toggle view collapsed'),
    'valid_params'=>array(
           'comment'=>'\d*',
           'from'=>'.*',
    ),

    'test'=>'yes',
    'test_params'=>array('comment'=>'_commentEdit_',),

));
new PageHandleFunc(array('id'=>'taskExpandAllComments',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Toggle view collapsed'),
    'valid_params'=>array(
           'comment'=>'\d*',
           'from'=>'.*',
    ),

    'test'=>'yes',
    'test_params'=>array('comment'=>'_commentEdit_',),
));

new PageHandleFunc(array('id'=>'taskAddIssueReport',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Add issue/bug report'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskEdit_',),
));


new PageHandleForm(array('id'=>'taskEditDescription',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Edit Description'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskEdit_',),
));
new PageHandleSubm(array('id'=>'taskEditDescriptionSubmit',
    'req'=>'pages/task_more.inc.php',

));

new PageHandleForm(array('id'=>'taskNoteOnPersonNew',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Create Note'),
    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskNoteOnPersonNew_',),
));

new PageHandleForm(array('id'=>'taskNoteOnPersonEdit',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Edit Note'),
    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskNoteOnPersonEdit_',),
));

new PageHandleSubm(array('id'=>'taskNoteOnPersonEditSubmit',
    'req'=>'pages/task_more.inc.php',
    'title'=>__('Edit Note'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskNoteOnPersonEdit_',),
));

/**
* efforts
*/
new PageHandle(array('id'=>'effortView',
    'req'=>'pages/effort.inc.php',
    'title'=>__('View effort'),
    'valid_params'=>array(
           'effort'=>'\d*'),

    'test'=>'yes',
    'test_params'=>array('effort'=>'_effortView_',),

    'cleanurl'=>'_ITEM_',
    'cleanurl_mapping'=>array('effort' => '_ITEM_'),
    'valid_for_crawlers'=>false,

));
new PageHandle(array('id'=>'effortViewMultiple',
    'req'=>'pages/effort.inc.php',
    'title'=>__('View multiple efforts'),
    'valid_params'=>array(
           'effort'=>'\d*'),

    'test'=>'yes',
    'test_params'=>array('effort'=>'_effortViewMultiple_',),
    'valid_for_crawlers'=>false,
));
new PageHandleFunc(array('id'=>'effortNew',
    'req'=>'pages/effort.inc.php',
    'title'=>__('Log hours'),

    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectEdit_',),
));
new PageHandleForm(array('id'=>'effortEdit',
    'req'=>'pages/effort.inc.php',
    'title'=>__('Edit time effort'),

    'test'=>'yes',
    'test_params'=>array('effort'=>'_effortEdit_',),
));
new PageHandleSubm(array('id'=>'effortEditSubmit',
    'req'=>'pages/effort.inc.php',

));
new PageHandleForm(array('id'=>'effortEditMultiple',
    'req'=>'pages/effort.inc.php',
    'title'=>__('Edit multiple efforts'),

    'test'=>'yes',
    'test_params'=>array('effort'=>'_effortEdit_',),
));
new PageHandleSubm(array('id'=>'effortEditMultipleSubmit',
    'req'=>'pages/effort.inc.php',
	'title'=>__('Edit multiple efforts'),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_effortEdit_',),

));
new PageHandleFunc(array('id'=>'effortsDelete',
    'req'=>'pages/effort.inc.php',
));


/**
* comment
*/
new PageHandle(array('id'=>'commentView',
    'req'=>'pages/comment.inc.php',
    'title'=>__('View comment'),
    'valid_params'=>array(
           'comment'=>'\d*'),

    'test'=>'yes',
    'test_params'=>array('comment'=>'_commentView_',),

    'cleanurl'=>'_ITEM_',
    'cleanurl_mapping'=>array('comment' => '_ITEM_'),
    'valid_for_crawlers'=>false,
    'valid_for_crawlers'=>false,
));

new PageHandleFunc(array('id'=>'commentNew',
    'req'=>'pages/comment.inc.php',
    'title'=>__('Create comment'),
    'valid_params'=>array(
           'parent_task'=>'\d*',
           'comment'=>'\d*',
           'prj'=>'\d*'),

    'test'=>'yes',
    'test_params'=>array('prj'=>'_projectEdit_',),
));
new PageHandleForm(array('id'=>'commentEdit',
    'req'=>'pages/comment.inc.php',
    'title'=>__('Edit comment'),

    'test'=>'yes',
    'test_params'=>array('comment'=>'_commentEdit_',),
));
new PageHandleSubm(array('id'=>'commentEditSubmit',
    'req'=>'pages/comment.inc.php',

));
new PageHandleFunc(array('id'=>'commentsDelete',
    'req'=>'pages/comment.inc.php',
    'title'=>__('Delete comment'),

    'test'=>'yes',
));
new PageHandleFunc(array('id'=>'commentsUndelete',
    'req'=>'pages/comment.inc.php',
    'title'=>__('Delete comment'),

    'test'=>'yes',
));
new PageHandleFunc(array('id'=>'commentsMoveToFolder',
    'req'=>'pages/comment.inc.php',
    'title'=>__('Delete comment'),

    'test'=>'yes',
));
new PageHandleFunc(array('id'=>'commentToggleViewCollapsed',
    'req'=>'pages/comment.inc.php',
    'title'=>__('Toggle view collapsed'),
    'valid_params'=>array(
           'comment'=>'\d*',
           'from'=>'.*',
    ),

    'test'=>'yes',
    'test_params'=>array('comment'=>'_commentView_',),
));
new PageHandleFunc(array('id'=>'commentsCollapseView',
    'req'=>'pages/comment.inc.php',
    'title'=>__('Toggle view collapsed'),
    'valid_params'=>array(
           'comment'=>'\d*',
           'from'=>'.*',
    ),

    'test'=>'yes',
    'test_params'=>array('comment'=>'_commentEdit_',),

));
new PageHandleFunc(array('id'=>'commentsExpandView',
    'req'=>'pages/comment.inc.php',
    'title'=>__('Toggle view collapsed'),
    'valid_params'=>array(
           'comment'=>'\d*',
           'from'=>'.*',
    ),

    'test'=>'yes',
    'test_params'=>array('comment'=>'_commentEdit_',),
));


/**
* files
*/
new PageHandle(array('id'=>'fileView',
    'req'=>'pages/file.inc.php',
    'title'=>__('View file'),

    'test'=>'yes',
    'test_params'=>array('prj'=>'_fileView_',),

    'cleanurl'=>'_ITEM_',
    'cleanurl_mapping'=>array('file' => '_ITEM_'),
    'valid_for_crawlers'=>false,
));

new PageHandleFunc(array('id'=>'filesUpload',
    'req'=>'pages/file.inc.php',
    'title'=>__('Upload file'),
));


new PageHandleFunc(array('id'=>'fileUpdate',
    'req'=>'pages/file.inc.php',
    'title'=>__('Update file'),

#    'test'=>'yes',
#    'test_params'=>array('prj'=>'_projectEdit_',),
));

new PageHandleForm(array('id'=>'fileEdit',
    'req'=>'pages/file.inc.php',
    'title'=>__('Edit file'),

    'test'=>'yes',
#    'test_params'=>array('effort'=>'_fileEdit_',),
));
new PageHandle(array('id'=>'fileDownload',
    'req'=>'pages/file.inc.php',
    'title'=>__('Download'),
    'valid_for_crawlers'=>false,
));

new PageHandle(array('id'=>'fileDownloadAsImage',
    'req'=>'pages/file.inc.php',
    'title'=>__('Show file scaled'),
    'valid_for_crawlers'=>false,
));

new PageHandleSubm(array('id'=>'fileEditSubmit',
    'req'=>'pages/file.inc.php',

));
new PageHandleFunc(array('id'=>'filesDelete',
    'req'=>'pages/file.inc.php',
));
new PageHandleFunc(array('id'=>'filesMoveToFolder',
    'req'=>'pages/file.inc.php',
    'title'=>__('Move files to folder'),

    'valid_params'=>array(
           'from'=>'.*',
           'files_\d+_chk'=>"\S+",
           'file' =>"\d+",
    ),

    'test'=>'yes',
    'test_params'=>array('tsk'=>'_taskView_',),

));



/**
* company
*/
new PageHandle(array('id'=>'companyList',
    'req'=>'pages/company.inc.php',
    'title'=>__('List Companies'),
    'test'=>'yes',
    'valid_for_crawlers'=>false,

));

new PageHandle(array('id'=>'companyView',
    'req'=>'pages/company.inc.php',
    'title'=>__('View Company'),

    'test'=>'yes',
    'test_params'=>array('company'=>'_companyView_',),

    'cleanurl'=>'_ITEM_',
    'cleanurl_mapping'=>array('company' => '_ITEM_'),
));
new PageHandleFunc(array('id'=>'companyNew',
    'req'=>'pages/company.inc.php',
    'title'=>__('New company'),
    'rights_required'=>RIGHT_COMPANY_CREATE,

    'test'=>'yes',
));
new PageHandleForm(array('id'=>'companyEdit',
    'req'=>'pages/company.inc.php',
    'title'=>__('Edit Company'),
    'rights_required'=>RIGHT_COMPANY_EDIT,

    'test'=>'yes',
    'test_params'=>array('company'=>'_companyEdit_',),
));
new PageHandleSubm(array('id'=>'companyEditSubmit',
    'req'=>'pages/company.inc.php',
    'rights_required'=>RIGHT_COMPANY_EDIT,

));
new PageHandleFunc(array('id'=>'companyDelete',
    'req'=>'pages/company.inc.php',
    'title'=>__('Delete Company'),
    'rights_required'=>RIGHT_COMPANY_DELETE,

));
new PageHandle(array('id'=>'companyLinkPersons',
    'req'=>'pages/company.inc.php',
    'title'=>__('Link Persons'),
    'rights_required'=>RIGHT_COMPANY_EDIT,

    'test'=>'yes',
    'test_params'=>array('company'=>'_companyEdit_',),      # test aborts / not enough params
    'valid_for_crawlers'=>false,
    'valid_for_crawlers'=>false,
));
new PageHandleSubm(array('id'=>'companyLinkPersonsSubmit',
    'req'=>'pages/company.inc.php',
    'rights_required'=>RIGHT_COMPANY_EDIT,

));
new PageHandleFunc(array('id'=>'companyPersonsDelete',
    'req'       =>'pages/company.inc.php',
    'title'     =>__('Remove persons from company'),
    'rights_required'=>RIGHT_COMPANY_EDIT,

    'test'=>'yes',
    'test_params'=>array('company'=>'_companyEdit_',),
));

/**
* person
*/
new PageHandle(array('id'=>'personList',
    'req'=>'pages/person.inc.php',
    'title'=>__('List Persons'),
    'test'=>'yes',
    'valid_for_crawlers'=>false,

));


new PageHandle(array('id'=>'personView',
    'req'=>'pages/person.inc.php',
    'title'=>__('View Person'),

    'test'=>'yes',
    'test_params'=>array('person'=>'_personView_',),      # test aborts / not enough params
    'cleanurl'=>'_ITEM_',
    'cleanurl_mapping'=>array('person' => '_ITEM_'),
));
new PageHandleFunc(array('id'=>'personNew',
    'req'=>'pages/person.inc.php',
    'title'=>__('New person'),
    'rights_required'=>RIGHT_PERSON_CREATE,

    'test'=>'yes',
));
new PageHandleForm(array('id'=>'personEdit',
    'req'=>'pages/person.inc.php',
    'title'=>__('Edit Person'),
    'rights_required'=>RIGHT_PERSON_EDIT_SELF,

    'test'=>'yes',
    'test_params'=>array('person'=>'_personEdit_',),      # test aborts / not enough params
));
new PageHandleSubm(array('id'=>'personEditSubmit',
    'req'=>'pages/person.inc.php',
    'rights_required'=>RIGHT_PERSON_EDIT_SELF,
    'valid_for_tuid'=>true,                               # valid for temporary user ids

));
new PageHandleForm(array('id'=>'personEditRights',
    'rights_required'=>RIGHT_PERSON_EDIT_RIGHTS,
    'req'=>'pages/person.inc.php',
    'title'=>__('Edit User Rights'),

    'test'=>'yes',
    'test_params'=>array('person'=>'_personEdit_',),      # test aborts / not enough params
));
new PageHandleSubm(array('id'=>'personEditRightsSubmit',
    'rights_required'=>RIGHT_PERSON_EDIT_RIGHTS,
    'req'=>'pages/person.inc.php',

));

new PageHandleFunc(array('id'=>'personDelete',
    'req'=>'pages/person.inc.php',
    'title'=>__('Delete Person'),
    'rights_required'=>RIGHT_PERSON_DELETE,
));
new PageHandle(array('id'=>'personViewProjects',
    'req'=>'pages/person.inc.php',
    'title'=>__('View Projects of Person'),
	'valid_params'=>array(  'from'=>'.*',
                            'person'=>'\d*',
							'preset'=>'.*',
							'prj'=>'.*'
                            ),
    'test'=>'yes',
    'test_params'=>array('person'=>'_personView_',),      # test aborts / not enough params
));
new PageHandle(array('id'=>'personViewTasks',
    'req'=>'pages/person.inc.php',
    'title'=>__('View Task of Person'),
	'valid_params'=>array(  'from'=>'.*',
                            'person'=>'\d*',
							'preset'=>'.*',
							'prj'=>'.*'
                            ),
    'test'=>'yes',
    'test_params'=>array('person'=>'_personView_',),      # test aborts / not enough params
));
new PageHandle(array('id'=>'personViewEfforts',
    'req'=>'pages/person.inc.php',
    'title'=>__('View Efforts of Person'),
	'valid_params'=>array(  'from'=>'.*',
                            'person'=>'\d*',
							'preset'=>'.*',
							'prj'=>'.*'
                            ),
    'test'=>'yes',
    'test_params'=>array('person'=>'_personView_',),      # test aborts / not enough params
    'valid_for_crawlers'=>false,
));
new PageHandle(array('id'=>'personViewChanges',
    'req'=>'pages/person.inc.php',
    'title'=>__('View Changes of Person'),
	'valid_params'=>array(  'from'=>'.*',
                            'person'=>'\d*',
							'preset'=>'.*',
							'prj'=>'.*'
                            ),
    'test'=>'yes',
    'test_params'=>array('person'=>'_personView_',),      # test aborts / not enough params
    'valid_for_crawlers'=>false,
));
new PageHandleFunc(array('id'=>'personSendActivation',
    'req'       =>'pages/person.inc.php',
    'title'     =>__('Send Activation E-Mail'),
    'rights_required'=>RIGHT_PERSON_EDIT_SELF,

    'test'=>'complex',
    'test_params'=>array('projectperson'=>'_projectPersonEdit_',),
));
new PageHandleFunc(array('id'=>'personsFlushNotifications',
    'req'       =>'pages/person.inc.php',
    'title'     =>__('Flush Notifications'),
    'rights_required'=>RIGHT_PERSON_EDIT,
));

new PageHandleForm(array('id'=>'personRegister',
    'req'       =>'pages/person.inc.php',
    'title'     =>__('Register'),
    'test'=>'yes',

    'cleanurl'  => 'register',
));
new PageHandleSubm(array('id'=>'personRegisterSubmit',
    'req'       =>'pages/person.inc.php',
    'test'=>'yes',
));
new PageHandle(array('id'=>'personLinkCompanies',
    'req'=>'pages/person.inc.php',
    'title'=>__('Link Companies'),
    'rights_required'=>RIGHT_PERSON_EDIT,

    'test'=>'yes',
    'test_params'=>array('person'=>'_personEdit_',),      # test aborts / not enough params
    'valid_for_crawlers'=>false,
));
new PageHandleSubm(array('id'=>'personLinkCompaniesSubmit',
    'req'=>'pages/person.inc.php',
    'rights_required'=>RIGHT_PERSON_EDIT,

));
new PageHandleFunc(array('id'=>'personCompaniesDelete',
    'req'       =>'pages/person.inc.php',
    'title'     =>__('Remove companies from person'),
    'rights_required'=>RIGHT_PERSON_EDIT,

    'test'=>'yes',
    'test_params'=>array('person'=>'_personEdit_',),
));
new PageHandleFunc(array('id'=>'personAllItemsViewed',
    'req'       =>'pages/person.inc.php',
    'title'     =>__('Mark all items as viewed'),
));
new PageHandleFunc(array('id'=>'personToggleFilterOwnChanges',
    'req'       =>'pages/person.inc.php',
    'title'     =>__('Toggle filter own changes'),
    'test'=>'yes',
    'test_params'=>array('person'=>'_personEdit_',),
));



/**
* notification-trigger for cron-jobs ( index.php?go=triggerSendNotificiations)
*/
new PageHandleFunc(array('id'=>'triggerSendNotifications',
    'req'       =>'pages/misc.inc.php',
    'title'     =>__('Flush Notifications'),
    'valid_for_anonymous'=>true,
));


/**
* Renders a captcha image with using the given number
*/
new PageHandleFunc(array('id'=>'imageRenderCaptcha',
    'req'       =>'pages/misc.inc.php',
    'valid_for_anonymous'=>true,
    'valid_params'=>array(
           'key'=>'.*',
    ),
));




/**
* login
*/
new PageHandleForm(array('id'=>'loginForm',
    'req'=>'pages/login.inc.php',
    'title'=>__('Login'),
    'valid_for_anonymous'=>true,
    'ignore_from_handles'=>true,
    'valid_params'=>array(),

    'cleanurl'=>'login',
));
new PageHandleSubm(array('id'=>'loginFormSubmit',
    'req'=>'pages/login.inc.php',
    'valid_for_anonymous'=>true,
));

new PageHandleForm(array('id'=>'loginForgotPassword',
    'req'=>'pages/login.inc.php',
    'title'=>__('Forgot your password?'),
    'valid_for_anonymous'=>true,
    'ignore_from_handles'=>true,
    'valid_params'=>array(),
    #'cleanurl'=>'loginForgotPassword',
));

new PageHandleSubm(array('id'=>'loginForgotPasswordSubmit',
    'req'=>'pages/login.inc.php',
    'valid_for_anonymous'=>true,
));


new PageHandleSubm(array('id'=>'loginFormSubmit2',
    'req'=>'pages/login.inc.php',
    'valid_for_anonymous'=>true,
    'ignore_from_handles'=>true,
));

new PageHandleFunc(array('id'=>'logout',
    'req'=>'pages/login.inc.php',
    'title'=>__('Logout'),
    'ignore_from_handles'=>true,
    'cleanurl'=>'logout',
));
new PageHandle(array('id'=>'helpLicense',
    'req'=>'pages/login.inc.php',
    'title'=>__('License'),
    'valid_for_anonymous'=>true,
    'ignore_from_handles'=>true,
    'cleanurl'=>'license',
));

/**
* misc
*/
new PageHandleFunc(array('id'=>'changeSort',
    'req'=>'pages/misc.inc.php',
    'valid_params'=>array(
           'from'=>'.*',
           'table_id'=>'\S*',
           'column'=>'\S*',
           'page_id'=>'\S*',
           'list_style'=>'\S*',
    ),
));
new PageHandleFunc(array('id'=>'changeBlockStyle',
    'req'=>'pages/misc.inc.php',
    'valid_params'=>array(
           'from'=>'.*',
           'style'=>'\S*',
           'list_style'=>'\S*',
           'block_id'=>'\S*',
           'page_id'=>'\S*',
    ),
));
new PageHandleFunc(array('id'=>'changeBlockGrouping',
    'req'=>'pages/misc.inc.php'
));

new PageHandleFunc(array('id'=>'itemsRestore',
    'req'=>'pages/misc.inc.php',
    'valid_params'=>array(
           'item'=>'\d*',
           'from'=>'.*',
    ),
    'title'=>__('restore Item'),
));



new PageHandle(array('id'=>'error',
    'req'=>'pages/error.inc.php',
    'title'=>__('Error'),
    'valid_for_anonymous'=>true,    # without this PH->show() could be trapped in endless loop will crash php-cgi!
    'ignore_from_handles'=>true,
));

new PageHandle(array('id'=>'activateAccount',
    'req'=>'pages/login.inc.php',
    'title'=>__('Activate an account'),
    'valid_for_tuid'=>true,    # without this PH->show() could be trapped in endless loop will crash php-cgi!
    'ignore_from_handles'=>true,
    'valid_params'=>array(
           'comment'=>'\d*',
           'from'=>'.*',
    ),
    'valid_for_crawlers'=>false,

));

new PageHandle(array('id'=>'systemInfo',
    'req'=>'pages/misc.inc.php',
    'title'=>__('System Information'),
    'ignore_from_handles'=>true,
    'rights_required'=>RIGHT_VIEWALL,

    'test'=>'yes',
    'test_params'=>array(),
    'valid_for_crawlers'=>false,

));

new PageHandle(array('id'=>'showPhpInfo',
    'req'=>'pages/misc.inc.php',
    'title'=>__('PhpInfo'),
    'ignore_from_handles'=>true,

    'rights_required'=>RIGHT_VIEWALL,
    'test'=>'yes',
    'test_params'=>array(),
    'valid_for_crawlers'=>false,

));

new PageHandle(array('id'=>'showLog',
    'req'=>'pages/misc.inc.php',
    'title'=>__('Filter errors.log'),
    'ignore_from_handles'=>true,

    'rights_required'=>RIGHT_VIEWALL,
    'valid_for_crawlers'=>false,

));
new PageHandleFunc(array('id'=>'deleteLog',
    'req'=>'pages/misc.inc.php',
    'title'=>__('Delete errors.log'),

    'rights_required'=>RIGHT_VIEWALL,
));

new PageHandle(array('id'=>'search',
    'req'=>'pages/search.inc.php',
    'title'=>__('Search'),
    'valid_for_crawlers'=>false,
));

/**
* misc pages / ajax etc.
*/
new PageHandle(array('id'=>'taskAjax',
    'req'=>'pages/task_ajax.inc.php',
    'title'=>__('Task Test'),
    'valid_for_crawlers'=>false,
));


new PageHandle(array('id'=>'itemLoadField',
    'req'=>'pages/item_ajax.inc.php',
    'title'=>__('Load Field'),
    'valid_for_crawlers'=>false,
));

new PageHandle(array('id'=>'itemSaveField',
    'req'=>'pages/item_ajax.inc.php',
    'title'=>__('Save Field'),
    'valid_for_crawlers'=>false,
));

?>
