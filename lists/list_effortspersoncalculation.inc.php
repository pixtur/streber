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
class ListBlock_effortsPersonCalculation extends ListBlock
{
		
    public function __construct($args=NULL)
    {
		parent::__construct($args);

        global $PH;
        $this->id = 'effortspersoncalc';
        $this->no_items_html = __('no efforts booked yet');
		$this->title =  __("Calculation on team member");
		$this->show_icons = true;
		
		$this->add_col(new ListBlockColMethod(array(
			'key'=>'person',
			'name'=>__('person'),
			'func'=>'getPersonLink'
		)));
		$this->add_col( new ListBlockCol_EffortPersonCalcRole);
		$this->add_col( new ListBlockCol_EffortPersonAmountHour);
		$this->add_col( new ListBlockCol_EffortPersonAmountSalary);
		$this->add_col( new ListBlockCol_EffortPersonTaskCalculation);
		$this->add_col( new ListBlockCol_EffortPersonCalcGraph);

    }
	
	public function print_automatic()
    {
        global $PH;
		
		/*$effort_status = false;
		if($this->query_options['effort_status_min'] == $this->query_options['effort_status_max']){
			$effort_status = true;
		}*/
		
		$efforts = Effort::getEffortPersons($this->query_options);
		
		/*foreach($efforts as $e){
			$e->setStatus($effort_status);
		}*/
		
        $this->render_list($efforts);
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
			
			foreach($efforts as $e) {
				$this->render_trow($e);
			}
			
    		$this->render_tfoot();
            parent::render_blockEnd();            
        }
	}
}

class ListBlockCol_EffortPersonCalcRole extends ListBlockCol
{
	public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Role','columnheader');
    }
	
	function render_tr(&$obj, $style="") {
		
		global $g_user_profile_names;
		
		if(!isset($obj) || !$obj instanceof Effort) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		
		if($project = Project::getVisibleById($obj->project)){
			if($pp = $project->getProjectPersons(array('person_id'=>$obj->person))){
				$role = $g_user_profile_names[intval($pp[0]->role)];
			}
			else{
				$role = '';
			}
			
		}
		else{
			$role = '';
		}
		        
		print "<td><nobr>$role</nobr></td>";
	}
}

class ListBlockCol_EffortPersonAmountHour extends ListBlockCol
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
		
		/*if($obj->getStatus()){
			$sum_eff = Effort::getSumEfforts(array('project'=>$obj->project, 'person'=>$obj->person, 'status'=>$obj->status));
		}
		else{*/
			$sum_eff = Effort::getSumEfforts(array('project'=>$obj->project, 'person'=>$obj->person));
		#}
		
		if($sum_eff)
		{
			$sum = (round($sum_eff/60/60, 1) * 1.0) . " h";
		}
        
		print "<td><nobr>$sum</nobr></td>";
	}
}

class ListBlockCol_EffortPersonAmountSalary extends ListBlockCol
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
		
		if($person = Person::getVisibleById($obj->person)){
			/*if($obj->getStatus()){
				$sum_sal = Effort::getSumEfforts(array('project'=>$obj->project, 'person'=>$person->id, 'status'=>$obj->status));
			}
			else{*/
				$sum_sal = Effort::getSumEfforts(array('project'=>$obj->project, 'person'=>$person->id));
			#}
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
				//$sum_all = ($sum * $person->salary_per_hour);
			}
		}
			
		print "<td><nobr>$sum_all</nobr></td>";
	}
}

class ListBlockCol_EffortPersonTaskCalculation extends ListBlockCol
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
		
		if($effort_tasks = Effort::getEffortTasks(array('project'=>$obj->project, 'person'=>$obj->person))){
			foreach($effort_tasks as $et){
				if($task = Task::getVisibleById($et->task)){
				   if($task->calculation){
						$sum += $task->calculation;
				   }
				}
			}
		}
        
		print "<td><nobr>" . $sum . "</nobr></td>";
	}
}
class ListBlockCol_EffortPersonCalcGraph extends ListBlockCol
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
		$sum_calc = 0.0;
		$diff_value = false;
		
		if($obj->as_duration) {
		    echo "<td>-</td>";
		}
		else {
			if($person = Person::getVisibleById($obj->person)){
				/*if($obj->getStatus()){
					$sum_sal = Effort::getSumEfforts(array('project'=>$obj->project, 'person'=>$person->id, 'status'=>$obj->status));
				}
				else{*/
					$sum_sal = Effort::getSumEfforts(array('project'=>$obj->project, 'person'=>$person->id));
				#}
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
					//$sum_all = ($sum * $person->salary_per_hour);
				}
			}
			
			if($effort_tasks = Effort::getEffortTasks(array('project'=>$obj->project, 'person'=>$obj->person))){
				foreach($effort_tasks as $et){
					if($task = Task::getVisibleById($et->task)){
					   if($task->calculation){
							$sum_calc += $task->calculation;
					   }
					}
				}
			}
			
			if($sum_all && $sum_calc){
				$max_length_value = 3;
				$get_percentage = ($sum_all / $sum_calc) * 100;
				
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
}
?>