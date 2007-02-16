<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt


require_once(confGet('DIR_STREBER') . 'db/class_issue.inc.php');

define('TEXT_LEN_PREVIEW',   120);


class ListGroupingFolder extends ListGrouping
{

    public function __construct($args=NULL) {
        $this->id = 'parent_task';
        parent::__construct($args);
    }

    /**
    * render separating row
    */
    public function render(&$item)
    {
        if(! ($item instanceof Task)) {
            trigger_error("can't group for status",E_USER_NOTICE);
            return "---";
        }
        else {
            return $item->getFolderLinks(false);
        }
    }
}




/**
 * derived ListBlock-class for listing tasks
 *
 * @includedby:     pages/*
 *
 * @author:         Thomas Mann
 * @uses:           ListBlock
 * @usedby:
 *
 */
class ListBlock_tasks extends ListBlock
{

    public $filters                 = array();                               # assoc arry of ListFilters
    #public $active_block_function   = 'tree';              #@@@ HACK
    public $tasks_assigned_to       = NULL;
    public $use_short_names         = false;
    public $show_summary            = false;

    public function __construct($args=NULL)
    {
        global $PH;
		parent::__construct(array());

        $this->id           =  'tasks';
        $this->bg_style     ='bg_projects';
        $this->no_items_html=NULL;
		$this->title        = __("Tasks");

        ### filter params ###
        if($args) {
            foreach($args as $key=>$value) {
                if(!isset($this->$key) && !is_null($this->$key) && !$this->$key==="") {
                    trigger_error("unknown parameter",E_USER_NOTICE);
                }
                else {
                    $this->$key= $value;
                }
            }
        }



        /**
        * @@@ dummy-settings for filters
        */
        #$this->filters=array(
        #    new ListFilter_status_min(),
        #    new ListFilter_status_max(),
        #    new ListFilter_not_older(array(
        #        'not_older' => 13*25*60*60,
        #    )),
        #);

        ### columns ###
        $this->add_col( new ListBlockColSelect());
		$this->add_col( new ListBlockColPrio(array(
			'key'=>'prio',
			'name'=>"P",
			'tooltip'=>__("Priority of task"),
			'sort'=>1
		)));
		$this->add_col(new ListBlockColMethod(array(
			'key'=>'project',
			'name'=>__('Project'),
			'func'=>'getProjectLink'
		)));

		$this->add_col( new ListBlockColStatus(array(
			'key'=>'status',
			'name'=>__("Status","Columnheader"),
			'tooltip'=>__("Task-Status"),
			'sort'=>0
		)));

	    $this->add_col( new ListBlockCol_TaskLabel());
        $this->add_col( new ListBlockColMethod(array(
			'key'=>'parent_task',
			'name'=>__('Folder'),
			'func'=>'getFolderLinks'
		)));

        $this->add_col( new ListBlockCol_TasknameWithFolder());
	    $this->add_col( new ListBlockCol_TaskName(array(
	        'use_short_names'=>$this->use_short_names,
	        'indention'=>true
	    )));
	    $this->add_col( new ListBlockCol_TaskAssignedTo(array('use_short_names'=>false )));

        /*$this->add_col( new listBlockColDate(array(
			'key'=>'date_start',
            'name'=>__('Started'),
        )));*/
        $this->add_col( new listBlockColDate(array(
			'key'=>'modified',
            'name'=>__('Modified','Column header'),
        )));

        $this->add_col( new listBlockColDate(array(
			'key'=>'date_closed',
            'name'=>__('Closed'),
        )));
	    #$this->add_col( new ListBlockCol_TaskCreatedBy( array('use_short_names'=>false,'indention'=>true)));

		$this->add_col( new ListBlockColTime(array(
			'key'=>'estimated',
			'name'=>__("Est."),
			'tooltip'=>__("Estimated time in hours"),
			'sort'=>0,
		)));
		$this->add_col( new ListBlockCol_Milestone);
		$this->add_col( new ListBlockCol_EstimatedComplete);
		$this->add_col( new ListBlockCol_DaysLeft);
		$this->add_col( new ListBlockCol_TaskSumEfforts());
		$this->add_col( new ListBlockCol_TaskRelationEfforts);
        $this->add_col( new ListBlockColPubLevel());
        
        ### functions ###
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('taskEdit')->id,
            'name'  =>__('Edit'),
            'id'    =>'taskEdit',
            'icon'  =>'edit',
            'context_menu'=>'submit',
        )));

        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('taskNew')->id,
            'name'  =>__('Add new Task'),
            'id'    =>'taskNew',
            'icon'  =>'new',
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('taskNewBug')->id,
            'name'  =>__('Report new Bug'),
            'id'    =>'taskNewBug',
            'icon'  =>'new',
            'context_menu'=>'submit',
            'dropdown_menu'=>false,
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('commentNew')->id,
            'name'  =>__('Add comment'),
            'id'    =>'commentNew',
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('tasksDelete')->id,
            'name'  =>__('Delete'),
            'id'    =>'tasksDelete',
            'icon'  =>'delete',
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('tasksComplete')->id,
            'name'  =>__('Status->Completed'),
            'id'    =>'tasksCompleted',
            'icon'  =>'complete',
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('tasksApproved')->id,
            'name'  =>__('Status->Approved'),
            'id'    =>'tasksApproved',
			'icon'  =>'approve',
            'context_menu'=>'submit',
        )));
		$this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('tasksClosed')->id,
            'name'  =>__('Status->Closed'),
            'id'    =>'tasksClosed',
            'icon'  =>'close',
            'context_menu'=>'submit',
        )));

        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('tasksMoveToFolder')->id,
            'name'  =>__('Move tasks'),
            'id'    =>'tasksMoveToFolder',
            'context_menu'=>'submit'
        )));

        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('effortNew')->id,
            'name'  =>__('Log hours for select tasks'),
            'id'    =>'effortNew',
            'icon'    =>'loghours',
            'context_menu'=>'submit',
        )));

		$this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('itemsAsBookmark')->id,
            'name'  =>__('Mark as bookmark'),
            'id'    =>'itemsAsBookmark',
            'context_menu'=>'submit',
        )));
		

        ### block style functions ###
        $this->add_blockFunction(new BlockFunction(array(
            'target'=>'changeBlockStyle',
            'key'=>'list',
            'name'=>__('List','List sort mode'),
            'params'=>array(
                'style'=>'list',
                'block_id'=>$this->id,
                'page_id'=>$PH->cur_page->id,
#                'use_collapsed'=>true,
             ),
        )));
        $this->add_blockFunction(new BlockFunction(array(
            'target'=>'changeBlockStyle',
            'key'=>'tree',
            'name'=>__('Tree','List sort mode'),
            'params'=>array(
                'style'=>'tree',
                'block_id'=>$this->id,
                'page_id'=>$PH->cur_page->id,
            ),
            #'default'=>true,
        )));
        $this->groupings= new BlockFunction_grouping(array(
            'target'=>'changeBlockStyle',
            'key'=>'grouped',
            'name'=>__('Grouped','List sort mode'),
            'params'=>array(
                'style'=>'grouped',
                'block_id'=>$this->id,
                'page_id'=>$PH->cur_page->id,
            ),
        ));
        $this->add_blockFunction($this->groupings);



        ### list groupings ###

        $this->groupings->groupings= array(
            new ListGroupingFolder(),
            new ListGroupingStatus(),
            new ListGroupingPrio(),
            new ListGroupingCreatedBy(),
        );


        $this->initOrderQueryOption('order_id');
    }

    /**
    * render completely (overwrites original ListBlock::render())
    */
    public function render_list(&$tasks=NULL)
    {
        #global $PH;
        #require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

		switch($this->page->format){
			case FORMAT_CSV:
				#$this->renderListCsv($list);
				$this->renderListCSV($tasks);
				break;

			default:
				$this->renderListHtml($tasks);
				break;
		}
    }

    /**
    * render completely (overwrites original ListBlock::render())
    */
    public function renderListHtml(&$tasks=NULL)
    {
        global $PH;
        require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

		$this->render_header();
		if($this->groupings) {
		    $this->groupings->getActiveFromCookie();
		}

        /**
        * for rendering undefined wiki-links we need to know the
        * project of each task. This is used for caching:
        */
        $last_project_id= 0;
        $project= NULL;


		/**
		* @@@ dummy rending of filters. Should later be placed at ListBlock()
		*/
		/*if($this->filters) {
		    echo '<span class=filters>Filters:';
		    foreach($this->filters as $f) {
		        echo '<span class=filter>'.$f->render().'</span> ';
		    }
		    echo '</span>';
		}
		*/


		$style='';
        if(!$tasks && $this->no_items_html) {
            $this->render_tfoot_empty();
        }
        else {

            ### render table lines ###
    		$this->render_thead();
            $count_estimated=0;

            $last_group= NULL;
    		foreach($tasks as $t) {

                ### grouped style ###
                if($this->groupings && $this->active_block_function == 'grouped') {
                    $gr= $this->groupings->active_grouping_key;

                    if($t->project != $last_project_id) {
                        $project= Project::getVisibleById($t->project);
                        $last_project_id= $t->project;
                    }


                    if($gr=='parent_task') {
                        if($t->category == TCATEGORY_FOLDER) {
    		                echo '<tr class=group><td colspan='. count($this->columns) .'>';
    		                #. $this->groupings->active_grouping_obj->render($t)


                            ### toggle ###
                            $description= '';
                            if($t->view_collapsed) {
                                $toggle=$PH->getLink('taskToggleViewCollapsed','<img src="' . getThemeFile("img/toggle_folder_closed.gif") .'">',array('tsk'=>$t->id),'folder_collapsed', true);

                                ### number of subtasks with folded ###
                                $description='<span class=diz>( ' . sprintf(__('%s hidden'), $t->getNumSubtasks()) .')</span>';
                            }
                            else {
                                $toggle=$PH->getLink('taskToggleViewCollapsed','<img src="' . getThemeFile("img/toggle_folder_open.gif") . '">',array('tsk'=>$t->id),'folder_open', true);
                            }
                            echo $toggle;

    		                if($parents= $t->getFolderLinks(false)) {
    		                    echo $parents. '<em>&gt;</em>';
    		                }
    		                echo $t->getLink();
    		                echo $description;
    		                echo '</td></tr>';
                            continue;
                        }

                    }
                    else {
    		            if($last_group != $t->$gr) {
    		                echo '<tr class=group><td colspan='. count($this->columns) .'>'. $this->groupings->active_grouping_obj->render($t).'</td></tr>';
		                    $last_group = $t->$gr;
		                }
           		    }
           		}

                $style=($t->category == TCATEGORY_FOLDER)
                    ?' isFolder'
                    :'';

                ### done ###
                if(@intval($t->status) >= STATUS_COMPLETED) {
                    $style.= ' isDone';
                }
                else {
                    $count_estimated+=$t->estimated;
                }

      			$this->render_trow(&$t,$style);


      			### render additional information ###
                if($this->groupings && $this->active_block_function == 'grouped') {
		            echo '<tr class=details><td colspan='. count($this->columns) .'>';


		            ### block 1 ###
		            {
		                $html_buffer='';
    		            if($t->issue_report) {
                            $ir=Issue::getById($t->issue_report);
    	                }
    	                else {
    	                    $ir= NULL;
    	                }
    		            global $g_severity_names;
    		            global $g_reproducibility_names;
    		            global $g_prio_names;
    		            global $g_status_names;



    		            #if($t->prio != PRIO_NORMAL && isset($g_prio_names[$t->prio]))  {
    		            #    echo "<p>".$g_prio_names[$t->prio]."</p>";
    		            #}

    		            if($ir && $ir->severity && isset($g_severity_names[$ir->severity]))  {
    		                $html_buffer.= "<p>".$g_severity_names[$ir->severity]."</p>";
    		            }
    		            if($ir && $ir->version)  {
    		                $html_buffer.=  "<p>".$ir->version."</p>";
    		            }

    		            if($ir && $ir->production_build)  {
    		                $html_buffer.=  "<p>".$ir->production_build."</p>";
    		            }

    		            if($ir && $ir->reproducibility  && isset($g_reproducibility_names[$ir->reproducibility]))  {
    		                $html_buffer.=  "<p>".$g_reproducibility_names[$ir->reproducibility]."</p>";
    		            }

    		            if($t->status != STATUS_OPEN && $t->status != STATUS_NEW && isset($g_status_names[$t->status]))  {
    		                $html_buffer.=  "<p>".$g_status_names[$t->status]."</p>";
    		            }

    		            echo '<div class=severity>';
    		            if($html_buffer) {
    		                echo $html_buffer;
    		            }
    		            else {
    		                echo '&nbsp;';   # dummy content to keep floating
    		            }


    		            echo '</div>';
    		        }

		            ### block description ###
		            {
    		            echo '<div class=description>&nbsp;';
    		            if($t->description)  {
    		                echo "<p>".wiki2html($t->description, $project)."</p>";
    		            }



		                ### steps ###
    		            if($ir && isset($ir->steps_to_reproduce) && $ir->steps_to_reproduce)  {
    		                echo "<p>".wiki2html($ir->steps_to_reproduce, $project)."</p>";
    		            }
    		            if($ir && isset($ir->expected_result) && $ir->expected_result)  {
    		                echo "<p>".wiki2html($ir->expected_result, $project)."</p>";
    		            }
    		            if($ir && isset($ir->suggested_solution) && $ir->suggested_solution)  {
    		                echo "<p>".wiki2html($ir->suggested_solution, $project)."</p>";
    		            }


    		            echo '&nbsp;</div>';
    		        }


		            ### block last comment ###
		            {
                        echo '<div class=steps>';

    		            if($c = $t->getLatestComment()) {

    		                echo "<p>".__('Latest Comment')." ";
    		                if($person= Person::getVisibleById($c->created_by)) {
    		                    echo __("by").' '.$person->getLink();
    		                }
    		                echo " (". renderDateHtml($c->modified). "):";
    		                echo "</p>";

                            if($c->name) {
    		                    echo '<p>'. asHtml($c->name) . '</p>';
    		                }
    		                if($c->description) {
    		                    echo "<p>". wiki2html($c->description, $project). "</p>";
    		                }
    		            }
    		            echo '&nbsp;</div>';
    		        }

		            ### assigned to ###
		            {
    		            echo '<div class=assigned_to>';

    		            $persons= $t->getAssignedPersons();
    		            if($persons) {
    		                $sep='';
    		                echo "<p>".__('for')." ";
    		                foreach($persons as $p) {
    		                    echo $sep . $p->getLink();
    		                    $sep= ', ';
    		                }
    		                echo "</p>";
    		            }
    		            echo '</div>';
    		        }




		            echo '</td></tr>';
		        }
            }
               		#$this->render_trow(&$t);

            if($this->show_summary) {
                 $this->summary=sprintf(__("%s open tasks / %s h"), count($tasks), $count_estimated);
            }
            else {
                $this->summary= '';
            }
    		$this->render_tfoot();
        }
    }


    /**
    * print a complete list as html
    * - use filters
    * - use check list style (tree, list, grouped)
    * - check customization-values
    * - check sorting
    * - get objects from database
    *
    */
    public function print_automatic($project=NULL, $parent_task=NULL, $filter_empty_folders=false)
    {
        global $PH;
        global $auth;

        if($project) {
            $this->query_options['project']= $project->id;
        }

        if(!$this->no_items_html && $parent_task) {
            $this->no_items_html=
            $PH->getLink('taskNewFolder',__('New Folder'),array('parent_task'=>$parent_task->id, 'prj'=>$project->id))
            ." ". __("or")." "
            . $PH->getLink('taskNew','',array('parent_task'=>$parent_task->id));
        }
        else if(!$this->no_items_html && $project) {
            $this->no_items_html=
            $PH->getLink('taskNewFolder',__('New Folder'),array('prj'=>$project->id))
            ." ". __("or")." "
            . $PH->getLink('taskNew','',array('prj'=>$project->id));
        }


        if(!$this->active_block_function=$this->getBlockStyleFromCookie()) {
            $this->active_block_function = 'list';
        }

        if($parent_task) {
            $this->query_options['parent_task']= $parent_task->id;
        }

        $this->group_by= get("blockstyle_{$PH->cur_page->id}_{$this->id}_grouping");

        #$filter_milestone= new ListFilter_for_milestone();
        #$this->filters[]= new ListFilter_for_milestone();




        ### add filter options ###
        foreach($this->filters as $f) {
            foreach($f->getQuerryAttributes() as $k=>$v) {
                $this->query_options[$k]= $v;
            }
        }

        $sort_cookie= "sort_{$PH->cur_page->id}_{$this->id}_{$this->active_block_function}";
        if($sort= get($sort_cookie)) {
            $this->query_options['order_by']= $sort;
        }


        if($auth->cur_user->user_rights & RIGHT_VIEWALL) {
            $this->query_options['visible_only']=false;
        }
        $tasks = array();


        ### hide columns depending on project options ###
        if($project && !($project->settings & PROJECT_SETTING_MILESTONES)) {
            unset($this->columns['for_milestone']);
        }

        if($project && !($project->settings & PROJECT_SETTING_EFFORTS)) {
            unset($this->columns['efforts']);
        }


        ### list view ###
        if($this->active_block_function == 'list') {

            if($this->tasks_assigned_to) {
                $this->query_options['assigned_to_person']= $this->tasks_assigned_to;
            }
            $this->query_options['show_folders']    = false;

            $this->query_options['order_by'] = $this->groupings->getActiveFromCookie() . ",".$this->query_options['order_by'];

            unset($this->columns['parent_task']);
            unset($this->columns['date_closed']);
#	        unset($this->columns['pub_level']);
            unset($this->columns['name']);
	        unset($this->columns['estimated']);
            $tasks= Task::getAll($this->query_options);
        }

        ### grouped ###
        else if($this->active_block_function == 'grouped') {
            if($this->tasks_assigned_to) {
                $this->query_options['assigned_to_person']= $this->tasks_assigned_to;
            }

            unset($this->columns['date_closed']);
            unset($this->columns['parent_task']);
            unset($this->columns['name']);
#	        unset($this->columns['pub_level']);
	        unset($this->columns['created_by']);
	        unset($this->columns['estimated']);
	        unset($this->columns['planned_start']);
	        unset($this->columns['assigned_to']);
	        unset($this->columns['status']);
	        #unset($this->columns['prio']);

	        ### prepend key to sorting ###
	        if(isset($this->query_options['order_by'])) {
	            $this->query_options['order_by'] = $this->groupings->getActiveFromCookie() . ",".$this->query_options['order_by'];
	        }
	        else {
	            $this->query_options['order_by'] = $this->groupings->getActiveFromCookie();
	        }

            ### sort folders ? ###
            /**
            * @@@ pixtur 2006-11-16:
            * Although we want to replace task.is_folder with category == TCATEGORY_FOLDER,
            * I am not sure, how we would do this here.
            */
            if($this->groupings->active_grouping_key == 'parent_task') {
                $this->query_options['sort_hierarchical']= true;
                $this->query_options['use_collapsed']    = true;
                $this->query_options['show_folders']     = true;
                $this->query_options['order_by'] = 'is_folder' . ",".$this->query_options['order_by'];
                $this->query_options['parent_task']= NULL;
            }
            else {


                #$this->query_options['sort_hierarchical']= true;
                #$this->query_options['use_collapsed']    = true;
                $this->query_options['show_folders']= false;
            }

            ### remove current grouping key as column ###
            unset($this->columns[$this->groupings->getActiveFromCookie()]);
            $tasks= Task::getAll($this->query_options);

        }

        ### tree view ###
        else {

            ### first get only folders ###
            $parent_task_id = $parent_task
                            ? $parent_task->id
                            : NULL;

            $t_order_by= isset($this->query_options['order_by'])
                       ?     $this->query_options['order_by']
                       : 'order_id,name';


            $tmp_options= array(
                'visible_only'      => true,
                'folders_only'      => true,
                'sort_hierarchical' => true,
                'use_collapsed'     => true,
                'order_by'          => $t_order_by,
                'parent_task'       => $parent_task_id,
                'status_min'       => STATUS_NEW,
                'status_max'       => STATUS_CLOSED,
            );
            #if(isset($this->query_options['status_min'])) { $tmp_options['status_min']= $this->query_options['status_min'];};
            #if(isset($this->query_options['status_max'])) { $tmp_options['status_max']= $this->query_options['status_max'];};




            if(isset($project)) {
                $tmp_options['project']= $project->id;
            }

            $tmp_folders= Task::getAll($tmp_options);

            $folders= array();
            foreach($tmp_folders as $f) {
                $folders[$f->id]= $f;
            }

#            $this->query_options['sort_hierarchical']= true;

#            if(!$this->tasks_assigned_to) {
#                $this->query_options['use_collapsed']    = true;
#            }

            /**
            * @@@ later use only once...
            *
            *   $this->columns= filterOptions($this->columns,"CURPAGE.BLOCKS[{$this->id}].STYLE[{$this->active_block_function}].COLUMNS");
            */
            unset($this->columns['parent_task']);
            unset($this->columns['taskwithfolder']);
            unset($this->columns['date_closed']);
#	        unset($this->columns['pub_level']);
	        unset($this->columns['estimated']);
	        if(isset($this->query_options['folders_only'])) {
	            $full_list= $folders;
	        }
	        else {
                $this->query_options['show_folders']= false;
                $this->query_options['parent_task']= NULL;
                $tasks= Task::getAll($this->query_options);

                ### build hash of tasks appended to a folder ###
                $tasks_for_folder= array();
                foreach($tasks as $t) {
                    $tasks_for_folder[$t->parent_task][]= $t;
                }

                ### build full list ###
                $full_list = array();
                foreach($folders as $f) {
                    $full_list[]=$f;
                    #if(!$f->view_collapsed && isset($tasks_for_folder[$f->id])) {
                    if(isset($tasks_for_folder[$f->id])) {
                        if($f->view_collapsed) {

                            $f->num_subtasks= count($tasks_for_folder[$f->id]);
                        }
                        else {
                            foreach($tasks_for_folder[$f->id] as $t) {
                                $t->level= $f->level+1;
                                $full_list[]= $t;
                            }
                        }
                        unset($tasks_for_folder[$f->id]);
                    }
                }

                ### add tasks as project root / parent-task ###
                if($parent_task && isset($tasks_for_folder[$parent_task->id])) {
                    foreach($tasks_for_folder[$parent_task->id] as $t) {
                        $t->level= 0;
                        $full_list[]= $t;
                    }

                }
                else if(!$parent_task && isset($tasks_for_folder[0])){
                    foreach($tasks_for_folder[0] as $t) {
                        $t->level= 0;
                        $full_list[]= $t;
                    }
                }

                ### for files that have not be added to visible folders yet, try to increase count of visible parent-folders ###
                foreach($tasks_for_folder as $id=>$ar) {

                    if(isset($folders[$id])) {
                         $folders[$id]->num_subtasks= count($tasks_for_folder[$id]);
                    }

                    $parents= $ar[0]->getFolder();

                    foreach($parents as $pa) {
                        if(isset($folders[$pa->id])) {

                            $folders[$pa->id]->num_subtasks=  count($tasks_for_folder[$id]);
                        }
                    }
                }
	        }


            ### filter empty folders with wrong status ###
            # (or all empty, if set)

            $t_min= isset($this->query_options['status_min'])
                ? $this->query_options['status_min']
                : STATUS_NEW;

            $t_max= isset($this->query_options['status_max'])
                ? $this->query_options['status_max']
                : STATUS_CLOSED;

            {
                $new_list=array();
                $last_level=0;
                foreach(array_reverse($full_list) as $t) {
                    if($t->category == TCATEGORY_FOLDER) {


                        if($t->level < $last_level) {
                            $new_list[]=$t;
                            $last_level--;
                        }
                        else if($t->num_subtasks) {
                            $new_list[]=$t;
                            $last_level= $t->level;
                        }
                        else if(!$filter_empty_folders) {
                            if($t->status <= $t_max && $t->status >= $t_min) {
                                $new_list[]=$t;
                                $last_level= $t->level;
                            }
                        }
                        else {
                            if($t->num_subtasks) {
                                if($t->status <= $t_max && $t->status >= $t_min) {
                                    $new_list[]=$t;
                                    $last_level= $t->level;
                                }
                            }
                        }
                    }
                    else {
                        $new_list[]=$t;
                        $last_level= $t->level;
                    }
                }
                $tasks= array_reverse($new_list);
            }
        }
        $this->render_list(&$tasks);
    }
}




class ListBlockCol_TaskLabel extends ListBlockCol
{
    public $id='label';
    public $key='label';


    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('Label','Columnheader');
    }

	function render_tr(&$obj, $style="")
	{
        measure_start('col_label');
		if(!isset($obj) || !$obj instanceof Task) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
        if($obj->category == TCATEGORY_FOLDER) {
    		print "<td></td>";
        }

        else if($str_label= $obj->getLabel()) {
            $class_label= $obj->label
                ? "class=label$obj->label"
                : '';
    		print "<td class=label><span {$class_label}>$str_label</span></td>";

        }
        else {
            print "<td></td>";
        }

        measure_stop('col_label');
	}
}



class ListBlockCol_Milestone extends ListBlockCol
{
    public $name;
    public $id  ='for_milestone';
    public $key ='for_milestone';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('Milestone');
    }

	function render_tr(&$obj, $style='') {
		if(!isset($obj) || !$obj instanceof Task) {
   			return;
		}
        $value="";
        if($obj->for_milestone) {
            if($milestone= Task::getVisibleById($obj->for_milestone)) {
                $value= $milestone->getLink();
            }
        }
		print "<td>$value</td>";
	}
}



class ListBlockCol_TaskCreatedBy extends ListBlockCol
{
    public $name;
    public $id='created_by';
    public $key='created_by';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('Created by');
    }

	function render_tr(&$obj, $style="nowrap") {
		if(!isset($obj) || !$obj instanceof Task) {
   			return;
		}
        $value="";
        if($obj->created_by) {
            if($person= Person::getVisibleById($obj->created_by)) {
                $value=$person->getLink();
            }
        }
		print "<td class=nowrap>$value</td>";
	}
}



class ListBlockCol_TaskAssignedTo extends ListBlockCol
{
    public $name;

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('Assigned to');
        $this->id='assigned_to';
    }

	function render_tr(&$obj, $style="nowrap") {
		if(!isset($obj) || !$obj instanceof Task) {
   			return;
		}
        $value="";
        if($tps= $obj->getAssignedPersons()) {
            $sep="";
            foreach($tps as $tp) {
                $value.= $sep.$tp->getLink();
                $sep=", ";
            }
        }
		print "<td class=nowrap>$value</td>";
	}
}



/**
* print name intention and comments
*/
class ListBlockCol_TaskName extends ListBlockCol
{
    public $use_short_names=false;
    public $name;
    public $indention=false;
    public $key='name';
    public $show_toggles= true;

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->width='90%';
        $this->name=__('Task name');
        $this->id='name';
    }

	function render_tr(&$task, $style="")
	{
        measure_start('col_taskname');

        global $PH;
		if(!isset($task) || !is_object($task)) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}

        ### descriptions ###
        if($task->description && !$this->use_short_names) {
            $html_diz= asHtml($task->description);
            if(strlen($html_diz) > TEXT_LEN_PREVIEW) {
                $html_diz= substr($html_diz, 0, TEXT_LEN_PREVIEW);
            }
            $html_diz=preg_replace("/\r\n/",'',$html_diz);
            $description= '<span class=diz title="'.$html_diz.'">diz</span>';
        }
        else {
            $description='';
        }

        ### comments ###
        $discussion='';
        if(($num_comments=$task->getNumComments())  && !$this->use_short_names) {
            $diz=sprintf(__("has %s comments"),$num_comments);
            $discussion= ' <span class=comments title="' .$diz. '">' . $num_comments . '</span>';
        }

        ### attached files? ###
        $attachments='';
        {
            require_once(confGet('DIR_STREBER') . 'db/class_file.inc.php');

            if($files= File::getAll(array(
                'parent_item'=> $task->id,
                'project'=> $task->project,
            ))) {
                $attachments='<img title="' . sprintf(__('Task has %s attachments'), count($files))  . '" src="' . getThemeFile("items/item_attachment.png"). '">';
            }
         }
		
		
		 
        ### task with zero-id is project-root ###
        if(!$task->id) {
            $link=$PH->getLink('projView',"...project...",array('prj'=>$task->project));
            echo '<td>'.$link."</td>";
        }

		### name ###
        else {
            $name= $this->use_short_names
                ? $task->getShort()
                : $task->name;


            if(!$name) {
                $name=__("- no name -","in task lists");
            }

            $link= $PH->getLink('taskView',$name,array('tsk'=>$task->id));


            if($this->indention) {
                $toggle='';
                if($this->show_toggles) {
                    if($task->category == TCATEGORY_FOLDER) {
                        if($task->view_collapsed) {
                            $toggle=$PH->getLink('taskToggleViewCollapsed','<img src="' . getThemeFile("img/toggle_folder_closed.gif") . '">',array('tsk'=>$task->id),'folder_collapsed', true);

                            ### number of subtasks with folded ###
                            $description='<span class=diz title="'.__("number of subtasks").'">('.$task->getNumSubtasks().')</span>';
                        }
                        else {
                            $toggle=$PH->getLink('taskToggleViewCollapsed','<img src="' . getThemeFile("img/toggle_folder_open.gif"). '">',array('tsk'=>$task->id),'folder_open', true);
                        }
                    }
                }
                $html_indention='';
                if($task->level) {
                    $no_folder= ($task->category == TCATEGORY_FOLDER)
                            ? 0
                            : 1;
                    $html_indention= "style='padding-left:".(1.2 * ($no_folder+intval($task->level)))."em;'";
                }

                echo "<td $html_indention>{$toggle}$link{$description}{$discussion}{$attachments}</td>";

            }
            else {
                echo "<td>{$link}{$description}{$discussion}{$attachments}</td>";
            }
        }
        measure_stop('col_taskname');
   	}
}



/**
* reduced display of tasks names for documentation overview
*/
class ListBlockCol_TaskAsDocu extends ListBlockCol
{
    public $name;
    public $key='name';
    public $show_toggles= true;

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->width='90%';
        $this->name=__('Page name');
        $this->id='name';
    }

	function render_tr(&$task, $style="")
	{
        global $PH;
		if(!isset($task) || !is_object($task)) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}

        $link= $PH->getLink('taskViewAsDocu',$task->name,array('tsk'=>$task->id));

        $toggle='';
        if($task->category == TCATEGORY_FOLDER) {
            if($task->view_collapsed) {
                $toggle=$PH->getLink('taskToggleViewCollapsed','<img src="' . getThemeFile("img/toggle_folder_closed.gif") . '">',array('tsk'=>$task->id),'folder_collapsed', true);
            }
            else {
                $toggle=$PH->getLink('taskToggleViewCollapsed','<img src="' . getThemeFile("img/toggle_folder_open.gif"). '">',array('tsk'=>$task->id),'folder_open', true);
            }
        }

        $html_indention='';
        if($task->level) {
            $no_folder= ($task->category == TCATEGORY_FOLDER)
                      ? 0
                      : 1;
            $html_indention= "style='padding-left:".(1.2 * ($no_folder+intval($task->level)))."em;'";
        }
        echo "<td $html_indention>{$toggle}$link</td>";
   	}
}



class ListBlockCol_TaskSumEfforts extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('Efforts');
        $this->id='efforts';
        $this->tooltip=__("Sum of all booked efforts (including subtasks)");
    }


	function render_tr(&$obj, $style="nowrap")
	{
	    global $PH;
		if(!isset($obj) || !$obj instanceof Task) {
   			return;
		}
        $sum=$obj->getSumEfforts();

        $str=  $PH->getLink('taskViewEfforts',round($sum/60/60,1)."h", array('task'=>$obj->id));

		print "<td class=nowrap title='" .__("Effort in hours") . "'>$str</td>";
	}
}

class ListBlockCol_TaskRelationEfforts extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('Estimated/Booked (Diff.)');
        $this->id='efforts_estimated';
        $this->tooltip=__("Relation between estimated time and booked efforts");
    }


	function render_tr(&$obj, $style="nowrap")
	{
	    global $PH;
		if(!isset($obj) || !$obj instanceof Task) {
   			return;
		}
		$diff_str = '';
		$estimated_str = '';
		
        $sum = $obj->getSumTaskEfforts();
		
		$estimated = $obj->estimated;
		$estimated_max = $obj->estimated_max;
		
		if($estimated_max){
			$estimated_str = round($estimated_max/60/60,1) . "h";
			$diff = $estimated_max - $sum;
		}
		else{
			$estimated_str = round($estimated/60/60,1) . "h";
			$diff = $estimated - $sum;
		}
		
		if($diff){
			$diff_str = "(" .round($diff/60/60,1). "h)";
		}
		
        $str =  $PH->getLink('taskViewEfforts', $estimated_str . " / " . round($sum/60/60,1) . "h {$diff_str}", array('task'=>$obj->id));
		$percent = __('Completion:') . " " . $obj->completion . "%";
		
		print "<td class=nowrap title='" .__("Relation between estimated time and booked efforts") . "'>$str<br><span class='sub who'>$percent</span></td>";
	}
}


class ListBlockCol_DaysLeft extends ListBlockCol
{
    public $key='planned_start';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->tooltip=__("Days until planned start");
        $this->name=__("Due","column header, days until planned start");
    }

	function render_tr(&$obj, $style="")
	{
        measure_start('col_timedue');
        $due_str=$obj->planned_start;

        if($due_str == "0000-00-00" || $due_str == "0000-00-00 00:00:00") {
		    print "<td></td>";
        }
        else {
            $due_days= floor( (strToGMTime($obj->planned_start) - time())/24/60/60)+1;
            if($due_days==0) {
                $value="Today";
                $title="title='Hurry up!'";
                $class='';
            }
            else {
                $class='';
                if($due_days<0) {
                    $class='overDue';
                }
                $value="$due_days<span class='entity'>D</span>";
                if(!$obj->planned_end || $obj->planned_end !='0000-00-00' || '0000-00-00 00:00:00') {
                    $title="title='".renderDate($obj->planned_end)." - ".renderDate($obj->planned_start).  "'";
                    $value.="+";
                }
                else {
                    $title="'".sprintf(__("planned for %s","a certain date"), renderTimestamp($obj->planned_start))."'";
                }
            }
		    print "<td class='timeDue $class' $title>$value</td>";
        }
        measure_stop('col_timedue');

	}
}


class ListBlockCol_EstimatedComplete extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('Est/Compl');
        $this->id='estimate_complete';
        $this->tooltip=__("Estimated time / completed");
    }


	function render_tr(&$obj, $style="nowrap") {
		if(!isset($obj) || !$obj instanceof Task) {
   			return;
		}

        $str= renderEstimationGraph($obj->estimated, $obj->estimated_max, $obj->completion );
				
		print "<td>$str</td>";
	}
}






class ListBlockCol_TasknameWithFolder extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Task');
        $this->width ='80%';
        $this->id= 'taskwithfolder';
    }

	function render_tr(&$task, $style="nowrap")
	{
	    global $PH;
		if(!isset($task) || !$task instanceof Task) {
   			return;
		}

        ### task with zero-id is project-root ###
        if(!$task->id) {
            $link=$PH->getLink('projView',"...project...",array('prj'=>$task->project));
            echo '<td><b>'.$link."</b></td>";
        }

		### name ###
        else {
            $name= $task->name;


            if(!$name) {
                $name=__("- no name -","in task lists");
            }

            $html_details= '';
            if($tmp= $task->getFolderLinks()) {
                $html_details .=__('in', 'very short for IN folder...'). ' '. $tmp;
            }

            $isDone= ($task->status >= STATUS_COMPLETED)
                   ? 'isDone'
                   : '';

            $link= $PH->getLink('taskView',$name,array('tsk'=>$task->id));
            #echo "<td class=taskwithfolder><span class='name $isDone'>{$link}</span><br><span class=sub>$html_details</span></td>";
			echo "<td class=taskwithfolder><span class='$isDone'>{$link}</span><br><span class=sub>$html_details</span></td>";
        }
        measure_stop('col_taskname');

	}
}



?>