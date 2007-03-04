<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * classes for rendering list columns
 *
 * @author Thomas Mann
 * @uses:
 * @usedby:list-definitions in pageFunctions
 *
 */



/***********************************************************
* derived versions of ListBlockCol for special purposes
*/





/*********
* test version of column-rendering using code-eval
*
* early try of custimized field-rendering in lists. This is prone to errors. For most
* purposes of customized rendering, we suggest ListBlockColFormat.
*
* @usedby: not used / obsolete
*/
class ListBlockColEval extends ListBlockCol{

	function render_tr(&$obj, $style='') {
		$style= (isset($this->style) && $this->style!="") ? "class=\"$->style\"" : "";
		echo "<td $style>";

		//--- try to get param ---
		$key= $this->key;
		$value= isset($obj->$key) ? $obj->$key : "??$key";

		if(isset($this->eval)) {
			$tmp="\$value=\"".$this->eval."\";";
			eval($tmp);
			echo $value;
		}
		else {
			echo "<a href=\"\">$value</a>";
		}
		echo "</td>";
	}
}


/**
* render list-columns as with html-formated template using {key} to output data
*
* This is the preferred method for displaying formatted output.
* example:<pre>
*
*  		$this->add_col( new ListBlockColFormat(array(
*			'key'=>'phone',
*			'name'=>"Phone",
*			'tooltip'=>"Phone-Number",
*			'format'=>'<nobr>{?phone}</nobr>'
*		)));
*        </pre>
*
* This function will NOT allow html-formatting of values, because this would cause
* security issues like XSS and code injection.
*
* @usedby:most listBlock defintions
*/
class ListBlockColFormat extends ListBlockCol
{
	function render_tr(&$obj, $style="") {
		if(!isset($obj) || !is_object($obj)) {
			trigger_error("ListBlock->render_tr() called without valid object",E_USER_WARNING);
   			return;
		}
		$key= $this->key;
		$format= $this->format;
		$rest=$this->format;
		$style= $this->style
		      ? "class='$this->style'"
		      : '';

		while(	ereg("\{\?([a-z_]*)\}(.*)",$rest, $matches) ) {
			$key=$matches[1];
	  		$rest=$matches[2];
			$value= isset($obj->$key) ? $obj->$key : "??$key";
			$format=ereg_replace("\{\?$key\}",asHtml($value),$format);
		}

		print "<td $style>". $format . '</td>';
	}
}



/**
* render list-columns by custum-method of object
*
* example:<pre>
*
*    	$this->add_col( new ListBlockColMethod(array(
*           'key'=>'company',
*    		'name'=>"Company",
*    		'tooltip'=>"Company",
*    		'func'=>'getCompanyLink',
*    	)));
*
*
* </pre>
*
* @usedby: most listBlock-defintions
*/
class ListBlockColMethod extends ListBlockCol
{
	function render_tr(&$obj, $style="") {
		if(!isset($obj) || !is_object($obj)) {
			trigger_error("ListBlock->render_tr() called without valid object",E_USER_WARNING);
   			return;
		}
        $out=call_user_func(array($obj,$this->func));
        if($this->style) {
    		print "<td class='$this->style'>$out</td>";
        }
        else {
    		print "<td>$out</td>";
        }
	}
}


/**
* render list-column as time in hours
*
*/
class ListBlockColTime extends ListBlockCol{
    public $style='right';

	function render_tr(&$obj, $style_overwrite="") {
		if(!isset($obj) || !is_object($obj)) {
			trigger_error("ListBlockColTime->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		$key= $this->key;
        $value=$obj->$key;
        $format='';
        if($value && $value!="00:00:00") {
            $format=$value;
            ereg("(..):(..):(..)",$value,$matches);
            list($all,$hh,$mm,$ss)=$matches;
            #$format="$hh:$mm";
            $hours=$hh*1+ ($mm/60);
            $format=round($hours,1)."<span class='entity'>h</span>";
        }
		print "<td class='$this->style $style_overwrite'>$format</td>";
	}
}


/**
* render list-column as external link (removing http:/ and reduced to sane lenght)
*/
class ListBlockColLinkExtern extends ListBlockCol
{
	function render_tr(&$obj, $style_overwrite="") {
		if(!isset($obj) || !is_object($obj)) {
			trigger_error("ListBlockLinkExtern->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		$key= $this->key;
        $value=$obj->$key;
        if($value) {

            $format= url2linkExtern(asHtml($value));
    		print "<td class='$this->style $style_overwrite'>". $format ."</td>";
        }
        else {
    		print "<td></td>";
        }
	}
}

/**
* render list-column as date with distance to today as tooltip
*/
class ListBlockColDate extends ListBlockCol
{
    public $key= 'modified';

    function __construct($args=NULL) {
        parent::__construct($args);
        if(!$this->name) {
            $this->name= __('Modified');
        }
    }

	function render_tr(&$obj, $style="") {
	    global $auth;

		if(!isset($obj) || !is_object($obj)) {
			trigger_error("ListBlockColDate->render_tr() called without valid object", E_USER_WARNING);
   			return;
		}
		$key= $this->key;

        $value_str=renderDateHtml($obj->$key);


		print "<td class='nowrap'>$value_str</td>";
	}
}





class ListBlockCol_OpenTasks extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__("Tasks","short column header");
        $this->tooltip=__("Number of open tasks is hilighted if shown home.");
        $this->style='narrow';
        $this->id='tasks';
    }
    function render_tr(&$project,$style='') {
        $num_tasks= $project->getNumTasks();
        #if($project->show_in_home) {
            echo "<td class='right'>$num_tasks</td>";
        #}
        #else {
        #    echo "<td class='right notShown' title='Tasks of this project are not shown in home'>($num_tasks)</td>";
        #}
    }
}


class ListBlockColPrio extends ListBlockCol{

    public $style='narrow';

    function render_tr(&$obj,$style="") { global $auth;
        global $g_prio_names;

		//--- try to get param ---
        if(!isset($obj->prio) || !intval($obj->prio)) {
            $out="?";
        }
        else {
            $tooltip= sprintf(__("Priority is %s"),$g_prio_names[$obj->prio]);
        	$out= "<img title='$tooltip' src='". getThemeFile("img/prio_{$obj->prio}.png"). "'>";
        }
        $class= $this->style
            ?"class='$this->style'"
            :'';
		echo "<td $class>";
		echo $out;
		echo "</td>";
	}
}

class ListBlockColStatus extends ListBlockCol{

    public $style='narrow';
    public $key='status';

    function __construct() {
        $this->name     =__('Status','Short status column header');
    }

	function render_tr(&$obj, $style="")
	{
        global $auth;
        global $g_status_names;

		//--- try to get param ---
   		$status= $obj->status;

        $class= $this->style
            ?"class='$this->style'"
            :'';

        #$tooltip=$g_status_names[$status];

		#echo "<td $class title='"
		#    . sprintf(__("Status is %s"), $tooltip)
		#    ."'>";
		#echo "<img src=\"" . getThemeFile("img/status_$status.png") ."\">";
		if($obj->status) {
    		$name= isset($g_status_names[$obj->status])
    		           ? $g_status_names[$obj->status]
    		           : "";
        }
        else {
            $name="";
        }

        $extra = '';
        if($obj->status <= STATUS_NEW) {
            $extra='new';
        }

        if($obj->status >= STATUS_COMPLETED) {
            $extra= 'done';
        }

        if($obj->status == STATUS_OPEN) {
            $extra= 'open';
        }

		echo "<td class='status $extra'>";
		echo "$name";
		echo "</td>";
	}
}


class ListBlockColPubLevel extends ListBlockCol{

    public $style='narrow';
    public $key='pub_level';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->tooltip=__("Item is published to");
        $this->name=__("Pub","column header for public level");
        $this->id='pub';
    }

	function render_tr(&$obj, $style="")
    {

        global $g_pub_level_names;
        global $g_pub_level_short_names;
		//--- try to get param ---
   		$pub_level= $obj->pub_level;

        $class= $this->style
            ?"class='$this->style'"
            :'';
        $str_level=$g_pub_level_short_names[$pub_level];
        $title= sprintf(__("Publish to %s"),$g_pub_level_names[$pub_level]);

		echo "<td $class title='$title'>";
		echo $str_level;
		echo "</td>";
	}
}


class ListBlockColSelect extends ListBlockCol{

    public $style='narrow';
    public $key='_select_col_';
    public $name="S";

    function render_th() {
		if($this->key=="_select_col_") {
		    $title= __("Select / Deselect");
			echo "<th class=select_col title='$title' style='width:1%'>";
            echo "<a href='#'>";

			echo "<img src=\"". getThemeFile("img/list_check_range.png") . "\">";
			echo "</a>";
			echo "</th>";
		}
    }

	function render_tr(&$obj, $style="")
    {
		echo
        "<td width=10 class=select_col>
        <input type=checkbox id={$this->parent_block->id}_{$obj->id}_chk name={$this->parent_block->id}_{$obj->id}_chk>
        </td>";
	}
}

class ListBlockCol_CreatedBy extends ListBlockCol
{
    public $name;
    public $id='createdby';
    public $key='created_by';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('Created by');
        $this->id='created_by';
    }

	function render_tr(&$obj, $style="nowrap") {
		if(!isset($obj) || !$obj instanceof DbProjectItem) {
   			return;
		}
        $value="";
        if($obj->created_by) {
            if($person= Person::getVisibleById($obj->created_by)) {
                $value=$person->getLink();
            }
        }
		print "<td class=nowrap>$value</td>";
	}
}





?>