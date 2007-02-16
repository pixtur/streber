<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * derived ListBlock-class for listing changes of an project (second try)
 *
 * @includedby:     pages/*
 *
 * @author:         Thomas Mann
 * @uses:           ListBlock
 * @usedby:

*/

require_once(confGet('DIR_STREBER') . 'db/class_comment.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_page.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . "db/db_itemchange.inc.php");

define('COMMENT_LEN_PREVIEW',   240);
define('ITEM_DELETED', 1);
define('ITEM_MODIFIED', 2);
define('ITEM_NEW', 3);


/**
* class for assembling information in a change-list-line
*
* Some notes:
* - changes are collected for each person since given date by the static function "getChangeLinesForPerson()"
* - this function returns a list of ChangeLines that can be used either to print html-lists or
*   to compose Notification mails
* - this function has not been optimized for performance
*
*/
class ChangeLine extends BaseObject {
    public $project_id;
    public $timestamp;
    public $person_by;
    public $relavant_to_cur_user= true;
    public $html_what;
    public $txt_what;
    public $what;
    public $task;
    public $task_id;
    public $task_html;
    public $html_details;
    public $html_assignment;


    public function __construct($args)
    {
        parent::__construct($args);
    }



    static function &getChangeLinesForPerson(&$person, $project=NULL, $date_compare=NULL)
    {
        global $PH;
        $query_options= array();

        if(!$date_compare) {
            $date_compare= $person->last_logout;
        }

        if($project) {
            $query_options['project']= $project->id;
        }
        fillMissingValues($query_options, array(
            'alive_only'     => false,
            'date_min'       => $date_compare,
            'not_modified_by'=> $person->id,
        ));

        $change_lines= ChangeLine::getChangeLines($query_options);
        return $change_lines;
    }


    static function &getChangeLines(&$query_options)
    {
        global $PH;

        global $auth;
        fillMissingValues($query_options, array(
            'alive_only' => false,
        ));


        $date_compare= isset($query_options['date_min'])
                    ? $query_options['date_min']
                    : "0000-00-00";


        /**
        * get list of items touched by other persons
        */       
		$changed_items= DbProjectItem::getAll($query_options);
        
        

        /**
        * go through list
        */

        $changes= array();
        foreach($changed_items as $i) {
            $change_type= NULL;

            if(!isset($query_options['project'])){
                $project= Project::getVisibleById($i->project);
            }
            else {
                $project= NULL;
            }

            /**
            * get item-change-type depeding on dates
            */
            if($i->deleted >= $i->modified) {
                $change_type= ITEM_DELETED;
            }
            else if($i->modified > $i->created) {
                $change_type= ITEM_MODIFIED;
            }
            else {
                $change_type= ITEM_NEW;
            }


            /**
            * build up change-list
            */
            switch($change_type) {
            case ITEM_NEW:

                if($i->type == ITEM_TASK) {
                    if(!$task= Task::getVisibleById($i->id)) {
                        continue;
                    }

                    if($assigned_persons= $task->getAssignedPersons()) {
                        $tmp=array();

                        foreach($assigned_persons as $ap) {
                            $tmp[]= $ap->getLink();
                        }

                        $html_assignment= __('to','very short for assigned tasks TO...'). ' ' . implode(', ', $tmp);
                    }
                    else {
                        $html_assignment= '';
                    }



                    $html_details= '';
                    if($tmp= $task->getFolderLinks(true, $project)) {
                        $html_details .=__('in', 'very short for IN folder...'). ' '. $tmp;
                    }

                    if($task->prio != PRIO_NORMAL && $task->prio != PRIO_UNDEFINED) {
                        global $g_prio_names;
                        $html_details .= ' / ' . $g_prio_names[$task->prio];
                    }


                    $change= new ChangeLine(array(
                        'person_by' =>      $i->created_by,
                        'timestamp' =>      $i->created,
                        'task_id'   =>      $i->id,
                        'html_what' =>      '<span class=new>'. __('new') .' '. $task->getLabel() .'</span>',
                        'txt_what'  =>      __('new') .' '. $task->getLabel(),
                        'html_assignment'=> $html_assignment,
                        'html_details'=>    $html_details,
                    ));
                    $changes[]= $change;
                }
                else {


                }
                break;

            case ITEM_MODIFIED:

                $timestamp_last_change= $date_compare;                 # make sure we use the last occured change type
                /**
                * modified tasks
                */
                if($i->type == ITEM_TASK) {


                    if(!$task= Task::getVisibleById($i->id)) {
                        continue;
                    }

                    if($assigned_persons= $task->getAssignedPersons()) {
                        $tmp=array();

                        foreach($assigned_persons as $ap) {
                            $tmp[]= $ap->getLink();
                        }

                        $html_assignment= __('to','very short for assigned tasks TO...'). ' ' . implode(', ', $tmp);
                    }
                    else {
                        $html_assignment= '';
                    }

                    $html_details= '';
                    if($tmp= $task->getFolderLinks(true, $project)) {
                        $html_details .=__('in', 'very short for IN folder...'). ' '. $tmp;
                    }

                    $html_what= __('modified');


                    ### try to get comments
                    {
                        $html_comment= '';
                        if($comments = Comment::getAll(array(
                            'person' => $i->modified_by,
                            'task' => $task->id,
                            'date_min'  => $timestamp_last_change,
                        ))) {
                            $last_comment= $comments[count($comments)-1];
                            $timestamp_last_change= $last_comment->created;


                            if($last_comment->name != __('New Comment')) {      # ignore default title
                                $html_comment= strip_tags($last_comment->name). ': ';
                            }
                            $html_comment.= strip_tags($last_comment->description);
                            if(strlen($html_comment) > COMMENT_LEN_PREVIEW) {
                                $html_comment= substr($html_comment, 0, COMMENT_LEN_PREVIEW). "...";
                            }
                            if(count($comments) > 1) {
                                $html_comment= sprintf(__('Last of %s comments:'), count($comments)). ' '. $html_comment;
                            }
                            else {
                                $html_comment= __('comment:'). ' '. $html_comment;
                            }
                            $html_comment = asHtml($html_comment);
                        }
                    }

                    ### get changed fields ###
                    $changed_fields_hash=array();
                    $html_functions= false; # this is to be added after the details
                    {
                        if($changed_fields_list= ItemChange::getItemChanges(array(
                            'item'      => $i->id,
                            'person'    => $i->modified_by,
                            'date_min'  => $date_compare,
                        ))) {
                            foreach($changed_fields_list as $cf) {
                                $changed_fields_hash[$cf->field]= $cf;
                            }

                            if(isset($changed_fields_hash['status'])) {
                                $status_old= $changed_fields_hash['status']->value_old;
                                if($task->status == STATUS_COMPLETED && $task->status > $status_old) {
                                    $html_what= __('completed') .' '. $task->getLabel();
                                    $html_functions= $PH->getLink('tasksApproved', __('Approve Task'),array('tsk' => $task->id));
                                    unset($changed_fields_hash['status']);
                                }
                                else if ($task->status == STATUS_APPROVED && $task->status > $status_old) {
                                    $html_what= __('approved');
                                    unset($changed_fields_hash['status']);
                                }
                                else if ($task->status == STATUS_CLOSED && $task->status > $status_old) {
                                    $html_what= __('closed');
                                    unset($changed_fields_hash['status']);
                                }
                                else if ($task->status == STATUS_OPEN && $task->status < $status_old) {
                                    $html_what= __('reopened');
                                    unset($changed_fields_hash['status']);
                                }
                                else if($task->status == STATUS_OPEN) {
                                    unset($changed_fields_hash['status']);
                                }
                                else if ($task->status == STATUS_BLOCKED) {
                                    $html_what= __('is blocked');
                                    unset($changed_fields_hash['status']);
                                }
                            }
                        }
                        if(isset($changed_fields_hash['parent_task'])) {
                            $html_what= __('moved');
                            unset($changed_fields_hash['parent_task']);
                        }

                        else if(count($changed_fields_hash) == 1 && isset($changed_fields_hash['name'])) {
                            $html_what= __('renamed');
                        }
                        else if(count($changed_fields_hash) == 1 && isset($changed_fields_hash['description'])) {
                            $html_what= __('edit wiki');
                        }

                        else if(count($changed_fields_hash)) {                        # status does not count
                            $html_details .= ' / ' . __('changed:'). ' '. implode(', ', array_keys($changed_fields_hash));
                            #if($html_comment) {
                            #    $html_details.= '<br> / '. $html_comment;
                            #}
                        }

                        /**
                        * task modified, but nothing changed, any comments?
                        */
                        else if($html_comment) {
                            $html_what= __('commented');
                        }

                        if($html_comment) {
                            $html_details .= ' / ' . $html_comment;
                        }

                    }

                    /**
                    * any recents assignments ?
                    * - to avoid confusion only list assignmets if it was to last action,
                    *
                    */

                    require_once "db/class_taskperson.inc.php";
                    $count_assignments=0;
                    if($assignments= TaskPerson::getTaskPersons(array(
                        'task'      => $task->id,
                        'project'   => $task->project,
                        'date_min'  => $task->modified,
                    ))) {
                        $t_timestamp= '';
                        foreach($assignments as $a) {

                            if($a->person != $task->modified_by
                              &&
                              $a->created_by == $task->modified_by
                              &&
                              $a->assigntype != ASSIGNTYPE_INITIAL
                            ) {
                                $t_timestamp = $a->created;
                                $count_assignments++;
                            }
                        }
                        if($count_assignments
                           &&
                           $timestamp_last_change < $t_timestamp
                        ) {
                            $html_what= __('assigned');
                            $timestamp_last_change = $t_timestamp;
                        }

                        if($html_comment) {
                            $html_details .= ' / ' . $html_comment;
                        }
                    }

                    /**
                    * any recents attachments ?
                    */
                    require_once "db/class_file.inc.php";
                    if($files= File::getAll(array(
                        'parent_item'      => $task->id,
                        'project'   => $task->project,
                        'date_min'  => $date_compare,
                    ))) {
                        $count_attached_files= 0;
                        $html_attached=__("attached").": ";
                        $t_timestamp='';
                        foreach($files as $f) {
                            #if($person->id != $f->modified_by) {
                                $t_timestamp= $f->created;
                                $count_attached_files++;
                                $html_attached.= $PH->getLink('fileView', $f->name, array('file'=>$f->id));
                            #}
                        }
                        if($count_attached_files) {
                            $html_what= __('attached file to');
                            if($timestamp_last_change < $t_timestamp) {
                                $html_details.= ' / '. $html_attached;
                                $timestamp_last_change = $t_timestamp;
                            }
                        }
                    }

                    if(count($changed_fields_hash)){
                        $html_details.=" / ". $PH->getLink('itemViewDiff',NULL, array('item'=>$task->id, 'date1' => $date_compare, 'date2' => gmdate("Y-m-d H:i:s")));
                    }

                    if($html_functions) {
                        $html_details.= " | ". $html_functions;
                    }

                    $change= new ChangeLine(array(
                        'person_by' =>      $i->modified_by,
                        'timestamp' =>      $i->modified,
                        'task_id'   =>      $i->id,
                        'html_what' =>      $html_what,
                        'html_assignment'=> $html_assignment,
                        'html_details'=>    $html_details,
                        #'project_id'=> $i->project,
                    ));
                    $changes[]= $change;
                }

                break;


            case ITEM_DELETED:

                /**
                * deleted tasks
                */
                if($i->type == ITEM_TASK) {
                    if(!$task= Task::getVisibleById($i->id)) {
                        continue;
                    }

                    if($assigned_persons= $task->getAssignedPersons()) {
                        $tmp=array();

                        foreach($assigned_persons as $ap) {
                            $tmp[]= $ap->getLink();
                        }

                        $html_assignment= __('to','very short for assigned tasks TO...'). ' ' . implode(', ', $tmp);
                    }
                    else {
                        $html_assignment= '';
                    }


                    $html_details= '';
                    if($tmp= $task->getFolderLinks(true, $project)) {
                        $html_details .=__('in', 'very short for IN folder...'). ' '. $tmp;
                    }

                    $html_details.= '|' .  $PH->getLink('itemsRestore',__('restore'),array('item'=>$task->id));

                    $html_what= __('deleted');


                    $change= new ChangeLine(array(
                        'person_by' =>      $i->deleted_by,
                        'timestamp' =>      $i->deleted,
                        'task_id'   =>      $i->id,
                        'html_what' =>      $html_what,
                        'html_assignment'=> $html_assignment,
                        'html_details'=>    $html_details,
                    ));
                    $changes[]= $change;
                }

                /**
                * deleted file
                */
                if($i->type == ITEM_FILE) {

                    /**
                    * @@@ add some output for deleted files
                    */
                }

                break;

            default:
                trigger_error("unknown change-type $change_type", E_USER_WARNING);
                break;
            }
        }
        return $changes;
    }
}









class ListBlock_changes extends ListBlock
{
    private  $list_changes_newer_than= '';                      # timestamp
	public   $filters = array();

    public function __construct($args=NULL)
    {
        parent::__construct($args);

        $this->bg_style= 'bg_time';

        global $PH;
        global $auth;

        $this->id='changes';

        $this->title=__("Changes");
        $this->id="changes";
        $this->no_items_html= sprintf(__('Other team members changed nothing since last logout (%s)'), renderDate($auth->cur_user->last_logout));


        $this->add_col( new ListBlockCol_ChangesDate());
        $this->add_col( new ListBlockCol_ChangesWhat());
        $this->add_col( new ListBlockCol_ChangesDetails());
		
    }



    public function print_automatic()
    {
        global $PH;
        global $auth;
				
        ### add filter options ###
        foreach($this->filters as $f) {
            foreach($f->getQuerryAttributes() as $k=>$v) {
			    $this->query_options[$k]= $v;
            }
        }
				
		if($auth->cur_user->user_rights & RIGHT_VIEWALL){
			$this->query_options['visible_only'] = false;
		}
		else{
			$this->query_options['visible_only'] = true;
		}
        #$changes= ChangeLine::getChangeLinesForPerson($auth->cur_user, NULL);
        #$this->query_options['not_modified_by']= $auth->cur_user->id;
        $changes= ChangeLine::getChangeLines($this->query_options);

        $this->render_list(&$changes);

    }



    /**
    * render complete
    */
    public function render_list(&$changes=NULL)
    {
        global $PH;



        $this->render_header();

        if(!$changes && $this->no_items_html) {
            $this->render_tfoot_empty();
        }
        else {

            $style='changeList';

            ### render table lines ###
            $this->render_thead();

            $last_group= NULL;
			
            foreach($changes as $c) {

                $this->render_trow(&$c,$style);
            }

            $this->render_tfoot();
        }
    }
}



/**
* prints person causing change (depending what happed last)
*
*/
class ListBlockCol_ChangesDate extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Date');
        $this->tooltip=__("Who changed what when...");
    }

    function render_tr(&$change_line, $style="")
    {
        if($change_line instanceof ChangeLine) {
            if($change_line->person_by) {
                if($person= Person::getVisibleById($change_line->person_by)) {
                    print '<td><span class=date>'.renderDateHtml($change_line->timestamp) .'</span><br><span class="sub who">by '. $person->getLink() .'</span></td>';
                    return;
                }

            }
            print '<td><span class=date>'.renderDateHtml($change_line->timestamp) .'</span></td>';
        }
        else {
            trigger_error('ListBlockCol_ChangesDate() requires instance of ChangeLine',E_USER_WARNING);
            print "<td></td>";
        }
    }
}



/**
* prints person causing change (depending what happed last)
*
*/
class ListBlockCol_ChangesWhat extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('what','column header in change list');
        $this->width ='10%';
    }

    function render_tr(&$change_line, $style="")
    {
        if(!$change_line instanceof ChangeLine) {
            trigger_error('ListBlockCol_ChangesWhat() requires instance of ChangeLine',E_USER_WARNING);
            print "<td></td>";
            return;
        }

        if($change_line->html_what) {
            $str_what= $change_line->html_what;
        }
        else {
            $str_what='';
        }

        $html_assignment= $change_line->html_assignment
                        ? '<span class=assigment>' . $change_line->html_assignment . '</span>'
                        : '';

        print '<td><span class=nowrap>'. $str_what .'</span><br><span class="sub who">'. $html_assignment .'</span></td>';
    }
}




/**
* prints person causing change (depending what happed last)
*
*/
class ListBlockCol_ChangesDetails extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Task');
        $this->width ='80%';
    }

    function render_tr(&$change_line, $style="")
    {
        if(!$change_line instanceof ChangeLine) {
            trigger_error('ListBlockCol_ChangesDetails() requires instance of ChangeLine',E_USER_WARNING);
            print "<td></td>";
            return;
        }

        if($change_line->task_html) {
            $str_task= $change_line->task_html;
        }
        else if($change_line->task) {
            $str_task= $task->getLink(false);
        }
        else if($change_line->task_id) {
            if($task= Task::getVisibleById($change_line->task_id)) {
                global $auth;

                ### high light changes by others ###
                $str_task= $task->getLink(false);

                if($task->status >= STATUS_COMPLETED) {
                    $str_task= '<span class=isDone>'. $str_task.'</span>';
                }

                if($change_line->person_by == $auth->cur_user->id) {
                    $str_task= '<b' . $str_task . '</b>';
                }
            }
        }
        else {
            '';
        }

        $str_details= $change_line->html_details
                 ? $change_line->html_details
                 : "";

        print '<td>'.$str_task .'<br><span class="sub">'. $str_details.'</span></td>';
    }
}












/**
* prints person causing change (depending what happed last)
*
*/
class ListBlockCol_ChangesDatePerson extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Date / by');
        $this->tooltip=__("Who changed what when...");
    }

    function render_tr(&$item, $style="")
    {
        $date_created=  $item->created;
        $date_modified= $item->modified;
        $date_deleted=  $item->deleted;

        $person=NULL;
        $str="";
        if($date_deleted >= $date_modified) {
            $person= Person::getVisibleById($item->deleted_by);
        }
        else if($date_modified > $date_created) {
            $person= Person::getVisibleById($item->modified_by);
        }
        else {
            $person= Person::getVisibleById($item->created_by);
        }

        $str_link="";
        if($person) {
            $str_link=$person->getLink();
        }
        print '<td><span class=date>'.$renderTimestampHtml($date_modified) .'</span><span class=sub>'. $person->getLink() .'</span></td>';
    }
}


class ListBlock_AllChanges extends ListBlock
{
    public $bg_style = "bg_time";
	public $filters = array();

	public function __construct($args=NULL)
    {
		parent::__construct($args);

		global $PH;
		global $auth;

		$this->id = 'allchanges';

		$this->title = __("Changes");
		$this->id = "allchanges";
		$this->no_items_html = __('Nothing has changed.');

		$this->add_col( new ListBlockColSelect());
		## from list_projectchanages.inc.php ##
		$this->add_col(new ListBlockCol_ChangesByPerson());
		$this->add_col(new ListBlockCol_ChangesEditType());
		$this->add_col(new ListBlockCol_ChangesItemType());
		$this->add_col(new ListBlockCol_AllChangesItemName());
		$this->add_col( new listBlockColDate(array(
			'key'=>'modified',
			'name'=>__('modified')
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

        $changes = DbProjectItem::getChanges($this->query_options);

        $this->render_list(&$changes);
    }
}

class ListBlockCol_AllChangesItemName extends ListBlockCol
{
    public $width = "80%";

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name = __('Name');
    }

	function render_tr(&$obj, $style="")
	{
	    global $PH;

        $str_url="";
        $str_name="";
        $str_addon="";
        switch($obj->type) {
			case ITEM_PROJECT:
				if($project = Project::getVisibleById($obj->id)) {
                    $str_name = asHtml($project->name);
                    $str_url = $PH->getUrl('projView',array('prj'=>$project->id));
                }
                break;

            case ITEM_TASK:
                if($task = Task::getVisibleById($obj->id)) {
                    $str_name = asHtml($task->name);
                    $str_url = $PH->getUrl('taskView',array('tsk'=>$task->id));
					if($project = Project::GetVisibleById($task->project)){
						$str_addon = "(".$project->getLink(false).")";
					}
                }
                break;

            case ITEM_COMMENT:
                if($comment = Comment::getVisibleById($obj->id)) {
					if($comment->name == ''){
						$str_name = "-";
					}
					else{
                    	$str_name = asHtml($comment->name);
					}
                    $str_url = $PH->getUrl('taskView',array('tsk'=>$comment->task));
					$str_addon .= "(";
					if($task = Task::getVisibleById($comment->task)){
						if($project = Project::getVisibleById($task->project)){
							$str_addon .= $project->getLink(false) . " > ";
						}
						$str_addon .= $task->getLink(false);
						if($comment->comment){
							if($comm = Comment::getVisibleById($comment->comment)){
								$str_addon .= " > " . $comm->name;
							}
						}
					}
					$str_addon .= ")";

                }
                break;

			case ITEM_COMPANY:
				if($c = Company::getVisibleById($obj->id)) {
                    $str_name = asHtml($c->name);
                    $str_url = $PH->getUrl('companyView',array('company'=>$c->id));
                }
                break;

			case ITEM_PERSON:
				if($person = Person::getVisibleById($obj->id)) {
                    $str_name = asHtml($person->name);
                    $str_url = $PH->getUrl('personView',array('person'=>$person->id));
                }
                break;

            case ITEM_PROJECTPERSON:
                if($pp = ProjectPerson::getVisibleById($obj->id)) {
                    if(!$person= new Person($pp->person)) {
                        $PH->abortWarning("ProjectPerson has invalid person-pointer!",ERROR_BUG);
                    }
                    $str_name = asHtml($person->name);
                    $str_url = $PH->getUrl('personView',array('person'=>$person->id));
					if($project = Project::getVisibleById($pp->project)){
						$str_addon = "(" . $project->getLink(false) .")";
					}

                }
                break;

			case ITEM_EMPLOYMENT:
                if($emp= Employment::getById($obj->id)) {
                    if($person= Person::getVisibleById($emp->person)) {
						$str_name= asHtml($person->name);
						$str_url= $PH->getUrl('personView',array('person'=>$person->id));
                	}
					if($company = Company::getVisibleById($emp->company)){
						$str_addon= "(". $company->getLink(false) .")";
					}
                }
                break;

            case ITEM_EFFORT:
                if($e= Effort::getVisibleById($obj->id)) {
                    $str_name= asHtml($e->name);
                    $str_url= $PH->getUrl('effortEdit',array('effort'=>$e->id));
					if($task = Task::getVisibleById($e->task)){
						if($project = Project::getVisibleById($task->project)){
							$str_addon .= "(". $project->getLink(false) ;
							$str_addon .= " > ". $task->getLink(false) .")";
						}
					}

                }
                break;

            case ITEM_FILE:
                if($f= File::getVisibleById($obj->id)) {
                    $str_name= asHtml($f->org_filename);
                    $str_url= $PH->getUrl('fileView',array('file'=>$f->id));
					$str_addon .= "(";
					if($p = Project::getVisibleById($f->project)){
						$str_addon .= $p->getLink(false) ;
					}
					if($t = Task::getVisibleById($f->parent_item)){
						$str_addon .= " > " . $t->getLink(false) ;
					}
					$str_addon .= ")";
                }
				break;

			 case ITEM_ISSUE:
                if($i = Issue::getVisibleById($obj->id)) {
					if($t = Task::getVisibleById($i->task)){
                    	$str_name = asHtml($t->name);
                    	$str_url = $PH->getUrl('taskView',array('tsk'=>$t->id));
						if($p = Project::getVisibleById($t->project)){
							$str_addon .= "(". $p->getLink(false) .")";
						}
					}
                }
				break;

			case ITEM_TASKPERSON:
				if($tp = TaskPerson::getVisibleById($obj->id)) {
					if($person = Person::getVisibleById($tp->person)){
						$str_name = asHtml($person->name);
						$str_url = $PH->getUrl('personView',array('person'=>$person->id));
					}
					if($task = Task::getVisibleById($tp->task)){
						if($project = Project::getVisibleById($task->project)){
							$str_addon .= "(". $project->getLink(false) ;
							$str_addon .= " > ". $task->getLink(false) .")";
						}
					}
				}
				break;

            default:
                break;

        }
		print "<td><a href='$str_url'>$str_name</a><span class='sub who'> $str_addon</span></td>";
	}
}

?>