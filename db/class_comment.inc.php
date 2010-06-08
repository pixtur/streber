<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * comments object
 *
 * @includedby:     *
 *
 * @author         Thomas Mann
 * @uses:           DbProjectList
 * @usedby:
 *
 */


/**
*  setup the database fields for comment-object as global assoc-array
*/
    global $comment_fields;
    global $COMMENTTYPE_VALUES;
    $comment_fields= array();
    addProjectItemFields(&$comment_fields);

    foreach(array(
        new FieldInternal(array(    'name'=>'id',
            'default'=>0,
            'in_db_object'=>1,
            'in_db_item'=>1,
        )),
            new FieldString(array(      'name'=>'name',
                'title'=>__('Summary'),
                'log_changes'=>true,
            )),
            new FieldDatetime(array(    'name'=>'time',
                'default'=>FINIT_NOW,
                'view_in_forms'=>false,
            )),
            new FieldHidden(array(      'name'=>'person',
                'view_in_forms'=>true
            )),
            new FieldHidden(array(      'name'=>'comment',
                'view_in_forms'=>true
            )),
            new FieldHidden(array(      'name'=>'task',
                'view_in_forms'=>true
            )),
            new FieldHidden(array(      'name'=>'effort'
            )),
            new FieldInternal(array(      'name'=>'view_collapsed'
            )),

            new FieldHidden(array(      'name'=>'file'
            )),
            new FieldBool(array(        'name'=>'starts_discussion',
                'title'=>'Starts Project Discussion',
                'view_in_forms'=>false,         # save discussions as a later feature

            )),
            new FieldText(array(        'name'=>'description',
                'title'=>__('Details'),
                'log_changes'=>true,

            )),
            new FieldHidden(array(         'name'=>'occasion',
                'default'=>$COMMENTTYPE_VALUES['Comment'],
                'view_in_forms'=>true,         # save discussions as a later feature

            )),
    ) as $f) {
        $comment_fields[$f->name]=$f;
    }


/**
* class for handling project - comments
*/
class Comment extends DbProjectItem
{
    public $level;              # level if child of parent-tasks
    public $type;
    public $path;               # used for hierarchical sorting of comments
    public $num_children;       # displayed when viewed collapsed (folded)

	//=== constructor ================================================
	function __construct ($id_or_array=false)
    {
        global $comment_fields;
        $this->fields= &$comment_fields;

        parent::__construct($id_or_array);
        if(!$this->type) {
            $this->type= ITEM_COMMENT;
        }
        $this->num_children=0;
   	}


    /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id)
    {
        $c= new Comment(intval($id));
        if($c->id) {
            return $c;
        }
        return NULL;
    }


    /**
    * query if visible for current user
    *
    * - returns NULL if failed
    * - this function is slow
    * - lists should check visibility with sql-querries
    */
    static function getVisibleById($id)
    {
        if($c= Comment::getById(intval($id))) {
            if($c->id) {
                if($p= Project::getById($c->project)) {
                    if($p->validateViewItem($c)) {
                        return $c;
                    }
                }
            }
        }
        return NULL;
    }

    /**
    * query if editable for current user
    */
    static function getEditableById($id)
    {
        if($c= Comment::getById(intval($id))) {
            if($p= Project::getById($c->project)) {
                if($p->validateEditItem($c)) {
                    return $c;
                }
            }
        }
        return NULL;
    }


    /**
    * getSubComments
    *
    * NOTE: This is NOT recursive!
    */
    public function getSubComments()
    {
        if(!$project= Project::getById($this->project)) {
            return array();
        }
        
        $comments= Comment::getAll(array(
            'parent_comment'=> $this->id        
        ));
        
        return $comments;
    }


    /**
    * getComments($project=false)
    */
    static function getAll($args=Array())
    {
        global $auth;
		$prefix = confGet('DB_TABLE_PREFIX');
        require_once(confGet('DIR_STREBER') . 'db/class_comment.inc.php');

        ### default params ###
        $order_by=      'c.name';
        $visible_only=  true;   # use project rights settings
        $alive_only=    true;   # ignore deleted
        $project=       NULL;
        $task=          NULL;
        $person=        NULL;
        $date_min=      NULL;
        $date_max=      NULL;
        $search=        NULL;
        $parent_comment= NULL;

        ### filter params ###
        if($args) {
            foreach($args as $key=>$value) {
                if(!isset($$key) && !is_null($$key) && !$$key==="") {
                    trigger_error("unknown parameter",E_USER_NOTICE);
                }
                else {
                    $$key= $value;
                }
            }
        }

        $dbh = new DB_Mysql;

        $str_is_alive= $alive_only
        ? 'AND i.state=1'
        : '';

        $AND_person= $person
        ? 'AND i.created_by='. intval($person)
        : '';

        $AND_task= $task
        ? 'AND c.task='. intval($task)
        : '';

        $AND_match= $search
        ? "AND (MATCH (c.name,c.description) AGAINST ('". asCleanString($search)."*'  IN BOOLEAN MODE))"
        : '';

        $AND_project1= $project
        ? "AND upp.project= $project"
        : "";

        $AND_project2= $project
        ? "AND i.project= $project"
        : "";

        $AND_date_min= $date_min
            ? "AND i.modified >= '". asCleanString($date_min)."'"
            : '';

        $AND_date_max= $date_max
            ? "AND i.modified <= '". asCleanString($date_max)."'"
            : '';

        if(!is_null($parent_comment)) {
            $AND_comment= 'AND c.comment = ' . intval($parent_comment);
        }
        else {
            $AND_comment= '';
        }

        if($visible_only) {
            $str_query=
            "SELECT i.*, c.* from {$prefix}item i, {$prefix}comment c, {$prefix}projectperson upp
            WHERE
                    upp.person = {$auth->cur_user->id}
                $AND_project1
                AND upp.state = 1

                AND i.type = '".ITEM_COMMENT."'
                AND i.project = upp.project
                $AND_project2
                $str_is_alive
                $AND_person
                $AND_date_min
                $AND_date_max
                AND ( i.pub_level >= upp.level_view
                      OR
                      i.created_by = {$auth->cur_user->id}
                )

                AND c.id = i.id
                $AND_task
                $AND_match
                $AND_comment

            ". getOrderByString($order_by);
        }
        else {
            $str_query=
            "SELECT i.*, c.* from {$prefix}item i, {$prefix}comment c
            WHERE
                    i.type = '".ITEM_COMMENT."'
                $AND_project2
                $str_is_alive
                $AND_person
                $AND_date_min
                $AND_date_max

                AND c.id = i.id
                $AND_task
                $AND_comment
                $AND_match

            ". getOrderByString($order_by);

        }

        $sth= $dbh->prepare($str_query);
    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();
    	$comments=array();
        foreach($tmp as $n) {
            $comment=new Comment($n);
            $comments[]= $comment;
        }
        return $comments;

    }

    public function getLink()
    {
        global $PH;
        return $PH->getLink('commentView', $this->name, array('comment'=>$this->id));
    }
}




?>