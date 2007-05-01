<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt


require_once(confGet('DIR_STREBER') . 'db/class_issue.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');


/**
 * derived ListBlock-class for listing milestones (aka roadmap)
 *
 * @includedby:     pages/proj.inc
 *
 * @author         Thomas Mann
 * @uses:           ListBlock
 * @usedby:
 *
 */
class ListBlock_milestones extends ListBlock
{

    public $filters= array();                               # assoc arry of ListFilters
    public $active_block_function = 'grouped';              #@@@ HACK
    public $tasks_assigned_to= NULL;

    public $tasks_open;
    public $tasks_closed;
    public $num_open;
    public $num_completed;
    public $num_closed;
    public $sum_completion_min;
    public $sum_completion_max;
    public $sum_estimated_min;
    public $sum_estimated_max;

    public function __construct($args=NULL)
    {
		parent::__construct($args);

        global $PH;
        $this->id='tasks';
        $this->class='milestones';
        $this->bg_style='bg_projects';
        $this->no_items_html=NULL;
		$this->title				= __("Milestones");


        ### columns ###
        $this->add_col( new ListBlockColSelect());

   	    $this->add_col( new ListBlockCol_MilestoneName(      array('use_short_names'=>false,'indention'=>true)));
        $this->add_col( new listBlockCol_MilestoneDate());

   	    $this->add_col( new ListBlockCol_MilestoneTasksGraph());
	    $this->add_col( new ListBlockCol_TaskAssignedTo(array('use_short_names'=>false )));

        $this->add_col( new ListBlockColPubLevel());


        ### functions ###
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('taskEdit')->id,
            'name'  =>__('Edit'),
            'id'    =>'taskEdit',
            'icon'  =>'edit',
            'context_menu'=>'submit',
        )));

        ### functions ###
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('tasksDelete')->id,
            'name'  =>__('Delete'),
            'id'    =>'taskDelete',
            'icon'  =>'delete',
            'context_menu'=>'submit',
        )));

        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('itemsAsBookmark')->id,
            'name'  =>__('Mark as bookmark'),
            'id'    =>'itemsAsBookmark',
            'context_menu'=>'submit',
        )));
        
    }

    /**
    * render complete
    */
    public function render_list(&$tasks=NULL)
    {
        global $PH;
        require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

		$this->render_header();

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


                ### get subtasks if expanded
                $this->tasks_open= Task::getAll(array(
                    'for_milestone' => $t->id,
                    'status_min'    => STATUS_NEW,
                    'status_max'    => STATUS_COMPLETED,
                    'project'       => $t->project,
                    'show_folders'  => false,
                ));
                $this->tasks_closed= Task::getAll(array(
                    'for_milestone' => $t->id,
                    'status_min'    => STATUS_APPROVED,
                    'status_max'    => STATUS_CLOSED,
                    'project'       => $t->project,
                    'show_folders'  => false,
                ));


                $this->num_closed= count($this->tasks_closed);
                $this->num_open  = count($this->tasks_open);


                $this->num_completed= 0;
                $this->sum_estimated_min= 0;
                $this->sum_estimated_max= 0;
                $this->sum_completion_min= 0;
                $this->sum_completion_max= 0;

                foreach($this->tasks_open  as $tt) {
                    $this->sum_estimated_min+= $tt->estimated;
                    $this->sum_estimated_max+= $tt->estimated_max
                                       ? $tt->estimated_max
                                       : $tt->estimated;


                    if($tt->status > STATUS_BLOCKED) {
                        $this->num_completed++;
                        $this->sum_completion_min+= $tt->estimated;
                        $this->sum_completion_max+= $tt->estimated_max;
                    }
                    else {
                        $this->sum_completion_min+= $tt->estimated * $tt->completion / 100;
                    }
                }

                foreach($this->tasks_closed  as $tt) {

                    $this->sum_estimated_min+= $tt->estimated;
                    $this->sum_estimated_max+= $tt->estimated_max
                                       ? $tt->estimated_max
                                       : $tt->estimated;

                    $this->sum_completion_min+= $tt->estimated;
                    $this->sum_completion_max+= $tt->estimated_max;
                }


                if($this->groupings && $this->active_block_function == 'grouped') {
                    $gr= $this->groupings->active_grouping_key;

		            if($last_group != $t->$gr) {
		                echo '<tr class=group><td colspan='. count($this->columns) .'>'. $this->groupings->active_grouping_obj->render($t).'</td></tr>';
	                    $last_group = $t->$gr;
	                }
           		}

                ### done ###
                if(@intval($t->status) >= STATUS_COMPLETED) {
                    $style_row= $style . ' isDone';
                }
                else {
                    $style_row= $style;
                    $count_estimated+=$t->estimated;
                }
      			$this->render_trow(&$t,$style_row);

            }
    		$this->render_tfoot();
        }
    }


    public function print_automatic($project=NULL, $parent_task=NULL)
    {
        global $PH;
        global $auth;


        if(!isset($this->query_options['status_max'])) {
            $this->query_options['status_max']=STATUS_COMPLETED;
        };

        if($project) {
            $this->query_options['project']= $project->id;
        }

        /*
        if(!$this->no_items_html && $project) {
            $this->no_items_html=
            $PH->getLink('taskNewFolder',__('New Folder'),array('prj'=>$project->id))
            ." ". __("or")." "
            . $PH->getLink('taskNew','',array('prj'=>$project->id));
        }
*/

        #if(!$this->active_block_function=$this->getBlockStyleFromCookie()) {
        #    $this->active_block_function = 'list';
        #}


        ### add filter options ###
        #foreach($this->filters as $f) {
        #    foreach($f->getQuerryAttributes() as $k=>$v) {
        #        $this->query_options[$k]= $v;
        #    }
        #}

        $sort_cookie= "sort_{$PH->cur_page->id}_{$this->id}_{$this->active_block_function}";
        if($sort= get($sort_cookie)) {
            $this->query_options['order_by']= asCleanString($sort);
        }

        {

            if($this->tasks_assigned_to) {
                $this->query_options['assigned_to_person']= $this->tasks_assigned_to;
            }
            $this->query_options['show_folders']    = false;

            unset($this->columns['date_closed']);
#	        unset($this->columns['pub_level']);
	        unset($this->columns['estimated']);
        }

        if($auth->cur_user->user_rights & RIGHT_VIEWALL) {
            $this->query_options['visible_only']=false;
        }


        $this->query_options['category']= TCATEGORY_MILESTONE;

        $tasks= Task::getAll($this->query_options);

        $this->render_list(&$tasks);
    }
}


class ListBlockCol_MilestoneName extends ListBlockCol
{
    public $key='name';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->width='90%';
        $this->name=__('Milestone');
        $this->id='name';
    }

	function render_tr(&$task, $style="")
	{

        global $PH;
		if(!isset($task) || !is_object($task)) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}

        global $g_wiki_project;
        $g_wiki_project= $task->project;


        $html_link= '<b>'. $task->getLink(false) .'</b>';
        $buffer=    '';


        ### collapsed view ###
		if($task->view_collapsed) {
    		$buffer.= $PH->getLink('taskToggleViewCollapsed',"<img src=\"". getThemeFile("img/toggle_folder_closed.gif") . "\">",array('tsk'=>$task->id),NULL, true)
    		        . $html_link;
		}
		### expanded view ###
		else {

    		$buffer.= $PH->getLink('taskToggleViewCollapsed',"<img src=\"" . getThemeFile("img/toggle_folder_open.gif") . "\">",array('tsk'=>$task->id),NULL, true)
    		. $html_link
    		. '<br>'
            . wiki2html($task->description, $task->project);
		}
        echo '<td>'. $buffer .'</td>';
   	}
}



class ListBlockCol_MilestoneDate extends ListBlockCol
{
    public $key='planned_end';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->width='15%';
        $this->name=__('Planned for');
        $this->id='planned_end';
    }

	function render_tr(&$task, $style="")
	{

        global $PH;
		if(!isset($task) || !is_object($task)) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}


        ### days left ###
        $due_str=$task->planned_end;
        $html_due= '';

        if($due_str == "0000-00-00" || $due_str == "0000-00-00 00:00:00") {
		    $html_due ='';
        }
        else {
            $due_days= floor( (strToGMTime($task->planned_end) - time())/24/60/60)+1;
            if($due_days == 0) {
                $html_due=__("Due Today");
            }
            else if($due_days<0) {
                $class='overDue';
                $html_due= '<span class=overdue>'
                         . sprintf(__("%s days late"), -$due_days)
                         . '</span>';
            }
            else {
                $html_due= sprintf(__("%s days left"), $due_days);
            }
        }



        $buffer = renderDateHtml($task->planned_end);

        if($html_due && $task->status < STATUS_CLOSED) {
            $buffer.= '<br><span class=sub>('. $html_due .')</span>';
        }

        if($this->parent_block->sum_estimated_max) {
            $buffer.= '<br><span class=sub>'
                   .  sprintf(__('%s required'), renderEstimatedDuration(
                     ($this->parent_block->sum_estimated_max + $this->parent_block->sum_estimated_min)/2
                     -
                     ($this->parent_block->sum_completion_max + $this->parent_block->sum_completion_min)/2
                    ))
                   .  '</span>';
        }

        echo '<td class=nowrap>'. $buffer .'</td>';
   	}
}


class ListBlockCol_MilestoneTasksGraph extends ListBlockCol
{

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name= __('Tasks open','columnheader');
    }


	function render_tr(&$obj, $style="")
	{
		if(!isset($obj) || !$obj instanceof Task) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}

		global $PH;

        /**
        * we need to get the open tasks here
        */

        if($this->parent_block->num_open == 0 && $this->parent_block->num_closed == 0) {
            echo "<td></td>";
        }
        else {
            $width= 150;
            if($this->parent_block->num_open + $this->parent_block->num_closed) {
                $width_closed= floor($width * ($this->parent_block->num_closed) / ($this->parent_block->num_open + $this->parent_block->num_closed));
                $width_completed= floor($width * ($this->parent_block->num_completed) / ($this->parent_block->num_open + $this->parent_block->num_closed));
                if($width_completed + $width_closed > $width) {
                    $width_completed = $width - $width_closed;
                }

            }
            else {
                $width_closed= 0;
                $width_completed= 0;
            }


            echo "<td>";
            echo "<div style='width:" .($width+2). "px;height:10px;border:1px solid #ccc;background-color:#fff;'>";

            if($width_closed) {
                echo "<div style='float:left;width:{$width_closed}px;height:10px;background-color:#90BC54;'></div>";
            }
            if($width_completed) {
                echo "<div style='float:left;width:{$width_completed}px;height:10px;background-color:#CEE98B;;border-left:1px solid #fff;'></div>";
            }

            echo "</div>";

            if(!$obj->view_collapsed) {
                 echo $PH->getLink('projViewTasks', $this->parent_block->num_closed." ". __("closed"),
                            array(
                                'prj'          => $obj->project,
                                'for_milestone'=>$obj->id,
                                'preset'       =>'closed_tasks',
                            ))
                     . " / "
                     . $PH->getLink('projViewTasks', ($this->parent_block->num_open - $this->parent_block->num_completed)." ". __("open"),
                            array(
                                'prj'          => $obj->project,
                                'for_milestone'=>$obj->id,
                                'preset'       =>'next_milestone',
                            ))
                     . '<br>';
                if( $this->parent_block->sum_estimated_min) {
                    echo renderEstimationGraph($this->parent_block->sum_estimated_min, $this->parent_block->sum_estimated_max, ($this->parent_block->sum_completion_min/ $this->parent_block->sum_estimated_min) * 100);
                }
            }

    		echo "</td>";
    	}
	}
}




?>