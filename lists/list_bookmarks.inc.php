<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * derived ListBlock-class for listing bookmarks
 *
 * @includedby:     pages/*
 *
 * @author:         Esther Burger
 * @uses:           ListBlock
 * @usedby:
 *
 */

require_once('db/db_itemperson.inc.php');
require_once('db/db_item.inc.php');

class ListGroupingType extends ListGrouping {

    public function __construct($args=NULL) {
        $this->id = 'type';
        parent::__construct($args);
    }

    /**
    * render separating row
    */
    public function render(&$item)
    {
        global $g_item_type_names;
		if(isset($item->type)){
            $type_name = $g_item_type_names[$item->type];
			return $type_name;
		}
        else {
            trigger_error("can't group for type",E_USER_NOTICE);
            return "---";
        }
    }
}

class ListBlock_bookmarks extends ListBlock
{
	public function __construct($args=NULL)
    {
		parent::__construct($args);

		global $PH;
		global $auth;

		$this->id='bookmarks';
		$this->title=__('Your bookmarks');
		$this->no_items_html= __("You have no bookmarks");
        $this->show_icons = true;

		$this->add_col(new ListBlockColSelect());
		$this->add_col(new ListBlockCol_ItemType());
		$this->add_col(new ListBlockCol_ItemMonitored());
		#$this->add_col(new ListBlockCol_ItemStatus());
		#$this->add_col(new ListBlockCol_ItemState());
		#$this->add_col(new ListBlockCol_ItemProjectName());
		$this->add_col(new ListBlockCol_ItemName());
		$this->add_col(new ListBlockCol_ItemComment());
		$this->add_col(new ListBlockCol_ItemRemind());
		#$this->add_col(new ListBlockCol_ItemModifier());
		$this->add_col(new ListBlockCol_ItemModified());

		$this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('itemBookmarkEdit')->id,
            'name'  =>__('Edit bookmark'),
            'id'    =>'itemBookmarkEdit',
            'icon'  =>'edit',
            'context_menu'=>'submit',
        )));
		$this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('itemsRemoveBookmark')->id,
            'name'  =>__('Remove bookmark'),
            'id'    =>'itemsRemoveBookmark',
            'context_menu'=>'submit',
        )));
		
		### block style functions ###
        $this->add_blockFunction(new BlockFunction(array(
            'target'=>'changeBlockStyle',
            'key'=>'list',
            'name'=>__('List','List sort mode'),
            'params'=>array(
                'style'=>'list',
                'block_id'=>$this->id,
                'page_id'=>$PH->cur_page->id,
                #'use_collapsed'=>true, @@@ this parameter seems useless
             ),
            'default'=>true,
        )));
        $this->groupings= new BlockFunction_grouping(array(
            'target'=>'changeBlockStyle',
            'key'=>'grouped',
            'name'=>__('Grouped','List sort mode'),
            'params'=>array(
                'style'=>'grouped',
                'block_id'=>$this->id,
                'page_id'=>$PH->cur_page->id,
            ),
        ));

        $this->add_blockFunction($this->groupings);
		
		### list groupings ###
        $this->groupings->groupings= array(
            new ListGroupingType(),
        );
   }

    public function print_automatic()
    {
        global $PH;
		global $auth;
		
		if(!$this->active_block_function=$this->getBlockStyleFromCookie()) {
            $this->active_block_function = 'list';
        }

        $this->group_by= get("blockstyle_{$PH->cur_page->id}_{$this->id}_grouping");
		
		#$this->initOrderQueryOption("created DESC");
		$this->initOrderQueryOption();
		
        $this->query_options['person'] = $auth->cur_user->id;
		$this->query_options['is_bookmark'] = 1;
		
		### grouped view ###
        if($this->active_block_function == 'grouped') {
            /**
            * @@@ later use only once...
            *
            *   $this->columns= filterOptions($this->columns,"CURPAGE.BLOCKS[{$this->id}].STYLE[{$this->active_block_function}].COLUMNS");
            */
			
            if(isset($this->columns[$this->group_by])) {
                unset($this->columns[$this->group_by]);
            }
			
			#$this->query_options['order_by'] = '';
            ### prepend key to sorting ###
            if(isset($this->query_options['order_by'])) {
                $this->query_options['order_by'] = $this->groupings->getActiveFromCookie() . ",".$this->query_options['order_by'];
				#$this->query_options['order_by'] = 'id';

            }
            else {
                $this->query_options['order_by'] = $this->groupings->getActiveFromCookie();
				#$this->query_options['order_by'] = 'id';
            }
        }
        ### list view ###
        else {
            $pass= true;
        }

		$bookmark_items = ItemPerson::getAll($this->query_options);
		
		$items= array();

		foreach($bookmark_items as $bi) {
		    if($item= DbProjectItem::getVisibleById($bi->item)) {
		       $items[]= $item;
		    }
		}

        $this->render_list(&$items);
    }
}


/**
* returns the type of the item
*
*/
class ListBlockCol_ItemType extends ListBlockCol
{
    public function __construct($args=NULL)
    {
        parent::__construct($args);
		$this->id = 'type';
		$this->key = 'type';
        $this->name = __('Type');
		$this->width = '10%';
    }


    function render_tr(&$item, $style="")
    {
        global $g_item_type_names;
		global $g_tcategory_names;
		global $g_status_names;

		$type_name = '';
		$status_name = '';
		$isDone = '';

        if($type = $item->type){
            $type_name = $g_item_type_names[$type];
            switch($type){
                case ITEM_TASK:
					require_once("db/class_task.inc.php");
					if($task = Task::getVisibleById($item->id)) {
						$type_name = $g_tcategory_names[$task->category];
						$status_name = asHtml($g_status_names[$task->status]);
						if($task->status >= STATUS_COMPLETED){
							$isDone = 'isDone';
						}
					}
					break;

				case ITEM_COMMENT:
					$status_name = '';
					break;

				case ITEM_PERSON:
					$status_name = '';
					break;

				case ITEM_EFFORT:
					$status_name = '';
					break;

				case ITEM_FILE:
					require_once("db/class_file.inc.php");
					if($f = File::getVisibleById($item->id)) {
						$status_name = asHtml($g_status_names[$f->status]);
						if($f->status >= STATUS_COMPLETED){
							$isDone = 'isDone';
						}
					}
					break;

				case ITEM_PROJECT:
					require_once("db/class_project.inc.php");
					if($prj = Project::getVisibleById($item->id)) {
						$status_name = asHtml($g_status_names[$prj->status]);
						if($prj->status >= STATUS_COMPLETED){
							$isDone = 'isDone';
						}
					}
					break;

				case ITEM_COMPANY:
					$status_name = '';
					break;

				case ITEM_VERSION:
					require_once("db/class_task.inc.php");
					if($tsk = Task::getVisibleById($item->id)) {
						$status_name = asHtml($g_status_names[$tsk->status]);
						if($tsk->status >= STATUS_COMPLETED){
							$isDone = 'isDone';
						}
					}
					break;

				default:
					break;
            }

			if($s = $item->state){
				if(isset($s) && $s == -1){
					$status_name = __('deleted');
				}
			}

            echo "<td><span class=$isDone>$type_name</span><br><span class='sub who'>$status_name</span></td>";
        }
        else{
            echo "<td>&nbsp;</td>";
        }
    }
}

/**
* returns if the item is monitored
*
*/
class ListBlockCol_ItemMonitored extends ListBlockCol
{
	public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name = __('');
		$this->width = '5%';
    }


	function render_tr(&$item, $style="")
	{
		global $PH;

		## notification on change ##
		if($notification_items = ItemPerson::getAll(array('item'=>$item->id,'notify_on_change'=>1))){
			print '<td><img title="' . __('Notify on change') . '" src="' . getThemeFile("icons/monitored.png"). '"></td>';
		}
		## notification only on unchanged ##
		else if ($notification_items = ItemPerson::getAll(array('item'=>$item->id,'notify_if_unchanged_min'=>NOTIFY_1DAY))){
			print '<td><img title="' . __('Notify on change') . '" src="' . getThemeFile("icons/monitored.png"). '"></td>';
		}
		else{
			print "<td>&nbsp;</td>";
		}
	}
}

/**
* returns the name of the item
*
*/
class ListBlockCol_ItemName extends ListBlockCol
{

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name = __('Name');
		$this->width = '30%';
    }


	function render_tr(&$item, $style="")
	{
		global $PH;

        $str_url = "";
        $str_name = "";
        $str_addon = "";
		$isDone = "";
		$html_details= "";
		$link = "";

		if($type = $item->type){
			switch($type) {
                case ITEM_TASK:
                    require_once("db/class_task.inc.php");
                    if($task = Task::getVisibleById($item->id)) {
                        $str_name = asHtml($task->name);
                        $str_url = $PH->getUrl('taskView',array('tsk'=>$task->id));
						if($task->status >= STATUS_COMPLETED){
							$isDone = "class=isDone";
						}
						if($prj = Project::getVisibleById($task->project)) {
							$link = $PH->getLink('projView',$prj->getShort(),array('prj'=>$prj->id));
							$html_details .=__('in', 'very short for IN folder...'). ' '. $link;
							if($tmp = $task->getFolderLinks()) {
								$html_details .= ' > ' . $tmp;
							}
						}
                    }
                    break;

				case ITEM_COMMENT:
					require_once("db/class_comment.inc.php");
					if($comment = Comment::getVisibleById($item->id)) {
						$str_name = asHtml($comment->name);
						if($comment->comment) {
							$str_url = $PH->getUrl('taskView',array('tsk'=>$comment->task));
							$str_addon = __("(on comment)");
						}
						else if($comment->task) {
							$str_url = $PH->getUrl('taskView',array('tsk'=>$comment->task));
							$str_addon = __("(on task)");
						}
						else {
							$str_url = $PH->getUrl('projView',array('prj'=>$comment->project));
							$str_addon = __("(on project)");
						}
					}
					break;

				case ITEM_PERSON:
					require_once("db/class_person.inc.php");
					if($person = Person::getVisibleById($item->id)) {
						$str_name = asHtml($person->name);
						$str_url = $PH->getUrl('personView',array('person'=>$person->id));
					}
					break;

				case ITEM_EFFORT:
					require_once("db/class_effort.inc.php");
					if($e = Effort::getVisibleById($item->id)) {
						$str_name = asHtml($e->name);
						$str_url = $PH->getUrl('effortEdit',array('effort'=>$e->id));
					}
					if($prj = Project::getVisibleById($e->project)) {
						$link = $PH->getLink('projView',$prj->getShort(),array('prj'=>$prj->id));
						$html_details .=__('in', 'very short for IN folder...'). ' '. $link;
					}
					break;

				case ITEM_FILE:
					require_once("db/class_file.inc.php");
					if($f = File::getVisibleById($item->id)) {
						$str_name = asHtml($f->org_filename);
						$str_url = $PH->getUrl('fileView',array('file'=>$f->id));
						if($f->status >= STATUS_COMPLETED){
							$isDone = "class=isDone";
						}
						if($prj = Project::getVisibleById($f->project)) {
							$link = $PH->getLink('projView',$prj->getShort(),array('prj'=>$prj->id));
							$html_details .=__('in', 'very short for IN folder...'). ' '. $link;
						}
					}
					break;

				case ITEM_PROJECT:
					require_once("db/class_project.inc.php");
					if($prj = Project::getVisibleById($item->id)) {
						$str_name = asHtml($prj->name);
						$str_url = $PH->getUrl('projView',array('prj'=>$prj->id));
						if($prj->status >= STATUS_COMPLETED){
							$isDone = "class=isDone";
						}
					}
					break;

				case ITEM_COMPANY:
					require_once("db/class_company.inc.php");
					if($c = Company::getVisibleById($item->id)) {
						$str_name = asHtml($c->name);
						$str_url = $PH->getUrl('companyView',array('company'=>$c->id));
					}
					break;

				case ITEM_VERSION:
					require_once("db/class_task.inc.php");
					if($tsk = Task::getVisibleById($item->id)) {
						$str_name = asHtml($tsk->name);
						$str_url = $PH->getUrl('taskView',array('tsk'=>$tsk->id));
						if($tsk->status >= STATUS_COMPLETED){
							$isDone = "class=isDone";
						}
						if($prj = Project::getVisibleById($task->project)) {
							$link = $PH->getLink('projView',$prj->getShort(),array('prj'=>$prj->id));
							$html_details .=__('in', 'very short for IN folder...'). ' '. $link;
						}
					}
					break;

				default:
					break;

			}
			print "<td class='nowrap'><span $isDone><a href='$str_url'>$str_name</a> $str_addon</span>";
			if($html_details){
				print "<br><span class='sub who'>$html_details</span>";
			}
			print "</td>";
		}
		else{
			$PH->abortWarning("Could not get type of the element.",ERROR_BUG);
			print "<td>&nbsp;</td>";
		}
	}
}

/**
* returns the name of the item
*
*/
class ListBlockCol_ItemComment extends ListBlockCol
{

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name = __('Comment');
		$this->width = '35%';
    }


	function render_tr(&$item, $style="")
	{
		global $PH;

		$bookmark_items = ItemPerson::getAll(array(
			'item'          =>$item->id,
		    'is_bookmark'   =>1
		));

        if($bookmark_items[0]->comment){
			print "<td><span>" . $bookmark_items[0]->comment . "</span></td>";
		}
		else{
			print "<td>-</td>";
		}
	}
}

/**
* returns the days till a reminder is send
*
*/
class ListBlockCol_ItemRemind extends ListBlockCol
{
	public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name = __('Remind');
		$this->width = '10%';
    }


	function render_tr(&$item, $style="")
	{
		if($ip = ItemPerson::getAll(array('item'=>$item->id,'notify_if_unchanged_min'=>NOTIFY_1DAY))){
			$period = '';
			switch($ip[0]->notify_if_unchanged){
				case NOTIFY_1DAY:
					$period = 24*60*60;
					break;
				case NOTIFY_2DAYS:
					$period = 2*24*60*60;
					break;
				case NOTIFY_3DAYS:
					$period = 3*24*60*60;
					break;
				case NOTIFY_4DAYS:
					$period = 4*24*60*60;
					break;
				case NOTIFY_5DAYS:
					$period = 5*24*60*60;
					break;
				case NOTIFY_1WEEK:
					$period = 7*24*60*60;
					break;
				case NOTIFY_2WEEKS:
					$period = 2*7*24*60*60;
					break;
				case NOTIFY_3WEEKS:
					$period = 3*7*24*60*60;
					break;
				case NOTIFY_1MONTH:
					$period = 4*7*24*60*60;
					break;
				case NOTIFY_2MONTH:
					$period = 2*4*7*24*60*60;
					break;
			}

			$notify_date = $ip[0]->notify_date;

			if($notify_date != '0000-00-00 00:00:00'){
				$send_date = strToGMTime($notify_date) + $period;
				$current_date = time();
				if($send_date > $current_date){
					$days = round(($send_date - $current_date) / 60 / 60 / 24);
					print "<td>". sprintf(__('in %s day(s)'), $days) . "</td>";
				}
				else{
					$days = round(($current_date - $send_date) / 60 / 60 / 24);
					print "<td>". sprintf(__('since %s day(s)'), $days) . "</td>";
				}
			}
			else{
				print "<td>&nbsp;</td>";
			}
		}
		else{
			print "<td>&nbsp;</td>";
		}
	}
}
/**
* returns the modification date of the item
*
*/
class ListBlockCol_ItemModified extends ListBlockCol
{

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name = __('Modified');
		$this->width = '10%';
    }


	function render_tr(&$item, $style="")
	{
		global $PH;
		$str_date = '';
		$str_name = '';
		$str_url = '';

		if($i = DbProjectItem::getById($item->id)){
			if($i->modified){
				$mod_date = $i->modified;
				$str_date = renderDateHtml($mod_date);
				if($i->modified_by){
					if($person = Person::getVisibleById($i->modified_by)){
						$str_name = asHtml($person->name);
						$str_url = $person->getLink();
					}
				}
				print '<td><span class=date>'. $str_date .'</span><br><span class="sub who">'.__('by').' '. $str_url .'</span></td>';
			}
			else{
				print "<td class='nowrap'>&nbsp;</td>";
			}
		}
		else{
			$PH->abortWarning("Could not get modification date of the element.",ERROR_BUG);
			print "<td class='nowrap'>&nbsp;</td>";
		}

	}
}

/**
* returns the status of the item
*
*/
/*class ListBlockCol_ItemStatus extends ListBlockCol
{

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name = __('Status');
		$this->width = '5%';
    }


    function render_tr(&$item, $style="")
    {
        global $g_status_names;
        global $PH;

        $str_name = "";
		if($type = $item->type){
			switch($type) {
                case ITEM_TASK:
                    require_once("db/class_task.inc.php");
                    if($task = Task::getVisibleById($item->id)) {
                        $str_name = asHtml($g_status_names[$task->status]);
						if($task->status >= STATUS_COMPLETED){
							$str_name = "<span class=isDone>" . $str_name . "</span>";
						}
                    }
                    break;

				case ITEM_COMMENT:
					$str_name = '';
					break;

				case ITEM_PERSON:
					$str_name = '';
					break;

				case ITEM_EFFORT:
					$str_name = '';
					break;

				case ITEM_FILE:
					require_once("db/class_file.inc.php");
					if($f = File::getVisibleById($item->id)) {
						$str_name = asHtml($g_status_names[$f->status]);
						if($f->status >= STATUS_COMPLETED){
							$str_name = "<span class=isDone>" . $str_name . "</span>";
						}
					}
					break;

				case ITEM_PROJECT:
					require_once("db/class_project.inc.php");
					if($prj = Project::getVisibleById($item->id)) {
						$str_name = asHtml($g_status_names[$prj->status]);
						if($prj->status >= STATUS_COMPLETED){
							$str_name = "<span class=isDone>" . $str_name . "</span>";
						}
					}
					break;

				case ITEM_COMPANY:
					$str_name = '';
					break;

				case ITEM_VERSION:
					require_once("db/class_task.inc.php");
					if($tsk = Task::getVisibleById($item->id)) {
						$str_name = asHtml($g_status_names[$tsk->status]);
						if($tsk->status >= STATUS_COMPLETED){
							$str_name = "<span class=isDone>" . $str_name . "</span>";
						}
					}
					break;

				default:
					break;
			}

			print "<td>$str_name</td>";
		}
		else{
            $PH->abortWarning("Could not get the status of the element.",ERROR_BUG);
            print "<td>&nbsp;</td>";
        }
    }
}*/

/**
* returns the project name of the item
*
*/
/*class ListBlockCol_ItemProjectName extends ListBlockCol
{

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name = __('Project');
		$this->width = '14%';
    }

    function render_tr(&$item, $style="")
    {
        global $PH;

		$link = "";
		$isDone = "";
        if($type = $item->type){
            switch($type) {
                case ITEM_TASK:
                    require_once("db/class_task.inc.php");
                    if($task = Task::getVisibleById($item->id)) {
                        if($prj = Project::getVisibleById($task->project)) {
							$link = $PH->getLink('projView',$prj->getShort(),array('prj'=>$prj->id));
							if($task->status >= STATUS_COMPLETED){
								$isDone = "class=isDone";
							}
                        }
                    }
                    break;

                case ITEM_EFFORT:
                    require_once("db/class_effort.inc.php");
                    if($e = Effort::getVisibleById($item->id)) {
                        if($prj = Project::getVisibleById($e->project)) {
							$link = $PH->getLink('projView',$prj->getShort(),array('prj'=>$prj->id));
                        }
                    }
                    break;

                case ITEM_FILE:
                    require_once("db/class_file.inc.php");
                    if($f = File::getVisibleById($item->id)) {
                        if($prj = Project::getVisibleById($f->project)) {
							$link = $PH->getLink('projView',$prj->getShort(),array('prj'=>$prj->id));
                        }
                    }
                    break;

                case ITEM_VERSION:
                    require_once("db/class_task.inc.php");
                    if($task = Task::getVisibleById($item->id)) {
                        if($prj = Project::getVisibleById($task->project)) {
							$link = $PH->getLink('projView',$prj->getShort(),array('prj'=>$prj->id));
							if($task->status >= STATUS_COMPLETED){
								$isDone = "class=isDone";
							}
                        }
                    }
                    break;

                case ITEM_PROJECT:
                    require_once("db/class_project.inc.php");
                    if($prj = Project::getVisibleById($item->id)) {
						$link = '';
                    }
                    break;
                default:
                    break;

            }
            print "<td><span $isDone>$link</td>";
        }
        else{
            $PH->abortWarning("Could not get project name of the element.",ERROR_BUG);
            print "<td>&nbsp;</td>";
        }
    }
}*/

/**
* returns the state of the item
*
*/
/*class ListBlockCol_ItemState extends ListBlockCol
{

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name = __('State');
		$this->width = '1%';
    }


    function render_tr(&$item, $style=""){
		if($s = $item->state){
			if(isset($s) && $s == -1){
				 print '<td><img src="' . getThemeFile("icons/delete.gif") . '"></td>';
			}
			else{
				 print "<td>&nbsp;</td>";
			}
		}
		else{
			$PH->abortWarning("Could not get item.",ERROR_BUG);
            print "<td>&nbsp;</td>";
		}
	}
}*/



/**
* returns the modifier of the item
*
*/
/*class ListBlockCol_ItemModifier extends ListBlockCol
{

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name = __('Modified by');
		$this->width = '15%';
    }


	function render_tr(&$item, $style="")
	{
		global $PH;
		$str_name = '';
		$str_url = '';

		if($i = DbProjectItem::getById($item->id)){
			if($i->modified_by){
				if($person = Person::getVisibleById($i->modified_by)){
					$str_name = asHtml($person->name);
					$str_url = $PH->getUrl('personView',array('person'=>$person->id));
				}
			}
			print "<td><a href='$str_url'>$str_name</a></td>";
		}
		else{
			$PH->abortWarning("Could not get modifier of the element.",ERROR_BUG);
			print "<td>&nbsp;</td>";
		}

	}
}*/
?>
