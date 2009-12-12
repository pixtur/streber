<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * Renders a list of attached files to an item
 *
 * included by: @render_page
 * @author     Thomas Mann
 */


/**
* provide front-end for rendering and manimpulating lists
*
* usage:
*
*    $block= new ListCommentsBlock($comments);
*    $block->render()
*
* @uses     ListFunction
* @usedby   most pages
*/
class FilesAttachedToItemBlock extends PageBlock
{
    public $item_with_attachments;

    function __construct($item)
    {
        parent::__construct(NULL);
        $this->item_with_attachments = $item;
    }


    public function __toString()
    {
        global $PH;
        global $auth;

        require_once(confGet('DIR_STREBER') . 'lists/list_files.inc.php');
        $files= File::getall(array('parent_item'=> $this->item_with_attachments->id));

        $list= new ListBlock_files();
        $list->reduced_header= true;
        $list->query_options['parent_item']= $this->item_with_attachments->id;
        $list->show_functions=false;

        unset($list->columns['status']);
        unset($list->columns['mimetype']);
        unset($list->columns['filesize']);
        unset($list->columns['created_by']);
        unset($list->columns['version']);
        unset($list->columns['_select_col_']);
        unset($list->columns['modified']);
        unset($list->columns['name']);
        unset($list->columns['thumbnail']);

        unset($list->block_functions['list']);
        unset($list->block_functions['grouped']);
        unset($list->functions['fileEdit']);
        unset($list->functions['filesDelete']);

        $list->title=__('Attached files');

        if($this->item_with_attachments->isEditable()) {
            $list->summary= buildFileUploadForm( $this->item_with_attachments );
        }
        
        $list->print_automatic($project);
        $PH->go_submit= $PH->getValidPage('filesUpload')->id;
        
        return "";
    }

}
