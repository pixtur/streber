<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * block for rendering the login form
 *
 * included by: @render_page
 * @author     Thomas Mann
 */

require_once(confGet('DIR_STREBER') . "render/render_page.inc.php");

class CurrentMilestoneBlock extends PageBlock
{
    public $project;
    public $current_milestone;

    public function __construct($project)
    {
        parent::__construct(NULL);
        $this->project = $project;
        $this->current_milestone = $project->getNextMilestone();
        $this->title = __('Current Milestone');        
    }

    public function __toString()
    {
        return "";

    }
    
    public function render()
    {
        if(!$this->current_milestone) {
            return '';
        }
        global $PH;

        $this->render_blockStart();
        echo "<div class='post_list_entry'>";
            echo "<h3>";
            echo $this->current_milestone->getLink();
            #echo $PH->getLink('taskView', array('tsk'=>$this->current_milestone->id)  );
            echo "</h3>";

            $milestone_task_summary= $this->current_milestone->getMilestoneTasksSummary();
            $this->render_milestoneGraph($milestone_task_summary);
        echo "</div>";

        $this->render_blockEnd();
        return '';
    }
    
    private function render_milestoneGraph( $milestone_task_summary )
    {
        global $PH;
        $width= 220;
        if($milestone_task_summary['num_open'] + $milestone_task_summary['num_closed']) {
            $width_closed   = floor($width * ($milestone_task_summary['num_closed'])    / ($milestone_task_summary['num_open'] + $milestone_task_summary['num_closed']));
            $width_completed= floor($width * ($milestone_task_summary['num_completed']) / ($milestone_task_summary['num_open'] + $milestone_task_summary['num_closed']));
            if($width_completed + $width_closed > $width) {
                $width_completed = $width - $width_closed;
            }
        }
        else {
            $width_closed= 0;
            $width_completed= 0;
        }

        echo "<div style='width:" .($width+2). "px;height:10px;border:1px solid #ccc;background-color:#fff;'>";

        if($width_closed) {
            echo "<div style='float:left;width:{$width_closed}px;height:10px;background-color:#90BC54;'></div>";
        }
        if($width_completed) {
            echo "<div style='float:left;width:{$width_completed}px;height:10px;background-color:#CEE98B;;border-left:1px solid #fff;'></div>";
        }

        echo "</div>";

        echo $PH->getLink('projViewTasks',  sprintf(__("%s completed task"), $milestone_task_summary['num_closed']),
                    array(
                        'prj'          => $this->project->id,
                        'for_milestone'=> $this->current_milestone->id,
                        'preset'       =>'closed_tasks',
                    ))
             . " / "
             . $PH->getLink('projViewTasks',  sprintf(__("%s open"), $milestone_task_summary['num_open']),
                    array(
                        'prj'          => $this->project->id,
                        'for_milestone'=> $this->current_milestone->id,
                        'preset'       =>'next_milestone',
                    ))
             . '<br>';

        if( $milestone_task_summary['sum_estimated_min']) {
            echo renderEstimationGraph($milestone_task_summary['sum_estimated_min'], $milestone_task_summary['sum_estimated_max'], ($milestone_task_summary['sum_completion_min']/ $milestone_task_summary['sum_estimated_min']) * 100);
        }
    }    
}


?>