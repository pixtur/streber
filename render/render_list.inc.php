<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * classes related to rendering lists
 *
 * included by: @render_page
 *
 * @author     Thomas Mann
 */

/**
* @defgroup render_lists Render Lists
*
* Because most information in streber is display as lists, this is a major task for rendering.
*/

require_once(confGet('DIR_STREBER') . "render/render_block.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list_column.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list_column_special.inc.php");
require_once(confGet('DIR_STREBER') . "std/export.inc.php");


abstract class FilterSetting extends BaseObject
{
    public $id;
    public $name;
    public $filters= NULL;

    public function getFilters()
    {
        return $this->filters;
    }

    public function initFilters($filters)
    {

    }
}




/**
*
*/
class FilterSetting_tasks extends FilterSetting
{
    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $tmp_filters= array(
            new ListFilter_for_milestone(),
            new ListFilter_project(),
            new ListFilter_status(),
        );

        foreach($tmp_filters as $f) {
            $this->filters[$f->id] = $f;
        }
    }


    public function set_preset($preset)
    {
        if($preset->valid_for_setting != $this->id) {
            trigger_warning("can't use setting $preset->name for FilterSetting $id", E_USER_NOTICE);
            return NULL;
        }



        foreach($preset->active_filters as $f) {

        }

    }
}

class FilterPreset_Setting extends BaseObject
{
    public $name;
    public $valid_for_setting;
    public $id;

    public $active_filters  =array();
    public $filter_values   = array();




}




abstract class ListFilter extends BaseObject
{
    public $id;                         # id inside html-structure (for icons and referrer attributes)
    public $locked=false;               # if true, can't be removed
    public $hidden=false;               # if true not visible
    public $default = NULL;
    public $value=NULL;
    public $active  = true;
    public $sql_querry_attribute = NULL;# if NULL, 'id' is used   NOTE: used for functions like Task::getTasks($querry_attributes)
    public $render_string= NULL;        # e.g. "for milestone %s". Does not have to be set, if render() is overwritten


    public function __construct($args)
    {
        parent::__construct($args);
        $this->initValue($this->value);
    }


    /**
    * init value in this order:
    * 1. if GET/POST paramter
    * 2. if passed argument (if not NULL)
    * 3. with default-value
    */
    public function initValue($value= NULL)
    {
        if($v= get($this->id)) {
            $this->value = $v;
        }
        else if(is_null($this->value)) {
            $this->value = $this->default;
        }
        return $this->value;
    }


    public function getQuerryAttributes()
    {
        $a=array();
        if($this->active) {
            $name= $this->sql_querry_attribute
                 ? $this->sql_querry_attribute
                 : $this->id;
            $a[$name]= $this->value;
        }
        return $a;
    }



    /**
    * Note: default rendering only works well for numerical stuff like milestones.
    * Filters like status or assigned to, normally have to be overwritten in derived
    * classes
    */
    public function render()
    {
        if($this->active && !$this->hidden) {
            if($this->render_string) {
                return sprintf($this->render_string, $this->value);
            }
            return $for_milestone;
        }
        else {
            return '';
        }
    }
}


class ListFilter_changes extends ListFilter
{
    public $id = 'changes';
    public $sql_querry_attribute = 'visible_only';
    public $default = true;

    public function __construct($args=NULL)
    {
        parent::__construct($args);
    }
}

class ListFilter_efforts extends ListFilter
{
    public $id = 'efforts';
    public $sql_querry_attribute = 'visible_only';
    public $default = true;

    public function __construct($args=NULL)
    {
        parent::__construct($args);
    }
}

class ListFilter_projects extends ListFilter
{
    public $id = 'projects';
    public $sql_querry_attribute = 'visible_only';
    public $default = true;

    public function __construct($args=NULL)
    {
        parent::__construct($args);
    }
}

class ListFilter_tasks extends ListFilter
{
    public $id = 'tasks';
    public $sql_querry_attribute = 'visible_only';
    public $default = true;

    public function __construct($args=NULL)
    {
        parent::__construct($args);
    }
}

class ListFilter_persons extends ListFilter
{
    public $id = 'persons';
    public $sql_querry_attribute = 'visible_only';
    public $default = true;

    public function __construct($args=NULL)
    {
        parent::__construct($args);
    }
}

class ListFilter_companies extends ListFilter
{
    public $id = 'company';
	public $sql_querry_attribute = 'visible_only';
    public $default = true;

    public function __construct($args=NULL)
    {
        parent::__construct($args);
    }
}

class ListFilter_for_milestone extends ListFilter
{
    public $id          = 'for_milestone';
    public $default     = NULL;
    public $milestone   = NULL;                             # object-ref if visible


    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->render_string= __('for milestone %s');       # to be translated strings have to be set inside a function
    }


    public function initValue($value= NULL)
    {
        parent::initValue($value);

        /**
        * check for visibility
        */
        if($ms= Task::getVisibleById($this->value)) {
            if($ms->category == TCATEGORY_MILESTONE) {
                $this->milestone= $ms;
            }
            else {
                $this->value= NULL;
            }
        }
        else if($this->value === 0 || $this->value === "0")  {
            $this->value =0;
        }
        else {
            $this->value =NULL;
        }
        return $this->value;
    }

}


class ListFilter_status_min extends ListFilter
{
    public $id          = 'status_min';
    public $default     = STATUS_NEW;

    public function render()
    {
        global $g_status_names;

        if($this->active && !$this->hidden) {

            $min=   isset($g_status_names[$this->value])
                        ? $g_status_names[$this->value]
                        : '';

            return $min;
        }
        return '';
    }
}


class ListFilter_status_max extends ListFilter
{
    public $id          = 'status_max';
    public $default     = STATUS_COMPLETED;

    public function render()
    {
        global $g_status_names;

        if($this->active && !$this->hidden) {

            $max=   isset($g_status_names[$this->value])
                        ? $g_status_names[$this->value]
                        : '';

            return $max;
        }
        return '';
    }
}

class ListFilter_effort_status_min extends ListFilter
{
    public $id          = 'effort_status_min';
    public $default     = EFFORT_STATUS_NEW;

    public function render()
    {
        global $g_effort_status_names;

        if($this->active && !$this->hidden) {

            $min=   isset($g_effort_status_names[$this->value])
                        ? $g_effort_status_names[$this->value]
                        : '';

            return $min;
        }
        return '';
    }
}


class ListFilter_effort_status_max extends ListFilter
{
    public $id          = 'effort_status_max';
    public $default     = EFFORT_STATUS_BALANCED;

    public function render()
    {
        global $g_effort_status_names;

        if($this->active && !$this->hidden) {

            $max=   isset($g_effort_status_names[$this->value])
                        ? $g_effort_status_names[$this->value]
                        : '';

            return $max;
        }
        return '';
    }
}

class ListFilter_assigned_to extends ListFilter
{
    public $id          = 'assigned_to_person';

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        global $auth;
        $this->default = $auth->cur_user->id;
    }
}

class ListFilter_last_logout extends ListFilter
{
    public $id = 'last_logout';
    public $sql_querry_attribute = 'date_min';
    public $logout_date = NULL;

    public function initValue($value= NULL)
    {
        parent::initValue($value);

        /**
        * get logout date and reset the value variable
        */
        if($person = Person::getVisibleById($this->value)) {
            if($person->last_logout) {
                $this->logout_date = $person->last_logout;
            }
            else {
                $this->value= NULL;
            }
        }
        else {
            $this->value =NULL;
        }
        return $this->value;
    }

    public function getQuerryAttributes()
    {
        $a = array();
        if($this->active) {
            $name= $this->sql_querry_attribute
                 ? $this->sql_querry_attribute
                 : $this->id;
            $a[$name]= $this->logout_date;
        }
        return $a;
    }
}

class ListFilter_today extends ListFilter
{
    public $id = 'today';
    public $today = NULL;

    public function initValue($value= NULL)
    {
        parent::initValue($value);

        /**
        * get logout date and reset the value variable
        */
        if(!$this->today) {
            $date = date('Y-m-d', time());
            $dt = $date . " 00:00:01";
            $this->today = $dt;
        }

        return $this->value;
    }

    public function getQuerryAttributes()
    {
        $a = array();
        if($this->active) {
            $name= $this->sql_querry_attribute
                 ? $this->sql_querry_attribute
                 : $this->id;
            $a[$name]= $this->today;
        }
        return $a;
    }

}

class ListFilter_min_week extends ListFilter
{
    public $id = 'date_min';
    public $min_date = NULL;
    public $factor = 7;

    public function initValue($value= NULL)
    {
        parent::initValue($value);

        /**
        * get logout date and reset the value variable
        */
        if(!$this->min_date) {
            $date = date('Y-m-d', (time()-($this->factor*24*60*60)));
            $time = getGMTString();
            #$dt = $date . " " . renderTime($time);
            $dt = $date . " 00:00:01";
            $this->min_date = $dt;
        }

        return $this->value;
    }

    public function getQuerryAttributes()
    {
        $a = array();
        if($this->active) {
            $name= $this->sql_querry_attribute
                 ? $this->sql_querry_attribute
                 : $this->id;
            $a[$name]= $this->min_date;
        }
        return $a;
    }

}

class ListFilter_max_week extends ListFilter
{
    public $id = 'date_max';
    public $max_date = NULL;
	public $factor = NULL;
    public function initValue($value= NULL)
    {
        parent::initValue($value);

        /**
        * get logout date and reset the value variable
        */
        if(!$this->max_date) {
            $date = gmdate("Y-m-d", (time()-($this->factor*24*60*60)));
            $time = getGMTString();
            #$dt = $date . " " . renderTime($time);
            $dt = $date . " 23:59:59";
            $this->max_date = $dt;
        }
        return $this->value;
    }

    public function getQuerryAttributes()
    {
        $a = array();
        if($this->active) {
            $name= $this->sql_querry_attribute
                 ? $this->sql_querry_attribute
                 : $this->id;
            $a[$name]= $this->max_date;
        }
        return $a;
    }
}

class ListFilter_category extends ListFilter
{
    public $id          = 'category';
    public function __construct($args=NULL)
    {
        parent::__construct($args);
        global $auth;
        $this->default = 0;
    }
}

class ListFilter_category_in extends ListFilter
{
    public $id          = 'category_in';
    public function __construct($args=NULL)
    {
        parent::__construct($args);
        global $auth;
        $this->default = array(0);
    }
}

class ListFilter_not_older extends ListFilter
{
    public $id          = 'not_older';
    public $sql_querry_attribute = 'date_min';


    public function getQuerryAttributes()
    {
        $a=array();
        if($this->active) {
            if($this->value) {
                $a['date_min'] = getGMTString( (time() - $this->value));
            }
        }
        return $a;
    }


    public function render()
    {

        if($this->active && !$this->hidden) {
            if($this->value / 60/60/24 < 1) {
                return __('changed today');
            }
            else if($this->value / 60/60/24 < 2){
                return __('changed since yesterday');
            }
            else if($this->value / 60/60/24 < 14){
                return sprintf(__('changed since <b>%d days</b>'), $this->value / 60/60/24);
            }
            else {
                return sprintf(__('changed since <b>%d weeks</b>'), $this->value / 60/60/24/7);
            }
        }
        return '';
    }
}



class ListFilter_modified_by extends ListFilter
{
    public $id          = 'modified_by';

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        global $auth;
        $this->default = $auth->cur_user->id;
    }
}



class ListFilter_not_modified_by extends ListFilter
{
    public $id          = 'not_modified_by';

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        global $auth;
        $this->default = $auth->cur_user->id;
    }
}

class ListFilter_person_category_min extends ListFilter
{
    public $id          = 'pcategory_min';
    public $default     = PCATEGORY_UNDEFINED;

    public function render()
    {
        global $g_pcategory_names;

        if($this->active && !$this->hidden) {

            $min=   isset($g_pcategory_names[$this->value])
                        ? $g_pcategory_names[$this->value]
                        : '';

            return $min;
        }
        return '';
    }
}


class ListFilter_person_category_max extends ListFilter
{
    public $id          = 'pcategory_max';
    public $default     = PCATEGORY_PARTNER;

    public function render()
    {
        global $g_pcategory_names;

        if($this->active && !$this->hidden) {

            $max=   isset($g_pcategory_names[$this->value])
                        ? $g_pcategory_names[$this->value]
                        : '';

            return $max;
        }
        return '';
    }
}

class ListFilter_can_login extends ListFilter
{
    public $id = 'can_login';

    public function getQuerryAttributes()
    {
        $a = array();
        if($this->active) {
            $name= $this->sql_querry_attribute
                 ? $this->sql_querry_attribute
                 : $this->id;
			if(!is_null($this->value)){
            	$a['can_login']= $this->value;
			}
        }
        return $a;
    }
}

class ListFilter_is_alive extends ListFilter
{
    public $id = 'is_alive';

    public function getQuerryAttributes()
    {
        $a = array();
        if($this->active) {
            $name= $this->sql_querry_attribute
                 ? $this->sql_querry_attribute
                 : $this->id;
			if(!is_null($this->value)){
            	$a['is_alive']= $this->value;
			}
        }
        return $a;
    }
}

class ListFilter_company_category_min extends ListFilter
{
    public $id          = 'ccategory_min';
    public $default     = CCATEGORY_UNDEFINED;

    public function render()
    {
        global $g_ccategory_names;

        if($this->active && !$this->hidden) {

            $min=   isset($g_ccategory_names[$this->value])
                        ? $g_ccategory_names[$this->value]
                        : '';

            return $min;
        }
        return '';
    }
}


class ListFilter_company_category_max extends ListFilter
{
    public $id          = 'ccategory_max';
    public $default     = CCATEGORY_PARTNER;

    public function render()
    {
        global $g_ccategory_names;

        if($this->active && !$this->hidden) {

            $max=   isset($g_ccategory_names[$this->value])
                        ? $g_ccategory_names[$this->value]
                        : '';

            return $max;
        }
        return '';
    }
}

/**
* blockfunction for grouping lists
*
*
*/
class BlockFunction_grouping extends BlockFunction
{
    public $groupings;
    public $active_grouping_key;         # id of the active grouping (don't confuse with BlockFunctions active-flag)
    public $active_grouping_obj;

    public function __construct($args) {
        parent::__construct($args);
        #if(!$this->active) {
        #    $this->active= $this->getActiveFromCookie();
        #}
    }


    public function render()
    {
        $buffer="";
        if($this->active) {
            $buffer= "<span class=active><a href='$this->url'>" . asHtml($this->name) . "</a></span>";
            $buffer.= $this->renderGroupingSelection();
        }
        else {
            $buffer= "<span><a href='$this->url'>" . asHtml($this->name) . "</a></span>";
        }
        return $buffer;

    }

    /**
    * build dropdownmenu for selecting grouping
    * - with javascript to call misc/changeBlockGrouping() on change
    *
    * @@@TODO
    * - could check if group-function is active
    */
    public function renderGroupingSelection()
    {
        global $PH;
        if(!$this->groupings) {
            return;
        }
        $name_select= "style_grouping";
        $buffer = "\n\n\r<select name='style_grouping' onChange=\"javascript:window.location=(document.my_form.{$name_select}.options[document.my_form.{$name_select}.selectedIndex].value);\">";

        $this->getActiveFromCookie();

        foreach($this->groupings as $g) {
            $url= $PH->getUrl('changeBlockGrouping',array(
                'block_id'  => $this->parent_block->id,
                'page_id'   => $PH->cur_page->id,
                'grouping'  => $g->id,
            ));

            if($g->id == $this->active_grouping_key) {
                $selected= 'selected';
            }
            else {
                $selected= '';
            }


            $buffer.="\n<option $selected value='$url'>$g->name</option>";
        }
        $buffer.="\n</select>";

        return $buffer;
    }



    /**
    * get the current block-style from cookie
    */
    function getActiveFromCookie()
    {
        global $PH;
        if(!$this->parent_block) {
            trigger_error("getActiveFromCookie requires parent_block to be set", E_USER_WARNING);
        }

        /**
        * get from cookie?
        */
        if($key= get("blockstyle_{$PH->cur_page->id}_{$this->parent_block->id}_grouping")) {
            $this->active_grouping_key = $key;
            $obj=NULL;
            foreach($this->groupings as $g) {
                if($g->id == $key) {
                    $obj= $g;
                    break;
                }
            }
            $this->active_grouping_obj = $obj;
            return $key;
        }

        /**
        * return first grouping as default-setting...
        */
        else {
            if($this->groupings) {
                $this->active_grouping_key= $this->groupings[0]->id;
                $this->active_grouping_obj= $this->groupings[0];
                return $this->active_grouping_key;
            }
            else {
                return NULL;
            }
        }
    }
}




/**
* grouping for BlockFunction_grouping
*/
class ListGrouping extends BaseObject
{
    public $name;                       # name/Tootip
    public $id;                         # id inside html-struction (for icons)
    public $key;
    public $sql_filter;                 # string which ()
    public $locked=false;               # if true, can't be removed
    public $hidden=false;               # if true no visible
    public $order_key;

    public function __construct($args) {
        parent::__construct($args);
        if(!$this->id) {
            trigger_error("ListGroupings requires id", E_USER_WARNING);
            return;
        }

        /**
        * NOTE: automatical init of name is not good, because
        * it can't be internationalized
        */
        if(!$this->name) {
            $this->name = $this->id;
        }
        if(!$this->key) {
            $this->key= $this->id;
        }
        if(!$this->order_key) {
            $this->order_key= $this->id;
        }
    }

    /**
    * render separating row
    */
    public function render(&$item)
    {
        $k= $this->key;
        if(isset($item->$k)) {
            return $item->$k;
        }
        else {
            trigger_error("grouping for what?",E_USER_NOTICE);
            return "---";
        }
    }
}




class ListGroupingStatus extends ListGrouping
{

    public function __construct($args=NULL) {
        $this->id = 'status';
        parent::__construct($args);
    }

    /**
    * render separating row
    */
    public function render(&$item)
    {
        if(isset($item->status)) {
            global $g_status_names;
            return $g_status_names[$item->status];
        }
        else {
            trigger_error("can't group for status",E_USER_NOTICE);
            return "---";
        }
    }
}

class ListGroupingEffortStatus extends ListGrouping
{

    public function __construct($args=NULL) {
        $this->id = 'status';
        parent::__construct($args);
    }

    /**
    * render separating row
    */
    public function render(&$item)
    {
        if(isset($item->status)) {
            global $g_effort_status_names;
            return $g_effort_status_names[$item->status];
        }
        else {
            trigger_error("can't group for status",E_USER_NOTICE);
            return "---";
        }
    }
}




class ListGroupingPrio extends ListGrouping
{

    public function __construct($args=NULL) {
        $this->id = 'prio';
        parent::__construct($args);
    }

    /**
    * render separating row
    */
    public function render(&$item)
    {
        if(isset($item->prio)) {
            global $g_prio_names;
            return "<img src=\"". getThemeFile("img/prio_{$item->prio}.png") . "\">&nbsp;"
                  .$g_prio_names[$item->prio];
        }
        else {
            trigger_error("can't group for prio",E_USER_NOTICE);
            return "---";
        }
    }
}


class ListGroupingCreatedBy extends ListGrouping
{

    public function __construct($args=NULL) {
        $this->id = 'created_by';
        parent::__construct($args);
    }

    /**
    * render separating row
    */
    public function render(&$item)
    {
        require_once(confGet('DIR_STREBER') . "db/class_person.inc.php");
        if($person= Person::getVisibleById($item->created_by)) {
            $name= sprintf(__("created by %s"), $person->getLink());
        }
        else {
            $name=__("created by unknown");
        }
        return $name;
    }
}

class ListGroupingProject extends ListGrouping
{

    public function __construct($args=NULL) {
        $this->id       = 'project';    # used get set cookie and hide columns
        $this->order_key = 'i.project';  # used to construct sql order string
        parent::__construct($args);
    }

    /**
    * render separating row
    */
    public function render(&$item)
    {
        require_once(confGet('DIR_STREBER') . "db/class_project.inc.php");
        if($project= Project::getVisibleById($item->project)) {
            $name= sprintf($project->getLink());
        }
        else {
            $name= "???";
        }
        return $name;
    }
}


class ListGroupingTask extends ListGrouping
{

    public function __construct($args=NULL) {
        $this->id = 'task';
        parent::__construct($args);
    }

    /**
    * render separating row
    */
    public function render(&$item)
    {
        require_once(confGet('DIR_STREBER') . "db/class_task.inc.php");
        if($task = Task::getVisibleById($item->task)){
            $name = $task->name;
        }
        else{
            $name=__("unknown");
        }
        return $name;
    }
}


class ListGroupingModifiedBy extends ListGrouping
{

    public function __construct($args=NULL) {
        $this->id = 'modified_by';
        parent::__construct($args);
    }

    /**
    * render separating row
    */
    public function render(&$item)
    {
        require_once(confGet('DIR_STREBER') . "db/class_person.inc.php");
        if($person= Person::getVisibleById($item->modified_by)) {
            $name= sprintf(__("modified by %s"), $person->getLink());
        }
        else {
            $name=__("modified by unknown");
        }
        return $name;
    }
}


class ListGroupingItemType extends ListGrouping
{

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

        if(!$typename= $g_item_type_names[$item->type]) {
            trigger_error(sprintf(__("item #%s has undefined type"), $item->id),E_USER_NOTICE);
            $typename="?";
        }

        return $typename;
    }
}



/**
* list-functions provide ways of manipulating entries of a list (like add/edit/delete).
* They are rendered as icons, drop-downmenu or context-menu.
*
* how they work:
* - List-Function submit the current page (yes, the complete page has only ONE form).
* before this they write the target-value into the go-field (which is always rendered
* by PageContentClose(). This makes passing of addition parameters to the parameters really tricky.
*
* One solution for this problem would be to collect all params used by added functions and
* append hidden-fields at the of of the page (writing them after each list would not work
* because more then one list might use the same param). Then those parqmeters have to be written
* with jave-script.
*
* This definately has to be done for cascade context-menus.
*
* Currently ListFunction only work for pageHandles without additional parameters.
* Sooner or later addition functions or flags should be implemented (like creating
* new tasks with an issue_report and setting status to a certain value
*
* @usedby   ListBlock
*/
class ListFunction {
    public $target;                     # link-target
    public $active_for_single=true;
    public $active_for_multiple=true;
    public $active_always=false;        #
    public $name;                       # name/Tootip
    public $id;                         # id inside html-struction (for icons)
    public $icon;                       # name of function icon
    public $label;                      # label instead of icon
    public $parent_block;
    public $tooltip;
    public $context_menu=false;         # show in context-menus
    public $dropdown_menu=true;         # show in dropdown



    public function __construct($args=NULL)
    {
        foreach($args as $key=>$value) {
            is_null($this->$key);   # cause E_NOTICE if member not defined
            $this->$key=$value;
        }
        if(!$this->target || !$this->id || !$this->name) {
            trigger_error("ListFunctions require name,id, and target",E_USER_ERROR);
        }

        ### add to dropdown-menu ? ###
        #if(!$this->icon) {
        #    $this->dropdown_menu=true;
        #}
    }

    public function __set($name,$value)
    {
        if($this->$name) {
            $this->$name= $value;
        }
        else {
            trigger_error("setting undefined attribute '$name' of list function  to '$value'",E_USER_WARNING);
            $this->$name= $value;
        }
    }
}

/**
* provide front-end for rendering and manimpulating lists
*
* usage: <pre>
*
    $list= new ListBloc('example');                 #create instances
    $list->title="Open tasks";                      #set title
    $list_tasks->add_col( new ListBlockCol(array(   #add columns
        'key'=>'_select_col_',
    )));

    $list_tasks->add_function(new ListFunction(array( #add functions
        'target'=>$PH->getPage('taskEdit')->id,
        'name'  =>'Edit',
        'id'    =>'taskEdit',
        'icon'  =>'edit',
        'context_menu'=>'submit',
    )));

    $list_tasks->render();                          # render default output (simple) or...

    ### complex rendering to calculate summary and make custom-style-assigments
    $list->render_header();
    $list->render_thead();

    $count_estimated=0;
    foreach($tasks as $t) {
        $count_estimated+=$t->estimated;
        $list_tasks->render_trow(&$t,$style);
    }
    $list->summary= count($tasks)." tasks with estimated $count_estimated hours of work";
    $list->render_tfoot();

* @uses     ListFunction
* @usedby   most pages
*/
class ListBlock extends PageBlock
{
    public $columns         = array();
    public $functions       = array();
    public $query_options   = array();      # options passed to database-query functions (filtering, sorting, etc)

    public $row_count       = 0;
    public $show_functions  = false;        # is set true, when adding functions without icon
    public $show_pages      = false;
    public $show_items      = false;
    public $show_icons      = false;
    public $show_footer     = true;
    public $show_summary    = true;
    public $summary;
    public $footer_links    = array();      # additional http-fragments in footer (e.g. export links)
    public $no_items_html   = '';           # should be overwritten by 'create first link'
    public $groupings;                      # list of BlockFunction_grouping
    public $active_grouping_key;            #
    public $group_by        = 'status';
    public $class;

    //=== constructor ================================================
    function __construct($args=NULL)
    {
        parent::__construct($args);


    }
    
    public function render_header()
    {
        $str_selectable= isset($this->columns['_select_col_'])
                        ? 'selectable'
                        : '';

        parent::render_blockStart();
        #--- start table (needs to be closed later)
        echo "<div class=table_container><table cellpadding=0 cellspacing=0 id=$this->id class='list $this->class $str_selectable'"
        .">"; # required by Safari  & IE 5.2 MAC)

    }

    function render_thead() {
        echo "<thead>";
        echo "<tr>";
    
        foreach($this->columns as $c) {
            $c->render_th();
        }
        echo "</tr>";
        echo "</thead>\n";
    }


    function render_trow($obj, $style='')
    {
        global $auth;

        $this->row_count++;
        $oddeven =($this->row_count %2)
                 ? "odd"
                 : "even";

        $style.= " ".$oddeven;

        if(isset($obj->pub_level)) {
            $level=$obj->pub_level;
            global $g_pub_level_names;
            $style.=" pub_".$g_pub_level_names[$level];
        }


        if(isset($this->id) && isset($obj->id)) {
            if( $obj->isChangedForUser() ) {
                echo "<tr class='$style changed'>";
            }
            else {
                echo "<tr class='$style'>";
            }
        }
        else {
            echo "<tr class='$style'>";
        }

        foreach($this->columns as $c) {
            $c->render_tr($obj);
        }
        echo "</tr>\n";
    }


    function render_tfoot()
    {
        global $PH;
        echo "</table></div>";
        #--- footer extras ----

        $context_menu_def="";
        $context_menu_rows="";

        if($this->show_footer && ($this->show_pages || $this->show_functions || $this->show_icons)) {
            echo "<div class=footer>";

            #--- icons --------
            if($this->show_icons && $this->functions) {
                echo "<span class=icons>";
                foreach($this->functions as $f) {
                    if($f->icon) {

                        $tooltip=$f->tooltip
                            ? "title='" . asHtml($f->tooltip) . "'"
                            : "title='" . asHtml($f->name)    . "'";
                        echo "<a $tooltip href=\"javascript:document.my_form.go.value='$f->target';document.my_form.submit();\"><img src='". getThemeFile('icons/' . $f->icon . ".gif") . "'></a>";
                    }
                    else{
                        echo "&nbsp;";
                    }
                }
                echo "</span>";
            }

            #--- text-labels --------
            if(!$this->show_icons && $this->functions) {
                echo "<span class=list_functions>";
                foreach($this->functions as $f) {
                    if($f->label) {

                        $tooltip=$f->tooltip
                            ? "title='" . asHtml($f->tooltip) . "'"
                            : "title='" . asHtml($f->name)    . "'";
                        echo "<a $tooltip href=\"javascript:document.my_form.go.value='$f->target';document.my_form.submit();\">" . asHtml($f->label) . "</a>";
                    }
                }
                echo "</span>";
            }

            #--- menu ------------------
            if($this->show_functions && $this->functions && $this->show_icons) {
                $name_select= "select_". $this->id;
                $flag_visible= false;                       # only show if contains at least one function

                $buffer="";

                $buffer.= "<span class=functions>";
                $buffer.= "";
                $buffer.= "<select class=menu name='$name_select' size=1 onChange=\"javascript:document.my_form.go.value=document.my_form.$name_select.options[document.my_form.$name_select.selectedIndex].value;document.my_form.submit();\">";
                $buffer.= "<option value='home' selected>" . __("do...") . "</option>";
                foreach($this->functions as $f) {
                    if(!$f->icon) {
                        $buffer.= "<option value='$f->target'>$f->name</option>";
                        $flag_visible= true;
                    }
                }
                $buffer.= "</select>";
                $buffer.= "</span>";
                if($flag_visible) {
                    echo $buffer;
                }
            }

            #--- footerlinks -----------
            if($this->footer_links) {
                echo "<span class='links'>";
                foreach($this->footer_links as $fl) {
                    echo $fl;
                }
                echo "</span>";
            }

            #--- summary --------------------
            echo "<span class=summary>&nbsp;$this->summary</span>\n";

            #if($this->show_pages) {
            #    echo "<span class=items>20 of 234&nbsp;&nbsp;&nbsp;</span>";
            #    echo "<span class=pages>  Page 1 2 3 4</span>";
            #}
            echo "</div> <!-- end list footer-->";
        }

        #--- context menu ------------
        {

            foreach($this->functions as $f) {
                if($f->context_menu) {
                    $context_menu_def.="{type:'submit', name:'$f->name',   go:'$f->target'},\n";
                    $context_menu_rows.="<tr><td class=menuItem>$f->name</td></tr>\n";
                }
            }
        }

        parent::render_blockEnd();

        #--- write context-menu-definition -------------
        if($context_menu_def) {

            echo "<script  type='text/javascript'>
                    cMenu.menus['$this->id']=
                    {   menuID:'contextMenu_{$this->id}',
                        items:[
                        $context_menu_def
                    ] };</script>";

            echo "\n<div id='contextMenu_{$this->id}' class='contextMenus' onclick='hideContextMenus( )'"
                ." onmouseup='execMenu(event)' onmouseover='toggleHighlight(event)'"
                ." onmouseout='toggleHighlight(event)' style='display:none'>"
                ."<table><tbody>"
                .$context_menu_rows
                ."</tbody></table>"
                ."</div> <!-- end context-menu-->";
        }
    }


    /**
    * if no items to show, display alternative content
    */
    public function render_tfoot_empty() {
        echo "</table></div><div class=empty>{$this->no_items_html}"
            ."</div>"
            ."</div>";
    }


    /**
    * render complete list-block automatically
    *
    * @@@this should RETURN as string not PRINT one
    */
    public function render_list( &$list=NULL )
    {
        switch($this->page->format){
            case FORMAT_CSV:
                $this->renderListCsv($list);
                break;
            default:
                $this->renderListHtml($list);
                break;
        }
    }

    /*
    *format=csv*
    */
    function renderListCsv( $list=NULL )
    {
        if(!count($list)){
            return;
        }

        ## header ##
        $ids = array();
        $count = 0;
        foreach($list[0]->fields as $field_name => $field){
            if($field->export) {
                switch($field->type){
                    case 'FieldString':
                    case 'FieldInt':
                    case 'FieldDatetime':
                    case 'FieldText':

                        $ids[] = $field_name;
                        $count++;
                        break;

                    case 'FieldInternal':
                        if ($field_name == 'task') {
                            $ids[] = 'task_id';
                            $ids[] = 'task_name';
                        }
                        else if ($field_name == 'person') {
                            $ids[] = 'person_id';
                            $ids[] = 'person_name';
                        }
                        else if ($field_name == 'project') {
                            $ids[] = 'project_id';
                            $ids[] = 'project_name';
                        }
                        else {
                            $ids[] = $field_name;
                        }
                        break;

                    default:
                        break;
                }
            }
        }

        ## list ##
        $values = array();
        foreach($list as $row){
            foreach($list[0]->fields as $field_name => $field){
                if($field->export) {
                    switch($field->type){
                        case 'FieldText':
                        case 'FieldString':
                            $values[] = $this->cleanForCSV($row->$field_name);
                            break;
                        
                        case 'FieldInternal':
                            if ($field_name == 'task') {
                                $values[] = $row->$field_name;
                                if($task = Task::getVisibleById($row->$field_name)) {
                                    $values[] = $this->cleanForCSV($task->name);
                                }
                                else {
                                    $values[] = '';
                                }
                            }
                            else if ($field_name == 'person') {
                                $values[] = $row->$field_name;
                                if($person = Person::getVisibleById($row->$field_name)) {
                                    $values[] = $this->cleanForCSV($person->name);
                                }
                                else {
                                    $values[] = '-';
                                }
                            }
                            else if ($field_name == 'project') {
                                $values[] = $row->$field_name;
                                if($project = Project::getVisibleById($row->$field_name)) {
                                    $values[] = $this->cleanForCSV($project->name);
                                }
                                else {
                                    $values[] = '';
                                }
                            }
                            else {
                                $values[] = $row->$field_name;
                            }

                        
                            break;

                        case 'FieldInt':
                        case 'FieldDatetime':
                            #$values[] = addslashes($row->$field_name,"\0..\37");
                            $values[] = $row->$field_name;
                            break;

                        default:
                            break;
                    }
                }
            }
        }

        ## export function ##

        exportToCSV($ids, $values);
    }


    private function cleanForCSV($value) {
        if(!is_string($value)) {
            return $value;
        }
        
        $value2 = preg_replace(array("/\n/si","/\r/si","/\t/si",'/"/',"/`/"),array("\n","","\t",'',""), $value);
        $value2 = str_replace(';', ',', $value2);
    
        if($value2 != $value) {
            $value2 = '"'. $value2 .'"';
        }
        return $value2;
    }



    /*
    *format=html*
    *render complete list-block automatically*
    */
    function renderListHtml(&$list=NULL)
    {
        $this->render_header();
        if($list || !$this->no_items_html) {
            $this->render_thead();
            
            if($list) {
                ### grouping ###
                if($this->groupings && $this->active_block_function == 'grouped' && $this->groupings->active_grouping_obj) {
                    $last_group= NULL;
                    $gr = $this->groupings->active_grouping_key;
					
                    foreach($list as $e) {
                        if($last_group != $e->$gr) {
                            echo '<tr class=group><td colspan='. count($this->columns) .'>'. $this->groupings->active_grouping_obj->render($e).'</td></tr>';
                            $last_group = $e->$gr;
                        }
                        $this->render_trow($e);
                    }
                }
                else {
                    foreach($list as $e) {
                        $this->render_trow($e);
                    }
                }
            }
            $this->render_tfoot();
        }
        else {
            $this->render_tfoot_empty();
        }
    }



    function add_col(ListBlockCol $col)
    {
        if(!$col || !($col instanceof ListBlockCol)) {
            trigger_error("add_col requires column-object", E_USER_WARNING);
        }
        $key = count($this->columns);
        if(isset($col->id)) {
            $key= $col->id;
        }
        else if($col->key) {
            $key= $col->key;
        }
        else if(isset($col->id)){
            $key= strtolower($col->id);
        }
        $this->columns[$key]=$col;
        $col->parent_block= $this;
    }


    /**
    * add a function to the list as icon, menu or context-menus
    */
    function add_function(ListFunction $fn)
    {
        global $PH;

        ### cancel, if not enough rights ###
        if(!$PH->getValidPageId($fn->target)) {

            /**
            * it's quiet common that the above statement returns NULL. Do not warn here
            */
            #trigger_error("invalid target $fn->target",E_USER_WARNING);
            return;
        }


        $key=count($this->functions);
        if(isset($fn->target)) {
            $key= $fn->target;
        }
        if(isset($fn->id)){
            $key= $fn->id;
        }

        ### be sure it's hidden in dropdown_menu ###
        if($fn->dropdown_menu == false && $fn->icon) {
            $fn->icon=NULL;
        }


        ### already defined? ###
        if(isset($this->functions[$key])) {
            echo "overwriting function with id '$key'";
        }
        $this->functions[$key]=$fn;
        $fn->parent_block= $this;
        if(!$fn->icon && $fn->dropdown_menu) {
            $this->show_functions=true;                     # enable dropdown menu
        }
        else {
            $this->show_icons=true;
        }
    }


    public function getOrderByFromCookie()
    {
        global $PH;
        $s_cookie= "sort_{$PH->cur_page->id}_{$this->id}_{$this->active_block_function}";
        if($sort= get($s_cookie)) {
            return $sort;
        }
        return;
    }

    /**
    * set the query_option for order with default value or from cookie
    */

    public function initOrderQueryOption($default=NULL)
    {
        if($order= $this->getOrderByFromCookie()) {
            $this->query_options['order_by']= $order;
        }
        else if($default) {
            $this->query_options['order_by']= $default;
        }
    }
}

?>
