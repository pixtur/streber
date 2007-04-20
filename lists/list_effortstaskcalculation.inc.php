<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * derived ListBlock-class for listing efforts
 *
 * @includedby:     pages/*
 *
 * @author:         Esther Burger
 * @uses:           ListBlock
 * @usedby:
 *
 */
class ListBlock_effortsTaskCalculation extends ListBlock
{
	public $bg_style = "bg_time";
	
    public function __construct($args=NULL)
    {
		parent::__construct($args);

        global $PH;
        $this->id = 'effortstaskcalc';
        $this->bg_style = 'bg_time';
        $this->no_items_html = __('no efforts booked yet');
		$this->title =  __("Calculation on task");
		$this->show_icons = true;
		$this->add_col( new ListBlockCol_EffortTaskCalcName);
		$this->add_col( new ListBlockCol_EffortTaskAmountHour);
		$this->add_col( new ListBlockCol_EffortTaskAmountSalary);
		$this->add_col( new ListBlockCol_EffortTaskCalculation);
		$this->add_col( new ListBlockCol_EffortTaskCalcGraph);
		$this->add_col( new ListBlockCol_EffortTaskRelation);

    }
	
	public function print_automatic()
    {
        global $PH;
		
		$effort_status = false;
		if($this->query_options['effort_status_min'] == $this->query_options['effort_status_max']){
			$effort_status = true;
		}
		
		$efforts = Effort::getEffortTasks($this->query_options);
		
		foreach($efforts as $e){
			$e->setStatus($effort_status);
		}
		
        $this->render_list(&$efforts);
    }
	
    /**
    * render complete
    */
    public function render_list(&$efforts=NULL)
    {
		switch($this->page->format){
			case FORMAT_CSV:
				$this->renderListCSV($efforts);
				break;
			default:
				$this->renderListHtml($efforts);
				break;
		}

    }

	function renderListHtml(&$efforts=NULL)
	{
		$this->render_header();
        if(!$efforts && $this->no_items_html) {
            $this->render_tfoot_empty();
        }
        else {

    		$this->render_thead();
			
			$sum_hours = 0.0;
			
			foreach($efforts as $e) {
				$this->render_trow(&$e);
			}
			
			## sum effort hours ##
			/*{
				if($efforts[0]->getStatus()){
					$sum_proj = Effort::getSumEfforts(array('project'=>$efforts[0]->project, 'status'=>$efforts[0]->status));
				}
				else{
					$sum_proj = Effort::getSumEfforts(array('project'=>$efforts[0]->project));
				}
				
				if($sum_proj){
					$sum_hours += $sum_proj/60/60 * 1.0;
				}
				
				$sum_hours = round($sum_hours,1);
			}*/
			
			
    		$this->render_tfoot();
        }
	}
}


class ListBlockCol_EffortTaskCalcName extends ListBlockCol
{
	public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Task','columnheader');
    }
	
	function render_tr(&$obj, $style=""){
		global $PH;
	    $str="";

        if(isset($obj->task)) {
            if($task= Task::getById($obj->task)) {
                $str= $PH->getLink('taskView',$task->name,array('tsk'=>$task->id));
    		}
		}
	    print "<td><nobr>$str</nobr></td>";
	}
}

class ListBlockCol_EffortTaskAmountHour extends ListBlockCol
{
	public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Sum','columnheader');
    }
	
	function render_tr(&$obj, $style="") {
			
		if(!isset($obj) || !$obj instanceof Effort) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		
		$sum = 0.0;
		
		if($obj->getStatus()){
			$sum_task = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task, 'status'=>$obj->status));
		}
		else{
			$sum_task = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task));
		}
		
		if($sum_task)
		{
			$sum = (round($sum_task/60/60, 1) * 1.0) . " h";
		}
        
		print "<td><nobr>$sum</nobr></td>";
	}
}

class ListBlockCol_EffortTaskAmountSalary extends ListBlockCol
{
	public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Sum','columnheader') . " " . __('in Euro');
    }
	
	function render_tr(&$obj, $style="") {
			
		if(!isset($obj) || !$obj instanceof Effort) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		
		$sum = 0.0;
		$sum_sal = 0.0;
		$sum_all = 0.0;
		
		if($effort_persons = Effort::getEffortPersons(array('project'=>$obj->project, 'task'=>$obj->task))){
			foreach($effort_persons as $ep){
				if($person = Person::getVisibleById($ep->person)){
					if($obj->getStatus()){
						$sum_sal = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task, 'person'=>$person->id, 'status'=>$obj->status));
					}
					else{
						$sum_sal = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task, 'person'=>$person->id));
					}
					if($sum_sal)
					{
						$sum = (round($sum_sal/60/60, 1) * 1.0);
						if($project = Project::getVisibleById($obj->project)){
							if($pp = $project->getProjectPersons(array('person_id'=>$person->id))){
								if($pp[0]->salary_per_hour){
									$sum_all = ($sum * $pp[0]->salary_per_hour);
								}
								else{
									$sum_all = ($sum * $person->salary_per_hour);
								}
							}
							else{
								$sum_all = ($sum * $person->salary_per_hour);
							}
						}
						//$sum_all += ($sum * $person->salary_per_hour);
					}
				}
			}
		}
		
		print "<td><nobr>$sum_all</nobr></td>";
	}
}

class ListBlockCol_EffortTaskCalculation extends ListBlockCol
{
	public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Calculation','columnheader') . " " . __('in Euro');
    }
	
	function render_tr(&$obj, $style="") {
			
		if(!isset($obj) || !$obj instanceof Effort) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		
		$sum = 0.0;
		
		if(isset($obj->task)) {
            if($task= Task::getById($obj->task)) {
               if($task->calculation){
		            $sum = $task->calculation;
		       }
    		}
		}
        
		print "<td><nobr>" . $sum . "</nobr></td>";
	}
}


class ListBlockCol_EffortTaskCalcGraph extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Costgraph','columnheader');
		$this->width= '40%';
    }
	
	function render_tr(&$obj, $style="") {
	
		if(!isset($obj) || !$obj instanceof Effort) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		
		$sum = 0.0;
		$sum_sal = 0.0;
		$sum_all = 0.0;
		$diff_value = false;
		
		if($obj->as_duration) {
		    echo "<td>-</td>";
		}
		else {
			if($effort_persons = Effort::getEffortPersons(array('project'=>$obj->project, 'task'=>$obj->task))){
				foreach($effort_persons as $ep){
					if($person = Person::getVisibleById($ep->person)){
						if($obj->getStatus()){
							$sum_sal = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task, 'person'=>$person->id, 'status'=>$obj->status));
						}
						else{
							$sum_sal = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task, 'person'=>$person->id));
						}
						if($sum_sal)
						{
							$sum = (round($sum_sal/60/60, 1) * 1.0);
							if($project = Project::getVisibleById($obj->project)){
								if($pp = $project->getProjectPersons(array('person_id'=>$person->id))){
									if($pp[0]->salary_per_hour){
										$sum_all = ($sum * $pp[0]->salary_per_hour);
									}
									else{
										$sum_all = ($sum * $person->salary_per_hour);
									}
								}
								else{
									$sum_all = ($sum * $person->salary_per_hour);
								}
							}
							//$sum_all += ($sum * $person->salary_per_hour);
						}
					}
				}
			}
			if($task = Task::getVisibleById($obj->task)){
				if($sum_all && $task->calculation){
					$max_length_value = 3;
					$get_percentage = ($sum_all / $task->calculation) * 100;
					
					if($get_percentage > 100){
						$diff = $get_percentage - 100;
						$get_percentage = 100;
						$diff_value = true;
					}
					
					$show_rate = $get_percentage * $max_length_value;
					
					echo "<td>";
					echo "<nobr>";
					echo "<img src='".getThemeFile("img/pixel.gif") . "' style='width:{$show_rate}px;height:12px;background-color:#f00;'>";
					
					if($diff_value){
						$show_rate = $diff * $max_length_value;
						echo "<img src='".getThemeFile("img/pixel.gif") . "' style='width:{$show_rate}px;height:12px;background-color:#ff9900;'>";
						echo " " . round($get_percentage,1) . "% / " . round($diff,1) ." %";
					}
					else{
						echo " " . round($get_percentage,1) . "%";
					}
					
					echo "</nobr>";
					echo "</td>";
				}
				else{
					 echo "<td>-</td>";
				}
			}
			else{
				 echo "<td>-</td>";
			}
    	}
	}
}

class ListBlockCol_EffortTaskRelation extends ListBlockCol
{
    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('Estimated/Booked (Diff.)');
        $this->id='efforts_tasks_estimated';
        $this->tooltip=__("Relation between estimated time and booked efforts");
    }


	function render_tr(&$obj, $style="")
	{
	    global $PH;
		
		if(!isset($obj) || !$obj instanceof Effort) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		
		$sum = 0.0;
		$diff_str = '';
		$estimated_str = '';
		$str = '';
		$percent = '';
		
		if($obj->getStatus()){
			$sum_task = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task, 'status'=>$obj->status));
		}
		else{
			$sum_task = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task));
		}
		
		if($sum_task)
		{
			$sum = $sum_task;
		}
				
		if($task = Task::getVisibleById($obj->task)){
		
			$estimated = $task->estimated;
			$estimated_max = $task->estimated_max;
			
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
			
			$str =  $estimated_str . " / " . round($sum/60/60,1) . "h {$diff_str}";
			$percent = __('Completion:') . " " . $task->completion . "%";
		}
		
		print "<td class=nowrap title='" .__("Relation between estimated time and booked efforts") . "'>$str<br><span class='sub who'>$percent</span></td>";
	}
}

?>