<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * company object
 *
 * @includedby:     *
 *
 * @author         Thomas Mann
 * @uses:           DbProjectList
 * @usedby:
 *
 */

global $g_company_fields;
$g_company_fields=array();
addProjectItemFields(&$g_company_fields);

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
    new FieldString(array(
        'name'=>'name',
        'title'=>__('Name'),
        'tooltip'=>__('Required. (e.g. pixtur ag)'),
        'log_changes'=>true,
    )),
    new FieldString(array(
        'name'=>'short',
        'title'=>__('Short','form field for company'),
        'tooltip'=>__('Optional: Short name shown in lists (eg. pixtur)'),
        'log_changes'=>true,
    )),
    new FieldString(array(
        'name'=>'tagline',
        'title'=>__('Tag line','form field for company'),
        'tooltip'=>__('Optional: Additional tagline (eg. multimedia concepts)'),
        'log_changes'=>true,
    )),
    new FieldString(array(
        'name'=>'phone',
        'title'=>__('Phone','form field for company'),
        'tooltip'=>__('Optional: Phone (eg. +49-30-12345678)'),
        'log_changes'=>true,
    )),
    new FieldString(array(
        'name'=>'fax',
        'title'=>__('Fax','form field for company'),
        'tooltip'=>__('Optional: Fax (eg. +49-30-12345678)'),
        'log_changes'=>true,
    )),
    new FieldString(array(
        'name'=>'street',
        'title'=>__('Street'),
        'tooltip'=>__('Optional: (eg. Poststreet 28)'),
        'log_changes'=>true,
    )),
    new FieldString(array(
        'name'=>'zipcode',
        'title'=>__('Zipcode'),
        'tooltip'=>__('Optional: (eg. 12345 Berlin)'),
        'log_changes'=>true,
    )),
    new FieldString(array(
        'name'=>'homepage',
        'title'=>__('Website'),
        'tooltip'=>__('Optional: (eg. http://www.pixtur.de)'),
        'log_changes'=>true,
    )),
    new FieldString(array(
        'name'=>'intranet',
        'title'=>__('Intranet'),
        'tooltip'=>__('Optional: (eg. http://www.pixtur.de/login.php?name=someone)'),
        'log_changes'=>true,
    )),
    new FieldString(array(
        'name'=>'email',
        'title'=>__('E-Mail'),
        'tooltip'=>__('Optional: (eg. http://www.pixtur.de/login.php?name=someone)'),
        'log_changes'=>true,
    )),
    new FieldText(array(
        'name'=>'comments',
        'title'=>__('Comments','form label for company'),
        'tooltip'=>__('Optional'),
        'log_changes'=>true,
    )),
	### company category ###
	new FieldInternal(array(
		'name'=>'category',
		'view_in_forms' =>false,
		'default'=>0,
		'log_changes'=>true,
	)),
) as $f) {
    $g_company_fields[$f->name]=$f;
}





class Company extends DbProjectItem
{

	//=== constructor ================================================
	function __construct ($id_or_array=NULL)
    {
        global $g_company_fields;
        $this->fields= &$g_company_fields;

        parent::__construct($id_or_array);
        if(!$this->type) {
            $this->type= ITEM_COMPANY;
        }
   	}

    #------------------------------------------------------------
    # returns link to company-view with short name
    #------------------------------------------------------------
    public function getLink($show_long=false)
    {
        global $PH;
        if($show_long) {
            $out='<span class="item company">'. $PH->getLink('companyView',$this->name,array('company'=>$this->id)).'</span>';
        }
        else {
            $out='<span class="item company">'. $PH->getLink('companyView',$this->getShortWithTitle(),array('company'=>$this->id),'item company',true).'</span>';
        }
        return $out;
    }


    /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id)
    {
        $c= new Company(intval($id));
        if($c->id) {
            return $c;
        }
        return NULL;
    }


    /**
    * query if visible for current user
    *
    * - returns NULL if failed
    * - this function is a double of validateView. Fix this
    */
    static function getVisibleById($id)
    {

        $companies= Company::getAll(array(
				    'order_str'=>NULL,
					'has_id'=>intval($id)));

        if(count($companies) == 1) {
            if($companies[0]->id) {
                return $companies[0];
            }
        }
        return NULL;
    }

    /**
    * query if editable for current user
    */
    static function getEditableById($id)
    {
        global $auth;
    	if(
    		$auth->cur_user->user_rights & RIGHT_COMPANY_EDIT
    	) {
            return Company::getById(intval($id));
        }
        return NULL;
    }


    static function &queryFromDb($query_string)
	{
        $dbh = new DB_Mysql;

        $sth= $dbh->prepare($query_string);

    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();
    	$companies=array();
        foreach($tmp as $t) {
            $company=new Company($t);
            $companies[]=$company;
        }
        return $companies;
    }


    #------------------------------------------------------------
    # get companies from db --> old function
    #------------------------------------------------------------
    /*public static function &getAll($order_str=NULL, $has_id=NULL, $search=NULL)
    {
        global $auth;
		$prefix = confGet('DB_TABLE_PREFIX');

        $has_id= intval($has_id);

        $str_has_id= $has_id
                ? ('AND c.id='.intval($has_id))
                : '';

        if($search) {
            $search= asMatchString($search);
            $AND_match= "AND (MATCH (c.name) AGAINST ('".asCleanString($search). "*') or MATCH (c.comments) AGAINST ('".asCleanString($search)."*'  IN BOOLEAN MODE))";
        }
        else {
            $AND_match= '';
        }

        ### show all ###
        if($auth->cur_user->user_rights & RIGHT_VIEWALL) {
            $str=
                "SELECT c.*, ic.* from {$prefix}company c, {$prefix}item ic
                WHERE
                      c.state = 1
                      $str_has_id
                      AND c.id = ic.id
                      $AND_match"
                . getOrderByString($order_str, 'c.name');
        }

        ### only related companies ###
        else {
               $str= "SELECT DISTINCT c.*, ic.* from {$prefix}company c, {$prefix}project p, {$prefix}projectperson upp, {$prefix}item ic
                 WHERE
                        upp.person = {$auth->cur_user->id}
                    AND upp.state = 1   /*      /* upp all user projectpersons */

                    /*AND  upp.project = p.id*/  /* all user projects */
                     /*AND  p.company = c.id*/    /* all companies */
                      /* AND  c.state = 1
                       $str_has_id
                         AND c.id = ic.id


                      $AND_match

                ". getOrderByString($order_str, 'c.name');
        }
  	    $companies = self::queryFromDb($str);               # store in variable to return by reference
  	    return $companies;
    }*/

	#------------------------------------------------------------
    # get specific companies from db
    #------------------------------------------------------------
	public static function &getAll($args=NULL)
	{
		global $auth;
		$prefix = confGet('DB_TABLE_PREFIX');

		### default parameter ###
		$order_str=NULL;
		$has_id=NULL;
		$search=NULL;
		$visible_only = NULL;
		#$comcat=NULL;
		$ccategory_min = CCATEGORY_UNDEFINED;
		$ccategory_max = CCATEGORY_PARTNER;

		### filter parameter ###
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

		$str_has_id= $has_id
                ? ('AND c.id='.intval($has_id))
                : '';

        if($search) {
            $search= asMatchString($search);
            $AND_match= "AND (MATCH (c.name) AGAINST ('".asCleanString($search). "*') or MATCH (c.comments) AGAINST ('".asCleanString($search)."*'  IN BOOLEAN MODE))";
        }
        else {
            $AND_match= '';
        }

		/*if(is_null($comcat))
		{
			$str_comcat = '';
		}
		else
		{
			$str_comcat = 'AND c.category=' .intval($comcat);
		}*/
		
		if(!is_null($ccategory_min) && !is_null($ccategory_max)){
			$str_ccategory = "AND (c.category BETWEEN " . $ccategory_min . " AND " . $ccategory_max . ")";
		}
		else{
			$str_ccategory = '';
		}

		### show all ###
        if($auth->cur_user->user_rights & RIGHT_COMPANY_VIEWALL) {
            $str=
                "SELECT c.*, ic.* from {$prefix}company c, {$prefix}item ic
                WHERE
                      c.state = 1
                      $str_has_id
                      AND c.id = ic.id
                      $AND_match
					  $str_ccategory "
                . getOrderByString($order_str, 'c.name');
        }

        ### only related companies ###
        else {
               $str= "SELECT DISTINCT c.*, ic.* from {$prefix}company c, {$prefix}project p, {$prefix}projectperson upp, {$prefix}item ic
                 WHERE
                        upp.person = {$auth->cur_user->id}
                    AND upp.state = 1         /* upp all user projectpersons */

                    AND  upp.project = p.id  /* all user projects */
                       AND  p.company = c.id    /* all companies */
                       AND  c.state = 1
                       $str_has_id
                         AND c.id = ic.id


                      $AND_match
					  $str_ccategory "
                . getOrderByString($order_str, 'c.name');
        }


  	    $companies = self::queryFromDb($str);               # store in variable to return by reference
  	   
		return $companies;

	}

	/*public static function &getCompanies($order_str=NULL, $has_id=NULL, $search=NULL, $comcat=NULL)
    {
        global $auth;
		$prefix = confGet('DB_TABLE_PREFIX');

        $has_id= intval($has_id);

        $str_has_id= $has_id
                ? ('AND c.id='.intval($has_id))
                : '';

        if($search) {
            $search= asMatchString($search);
            $AND_match= "AND (MATCH (c.name) AGAINST ('".asCleanString($search). "*') or MATCH (c.comments) AGAINST ('".asCleanString($search)."*'  IN BOOLEAN MODE))";
        }
        else {
            $AND_match= '';
        }

		if(is_null($comcat))
		{
			$str_comcat = '';
		}
		else
		{
			$str_comcat = 'AND c.category=' .intval($comcat);
		}

        ### show all ###
        if($auth->cur_user->user_rights & RIGHT_VIEWALL) {
            $str=
                "SELECT c.*, ic.* from {$prefix}company c, {$prefix}item ic
                WHERE
                      c.state = 1
                      $str_has_id
                      AND c.id = ic.id
                      $AND_match
					  $str_comcat "
                . getOrderByString($order_str, 'c.name');
        }

        ### only related companies ###
        else {
               $str= "SELECT DISTINCT c.*, ic.* from {$prefix}company c, {$prefix}project p, {$prefix}projectperson upp, {$prefix}item ic
                 WHERE
                        upp.person = {$auth->cur_user->id}
                    AND upp.state = 1   */      /*upp all user projectpersons */

                    /*AND  upp.project = p.id*/  /* all user projects */
                    /*   AND  p.company = c.id*/    /* all companies */
                    /*   AND  c.state = 1
                       $str_has_id
                         AND c.id = ic.id


                      $AND_match
					  $str_comcat "
                . getOrderByString($order_str, 'c.name');
        }


  	    $companies = self::queryFromDb($str);               # store in variable to return by reference
  	    return $companies;
    }*/

    #---------------------------
    # get nume tasks
    #---------------------------
    function getNumOpenProjects()
	{
		$prefix= confGet('DB_TABLE_PREFIX');
        $dbh = new DB_Mysql;
        $AND_status_min= "AND status >= ".STATUS_NEW;
        $AND_status_max= "AND status <= ".STATUS_OPEN;
        $sth= $dbh->prepare("
            SELECT
            COUNT(*)
            FROM {$prefix}project
            WHERE company = \"$this->id\"
              AND state=1
              $AND_status_min
              $AND_status_max
              "

              );
    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();
        return $tmp[0]['COUNT(*)'];
    }

    #---------------------------
    # get projects of company
    #---------------------------
    function getProjects($f_order_by=NULL, $f_status_min=1, $f_status_max=4)
    {
        global $auth;
		$prefix= confGet('DB_TABLE_PREFIX');

        $status_min= intval($f_status_min);
        $status_max= intval($f_status_max);

       #"SELECT * FROM {$prefix}project WHERE company = \"$this->id\" AND state=1 ORDER BY name"

        ### all projects ###
        if($auth->cur_user->user_rights & RIGHT_PROJECT_ASSIGN) {
            $str=
                "SELECT p.* from {$prefix}project p
                WHERE
                       p.status <= $status_max
                   AND p.status >= $status_min
                   AND p.company =  $this->id
                   AND p.state = 1

                ". getOrderByString($f_order_by,'name');
        }

        ### only assigned projects ###
        else {
            $str=
                "SELECT p.* from {$prefix}project p, {$prefix}projectperson upp
                WHERE
                        upp.person = {$auth->cur_user->id}
                    AND upp.state = 1       /* all projectpersons of user */


                    AND   p.id  = upp.project       /* all projects of user */
                    AND   p.company = $this->id     /* all project of this company */
                    AND   p.status <= $status_max
                    AND   p.status >= $status_min
                    AND   p.state = 1

                ". getOrderByString($f_order_by, 'name');
        }

        $dbh = new DB_Mysql;
        $sth= $dbh->prepare($str);


    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();
        $projects=array();
        foreach($tmp as $t) {
            $projects[]=new Project($t);
        }
        return $projects;
    }

    #---------------------------
    # get Employments
    #---------------------------
    function getEmployments()
    {
		$prefix= confGet('DB_TABLE_PREFIX');
        require_once(confGet('DIR_STREBER') . 'db/class_employment.inc.php');

        $dbh = new DB_Mysql;
        $sth= $dbh->prepare(
            "SELECT em.* FROM {$prefix}employment em, {$prefix}item i
              WHERE  i.type= ".ITEM_EMPLOYMENT."
              AND    i.state=1
              AND   i.id = em.id
              AND   em.company = $this->id
              "
        );
    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();
        $es=array();
        foreach($tmp as $t) {
            $es[]=new Employment($t);
        }
        return $es;
    }

    /**
    * get Persons working for company
    *
    * @@@ visibilities-validation is REALLY slow
    */
    function getPersons()
    {
		$prefix= confGet('DB_TABLE_PREFIX');
        require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');
        require_once(confGet('DIR_STREBER') . 'db/class_employment.inc.php');
        $dbh = new DB_Mysql;
        $sth= $dbh->prepare(
						"SELECT p.* FROM {$prefix}person p,{$prefix}employment em, {$prefix}item i
						WHERE   i.type= ".ITEM_EMPLOYMENT."
						AND     i.state=1
						AND     i.id= em.id
						AND     em.company = \"$this->id\"
						AND     em.person= p.id
						AND     p.state=1"
		);
		
    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();
        $es=array();

        foreach($tmp as $t) {
            if($person = Person::getVisibleById($t['id'])) {
               $es[]=$person;
            }
        }
		
        return $es;
    }



    #---------------------------
    # get PersonLinks
    #---------------------------
    function getPersonLinks($show_max_number=3)
    {
        $ps= $this->getPersons();
        $buffer= '';
        $sep= '';
        $num=0;
        foreach($ps as $p) {
            $buffer.= $sep.$p->getLink();
            if(++$num > $show_max_number) {
                break;
            }
            $sep=", ";
        }
        return $buffer;
    }

    #---------------------------
    # is company visible to user?
    #---------------------------
    function validateView()
    {
        global $auth;
        global $PH;
		$prefix= confGet('DB_TABLE_PREFIX');

        ### all ###
        if($auth->cur_user->user_rights & RIGHT_VIEWALL) {
            return true;
        }
        
        ### all companies ###
        if($auth->cur_user->user_rights & RIGHT_COMPANY_VIEWALL) {
            return true;
        }


           $str= "SELECT COUNT(*) from {$prefix}company c, {$prefix}project p, {$prefix}projectperson upp
             WHERE
                    upp.person = {$auth->cur_user->id}
                AND upp.state = 1         /* upp all user projectpersons */

                AND  p.id = upp.project   /* all user projects */
                AND  c.id = p.company     /* all companies */
                AND  c.id = $this->id
                AND  c.state = 1
            ";

        $dbh = new DB_Mysql;
        $sth= $dbh->prepare($str);
    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();

        $count= $tmp[0]['COUNT(*)'];

        if($count == 1) {
            return true;
        }
        else if($count > 1) {
            $PH->abortWarning(__("not available"),ERROR_RIGHTS);
        }
        else{
            $PH->abortWarning(__("not available"),ERROR_RIGHTS);
        }
    }




}




?>
