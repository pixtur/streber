<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt


/**
* Versions can be understood as released milestones
*
*/




/**
 * derived ListBlock-class for listing versions
 *
 * @includedby:     pages/*
 *
 * @author         Thomas Mann
 * @uses:           ListBlock
 * @usedby:
 *
 */
class ListBlock_versions extends ListBlock
{

    public function __construct($args=NULL)
    {
        parent::__construct($args);

        $this->id='tasks';
        $this->title="Versions";
        $this->active_block_function = 'list';

        $this->add_col( new ListBlockColSelect());
        #$this->add_col( new ListBlockColPrio());
        #$this->add_col( new ListBlockColStatus());
        $this->add_col( new ListBlockCol_VersionName());
        $this->add_col( new ListBlockCol_TimeReleased());


        /*$this->add_col( new ListBlockColFormat(array(
            'key'=>'short',
            'name'=>"Name Short",
            'tooltip'=>"Shortnames used in other lists",
            'sort'=>0,
            'format'=>'<nobr><a href="index.php?go=projView&amp;prj={?id}">{?short}</a></nobr>'
        )));*/
        /*$this->add_col( new ListBlockColFormat(array(
            'key'=>'name',
            'name'=>__("Version"),
            'tooltip'=>__("Task name. More Details as tooltips"),
            'width'=>'30%',
            'sort'=>0,
            'format'=>'<a href="index.php?go=projView&amp;prj={?id}">{?name}</a>'
        )));*/


        #---- functions ------------------------
        global $PH;

        ### functions ###
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('taskEdit')->id,
            'name'  =>__('Edit'),
            'id'    =>'taskEdit',
            'icon'  =>'edit',
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('itemsAsBookmark')->id,
            'name'  =>__('Mark as bookmark'),
            'id'    =>'itemsAsBookmark',
            'context_menu'=>'submit',
        )));


        $this->query_options['category']=    TCATEGORY_VERSION;
        #$this->query_options['is_released_min']= RELEASED_UPCOMMING;
        $this->query_options['status_min']= 0;
        $this->query_options['status_max']= 200;
        $this->query_options['order_by']= 'created DESC';
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
        require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

        global $PH;

        if(!$this->active_block_function=$this->getBlockStyleFromCookie()) {
            $this->active_block_function = 'list';
        }


        $this->initOrderQueryOption();

        ### grouped view ###
        if($this->active_block_function == 'grouped') {
            $this->group_by= get("blockstyle_{$PH->cur_page->id}_{$this->id}_grouping");

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

        $versions= Task::getAll($this->query_options);

        $this->render_list(&$versions);
    }
}



class ListBlockCol_VersionName extends ListBlockCol
{
    public $key='name';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->width='90%';
        $this->name=__('Released Milestone');
        $this->id='name';
    }

    function render_tr(&$task, $style="")
    {

        global $PH;
        global $g_resolve_reason_names;
        if(!isset($task) || !is_object($task)) {
            trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
            return;
        }
        $buffer='';

        ### collapsed view ###
        $html_link= '<b>'. $task->getLink(false, false) .'</b>';
        if($task->view_collapsed) {
            $buffer.= $PH->getLink('taskToggleViewCollapsed',"<img src=\"". getThemeFile("img/toggle_folder_closed.gif") ."\">",array('tsk'=>$task->id),NULL, true)
                    . $html_link;
        }
        ### detailed view with change log ###
        else {
            $buffer.= $PH->getLink('taskToggleViewCollapsed',"<img src=\"".getThemeFile("img/toggle_folder_open.gif") ."\">",array('tsk'=>$task->id),NULL, true)
            . $html_link
            . '<br>';

            $editable= false;
            if(Task::getEditableById($task->id)) {
                $editable= true;
            }
                

            $buffer.= "<div class=description>";
            $buffer.=  wikifieldAsHtml($task, 'description');
            $buffer.= "</div>";




        }
        echo '<td>'. $buffer .'</td>';
    }
}


class ListBlockCol_TimeReleased extends ListBlockCol
{
    public $key='time_released';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->width='15%';
        $this->name=__('Release Date');
        $this->id='time_released';
    }

    function render_tr(&$task, $style="")
    {

        global $PH;
        if(!isset($task) || !is_object($task)) {
            trigger_error("ListBlock->render_tr() called without valid object", E_USER_WARNING);
            return;
        }


        $buffer = renderDateHtml($task->time_released);

        #if($html_due && $task->status < STATUS_CLOSED) {
        #    $buffer.= '<br><span class=sub>('. $html_due .')</span>';
        #}

        #if($this->parent_block->sum_estimated_max) {
        #    $buffer.= '<br><span class=sub>'
        #           .  sprintf(__('%s required'), renderEstimatedDuration(($this->parent_block->sum_estimated_max + $this->parent_block->sum_estimated_min) /2))
        #           .  '</span>';
        #}

        echo '<td class=nowrap>'. $buffer .'</td>';
    }
}



?>