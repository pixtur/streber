<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}


require_once(confGet('DIR_STREBER') . "db/db.inc.php");
#


require_once(confGet('DIR_STREBER') . "render/render_fields.inc.php");







/**
* Field Baseclass for handling db-fields
*
* DbItems are objects representing db-elements. DbItems have fields of different types.
* Some of these field types directly refer to there counterpart in sql. Some provide additional
* layers of abstraction.
*  The Field-class tries to find special methods for rendering end convertion. Actually those
* methods (eg. XXX_renderToForm, where 'XXX' could be 'task') could be members of the derived
* classes, but refering to existing function allows to overwrite already defined classes by
* new themes.
*
* Mental note: I doubt that overwriting an existing function is easier than overwriting a class-method.
*
* @see      FieldHidden, FieldString
* @usedby   all derived DbItem-classes (task, person, etc.)
*
*/
class Field
{
    public      $type;                      #field
    public      $download   =FDOWNLOAD_ALWAYS; #loaded by default, on demand
    public      $name       ='';
    public      $title      ='';            # label used in forms
    public      $default;
    public      $tooltip    ='';
    public      $invalid;                   # current value marked as invalid (use for rerendering forms with invalid data)

    public      $func_renderToForm;            # function name for rendering the field / automatically defined
    public      $func_parseForm;            # functino name for parse entered data / automatically defined
    public      $func_renderListHead;
    public      $func_renderListRow;
    public      $func_getFormElement;
    public      $view_in_forms;             # TODO: 1-alwayys, 2-details, etc.
    public      $view_in_lists;             # do we see this field in lists?
    public      $log_changes = true;        # by default all changes are logged
    public      $export      = true;        # may be exported as csv or xml (should be false for passwords, etc)


	public      $export_csv = false;
    /**
    * constructor
    *
    * @param assoc array
    */
    public function __construct($args=NULL)
    {
        #--- set parameters ------
        if(!$args) {
        	trigger_error("Can't construct a field without name parameters", E_USER_ERROR);
        }
        foreach($args as $key=>$value) {
            empty($this->$key);     # cause php-notification if undefined property
            $this->$key= $value;
        }


        #--- try to automatically assign functions for rendering...
        if($this->view_in_forms) {
            foreach(array(
            '_renderToForm',
            '_parseForm',
            '_getFormElement'
            ) as $fn_append) {
                $fname= $this->type.$fn_append;
                $fn= 'func'.$fn_append;
                if(!$this->$fn) {
                    if(function_exists($fname)) {
                        $this->$fn= $fname;
                    }
                }
            }
        }
        if($this->view_in_lists) {
            foreach(array('_renderListHead','_renderListRow') as $fn_append) {
                $fname= $this->type.$fn_append;
                $fn= 'func'.$fn_append;
                if(!$this->$fn) {
                    if(function_exists($fname)) {
                        $this->$fn= $fname;
                    }
                }
                else {
                    trigger_error("'$fname' is not defined", E_USER_ERROR);
                }
            }
        }

        #--- some checks ---
        if(!$this->name) {
            trigger_error("Can't construct a field without name parameters",E_USER_ERROR);
            return;
        }
        if($this->download != FDOWNLOAD_ALWAYS && $this->download != FDOWNLOAD_ONDEMAND && $this->download != FDOWNLOAD_NEVER) {
            trigger_error("invalid value for download: $this->download",E_USER_ERROR);
        }

        #--- try to figure title ----
        if(!$this->title) {
            $this->title= ucwords(str_replace('_',' ',$this->name));
        }
    }

    #---------------------------------------------------------------------
    # converts a string into a valid value for database
    #---------------------------------------------------------------------
    public function value2db($value=FALSE)
    {
        return $value;
    }

    #------------------------------------------------------------------------
    # converts values from db into meaningful string-formats
    #------------------------------------------------------------------------
    public function db2value($value=FALSE)
    {
        return $value;
    }

    public function render2form(&$obj)
    {
        if(isset($this->func_renderToForm)) {
            $fn= $this->func_renderToForm;
            return $fn(&$this,&$obj);
        }
        return false;                   # TODO: add warning
    }

    public function parseForm(&$obj)
    {
        if(isset($this->func_parseForm)) {
            $fn= $this->func_parseForm;
            return $fn(&$this, &$obj);
        }
        return false;                   # TODO: add warning
    }

    /**
    * calls custom-function to return appropropriete form-element
    */
    public function getFormElement(&$obj, $title=NULL)
    {
        if(isset($this->func_getFormElement)) {
            $fn= $this->func_getFormElement;
            return $fn(&$this, &$obj, $title);
        }
        else {
            return new Form_CustomHTML('');
        }
    }
}

#================================================================================================================
class FieldHidden extends Field {
    public function __construct($args=NULL) {
        $this->type=__class__;
        $this->default= 0;
        $this->view_in_forms=true;
        parent::__construct($args);
    }
}

#================================================================================================================
class FieldInternal extends Field {
    public function __construct($args=NULL) {
        $this->type=__class__;
        $this->default= 0;
        $this->log_changes= false;
        $this->view_in_forms=false;
        $this->view_in_lists=false;
        parent::__construct($args);
    }
}

#================================================================================================================
class FieldString extends Field {
    public function __construct($args=NULL) {
        $this->default= '';
        $this->type=__class__;
        $this->view_in_forms=true;
        $this->view_in_lists=true;
        parent::__construct($args);
    }
}

#================================================================================================================
class FieldPassword extends Field {
    public function __construct($args=NULL) {
        $this->type=__class__;
        $this->default= '';
        $this->view_in_forms=true;
        $this->view_in_lists=false;
        parent::__construct($args);
    }
}

#================================================================================================================
class FieldBool extends Field {
    public function __construct($args=NULL) {
        $this->default= 0;
        $this->type=__class__;
        $this->view_in_forms=true;
        parent::__construct($args);
    }
}

#================================================================================================================
class FieldDate extends Field {
    public function __construct($args=NULL)
    {
        $this->default= '0000-00-00';
        $this->type=__class__;
        $this->view_in_forms=true;
        $this->view_in_lists=true;
        parent::__construct($args);
    }

}

#================================================================================================================
class FieldTime extends Field {
    public function __construct($args=NULL) {
        $this->type=__class__;
        $this->view_in_forms=true;
        $this->view_in_lists=true;
        parent::__construct($args);
    }
}

#================================================================================================================
class FieldPercentage extends Field {
    public function __construct($args=NULL) {
        $this->default= 0;
        $this->type=__class__;
        $this->view_in_forms=true;
        $this->view_in_lists=true;
        parent::__construct($args);
    }
}

#================================================================================================================
class FieldDatetime extends Field {
    public function __construct($args=NULL) {
        $this->default= '0000-00-00 00:00:00';
        $this->type=__class__;
        $this->view_in_forms=true;
        $this->view_in_lists=true;
        parent::__construct($args);
    }
}

#================================================================================================================
class FieldInt extends Field {
    public function __construct($args=NULL) {
        $this->default= 0;
        $this->type=__class__;
        $this->view_in_forms=true;
        $this->view_in_lists=true;
        parent::__construct($args);
    }
}

#================================================================================================================
class FieldOption extends Field {
    public $options;
    public function __construct($args=NULL) {
        $this->default= 0;
        $this->type=__class__;
        $this->view_in_forms=true;
        $this->view_in_lists=true;
        $this->options=array();
        parent::__construct($args);
    }
}

#================================================================================================================
class FieldText extends Field {
    public function __construct($args=NULL) {
        $this->default= '';
        $this->type=__class__;
        $this->view_in_forms=true;
        parent::__construct($args);
    }
}


#================================================================================================================
class FieldUser extends Field {
    public function __construct($args=NULL) {
        $this->type=__class__;
        parent::__construct($args);
    }
}

//====================================================================
// DbItem
// - handles connection of objects to database
//====================================================================
abstract class DbItem {
    public $id=-1;                 # all items need to have an id
    public $_type;              # name of table like "user", etc. Needed to be set by derived class
    public $fields;             # reference to global assoc. array of Field-Objects
    private $field_states;      # assoc. array of field-names and field states. Required for lazy loading.
    public static $fields_static;


    public function __construct($id = false)
    {
        if(!isset($this->_type)) {
            trigger_error("Constructing DbItem requires this->_type to be set", E_USER_ERROR);
        }

        #--- create members for all fields ---
        $this->field_states=array();
        foreach($this->fields as $f) {
            $this->field_states[$f->name]=FSTATE_UNKNOWN;
            $tmp_name=$f->name;

            #--- set default-values ---
            $def_value=$f->default;
            if($def_value === FINIT_NOW) {
                $def_value= getGMTString();
            }
            else if($def_value === FINIT_TODAY) {
                $def_value=gmdate("Y-m-d");
            }
            else if($def_value === FINIT_RAND_MD5) {
                 $def_value= md5(time().microtime(). rand(12312,123213). rand(234423,123213)); #@@@ those numbers don't look very nice
            }
            else if($def_value === FINIT_CUR_USER) {
                global $auth;
                if($auth->cur_user) {
                    $def_value= $auth->cur_user->id;
                }
            }
            $this->$tmp_name=$def_value;
        }

        if($id === 0) {
            return NULL;	# this is probably a failure...
        }

        if($id === false) {
          return;
        }

        #--- if id given, querry important fields from db
        $dbh = new DB_Mysql;
        $download_fields="";
        $delimiter= '';
        $fields=$this->fields;
        foreach($fields as $f) {
            if($f->download==FDOWNLOAD_ALWAYS) {
                $download_fields.= $delimiter.$f->name;
                $delimiter=',';
            }
        }
		$prefix= confGet('DB_TABLE_PREFIX');
        $query = "SELECT $download_fields from {$prefix}$this->_type WHERE id = 1";

        $data = $dbh->prepare($query)->execute($id)->fetch_assoc();
        if($data) {
            foreach( $data as $attr => $value ) {
                $this->$attr = stripslashes($value);
            }
        }
        else {
            unset($this);
            return NULL;     # returning false does not makes sense
        }
    }

    #-------------------------------------------------
    # delete
    #-------------------------------------------------
    public function deleteFull()
    {
        if(!$this->id) {
          trigger_error("Deleting requires id",E_USER_ERROR);
        }
		$prefix= confGet('DB_TABLE_PREFIX');
        $query = "DELETE FROM {$prefix}{$this->_type} WHERE id = {$this->id}";
        $dbh = new DB_Mysql;
        $dbh->prepare($query)->execute($this->id);

        #--- deleting yourself? ----
        unset($this);
        return true;
    }

    #-------------------------------------------------
    # mark_delete (sets object-state to -1)
    #-------------------------------------------------
    public function delete()
    {
        if(!$this->id) {
        	trigger_error("Deleting requires id", E_USER_ERROR);
        }
		$prefix= confGet('DB_TABLE_PREFIX');
        $query= "update {$prefix}{$this->_type} SET state=-1 WHERE id= $this->id";
        $dbh = new DB_Mysql;
        $dbh->prepare($query)->execute();

        #--- deleting yourself? ----
        unset($this);
        return true;
    }


    #-------------------------------------------------
    # update()  / write to db
    #-------------------------------------------------
    public function update($args=NULL, $update_modifier=true)
    {
        if(!$this->id) {
          trigger_error("needs id to call update()", E_USER_ERROR);
        }
        if(!isset($this->_type) || !$this->_type || $this->_type=="") {
            trigger_error("need _type to call update()", E_USER_ERROR);
        }
        if(!$args || !sizeof($args)) {
            $args=$this->field_states;
        }
        if(!sizeof($args)) {
            trigger_error("need members to update to database. e.g. 'firstname,lastname,data'", E_USER_ERROR);
        }

        #--- build query-string like "update users SET firstname=:1, lastname=:2 where id=:3" --
        #--- build value-array ----
		$prefix= confGet('DB_TABLE_PREFIX');
        $query = "UPDATE {$prefix}{$this->_type} SET  ";
        $values=array();
        $counter=1;
        $delimiter="";
        $value_str="VALUES(";

        # TODO: filter changed fields before saving to db!
        foreach($this->field_states as $m_key => $m_state) {
            if(!isset($this->$m_key) && $this->$m_key!=NULL) {
                trigger_error("$m_key is not a member of '".get_class($this)."' and can't be passed to db", E_USER_ERROR);
            }
            $values[]=  $this->$m_key;
            $query.=    $delimiter.$m_key .'=' .$counter;
            $value_str.=$delimiter." ".$counter;
            ++$counter;
            $delimiter=", ";
        }
        $query.= " WHERE id=".$counter++;
        $values[]=$this->id;

        $dbh = new DB_Mysql;
        $statement=$dbh->prepare($query);
        call_user_func_array(array($statement,'execute'),$values);
        return true;
    }



    /**
    * insert db-project item to db
    *
    * returns true on success
    */
    public function insert()
    {
        if($this->id) {
          trigger_error("User object which already has an id, can't be inserted", E_USER_ERROR);
        }
        if(!sizeof($this->field_states)) {
            trigger_error("need members to update to database. e.g. 'firstname,lastname,data'",E_USER_ERROR);
        }

        #--- build query-string like "INSERT INTO users (firstname, lastname) VALUES(:1, :2)" --
        #--- build value-array ----
		$prefix= confGet('DB_TABLE_PREFIX');
        $t_values= array();
        $t_fields= array();
        foreach($this->field_states as $m_key => $m_state) {
            if(!isset($this->$m_key) && $this->$m_key!=NULL) {
                trigger_error("$m_key is not a member of $this and can't be passed to db", E_USER_ERROR);
            }

            $t_fields[]= $m_key;
            $t_values[]="'".asSecureString($this->$m_key)."'";
        }

        $dbh = new DB_Mysql;
        #$statement=$dbh->prepare($query);
        #call_user_func_array(array($statement,'execute'),$values);

        $str_query = "INSERT INTO {$prefix}$this->_type "
                          . '(' . join(', ', $t_fields )   .')'
                    .' VALUES(' . join(', ', $t_values) .')';

        $sth= $dbh->prepare($str_query);

    	$sth->execute("",1);

         #$statement->execute($values);
        $this->id =  $dbh->lastId();
        return true;

    }

    /**
    * output a name trimmed to a certain length
    *
    * overwrite default length with optional parameter
    */
    function getShort($length = false)
    {
        if(isset($this->short) && $this->short && $this->short !="") {
            return $this->short;
        }
        if(!$length) {
            $length= confGet('STRING_LENGTH_SHORT');
        }
        if(isset($this->name) && $this->name !="") {
            ereg("(.{0,$length})(.*)",$this->name,$matches);
            if(!$matches[2]) {
                return $matches[1];
            }
            return $matches[1]."...";
        }
        else {
            return __("unnamed");
        }
    }



    /**
    * trimmed output with with full name as html-title
    */
    function getShortWithTitle()
    {
        if(isset($this->short) && $this->short && $this->short !="") {
            return "<span title='$this->name'>".asHtml($this->short)."</span>";
        }
        $length= confGet('STRING_LENGTH_SHORT');
        if(isset($this->name) && $this->name !="") {
            ereg("(.{0,$length})(.*)",asHtml($this->name),$matches);
            if(!$matches[2]) {
                return $matches[1];
            }
            return "<span title='$this->name'>".$matches[1]."...</span>";
        }
        else {
            return __("unnamed");
        }
    }



    static function getItemType($id)
	{
		$prefix= confGet('DB_TABLE_PREFIX');
        $dbh = new DB_Mysql;
        $sth= $dbh->prepare("SELECT  type FROM {$prefix}item i
            WHERE
                  i.id = $id
            " );
    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();
        return $tmp[0]['type'];
    }



	static function getItemState($id)
	{
		$prefix= confGet('DB_TABLE_PREFIX');
        $dbh = new DB_Mysql;
        $sth= $dbh->prepare("SELECT state FROM {$prefix}item i
            WHERE
                  i.id = $id
            " );
    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();
        return $tmp[0]['state'];
    }


    /**
    *
    */
	public function nowViewedByUser($user=NULL)
	{
		global $auth;

		if(is_null($user)){
			if($auth->cur_user){
				$user = $auth->cur_user;
			}
			else{
				return NULL;
			}
		}

		require_once(confGet('DIR_STREBER') . 'db/db_itemperson.inc.php');

		if($view = ItemPerson::getAll(array('person'=>$user->id, 'item'=>$this->id))){
			$view[0]->viewed        = true;
			$view[0]->viewed_last   = getGMTString();
			$view[0]->update();
		}
		else{
			$new_view = new ItemPerson(array(
			'item'          =>$this->id,
			'person'        =>$user->id,
		    'viewed'        =>1,
			'viewed_last'   =>getGMTString(),
			'is_bookmark'   =>0,
			'notify_on_change'=>0));
			$new_view->insert();
		}
	}



    /**
    * with the help of the item_person table we highlight
    * items with have been changed by other users.
    */
    public function isChangedForUser()
    {
        global $auth;

	    ### ignore, if too old
	    if($this->modified < $auth->cur_user->date_highlight_changes) {
	        return false;
	    }

	    ### ignore self edited items ###
	    if($this->modified_by == $auth->cur_user->id) {
	        return false;
	    }

	    require_once(confGet('DIR_STREBER') . 'db/db_itemperson.inc.php');
		if($item_persons = ItemPerson::getAll(array('person'=>$auth->cur_user->id,'item' => $this->id))) {
		    $ip= $item_persons[0];
		    if($ip->viewed_last < $this->modified) {
		        return true;
		    }
		    else {
		        return false;
		    }
		}
		return true;
    }

	public function nowChangedByUser()
	{
		require_once('std/mail.inc.php');
		require_once('db/db_itemperson.inc.php');
		### if notify_if_unchanges is set ###
		if ($ip = ItemPerson::getAll(array('item'=>$this->id,'notify_if_unchanged_min'=>NOTIFY_1DAY))){
			if(isset($ip)){
				$ip[0]->notify_date = date('Y-m-d H:i:s', time());
				$ip[0]->update();
			}
		}
	}




    #--- set --------------------------------------
    function __set($name, $val)
    {
       if (isset($this->$name) || isset($this->field_states[$name])) {
           $this->$name = $val;
       }
       else {
            trigger_error("can't set dbItem->$name for object of type ".get_class($this),E_USER_ERROR);
       }
    }

    #--- get --------------------------------------
    function __get($name)
    {
       if(isset($this->$name)) {
           return $this->$name;
       }
       else if(isset($this->fields[$name])) {
            trigger_error("can't read '$name' from object of type ".get_class($this),E_USER_ERROR);
       }
       else {
            trigger_error("can't read '$name' from object of type '".get_class($this)."' ",E_USER_WARNING);
       }
   }
}


global $g_item_fields;
$g_item_fields=array();
foreach(array(
            ### internal fields ###
            new FieldInternal  (array('name'=>'id',
                'default'=>0,
                'log_changes'=>false,
            )),
            new FieldInternal  (array('name'=>'type',
                'default'=>0,
                'log_changes'=>false,
            )),
            new FieldUser     (array('name'=>'created_by',
                'default'=> FINIT_CUR_USER,
                'view_in_forms'=>false,
                'log_changes'=>false,
            )),
            new FieldDatetime( array('name'=>'created',
                'default'=>FINIT_NOW,
                'view_in_forms'=>false,
                'log_changes'=>false,
            )),
            new FieldUser     (array('name'=>'modified_by',
                'default'=> FINIT_CUR_USER,
                'view_in_forms'=>false,
                'log_changes'=>false,
            )),
            new FieldDate     (array('name'=>'modified',
                'default'=>FINIT_NOW,
                'view_in_forms'=>false,
                'log_changes'=>false,
            )),
            new FieldUser     (array('name'=>'deleted_by',
                'view_in_forms'=>false,
                'log_changes'=>false,
                'default'=>0,
            )),
            new FieldDate     (array('name'=>'deleted',
                'default'=>FINIT_NEVER,
                'view_in_forms'=>false,
                'log_changes'=>false,
            )),
            new FieldInternal(array(    'name'=>'pub_level',
                'view_in_forms'=>false,
                'default'=>PUB_LEVEL_OPEN,
                'log_changes'=>true,

            )),
            new FieldInternal  (array('name'=>'state',
                'log_changes'=>true,
                'default'=>1,
            )),
            new FieldInternal  (array('name'=>'project',
                'default'=>0,
                'log_changes'=>false,
            )),

       ) as $f) {
            $g_item_fields[$f->name]=$f;
       }

function addProjectItemFields(&$ref_fields) {
    global $g_item_fields;
    foreach($g_item_fields as $f) {
        $ref_fields[$f->name]=$f;
    }
}

/**
* abstract class for project-related database-objects (tasks, project, etc. )
*
* By establishing the right-managing in the item-table we are possible to track
* all items in a project. Each of those items consists of two parts:
*  ITEM
*   - holds information common to all project-related items (id, type, date, ownership, publicity, etc)
*
*   With ITEM.id and ITEM.type we can get the REST of the items-data by looking into
*   the table of this item-type (likes TASK, PROJECT, PROJECT_PERSON, etc.)
*
*   There might be other tables, that use 'Fields' but do not refer to the almighty-
*   item-table those are directly derived from DbItem.
*
*/
class DbProjectItem extends DbItem
{

    public $fields_project;
    private $_values_org=array();
    public $children= array();

    /**
    * create empty project-item or querry database
    */
    public function __construct($id_or_array=NULL)
    {

        /**
        *  this->_type holds a string for the current type
        *  which is used for accessing db-tables and
        *  form-parameter-passing (therefore it has to be lowercase)
        */
        $this->_type=strtolower(get_class($this));


        /**
        * add default fields if not overwritten by derived class
        */
        if(!$this->fields) {
            global $g_item_fields;
            $this->fields=&$g_item_fields;
        }

        /**
        * if array is passed, create a new empty object with default-values
        */
        if(is_array($id_or_array)) {
            parent::__construct();
			foreach($id_or_array as $key => $value) {
				is_null($this->$key); ### cause E_NOTICE on undefined properties
				$this->_values_org[$key]= $this->$key=$value;
			}
        }

        /**
        * if int is passed, it's assumed to be ITEM-ID
        * - query item-tables
        * - query table with name of object-type
        */
        else if(is_int($id_or_array) || (is_string($id_or_array) and $id_or_array !== "0")){

            parent::__construct();  # call constructor to initialize members from field-array
            $id=intval($id_or_array);       # construction-param was an id
            if(!$id) {
                return;
            }

            global $g_item_fields;


            #--- try to find in item-table ---
            {
                $dbh = new DB_Mysql;
                $str_download_fields="";
                $str_delimiter= '';
                foreach($g_item_fields as $f) {
                    $str_download_fields.= $str_delimiter . $f->name;
                    $str_delimiter=',';
                }
				$prefix= confGet('DB_TABLE_PREFIX');
                $query = "SELECT $str_download_fields from {$prefix}item WHERE id = $id";
                $data = $dbh->prepare($query)->execute()->fetch_assoc();
                if($data) {
                    foreach( $data as $attr => $value ) {

                        is_null($this->$attr);   # cause E_NOTICE if member not defined
                        $this->_values_org[$attr]= $this->$attr = $value;
                    }
                }

                #--- not found in item-table ---
                else {
                    /**
                    * this might happen very often (like when searching for id)
                    */
                    #trigger_error("item id='$id' not found in table", E_USER_WARNING);
                    unset($this);                   #@@@ not sure if abort called construction like this works
                    return NULL;
                }
            }

            #--- now find the other fields in the appropriate table ---
            if($this->_type && $this->_type != 'dbprojectitem') {
                $dbh = new DB_Mysql;
                $str_download_fields="";
                $str_delimiter= '';
                foreach($this->fields as $f) {
                    #--- ignore project item fields ---
                    if(!isset($g_item_fields[$f->name])) {
                        $str_download_fields.= $str_delimiter . $f->name;
                        $str_delimiter=',';
                    }
                }
				$prefix= confGet('DB_TABLE_PREFIX');
                $query = "SELECT $str_download_fields from {$prefix}$this->_type WHERE id = $id";
                $data = $dbh->prepare($query)->execute()->fetch_assoc();
                if($data) {
                    foreach( $data as $attr => $value ) {
                        is_null($this->$attr);                                          # cause E_NOTICE if member not defined
                        #$this->_values_org[$attr]= $this->$attr = stripslashes(stripslashes(stripslashes($value))); #@@@ note this is a weird bug

                        /**
                        * @@@Pixtur: one strip slashes should be sufficient...
                        *            only tested with myslq5 / xampp
                        */
                        $this->_values_org[$attr]= $this->$attr = stripslashes($value);
                    }
                }

                #--- not found in item-table ---
                else {
                    trigger_error("item #$id not found in db-table '$this->_type'",E_USER_WARNING);
                    return NULL;
                }
            }

        }
        #--- just empty ----
        else {
            /**
            * this error might occure frequently
            */
            #trigger_error("can't construct zero-id item",E_USER_WARNING);
            parent::__construct();
            return NULL;
        }
    }


    /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id)
    {
        $i= new DbProjectItem($id);
        if($i->id) {
            return $i;
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
        if($i= DbProjectItem::getById($id)) {
            if($i->type == ITEM_PROJECT) {

                /**
                * @@@ Add visibility check here
                */
                return $i;
            }
            else if($i->type == ITEM_PERSON) {
                if($p= Person::getVisibleById($id)) {
                    return $i;
                }
                else {
                    return NULL;
                }

            }
            else if($i->type == ITEM_COMPANY) {
                require_once(confGet('DIR_STREBER') . 'db/class_company.inc.php');

                if($c= Company::getVisibleById($id)) {
                    return $i;
                }
                else {
                    return NULL;
                }

            }
            else {
                if($p= Project::getById($i->project)) {
                    if($p->validateViewItem($i)) {
                        return $i;
                    }
                }
                else {
                    trigger_error("item #$id (type= $i->type) has no project?",E_USER_WARNING);
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
        require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
        if($i= DbProjectItem::getById($id)) {
            if($p= Project::getById($i->project)) {
                if($p->validateEditItem($i)) {
                    return $i;
                }
            }
            else {
                trigger_error("issue without project?",E_USER_WARNING);
            }
        }
        return NULL;
    }


    /***************************************************************
    * insert objects to database
    */
    public function insert()
    {
        global $g_item_fields;

        if($this->id) {
          trigger_error("User object which already has an id, can't be inserted", E_USER_WARNING);
        }
        if(!sizeof($this->field_states)) {
            trigger_error("need members to update to database. e.g. 'firstname,lastname,data'", E_USER_WARNING);
        }

        /**
        * @@@ WE NEED AN AUTHORISATION-CHECK HERE @@@
        *
        * we also should lock those to into ONE transaction
        *
        *
        */

        #--- first write item-fields ---
        #
        # build query-string like "INSERT INTO users (firstname, lastname) VALUES(tom, mann)"
        #
        {
            $dbh = new DB_Mysql;

            $t_fields=array();
            $t_values=array();
            foreach($g_item_fields as $f) {
                $name= $f->name;
                if(!isset($this->$name) && $this->$name!=NULL) {
                    trigger_error("$name is not a member of $this and can't be passed to db",E_USER_WARNING);
                }
                $t_fields[]=$name;
                $t_values[]="'".asSecureString($this->$name)."'";
            }
			$prefix= confGet('DB_TABLE_PREFIX');
            $str_query= 'INSERT INTO '
                        .$prefix.'item '
                              . '(' . join(', ', $t_fields )   .')'
                        .' VALUES(' . join(', ', $t_values) .')';

            $sth= $dbh->prepare($str_query);
        	$sth->execute("",1);
        }

        #--- extract the id of last inserted item ---
        $this->id =  $dbh->lastId();

        #--- now write non item-fields ---
        #
        # build query-string like "INSERT INTO users (firstname, lastname) VALUES(tom, mann)"
        #
        {
            $dbh = new DB_Mysql;
            $t_fields=array();
            $t_values=array();

            foreach($this->fields as $f) {
                $name= $f->name;

                ### skip project-item fields ###
                if(isset($this->fields[$name]) && isset($this->fields[$name]->in_db_object) || !isset($g_item_fields[$name])) {
                    if(!isset($this->$name) && $this->$name!=NULL) {
                        trigger_error("$name is not a member of $this and can't be passed to db", E_USER_WARNING);
                    }
                    $t_fields[]=$name;
                    $t_values[]="'".asSecureString($this->$name)."'";
                }
            }
            $str_query= 'INSERT INTO '
                        .$prefix.$this->_type
                              . '(' . join(',', $t_fields  ) .')'
                        .' VALUES(' . join(',', $t_values) .')';


            $sth= $dbh->prepare($str_query);
        	$sth->execute("",1);
        }
        return true;
    }

    /***************************************************************
    * update objects in database
    */
    public function update($args=NULL, $update_modifier=true)
    {
        global $auth;
        global $g_item_fields;
        $dbh = new DB_Mysql;

        $update_fields=NULL;

        ### build hash to fast access ##
        if($args) {
            $update_fields=array();
            foreach($args as $a) {
                $update_fields[$a]=true;
            }
        }

        if(!$this->id) {
          trigger_error("User object without id can't be updated", E_USER_WARNING);
        }
        if(!sizeof($this->field_states)) {
            trigger_error("need members to update to database. e.g. 'firstname,lastname,data'", E_USER_WARNING);
        }

        /**
        * @@@ WE NEED AN AUTHORISATION-CHECK HERE @@@
        *
        * we also should lock those to into ONE transaction
        *
        *
        */
        if($update_modifier && $auth->cur_user) {
            $this->modified_by= $auth->cur_user->id;
            $this->modified=  getGMTString();
            if($update_fields) {
                $update_fields['modified_by']=true;
                $update_fields['modified']=true;
            }
        }


        $log_changed_fields= array();

        #--- first write item-fields ---
        #
        #--- build query-string like "update users SET firstname=:1, lastname=:2 where id=:3" --
        {
            $t_pairs=array();
            foreach($g_item_fields as $f) {
                $name= $f->name;
                if($update_fields && !isset($update_fields[$name])) {
                    continue;
                }
                if(isset($this->_values_org[$name])) {
                    if(!isset($this->$name) && $this->$name!=NULL) {
                        trigger_error("$name is not a member of $this and can't be passed to db", E_USER_WARNING);
                    }

                    if (  $this->_values_org[$name] == stripslashes($this->$name)) {
                        continue;
                    }
                    else if($this->fields[$name]->log_changes) {
                        $log_changed_fields[]=$name;
                    }
                }

                $t_pairs[]= $name."='".asSecureString($this->$name)."'";
            }
			$prefix= confGet('DB_TABLE_PREFIX');
			if(count($t_pairs)) {
                $str_query= 'UPDATE '
                            .$prefix.'item '
                            .'SET ' . join(', ', $t_pairs)
                            .' WHERE id='.$this->id ;

                $dbh = new DB_Mysql;

                $sth= $dbh->prepare($str_query);
            	$sth->execute("",1);
            }
        }

        #--- now write non item-fields ---
        #
        #--- build query-string like "update users SET firstname=:1, lastname=:2 where id=:3" --
        #
        if($this->_type && $this->_type != 'dbprojectitem') {

            $t_pairs=array();          # the 'id' field is skipped later, because it's defined as project-item-field. so we have to add it here
            foreach($this->fields as $f) {
                $name= $f->name;

                ### selective updates ###
                if($update_fields && !isset($update_fields[$name])) {
                    continue;
                }

                ### skip project-item fields ###
                if(
                   (   isset($this->fields[$name])
                    && isset($this->fields[$name]->in_db_object)
                   )
                   || !isset($g_item_fields[$name])
                ){
                    if(!isset($this->$name) && $this->$name!=NULL) {
                        trigger_error("$name is not a member of $this and can't be passed to db", E_USER_WARNING);
                        continue;
                    }
                    if(isset($this->_values_org[$name])) {
                        if (  $this->_values_org[$name] == stripslashes($this->$name)) {
                            continue;
                        }
                        else if($this->fields[$name]->log_changes) {
                            $log_changed_fields[]=$name;
                        }
                    }
                    global $sql_obj;
                    #$t_pairs[]= $name.'='."'".$this->$name."'";
                    #$t_pairs[]= $name.'='."'".mysql_real_escape_string($this->$name)."'";
                    $t_pairs[]= $name.'='."'". asSecureString($this->$name)."'";
                }
            }
            if(count($t_pairs)) {
                $str_query= 'UPDATE '
                            .$prefix.$this->_type
                            .' SET ' . join(', ', $t_pairs)
                            .' WHERE id='.$this->id ;

                $sth= $dbh->prepare($str_query);
                $sth->execute("",1);
            }

            if($log_changed_fields) {
                require_once(confGet('DIR_STREBER') . "db/db_itemchange.inc.php");
                foreach($log_changed_fields as $name) {

                    /**
                    * keep changes in itemchange table
                    */
                    $c= new ItemChange(array(
                        'item'=>    $this->id,
                        'field'=>   $name,
                        'value_old'=>$this->_values_org[$name],
                    ));
                    $c->insert();
                }
            }
        }
        return true;
    }

    /**
    * mark_delete (sets object-state to -1)
    */
    public function delete()
    {
        global $auth;
        if(!$this->id) {
          trigger_error("Deleting requires id", E_USER_WARNING);
        }


        ### check user-rights ###
        if($pp= $this->getProjectPerson()) {


            $pub_level=  $this->pub_level;

            ### owned ###
            if($this->created_by == $pp->person) {
                $pub_level= PUB_LEVEL_OWNED;
            }

            ### is item editable ?
            if($pub_level >= $pp->level_delete
            ) {
                ### AND below delete-level ###
                if($pub_level >= $pp->level_delete
                ) {
                    $this->state = -1;
                    $this->deleted_by= $auth->cur_user->id;
                    $this->deleted= getGMTString();

                    $this->update();

                    #--- deleting yourself? ----
                    return true;

                }
            }
        }
        ### not a project-item? ###
        #
        #@@@  be sure that rights deleting project, companies and persons is validated somewhere else
        #
        else if($this->project == 0) {

            if($auth->cur_user) {
                $this->state = -1;
                $this->deleted_by= $auth->cur_user->id;
                $this->deleted= getGMTString();

                $this->update();
                return true;
            }
            else {
                return false;
            }
        }
        return true;
    }

    /**
    * bruteforce delete from database
    *
    * this should only be used in critical situations which would
    * otherwise lead to database inconsistencies.
    */
    public function deleteFromDb()
    {
        if(!$this->id) {
          trigger_error("Deleting requires id",E_USER_ERROR);
        }
		$prefix= confGet('DB_TABLE_PREFIX');

        $query = "DELETE FROM {$prefix}{$this->_type} WHERE id = {$this->id}";
        $dbh = new DB_Mysql;
        $dbh->prepare($query)->execute($this->id);


        $query = "DELETE FROM {$prefix}item WHERE id = {$this->id}";
        $dbh = new DB_Mysql;
        $dbh->prepare($query)->execute($this->id);

        #--- deleting yourself? ----
        return true;
    }



    /**
    * return the project object the current user has to this item
    */
    public function getProjectPerson() {
        global $auth;

		$prefix= confGet('DB_TABLE_PREFIX');

        #--- get the belonging project-person ---
        $dbh = new DB_Mysql;

        $sth= $dbh->prepare(
                "SELECT i.*, upp.* from {$prefix}item i,  {$prefix}projectperson upp
                WHERE
                        upp.person = {$auth->cur_user->id}
                    AND upp.state = 1
                    AND upp.project = $this->project

                    AND i.type = '".ITEM_PROJECTPERSON."'
                    AND i.id = upp.id
                ");
    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();

        ### return nothing if no rights ###
        if(count($tmp) != 1) {
            return NULL;
        }
        require_once(confGet('DIR_STREBER') . 'db/class_projectperson.inc.php');
        $pp=new ProjectPerson($tmp[0]);
        return $pp;
    }

   /**
    * returns an assoc array with pub-levels the current user may set on a given item
    *
    * - reducing the pub_level is like deleting an item for others
    * - raising the pub_level might reveal information to outsiders
    */
    public function getValidUserSetPublevel()
    {
        global $g_pub_level_names;

        ### get belonging project person ###
        if($pp= $this->getProjectPerson()) {
            ### can we edit this object ? ###
            if(
                $pp->level_edit <= $this->pub_level
                ||
                $this->created_by == $pp->person
            ) {

                ### get max pub level ###
                $max_pub_level= $pp->level_create;

                ### get min reduce level ###
                $min_pub_level= $pp->level_reduce;

                ### get slice of assoc. array ###
                $levels= array();
                for($i= $min_pub_level; $i <= $max_pub_level; $i++) {
                    if(isset($g_pub_level_names[$i])) {
                        $levels[$i]= $g_pub_level_names[$i];
                    }
                }

                ### add current value ###
                $levels[$this->pub_level]= $g_pub_level_names[$this->pub_level];


                ### new items might by created as private ###
                if($this->id == 0) {
                    $levels[PUB_LEVEL_PRIVATE]= $g_pub_level_names[PUB_LEVEL_PRIVATE];
                }
                return array_flip($levels);
            }
        }
        return NULL;
    }



    function validateEditRequestTime($abort_on_failure= true)
    {
        global $PH;
        global $auth;

        if(!$edit_request_time= get('edit_request_time')) {
            if($abort_on_failure) {
                $PH->abortWarning("undefined edit request time", ERROR_BUG);
                exit();
            }
            else {
                return NULL;
            }
        }


        $last_modified= strToGMTime($this->modified);

        if($edit_request_time < $last_modified) {

            if($this->modified_by != $auth->cur_user->id) {

                if($abort_on_failure) {
                    require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');

                    if($person= Person::getVisibleById($this->modified_by)) {
                        $link_person= $person->getLink();
                    }
                    else {
                        $link_person= __('Unknown');
                    }

                    $time_ago = floor((time() - $last_modified) / 60)+1;
                    $PH->abortWarning(
                      sprintf(__("Item has been modified during your editing by %s (%s minutes ago). Your changes can not be submitted."), $link_person, $time_ago),
                      ERROR_NOTE
                    );
                }
                else {
                    return NULL;
                }
            }
        }
        return true;
    }



    /**
    * get list of items from database
    *
    * This function is used for getting changed items for projects or by user, etc.
    */
    static function &getAll($args=array())
    {
        global $auth;
		$prefix = confGet('DB_TABLE_PREFIX');

        ### default params ###
        $project            = NULL;
        $order_by           = "modified DESC";
        $status_min         = STATUS_UNDEFINED;
        $status_max         = STATUS_CLOSED;
        $visible_only       = true;       # use project rights settings
        $alive_only         = true;       # hide deleted
        $date_min           = NULL;
        $date_max           = NULL;
        $modified_by        = NULL;
        $not_modified_by    = NULL;
        $show_issues        = false;
        $limit              = NULL;

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

        $str_show_issues= $show_issues
            ? ''
            : 'AND i.type != '. ITEM_ISSUE;


        $str_project= $project
            ? 'AND i.project=' . intval($project)
            : '';

        $str_project2= $project
            ? 'AND upp.project='. intval($project)
            : '';

        $str_state= $alive_only
            ? 'AND i.state='. ITEM_STATE_OK
            : '';

        $str_date_min= $date_min
            ? "AND i.modified >= '" . asCleanString($date_min) . "'"
            : '';

        $str_date_max= $date_max
            ? "AND i.modified <= '" . asCleanString($date_max) . "'"
            : '';

        $str_modified_by= $modified_by
            ? 'AND i.modified_by=' . intval($modified_by)
            : '';

        $str_not_modified_by= $not_modified_by
            ? 'AND i.modified_by != ' . intval($not_modified_by)
            : '';

        $str_limit= $limit
                ? " LIMIT $limit"
                : "";

        ### only visibile for current user ###
        if($visible_only) {
            $s_query=
            "SELECT i.* from {$prefix}item i, {$prefix}projectperson upp
            WHERE
                upp.person = {$auth->cur_user->id}
                AND upp.project = i.project
                $str_state
                $str_show_issues
                $str_project
                $str_project2
                $str_modified_by
                $str_not_modified_by
                $str_date_min
                $str_date_max

                AND ( i.pub_level >= upp.level_view
                      OR
                      i.created_by = {$auth->cur_user->id}
                )

            " . getOrderByString($order_by)
            . $str_limit;
        }

        ### all including deleted ###
        else {
            $s_query=
            "SELECT i.*  from
                                {$prefix}item i
            WHERE 1

            $str_state
            $str_project
            $str_show_issues
            $str_modified_by
            $str_not_modified_by
            $str_date_min
            $str_date_max

            " . getOrderByString($order_by)
            . $str_limit;
        }
        require_once(confGet('DIR_STREBER') . 'db/class_projectperson.inc.php');


        $dbh = new DB_Mysql;

        $sth= $dbh->prepare($s_query);
    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();

    	$items= array();
        foreach($tmp as $n) {
            $item= new DbProjectItem($n);
            $items[]= $item;
        }
        return $items;
    }



/*
	static function &getChanges($args=array())
	{
		global $auth;
		$prefix = confGet('DB_TABLE_PREFIX');

        ### default params ###
        $order_by           = "modified DESC";
        $visible_only       = true;       # use project rights settings
        $alive_only         = true;       # hide deleted
        $date_min           = NULL;
        $date_max           = NULL;
		$today              = NULL;

        ### filter params ###
        if($args) {
            foreach($args as $key=>$value) {
                if(!isset($$key) && !is_null($$key) && !$$key==="") {
                    trigger_error("unknown parameter",E_USER_NOTICE);
                }
                else {
                    $$key = $value;
                }
            }
        }

		if($auth->cur_user->user_rights & RIGHT_EDITALL) {
            $visible_only = false;
        }

		$str_state = $alive_only
			? 'AND i.state = '. ITEM_STATE_OK
			: '';

		$str_today = $today
			? "AND i.modified >= '" . asCleanString($today) . "'"
			: '';

		$str_date_min = $date_min
			? "AND i.modified >= '" . asCleanString($date_min) . "'"
			: '';

		$str_date_max = $date_max
			? "AND i.modified <= '" . asCleanString($date_max) . "'"
			: '';


        ### only visibile for current user ###
        if($visible_only) {
            $s_query =
            "SELECT i.* from {$prefix}item i, {$prefix}projectperson upp
            WHERE
            upp.person = {$auth->cur_user->id}
            AND upp.project = i.project
            $str_state
			$str_today
            $str_date_min
            $str_date_max
			AND ( i.pub_level >= upp.level_view
                  OR
                  i.created_by = {$auth->cur_user->id}
                )
            " . getOrderByString($order_by);
        }
        ### all including deleted ###
        else {
            $s_query =
            "SELECT i.*  from {$prefix}item i
            WHERE 1
            $str_state
			$str_today
            $str_date_min
            $str_date_max
            " . getOrderByString($order_by);
        }

        $dbh = new DB_Mysql;

        $sth = $dbh->prepare($s_query);
    	$sth->execute("",1);
    	$tmp = $sth->fetchall_assoc();

    	$items = array();
        foreach($tmp as $n) {
            $item = new DbProjectItem($n);
            $items[] = $item;
        }
        return $items;
	}

	*/

    /**
    * returns visible object of correct type by an itemId
    *
    * this is useful, eg. if you when to access common parameters like name,
    * regardless of the object's type.
    *
    * DbProjectItem::getById() would only load to basic fields. Getting the
    * complete date required check for type.
    */
    public static function getObjectById($id)
    {
    	if(!$item = DbProjectItem::getById($id)) {
    	    return NULL;
        }

    	if($type = $item->type){
    		switch($type) {
    			case ITEM_TASK:
    				require_once("db/class_task.inc.php");
    				$item_full = Task::getVisibleById($item->id);
    				break;

    			case ITEM_COMMENT:
    				require_once("db/class_comment.inc.php");
    				$item_full = Comment::getVisibleById($item->id);
    				break;

    			case ITEM_PERSON:
    				require_once("db/class_person.inc.php");
    				$item_full = Person::getVisibleById($item->id);
    				break;

    			case ITEM_EFFORT:
    				require_once("db/class_effort.inc.php");
    				$item_full = Effort::getVisibleById($item->id);
    				break;

    			case ITEM_FILE:
    				require_once("db/class_file.inc.php");
    				$item_full = File::getVisibleById($item->id);
    				break;

    			case ITEM_PROJECT:
    				require_once("db/class_project.inc.php");
    				$item_full = Project::getVisibleById($item->id);
    				break;

    			case ITEM_COMPANY:
    				require_once("db/class_company.inc.php");
    				$item_full = Company::getVisibleById($item->id);
    				break;

    			case ITEM_VERSION:
    				require_once("db/class_task.inc.php");
    				$item_full = Task::getVisibleById($item->id);
    				break;

    			default:
    				$item_full = NULL;

    		}
    		return $item_full;
        }
    }



}




?>
