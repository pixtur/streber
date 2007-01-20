<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php5 based project management system  (c) 2005 Thomas Mann / thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * classes for rendering list columns
 *
 * @author: Thomas Mann
 * @uses:
 * @usedby:list-definitions in pageFunctions
 *
 */



 /**
 * base-class for list columns is derived
 *
 */
class ListBlockCol
{
    public $width='1%';
    public $id;             # name of columne in list's column hash (normally extracted from key)
    public $key;            # key for sorting (probably obj attributes like name or c.name)
    public $sort;
    public $tooltip;
    public $parent_block;
    public $style='';
    public $name='';

	/**
	* constructor
	*/
	function __construct($name_or_arguments=NULL, $key="", $sort=0,$tooltip=false,$width=false)
	{
  		if($width) {
            $this->width=$width;
        }
		if(!$this->key) {
		    $this->key = $key;
		};
		$this->sort= $sort;
		if($tooltip) {
            $this->tooltip= $tooltip;
        }
        $this->functions=array();


		#--- either define as param-list or hash ----
		if(is_string($name_or_arguments)) {
			$this->name= $name_or_arguments;
		}
		else if (is_array($name_or_arguments)){
			foreach($name_or_arguments as $key=>$value) {
				$this->$key = $value;
			}
		}
		else {
			return;
		}
		if(NULL == $this->id) {
		    $this->id = $this->key;
		}
    }

	function render_th()
	{
		global $str;
        global $PH;
        global $auth;

		#--- width ---
		$width="";
		if($this->width) {
			$width= "width=\"$this->width\"";
		}

		#--- sorting ----
		/**
		* @@@pixtur 2006-11-12: sorting has to be implemented!
		*/
		$sort_style="";
		$sort_img="";
		if($this->sort != 0) {
			$sort_style="sort_primary";
			#$sort_img= "<img src=\"" . getThemeFile("img/list_sort_asc_1st.png") . "\">";

		}

		#--- tool tip-----
		$tooltip="";
		if(isset($this->tooltip) && $this->tooltip != "") {
			$tooltip="title='$this->tooltip'";
		}


		#--- text & link -----
		echo "<th $tooltip class=\"$sort_style\" $width>";
        if($this->key) {
            $link=$PH->getLink('changeSort',$this->name,array(
                'table_id'=>$this->parent_block->id,
                'column'=>$this->key,
                'page_id'=>$PH->cur_page->id,
                'list_style'=>$this->parent_block->active_block_function,
                ));
			#echo "$sort_img<a href=\"$target\">";
			#echo $this->name;
			#echo "</a>";
            echo $link;
        }
        else {
            echo $this->name;
        }
        echo "</th>";

	}

	function render_tr(&$obj, $style='') {
		#--- it's the checkbox -col ---
		if($this->key=="_select_col_"){
			echo "<td width=10 class=select_col onClick=\"stopEvent(event)\"><input  type=checkbox id={$this->parent_block->id}_{$obj->id}_chk name={$this->parent_block->id}_{$obj->id}_chk></td>";
		}
		#--- property of object undefined ?----
		else if(!isset($this->key)) {
			echo "<td>Undefined key</td>";

		}
		#--- normal output ---
		else {
			$style= (isset($this->style) && $this->style!="") ? "class=\"$->style\"" : "";
			echo "<td $style>";

			//--- try to get param ---
			$key= $this->key;
			if(!isset($obj->$key)) {
				print "$key";
			}
			$value= isset($obj->$key) ? $obj->$key : "??$key";

			if(isset($this->func)) {
				echo eval($this->func);
			}
			else {
				echo $value;
			}
			echo "</td>";
		}
	}
}








?>