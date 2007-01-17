<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * derived ListBlock-class for listing changes of an project
 *
 * @includedby:     pages/*
 *
 * @author:         Thomas Mann
 * @uses:           ListBlock
 * @usedby:
 *
 */

class ListBlock_projectchanges extends ListBlock
{
    public $bg_style = "bg_time";
	public $filters = array();

	public function __construct($args=NULL)
    {
		parent::__construct($args);

		global $PH;
		global $auth;

		$this->id='changes';

		$this->title=__("Changes");
		$this->id="changes";
		$this->no_items_html= __('Nothing has changed.');


		$this->add_col( new ListBlockColSelect());

		$this->add_col(new ListBlockCol_ChangesByPerson());

		$this->add_col(new ListBlockCol_ChangesEditType());
		$this->add_col(new ListBlockCol_ChangesItemType());
		$this->add_col(new ListBlockCol_ChangesItemName());
		/*$this->add_col(new ListBlockCol_Person(array(
			'key'=>'created_by',
			'name'=>__('Created by'),
			'tooltip'=>__('Item was originally created by'),
		)));
		*/

		$this->add_col( new listBlockColDate(array(
			'key'=>'modified',
			'name'=>__('modified')
		)));
		$this->add_col(new ListBlockCol_ChangesItemState());
		$this->add_col( new ListBlockColPubLevel());



		/*#---- functions ----
		$this->add_function(new ListFunction(array(
			'target'=>$PH->getPage('chanEdit')->id,
			'name'  =>'Edit effort',
			'id'    =>'effortEdit',
			'icon'  =>'edit',
			'context_menu'=>'submit',
		)));
		$this->add_function(new ListFunction(array(
			'target'=>$PH->getPage('effortNew')->id,
			'name'  =>'New effort',
			'id'    =>'effortNew',
			'icon'  =>'new',
			'context_menu'=>'submit',
		)));
		$this->add_function(new ListFunction(array(
			'target'=>$PH->getPage('effortDelete')->id,
			'name'  =>'Delete',
			'id'    =>'effortsDelete',
			'icon'  =>'delete',
			'context_menu'=>'submit',
		)));
		*/

	   ### block style functions ###
		$this->add_blockFunction(new BlockFunction(array(
			'target'=>'changeBlockStyle',
			'key'=>'list',
			'name'=>'List',
			'params'=>array(
				'style'=>'list',
				'block_id'=>$this->id,
				'page_id'=>$PH->cur_page->id,

#                'use_collapsed'=>true, @@@ this parameters seems useless...
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
		   new ListGroupingModifiedBy(),
		   new ListGroupingItemType(),
	   );
   }

    public function print_automatic(&$project)
    {
        global $PH;

        if(!$this->active_block_function=$this->getBlockStyleFromCookie()) {
            $this->active_block_function = 'list';
        }

        if($project) {
            $this->query_options['project']= $project->id;
        }
        $this->query_options['alive_only'] = false;

        $this->group_by= get("blockstyle_{$PH->cur_page->id}_{$this->id}_grouping");

        $s_cookie= "sort_{$PH->cur_page->id}_{$this->id}_{$this->active_block_function}";
        if($sort= get($s_cookie)) {
            $this->query_options['order_by']= $sort;
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

        $changes= Project::getChanges($this->query_options);

        $this->render_list(&$changes);
    }
}





/**
* returns the type of latest edit (create,modified,deleted)
*
*/
class ListBlockCol_ChangesEditType extends ListBlockCol
{

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name     =__('C');
        $this->tooltip=__("Created,Modified or Deleted");
    }


	function render_tr(&$obj, $style="")
	{
        $date_created=$obj->created;
        $date_modified=$obj->modified;
        $date_deleted=$obj->deleted;


        $str="";
        if($date_deleted >= $date_modified) {
            $str= __("Deleted");
        }
        else if($date_modified > $date_created) {
            $str= __("Modified");
        }
        else {
            $str= "<span class='new'>" . __("new") . '</span>';
        }

		print "<td>$str</td>";
	}
}


/**
* prints person causing change (depending what happed last)
*
*/
class ListBlockCol_ChangesByPerson extends ListBlockCol
{
    public $key= 'modified_by';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('by Person');
        $this->tooltip=__("Person who did the last change");
    }

	function render_tr(&$obj, $style="") {
		$date_created=$obj->created;
        $date_modified=$obj->modified;
        $date_deleted=$obj->deleted;

        $person=NULL;
        $str="";
        if($date_deleted >= $date_modified) {
            $person= Person::getVisibleById($obj->deleted_by);
        }
        else if($date_modified > $date_created) {
            $person= Person::getVisibleById($obj->modified_by);
        }
        else {
            $person= Person::getVisibleById($obj->created_by);
        }

		$str_link="";
		if($person) {
			$str_link=$person->getLink();
		}
		print "<td>$str_link</td>";

	}
}


/**
* prints person causing change (depending what happed last)
*
*/
class ListBlockCol_Person extends ListBlockCol
{


	function render_tr(&$obj, $style="") {

        $key=$this->key;
        if($person= new Person($obj->$key)) {
            $str_link=$person->getLink();
        }
		print "<td>$str_link</td>";
	}
}


/**
* returns the type of item
*
*/
class ListBlockCol_ChangesItemType extends ListBlockCol
{
    public $key= 'type';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Type','Column header');
    }


	function render_tr(&$obj, $style="") {
	    global $g_item_type_names;

        if(!$typename= $g_item_type_names[$obj->type]) {
            trigger_error(sprintf(__("item %s has undefined type"),$obj->id),E_USER_NOTICE);
            $typename="?";
        }
		print "<td>$typename</td>";
	}
}


/**
* returns the state of item (alive/deleted)
*
*/
class ListBlockCol_ChangesItemState extends ListBlockCol
{
    public $key=    'state';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Del');
        $this->tooltip=__("shows if item is deleted");
    }

	function render_tr(&$obj, $style="") {
	    global $PH;

	    $str= "?";
        switch($obj->state) {
            case 1:
                $str="";
                break;
            case -1:
                $str= $PH->getLink('itemsRestore',__('restore'),array('item'=>$obj->id));
                break;

        }

		print "<td class=nowrap>$str</td>";
	}
}

/**
* returns the name and link to item
*
*/
class ListBlockCol_ChangesItemName extends ListBlockCol
{
    public $width="80%";

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Name');
    }


	function render_tr(&$obj, $style="")
	{
	    global $PH;

        $str_url="";
        $str_name="";
        $str_addon="";
        switch($obj->type) {
            case ITEM_TASK:
                if($task= Task::getVisibleById($obj->id)) {
                    $str_name= asHtml($task->name);
                    $str_url= $PH->getUrl('taskView',array('tsk'=>$task->id));
                }
                break;

            case ITEM_COMMENT:
                require_once(confGet('DIR_STREBER') . 'db/class_comment.inc.php');
                if($comment= Comment::getVisibleById($obj->id)) {
                    $str_name= asHtml($comment->name);
                    if($comment->comment) {
                        $str_url= $PH->getUrl('taskView',array('tsk'=>$comment->task));
                        $str_addon=__("(on comment)");
                    }

                    else if($comment->task) {
                        $str_url= $PH->getUrl('taskView',array('tsk'=>$comment->task));
                        $str_addon=__("(on task)");

                    }

                    else {
                        $str_url= $PH->getUrl('projView',array('prj'=>$comment->project));
                        $str_addon=__("(on project)");
                    }
                }
                break;

            case ITEM_PROJECTPERSON:
                if($pp= ProjectPerson::getVisibleById($obj->id)) {
                    if(!$person= new Person($pp->person)) {
                        $PH->abortWarning("ProjectPerson has invalid person-pointer!",ERROR_BUG);
                    }
                    $str_name= asHtml($person->name);
                    $str_url= $PH->getUrl('personView',array('person'=>$person->id));

                }
                break;

            case ITEM_EFFORT:
                require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
                if($e= Effort::getVisibleById($obj->id)) {
                    $str_name= asHtml($e->name);
                    $str_url= $PH->getUrl('effortEdit',array('effort'=>$e->id));

                }
                break;
            case ITEM_FILE:
                require_once(confGet('DIR_STREBER') . 'db/class_file.inc.php');
                if($f= File::getVisibleById($obj->id)) {
                    $str_name= asHtml($f->org_filename);
                    $str_url= $PH->getUrl('fileView',array('file'=>$f->id));
                }

            default:
                break;

        }
		print "<td><a href='$str_url'>$str_name</a> $str_addon</td>";
	}
}





?>
