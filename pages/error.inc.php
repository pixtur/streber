<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * pages relating to error
 *
 * @author:         Thomas Mann
 * @uses:           ListBlock
 * @usedby:
 *
 */

/**
* shown, if unknown page-id requested.
* @@@ this should only trigger an error and relay to home
* @@@ removing this function would make renderBacktrace() obsolete, too
*/
function error()
{
    global $PH;
    require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');

    ### set up page ####
    {
        $page= new Page();

        $page->tabs['error']=  array('target'=>"index.php?go=error",     'title'=>__('Error','top navigation tab'), 'bg'=>"error");
    	$page->cur_tab='error';

        $page->title=__("Unknown Page");
        $page->type=__("Error");
        $page->title_minor=get('go');
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    $block=new PageBlock(array('title'=>__('Error'), 'id'=>'error'));
    $block->render_blockStart();
    echo "<div class=text>";
    echo "<p>Sorry but you found a function that has not yet been implemented.<br>";
    echo "If you feel this a bug, or a very important function is missing, please help us to fix this,
    Please hit the back-button of your browser and use the 'Wiki + Help' option to follow to the online
    documentation. Then edit 'issue' or 'request-part'.</p>";

    echo "</div>";


    $block->render_blockEnd();

    $block=new PageBlock(array('title'=>'Details', 'id'=>'details'));
    $block->render_blockStart();
    echo "<div class=text>";
    echo "<pre>";
    echo renderBacktrace(debug_backtrace());

    echo "</pre>";
    echo "</div>";

    $block->render_blockEnd();


    echo (new PageContentClose);
	echo (new PageHtmlEnd);
}


?>