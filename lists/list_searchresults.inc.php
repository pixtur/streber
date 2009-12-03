<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt


/**\file 
* Classes for listing a search result
*/

require_once(confGet('DIR_STREBER') . './render/render_list.inc.php');

/**
* List search results 
*
* @ingroup render_lists
*/
class ListBlock_searchresults extends ListBlock
{
    private  $list_changes_newer_than= '';                      # timestamp

    public function __construct() {

        global $PH;
        global $auth;

        $this->id='changes';

		$this->title=__("Changes");
		$this->id="changes";
		$this->no_items_html= sprintf(__('Other team members changed nothing since last logout (%s)'), renderDate($auth->cur_user->last_logout));

        $this->add_col( new ListBlockCol_SearchResultType());
        $this->add_col( new ListBlockCol_SearchResultName());
        $this->add_col( new ListBlockCol_SearchResultModified());
        #$this->add_col( new ListBlockCol_ChangesDate());

        /*
       ### block style functions ###
        $this->add_blockFunction(new BlockFunction(array(
            'target'=>'changeBlockStyle',
            'key'=>'list',
            'name'=>'List',
            'params'=>array(
                'style'=>'list',
                'block_id'=>$this->id,
                'page_id'=>$PH->cur_page->id,
                'use_collapsed'=>true,
             ),
             'default'=>true,
        )));
        */
    }



    public function print_automatic(&$results)
    {
        global $PH;
        global $auth;

        #$changes= ChangeLine::getChangeLinesForPerson($auth->cur_user, $project);

        $this->render_list(&$results);

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

    		$style='searchresults';

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
* @ingroup render_lists
*/
class ListBlockCol_SearchResultModified extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Modified');
        $this->tooltip=__("Who changed what when...");
    }

	function render_tr(&$r, $style="")
	{
        if($r instanceof SearchResult) {
            if(isset($r->item)) {
                if($r->item->modified_by) {

                    if($person= Person::getVisibleById($r->item->modified_by)) {

                		print '<td><span class=date>'.renderDateHtml($r->item->modified) .'</span><br><span class="sub who">'.__('by').' '. $person->getLink() .'</span></td>';
                		return;
                    }

                }
                else {
        		    print '<td><span class=date>'.renderDateHtml($r->item->modified) .'</span></td>';
        		}
        	}
    	    print "<td></td>";
    	}
    	else {
    	    trigger_error('ListBlockCol_ChangesDate() requires instance of SearchResult',E_USER_WARNING);
    	    print "<td></td>";
    	}
	}
}




/**
* @ingroup render_lists
*/

class ListBlockCol_SearchResultType extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Type');
    }

	function render_tr(&$r, $style="")
	{
        if(!$r instanceof SearchResult) {
    	    trigger_error('ListBlockCol_SearchResultName() requires instance of SearchResult',E_USER_WARNING);
    	    print "<td></td>";
    	    return;
    	}
    	echo "<td>";
    	echo $r->type;
    	if($r->status) {
    	    echo "<br>";
    	    echo "<span class=sub>";
    	    echo $r->status;
    	    echo "</span>";
    	}
    	echo "</td>";

	}
}

/**
* @ingroup render_lists
*/

class ListBlockCol_SearchResultName extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Name');
        $this->width ='80%';
    }

	function render_tr(&$r, $style="")
	{
        global $PH;
        if(!$r instanceof SearchResult) {
    	    trigger_error('ListBlockCol_SearchResultName() requires instance of SearchResult',E_USER_WARNING);
    	    print "<td></td>";
    	    return;
    	}

    	$isDone= $r->is_done
    	       ? 'isDone'
    	       : '';

    	echo "<td>";
        echo "<span class='name $isDone'>";
    	echo $PH->getLink($r->jump_id, $r->name, $r->jump_params);
    	echo "</span>";
    	if($r->html_location) {
    	    echo "<br>";

    	    echo "<span class=sub>";
    	    echo $r->html_location;
    	    echo "</span>";

    	}
    	if($r->extract) {
    	    echo "<br>";

    	    echo "<span class=extract>";
    	    echo $r->extract;
    	    echo "</span>";
    	}
    	echo "</td>";

	}
}






?>