<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * derived ListBlock-class for listing efforts
 *
 * @includedby:     pages/*
 *
 * @author         Thomas Mann
 * @uses:           ListBlock
 * @usedby:
 *
 */
class ListBlock_comments extends ListBlock
{

    public function __construct($args=NULL) {
        global $PH;

		parent::__construct();

        $this->id       ='comments';
        $this->bg_style ='bg_misc';

        $this->no_items_html=$PH->getLink('commentNew');;

		$this->title    =__("Comments");


        #--- columns ----
        $this->add_col( new ListBlockCol_CommentPoster());
		$this->add_col( new ListBlockCol_CommentText());

        #--- functions -------
        
        #$this->add_function(new ListFunction(array(
        #    'target'=>$PH->getPage('commentNew')->id,
        #    'name'  =>__('New Comment'),
        #    'id'    =>'commentNew',
		#	'label' => __('Add Comment'),
        #    'context_menu'=>'submit',
        #)));
		$this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('itemsAsBookmark')->id,
            'name'  =>__('Mark as bookmark'),
            'id'    =>'itemsAsBookmark',
            'context_menu'=>'submit',
        )));
        /**
        * NOTE the following functions only work if quick-edit
        * form is shown (so not for folders). I am not sure, if
        * we need this function.
        *

        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('taskCollapseAllComments')->id,
            'name'  =>__('Shrink All Comments'),
            'id'    =>'commentsCollapseView',
			'label' => __('Collapse All Comments'),
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('taskExpandAllComments')->id,
            'name'  =>__('Expand All Comments'),
            'id'    =>'commentsExpandViesw',
			'label' => __('Expand All Comments'),
            'context_menu'=>'submit',
        )));
        */

        }
}



/**
* special list-columns for rendering comment-lists
*/
class ListBlockCol_CommentPoster extends ListBlockCol
{

	public $key= 'created_by';
    public $width='15%';

    function __construct($args=NULL) {
        parent::__construct($args);
        #$this->name= __('By','column header');
    }
	function render_tr(&$obj, $style="") {

		global $PH;
		global $auth;
    	global $COMMENTTYPE_NAMES;

		if(!isset($obj) || !$obj instanceof Comment) {
			trigger_error("ListBlock->render_tr() called without valid object",E_USER_WARNING);
   			return;
		}


        $style_cur_user='';
    	if($obj->created_by != 0 && $person=Person::getById($obj->created_by)) {
		    if($obj->created_by == $auth->cur_user->id) {
		        $style_cur_user= 'by_cur_user';
        	}
		}
		$column_poster= '<td class="details ' . $style_cur_user . '">';


        ### get user ###
        {
        	if($obj->created_by != 0 && $person=Person::getById($obj->created_by)) {
                $column_poster.= '<p class="poster">'.$person->getLink().'</p>';
			}
		}



        if(!$obj->view_collapsed) {
    		### time ###
    		$p_time=renderDateHtml($obj->time);


    		$column_poster.= "<span class=date>$p_time</span>";
    		### pub level if not open ###
    		if($obj->pub_level != PUB_LEVEL_OPEN) {
    		    global $g_pub_level_names;
    		    $column_poster .= "<br>(". $g_pub_level_names[$obj->pub_level]. ')<br>';
    		}

            ### get version ###
            {
                require_once(confGet('DIR_STREBER') . "db/db_itemchange.inc.php");
                $versions= ItemVersion::getFromItem($obj);
                if(count($versions) > 1) {
                    $column_poster.= "<br>" . 
                                    $PH->getLink('itemViewDiff', 
                                        sprintf(__("version %s"), count($versions)), 
                                        array('item' => $obj->id)
                                    ); 
                }
                
                
            }


    		### edit functions - depending on the relation of the current user ###
    		{
    			$column_poster.= "<div class=edit_functions>";

    			# if current user is the creator of the comment
    			if($obj->created_by == $auth->cur_user->id) {

					if( $obj->isEditable()) {
        				$column_poster.= $PH->getLink('commentEdit', __('Edit'), array('comment'=>$obj->id));
        				$column_poster.= $PH->getLink('commentsDelete', __('Delete'), array('comment'=>$obj->id));
					}
    			}
    			else
    			{
    				### check sufficient rights ###
    				if($parent_task= Task::getEditableById($obj->task)) {
    					# have to send the task-id otherwise the reply function doesn't work
    					$column_poster.= $PH->getLink('commentNew', __('Reply'), array( 'comment'=>$obj->id, 'parent_task'=>$obj->task));

    					if($obj->pub_level != PUB_LEVEL_OPEN) {
    					    $column_poster.= $PH->getLink('itemsSetPubLevel', __('Publish'), array( 'item'=>$obj->id, 'item_pub_level'=>PUB_LEVEL_OPEN));
    					}

    				}
    			}
    			$column_poster.= "</div>";
    		}
    	}

		$column_poster.= "</td>";

		print $column_poster;
	}
}






class ListBlockCol_CommentText extends ListBlockCol
{
    public $key='name';      # for sql-column for sorting

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->width='80%';
        $this->id='topic';
    }

	function render_tr(&$obj, $style="")
	{
	    global $PH;
		if(!isset($obj) || !$obj instanceof Comment) {
			trigger_error("ListBlock->render_tr() called without valid object",E_USER_WARNING);
   			return;
		}


        global $auth;
        if($obj->created_by == $auth->cur_user->id) {
    		$column_text= '<td class="comment_text by_cur_user">';
        }
        else {
    		$column_text= "<td class=comment_text>";
        }


		$column_text.= "<div class=comment_block style='padding-left:".($obj->level*2.0)."em'>";

		if($obj->view_collapsed) {
    		$column_text.= $PH->getLink('commentToggleViewCollapsed',"<img src=\"" . getThemeFile("img/toggle_folder_closed.gif") . "\">",array('comment'=>$obj->id),NULL, true);
    		$column_text.= "<span class=title>" . $PH->getLink('commentView',$obj->name, array('comment' => $obj->id)) . "</span>";
    		if($obj->num_children) {
    	    	$column_text.= "<span class=children> (";
 				if($obj->num_children == 1) {
					$column_text.= __("1 sub comment");
				}
				else {
					$column_text.= printf(__("%s sub comments"), $obj->num_children);
				}
				$column_text.= ")</span>";
    	    }
		}
		else {
    		$column_text.= $PH->getLink('commentToggleViewCollapsed',"<img src=\"" . getThemeFile("img/toggle_folder_open.gif") . "\">",array('comment'=>$obj->id),NULL,true);
    		$column_text.= "<span class=title>" . $PH->getLink('commentView',$obj->name, array('comment' => $obj->id)) . "</span>";

    		require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');
    		$project= Project::getVisibleById($obj->project);
    		$obj->nowViewedByUser();


            ### editable? ###
            $editable= false;
    		if($obj->created_by == $auth->cur_user->id) {
    		    #if($pp= $obj->getProjectPerson()) {
    			#    if($pp->level_edit < $obj->pub_level) {
    				    $editable= true;
    			#	}
    			#}
    		}
            if($editable) {
    		    $diz= wiki2html($obj->description, $project, $obj->id, 'description');
    		}
    		else {
    		    $diz= wiki2html($obj->description, $project);
    		}


            if($diz) {
	    	    $column_text.= "<div class=comment_text>$diz</div>";
	    	}
   		}

		$column_text.= "</div>";
        $column_text.= "</td>";

		print $column_text;
	}
}




?>