<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * classes related to rendering blocks which can be collapsed
 *
 * included by: @render_page
 * @author     Thomas Mann
 */

require_once(confGet('DIR_STREBER') . "render/render_page.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list_column.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list_column_special.inc.php");



/**
* function for changing the currently displayed block (like switching between list and tree)
*
*/
class BlockFunction
{
    public $target;             # pageid without params
    public $params;             # pageid without params
    public $url;                # link-target (pageid including params)
    public $name;               # name
    public $icon;               # name of function icon
    public $parent_block;
    public $tooltip;
    public $context_menu=false; # show in context-menus
    public $key;                # used as id in assoc. array  'functions'
    public $active;             # flag if options should be highlighted as active
    public $default;			# flag if block's default-option (style)


    public function __construct($args=NULL)
    {
        foreach($args as $key=>$value) {
            is_null($this->$key);   # cause E_NOTICE if member not defined
            $this->$key=$value;
        }
        if(!$this->target) {
            trigger_error("PageFunctions require target.  ('params','name','icon' are optional)", E_USER_ERROR);
        }
    }

    public function __set($name,$value)
    {
        if($this->$name) {
            $this->$name= $value;
        }
        else {
            trigger_error("setting undefined attribute '$name' of list function  to '$value'", E_USER_WARNING);
            $this->$name= $value;
        }
    }

    public function render()
    {
        $buffer="";
        if($this->active) {
            $buffer= "<span class=active><a href='$this->url'>$this->name</a></span>";
        }
        else {
            $buffer= "<span><a href='$this->url'>$this->name</a></span>";
        }
        return $buffer;

    }

}






/**
* provide html-code for a html-block that can be folded
*/
class PageBlock extends PageElement
{
    public $id                      = NULL;         # required for cookies, block-toggle, javascript, etc.
    public $css_classes             = array('block');      # additional classes of block. Id is automatically added
    public $style                   = NULL;
    public $title                   ='';
    public $title_append_hidden;
    public $block_functions         = array();		# should be assoc array to allow user-settings
	public $active_block_function   = NULL;	        # name of active block_function / style
    public $noshade                 = false;        # noframe for primary text blocks (like wiki)
    public $headline_links          = array();      # List of links rendered behind block headline e.g. "(Show your)"
    public $reduced_header= false; # 


	//== constructor ========================================================================
    public function __construct($args=NULL)
    {
        parent::__construct($args);

        ### be sure id is present ###

        if(!$this->id) {
            $this->id= strToLower(preg_replace("/[^\w\d]/","",$this->title));       # remove all special chars
        }
        else {
            if(preg_match("/[^\w\d]/s", $this->id)) {
                trigger_error("removed invalid characters in blockid '$this->id'");
                $this->id= preg_replace("/[^\w\d]/","",$this->id);
            }
        }
        $this->css_classes[]= $this->id;

        ### add current page id to id to make block unique for storing toggle-state as cookie ###
        global $PH;
        $this->id= $PH->cur_page->id."_".$this->id;
    }



	public function render_blockStart($hidden=false)
	{
	    global $auth;
		echo "<!-- start of list-block -->\n";
  		echo "<div id=b_{$this->id}_long class=\"" . implode(" ", $this->css_classes) . " opened\">";
		echo "<div class=block_header>";
		    echo "<h2 class=table_name >\n";
			echo asHtml($this->title);
			
			if($this->headline_links) {
			    echo ' <span class=links>(';
			    echo  join($this->headline_links, '<span class=separator>|</span');
			    echo ')</span>';
			}
			echo "</h2>";

			$this->renderBlockFunctions();
			

		echo "</div>";
	    echo "<div class='block_body'>";
	        echo "<div class='block_content'>";

	}
	
	/**
	* overwrite this function to insert content to block footer
    */
    public function render_blockFooter() {

    }
    
	/**
	* overwrite this function to insert content to block footer
    */
    public function render_blockContent() {
        
    }


    public function render_blockEnd()
    {
        echo "\n</div>";  # /block_content
        $this->render_blockFooter();
        echo  '</div>'    # /block_body
             . '<b class=doclear>&nbsp;</b>'
             . '</div>'   # /block
             . "<!-- end {$this->id} -->\n";
    }


	/**
	* get the current block-style from cookie
	*/
	public function getBlockStyleFromCookie()
	{
		global $PH;

		/**
		* get from cookie?
		*/
        $liststyle=get("blockstyle_" . $PH->cur_page->id . "_" . $this->id);
        if($liststyle) {
        	if(isset($this->block_functions)) {
	        	$this->active_block_function= $liststyle;
                if(isset($this->block_functions[$liststyle])) {
                     $this->block_functions[$liststyle]->active = true;
                }
	        	return $liststyle;
	        }
        	else  {
        		trigger_error("undefined block_function '$liststyle' in block '$this->id'", E_USER_NOTICE);
        	}
        }

		/**
		* return default-setting...
		*/
        else {
			if($this->active_block_function) {
                if(isset($this->block_functions[$this->active_block_function])) {
                     $this->block_functions[$this->active_block_function]->active = true;
                }
				return $this->active_block_function;
			}
			else {
				trigger_error("one block-function of '$this->id' should have default-flag", E_USER_NOTICE);
			}
        }
    }

    /**
    * add a block function / block style
    *
    * @@@ most of this stuff should be done in constructor of BlockFunction
    */
    public function add_blockFunction(BlockFunction &$fn)
    {
        global $PH;

        ### cancel, if not enough rights ###
        if(!$PH->getValidPageId($fn->target)) {

            /**
            * it's quiet common that the above statement returns NULL. Do not warn here
            */
            #trigger_error("invalid target $fn->target", E_USER_WARNING);
            return;
        }

        ### build url ###
        $fn->url= $PH->getUrl($fn->target, $fn->params);

        ### create key if undefined ###
        if(!isset($fn->key)) {
            if(isset($fn->target)) {
                $fn->key= $fn->target;
            }
            else if(isset($fn->id)){
                $fn->key= strtolower($fn->id);
            }
        }

        ### warn, if already defined? ###
        if(isset($this->block_functions[$fn->key])) {
            trigger_error("overwriting function with id '$fn->key'",E_USER_NOTICE);
        }

        ### if not given, get title for page-handle ###
        if(!isset($fn->name)) {
            $phandle=$PH->getValidPage($fn->target);
            $fn->name= $phandle->title;

        }

        ### default-style? ###
        if($fn->default) {
    		$this->active_block_function = $fn->key;
    		$fn->active = true;
        }

        $fn->parent_block= $this;
        $this->block_functions[$fn->key]=$fn;
    }


    private function renderBlockFunctions()
    {
    	if($this->block_functions) {
    	    echo "<span class=block_options>";
    	    foreach($this->block_functions as $fn) {

    	        echo $fn->render();

    	    }
            echo "</span>";
    	}
    }
    


}





?>
