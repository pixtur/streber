<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * classes related to rendering project news
 *
 * included by: @render_page
 * @author     Thomas Mann
 */

require_once(confGet('DIR_STREBER') . "render/render_page.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list_column.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list_column_special.inc.php");


class ProjectNewsBlock extends PageBlock
{
    public $project;
    public $max_news = 3;

    function __construct($project)
    {
        parent::__construct(NULL);
        $this->project = $project;
        $this->title = __('Project News');
        $this->id = 'project_news';
    }

    public function __toString()
    {
        global $PH;


		$news= $this->project->getTasks(array(  # NOTE: get all items with show news option (not just DOCU)
            'is_news'  => 1,
            'order_by'  => 'created DESC',
        ));
        if(!$news) {
            return '';
        }

        
    	#--- news -----------------------------------------------------------


        $this->render_blockStart();

        $count = 0;
        foreach($news as $n) {
            if($count++ >= $this->max_news) {
                break;
            };
            echo "<div class='post_list_entry'>";
            if($creator= Person::getVisibleById($n->created_by)) {
                $link_creator= ' by '. $creator->getLink();
            }
            else {
                $link_creator= '';
            }
            echo "<h3>" . asHtml( $n->name ) . "</h3>";
            echo "<p class= details>";
            echo sprintf (__('%s by %s', "time ago by nickname"), renderTimeAgo($n->created), asHtml($creator->nickname));

            if($comments= $n->getComments()) {
                echo " / ";
                echo  $PH->getLink('taskViewAsDocu', sprintf(__("%s comments"),count($comments)), array('tsk'=> $n->id));
            }
            echo " / ";
            echo $PH->getLink("commentNew", __("Add comment"), array('parent_task' => $n->id) );

            echo "</p>";
            echo  wikifieldAsHtml($n, 'description');   

            echo "</div>";                
        }   

        $this->render_blockEnd();
        return '';
    }
}


?>