<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_taskfolders.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_comments.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');

/**\file
* Pages related to displaying Tasks
*
* \NOTE additional Pages for tasks are placed in task_more.inc.php
*/

/**
* view a task @ingroup pages
*/
function TaskView()
{
    global $PH;
    global $auth;


    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

    ### get task ####
    $tsk=get('tsk');

    #$tsk=getOnePassedId('tsk','tasks_*');      # causes error if no task found

    $editable= false;                           # flag, if this task can be edited

    if($task= Task::getEditableById($tsk)) {
        $editable= true;
    }
    else if(!$task=Task::getVisibleById($tsk)) {
        $PH->abortWarning("invalid task-id",ERROR_FATAL);
    }

    if($task->category == TCATEGORY_DOCU) {
        TaskViewAsDocu($task, $editable);
        exit();
    }

    if(!$project= Project::getVisibleById($task->project)) {
        $PH->abortWarning("this task has an invalid project id", ERROR_DATASTRUCTURE);
    }

    ### create from handle ###
    $from_handle= $PH->defineFromHandle(array('tsk'=>$task->id));

	## is viewed by user ##
	$task->nowViewedByUser();

    global $g_wiki_task;
    $g_wiki_task= $task;

    ### set up page and write header ####
    {
        $page= new Page();
    	$page->cur_tab='projects';

        /*
            $page->crumbs= build_task_crumbs($task);
        */
        if($task->category == TCATEGORY_MILESTONE) {
            $page->cur_crumb= 'projViewMilestones';
        }
        else if($task->category == TCATEGORY_VERSION) {
            $page->cur_crumb= 'projViewVersions';
        }
        else if($task->category == TCATEGORY_DOCU) {
            $page->cur_crumb= 'projViewDocu';

        }
        else {
            $page->cur_crumb= 'projViewTasks';
        }
        $page->crumbs= build_project_crumbs($project);
        $page->options= build_projView_options($project);



        global $g_status_names;
        $status=  $task->status != STATUS_OPEN && isset($g_status_names[$task->status])
               ?  ' ('.$g_status_names[$task->status].')'
               :  '';

        $type=$task->getLabel();

        if($folder= $task->getFolderLinks()) {
            $page->type= $folder ." &gt; " . $type . $status ;
        }
        else {
            $page->type=  $status .' '. $type ;
        }

        $page->title= $task->name;
        $page->title_minor_html=$PH->getLink('taskView', sprintf(__('Item-ID %d'), $task->id), array('tsk'=>$task->id));
        if($task->state== -1) {
            $page->title_minor_html .= ' ' . sprintf(__('(deleted %s)','page title add on with date of deletion'),renderTimestamp($task->deleted));
        }


        ### page functions ###
        {
            if($editable) {
                $page->add_function(new PageFunctionGroup(array(
                    'name'      => __('edit:')
                )));
                if($task->category == TCATEGORY_FOLDER) {
                    $page->add_function(new PageFunction(array(
                        'target'=>'taskEdit',
                        'params'=>array('tsk'=>$task->id),
                        'icon'=>'edit',
                        'tooltip'=>__('Edit this task'),
                        'name'=>__('Folder')
                    )));
                }
                else {
                    $page->add_function(new PageFunction(array(
                        'target'=>'taskEdit',
                        'params'=>array('tsk'=>$task->id),
                        'icon'=>'edit',
                        'tooltip'=>__('Edit this task'),
                        'name'=>__('Task')
                    )));
                }

            }


            ### folder ###
            if($task->category == TCATEGORY_FOLDER) {

                $page->add_function(new PageFunction(array(
                    'target'=>'tasksMoveToFolder',
                    'params'=>array('tsk'=>$task->id),
                    'icon'=>'edit',
                    'name'=>__('Move', 'page function to move current task'),
                )));


                $page->add_function(new PageFunctionGroup(array(
                    'name'=>__('new:'),
                )));

                $page->add_function(new PageFunction(array(
                    'target'=>'taskNew',
                    'params'=>array('parent_task'=>$task->id),
                    'icon'=>'new',
                    'tooltip'=>__('new subtask for this folder'),
                    'name'=>__('Task'),
                )));

                $page->add_function(new PageFunction(array(
                    'target'=>'taskNewBug',
                    'params'=>array('parent_task'=>$task->id),
                    'icon'=>'new',
                    'tooltip'=>__('new bug for this folder'),
                    'name'=>__('Bug'),
                )));
            }

            ### milestone ###
            else if($task->is_milestone) {
                $page->add_function(new PageFunctionGroup(array(
                    'name'=>__('new:'),
                )));

                $page->add_function(new PageFunction(array(
                    'target'=>'taskNew',
                    'params'=>array('parent_task'=>$task->id, 'for_milestone'=>$task->id),
                    'icon'=>'new',
                    'tooltip'=>__('new task for this milestone'),
                    'name'=>__('Task'),
                )));

                $page->add_function(new PageFunction(array(
                    'target'=>'taskNewBug',
                    'params'=>array('parent_task'=>$task->id),
                    'icon'=>'new',
                    'tooltip'=>__('new bug for this folder'),
                    'name'=>__('Bug'),
                )));
            }

            ### normal task ###
            else {
                if($editable) {
                    $page->add_function(new PageFunction(array(
                        'target'=>'tasksMoveToFolder',
                        'params'=>array('tsk'=>$task->id),
                        'icon'=>'edit',
                        'name'=>__('Move', 'page function to move current task'),
                    )));
                }

            }

			$item = ItemPerson::getAll(array('person'=>$auth->cur_user->id,'item'=>$task->id));
			if((!$item) || ($item[0]->is_bookmark == 0)){
				$page->add_function(new PageFunction(array(
					'target'    =>'itemsAsBookmark',
					'params'    =>array('task'=>$task->id),
					'tooltip'   =>__('Mark this task as bookmark'),
					'name'      =>__('Bookmark'),
        		)));
			}
			else{
				$page->add_function(new PageFunction(array(
					'target'    =>'itemsRemoveBookmark',
					'params'    =>array('task'=>$task->id),
					'tooltip'   =>__('Remove this bookmark'),
					'name'      =>__('Remove Bookmark'),
        		)));
			}

            if($editable) {
                if($task->state == 1) {
                    $page->add_function(new PageFunction(array(
                        'target'=>'tasksDelete',
                        'params'=>array('tsk'=>$task->id),
                        'icon'=>'delete',
                        'tooltip'=>__('Delete this task'),
                        'name'=>__('Delete')
                    )));
                }
                if($task->state == -1) {
                    $page->add_function(new PageFunction(array(
                        'target'=>'tasksUndelete',
                        'params'=>array('tsk'=>$task->id),
                        'icon'=>'undelete',
                        'tooltip'=>__('Restore this task'),
                        'name'=>__('Undelete')
                    )));
                }
            }
        }


    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);



    #--- info block ------------
    {
        $block=new PageBlock(array(
            'title'=>__("Summary","Block title"),
            'id'=>'summary',
            'reduced_header'=>true,
        ));
        $block->render_blockStart();

        echo "<div class=text>";


        ### milestones and versions ###
        if($task->is_milestone) {
            global $g_released_names;
            if($task->is_released && isset($g_released_names[$task->is_released])) {
                echo "<p><label>".__("Released as","Label in Task summary")."</label>".$g_released_names[$task->is_released] ." / ". renderDateHtml($task->time_released). "</p>";
            }



        }
        ### normal tasks ###
        else {

            if($task->for_milestone) {
                if($milestone= Task::getVisibleById($task->for_milestone)) {
                    echo "<p><label>".__("For Milestone","Label in Task summary")."</label>".$milestone->getLink(false)."</p>";
                }
            }


            global $g_status_names;
            if($status=$g_status_names[$task->status]) {
                echo "<p><label>".__("Status","Label in Task summary")."</label>$status</p>";
            }


            echo "<p><label>".__("Opened","Label in Task summary")."</label>".renderDateHtml($task->date_start)."</p>";

            if($task->estimated) {
                echo "<p><label>".__("Estimated","Label in Task summary")."</label>".renderDuration($task->estimated). ' ';

                if($task->estimated_max) {
                    echo " ... ". renderDuration($task->estimated_max);
                }
                echo "</p>";
            }

            if($task->completion) {
                echo "<p><label>".__("Completed","Label in Task summary")."</label>".$task->completion."%</p>";
            }


            if($task->planned_start && $task->planned_start != "0000-00-00 00:00:00") {
                echo "<p><label>".__("Planned start","Label in Task summary")."</label>".renderTimestamp($task->planned_start)."</p>";
            }

            if($task->planned_end && $task->planned_end != "0000-00-00 00:00:00") {
                echo "<p><label>".__("Planned end","Label in Task summary")."</label>".renderTimestamp($task->planned_end)."</p>";
            }


            if($task->date_closed !="0000-00-00") {
                echo "<p><label>".__("Closed","Label in Task summary")."</label>". renderDateHtml($task->date_closed) . "</p>";
            }
        }

        if($person_creator= Person::getVisibleById($task->created_by)) {
            echo "<p><label>".__("Created","Label in Task summary")."</label>". renderDateHtml($task->created) . ' / ' . $person_creator->getLink().'</p>' ;
        }




        #if($task->modified_by != $task->created_by) {
            if($person_modify= Person::getVisibleById($task->modified_by)) {
                echo "<p><label>".__("Modified","Label in Task summary")."</label>". renderDateHtml($task->modified) . ' / ' .  $person_modify->getLink() . '</p>' ;
                #echo "<p><label>" . $str_version . "</label>". renderDateHtml($task->modified) . ' / ' .  $person_modify->getLink() . '</p>' ;
            }

        ### get version ###
        {
            require_once(confGet('DIR_STREBER') . "db/db_itemchange.inc.php");
            $versions= ItemVersion::getFromItem($task);
            if(count($versions) > 1) {
                $str_version=     $PH->getLink('itemViewDiff',
                                    sprintf(__("View previous %s versions"), count($versions)),
                                    array('item' => $task->id)
                                );
                echo "<p><label></label>$str_version</p>";
            }
        }


        #}

        $sum_efforts= $task->getSumEfforts();
        if($sum_efforts) {
            echo "<p><label>".__("Logged effort","Label in task-summary")."</label>".
            $PH->getLink('taskViewEfforts',round($sum_efforts/60/60,1), array('task'=>$task->id))
            ."</p>" ;
        }

        if($tps= $task->getAssignedPersons()) {
            $value="";
            $sep="";
            foreach($tps as $tp) {
                $value.= $sep . $tp->getLink();
                $sep=", ";
            }
            $label=__("Assigned to");
            echo "<p><label>$label</label>$value</p>" ;


        }

        ### publish to ###
        global $g_pub_level_names;
        if($task->pub_level != PUB_LEVEL_OPEN && isset($g_pub_level_names[$task->pub_level])) {
            echo "<p><label>".__("Publish to","Label in Task summary")."</label>".$g_pub_level_names[$task->pub_level] ;
            if($editable) {
                echo '<br>('
                    . $PH->getLink('itemsSetPubLevel',__('Set to Open'), array('item' => $task->id,'item_pub_level' => PUB_LEVEL_OPEN))
                    . ')';
            }
            echo "</p>";
        }


        echo "</div>";

        $block->render_blockEnd();
    }

    #--- navigation structure for documentation --------------------------------------------
    if($task->category == TCATEGORY_FOLDER) {
        require_once(confGet('DIR_STREBER') . 'lists/list_docustructure.inc.php');
        $list=new Block_docuNavigation(array(
            'current_task'=> $task,
            'root'          => $task,
        ));

        $list->title = __("Further Documentation");


        $list->print_all();
    }


    #--- list files --------------------------------------------------------------------------
    {
        require_once(confGet('DIR_STREBER') . 'lists/list_files.inc.php');
        $list= new ListBlock_files();
        $list->reduced_header= true;
        #$list->query_options['visible_only']= false;
        $list->query_options['parent_item']= $task->id;
        $list->show_functions=false;

        unset($list->columns['status']);
        unset($list->columns['mimetype']);
        unset($list->columns['filesize']);
        unset($list->columns['created_by']);
        #unset($list->columns['download']);
        unset($list->columns['version']);
        unset($list->columns['_select_col_']);
        unset($list->columns['modified']);
        unset($list->columns['name']);
        unset($list->columns['thumbnail']);

        unset($list->block_functions['list']);
        unset($list->block_functions['grouped']);
        unset($list->functions['fileEdit']);
        unset($list->functions['filesDelete']);

        $list->reduced_header= false;
        $list->title=__('Attached files');

        if($editable) {
            $list->no_items_html= $list->summary='<div style="text-align:left;margin-left:3px">'.__('attach new').':<br />'
            .'<input type="hidden" name="parent_task" value="' .$task->id. '">'
    		.'<input type="hidden" name="MAX_FILE_SIZE" value="'.confGet('FILE_UPLOAD_SIZE_MAX').'" />'
    		.'<input id="userfiletask" name="userfile" type="file" size="15" accept="*" /><br />'
            .'<input style="margin-top:5px;margin-bottom:5px;margin-left:0px" class="button" type="button" value="' .__('Upload'). '" onclick=\'document.my_form.go.value="filesUpload";document.my_form.submit();\'/>'
            .'</div>';
        }

        $list->print_automatic($project);
        $PH->go_submit= $PH->getValidPage('filesUpload')->id;
	}

    echo(new PageContentNextCol);


    #--- description ----------------------------------------------------------------
    if($task->description!="") {

        echo "<div class=description>";
        if($editable) {
            echo  wiki2html($task->description, $project, $task->id, 'description');
        }
        else {
            echo  wiki2html($task->description, $project);
        }
        echo "</div>";

        ### update task if relative links have been converted to ids ###
        global $g_wiki_auto_adjusted;
        if(isset($g_wiki_auto_adjusted) && $g_wiki_auto_adjusted) {
            $task->description= $g_wiki_auto_adjusted;
            $task->update(array('description'),false);
        }
    }

    ### edit description button ###
    if($editable) {
        echo "<div class=edit_functions>";
        echo $PH->getLink('taskEditDescription',NULL,array('tsk'=> $task->id),'edit_description');
        echo "</div>";

/**
early development version of inline edit handler.

echo "
<script type='text/javascript'>
// <![CDATA[
onLoadFunctions.push(function()
{
    var chapter= $('div.wiki')[0];

    $('body.taskView div.edit_functions a.edit_description').editable('index.php?go=itemSaveField&item={$task->id}&field=description', {
        postload:'index.php?go=itemLoadField&item={$task->id}&field=description',
        type:'textarea',
        obj:chapter,
        submit:'Save',
        cancel:'Cancel'
    });
    alert('here');

});

// ]]>
</script>
";
*/


    }


    #--- issue report -------------------------------------------------------------
    if($task->category == TCATEGORY_BUG && $task->issue_report) {
        require_once(confGet('DIR_STREBER') . 'db/class_issue.inc.php');
        $issue= new Issue($task->issue_report);


        $buffer="";

        if($issue->severity) {
            global $g_severity_names;
            if(isset($g_severity_names[$issue->severity])) {
                $buffer.= '<div class=labeled><label>' . __("Severity","label in issue-reports") . '</label>'. $g_severity_names[$issue->severity]. '</div>';
            }
        }

        if($issue->severity) {
            global $g_reproducibility_names;
            if(isset($g_reproducibility_names[$issue->reproducibility])) {
                $buffer.= '<div class=labeled><label>' . __("Reproducibility","label in issue-reports") . '</label>'. $g_reproducibility_names[$issue->reproducibility]. '</div>';
            }
        }


        if($issue->plattform) {
            $buffer.= '<div class=labeled><label>' . __('Plattform') . '</label>'.asHtml($issue->plattform).'</div>';
        }
        if($issue->os) {
            $buffer.= '<div class=labeled><label>' . __('OS') . '</label>'. asHtml($issue->os).'</div>';
        }
        if($issue->version) {
            $buffer.= '<div class=labeled><label>' . __('Version') . '</label>'. asHtml($issue->version).'</div>';
        }
        if($issue->production_build) {
            $buffer.= '<div class=labeled><label>' . __('Build') . '</label>'. asHtml($issue->production_build). '</div>';
        }

        if($issue->steps_to_reproduce) {
            $text= wiki2html($issue->steps_to_reproduce, $project);
            $buffer.= "<div class=labeled><label>" . __("Steps to reproduce","label in issue-reports") . "</label>$text</div>";
        }
        if($issue->expected_result) {
            $text= wiki2html($issue->expected_result, $project);
            $buffer.= "<div class=labeled><label>" . __("Expected result","label in issue-reports") . "</label>$text</div>";
        }
        if($issue->suggested_solution) {
            $text= wiki2html($issue->suggested_solution, $project);
            $buffer.= "<div class=labeled><label>" . __("Suggested Solution","label in issue-reports") . "</label>$text</div>";
        }



        if($buffer) {

            $block=new PageBlock(array(
                'title'=>__('Issue report'),
                'id'=>'issue_report'

            ));
            $block->render_blockStart();

            echo "<div class=text>";
            echo $buffer;
            echo "</div>";

            $block->render_blockEnd();
        }
    }


    #--- list tasks -------------------------------------------------------------
    if($task->category== TCATEGORY_FOLDER || $task->getNumSubtasks() > 0 ) {

        $list= new ListBlock_tasks(array(
            'active_block_function'=>'tree',
            'title'=>__('Sub tasks'),

        ));
        unset($list->columns['project']);
        unset($list->columns['created_by']);
        unset($list->columns['planned_start']);
        unset($list->columns['modified']);
        unset($list->columns['estimate_complete']);
        unset($list->columns['pub_level']);
        $list->filters[]= new ListFilter_status_max(array(
            'value'=>STATUS_COMPLETED,
        ));
        $list->filters[]= new ListFilter_category_in(array(
            'value'=>array(TCATEGORY_FOLDER, TCATEGORY_TASK, TCATEGORY_BUG),
        ));
        $list->print_automatic($project, $task);

    }

    #--- list milestone-tasks ---------------------------------------------------
    if($task->category== TCATEGORY_MILESTONE || $task->category== TCATEGORY_VERSION) {

        $list= new ListBlock_tasks(array(
            'active_block_function'=>'tree',
            'title'=> __('Open tasks for milestone'),
        ));

        $list->no_items_html=__('No open tasks for this milestone');
        unset($list->columns['project']);
        unset($list->columns['created_by']);
        unset($list->columns['planned_start']);
        unset($list->columns['modified']);
        unset($list->columns['for_milestone']);
        unset($list->columns['pub_level']);
        $list->filters[]= new ListFilter_status_max(array('value'=>STATUS_COMPLETED));
        $list->filters[]= new ListFilter_for_milestone(array('value'=>$task->id));
        $list->print_automatic($project, NULL, true);

    }

    #--- list change log ---------------
    if ($task->category== TCATEGORY_VERSION)
    {

        ### get resolved tasks ###
        if($resolved= Task::getAll(array(
            'project'               => $task->project,
            'resolved_version'      => $task->id,
            'status_min'            => 0,
            'status_max'            => 200,
            'order_by'              => 'resolve_reason',
        ))) {
            $block=new PageBlock(array(
                'title'=>__("Resolved tasks","Block title"),
                'id'=>'resolved_tasks',
            ));
            $block->render_blockStart();

            echo "<div class=text>";

            $buffer= "<ul>";
            foreach($resolved as $r) {
                if($r->resolve_reason && isset($g_resolve_reason_names[$r->resolve_reason])) {
                    $reason= $g_resolve_reason_names[$r->resolve_reason] .": ";
                }
                else {
                    $reason= "";
                }
                $buffer.='<li>'. $reason . $r->getLink(false) .'</li>';
            }
            $buffer.="</ul>";
            echo $buffer;

            echo "</div>";

            $block->render_blockEnd();
        }
    }


    #--- list comments -------------------------------------------------------------
    {

        $order_str=get("sort_".$PH->cur_page->id ."_comments");
        if(!$order_str) {
            $order_str= 'created ASC';
        }


		if($auth->cur_user->user_rights & RIGHT_VIEWALL) {
			$comments= $task->getComments(array(
	            'order_by'=>$order_str,
	            'visible_only'=>false,
	        ));
		}
		else{
	        $comments= $task->getComments(array(
	            'order_by'=>$order_str,
	        ));
		}
        if(count($comments) != 0) {

            $list_comments= new ListBlock_comments();
			if(count($comments) == 1){
			     $list_comments->title= __("1 Comment") ;
			}
            else {
			     $list_comments->title= sprintf(__("%s Comments"), count($comments)) ;
			}


    		$list_comments->no_items_html=$PH->getLink('commentNew','',array('parent_task'=>$task->id));
            $list_comments->render_list(&$comments);
        }
    }


	#--- task qickedit form -------------------------------------------------------------
	{

		### visible only for real tasks, not for folders and milestones ###
		if( ($task->category != TCATEGORY_FOLDER || $task->category == TCATEGORY_DOCU)
		    &&
		    !$task->is_milestone
		) {
			$block_task_quickedit= new Block_task_quickedit();
    	    $block_task_quickedit->render_quickedit(&$task);
		}
	}



    #echo '<input type="hidden" name="prj" value="'.$task->project.'">';

    /**
    * give parameter for create of new items (subtasks, efforts, etc)
    */
    #echo '<input type="hidden" name="parent_task" value="'.$task->id.'">';


    echo (new PageContentClose);
	echo (new PageHtmlEnd);
}



/**
* Renders a quick edit form for one task
*
* @author         Tino Beirau
*/
class Block_task_quickedit extends PageBlock
{

	public function __construct($args=NULL)
	{
        global $PH;
        $this->id='quick_edit';
        $this->bg_style='bg_projects';
		$this->title= __("Comment / Update");
		$this->reduced_header = true;
    }



	public function render_quickedit($task)
	{
        global $PH;

        $editable= false;

        ### make sure it's editable ###
        if(Task::getEditableById($task->id)) {
            $editable= true;
        }
        else if(! Task::getVisibleById($task->id)) {
            return false;
        }

	    ### get parent project ####
	    if(!$project= Project::getVisibleById($task->project)) {
	        return;
	    }

	    ### abort, if not enough rights ###
	    #$project->validateEditItem($task);

	    ### set up ListBlock ####
	    {
	        #$block=new PageBlock(array(
	        #    'title'=>__('quick edit'),
	        #    'id'=>'quick_edit'
	        #));
	        $this->render_blockStart();
	    }

		### write form #####
		{
		    require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');

		    global $REPRODUCIBILITY_VALUES;

		    global $g_prio_names;
		    global $g_status_names;


		    $form=new PageForm();
		    $form->button_cancel=false;

            $form->add($tab_group=new Page_TabGroup());

            ### add comment ###
            {
                $tab_group->add($tab=new Page_Tab("comment",__("Add comment")));

    			### Comment ###
    		    $comment_name= '';
    			$comment= new Comment(array(
    		        'id'=>0,
    		        'name'=>$comment_name,
    		    ));

    			$tab->add($comment->fields['name']->getFormElement(&$comment,__('Comment')));
    			$e= $comment->fields['description']->getFormElement(&$comment);
    	        $e->rows=8;
    	        $tab->add($e);

            }

            ### update ###
            {
                $tab_group->add($tab=new Page_Tab("update",__("Update")));

                if($task->category == TCATEGORY_TASK || $task->category == TCATEGORY_BUG && $editable) {

                    ### milestone / resolved in version ###
                    {
                        if($milestones= Task::getAll(array(
                            'is_milestone'  =>1,
                            'project'       =>$project->id,
                            'status_min'    =>STATUS_NEW,
                            'status_max'    =>STATUS_CLOSED,
                        ))) {

                            $tmp_milestonelist= array(('-- ' . __('undefined') . ' --' )=>'0');

                            $tmp_resolvelist= array(
                                        ('-- ' . __('undefined')             . ' --') => '0',
                                        ('-- ' . __('next released version') . ' --') => -1);
                            foreach($milestones as $m) {
                                if($m->is_released >= RELEASED_UPCOMMING) {
                                    $tmp_resolvelist[$m->name]= $m->id;
                                }
                                if($m->status >= STATUS_NEW && $m->status <= STATUS_APPROVED) {
                                    $tmp_milestonelist[$m->name]= $m->id;
                                }
                            }
                            $tab->add(new Form_Dropdown('task_for_milestone', __('For Milestone'),$tmp_milestonelist,$task->for_milestone));


                            $tab->add(new Form_Dropdown('task_resolved_version', __('Resolved in'),$tmp_resolvelist,$task->resolved_version));

                            global $g_resolve_reason_names;
                            $tab->add(new Form_Dropdown('task_resolve_reason', __('Resolve reason'),array_flip($g_resolve_reason_names), $task->resolve_reason));
                        }
                    }

        	        ### public-level ###
        	       	#{
        	 		#	if(($pub_levels=$task->getValidUserSetPublevel()) && count($pub_levels)>1) {
        	        #    	$form->add(new Form_Dropdown('task_pub_level',  __("Public to"),$pub_levels,$task->pub_level));
           	        #	}
        			#}

        	        ### assigned to ###
        	        {
        	            ### for existing tasks, get already assigned
        	            if($task->id) {
        	                $assigned_persons = $task->getAssignedPersons();
        	            }

        	            ### for new tasks get the assignments from parent task ###
        				else {
        				    trigger_error("view a task with zero id?");
        	            }

        	            $team=array(__('- select person -')=>0);

        	            ### create team-list ###
        	            foreach($project->getPersons() as $p) {
        	                $team[$p->name]= $p->id;
        	            }


        	            ### create drop-down-lists ###
        	            $count_new=0;
        	            $count_all=0;
        	            if(isset($assigned_persons)) {
        	                foreach($assigned_persons as $ap) {
        	                    if(!$p= Person::getVisibleById($ap->id)) {
        	                        continue;                               # skip if invalid person
        	                    }

        	                    if($task->id) {
        	                        $tab->add(new Form_Dropdown('task_assigned_to_'.$ap->id, __("Assigned to"),$team, $ap->id));
        		                }
        		                else {
        	                        $tab->add(new Form_Dropdown('task_assign_to_'.$count_new, __("Assign to"),$team, $ap->id));
        	                        $count_new++;
        	                    }
        	                    $count_all++;
        	                    unset($team[$ap->name]);
        	                }
        	            }


        	            ### add empty drop-downlist for new assignments ###
        	            $str_label  = ($count_all == 0)
        	                        ? __("Assign to","Form label")
        	                        : __("Also assign to","Form label");
        	            $tab->add(new Form_Dropdown("task_assign_to_$count_new",  $str_label,$team, 0));
        	        }


        			### priority ###
        		    {
        		    	if(!$task->is_milestone) {
        		            $tab->add(new Form_Dropdown('task_prio',  __("Prio","Form label"),  array_flip($g_prio_names), $task->prio));
        		        }
        			}

        		    ### estimated ###
        		    {
        	            #$tab->add($task->fields['estimated'    ]->getFormElement(&$task));
        	            $ar= array(
        	                __('undefined')=> 0,
        	                __('30 min')    => 30*60,
        	                __('1 h')  => 60*60,
        	                __('2 h') => 2*60*60,
        	                __('4 h') => 4*60*60,
        	                __('1 Day')     =>   1 * confGet('WORKHOURS_PER_DAY') * 60 * 60,
        	                __('2 Days')    =>   2 * confGet('WORKHOURS_PER_DAY') * 60 * 60,
        	                __('3 Days')    =>   3 * confGet('WORKHOURS_PER_DAY') * 60 * 60,
        	                __('4 Days')    =>   4 * confGet('WORKHOURS_PER_DAY') * 60 * 60,
        	                __('1 Week')   =>   1 * confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60,
        	                #__('1,5 Weeks')=> 1.5 * confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60,
        	                __('2 Weeks')  =>   2 * confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60,
        	                __('3 Weeks')  =>   3 * confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60,
        	            );
        	            $tab->add(new Form_Dropdown('task_estimated',__("Estimated time"),$ar,  $task->estimated));
        	            $tab->add(new Form_Dropdown('task_estimated_max',__("Estimated worst case"),$ar,  $task->estimated_max));

        	        }

        	        ### completion ###
        	        {
        	            $ar= array(
        	                __('undefined')=> -1,
        	                '0%'    => 0,
        	                '10%'    => 10,
        	                '20%'    => 20,
        	                '30%'    => 30,
        	                '40%'    => 40,
        	                '50%'    => 50,
        	                '60%'    => 60,
        	                '70%'    => 70,
        	                '80%'    => 80,
        	                '90%'    => 90,
        	                '95%'    => 95,
        	                '98%'    => 98,
        	                '99%'    => 99,
        	                '100%'   => 100,
        	            );
        	            $tab->add(new Form_Dropdown('task_completion',__("Completed"),$ar,  $task->completion));
        	        }

        	        $tab->add($task->fields['parent_task']->getFormElement(&$task));


        	        ### status ###
        	        {
        	            $st=array();
        	            foreach($g_status_names as $s=>$n) {
        	                if($s >= STATUS_NEW) {
        	                    $st[$s]=$n;
        	                }
        	            }
        	            if($task->is_milestone) {
        	                unset($st[STATUS_NEW]);
        	            }

        	            $tab->add(new Form_Dropdown('task_status',"Status",array_flip($st),  $task->status));
        	        }

                }
            }

            /**
            * to reduce spam, enforce captcha test for guests
            */
            global $auth;
            if($auth->cur_user->id == confGet('ANONYMOUS_USER')) {
                $form->addCaptcha();
            }

			### some required hidden fields for correct data passing ###
			$form->add(new Form_HiddenField('tsk','',$task->id));
		    echo($form);

		    $PH->go_submit= 'taskEditSubmit';
		    echo "<input type=hidden name='comment' value='$comment->id'>";

			if($return=get('return')) {
		        echo "<input type=hidden name='return' value='$return'>";
		    }

			### end of ListBlock ###
			{
				$this->render_blockEnd();
			}
	    }
	}
}

/**
* view task a documentation page @ingroup pages
*/
function taskViewAsDocu()
{
    global $PH;
    global $auth;

    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

    ### get task ####
    $tsk=get('tsk');

    $editable= false;                           # flag, if this task can be edited

    if($task= Task::getEditableById($tsk)) {
        $editable= true;
    }
    else if(!$task=Task::getVisibleById($tsk)) {
        $PH->abortWarning("invalid task-id",ERROR_FATAL);
    }


    if(!$project= Project::getVisibleById($task->project)) {
        $PH->abortWarning("this task has an invalid project id", ERROR_DATASTRUCTURE);
    }

    ### create from handle ###
    $from_handle= $PH->defineFromHandle(array('tsk'=>$task->id));

    global $g_wiki_task;
    $g_wiki_task= $task;

    ### set up page and write header ####
    {
        $page= new Page();
    	$page->cur_tab='projects';

        $page->crumbs   = build_project_crumbs($project);
        $page->cur_crumb= 'projViewDocu';
        $page->options  = build_projView_options($project);

        ### breadcrumbs ###
        $type = $task->getLabel();

        if($folder= $task->getFolderLinks()) {
            $page->type= $folder ." &gt; " . $type ;
        }
        else if($type) {
            $page->type=  $type;
        }
        else {
            global $g_tcategory_names;
            $page->type=  $g_tcategory_names[$task->category];

        }

        $task->nowViewedByUser();

        $page->title = $task->name;
        $page->title_minor_html=$PH->getLink('taskView', sprintf(__('Item-ID %d'), $task->id), array('tsk'=>$task->id));
        if($task->state == -1) {
            $page->title_minor_html .= ' ' . sprintf(__('(deleted %s)','page title add on with date of deletion'),renderTimestamp($task->deleted));
        }

        ### page functions ###
        {
            ### edit ###
            if($editable) {
                $page->add_function(new PageFunction(array(
                    'target'=>'taskEdit',
                    'params'=>array('tsk'=>$task->id),
                    'icon'=>'edit',
                    'tooltip'=>__('Edit this task'),
                    'name'=>__('Edit')
                )));
                $page->add_function(new PageFunction(array(
                    'target'=>'tasksMoveToFolder',
                    'params'=>array('tsk'=>$task->id),
                    'icon'=>'edit',
                    'name'=>__('Move', 'page function to move current task'),
                )));

                if($task->state == 1) {
                    $page->add_function(new PageFunction(array(
                        'target'=>'tasksDelete',
                        'params'=>array('tsk'=>$task->id),
                        'icon'=>'delete',
                        'tooltip'=>__('Delete this task'),
                        'name'=>__('Delete')
                    )));
                }
                else if($task->state == -1) {
                    $page->add_function(new PageFunction(array(
                        'target'=>'tasksUndelete',
                        'params'=>array('tsk'=>$task->id),
                        'icon'=>'undelete',
                        'tooltip'=>__('Restore this task'),
                        'name'=>__('Undelete')
                    )));
                }
            }

            ### new ###
            $page->add_function(new PageFunctionGroup(array(
                'name'=>__('new:'),
            )));
            if($task->category == TCATEGORY_FOLDER) {

                $page->add_function(new PageFunction(array(
                    'target'=>'taskNew',
                    'params'=>array(
                        'parent_task'=>$task->id,
                        'task_category' =>TCATEGORY_DOCU,
                    ),
                    'icon'=>'edit',
                    'name'=>__('Page'),
                )));
            }
            else if($task->parent_task) {
                $page->add_function(new PageFunction(array(
                    'target'=>'taskNew',
                    'params'=>array(
                        'parent_task' => $task->parent_task,
                        'task_category' =>TCATEGORY_DOCU,
                    ),
                    'icon'=>'edit',
                    'name'=>__('Page'),
                )));
            }
            else {
                $page->add_function(new PageFunction(array(
                    'target'=>'taskNew',
                    'params'=>array(
                        'prj'=>$task->project,
                        'task_category' =>TCATEGORY_DOCU,
                    ),
                    'icon'=>'edit',
                    'name'=>__('Page'),
                )));
            }

            if($project->settings & PROJECT_SETTING_EFFORTS) {
                $page->add_function(new PageFunction(array(
                    'target'=>'effortNew',
                    'params'=>array(
                        'parent_task'=>$task->id,

                    ),
                    'icon'=>'effort',
                    'name'=>__('Book Effort'),
                )));
            }

        }

    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);


    #--- navigation structure for documentation --------------------------------------------
    {
        require_once(confGet('DIR_STREBER') . 'lists/list_docustructure.inc.php');
        $list=new Block_docuNavigation(array(
            'current_task'=> $task
        ));

        $list->print_all();
    }



    #--- info block ------------
    {
        $block=new PageBlock(array(
            'id'=>'summary',
            'reduced_header'=>true,
        ));
        $block->render_blockStart();

        echo "<div class=text>";

        if($person_creator= Person::getVisibleById($task->created_by)) {
            echo "<p><label>".__("Created","Label in Task summary")."</label>". renderDateHtml($task->created) . ' / ' . $person_creator->getLink().'</p>' ;
        }

        if($person_modify= Person::getVisibleById($task->modified_by)) {
            echo "<p><label>".__("Modified","Label in Task summary")."</label>". renderDateHtml($task->modified) . ' / ' .  $person_modify->getLink() . '</p>' ;
        }

        ### get version ###
        {
            require_once(confGet('DIR_STREBER') . "db/db_itemchange.inc.php");
            $versions= ItemVersion::getFromItem($task);
            if(count($versions) > 1) {
                $str_version=     $PH->getLink('itemViewDiff',
                                    sprintf(__("View previous %s versions"), count($versions)),
                                    array('item' => $task->id)
                                );
                echo "<p><label></label>$str_version</p>";
            }
        }


        ### publish to ###
        global $g_pub_level_names;
        if($task->pub_level != PUB_LEVEL_OPEN && isset($g_pub_level_names[$task->pub_level])) {
            echo "<p><label>".__("Publish to","Label in Task summary")."</label>".$g_pub_level_names[$task->pub_level] ;
            if($editable) {
                echo '<br>('
                    . $PH->getLink('itemsSetPubLevel',__('Set to Open'), array('item' => $task->id,'item_pub_level' => PUB_LEVEL_OPEN))
                    . ')';
            }
            echo "</p>";
        }


        echo "</div>";

        $block->render_blockEnd();
    }

    #--- list files --------------------------------------------------------------------------
    {
        require_once(confGet('DIR_STREBER') . 'lists/list_files.inc.php');
        $files= File::getall(array('parent_item'=>$task->id));

        $list= new ListBlock_files();
        $list->reduced_header= true;
        $list->query_options['parent_item']= $task->id;
        $list->show_functions=false;

        unset($list->columns['status']);
        unset($list->columns['mimetype']);
        unset($list->columns['filesize']);
        unset($list->columns['created_by']);
        #unset($list->columns['download']);
        unset($list->columns['version']);
        unset($list->columns['_select_col_']);
        unset($list->columns['modified']);
        unset($list->columns['name']);
        unset($list->columns['thumbnail']);

        unset($list->block_functions['list']);
        unset($list->block_functions['grouped']);
        unset($list->functions['fileEdit']);
        unset($list->functions['filesDelete']);

        $list->reduced_header= false;
        $list->title=__('Attached files');

        $list->no_items_html= $list->summary='<div style="text-align:left;margin-left:3px">'.__('attach new').':<br />'
        .'<input type="hidden" name="parent_task" value="' .$task->id. '">'
		.'<input type="hidden" name="MAX_FILE_SIZE" value="'.confGet('FILE_UPLOAD_SIZE_MAX').'" />'
		.'<input id="userfiletask" name="userfile" type="file" size="10" accept="*" /><br />'
        .'<input style="margin-top:5px;margin-bottom:5px;margin-left:0px" class="button" type="button" value="' .__('Upload'). '" onclick=\'document.my_form.go.value="filesUpload";document.my_form.submit();\'/>'
        .'</div>';

        $list->print_automatic($project);
        $PH->go_submit= $PH->getValidPage('filesUpload')->id;
	}


    echo(new PageContentNextCol);


    #--- description ----------------------------------------------------------------
    if($task->description!="") {

        echo "<div class=description>";
        if($editable) {
            echo  wiki2html($task->description, $project, $task->id, 'description');
        }
        else {
            echo  wiki2html($task->description, $project);
        }
        echo "</div>";


        global $g_wiki_auto_adjusted;
        if(isset($g_wiki_auto_adjusted) && $g_wiki_auto_adjusted) {
            $task->description= $g_wiki_auto_adjusted;
            $task->update(array('description'),false);
        }
    }

    ### edit description button ###
    if($editable) {
        echo "<div class=edit_functions>";
        echo $PH->getLink('taskEditDescription',NULL,array('tsk'=> $task->id));
        echo "</div>";
    }

    #--- list comments -------------------------------------------------------------
    {

        $order_str=get("sort_".$PH->cur_page->id ."_comments");
        if(!$order_str) {
            $order_str= 'created ASC';
        }


		if($auth->cur_user->user_rights & RIGHT_VIEWALL) {
			$comments= $task->getComments(array(
	            'order_by'=>$order_str,
	            'visible_only'=>false,
	        ));
		}
		else{
	        $comments= $task->getComments(array(
	            'order_by'=>$order_str,
	        ));
		}
        if(count($comments) != 0) {

            $list_comments= new ListBlock_comments();
			if(count($comments) == 1){
			     $list_comments->title= __("1 Comment") ;
			}
            else {
			     $list_comments->title= sprintf(__("%s Comments"), count($comments)) ;
			}


    		$list_comments->no_items_html=$PH->getLink('commentNew','',array('parent_task'=>$task->id));
            $list_comments->render_list(&$comments);
        }
    }


	#--- task qickedit form -------------------------------------------------------------
	{
		$block_task_quickedit= new Block_task_quickedit();
	    $block_task_quickedit->render_quickedit(&$task);
	}

    echo (new PageContentClose);
	echo (new PageHtmlEnd);
}



?>
