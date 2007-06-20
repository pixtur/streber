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

    public      $func_renderToForm;         # function name for rendering the field / automatically defined
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
        #$this->valid_condition_types=array('=', '<', '');
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


?>