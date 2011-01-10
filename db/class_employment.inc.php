<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html



/**\file
* employments / jointable between company and person
*
* linking persons to companies is not required with work with projects. It's only
* purpose now, is to display additional information in personView and projView.
*
*
* @includedby:     *
*
* @author         Thomas Mann
* @uses:           DbProjectList
* @usedby:
*
*/




class Employment extends DbProjectItem {
    public $name;
    public $project;

    /**
    * constructor
    */
    function __construct ($id_or_array=NULL)
    {
        global $g_employment_fields;
        $this->fields= &$g_employment_fields;

        parent::__construct($id_or_array);
        if(!$this->type) {
            $this->type= ITEM_EMPLOYMENT;
        }
    }


    static function initFields()
    {
        
        global $g_employment_fields;
        $g_employment_fields=array();
        
        
        addProjectItemFields($g_employment_fields);
        
        foreach(array(
            new FieldInternal(array(    'name'=>'id',
                'default'=>0,
                'in_db_object'=>1,
                'in_db_item'=>1,
            )),
            new FieldInternal(array(    'name'=>'person',
            )),
            new FieldInternal(array(    'name'=>'company',
            )),
            new FieldString(array(      'name'=>'comment',
            )),
        ) as $f) {
            $g_employment_fields[$f->name]=$f;
        }
    }
    
     /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id)
    {
        $e= new Employment(intval($id));
        if($e->id) {
            return $e;
        }
        return NULL;
    }
    
    /**
    * query if editable for current user
    */
    static function getEditableById($id)
    {
        global $auth;
        if($auth->cur_user->user_rights & RIGHT_COMPANY_EDIT) {
            return Employment::getById(intval($id));
        }
        return NULL;
    }
}

Employment::initFields();


?>