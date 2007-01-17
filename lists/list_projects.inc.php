<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt



class ListGroupingCompany extends ListGrouping {

    public function __construct($args=NULL) {
        $this->id = 'company';
        parent::__construct($args);
    }

    /**
    * render separating row
    */
    public function render(&$item)
    {
        require_once "db/class_company.inc.php";
        if(isset($item->company)) {
            if($c= Company::getVisibleById($item->company)) {
                return $c->getLink();
            }
            else {
                return __("Company");
            }

        }
        else {
            trigger_error("can't group for company",E_USER_NOTICE);
            return "---";
        }
    }
}



/**
 * derived ListBlock-class for listing projects
 *
 * @includedby:     pages/*
 *
 * @author:         Thomas Mann
 * @uses:           ListBlock
 * @usedby:
 *
 */
class ListBlock_projects extends ListBlock
{

    public function __construct($args=NULL)
    {
		parent::__construct($args);

        $this->id       = 'projects';
        $this->bg_style = 'bg_projects';
		$this->title    = "related Projects";

        $this->add_col( new ListBlockColSelect());
		$this->add_col( new ListBlockColPrio(array(
			'key'=>'prio',
			'name'=>"P",
			'tooltip'=>__("Project priority (the icons have tooltips, too)"),
			'sort'=>1,
		)));
		$this->add_col( new ListBlockColStatus(array(
			'key'=>'status',
			'name'=>"S",
			'tooltip'=>__("Task-Status"),
			'sort'=>0
		)));
    	$this->add_col( new ListBlockColMethod(array(
            #'key'=>'company',
			'key'=>'c.name',
    		'name'=>__("Company"),
    		'tooltip'=>__("Company"),
    		'func'=>'getCompanyLink',
    	)));

   		/*$this->add_col( new ListBlockColFormat(array(
			'key'=>'short',
			'name'=>"Name Short",
			'tooltip'=>"Shortnames used in other lists",
			'sort'=>0,
			'format'=>'<nobr><a href="index.php?go=projView&amp;prj={?id}">{?short}</a></nobr>'
		)));*/
   		$this->add_col( new ListBlockColFormat(array(
			'key'=>'name',
			'name'=>__("Project"),
			'tooltip'=>__("Task name. More Details as tooltips"),
			'width'=>'30%',
			'sort'=>0,
			'format'=>'<a href="index.php?go=projView&amp;prj={?id}">{?name}</a>'
		)));

   		$this->add_col( new ListBlockColFormat(array(
			'key'=>'status_summary',
			'name'=>__("Status Summary"),
			'tooltip'=>__("Short discription of the current status"),
			'format'=>'{?status_summary}'
		)));

        $this->add_col( new ListBlockCol_ProjectPersons);

        $this->add_col( new ListBlockCol_ProjectEffortSum);

    	$this->add_col( new ListBlockColMethod(array(
    		'name'=>__("Tasks"),
    		'tooltip'=>__("Number of open Tasks"),
    		'sort'=>0,
    		'func'=>'getNumTasks',
            'style' =>'right',
            'id'    =>'tasks',
    	)));
   		$this->add_col( new ListBlockColDate(array(
			'key'=>'date_start',
			'name'=>__("Opened"),
			'tooltip'=>__("Day the Project opened"),
			'sort'=>0,
		)));
   		$this->add_col( new ListBlockColDate(array(
			'key'=>'date_closed',
			'name'=>__("Closed"),
			'tooltip'=>__("Day the Project state changed to closed"),
			'sort'=>0,
		)));

        #---- functions ------------------------
        global $PH;

        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('projEdit')->id,
            'name'  =>__('Edit project'),
            'id'    =>'projEdit',
            'icon'  =>'edit',
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('projDelete')->id,
            'name'  =>__('Delete project'),
            'id'    =>'projDelete',
            'icon'  =>'delete'
        )));

        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('effortNew')->id,
            'name'  =>__('Log hours for a project'),
            'id'    =>'effortNew',
            'context_menu'=>'submit',
            'icon'  =>'loghours',
        )));

        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('projChangeStatus')->id,
            'name'  =>__('Open / Close'),
            'id'    =>'projOpenClose',
            'context_menu'=>'submit',
        )));

        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('projNew')->id,
            'name'  =>__('Create new project'),
            'id'    =>'projNew',
            'icon'  =>'new',
            'context_menu'=>'submit',
        )));

        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('projCreateTemplate')->id,
            'name'  =>__('Create Template'),
            'id'    =>'projCreateTemplate',
            'dropdown_menu'=>true,
            'context_menu'=>'submit',

        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('projNewFromTemplate')->id,
            'name'  =>__('Project from Template'),
            'id'    =>'projNewFromTemplate',
            'dropdown_menu'=>true,

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
            'name'=>'List',
            'params'=>array(
                'style'=>'list',
                'block_id'=>$this->id,
                'page_id'=>$PH->cur_page->id,
#                'use_collapsed'=>true, @@@ this parameter seems useless
             ),
            'default'=>true,
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
            new ListGroupingStatus(),
            new ListGroupingPrio(),
            new ListGroupingCompany(),
        );
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
    public function print_automatic()
    {
        global $PH;

        if(!$this->active_block_function=$this->getBlockStyleFromCookie()) {
            $this->active_block_function = 'list';
        }

        $this->group_by= get("blockstyle_{$PH->cur_page->id}_{$this->id}_grouping");
        
        $this->initOrderQueryOption();

        ### add filter options ###
        #foreach($this->filters as $f) {
        #    foreach($f->getQuerryAttributes() as $k=>$v) {
        #        $this->query_options[$k]= $v;
        #    }
        #}

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

        $projects= Project::getAll($this->query_options);


        $this->render_list(&$projects);
    }
}


/**
* column active projects
*
*/
class ListBlockCol_ProjectPersons extends ListBlockCol
{
    public $name;
    public $tooltip;
    public $id='persons';
    public $width="70%";

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('People');
        $this->tooltip  =__("... working in project");
    }


	function render_tr(&$project, $style="")
	{
	    global $PH;

		print "<td>";
		if($pps= $project->getProjectPersons()) {

			$str_delimiter="";
			foreach($pps as $pp){
				### ###
				if( $person= Person::getVisibleById($pp->person)) {
					$link= $PH->getLink('personView',$person->getShort(),array('person'=>$person->id));
					print  $str_delimiter . $link;

					$str_delimiter=", ";
				}

			}
		}
		print "</td>";

	}
}

class ListBlockCol_ProjectEffortSum extends ListBlockCol{
    public $name='Efforts';
    public $tooltip="Not cleared project efforts in hours";
    public $id='efforts';

    public function __construct($args=NULL) {
        parent::__construct($args);
    }
	function render_tr(&$project, $style="") {

		if(!isset($project) || !$project instanceof Project) {
			trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}

		$value= round($project->getEffortsSum()/60/60,1);
		if($value) {
			print "<td>{$value}h</td>";
		}
		else {
			print "<td></td>";
		}
	}
}



?>