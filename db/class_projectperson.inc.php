<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
* Project Person
*/


/**
* Project Person - jointable between projects and persons
*/
class ProjectPerson extends DbProjectItem {
    public $name;
    public $project;

	/**
	* constructor
	*/
	function __construct ($id_or_array=NULL)
    {
        global $projectperson_fields;
        $this->fields= &$projectperson_fields;

        parent::__construct($id_or_array);
        $this->type=ITEM_PROJECTPERSON;
   	}

    /**
    * Init the objects fields
    */
    static function initFields()
    {
        global $projectperson_fields;
        $projectperson_fields=array();
        addProjectItemFields(&$projectperson_fields);
    
        foreach(array(
            new FieldInternal(array(    'name'=>'id',
                'default'=>0,
                'in_db_object'=>1,
                'in_db_item'=>1,
            )),
            new FieldInternal(array(    'name'=>'state',
                'default'=>1,
                'in_db_object'=>1,
                'in_db_item'=>1,
            )),
            new FieldInternal(array(    'name'=>'person',
            )),
            new FieldInternal(array(    'name'=>'project',
                'default'=>0,
                'in_db_object'=>1,
                'in_db_item'=>1,
            )),
            new FieldString(array(      'name'=>'name',
                'default'=>'member',
                'title'=>__('job'),
            )),
    
            new FieldInternal(array(    'name'=>'proj_rights',
            )),
            new FieldInternal(array(    'name'=>'level_create',
                'default'=>PUB_LEVEL_OPEN,
            )),
            new FieldInternal(array(    'name'=>'level_view',
                'default'=>PUB_LEVEL_OPEN,
            )),
            new FieldInternal(array(    'name'=>'level_edit',
                'default'=>PUB_LEVEL_OPEN,
            )),
            new FieldInternal(array(    'name'=>'level_reduce',
                'default'=>PUB_LEVEL_OPEN,
            )),
            new FieldInternal(array(    'name'=>'level_delete',
                'default'=>PUB_LEVEL_OPEN,
            )),
            /**
            * 0 - efforts logged as time_start - time_end
            * 1 - efforts looged in duration
            */
            new FieldInternal(array(    'name'=>'adjust_effort_style',
                'default'=>EFFORT_STYLE_DURATION,
            )),
    
            new FieldInternal(array(    'name'=>'role',  # this is only a cache for string-output
                'title'=>__('role'),
                'default'=>PROFILE_USER,
            )),
			new FieldString(array('name'=>'salary_per_hour',
				'title'     =>__('Salary per hour') . " " . __('in Euro'),
                'default'   =>0.0,
                'export'    =>false,
            )),
        ) as $f) {
            $projectperson_fields[$f->name]=$f;
        }
    }


    /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id)
    {
        $pp= new ProjectPerson(intval($id));
        if($pp->id) {
            return $pp;
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
        if($pp= ProjectPerson::getById($id)) {
            if($p= Project::getById($pp->project)) {
                if($p->validateViewItem($pp)) {
                    return $pp;
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
        if($pp= ProjectPerson::getById($id)) {
            if($p= Project::getById($pp->project)) {
                if($p->validateEditItem($pp)) {
                    return $pp;
                }
            }
        }
        return NULL;
    }



    /**
    * give person-object to this projectProject
    */
    public function getPerson()
    {
        return Person::getById($this->person);
    }


    /**
    * set attributes to values defined in profile-list
    */
    public function initWithUserProfile($profile_num= NULL)
    {
        global $g_user_profile_names;
        global $g_user_profiles;

        if(is_null($profile_num)) {
    	    trigger_error("initWithProfile() needes profile",E_USER_ERROR);
        }

        if(!isset($g_user_profiles[$profile_num])) {
            trigger_error("undefined profile '$profile_num'",E_USER_ERROR);
            return NULL;
        }
        $profile= $g_user_profiles[$profile_num];

        ### try to initialize standard values ###
        if(isset($profile['job_name'])) {
            $this->name= $profile['job_name'];
        }
        else {
            $this->name= $g_user_profile_names[$profile_num];
        }
        $this->role= $profile_num;


        ### build assoc array of defined class members ###
        $data=array();
        foreach(get_object_vars($this) as $key=>$value) {
            $data[$key]=true;
        }

        ### try to initialize other values if profile-attribute-name matches with pp-member ###
        foreach($profile as $key=>$value) {
            if(isset($data[$key])) {
                $this->$key= $value;
            }
        }
    }
}

ProjectPerson::initFields();


?>