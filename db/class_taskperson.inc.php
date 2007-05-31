<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
* task_person / jointable between company and person
*
* assigning tasks to persons
*
* @author         Thomas Mann
*
*/

define('ASSIGNTYPE_UNDEFINED', 0);
define('ASSIGNTYPE_INITIAL', 1);
define('ASSIGNTYPE_CHANGED', 2);
define('ASSIGNTYPE_ADDED', 3);



class TaskPerson extends DbProjectItem {
    public $name;
    public $project;

    /**
    * constructor
    */
    function __construct ($id_or_array=NULL)
    {
        global $g_task_person_fields;
        $this->fields= &$g_task_person_fields;

        parent::__construct($id_or_array);
        if(!$this->type) {
            $this->type= ITEM_TASKPERSON;
        }
    }

    static function initFields()
    {
        global $g_task_person_fields;
        $g_task_person_fields=array();
        addProjectItemFields(&$g_task_person_fields);
        
        foreach(array(
            new FieldInternal(array(    'name'=>'id',               # add id to both tables for caching
                'default'=>0,
                'in_db_object'=>1,
                'in_db_item'=>1,
            )),
            new FieldInternal(array(    'name'=>'task',             # id task
            )),
            new FieldInternal(array(    'name'=>'person',           # id of assigned person
            )),
            new FieldString(array(      'name'=>'comment',
            )),
            new FieldInternal(array(    'name'=>'assigntype',
                'default'=>ASSIGNTYPE_INITIAL,
            )),
			new FieldInternal(array(    'name'=>'forward',
                'default'=>0,
            )),
			new FieldString(array(      'name'=>'forward_comment',
            )),
        
        ) as $f) {
            $g_task_person_fields[$f->name]=$f;
        }
    }

    /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id)
    {
        $tp= new TaskPerson($id);
        if($tp->id) {
            return $tp;
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
        if($tp= TaskPerson::getById($id)) {
            if($p= Project::getById($tp->project)) {
                if($p->validateViewItem($tp)) {
                    return $tp;
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
        if($tp= TaskPerson::getById($id)) {
            if($p= Project::getById($tp->project)) {
                if($p->validateEditItem($tp)) {
                    return $tp;
                }
            }
        }
        return NULL;
    }



    static function &getTaskPersons( $args=NULL)
    {
        global $auth;
        $prefix = confGet('DB_TABLE_PREFIX');

        ### default params ###
        $date_min           = NULL;
        $date_max           = NULL;
        $created_by         = NULL;       # who created assigment...
        $person             = NULL;        # who has was assigned...
        $task               = NULL;
        $project            = NULL;
		$forward            = NULL;
		$state              = NULL;
						
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


        $str_project= $project
            ? 'AND i.project='.intval($project)
            : '';

        $str_created_by= $created_by
            ? 'AND i.created_by='.intval($created_by)
            : '';

        $str_date_min= $date_min
            ? "AND i.modified >= '".asCleanString($date_min)."'"
            : '';

        $str_date_max= $date_max
            ? "AND i.modified <= '" . asCleanString($date_max) ."'"
            : '';

        $str_task= $task
            ? 'AND tp.task ='.intval($task)
            : '';

        $str_person= $person
            ? 'AND tp.person ='.intval($person)
            : '';
		
		$str_forward = $forward
		    ? 'AND tp.forward = 1'
			: '';
		
		$str_state = $state
		    ? 'AND i.state ='.intval($state)
			: '';
			
        ### show all ###
		$str_query=
			"SELECT tp.*, i.* from {$prefix}taskperson tp, {$prefix}item i
			 WHERE
			i.type = '".ITEM_TASKPERSON."'
			$str_project
			$str_created_by
			$str_forward
			$str_state
			AND tp.id = i.id
				$str_person
				$str_task
			$str_date_max
			$str_date_min
			";

		$dbh = new DB_Mysql;
		$sth= $dbh->prepare($str_query);

		$sth->execute("",1);
		$tmp=$sth->fetchall_assoc();
		#echo "%%query: " .$str_query. "<br>";
		$tps=array();
		foreach($tmp as $t) {
			$c=new TaskPerson($t);
			$tps[]=$c;
		}
		return $tps;
		
    }
}



TaskPerson::initFields();



?>
