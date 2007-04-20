<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * derived ListBlock-class for listing efforts
 *
 * @includedby:     pages/*
 *
 * @author         Thomas Mann
 * @uses:           ListBlock
 * @usedby:
 *
 */
class ListBlock_efforts extends ListBlock
{
	public $bg_style = "bg_time";
	public $filters = array();
	
    public function __construct($args=NULL)
    {
		parent::__construct($args);

        global $PH;
        $this->id='efforts';
        $this->bg_style='bg_time';
        $this->no_items_html= __('no efforts booked yet');
		$this->title= __("Efforts");


        $this->add_col( new ListBlockColSelect());
		$this->add_col(new ListBlockColMethod(array(
			'key'=>'p.name',
			'name'=>__('Project'),
			'func'=>'getProjectLink'
		)));
		$this->add_col(new ListBlockColMethod(array(
			'key'=>'person',
			'name'=>__('person'),
			'func'=>'getPersonLink'
		)));
		$this->add_col( new ListBlockCol_EffortTask);
		$this->add_col( new ListBlockCol_EffortStatus);
		$this->add_col( new ListBlockCol_EffortName);
		$this->add_col( new ListBlockCol_EffortDate);
		$this->add_col( new ListBlockCol_EffortDateEnd);
		$this->add_col( new ListBlockCol_EffortAmount);
		$this->add_col( new ListBlockCol_DayGraph);

        #---- functions ----
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('effortEdit')->id,
            'name'  =>__('Edit effort'),
            'id'    =>'effortEdit',
            'icon'  =>'edit',
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('effortNew')->id,
            'name'  =>__('New effort'),
            'id'    =>'effortNew',
            'icon'  =>'new',
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('effortsDelete')->id,
            'name'  =>__('Delete'),
            'id'    =>'effortsDelete',
            'icon'  =>'delete',
            'context_menu'=>'submit',
        )));

        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('effortViewMultiple')->id,
            'name'  =>__('View selected Efforts'),
            'id'    =>'effortViewMultiple',
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
			'default'=>true,
			'name'=>'List',
			'params'=>array(
				'style'=>'list',
				'block_id'=>$this->id,
				'page_id'=>$PH->cur_page->id,
			 ),
			 //'default'=>true,
		)));
		$this->groupings= new BlockFunction_grouping(array(
			'target'=>'changeBlockStyle',
			'key'=>'grouped',
		     'name'=>'Grouped',
		     'params'=>array(
			   'style'=>'grouped',
			   'block_id'=>$this->id,
			   'page_id'=>$PH->cur_page->id,
		   ),
	   ));
	   $this->add_blockFunction($this->groupings);

        ### list groupings ###
        $this->groupings->groupings= array(
            new ListGroupingEffortStatus(),
            new ListGroupingCreatedBy(),
			new ListGroupingTask(),
        );
		
    }
	
	public function print_automatic()
    {
        global $PH;
		
		if(!$this->active_block_function=$this->getBlockStyleFromCookie()) {
            $this->active_block_function = 'list';
        }

        $this->query_options['alive_only'] = false;

        $this->group_by= get("blockstyle_{$PH->cur_page->id}_{$this->id}_grouping");

        $s_cookie= "sort_{$PH->cur_page->id}_{$this->id}_{$this->active_block_function}";
        if($sort= get($s_cookie)) {
            $this->query_options['order_by']= $sort;
        }
        else {
            $this->query_options['order_by']= 'time_end DESC';
        }
		
        ### add filter options ###
        foreach($this->filters as $f) {
            foreach($f->getQuerryAttributes() as $k=>$v) {
                $this->query_options[$k]= $v;
            }
        }
		
		### grouped view ###
        if($this->active_block_function == 'grouped') {

            /**
            * @@@ later use only once...
            *
            *   $this->columns= filterOptions($this->columns,"CURPAGE.BLOCKS[{$this->id}].STYLE[{$this->active_block_function}].COLUMNS");
            */
            if(isset($this->columns[ $this->group_by ])) {
                unset($this->columns[$this->group_by]);
            }

	        ### prepend key to sorting ###
	        if(isset($this->query_options['order_by'])) {
	            $this->query_options['order_by'] = $this->groupings->getActiveFromCookie() . ",".$this->query_options['order_by'];

	        }
	        else {
	            $this->query_options['order_by'] = $this->groupings->getActiveFromCookie();
	        }
        }
        ### list view ###
        else {
            $pass= true;
        }
		
		$efforts = Effort::getAll($this->query_options);

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
            $day_last=0;
			
			### grouping ###
			if($this->groupings && $this->active_block_function == 'grouped' && $this->groupings->active_grouping_obj) {
				$last_group= NULL;
				$gr= $this->groupings->active_grouping_key;
				foreach($efforts as $e) {
					if($last_group != $e->$gr) {
						echo '<tr class=group><td colspan='. count($this->columns) .'>'. $this->groupings->active_grouping_obj->render($e).'</td></tr>';
						$last_group = $e->$gr;
					}
					$sum +=(strToClientTime( $e->time_end) - strToClientTime(  $e->time_start) )/60/60 * 1.0;
	
					/**
					* separate new days with style
					*/
					$day= gmdate('z',strToClientTime( $e->time_end ) )*1;
					if($day != $day_last) {
						$day_last= $day;
						$this->render_trow(&$e,'isNewDay');
					}
					else {
						$this->render_trow(&$e);
					}
				}
			}
			else {
				foreach($efforts as $e) {
					$sum +=(strToClientTime( $e->time_end) - strToClientTime(  $e->time_start) )/60/60 * 1.0;
	
					/**
					* separate new days with style
					*/
					$day= gmdate('z',strToClientTime( $e->time_end ) )*1;
					if($day != $day_last) {
						$day_last= $day;
						$this->render_trow(&$e,'isNewDay');
					}
					else {
						$this->render_trow(&$e);
					}
				}
			}
            
            $sum=round($sum,1);
            $this->summary= sprintf(__("%s effort(s) with %s hours"), count($efforts), $sum);
    		$this->render_tfoot();
        }
	}
}

class ListBlockCol_EffortName extends ListBlockCol
{
	public $key='name';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Effort');
		$this->width= '50%';
		$this->tooltip= __("Effort name. More Details as tooltips");
		$this->format= '{?name}';
    }
	function render_tr(&$obj, $style="")
	{
	    global $PH;
	    $str="";

		if(isset($obj->name)) {
			if($effort= Effort::getById($obj->id)) {
				 $str= $PH->getLink('effortView', $effort->name, array('effort'=>$effort->id));
			}
		}

	    print "<td><b>$str</b></td>";
	}
}

class ListBlockCol_EffortTask extends ListBlockCol
{
    public $key='task';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Task','column header');
    }
	function render_tr(&$obj, $style="")
	{
	    global $PH;
	    $str="";

        if(isset($obj->task)) {
            if($task= Task::getById($obj->task)) {
                $str= $PH->getLink('taskView',$task->getShort(),array('tsk'=>$task->id));
    		}
		}
	    print "<td><nobr>$str</nobr></td>";

	}
}

class ListBlockCol_EffortStatus extends ListBlockCol
{
    public $key = 'status';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name = __('Status','column header');
    }
	function render_tr(&$obj, $style="")
	{
	    global $PH;
		global $g_effort_status_names;
	    $str = "";

        if(isset($obj->status)) {
            $str = $g_effort_status_names[$obj->status];
		}
	    print "<td><nobr>$str</nobr></td>";

	}
}

class ListBlockCol_EffortDate extends ListBlockCol
{
    public $key='time_start';


    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name= __('Start','column header');
    }


	function render_tr(&$obj, $style="")
	{
		if(!isset($obj) || !$obj instanceof Effort) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}

        #$value= date(__("D, d.m.Y"), strToGMTime($obj->time_start) );
        $value= renderTimestampHtml($obj->time_start);

        if($obj->as_duration) {
            $value.="&nbsp;&nbsp;".renderTime($obj->time_start) ;
        }
		print "<td><nobr>$value</nobr></td>";   #@@@ note: nobr is a hack for firefox 1.0
	}
}

class ListBlockCol_EffortDateEnd extends ListBlockCol{
    public $key='time_end';

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name= __('End','column header');
    }

	function render_tr(&$obj, $style="")
	{
		if(!isset($obj) || !$obj instanceof Effort) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		if($obj->as_duration) {
		    $value="";
		}
		else {
            $value= renderTime($obj->time_end);
        }
		print "<td>$value</td>";
	}
}

class ListBlockCol_EffortAmount extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('len','column header of length of effort');
    }
	function render_tr(&$obj, $style="") {
		if(!isset($obj) || !$obj instanceof Effort) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
        $value=round((strToGMTime($obj->time_end) - strToGMTime($obj->time_start))/60/60,1)."h";
		print "<td>$value</td>";
	}
}

class ListBlockCol_DayGraph extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name= __('Daygraph','columnheader');
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
            $tmp=mysqlDatetime2utc($obj->time_start);
            $day_time_start= confGet('DAYGRAPH_START_HOUR')*60*60;
            $day_time_end= confGet('DAYGRAPH_END_HOUR')*60*60;

            $stretch= confGet('DAYGRAPH_WIDTH')/ ($day_time_end - $day_time_start);

            $time_start= round((($tmp['hour']*60*60+$tmp['min']*60+ $tmp['sec']) - $day_time_start)* $stretch,0);
            if($time_start<0) {
                $time_start=0;
            }


            $tmp=mysqlDatetime2utc($obj->time_end);
            $time_end= round((($tmp['hour']*60*60+$tmp['min']*60+ $tmp['sec']) - $day_time_start)*$stretch,0);
            if($time_end< $time_start) {
                $time_end=0;
            }
            $time_len= $time_end - $time_start;

            echo "<td>";
            echo "<nobr>";
            echo "<img src='".getThemeFile("img/pixel.gif") . "' style='width:{$time_start}px;height:3px;'>";
            echo "<img src='".getThemeFile("img/pixel.gif") . "' style='width:{$time_len}px;height:12px;background-color:#f00;'>";
    		echo "</nobr>";
    		echo "</td>";
    	}
	}
}


?>