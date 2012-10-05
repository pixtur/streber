<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 *
 *
 * included by: @render_page
 * @author     Thomas Mann
 */

require_once(confGet('DIR_STREBER') . "render/render_page.inc.php");

class ProjectSummaryBlock extends PageBlock
{
    public $project;
    public $current_milestone;
    public $title= ""; 

    public function __construct($project)
    {
        parent::__construct(NULL);
        $this->project = $project;
        $this->current_milestone = $project->getNextMilestone();
        $this->title= __('');
    }

    public function __toString()
    {
        return "";
    }


    public function render($args=NULL)
    {
        global $PH;
        
        $this->render_blockStart();
        //echo "<div class='post_list_entry'>";

        {
            ### client ###
            if($this->project->company) {
                echo "<div class=labeled><label>".__("For","Label in Task summary")."</label>"
                    . $this->project->getCompanyLink()
                    . "</div>";
            }
            
            global $g_status_names;
            if($status=$g_status_names[$this->project->status]) {
                echo "<div class=labeled><label>".__("Status","Label in Task summary")."</label>$status</div>";
            }

            echo "<div class=labeled><label>".__("Opened","Label in Task summary")."</label>".renderDateHtml($this->project->date_start)."</div>";
            if($this->project->date_closed !="0000-00-00") {
                echo "<div class=labeled><label>".__("Closed","Label in Task summary")."</label>". renderDateHtml($this->project->date_closed) . "</div>";
            }

            ### efforts ###
            if($openEfforts = $this->project->getOpenEffortsSum() > 0) {
                echo "<div class=labeled><label>".__("Open efforts","Label in Task summary")."</label>"
                    . $PH->getLink('projViewEfforts', round($this->project->getOpenEffortsSum()/60/60,1) . "h", array('prj'=> $this->project->id, 'preset' => 'open_efforts' ))
                    . "</div>";            
            }
            
            
            /*
            ### normal tasks ###
            else {

                if($task->for_milestone) {
                    if($milestone= Task::getVisibleById($task->for_milestone)) {
                        echo "<div class=labeled><label>".__("For Milestone","Label in Task summary")."</label>".$milestone->getLink(false)."</div>";
                    }
                }


                global $g_status_names;
                if($status=$g_status_names[$task->status]) {
                    echo "<div class=labeled><label>".__("Status","Label in Task summary")."</label>$status</div>";
                }


                echo "<div class=labeled><label>".__("Opened","Label in Task summary")."</label>".renderDateHtml($task->date_start)."</div>";

                if($task->estimated) {
                    echo "<div class=labeled><label>".__("Estimated","Label in Task summary")."</label>".renderDuration($task->estimated). ' ';

                    if($task->estimated_max) {
                        echo " ... ". renderDuration($task->estimated_max);
                    }
                    echo "</div>";
                }

                if($task->completion) {
                    echo "<div class=labeled><label>".__("Completed","Label in Task summary")."</label>".$task->completion."%</div>";
                }

                if($task->planned_start && $task->planned_start != "0000-00-00 00:00:00") {
                    echo "<div class=labeled><label>".__("Planned start","Label in Task summary")."</label>".renderTimestamp($task->planned_start)."</div>";
                }

                if($task->planned_end && $task->planned_end != "0000-00-00 00:00:00") {
                    echo "<div class=labeled><label>".__("Planned end","Label in Task summary")."</label>".renderTimestamp($task->planned_end)."</div>";
                }

                if($task->date_closed !="0000-00-00") {
                    echo "<div class=labeled><label>".__("Closed","Label in Task summary")."</label>". renderDateHtml($task->date_closed) . "</div>";
                }
            }

            if($person_creator= Person::getVisibleById($task->created_by)) {
                echo "<div class=labeled><label>".__("Created","Label in Task summary")."</label>". renderDateHtml($task->created) . ' / ' . $person_creator->getLink().'</div>' ;
            }

            if($person_modify= Person::getVisibleById($task->modified_by)) {
                echo "<div class=labeled><label>".__("Modified","Label in Task summary")."</label>". renderDateHtml($task->modified) . ' / ' .  $person_modify->getLink() . '</div>' ;
            }

            ### get version ###
            {
                require_once(confGet('DIR_STREBER') . "db/db_itemchange.inc.php");
                $versions= ItemVersion::getFromItem($task);
                if(count($versions) > 1) {
                    $str_version=     $PH->getLink('itemViewDiff',
                                        sprintf(__("View previous %s versions"), count($versions)),
                                        array('item' => $task->id)
                                    );
                    echo "<div class=labeled><label></label>$str_version</div>";
                }
            }


            #}

            $sum_efforts= $task->getSumEfforts();
            if($sum_efforts) {
                echo "<div class=labeled><label>".__("Logged effort","Label in task-summary")."</label>".
                $PH->getLink('taskViewEfforts',round($sum_efforts/60/60,1), array('task'=>$task->id))
                ."</div>" ;
            }

            if($tps= $task->getAssignedPeople()) {
                $value="";
                $sep="";
                foreach($tps as $tp) {
                    $value.= $sep . $tp->getLink();
                    $sep=", ";
                }
                $label=__("Assigned to");
                echo "<div class=labeled><label>$label</label>$value</div>" ;


            }

            ### publish to ###
            global $g_pub_level_names;
            if($task->pub_level != PUB_LEVEL_OPEN && isset($g_pub_level_names[$task->pub_level])) {
                echo "<div class=labeled><label>".__("Publish to","Label in Task summary")."</label>".$g_pub_level_names[$task->pub_level] ;
                if($editable) {
                    echo '<br>('
                        . $PH->getLink('itemsSetPubLevel',__('Set to Open'), array('item' => $task->id,'item_pub_level' => PUB_LEVEL_OPEN))
                        . ')';
                }
                echo "</div>";
            }
            */


        }


        //echo "</div>";

        $this->render_blockEnd();
        return '';
    }
    
}


?>