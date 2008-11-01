<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt


/**
* \file  pages related to comments  
* 
* itemperson is a join table between each person and all other items. This
* table can be used for listing, how often a page is been used by whom.
* It is also used for handling bookmarks and notification on items.
*
**/

require_once ("db/db.inc.php");


global $g_itemperson_fields;
$g_itemperson_fields=array();
foreach(array(
            ### internal fields ###
            new FieldInternal(array('name'=>'id',
                'default'=>0,
            )),
            new FieldInternal(array('name'=>'person',
                'default'=>0,
            )),
            new FieldInternal(array('name'=>'item',
                'default'=>0,
            )),
            new FieldInternal(array('name'=>'viewed',
                'view_in_forms'=>false,
            )),
            new FieldDatetime(array('name'=>'viewed_last',
                'default'=>FINIT_NEVER,
                'view_in_forms'=>false,
            )),
            new FieldInternal(array('name'=>'view_count',
                'view_in_forms'=>false,
                'default'       => 1,
            )),
            new FieldInternal(array('name'=>'is_bookmark',
                'default'=>0,
                'view_in_forms'=>false,
            )),
            new FieldInternal(array('name'=>'notify_on_change',
                'default'=>0,
                'view_in_forms'=>false,
            )),
            new FieldInternal(array('name'=>'notify_if_unchanged',  # time
                'default'=>0,
                'view_in_forms'=>false,
            )),
            new FieldText(array(
                'name'=>'comment',
                'title'=>__('Comment','form label for items'),
                'tooltip'=>__('Optional'),
                'log_changes'=>true,
            )),
            new FieldDatetime(array('name'=>'notify_date',
                'default'=>FINIT_NEVER,
                'view_in_forms'=>false,
            )),
            new FieldDatetime(array('name'=>'created',
                'default'=>FINIT_NEVER,
                'view_in_forms'=>false,
            )),
            new FieldInternal(array('name'=>'feedback_requested_by',
                'default'=>0,
                'view_in_forms'=>false,
            )),
       ) as $f) {
            $g_itemperson_fields[$f->name]=$f;
       }

class ItemPerson extends DbItem
{

    public $fields_itemperson;
    private $_values_org = array();
    public $children = array();

    public function __construct($id_or_array=NULL)
    {
        global $g_itemperson_fields;
        $this->fields = &$g_itemperson_fields;
        /**
        *  this->_type holds a string for the current type
        *  which is used for accessing db-tables and
        *  form-parameter-passing (therefore it has to be lowercase)
        */
        $this->_type = strtolower(get_class($this));

        /**
        * add default fields if not overwritten by derived class
        */
        if(!$this->fields) {
            global $g_itemperson_fields;
            $this->fields = &$g_itemperson_fields;
        }

        /**
        * if array is passed, create a new empty object with default-values
        */
        parent::__construct();

        if(is_array($id_or_array)) {
            parent::__construct();
            foreach($id_or_array as $key => $value) {
                is_null($this->$key); ### cause E_NOTICE on undefined properties
                $this->$key=$value;
            }
        }

        /**
        * if int is passed, it's assumed to be ITEM-ID
        * - query item-tables
        * - query table with name of object-type
        */
        else if(is_int($id_or_array)) {
            parent::__construct($id_or_array);
        }
        #--- just empty ----
        else {
            trigger_error("can't construct zero-id item",E_USER_WARNING);
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
        $i = new ItemPerson( intval($id));
        if($i->id) {
            return $i;
        }
        return NULL;
    }

    function getItemModified(){
        if($i = DbProjectItem::getById($this->item)){
            $mod_date = $i->modified;
            return $mod_date;
        }
        else{
            return NULL;
        }
    }

    static function &getAll($args=NULL){

        global $auth;

        $prefix = confGet('DB_TABLE_PREFIX');
        $dbh = new DB_Mysql;

        ## default parameter ##
        $id               = NULL;
        $person           = $auth->cur_user->id;
        $item             = NULL;
        $viewed           = NULL;
        $is_bookmark      = NULL;
        $feedback_requested_by = NULL;
        $notify_on_change = NULL;
        $notify_if_unchanged_min = NULL;
        $notify_if_unchanged_max = NULL;
        $order_by         = "ip.created DESC";
        
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

        $str_id = $id
            ? "AND ip.id = " . $id .""
            : "";

        $str_item = $item
            ? "AND ip.item = " . $item .""
            : "";

       if(is_null($is_bookmark)){
            $str_bookmark = "";
       }
       else{
           if($is_bookmark){
               $str_bookmark = "AND ip.is_bookmark = 1";
           }
           else{
               $str_bookmark = "AND ip.is_bookmark = 0";
           }
       }

       if(is_null($feedback_requested_by)){
            $str_feedback = "";
       }
       else{
           
           if( is_int($feedback_requested_by) || is_string($feedback_requested_by)){
               $str_feedback = "AND ip.feedback_requested_by = int($feedback_requested_by)";
           }
           else{
               $str_feedback = "AND ip.feedback_requested_by != 0";
           }
       }

        
        if(!is_null($notify_on_change)){
            $str_notify_on_change = 'AND ip.notify_on_change = ' . $notify_on_change;
        }
        else{
            $str_notify_on_change = '';
        }
        
        if(!is_null($notify_if_unchanged_min)){
            $str_notify_if_unchanged_min = 'AND ip.notify_if_unchanged >= ' . $notify_if_unchanged_min;
        }
        else{
            $str_notify_if_unchanged_min = '';
        }
        
        if(!is_null($notify_if_unchanged_max)){
            $str_notify_if_unchanged_max = 'AND ip.notify_if_unchanged <= ' . $notify_if_unchanged_max;
        }
        else{
            $str_notify_if_unchanged_max = '';
        }
        
        if(!is_null($person)){
            $str_query = "SELECT ip.* FROM {$prefix}itemperson ip,  {$prefix}item i
                          WHERE ip.person = " . $person . "
                          AND i.id = ip.item
                          $str_item
                          $str_bookmark
                          $str_id
                          $str_feedback
                          $str_notify_on_change
                          $str_notify_if_unchanged_min
                          $str_notify_if_unchanged_max"
                          . getOrderByString($order_by);

            $sth = $dbh->prepare($str_query);
            $sth->execute("",1);
            $tmp = $sth->fetchall_assoc();
            $itempersons = array();
            foreach($tmp as $t){
                $itemperson = new ItemPerson($t);
                $itempersons[] = $itemperson;
            }

            return $itempersons;
        }
        else{
            return NULL;
        }
    }
    
    static function checkChangedItem($args=NULL){
        global $auth;
        
        $prefix = confGet('DB_TABLE_PREFIX');
        $dbh = new DB_Mysql;

        ## default parameter ##
        $item             = NULL;
        $notify_on_change = NULL;

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
        
        $str_query = "SELECT * FROM {$prefix}itemperson
                      WHERE item = " . $item . "
                      AND notify_on_change = " . $notify_on_change . "
                      AND person != " . $auth->cur_user->id . ";";

        $sth = $dbh->prepare($str_query);
        $sth->execute("",1);
        $tmp = $sth->fetchall_assoc();
        
        if($tmp){
            return $tmp;
        }
        else{
            return NULL;
        }
        
        return NULL;
    }
    
    static function getPersons($item=NULL,$notify_on_change=NULL)
    {
        global $auth;

        $prefix = confGet('DB_TABLE_PREFIX');
        $dbh = new DB_Mysql;
        
        if(!is_null($item) && !is_null($notify_on_change)){
            $str_query = "SELECT ip.person, p.office_email, p.personal_email 
                          FROM {$prefix}itemperson ip, {$prefix}person p
                          WHERE ip.item = " . $item . "
                          AND ip.notify_on_change = " . $notify_on_change . "
                          AND ip.person = p.id;";
            $sth = $dbh->prepare($str_query);
            $sth->execute("",1);
            $tmp = $sth->fetchall_assoc();
            if($tmp){
                return $tmp;
            }
        }
        else{
            return NULL;
        }
        
        return NULL;
    }
    
    public function update($args=NULL, $update_modifier=true)
    {
        global $auth;
        $dbh = new DB_Mysql;

        $prefix= confGet('DB_TABLE_PREFIX');

        $update_fields = NULL;

        ### build hash to fast access ##
        if($args) {
            $update_fields = array();
            foreach($args as $a) {
                $update_fields[$a] = true;
            }
        }

        if(!$this->id) {
          trigger_error("User object without id can't be updated", E_USER_WARNING);
        }
        if(!sizeof($this->field_states)) {
            trigger_error("need members to update to database. e.g. 'firstname,lastname,data'", E_USER_WARNING);
        }

        $t_pairs=array();          # the 'id' field is skipped later, because it's defined as project-item-field. so we have to add it here
        foreach($this->fields as $f) {
            $name= $f->name;

            ### selective updates ###
            if($update_fields && !isset($update_fields[$name])) {
                continue;
            }

            ### skip project-item fields ###
            if((isset($this->fields[$name]) && isset($this->fields[$name]->in_db_object)) || !isset($g_item_fields[$name])){

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
    }
}


?>
