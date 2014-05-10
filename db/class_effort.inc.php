<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * effort object
 *
 * @includedby:     *
 *
 * @author         Thomas Mann
 * @uses:           DbProjectList
 * @usedby:
 *
 */






/**
* class for handling project - efforts
*/
class Effort extends DbProjectItem
{
    public $level;              # level if child of parent-tasks
    public $type;
    public $effort_status;

    //=== constructor ================================================
    function __construct ($id_or_array=NULL)
    {
        global $effort_fields;
        $this->fields= &$effort_fields;

        parent::__construct($id_or_array);
        if(!$this->type) {
            $this->type= ITEM_EFFORT;
        }
    }

    /**
    *  setup the database fields for effort-object as global assoc-array
    */
    static function initFields()
    {
        global $effort_fields;
        $effort_fields=array();
        addProjectItemFields($effort_fields);
    
                foreach(array(
                    new FieldInternal(array(    'name'=>'id',
                        'default'=>0,
                        'in_db_object'=>1,
                        'in_db_item'=>1,
                    )),
                    new FieldInternal(array(    'name'=>'project',
                        'default'=>0,
                        'in_db_object'=>1,
                        'in_db_item'=>1,
                    )),
                    new FieldString(array(      'name'=>'name',
                        'title'=>__('Summary'),
                        'tooltip'=>__('optional if tasks linked to this effort'),
                    )),
    
                    new FieldInternal(array(      'name'=>'task',
                    )),
    
                    new FieldInternal(array(      'name'=>'billing',
                    )),
                    new FieldInternal(array(      'name'=>'productivity',
                        'default'=> 3
                    )),
    
                    new FieldDatetime(array(    'name'=>'time_start',
                        'title'=> __('Time Start'),
                        'default'=>FINIT_NOW
                    )),
                    new FieldDatetime(array(    'name'=>'time_end',
                        'title'=> __('Time End'),
                        'default'=>FINIT_NOW
                    )),
                    new FieldInternal(array(    'name'=>'person',
                    )),
                    new FieldText(array(        'name'=>'description',
                        'title'=>__('Description'),
                    )),
                    new FieldInternal(array(    'name'=>'as_duration',
                        'default'=>0,
                    )),
                    new FieldOption   (array(    'name'=>'status',
                        'title'=>__('Status'),
                        'view_in_forms'=>true,
                        'default'=>1,
                    )),
                    
                    /**
                    * DEPRECATED! this internal field is for backwards compatibility to old db-structures
                    */
                    #new FieldInternal(array('name'=>'category',
                    #    'default'=>TCATEGORY_TASK,
                    #    'log_changes' => true,
                    #)),
    
                ) as $f) {
                    $effort_fields[$f->name]=$f;
                }
    }

    /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id)
    {
        $e= new Effort(intval($id));
        if($e->id) {
            return $e;
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
        if($e= Effort::getById(intval($id))) {
            if($p= Project::getById($e->project)) {
                if($p->validateViewItem($e)) {
                    return $e;
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
        if($e= Effort::getById(intval($id))) {
            if($p= Project::getById($e->project)) {
                if($p->validateEditItem($e)) {
                    return $e;
                }
            }
        }
        return NULL;
    }


    public static function getDateCreatedLast()
    {
        global $auth;
        $prefix= confGet('DB_TABLE_PREFIX');

        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
        $dbh = new DB_Mysql;
        $sth= $dbh->prepare(
            "SELECT MAX(e.time_end)
                 from {$prefix}item i,  {$prefix}effort e
                WHERE   i.created_by={$auth->cur_user->id}
                    AND i.type = '".ITEM_EFFORT."'
                    AND e.id = i.id
                    AND i.state = 1
                "
        )->execute();
        $tmp=$sth->fetchall_assoc();
        if($tmp) {
            $tmp_values=array_values($tmp[0]);
            return $tmp_values[0];
        }
        else {
            return false;
        }
    }






    /**
    * return efforts depending on filter options
    * @@@ todo:
    * - refacture status_min/max evaluation only if !is_null
    *
    */
    static function getAll( $args=NULL)
    {
        global $auth;
        $prefix = confGet('DB_TABLE_PREFIX');

        ### default params ###
        $project            = NULL;
        $person             = NULL;
        $order_by           = 'e.time_start DESC';
        $visible_only       = true;       # use project rights settings
        $alive_only         = true;       # ignore deleted
        $task               = NULL;       # for a parent task?
        $date_min           = NULL;
        $date_max           = NULL;
        $search             = NULL;       # search query
        $effort_status_min  = NULL;
        $effort_status_max  = NULL;
        $effort_time_min  = NULL;
        $effort_time_max  = NULL;

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
            ? 'AND i.project=' . intval($project)
            : '';


        $str_project2= $project
            ? 'AND upp.project=' . intval($project)
            : '';


        $str_is_alive= $alive_only
            ? 'AND i.state=' . ITEM_STATE_OK
            : '';


        $str_date_min= $date_min
            ? "AND i.modified >= '" . asCleanString($date_min) . "'"
            : '';

        $str_date_max= $date_max
            ? "AND i.modified <= ' ". asCleanString($date_max) . "'"
            : '';
            
        $str_status_min = $effort_status_min
            ? "AND e.status >= '" . asCleanString($effort_status_min) . "'"
            : '';

        $str_status_max = $effort_status_max
            ? "AND e.status <= ' ". asCleanString($effort_status_max) . "'"
            : '';

        $str_effort_time_min= $effort_time_min
            ? "AND e.time_start >= ' ". asCleanString($effort_time_min) . "'"
            : '';

        $str_effort_time_max= $effort_time_max
            ? "AND e.time_end <= ' ". asCleanString($effort_time_max) . "'"
            : '';

        $str_task= !is_null($task)
            ? 'AND e.task=' . intval($task)
            : '';

        $str_person= $person
            ? 'AND e.person=' . intval($person)
            : '';

        if ($auth->cur_user->user_rights & RIGHT_VIEWALL)
        {
            $str_projectperson = "";
        }
        else
        {
            $str_projectperson = "AND upp.person = {$auth->cur_user->id}";
        }

        $str_match= $search
            ? "AND MATCH (e.description) AGAINST ('". asMatchString($search) ."*' IN BOOLEAN MODE)"
        : '';
                
        /**
        * note: project p required for sorting
        */
        if($visible_only) {
            $str_query=
            "SELECT DISTINCT i.*, e.* from {$prefix}item i, {$prefix}effort e, {$prefix}project p, {$prefix}projectperson upp
            WHERE

                i.type = '".ITEM_EFFORT."'
                $str_project
                $str_projectperson
                $str_project2
                $str_person
                $str_is_alive
                AND ( i.pub_level >= upp.level_view
                      OR
                      i.created_by = {$auth->cur_user->id}
                )
                AND i.project = p.id

                AND i.id = e.id
                 $str_task
                 $str_date_max
                 $str_date_min
                 $str_status_max
                 $str_status_min
                 $str_effort_time_min
                 $str_effort_time_max
                 $str_match

            ". getOrderByString($order_by)
            ;
        }
        ### show all ###
        else {
            $str_query=
            "SELECT i.*, e.* from {$prefix}item i, {$prefix}effort e, {$prefix}project p
            WHERE
                i.type = '".ITEM_EFFORT."'
            $str_project
            $str_is_alive

            AND i.project = p.id

            AND i.id = e.id
             $str_task
             $str_date_max
             $str_date_min
             $str_match

            ". getOrderByString($order_by)
            ;
        }

        $dbh = new DB_Mysql;
        $sth= $dbh->prepare($str_query);

        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        
        $efforts=array();
        foreach($tmp as $t) {
            $effort=new Effort($t);
            $efforts[]=$effort;
        }
        return $efforts;
    }
    
    static function getSumEfforts($args=NULL)
    {
        global $auth;
        $sum = 0.0;

        $prefix= confGet('DB_TABLE_PREFIX');
        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
        $dbh = new DB_Mysql;
        
        $project = NULL;
        $person = NULL;
        $task = NULL;
        $status = false;
        
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
        
        $str_person = $person
                    ? "AND e.person = " . $person
                    : "";
                    
        if(!is_null($task)){
            $str_task = "AND e.task = " . $task;
        }
        else{
            $str_task = "";
        }
        
        $str_status = $status
                    ? "AND e.status = ' ". asCleanString($status) . "'"
                    : "";
                                                  
        if(!is_null($project))
         {
             $query_str = "SELECT SUM(unix_timestamp(e.time_end) - unix_timestamp(e.time_start)) as sum_efforts
                           FROM {$prefix}item i, {$prefix}effort e
                           WHERE e.project = $project
                           $str_person
                           $str_task
                           $str_status
                           AND i.type = '".ITEM_EFFORT."'
                           AND e.id = i.id
                           AND i.state = '". ITEM_STATE_OK ."'"; 
            $sth = $dbh->prepare($query_str);
            $sth->execute("",1);
            $tmp = $sth->fetch_row();
            if($tmp) {
                $sum += $tmp[0];
            }
            return $sum;
        }
        
        return sum;
    }
    
    static function getEffortPeople($args=NULL)
    {
        $prefix= confGet('DB_TABLE_PREFIX');
        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
        require_once(confGet('DIR_STREBER') . 'db/class_projectperson.inc.php');
        $dbh = new DB_Mysql;
        
        $project = NULL;
        $task = NULL;
        $effort_status_min = EFFORT_STATUS_NEW;
        $effort_status_max = EFFORT_STATUS_BALANCED;
        
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
        
        $str_status_min = $effort_status_min
            ? "AND e.status >= '" . asCleanString($effort_status_min) . "'"
            : '';

        $str_status_max = $effort_status_max
            ? "AND e.status <= ' ". asCleanString($effort_status_max) . "'"
            : '';
        
        $str_task = $task
            ? "AND e.task = '" . $task ."'"
            : '';
            
        if($effort_status_min != $effort_status_max){
            $str_st = "";
        }
        else{
            $str_st = ", e.status";
        }
        
         if(!is_null($project))
         {
             $query_str = "SELECT DISTINCT e.person, e.project {$str_st}
                           FROM {$prefix}item i, {$prefix}effort e
                           WHERE e.project = {$project}
                           AND i.type = '".ITEM_EFFORT."'
                           AND e.id = i.id
                           $str_status_min
                           $str_status_max
                           $str_task
                           AND i.state = '". ITEM_STATE_OK ."';"; 
            $sth = $dbh->prepare($query_str);
            $sth->execute("",1);
            $tmp=$sth->fetchall_assoc();
            $efforts=array();
            foreach($tmp as $t) {
                $effort=new Effort($t);
                $efforts[]=$effort;
            }
            return $efforts;
        }
        
        return NULL;
    }
    
    static function getEffortTasks($args=NULL)
    {
        $prefix= confGet('DB_TABLE_PREFIX');
        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
        require_once(confGet('DIR_STREBER') . 'db/class_projectperson.inc.php');
        $dbh = new DB_Mysql;
        
        $project = NULL;
        $person = NULL;
        $effort_status_min = EFFORT_STATUS_NEW;
        $effort_status_max = EFFORT_STATUS_BALANCED;
        
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
        
        $str_status_min = $effort_status_min
            ? "AND e.status >= '" . asCleanString($effort_status_min) . "'"
            : '';

        $str_status_max = $effort_status_max
            ? "AND e.status <= ' ". asCleanString($effort_status_max) . "'"
            : '';
        
        $str_person = $person
            ? "AND e.person = '" . $person ."'"
            : '';
            
        if($effort_status_min != $effort_status_max){
            $str_st = "";
        }
        else{
            $str_st = ", e.status";
        }
        
         if(!is_null($project))
         {
             $query_str = "SELECT DISTINCT e.task, e.project {$str_st}
                           FROM {$prefix}item i, {$prefix}effort e
                           WHERE e.project = {$project}
                           AND i.type = '".ITEM_EFFORT."'
                           AND e.id = i.id
                           $str_status_min
                           $str_status_max
                           $str_person
                           AND i.state = '". ITEM_STATE_OK ."';"; 
            $sth = $dbh->prepare($query_str);
            $sth->execute("",1);
            $tmp=$sth->fetchall_assoc();
            $efforts=array();
            foreach($tmp as $t) {
                $effort=new Effort($t);
                $efforts[]=$effort;
            }
            
            return $efforts;
        }
        
        return NULL;
    }
        
    function getProject()
    {
        require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
        if(!$this->project) {
            #trigger_error("Task:getProject. project-id not set",E_USER_WARNING);
            return NULL;
        }
        $project= Project::getById($this->project);
        return $project;
    }


    function getProjectLink()
    {
        if($project= $this->getProject()) {
            return "<nobr>".$project->getLink().'</nobr>';
        }
        else {
            return NULL;
        }
    }


    function getPerson()
    {
        require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');
        if($this->person) {
            $person= Person::getById($this->person);
        }
        else {
            $person= Person::getById($this->created_by);
        }
        return $person;
    }


    function getPersonLink()
    {
        if($person= $this->getPerson()) {
            return "<nobr>".$person->getLink().'</nobr>';
        }
        else {
            return NULL;
        }
    }

    public static function getMinMaxTime($args=NULL)
    {
        global $auth;
        $prefix = confGet('DB_TABLE_PREFIX');
        $dbh = new DB_Mysql;

        ### default params ###
        $e_ids            = NULL;

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

        $effort_ids = $e_ids;

        if($effort_ids)
        {
            $str = "SELECT MIN(e.time_start), MAX(e.time_end) FROM {$prefix}effort e
                    WHERE e.id = " . intval($effort_ids[0]);

            $num = count($effort_ids);
            if($num > 1)
            {
                for($i = 1; $i < $num; $i++)
                {
                    $str .= " OR e.id = " . intval($effort_ids[$i]);
                }
            }

            $str .= ";";

            $sth= $dbh->prepare($str);
            $sth->execute("",1);
            $tmp=$sth->fetch_row();

            return $tmp;
        }
        else {
            return NULL;
        }
    }
    
    public function getLink($short_name= true)
    {

        $style_isdone= $this->status >= EFFORT_STATUS_BALANCED
                    ? 'isDone'
                    : '';

        global $PH;
        if($short_name) {
            return '<span  title="'.asHtml($this->name).'" class="item task">'.$PH->getLink('effortView',$this->getShort(),array('effort'=>$this->id),$style_isdone).'</span>';
        }
        else {
            return '<span  class="item task">'.$PH->getLink('effortView',$this->name,array('effort'=>$this->id),$style_isdone).'</span>';
        }
    }
    
    function setStatus($status=NULL)
    {
        $this->effort_status = $status;
    }
    
    function getStatus()
    {
        return $this->effort_status;
    }
        
}
Effort::initFields();

?>
