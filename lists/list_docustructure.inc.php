<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt


require_once(confGet('DIR_STREBER') . 'db/class_issue.inc.php');





define('LEVEL_NONE',    -1);
define('LEVEL_PARENTS', 0);
define('LEVEL_NORMAL',  1);
define('LEVEL_CHILDREN',2);




/**
* renders docunavigation which is displayed on the right side of docu pages
*
* 1. get structure as list of tasks where level...
*    0 - parent links
*    1 - content links
*    2 - sub content links if current task is a folder and contains docu pages
*
* 2. renders list
*/
class Block_DocuNavigation extends PageBlock
{
    #public $title          = "bla";
    public  $current_task   = NULL;
    public  $project_id     = NULL;     # object
    public  $reduced_header = true;
    private $tasks          = array();
    public  $root           = NULL;



    public function __construct($args=NULL) {
        $this->title= __("Documentation");
        $this->id = 'parent_task';
        parent::__construct($args);
    }


    private function initStructure()
    {
        $tasks= array();

        if(!$this->project_id) {
            if(!$this->current_task) {
                trigger_error("At least current_task or project required");
                return;
            }
            $this->project_id = $this->current_task->project;
        }

        ### start from a certain parent (e.g. a task) ###
        if($this->root) {
            foreach(Task::getDocuTasks($this->project_id, $this->root->id) as $p) {
                $p->level = LEVEL_NORMAL;
                if($p->id == $this->current_task->id && $p->category == TCATEGORY_FOLDER) {
                    $p->view_collapsed = 0;
                    $tasks[]= $p;

                    foreach(Task::getDocuTasks($this->project_id, $p->id) as $sp) {
                        $sp->level = LEVEL_CHILDREN;
                        $tasks[]= $sp;
                    }
                }
                else {
                    $p->view_collapsed= 1;
                    $tasks[]= $p;
                }
            }
        }
        else if($this->current_task == NULL) {
            foreach(Task::getDocuTasks($this->project_id, 0) as $sp) {
                $sp->level = LEVEL_NORMAL;
                $tasks[]= $sp;
            }

        }
        ### with parents ###
        else if($parents= $this->current_task->getFolder()) {

            foreach($parents as $pt) {
                $pt->level = LEVEL_PARENTS;
                $tasks[]= $pt;
            }
            ### current level is children of last parent tasks ###
            foreach(Task::getDocuTasks($this->project_id, $pt->id) as $p) {

                $p->level = LEVEL_NORMAL;
                $p->view_collapsed= 1;
                if($p->id == $this->current_task->id && $p->category == TCATEGORY_FOLDER) {
                    $p->view_collapsed = 0;
                    $tasks[]= $p;

                    foreach(Task::getDocuTasks($this->project_id, $p->id) as $sp) {
                        $sp->level = LEVEL_CHILDREN;
                        $tasks[]= $sp;
                    }
                }
                else {
                    $p->view_collapsed= 1;
                    $tasks[]= $p;
                }
            }
        }
        ### at root level ##
        else {
            foreach(Task::getDocuTasks($this->project_id, 0) as $p) {
                $p->level = LEVEL_NORMAL;
                if($p->id == $this->current_task->id && $p->category == TCATEGORY_FOLDER) {
                    $p->view_collapsed = 0;
                    $tasks[]= $p;

                    foreach(Task::getDocuTasks($this->project_id, $p->id) as $sp) {
                        $sp->level = LEVEL_CHILDREN;
                        $tasks[]= $sp;
                    }
                }
                else {
                    $p->view_collapsed= 1;
                    $tasks[]= $p;
                }
            }
        }
        $this->tasks = $tasks;
        return;
    }



    public function print_all()
    {
        $this->initStructure();
        $this->render_BlockStart();
        echo "<div class=docuNavigation>";

        $state = LEVEL_NONE;
        foreach($this->tasks as $t) {
            switch($state) {
            case LEVEL_NONE:
                if($t->level == LEVEL_PARENTS) {
                    $state= LEVEL_PARENTS;
                    echo '<ul class=parents>';
                    echo '<li>' . $this->printLink($t) . '</li>';
                }
                else if($t->level == LEVEL_NORMAL) {
                    $state= LEVEL_NORMAL;
                    echo '<ul class=normal>';
                    echo '<li>' . $this->printLink($t). '</li>';

                }
                break;

            case LEVEL_PARENTS:
                if($t->level == LEVEL_PARENTS) {
                    echo '<li>' . $this->printLink($t). '</li>';
                }
                else {
                    echo '</ul>';
                    $state = LEVEL_NORMAL;
                    echo '<ul class=normal>';
                    echo '<li>' . $this->printLink($t) . '</li>';
                }
                break;

            case LEVEL_NORMAL:
                if($t->level == LEVEL_NORMAL) {
                    echo '<li>' . $this->printLink($t) . '</li>';
                }
                else if($t->level == LEVEL_CHILDREN) {
                    echo '<ul class=children>';
                    echo '<li>' . $this->printLink($t);
                    $state= LEVEL_CHILDREN;
                }
                break;

            case LEVEL_CHILDREN:
                if($t->level == LEVEL_CHILDREN) {
                    echo '<li>' . $this->printLink($t)  . '</li>';
                }
                else {
                    echo '</ul>';
                    $state= LEVEL_NORMAL;
                    echo '</li>';
                    echo '<li>' . $this->printLink($t)  . '</li>';
                }
                break;
            }

        }
        switch($state) {
        case LEVEL_NONE:
            break;
        case LEVEL_PARENTS:
            echo '</ul>';
            break;
        case LEVEL_NORMAL;
            echo '</ul>';
            break;
        case LEVEL_CHILDREN:
            echo '</ul>';
            echo '</ul>';
            break;
        }
        echo "</div>";


        $this->render_BlockEnd();

    }

    /**
    * prints a link to another documentation task
    *
    * sets style class depending on type and level
    */
    private function printLink($t)
    {
        global $PH;
        $style= NULL;
        $page= 'taskView';
        if($t->category == TCATEGORY_FOLDER) {
            $style= 'folder';
            if($this->current_task && $t->id == $this->current_task->id) {
                $style= 'folder current';
            }
            $page= 'taskViewAsDocu';
        }
        else if($this->current_task && $t->id == $this->current_task->id) {
            $style= 'current';
        }

        return $PH->getLink($page, $t->name, array('tsk' => $t->id), $style );
    }
}







?>