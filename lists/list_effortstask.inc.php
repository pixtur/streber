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
class ListBlock_effortsTask extends ListBlock
{
    public function __construct($args=NULL)
    {
		parent::__construct($args);

        global $PH;
        $this->id = 'effortstask';
        $this->no_items_html = __('no efforts booked yet');
		$this->title =  __("Efforts on task");
		$this->show_icons = true;
		$this->add_col( new ListBlockCol_EffortTaskName);
		$this->add_col( new ListBlockCol_EffortTaskAmount);
		$this->add_col( new ListBlockCol_EffortTaskGraph);

    }
	
	public function print_automatic()
    {
        global $PH;
		
		/*$effort_status = false;
		if($this->query_options['effort_status_min'] == $this->query_options['effort_status_max']){
			$effort_status = true;
		}*/
		
		$efforts = Effort::getEffortTasks($this->query_options);
		
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
			
			$sum=0.0;
			
			foreach($efforts as $e) {
				$this->render_trow($e);
			}
			
			/*if($efforts[0]->getStatus()){
				$sum_proj = Effort::getSumEfforts(array('project'=>$efforts[0]->project, 'status'=>$efforts[0]->status));
			}
			else{*/
				$sum_proj = Effort::getSumEfforts(array('project'=>$efforts[0]->project));
			#}
			
			if($sum_proj){
				$sum += $sum_proj/60/60 * 1.0;
			}
			
            $sum=round($sum,1);
            $this->summary= sprintf(__("Total effort sum: %s hours"), $sum);
    		$this->render_tfoot();
            parent::render_blockEnd();            
        }
	}
}


class ListBlockCol_EffortTaskName extends ListBlockCol
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

class ListBlockCol_EffortTaskAmount extends ListBlockCol
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
			$sum_task = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task, 'status'=>$obj->status));
		}
		else{*/
			$sum_task = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task));
		#}
		
		if($sum_task)
		{
			$sum = (round($sum_task/60/60, 1) * 1.0) . " h";
		}
        
		print "<td><nobr>$sum</nobr></td>";
	}
}

class ListBlockCol_EffortTaskGraph extends ListBlockCol
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
				$sum_task = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task, 'status'=>$obj->status));
				$sum_proj = Effort::getSumEfforts(array('project'=>$obj->project, 'status'=>$obj->status));
			}
			else{*/
				$sum_task = Effort::getSumEfforts(array('project'=>$obj->project, 'task'=>$obj->task));
				$sum_proj = Effort::getSumEfforts(array('project'=>$obj->project));
			#}
			
			if($sum_task && $sum_proj){
				$max_length_value = 3;
				$get_percentage = ($sum_task / $sum_proj) * 100;
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