<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

require_once(confGet('DIR_STREBER') . "db/class_effort.inc.php");

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
class ListBlock_effortsPerson extends ListBlock
{
    public function __construct($args=NULL)
    {
		parent::__construct($args);

        global $PH;
        $this->id = 'effortsperson';
        $this->no_items_html = __('no efforts booked yet');
		$this->title =  __("Efforts on team member");
		$this->show_icons = true;
		
		$this->add_col(new ListBlockColMethod(array(
			'key'=>'person',
			'name'=>__('person'),
			'func'=>'getPersonLink'
		)));
		$this->add_col( new ListBlockCol_EffortPersonRole);
		$this->add_col( new ListBlockCol_EffortPersonAmount);
		$this->add_col( new ListBlockCol_EffortGraph);

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
			
			$sum=0.0;
			
			foreach($efforts as $e) {
				$this->render_trow(&$e);
			}
			
			/*if($efforts[0]->getStatus()){
				$sum_proj = Effort::getSumEfforts(array('project'=>$efforts[0]->project, 'status'=>$efforts[0]->status));
			}
			else{*/
				$sum_proj = Effort::getSumEfforts(array('project'=>$efforts[0]->project));
			#}
			
			if($sum_proj)
			{
					$sum += $sum_proj/60/60 * 1.0;
			}
			
            $sum=round($sum,1);
            $this->summary= sprintf(__("Total effort sum: %s hours"), $sum);
    		$this->render_tfoot();
            parent::render_blockEnd();            
        }
	}
}

class ListBlockCol_EffortPersonRole extends ListBlockCol
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

class ListBlockCol_EffortPersonAmount extends ListBlockCol
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

class ListBlockCol_EffortGraph extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Effortgraph','columnheader');
		$this->width= '40%';
    }
	
	function render_tr(&$obj, $style="") {
	
		if(!isset($obj) || !$obj instanceof Effort) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		if($obj->as_duration) {
		    echo "<td>-</td>";
		}
		else {
			
			/*if($obj->getStatus()){
				$sum_eff = Effort::getSumEfforts(array('project'=>$obj->project, 'person'=>$obj->person, 'status'=>$obj->status));
				$sum_proj = Effort::getSumEfforts(array('project'=>$obj->project, 'status'=>$obj->status));
			}
			else{*/
				$sum_eff = Effort::getSumEfforts(array('project'=>$obj->project, 'person'=>$obj->person));
				$sum_proj = Effort::getSumEfforts(array('project'=>$obj->project));
			#}
			
			if($sum_eff && $sum_proj){
				$max_length_value = 3;
				$get_percentage = ($sum_eff / $sum_proj) * 100;
				$show_rate = $get_percentage * $max_length_value;
				
				echo "<td>";
				echo "<nobr>";
				echo "<img src='".getThemeFile("img/pixel.gif") . "' style='width:{$show_rate}px;height:12px;background-color:#f00;'>";
				echo " " . round($get_percentage,1) . "%";
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