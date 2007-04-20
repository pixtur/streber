<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html


/**\file
 * person object
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
global $g_cache_persons;
$g_cache_persons=array();



/**
* Persons
*/
class Person extends DbProjectItem {
    public $name;
    public $project;

    /**
    * constructor
    */
    function __construct ($id_or_array)
    {
        global $g_person_fields;
        $this->fields= &$g_person_fields;

        parent::__construct($id_or_array);
        if(!$this->type) {
            $this->type= ITEM_PERSON;
        }
    }

    /**
    * build translated fields for person class
    *
    * NOTE: This is called twice, because it might be translated AFTER a
    *       the current user has been created.
    */
    static function initFields()
    {
        global $g_person_fields;
        $g_person_fields=array();
        addProjectItemFields(&$g_person_fields);
    
        foreach(array(
            new FieldInternal(array(    'name'=>'id',
                'default'=>0,
                'in_db_object'=>1,
                'in_db_item'=>1,
                'log_changes'=>false,
    
            )),
            new FieldInternal(array(    'name'=>'state',    ### cached in project-table to speed up queries ###
                'default'=>1,
                'in_db_object'=>1,
                'in_db_item'=>1,
            )),
            new FieldString(array(      'name'=>'name',
                'title'     =>__('Full name'),
                'tooltip'   =>__('Required. Full name like (e.g. Thomas Mann)'),
                'required'=>true,
            )),
            new FieldString(array(      'name'=>'nickname',
                'title'     =>__('Nickname'),
                'tooltip'   =>__('only required if user can login (e.g. pixtur)'),
            )),
            new FieldString(array(      'name'=>'tagline',
                'title'     =>__('Tagline'),
                'tooltip'   =>__('Optional: Additional tagline (eg. multimedia concepts)'),
            )),
            new FieldString(array(      'name'=>'mobile_phone',
                'title'     =>__('Mobile Phone'),
                'tooltip'   =>__('Optional: Mobile phone (eg. +49-172-12345678)'),
            )),
    
            ### office stuff ###
            new FieldString(array(      'name'=>'office_phone',
                'title'     =>__('Office Phone'),
                'tooltip'   =>__('Optional: Office Phone (eg. +49-30-12345678)'),
            )),
            new FieldString(array(      'name'=>'office_fax',
                'title'     =>__('Office Fax'),
                'tooltip'   =>__('Optional: Office Fax (eg. +49-30-12345678)'),
            )),
            new FieldString(array(      'name'=>'office_street',
                'title'     =>__('Office Street'),
                'tooltip'   =>__('Optional: Official Street and Number (eg. Poststreet 28)'),
            )),
            new FieldString(array(      'name'=>'office_zipcode',
                'title'     =>__('Office Zipcode'),
                'tooltip'   =>__('Optional: Official Zip-Code and City (eg. 12345 Berlin)'),
            )),
            new FieldString(array(      'name'=>'office_homepage',
                'title'     =>__('Office Page'),
                'tooltip'   =>__('Optional: (eg. www.pixtur.de)'),
            )),
            new FieldString(array(      'name'=>'office_email',
                'title'     =>__('Office E-Mail'),
                'tooltip'   =>__('Optional: (eg. thomas@pixtur.de)'),
            )),
    
    
            ### personal stuff ###
            new FieldString(array(      'name'=>'personal_phone',
                'title'     =>__('Personal Phone'),
                'tooltip'   =>__('Optional: Private Phone (eg. +49-30-12345678)'),
            )),
            new FieldString(array(      'name'=>'personal_fax',
                'title'     =>__('Personal Fax'),
                'tooltip'   =>__('Optional: Private Fax (eg. +49-30-12345678)'),
            )),
            new FieldString(array(      'name'=>'personal_street',
                'title'     =>__('Personal Street'),
                'tooltip'   =>__('Optional:  Private (eg. Poststreet 28)'),
            )),
            new FieldString(array(      'name'=>'personal_zipcode',
                'title'     =>__('Personal Zipcode'),
                'tooltip'   =>__('Optional: Private (eg. 12345 Berlin)'),
            )),
            new FieldString(array(      'name'=>'personal_homepage',
                'title'     =>__('Personal Page'),
                'tooltip'   =>__('Optional: (eg. www.pixtur.de)'),
            )),
            new FieldString(array(      'name'=>'personal_email',
                'title'     =>__('Personal E-Mail'),
                'tooltip'   =>__('Optional: (eg. thomas@pixtur.de)'),
            )),
            new FieldDate(array(      'name'=>'birthdate',
                'title'     =>__('Birthdate'),
                'tooltip'   =>__('Optional')
            )),
    
            new FieldString(array(      'name'=>'color',
                'title'     =>__('Color'),
                'tooltip'   =>__('Optional: Color for graphical overviews (e.g. #FFFF00)'),
                'view_in_forms'=>false,
            )),
    
            new FieldText(array(        'name'=>'description',
                'title'     =>__('Comments'),
                'tooltip'   =>'Optional'
            )),
            new FieldPassword(array(    'name'=>'password',
                'view_in_forms'=>false,
                'title'     =>__('Password'),
                'tooltip'   =>__('Only required if user can login','tooltip'),
                'log_changes'=>false,
            )),
    
            /**
            * reservated
            */
            new FieldInternal(array(    'name'=>'security_question',
                'view_in_forms' =>false,
                'export'        =>false,
            )),
    
            new FieldInternal(array(    'name'=>'security_answer',
                'view_in_forms'=>false,
                'export'        =>false,
            )),
    
            /**
            * used for...
            * - initializing project-member-roles
            * - custimizing the interface (like hiding advance options to clients)
            */
            new FieldInternal(array(    'name'=>'profile',
                'title'         =>__('Profile'),
                'view_in_forms'=>false,
                'default'=>3,
                'log_changes'=>true,
            )),
    
            /**
            * theme
            */
            new FieldInternal(array(
                'name'          =>'theme',
                'title'         =>__('Theme','Formlabel'),
                'view_in_forms' =>false,
                'default'       => confGet('THEME_DEFAULT'),
                'log_changes'   =>true,
                'export'        =>false,
            )),
    
            /**
            * language
            */
            new FieldInternal(array(
                'name'          =>'language',
                'view_in_forms' =>false,
                'default'       => confGet('DEFAULT_LANGUAGE'),
                'log_changes'=>true,
            )),
    
            /**
            * at home show assigned only, unassigned, all open
            *
            * OBSOLETE
            */
            new FieldInternal(array(
                'name'          =>'show_tasks_at_home',
                'view_in_forms' =>false,
                'default'       => confGet('SHOW_TASKS_AT_HOME_DEFAULT'),
            )),
    
    
            /**
            * all items modified after this date will be highlighted if changed
            */
            new FieldDatetime(array(    'name'=>'date_highlight_changes',
                'view_in_forms' =>false,
                'log_changes'=>false,
                'default'   =>FINIT_NOW
            )),
    
            /**
            * flag if person has an account
            */
            new FieldInternal(array(    'name'=>'can_login',
                'view_in_forms' =>false,
                'log_changes'=>true,
            )),
    
    
            new FieldDatetime(array(    'name'=>'last_login',
                'view_in_forms' =>false,
                'log_changes'=>false,
                'default'=> FINIT_NEVER
            )),
    
            /**
            * used for highlighting modified items
            */
            new FieldDatetime(array(    'name'=>'last_logout',
                'view_in_forms' =>false,
                'log_changes'=>false,
                'default'=>FINIT_NOW,
            )),
    
            /**
            * bit-field of user-rights. See "std/auth.inc.php"
            */
            new FieldInternal(array(    'name'=>'user_rights',
                'tooltip'=>'Optional',
                'log_changes'   =>true,
                'export'        =>false,
            )),
    
            /**
            * md5 random-identifier for validating login
            */
            new FieldInternal(array(    'name'=>'cookie_string',
                'log_changes'   =>false,
                'export'        =>false,
            )),
    
            /**
            * ip-address of last valid login
            * - is checked if 'CHECK_IP_ADDRESS' is true
            */
            new FieldInternal(array(    'name'=>'ip_address',
                'log_changes'   =>false,
                'export'        =>false,
            )),
    
            /**
            * random-identifier for securitry
            *
            * - initialized on creation
            * - used for identifaction without password (like change password notification emails)
            */
            new FieldInternal(array(    'name'=>'identifier',
                'default'       =>FINIT_RAND_MD5,
                'log_changes'   =>false,
                'export'        =>false,
            )),
    
            /**
            * bit-field of misc settings
            */
            new FieldInternal(array(    'name'=>'settings',
                'default'=> (
                             USER_SETTING_HTML_MAIL
                             | USER_SETTING_NOTIFY_ASSIGNED_TO_PROJECT),
                'log_changes'   =>false,
                'export'        =>false,
    
            )),
    
            new FieldInternal(array(    'name'=>'notification_last',
                'default'       => FINIT_NEVER,
                'log_changes'   =>false,
                'export'        =>false,
            )),
    
            /**
            * notification are off by default
            */
            new FieldInternal(array(    'name'=>'notification_period',
                'default'   => 0,
                'log_changes'=>false,
            )),
    
    
            /**
            * time zone
            * - client's time zone setting.
            * - TIME_OFFSET_AUTO will use javascript to detect client's time zone
            */
            new FieldInternal(array(    'name'=>'time_zone',
                'default'   =>TIME_OFFSET_AUTO,
                'export'    =>false,
            )),
    
            /**
            * time offset in seconds
            */
            new FieldInternal(array(    'name'=>'time_offset',
                'default'   =>0,
                'export'    =>false,
            )),
    
            /**
            * reservated for non-project public-level (is not implemented / used)
            */
            new FieldInternal(array(    'name'=>'user_level_create',
                'log_changes'=>false,
                'export'        =>false,
            )),
            new FieldInternal(array(    'name'=>'user_level_view',
                'log_changes'=>false,
                'export'        =>false,
            )),
            new FieldInternal(array(    'name'=>'user_level_edit',
                'log_changes'=>false,
                'export'        =>false,
            )),
            new FieldInternal(array(    'name'=>'user_level_reduce',
                'log_changes'=>false,
                'export'        =>false,
            )),
            
            
            /* person category */
            new FieldInternal(array(    'name'=>'category',
                'view_in_forms' =>false,
                'default'       =>0,
                'log_changes'   =>true,
            )),
			new FieldString(array('name'=>'salary_per_hour',
				'title'     =>__('Salary per hour') . " " . __('in Euro'),
                'default'   =>0.0,
                'export'    =>false,
            )),
    
        ) as $f) {
            $g_person_fields[$f->name]=$f;
        }
    }


    /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id, $use_cache= true)
    {

        global $g_cache_persons;
        if($use_cache && isset($g_cache_persons[$id])) {
            $p= $g_cache_persons[$id];
        }
        else {
            $p= new Person($id);
            $g_cache_persons[$p->id]= $p;
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
    static function getVisibleById($id, $use_cache= true)
    {
        if(!is_int($id) && !is_string($id)) {
            trigger_error('Person::getVisibleById() requires int-paramter',E_USER_WARNING);
            return NULL;
        }
        global $g_cache_persons;
        if($use_cache && isset($g_cache_persons[$id])) {
            $p= $g_cache_persons[$id];
            return $p;
        }
        else {
            $p=NULL;
            $persons= Person::getPersons(array(
                'id'=>$id
            ));
            if(count($persons) == 1) {


                if($persons[0]->id) {
                    $p=$persons[0];
                    $g_cache_persons[$p->id]= $p;
                    return $p;
                }
            }
        }

        return NULL;
    }

    /**
    * query if editable for current user
    */
    static function getEditableById($id, $use_cache= false)
    {
        if(!is_int($id) && !is_string($id)) {
            trigger_error('Person::getVisibleById() requires int-paramter',E_USER_WARNING);
            return NULL;
        }
        global $auth;
        if(
            (
             $auth->cur_user->id == $id
             &&
             $auth->cur_user->user_rights & RIGHT_PERSON_EDIT_SELF
            )
            ||
            $auth->cur_user->user_rights & RIGHT_PERSON_EDIT
        ) {
            $persons= Person::getPersons(array(
                'id'=>$id
            ));
            if(count($persons) == 1) {
                if($persons[0]->id) {
                    return $persons[0];
                }
            }
        }
        return NULL;
    }


    public function getLink()
    {
        global $PH;
        if($this->nickname) {
            $out='<span title="'.$this->name.'" class="item person">'.$PH->getLink('personView',$this->nickname,array('person'=>$this->id)).'</span>';
        }
        else {
            $out='<span  title="'.$this->name.'" class="item person">'.$PH->getLink('personView',$this->getShort(),array('person'=>$this->id)).'</span>';
        }
        return $out;
    }

    /**
    * get Objects from db-query
    */
    static function &queryFromDb($query_string)
    {

        $dbh = new DB_Mysql;

        $sth= $dbh->prepare($query_string);

        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        $persons=array();
        foreach($tmp as $t) {
            $person=new Person($t);
            $persons[]=$person;
        }
        return $persons;
    }

    /**
    * getAll
    *
    * - use "has_id" to query one person if visible
    */
    #$order_by=NULL, $accounts_only=false, $has_id=NULL, $search=NULL)
    public static function &getPersons($args=NULL)
    {
        global $auth;
        $prefix = confGet('DB_TABLE_PREFIX');

        ### default params ###
        $order_by           = 'name';
        $visible_only       = 'auto';     #
        $can_login          = NULL;
        $id                 = NULL;
        $search             = NULL;
        $nickname           = NULL;
        $identifier         = NULL;
        $cookie_string      = NULL;
        $is_alive           = true;
        #$perscat            = NULL;
		$pcategory_min       = PCATEGORY_UNDEFINED;
		$pcategory_max       = PCATEGORY_PARTNER;
		
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

        if(!is_null($can_login)) {
			if($can_login == '0'){
				 $str_can_login = "AND pers.can_login = 0";
			}
			else{
				$str_can_login = "AND pers.can_login = 1";
			}
        }
        else {
            $str_can_login = '';
        }


        $str_id= $id
         ? 'AND pers.id='.intval($id)
         : '';


        $AND_match= $search
        ? "AND MATCH (pers.name,pers.nickname,pers.tagline,pers.description) AGAINST ('". asCleanString($search) ."*' IN BOOLEAN MODE)"
        : "";

        if($visible_only == 'auto') {
            $visible_only= $auth->cur_user->user_rights & RIGHT_PERSON_VIEWALL
                         ? false
                         : true;
        }


        if(is_null($is_alive)) {                            # ignore
            $str_alive= "";
        }
        else {
            $str_alive = $is_alive
                ? "AND pers.state=1"
                : "AND pers.state=-1";
        }

        /*if(is_null($perscat))
        {
            $str_perscat = "";
        }
        else
        {
            if($perscat == PCATEGORY_EMPLOYEE)
            {
                $str_perscat = "AND (pers.category BETWEEN " . PCATEGORY_STAFF . " AND " . PCATEGORY_EXEMPLOYEE . ")";
            }
            else if($perscat == PCATEGORY_CONTACT)
            {
                $str_perscat = "AND (pers.category BETWEEN " . PCATEGORY_CLIENT . " AND " . PCATEGORY_PARTNER . ")";
            }
            else
            {
                $str_perscat = "";
            }
        }*/
		
		if(!is_null($pcategory_min) && !is_null($pcategory_max)){
			$str_pcategory = "AND (pers.category BETWEEN " . $pcategory_min . " AND " . $pcategory_max . ")";
		}
		else{
			$str_pcategory = '';
		}
		
        ### all persons ###
        if(!$visible_only) {
            $str=
                "SELECT i.*, pers.* from {$prefix}person pers, {$prefix}item i
                WHERE 1
                    $str_alive
                    $str_id
                    $str_can_login
					$str_pcategory
                    AND i.id = pers.id
                    $AND_match


               ". getOrderByString($order_by);
        }

        ### only related persons ###
        else {
            $str=
                "SELECT DISTINCT pers.*, ipers.* from {$prefix}person pers, {$prefix}project p, {$prefix}projectperson upp, {$prefix}projectperson pp, {$prefix}item ipp, {$prefix}item ipers
                WHERE
                        upp.person = {$auth->cur_user->id}
                    AND upp.state = 1           /* upp all user projectpersons */
                    AND upp.project = p.id        /* all user projects */

                    AND p.state = 1
                    AND p.status > 0              /* ignore templates */
                    AND p.id = pp.project         /* all projectpersons in user's project*/

                    AND pp.state = 1
                    AND pp.id = ipp.id

                    AND ( ipp.pub_level >= upp.level_view
                          OR
                          ipp.created_by = {$auth->cur_user->id}
                    )
                    AND  pp.person = pers.id      /* all belonging person*/
                    $str_alive
                    $str_id
                    $str_can_login
					$str_pcategory
                    $AND_match
                    AND pers.id = ipers.id

               ". getOrderByString($order_by);
        }
        $persons = self::queryFromDb($str);                 # store in variable to pass by reference
		
        /**
        * be sure that the current user is listed
        * NOTE:
        * - constructing a query that insures the visibility of the current user
        *   is very complex because this does not depend on existing projects
        */
        if( !$search
            &&
            $auth && $auth->cur_user && $auth->cur_user->id
            &&
            (!$id || $id == $auth->cur_user->id)
            &&
            $is_alive !== false
            ) {

            $flag_user_found = false;
            foreach($persons as $p) {
                if($p->id == $auth->cur_user->id) {
                    $flag_user_found= true;
                    break;
                }
            }
            if(!$flag_user_found) {
                $persons[]= $auth->cur_user;
            }
        }

        return $persons;
    }

    #------------------------------------------------------------
    # get person by nickname
    #------------------------------------------------------------
    public static function getByNickname($nickname)
    {
        $prefix= confGet('DB_TABLE_PREFIX');
        $tmp=self::queryFromDb("SELECT * FROM {$prefix}person WHERE nickname='" . asCleanString($nickname) . "'");
        if(!$tmp || count($tmp)!=1) {
            return false;
        }
        return $tmp[0];
    }

    #------------------------------------------------------------
    # get person by cookie_string (md5)
    #------------------------------------------------------------
    public static function getByCookieString($f_cookie_string)
    {
        $prefix= confGet('DB_TABLE_PREFIX');


        $tmp=self::queryFromDb("SELECT * FROM {$prefix}person WHERE cookie_string='".asAlphaNumeric($f_cookie_string)."'");
        if(!$tmp || count($tmp)!=1) {
            return false;
        }
        return $tmp[0];
    }

    #------------------------------------------------------------
    # get person by identifer_string (md5)
    #------------------------------------------------------------
    public static function getByIdentifierString($f_identifier_string)
    {
        $prefix= confGet('DB_TABLE_PREFIX');

        $tmp=self::queryFromDb("SELECT * FROM {$prefix}person WHERE identifier='".asAlphaNumeric($f_identifier_string)."'");
        if(!$tmp || count($tmp)!=1) {
            return false;
        }
        return $tmp[0];
    }

    #---------------------------
    # get Employments
    #---------------------------
    function getEmployments()
    {
        $prefix = confGet('DB_TABLE_PREFIX');
        require_once(confGet('DIR_STREBER') . 'db/class_employment.inc.php');
        $dbh = new DB_Mysql;
        $sth= $dbh->prepare("
            SELECT * FROM {$prefix}employment em, {$prefix}item i
            WHERE   i.type = ".ITEM_EMPLOYMENT."
            AND     i.state = 1
            AND     i.id = em.id
            AND     em.person = \"$this->id\"
            " );
        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        $es=array();
        foreach($tmp as $t) {
            $es[]=new Employment($t);
        }
        return $es;
    }

    /**
    * get project-persons
    */
    function &getProjectPersons($f_order_by=NULL,$alive_only=true,$visible_only= true)
    {
        $prefix= confGet('DB_TABLE_PREFIX');
        global $auth;

        $AND_state= $alive_only
                    ? 'AND i.state = 1'
                    : '';


        require_once(confGet('DIR_STREBER') . 'db/class_projectperson.inc.php');
        $dbh = new DB_Mysql;

        ### ignore rights ###
        if(!$visible_only || $auth->cur_user->user_rights & RIGHT_PROJECT_ASSIGN) {
            $sth= $dbh->prepare(
                "SELECT i.*, pp.* from {$prefix}item i, {$prefix}projectperson pp
                WHERE

                        i.type = '".ITEM_PROJECTPERSON."'
                    $AND_state
                    AND i.project = pp.project

                    AND pp.person = $this->id
                    AND pp.id = i.id

                ". getOrderByString($f_order_by, "name desc")
            );

        }
        else {
            $sth= $dbh->prepare(
                "SELECT i.*, pp.* from {$prefix}item i, {$prefix}projectperson pp, {$prefix}projectperson upp
                WHERE
                        upp.person = {$auth->cur_user->id}
                    AND upp.state = 1

                    AND i.type = '".ITEM_PROJECTPERSON."'
                    $AND_state
                    AND i.project = upp.project

                    AND (
                        i.pub_level >= upp.level_view
                        OR
                        i.created_by= {$auth->cur_user->id}
                    )
                    AND pp.id = i.id
                    AND pp.person = $this->id

                ". getOrderByString($f_order_by, "name desc")
            );
        }
        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        $ppersons=array();
        foreach($tmp as $n) {
            $pperson=new ProjectPerson($n);
            $ppersons[]= $pperson;
        }
        return $ppersons;
    }

    /**
    * get Projects
    *
    * @@@ this should be refactured into Project::getProject()
    */
    public function getProjects($f_order_by=NULL, $f_status_min=STATUS_UPCOMING, $f_status_max= STATUS_COMPLETED)
    {
        global $auth;
        $prefix= confGet('DB_TABLE_PREFIX');
        $status_min= intval($f_status_min);
        $status_max= intval($f_status_max);

        ### all projects ###
        if($auth->cur_user->user_rights & RIGHT_PROJECT_ASSIGN) {
            $str=
                "SELECT p.* from {$prefix}project p, {$prefix}projectperson pp
                WHERE
                       p.status <= $status_max
                   AND p.status >= $status_min
                   AND p.state = 1

                   AND pp.person = $this->id
                   AND pp.project = p.id
                   AND pp.state=1
                ". getOrderByString($f_order_by, 'prio, name');
        }

        ### only assigned projects ###
        else {
            $str=
                "SELECT p.* from {$prefix}project p, {$prefix}projectperson upp , {$prefix}projectperson pp
                WHERE
                        upp.person = {$auth->cur_user->id}
                    AND upp.state = 1
                    AND upp.project = pp.project

                   AND pp.person = $this->id
                   AND pp.project = p.id
                   AND pp.state=1

                    AND p.id = upp.project
                    AND   p.status <= $status_max
                    AND   p.status >= $status_min
                    AND   p.state = 1

                ". getOrderByString($f_order_by, 'prio, name');
        }

        $dbh = new DB_Mysql;
        $sth= $dbh->prepare($str);
        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();

        $projects=array();
        foreach($tmp as $n_array) {
            require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
            if($n_array['id']){
                if($proj = Project::getById($n_array['id'])){
                    $projects[] = $proj;
                }
            }
        }
        return $projects;
    }

    /**
    *  get user efforts
    *
    * @@@ does NOT check for admin-rights to view all efforts
    */
    function getEfforts($f_order_by=NULL)
    {
        /*
        global $auth;
        $prefix= confGet('DB_TABLE_PREFIX');
        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');

        $dbh = new DB_Mysql;
        $sth= $dbh->prepare(
                "SELECT i.*, e.*  from {$prefix}item i, {$prefix}effort e, {$prefix}project p, {$prefix}projectperson upp
                WHERE
                        upp.person = {$auth->cur_user->id}
                    AND upp.state = 1

                    AND i.type = '".ITEM_EFFORT."'
                    AND i.state = 1
                    AND i.project = upp.project
                    AND i.created_by = $this->id
                    AND (
                        i.pub_level >= upp.level_view
                        OR
                        i.created_by= {$auth->cur_user->id}
                    )

                    AND e.id= i.id
                    AND p.id= i.project
                ". getOrderByString($f_order_by, 'time_end DESC')
        );
        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        $efforts=array();
        foreach($tmp as $t) {
            $efforts[]=new Effort($t);
        }*/
        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
        $efforts= Effort::getAll(array(
            'person'=> $this->id
        ));


        return $efforts;
    }


    /**
    * get the task-assignments for a person
    * - this is a very basic function with validation of visbibility-rights
    * - used for notification
    */
    function getTaskAssignments()
    {
        $dbh = new DB_Mysql;
        $prefix= confGet('DB_TABLE_PREFIX');

        $sth= $dbh->prepare(

        "
        SELECT  itp.*, tp.* from {$prefix}taskperson tp, {$prefix}item itp
        WHERE
                   tp.person = {$this->id}
               AND tp.id = itp.id
                       AND itp.state = 1
        ");

        $sth->execute("",1);
        $tmp=$sth->fetchall_assoc();
        $taskpersons=array();
        require_once(confGet('DIR_STREBER') . 'db/class_taskperson.inc.php');

        foreach($tmp as $tp) {
            $taskpersons[]=new TaskPerson($tp);
        }
        return $taskpersons;

    }
	
    #---------------------------
    # get Companies
    #---------------------------
    function getCompanies()
    {
        require_once(confGet('DIR_STREBER') . 'db/class_company.inc.php');
        $emps= $this->getEmployments();
        $cs=array();
        foreach($emps as $e) {
            if($e->company) {
                $c= Company::getById($e->company);
                if($c) {
                    $cs[]= $c;
                }
            }
        }
        return $cs;
    }



    function getCompanyLinks($show_max_number=3)
    {
        $cs= $this->getCompanies();
        $buffer= '';
        $sep= ', ';
        $num=0;
		$count = count($cs);
		$counter = 1;
        foreach($cs as $c) {
			if($counter == $count){
            	$sep=" ";
			}
			
            $buffer.= $c->getLink().$sep;
			
            if(++$num>$show_max_number) {
                break;
            }
			
			$counter++;
        }
        return $buffer;
    }




    /**
    * note, if we want to keep the user logged in between sessions (CHECK_IP_ADDRESS == false)
    * this function must only be used for building new Cookie-strings when logging out.
    */
    public function calcCookieString()
    {
        if(!function_exists('md5')) {
            trigger_error('md5() is not available.', E_USER_ERROR);
            return NULL;
        }
        return  md5($this->name . $this->password. md5(time().microtime(). rand(12312,123213). rand(234423,123213)));
    }



    /**
    * The identifier-string is used as token for notification-mails and password-remind mails
    * It is created out of the user-id and password. It is only recomputed, after password or
    * nickname of person has been changed.
    */
    public function calcIdentifierString()
    {
        if(!function_exists('md5')) {
            trigger_error('md5() is not available.', E_USER_ERROR);
        }
        return  md5($this->name .$this->nickname. $this->password);
    }
}

Person::initFields();

?>
