<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html


/**\file
 * project
 *
 * @author         Thomas Mann
 */


/**
* cache some db-elements
*
* those assoc. arrays hold references to objects from database
*  like       $id => object
*
*/
global $g_cache_projects;
$g_cache_projects=array();






/**
* Project
*/
class Project extends DbProjectItem
{
    public $_visible_team=NULL;    # assoc array for optimized visibility-check
    public $project_status;
    
    //=== constructor ================================================
    function __construct ($id_or_array=NULL)
    {
        global $g_project_fields;
        $this->fields= &$g_project_fields;

        parent::__construct($id_or_array);
        $this->type= ITEM_PROJECT;
    }


    static function initFields() 
    {
            
        global $g_project_fields;
        $g_project_fields=array();
        addProjectItemFields($g_project_fields);
        
        foreach(array(
            new FieldInternal(array(    'name'=>'id',
                'default'=>0,
                'in_db_object'=>1,
                'in_db_item'=>1,
            )),
            new FieldInternal(array(    'name'=>'state',    ### cached in project-table to speed up queries ###
                'default'=>1,
                'in_db_object'=>1,
                'in_db_item'=>1,
            )),
            new FieldString(array(      'name'=>'name',
                'title'=>__('Name'),
                'required'=>true,
            )),
            new FieldString(array(      'name'=>'short',
                'title'=>__('Short'),
            )),
            new FieldString(array(      'name'=>'status_summary',
                'title'=>__('Status summary'),
            )),
            new FieldString(array(      'name'=>'color',
                'title'=>__('Color'),
            )),
            new FieldDate(array(        'name'=>'date_start',
                'title'=>__('Date start'),
                'default'=>FINIT_TODAY
            )),
            new FieldDate(array(        'name'=>'date_closed',
                'title'=>__('Date closed'),
                'default'=>FINIT_NEVER
            )),
            new FieldOption(array(      'name'=>'status',
                'title'=>__('Status'),
                'default'=>3
            )),
            new FieldString(array(      'name'=>'projectpage',
                'title'=>__('Project page'),
            )),
            new FieldString(array(      'name'=>'wikipage',
                'title'=>__('Wiki page'),
            )),
            new FieldInt(array(         'name'=>'prio',
                'title'=>__('Priority'),
                'default'=>3
            )),     # @@@ todo: default-status and prio should be project-setting!
            new FieldText(array(        'name'=>'description',
                'title'=>__('Description'),
            )),
            new FieldInt(array(         'name'=>'company',
                'title'=>__('Company'),
            )),
            new FieldBool(array(        'name'=>'show_in_home',
                'default'=>1,
                'title'=>__('show tasks in home'),
            )),
        
            /**
            * bit-field of user-rights. See "std/auth.inc.php"
            */
            new FieldInternal(array(    'name'=>'settings',
                'default'=>    confGet('PROJECT_DEFAULT_SETTINGS'),
                'log_changes'=>true,
            )),
        
        
            /**
            * labels for newly created projects
            */
            new FieldHidden(array(      'name'=>'labels',
                'default'=>  confGet("PROJECT_DEFAULT_LABELS"),
            )),
        
            new FieldInternal(array(    'name'=>'default_pub_level',    # level of new items
                'view_in_forms'=>false,
                'default'=>PUB_LEVEL_OPEN,
            )),
        ) as $f) {
            $g_project_fields[$f->name]=$f;
        }
    }

    /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id, $use_cache=false)
    {
        $id = intval($id);
        global $g_cache_projects;
        if($use_cache && isset($g_cache_projects[$id])) {
            $p= $g_cache_projects[$id];
        }
        else {
            $p= new Project($id);
            $g_cache_projects[$p->id]= $p;
        }

        if(!$p->id) {
            return NULL;
        }
        return $p;
    }



    /**
    * query if visible for current user
    *
    * - returns NULL if failed
    */
    static function getVisibleById($id, $for_person=NULL, $use_cache=true)
    {
        $id = intval($id);
        
        if(!$for_person) {
            global $auth;
            $for_person= $auth->cur_user;
        }

        if($id) {
            $p= Project::getById($id, $use_cache);
            if(!$p) {
                return NULL;
            }
            $g_cache_projects[$p->id]= $p;

            if($p && $p->validateView(
                STATUS_UPCOMING,
                STATUS_CLOSED,
                false,          #$abort_page=true
                $for_person
             )) {

                return $p;
            }
        }
        return NULL;
    }

    /**
    * query if editable for current user
    */
    static function getEditableById($id)
    {
        $id = intval($id);
        global $auth;
        if(
            $auth->cur_user->user_rights & RIGHT_PROJECT_EDIT
        ) {
            return Project::getVisibleById($id, NULL, false);
        }
        return NULL;
    }



    /**
    * get task folders
    *
    */
    function getFolders($order_by=NULL)
    {
        return $this->getTasks(array(
            'folders_only'      =>true,
            'sort_hierarchical' =>true,
            'use_collapsed'     =>false,
        ));
    }



    function getEfforts($order_by=NULL, $visible_only=true, $alive_only=true)
    {
        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
        $efforts= Effort::getAll(array(
            'project'   => $this->id
        ));
        return $efforts;
    }


    function getTaskPeople($order_by=NULL, $visible_only=true, $alive_only=true)
    {
        global $auth;
        $prefix= confGet('DB_TABLE_PREFIX');
        if(!$order_by) {
            $order_by="comment";
        }
        require_once(confGet('DIR_STREBER') . 'db/class_taskperson.inc.php');
        $dbh = new DB_Mysql;

        $str_is_alive= $alive_only
                     ? 'AND i.state='. ITEM_STATE_OK
                     : '';

        if($visible_only) {
            $str_query=
            "SELECT i.*, tp.* from {$prefix}item i, {$prefix}taskperson tp,  {$prefix}projectperson upp
            WHERE
                    upp.person = {$auth->cur_user->id}
                AND upp.project = $this->id
                AND upp.state = 1


                AND i.type = '".ITEM_TASKPERSON."'
                AND i.project = $this->id
                $str_is_alive

                AND ( i.pub_level >= upp.level_view
                      OR
                      i.created_by = {$auth->cur_user->id}
                )

                AND tp.id = i.id
            ORDER BY $order_by";
        }
        else {
            $str_query=
            "SELECT i.*, tp.* from {$prefix}item i, {$prefix}taskperson tp
            WHERE

                    i.type = '".ITEM_TASKPERSON."'
                AND i.project = $this->id
                $str_is_alive

                AND tp.id = i.id
            ORDER BY $order_by";
        }

        $sth= $dbh->prepare($str_query);
        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        $taskpeople=array();
        foreach($tmp as $t) {
            $taskpeople[]=new TaskPerson($t);
        }

        return $taskpeople;
    }


    /**
    * get Efforts sum
    */
    function getEffortsSum()
    {
        $sum=0.0;
        if($efforts= $this->getEfforts()) {
            foreach($efforts as $e) {
                $sum+= 1.0*strToGMTime($e->time_end)-1.0*strToGMTime($e->time_start);
            }
        }
        return $sum;
    }

    /**
    * get Open Efforts sum
    * sums up open and new efforts (e.I. everything that's not closed, balanced or not billable)
    */
    function getOpenEffortsSum()
    {
        $sum=0.0;
        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
            
        $efforts= Effort::getAll(array(
            'project'   => $this->id,
            'effort_status_max' => EFFORT_STATUS_OPEN
        ));
        
        foreach($efforts as $e) {
            $sum+= 1.0*strToGMTime($e->time_end)-1.0*strToGMTime($e->time_start);
        }
        
        return $sum;
    }



    function getProgressSum()
    {

        $sum=0;
        if($tasknum = $this->getNumTasks()) {
            if($tasksum = $this->getSumTasksProgress()) {
                    $sum=($tasksum/$tasknum*100)/100;
            }
        }
        return $sum;
    }



    /**
    * NOTE: actually this function is obselete. better use Task::getAll()
    *
    *
    *
    * @params
    *   show_folders=true,
    *   order_by=NULL,
    *   status_min=2,
    *   status_max=4,
    *   visible_only=true,
    *   alive_only=true,
    *   parent_task=NULL)  # if NULL parent-task is ignored
    */
    function getTasks( $args=array())
    {
        $args['project']= $this->id;
        $result= Task::getAll($args);
        return $result;
    }

    /**
    * get num of open tasks
    *
    * @@@ check for user-rights
    */
    function getNumTasks()
    {
        $prefix= confGet('DB_TABLE_PREFIX');
        $dbh = new DB_Mysql;
        $sth= $dbh->prepare("SELECT  COUNT(*) FROM {$prefix}item i, {$prefix}task t
            WHERE
                i.project = \"$this->id\"
            AND i.type=  ". ITEM_TASK . "
            AND i.state= ".  ITEM_STATE_OK . "
            AND t.is_folder = 0
            AND t.id= i.id
            AND t.status < ". STATUS_CLOSED );
        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        return $tmp[0]['COUNT(*)'];
    }

    /**
    * get num of open tasks
    *
    * @@@ check for user-rights
    */
    function getSumTasksProgress()
    {
        $prefix= confGet('DB_TABLE_PREFIX');
        $dbh = new DB_Mysql;
        $sth= $dbh->prepare("SELECT  SUM(t.completion) CSUM FROM {$prefix}item i, {$prefix}task t
            WHERE
                i.project = \"$this->id\"
            AND i.type=  ". ITEM_TASK . "
            AND i.state= ".  ITEM_STATE_OK . "
            AND t.is_folder = 0
            AND t.id= i.id
            AND t.status < ". STATUS_CLOSED );
        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        return $tmp[0]['CSUM'];
    }


    /**
    * getComments($project=false)
    * @@@ ToDo:
    * the following function should be moved to Comment-class
    */
    function getComments($args=Array())
    {
        global $auth;
        $prefix = confGet('DB_TABLE_PREFIX');

        ### default params ###
        $order_by=      'name';
        $visible_only=  true;   # use project rights settings
        $alive_only=    true;   # ignore deleted
        $on_task=       0;      # only project-tasks by default
        $limit=         NULL;   # limit number of results


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

        $str_parent_task="";
        if($on_task) {
            $str_parent_task='AND c.task='. intVal($on_task);
        }
        else {
            $str_parent_task="AND c.task=0";
        }

        $str_limit= $limit
            ? "LIMIT " . intval($limit) .",0"
            : '';


        require_once(confGet('DIR_STREBER') . 'db/class_comment.inc.php');
        $dbh = new DB_Mysql;

        $str_is_alive= $alive_only
        ? 'AND i.state=' . ITEM_STATE_OK
        : '';

        if($visible_only) {
            $str_query=
            "SELECT i.*, c.* from {$prefix}item i, {$prefix}comment c, {$prefix}projectperson upp
            WHERE
                    upp.person = {$auth->cur_user->id}
                AND upp.project = $this->id
                AND upp.state = 1

                AND i.type = '".ITEM_COMMENT."'
                AND i.project = $this->id
                $str_is_alive
                AND ( i.pub_level >= upp.level_view
                      OR
                      i.created_by = {$auth->cur_user->id}
                )

                AND c.id = i.id
                $str_parent_task

            ". getOrderByString($order_by, 'i.created') ."
            $str_limit";

        }
        else {
            $str_query=
            "SELECT i.*, c.* from {$prefix}item i, {$prefix}comment c
            WHERE
                    i.type = '".ITEM_COMMENT."'
                AND i.project = $this->id
                $str_is_alive

                AND c.id = i.id
                $str_parent_task

            ". getOrderByString($order_by, 'i.created') ."
            $str_limit";

        }

        $sth= $dbh->prepare($str_query);
        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        $comments=array();
        foreach($tmp as $n) {
            $comment=new Comment($n);
            $comments[]= $comment;
        }

        ### sort hierarchical ###
        /**
        * this is the second version for hierrachically sorting the comment tree.
        * It's working in two linear passes and a recursive roll out function.
        * For sorting this list correctly, the sorted object need to have a children-attribute.
        * Since the last recursive function is type independent, it can also be used
        * for other lists (like tasks).
        *
        * - The original flat list needs to be presorted, e.g. by creation date
        * - The hierarchy is flattened, if the parent objects are not part of the list.
        */
        $dict_id_comment=array();

        $dummy= new Comment(array(
            'id'=> 0

        ));
        $dict_id_dict=array();  # zero id item as root

        ### 1st pass: build dict for all ids ###
        foreach($comments as $c) {
            $c->children= array(1=>2);
            $dict_id_dict[$c->id] = $c;
            $dict_id_dict[$c->id]->children = array();

        }

        ### 2nd pass: build up tree structure ###
        foreach($dict_id_dict as $id=>$c) {
            if(isset($dict_id_dict[$c->comment])) {
                $dict_id_dict[$c->comment]->children[$c->id]= $c;
            }
            else {
                $dict_id_dict[0]->children[$c->id]= $c;
            }
        }

        ### 3rd pass: roll out tree
        $list=array();
        if(isset($dict_id_dict[0]->children)) {
            foreach($dict_id_dict[0]->children as $c) {
                sortObjectsRecursively($c, $list);
            }
        }
        return $list;
    }




    /**
    * getIssues($project=false)
    */
    function getIssues($order_by=NULL, $visible_only=true, $alive_only=true){

        global $auth;
        $prefix= confGet('DB_TABLE_PREFIX');


        require_once(confGet('DIR_STREBER') . 'db/class_issue.inc.php');
        $dbh = new DB_Mysql;

        $str_is_alive= $alive_only
            ? 'AND state=' . ITEM_STATE_OK
            : '';


        if($visible_only) {
            $str_query=
            "SELECT i.*, iss.* from {$prefix}item i, {$prefix}issue iss, {$prefix}projectperson upp
            WHERE
                    upp.person = {$auth->cur_user->id}
                AND upp.project = $this->id
                AND upp.state = 1

                AND i.type = '".ITEM_ISSUE."'
                AND i.project = $this->id
                $str_is_alive

                AND ( i.pub_level >= upp.level_view
                      OR
                      i.created_by = {$auth->cur_user->id}
                )

                AND iss.id = i.id

                ". getOrderByString($order_by, 'iss.id')
                ;
        }
        else {
            $str_query=
            "SELECT i.*, iss.* from {$prefix}item i, {$prefix}issue iss
            WHERE
                    i.type = '".ITEM_ISSUE."'
                AND i.project = $this->id
                $str_is_alive

                AND iss.id = i.id

                ". getOrderByString($order_by, 'iss.id')
                ;
        }


        $sth= $dbh->prepare($str_query);
        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        $issues=array();
        foreach($tmp as $n) {
            $i=new Issue($n);
            $issues[]= $i;
        }
        return $issues;
    }

    /**
    * create assoc. array of team for optimized visibilty-checks
    */
    private function getVisibleTeam() {
        $a= array();
        $people= $this->getPeople();
        foreach($people as $p) {
            if($p->id) {
                $a[floor($p->id)] = $p;
            }
        }
        return $a;
    }

    /**
    * isPersonVisibleTeamMember
    */
    function isPersonVisibleTeamMember($person_or_id) {

        /**
        * reuse cached member list?
        */
        if(!isset($this->_visible_team)) {
            $this->_visible_team= $this->getVisibleTeam();
        }
        if(is_object($person_or_id)) {
            return isset($this->_visible_team[$person_or_id->id]);
        }
        else {
            return isset($this->_visible_team[$person_or_id]);
        }
    }

    /**
    * wrapper-function for visibility-check
    *
    * - @@@ refactory here:
    *   this function does not make sense, since the
    *   visibility of a person should be be defined by it's team-member-ship
    *   but by it's visibility over all projects like it's filtered in the
    *   personList() view.
    *    But for a fast visibility-check we need sql-views, which are not
    *   supported until mySQL v5.x
    */
    function getVisiblePersonById($id) {
        $id = intval($id);
        $p=Person::getById($id);
        if($p->id && $this->isPersonVisibleTeamMember($p->id)) {
            return $p;
        }
        return NULL;
    }


    /**
    * get projectAssigments (not people but their assigments to the current project)
    *
    * @see: getPeople()
    **/
    function getProjectPeople($args=NULL)
    {
        global $auth;
        $prefix = confGet('DB_TABLE_PREFIX');

        ### default parameter ###
        $order_by=NULL;
        $alive_only=true;
        //$visible_only=true;
        $visible_only = ($auth->cur_user->user_rights & RIGHT_VIEWALL)
                        ? false
                        : true;
        $person_id = NULL;

        ### filter parameters ###
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

        $s_alive_only= $alive_only
            ? "AND i.state=1"
            : "";
        
        $s_person = $person_id
                  ? "AND person.id = " . intval($person_id)
                  : "";

        ### all users ###
        if($auth->cur_user->user_rights & RIGHT_PROJECT_ASSIGN) {
            $s_query=
            "SELECT i.*, pp.* from {$prefix}item i, {$prefix}projectperson pp, {$prefix}person person
            WHERE
                    i.type = '".ITEM_PROJECTPERSON."'
                AND i.project = $this->id
                $s_alive_only
                AND pp.id = i.id
                AND person.id = pp.person
                $s_person
                ". getOrderByString($order_by, 'person.name')
                ;
        }
        ### only visibile for current user ###
        elseif($visible_only) {
            $s_query=
            "SELECT i.*, pp.* from {$prefix}item i, {$prefix}projectperson pp, {$prefix}projectperson upp, {$prefix}person person
            WHERE
                    upp.person = {$auth->cur_user->id}
                AND upp.project = $this->id
                AND upp.state = 1

                AND i.type = '".ITEM_PROJECTPERSON."'
                AND i.project = $this->id
                $s_alive_only
                AND pp.id = i.id
                AND (
                      i.pub_level >= upp.level_view
                      OR
                      i.created_by = {$auth->cur_user->id}
                      OR
                      pp.person =  {$auth->cur_user->id}
                )
                AND person.id = pp.person
                $s_person
                ". getOrderByString($order_by, 'person.name')
                ;
        }

        ### all including deleted ###
        else {
            $s_query=
            "SELECT i.*, pp.* from {$prefix}item i, {$prefix}projectperson pp, {$prefix}person person
            WHERE
                    i.type = '".ITEM_PROJECTPERSON."'
                AND i.project = $this->id
                $s_alive_only
                AND i.id = pp.id
                AND person.id = pp.person
                $s_person
                ". getOrderByString($order_by, 'person.name')
                ;
        }
        require_once(confGet('DIR_STREBER') . 'db/class_projectperson.inc.php');

        $dbh = new DB_Mysql;

        $sth= $dbh->prepare($s_query);
        $sth->execute("",1);
        
        $tmp=$sth->fetchall_assoc();
        $ppeople=array();
        foreach($tmp as $n) {
            $pperson=new ProjectPerson($n);
            $ppeople[]= $pperson;
        }

        return $ppeople;
    }
    
    /**
    * optimized query function which only returns the names of visible project members
    * 
    * returns list as assoc. array like: ['nickname'=>'name']
    */
    function getTeamMemberNames()
    {
        global $auth;
        $prefix= confGet('DB_TABLE_PREFIX');
        require_once(confGet('DIR_STREBER') . 'db/class_taskperson.inc.php');
        $dbh = new DB_Mysql;

        ### all users ###
        if(
            ($auth->cur_user->user_rights & RIGHT_PROJECT_ASSIGN)
            ||
            ($auth->cur_user->user_rights & RIGHT_VIEWALL)
        ) {
            $str_query=
            "SELECT person.name, person.nickname from {$prefix}item i, {$prefix}projectperson pp, {$prefix}person person
            WHERE
                    i.type = '".ITEM_PROJECTPERSON."'
                AND i.project = $this->id
                AND i.state=1
                AND pp.id = i.id
                AND person.id = pp.person
                ORDER BY person.name
            "
                ;
        }
        ### only visibile for current user ###
        else{
            $str_query=
            "SELECT person.name, person.nickname from {$prefix}item i, {$prefix}projectperson pp, {$prefix}projectperson upp, {$prefix}person person
            WHERE
                    upp.person = {$auth->cur_user->id}
                AND upp.project = $this->id
                AND upp.state = 1

                AND i.type = '".ITEM_PROJECTPERSON."'
                AND i.project = $this->id
                AND i.state=1
                AND pp.id = i.id
                AND (
                      i.pub_level >= upp.level_view
                      OR
                      i.created_by = {$auth->cur_user->id}
                      OR
                      pp.person =  {$auth->cur_user->id}
                )
                AND person.id = pp.person
                ORDER BY person.name
            "
                ;
        }

        $sth= $dbh->prepare($str_query);
        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        
        $names= array();
        foreach($tmp as $t) {
            $names[$t['nickname']] = $t['name'];
        }
        return $names;
    }

    
    /**
    * get people (team)
    */
    function getPeople($visible_only=true)
    {
        $ppeople= $this->getProjectPeople(NULL, true, $visible_only);
        $people= array();
        foreach($ppeople as $pp) {
            if($p= Person::getById($pp->person)) {
                $people[]= $p;
            }
        }
        return $people;
    }




    /**
    * returns link to project-view with short name
    */
    public function getLink($show_shortname=true) {
        global $PH;
        if($show_shortname) {
            return '<span class="item project">'.$PH->getLink('projView',$this->getShort(),array('prj'=>$this->id)).'</span>';
        }
        else {
            return '<span class="item project">'.$PH->getLink('projView',$this->name,array('prj'=>$this->id)).'</span>';
        }
    }


    /**
    * getCompanyLink
    */
    function getCompanyLink($show_long=false)
    {
        global $PH;
        if(!$this->company) {
            return "";
        }
        require_once(confGet('DIR_STREBER') . 'db/class_company.inc.php');
        if($company= Company::getVisibleById($this->company)) {
            return $company->getLink($show_long);
        }
        else {
            return "-";
        }
    }

    /**
    * query project-objects from database
    */
    static function queryFromDb($query_string)
    {
        $dbh = new DB_Mysql;

        $sth= $dbh->prepare($query_string);

        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        $projects=array();
        foreach($tmp as $t) {
            $project=new Project($t);
            $projects[]=$project;
        }
        return $projects;
    }




    /**
    * get all open & Visible projects from db
    */
    public static function getAll($args=NULL)
    {
        global $auth;
        $prefix= confGet('DB_TABLE_PREFIX');


        if($args && !is_array($args)) {
            trigger_error("requires array as parameter", E_USER_WARNING);
            return;
        }

        ### default params ###
        $order_by=      "prio, name";
        $status_min=    STATUS_UNDEFINED;
        $status_max=    STATUS_OPEN;
        $company=       NULL;
        $visible_only=  ($auth->cur_user->user_rights & RIGHT_VIEWALL)
                        ? false
                        : true;
        $search=        NULL;
        $id=            NULL;
        $person=        NULL;
        $limit=         NULL;

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

        $AND_id = $id
         ? 'AND p.id=' . intval($id)
         : '';

        $AND_match= $search
        ? "AND (MATCH (p.name,p.status_summary,p.description) AGAINST ('" . asMatchString($search) . "*' IN BOOLEAN MODE))"
        : '';

        if(!is_null($company)) {
            $AND_company=  'AND p.company=' . intval($company);
        }
        else {
            $AND_company= "";
        }
        
        if(!is_null($person)){
            $AND_person_all_part1 = " {$prefix}projectperson upp, ";
            $AND_person_all_part2 = "AND upp.person = '" . intval($person) . "' 
                                     AND upp.state = 1
                                     AND upp.project = p.id";
            $AND_person_visible_part1 = " {$prefix}projectperson upp2, ";
            $AND_person_visible_part2 = "AND upp.project = upp2.project
                                         AND upp2.person = '" . intval($person) . "'" ;
        }
        else{
            $AND_person_all_part1 = "";
            $AND_person_all_part2 = "";
            $AND_person_visible_part1 = "";
            $AND_person_visible_part2 = "";
        }

        $str_limit= $limit
                ? " LIMIT ". intval($limit). " "
                : "";

        
        /**
        * @@@ NOTE: using a distinct select here is not nice...
        */
        ### only assigned projects ###
        if($visible_only) {
            $str=
                "SELECT DISTINCT i.*, p.* from {$prefix}item i, {$prefix}projectperson upp, $AND_person_visible_part1 {$prefix}project p left join {$prefix}company c on p.company = c.id
                WHERE
                    upp.person = '{$auth->cur_user->id}'
                    AND upp.state = 1
                    AND upp.project = p.id
                    $AND_person_visible_part2
                    AND   p.status <= ". intval($status_max) ."
                    AND   p.status >= ". intval($status_min) ."
                    AND   p.state = 1
                    AND   i.id = p.id
                    AND (p.company = c.id OR p.company = 0)
                    $AND_company
                    $AND_match
                    $AND_id
                ". getOrderByString($order_by) 
                . $str_limit;
        }
        ### all projects ###
        else {
            $str=
                "SELECT DISTINCT i.*, p.* from {$prefix}item i, $AND_person_all_part1 {$prefix}project p left join {$prefix}company c on p.company = c.id

                WHERE
                       p.status <= ".intval($status_max)."
                   AND p.status >= ".intval($status_min)."
                   AND p.state = 1
                   AND i.id = p.id
                   AND (p.company = 0 OR p.company = c.id)
                  $AND_company
                  $AND_match
                  $AND_id
                  $AND_person_all_part2
                ". getOrderByString($order_by)
                . $str_limit;
                
        }

        $projects = self::queryFromDb($str);
        
        return $projects;
    }
    
    /**
    * get projects from db
    */
    public static function getActive($order_by=NULL)
    {
        if($order_by && !is_string($order_by)) {
            trigger_error("requires string", E_USER_WARNING);
            return;
        }
        return self::getAll(array(
            'order_by'  => $order_by,
        ));
    }

    public static function getClosed($order_by=NULL){
        if($order_by && !is_string($order_by)) {
            trigger_error("requires string", E_USER_WARNING);
            return;
        }
        return self::getAll(array(
            'order_by'  => $order_by,
            'status_min'=> STATUS_BLOCKED,
            'status_max'=> STATUS_CLOSED,
        ));
    }
    public static function getTemplates($order_by=NULL){
        if($order_by && !is_string($order_by)) {
            trigger_error("requires string", E_USER_WARNING);
            return;
        }
        return self::getAll(array(
            'order_by'  => $order_by,
            'status_min'=> STATUS_TEMPLATE,
            'status_max'=> STATUS_TEMPLATE,
        ));
    }

    /**
    * get current project-person
    *
    * primarily used for validating project-rights
    */
    function getCurrentProjectPerson()
    {
        global $auth;
        $prefix= confGet('DB_TABLE_PREFIX');

        require_once(confGet('DIR_STREBER') . 'db/class_projectperson.inc.php');
        $dbh = new DB_Mysql;
        $sth= $dbh->prepare(
            "SELECT i.*, pp.* from {$prefix}item i, {$prefix}projectperson pp
            WHERE
                    pp.person = {$auth->cur_user->id}
                AND pp.project = $this->id
                AND pp.state = 1

                AND i.id = pp.id
                AND i.state = 1
                AND i.type = '".ITEM_PROJECTPERSON."'"

        );
        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        $ppeople=array();
        foreach($tmp as $n) {
            $pperson=new ProjectPerson($n);
            $ppeople[]= $pperson;
        }
        if(count($ppeople) >1 ){
            trigger_error("internal error: person assigned twice to project",E_USER_WARNING);

            $tmp_null=NULL;
            return $tmp_null;   # only var-refs can be returned
        }
        else if (!$ppeople) {
            /**
            * this might occur on checking project-rights
            */
            #trigger_error("internal error: person is not assigned to project",E_USER_WARNING);
            $tmp_null=NULL;
            return $tmp_null;   # only var-refs might be returned
        }
        return $ppeople[0];
    }

    /**
    * return the valid public level of new created items
    *
    * aborts page, if current user may not create something in this project
    */
    public function getCurrentLevelCreate()
    {
        global $PH;
        if(!$pp= $this->getCurrentProjectPerson()) {
            /**
            * this can happen, if admin-user tries to create something, even if not in project
            */
            $PH->abortWarning(__('only team members can create items'),ERROR_RIGHTS); ## user may never have reached this point

        }
        $new_level= $this->default_pub_level;
        if($new_level > $pp->level_create) {
            $new_level = $pp->level_create;
        }
        return $new_level;

    }

    /**
    * validate if user has sufficient rights to view a project item
    *
    * - by default returns to previous page with error
    * - if abort_on_error is false, return with "false"
    * - to check for rights to create new items, use project->getCurrentLevelCreate();
    */
    public function validateViewItem($item=NULL, $abort_on_error=false)
    {
        global $PH;
        global $auth;

        if(!$item) {
            if($abort_on_error) {
                $PH->abortWarning(__("validating invalid item"),ERROR_BUG);
                exit();
            }
            return false;
        }

        if($auth->cur_user->user_rights & RIGHT_EDITALL) {
            return true;
        }
        if($auth->cur_user->user_rights & RIGHT_VIEWALL) {
            return true;
        }

        if(!$pp= $this->getCurrentProjectPerson()) {
            if($abort_on_error) {
                $PH->abortWarning(__("insufficient rights (not in project)"),ERROR_RIGHTS);
                exit();
            }
            return false;
        }

        $l= $item->pub_level;
        if($item->created_by == $pp->person) {
            $l= PUB_LEVEL_OWNED;
        }
        # \TODO check different items-types here...
        if($l < $pp->level_view) {
            if($abort_on_error) {
                $PH->abortWarning(__("insufficient rights"),ERROR_RIGHTS);
                exit();
            }
            return false;
        }
        return true;
    }


    /**
    * validate if user has sufficient rights to edit a project items
    *
    * - by default returns to previous page with error
    * - if abort_on_error is false, return with "false"
    * - to check for rights to create new items, use project->getCurrentLevelCreate();
    *
    */
    public function validateEditItem($item=NULL, $abort_on_error=true)
    {
        global $PH;
        global $auth;

        if( isset($auth) &&  $auth->isAnonymousUser()) {
           return false;
        }
        
        if(!$item) {
            if($abort_on_error) {
                $PH->abortWarning(__("validating invalid item"),ERROR_BUG);
                exit();
            }
            return false;
        }

        if($auth->cur_user->user_rights & RIGHT_EDITALL) {
            return true;
        }

        if(!$pp= $this->getCurrentProjectPerson()) {
            if($abort_on_error) {
                $PH->abortWarning(__("insufficient rights (not in project)"),ERROR_RIGHTS);
                exit();
            }
            return false;
        }
        
        $l= $item->pub_level;
        if($item->created_by == $pp->person) {
            $l= PUB_LEVEL_OWNED;
        }

        # \TODO check different items-types here...
        if($item->id != 0 && $l < $pp->level_edit) {
            if($abort_on_error) {
                $PH->abortWarning(__("insufficient rights"),ERROR_RIGHTS);
                exit();
            }
            return false;
        }
        return true;

    }


    /**
    * validate project can be viewed
    */
    public function validateView($status_min=STATUS_UPCOMING, $status_max=STATUS_APPROVED, $abort_page=true, $for_person=NULL)
    {
        if(!$for_person) {
            global $auth;
            $for_person= $auth->cur_user;
        }
        global $PH;
        $prefix= confGet('DB_TABLE_PREFIX');

        ### all projects ###
        if($for_person->user_rights & RIGHT_VIEWALL) {
            return true;
        }

        $str=
            "SELECT p.* from {$prefix}project p, {$prefix}projectperson upp
            WHERE
                    upp.person = {$for_person->id}
                AND upp.state = 1

                AND upp.project = p.id
                AND   p.id = $this->id
                AND   p.status <= ".intval($status_max)."
                AND   p.status >= ".intval($status_min)."
                AND   p.state = 1
        ";

        $projects= self::queryFromDb($str);

        if(count($projects) == 1) {
            return true;
        }
        else if($abort_page) {
            $PH->abortWarning(__("insufficient rights"),ERROR_RIGHTS);
        }
        return NULL;
    }

    /**
    * delete together with all belonging tasks
    */
    public function delete() {

        #--- first delete all tasks ---
        foreach($this->getTasks() as $t) {
            $t->delete();
        }

        #--- delete myself ---
        return parent::delete();
    }



    /**
    * status type is displayed in page above page-title
    */
    public function getStatusType()
    {
        if($this->status == STATUS_TEMPLATE) {
            return __("Project Template");
        }
        else if ($this->status >= STATUS_COMPLETED){
            return __("Inactive Project");
        }
        else {
            return __("Project","Page Type");
        }
    }


    public function getNextMilestone()
    {
        global $auth;
        $prefix= confGet('DB_TABLE_PREFIX');

        $dbh = new DB_Mysql;
        $sth= $dbh->prepare(
            "SELECT  i.id
                 from {$prefix}item i,  {$prefix}task t
                WHERE
                        t.category = " . TCATEGORY_MILESTONE .  "
                    AND t.id= i.id
                    AND i.state = '".ITEM_STATE_OK."'
                    AND i.project= $this->id
                    AND t.status < ". STATUS_COMPLETED ."
                    ORDER BY t.name, t.id
                "
        )->execute();
        $tmp=$sth->fetchall_assoc();
        if($tmp) {
            $tmp_values=array_values($tmp[0]);
            $next_milestone= Task::getVisibleById($tmp_values[0]);
            return $next_milestone;
        }
        else {
            return false;
        }
    }
    
    function setStatus($status=NULL)
    {
        $this->project_status = $status;
    }
    
    function getStatus()
    {
        return $this->project_status;
    }



    /**
    * build list of milestones / versions for drop downselection "resolved in"
    *
    * -- undefined --
    * -- next version --
    * version 1
    * version 2
    * -- milestones ---
    * milestone 1
    * milestone 2    
    *
    * @NOTE: listing milestones here is a little bit weird, but if don't
    * editing old tasks will drop the versions that had be changed into milestones. 
    * (which would be a weird situation, though)
    */
    public function buildResolvedInList()
    {
        $tmp_resolvelist= array(
            NO_OPTION_GROUP => array(
                                '0'  =>  ('-- ' . __('undefined')   . ' --'),
                                '-1' =>  ('-- ' . __('next released version') . ' --'),
                               )
        );

        #$tmp_resolvelist= array(
        #            ('-- ' . __('undefined')             . ' --') => '0',
        #            ('-- ' . __('next released version') . ' --') => -1);
        
        $versions=Task::getAll(array(
            'category'      => TCATEGORY_VERSION,
            'project'       => $this->id,
            'status_min'    => 0,
            'status_max'    => 10,
            'order_by'      => "name",            
        ));

        $version_options= array();
        foreach($versions as $version) {
            $version_options[$version->id]= $version->name;
        }
        
        if($version_options) {
            $tmp_resolvelist[__('Versions')] = $version_options;
        }
    
        $milestone_options= array();
        if($milestones =Task::getAll(array(
            'category'      => TCATEGORY_MILESTONE,
            'project'       => $this->id,
            'status_min'    => 0,
            'status_max'    => 10,
            'order_by'      => "name",
        ))) {
            foreach($milestones as $milestone) {
                $milestone_options[$milestone->id]= $milestone->name;
            }
        }
        if($milestone_options) {
            $tmp_resolvelist[__('Milestones')] = $milestone_options;
        }
        return $tmp_resolvelist;
    }
    
    
    
    /**
    * build list of milestones / versions for drop downselection planned "for_milestone"
    *
    * -- undefined --
    * milestone 1
    * milestone 2
    * -- already released versions ---
    * version 1
    * version 2
    */
    public function buildPlannedForMilestoneList()
    {
        $tmp_milestonelist= array(
            NO_OPTION_GROUP => array('0' => '-- ' . __('undefined')   . ' --')
        );
        
        $milestone_options= array();
        $closed_milestone_options = array();

        foreach(Task::getAll(array(
            'category'      => TCATEGORY_MILESTONE,
            'project'       => $this->id,
            'status_min'    => 0,
            'status_max'    => 10,
            'order_by'      => "name",

        )) as $milestone) {
            if ($milestone->status >= STATUS_COMPLETED) {
                $closed_milestone_options[$milestone->id] = $milestone->name;            
            }
            else{
                $milestone_options[$milestone->id] = $milestone->name;            
            }

        }
        if( $milestone_options ) {
            $tmp_milestonelist[__('Milestones')] = $milestone_options;
        }
    
        if( $closed_milestone_options ) {
            $tmp_milestonelist[__('Milestones (closed)')] = $closed_milestone_options;
        }


        $version_options= array();        
        
        if($versions =Task::getAll(array(
            'category'      => TCATEGORY_VERSION,
            'project'       => $this->id,
            'status_min'    => 0,
            'status_max'    => 10,
            'order_by'      => "name",
        ))) {
            #$tmp_milestonelist[('-- ' . __('Released versions')             . ' --')] = '-2';
            foreach($versions as $version) {
                $version_options[ $version->id] = $version->name;
            }            
        }
        if( $version_options ) {
            $tmp_milestonelist[__('Versions')] = $version_options;
        }
        return $tmp_milestonelist;
    }

}

Project::initFields();


function cmp_comments($a,$b) {
    if($a->path < $b->path) {
        return -1;
    }
    else if($a->path > $b->path) {
        return 1;
    }
    return 0;
}


?>
