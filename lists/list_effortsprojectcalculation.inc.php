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
class ListBlock_effortsProjectCalculation extends ListBlock
{
	public $bg_style = "bg_time";
	
    public function __construct($args=NULL)
    {
		parent::__construct($args);

        global $PH;
        $this->id = 'effortsprojectcalc';
        $this->bg_style = 'bg_time';
        $this->no_items_html = __('no efforts booked yet');
		$this->title =  __("Calculation for project");
		$this->show_icons = true;
		$this->add_col( new ListBlockCol_EffortProjectName);
		$this->add_col( new ListBlockCol_EffortProjectAmountHour);
		$this->add_col( new ListBlockCol_EffortProjectAmountSalary);
		$this->add_col( new ListBlockCol_EffortProjectCalculation);
		$this->add_col( new ListBlockCol_EffortProjectCalcGraph);
    }
	
	public function print_automatic(&$project)
    {
        #global $PH;
		
		$project_status = false;
		if($this->query_options['effort_status_min'] == $this->query_options['effort_status_max']){
			$project_status = true;
		}
		
		$project->setStatus($project_status);
		
        $this->render_list(&$project);
    }
	
    /**
    * render complete
    */
    public function render_list(&$project=NULL)
    {
		switch($this->page->format){
			case FORMAT_CSV:
				$this->renderListCSV($project);
				break;
			default:
				$this->renderListHtml($project);
				break;
		}

    }

	function renderListHtml(&$project=NULL)
	{
		$this->render_header();
		        
		if((!$project && $this->no_items_html)) {
            $this->render_tfoot_empty();
        }
        else {

    		$this->render_thead();
			
			$this->render_trow(&$project);
						
    		$this->render_tfoot();
        }
	}
}


class ListBlockCol_EffortProjectName extends ListBlockCol
{
	public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Project','columnheader');
    }
	
	function render_tr(&$obj, $style=""){
		global $PH;
	    $str="";

        $str= $PH->getLink('projView',$obj->name,array('prj'=>$obj->id));
    	
	    print "<td><nobr>$str</nobr></td>";
	}
}

class ListBlockCol_EffortProjectAmountHour extends ListBlockCol
{
	public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Sum','columnheader');
    }
	
	function render_tr(&$obj, $style="") {
			
		if(!isset($obj) || !$obj instanceof Project) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		
		$sum = 0.0;
		
		/*if($obj->getStatus()){
			$sum_proj = Effort::getSumEfforts(array('project'=>$obj->id, 'status'=>$obj->status));
		}
		else{*/
			$sum_proj = Effort::getSumEfforts(array('project'=>$obj->id));
		#}
		
		if($sum_proj)
		{
			$sum = (round($sum_proj/60/60, 1) * 1.0) . " h";
		}
        
		print "<td><nobr>$sum</nobr></td>";
	}
}

class ListBlockCol_EffortProjectAmountSalary extends ListBlockCol
{
	public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Sum','columnheader') . " " . __('in Euro');
    }
	
	function render_tr(&$obj, $style="") {
			
		if(!isset($obj) || !$obj instanceof Project) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		
		$sum = 0.0;
		$sum_sal = 0.0;
		$sum_all = 0.0;
		
		if($effort_persons = Effort::getEffortPersons(array('project'=>$obj->id))){
			foreach($effort_persons as $ep){
				if($person = Person::getVisibleById($ep->person)){
					/*if($obj->getStatus()){
						$sum_sal = Effort::getSumEfforts(array('project'=>$obj->id, 'person'=>$person->id, 'status'=>$obj->status));
					}
					else{*/
						$sum_sal = Effort::getSumEfforts(array('project'=>$obj->id, 'person'=>$person->id));
					#}
					if($sum_sal)
					{
						$sum = (round($sum_sal/60/60, 1) * 1.0);
						
						if($pp = $obj->getProjectPersons(array('person_id'=>$person->id))){
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
						
						//$sum_all += ($sum * $person->salary_per_hour);
					}
				}
			}
		}
		
		print "<td><nobr>$sum_all</nobr></td>";
	}
}

class ListBlockCol_EffortProjectCalculation extends ListBlockCol
{
	public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Calculation','columnheader') . " " . __('in Euro');
    }
	
	function render_tr(&$obj, $style="") {
			
		if(!isset($obj) || !$obj instanceof Project) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		
		$sum = 0.0;
		
		if($effort_tasks = Effort::getEffortTasks(array('project'=>$obj->id))){
			foreach($effort_tasks as $et){
				if($task = Task::getById($et->task)) {
				   if($task->calculation){
						$sum += $task->calculation;
				   }
				}
			}
		}
        
		print "<td><nobr>" . $sum . "</nobr></td>";
	}
}

class ListBlockCol_EffortProjectCalcGraph extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Costgraph','columnheader');
		$this->width= '40%';
    }
	
	function render_tr(&$obj, $style="") {
	
		if(!isset($obj) || !$obj instanceof Project) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		
		$sum = 0.0;
		$sum_sal = 0.0;
		$sum_all = 0.0;
		$sum_cal = 0.0;
		$diff_value = false;
		
		
		if($effort_persons = Effort::getEffortPersons(array('project'=>$obj->id))){
			foreach($effort_persons as $ep){
				if($person = Person::getVisibleById($ep->person)){
					/*if($obj->getStatus()){
						$sum_sal = Effort::getSumEfforts(array('project'=>$obj->id, 'person'=>$person->id, 'status'=>$obj->status));
					}
					else{*/
						$sum_sal = Effort::getSumEfforts(array('project'=>$obj->id, 'person'=>$person->id));
					#}
					if($sum_sal)
					{
						$sum = (round($sum_sal/60/60, 1) * 1.0);
						if($pp = $obj->getProjectPersons(array('person_id'=>$person->id))){
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
						//$sum_all += ($sum * $person->salary_per_hour);
					}
				}
			}
		}
		if($effort_tasks = Effort::getEffortTasks(array('project'=>$obj->id))){
			foreach($effort_tasks as $et){
				if($task = Task::getById($et->task)) {
				   if($task->calculation){
						$sum_cal += $task->calculation;
				   }
				}
			}
		}
		if($sum_all && $sum_cal){
			$max_length_value = 3;
			$get_percentage = ($sum_all / $sum_cal) * 100;
			
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
}
?>