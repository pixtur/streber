<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
require_once ("./db/db.inc.php");
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * pages relating to modification history
 *
 *
 */




/**
* NOTE:
* - since changes only store the old values of fields summing all changes up to a version
*   version history can become tricky. This class and its static function getFromItem() does
*   the job.
*
* - getFromItem() returns a list of all versions
*/
class ItemVersion extends BaseObject
{
    public $version_number;
    public $date_from;
    public $date_to;
    public $author;
    public $values=array();                         # hash with changed fields in this version
    public $values_next=array();                         # hash with changed fields in this version


    static function getFromItem($item)
    {

        ### get changes ###
        $all_changes= $all_changes= ItemChange::getItemChanges(array(
            'item'      => $item->id,
        ));

        $versions= array( new ItemVersion(array(
            'version_number'=>1,
            'date_from'=> $item->created,
            'author'=> $item->created_by,
        )));

        $last_version= $versions[0];


        $version_number=2;
        $modified_last= NULL;
        foreach($all_changes as $cf) {

            $flag_new= false;

            if($cf->modified != $modified_last) {
                $flag_new = true;
            }
            if(isset($last_version) && $last_version->author != $cf->modified_by) {
                $flag_new;
            }

            if($flag_new) {
                $version= new ItemVersion(array(
                    'version_number'=> $version_number++,
                    'date_from'     => $cf->modified,
                    'author'        => $cf->modified_by,
                   # 'changed_fields'=> array($cf)
                ));


                $modified_last = $cf->modified;
                $versions[]= $version;
                $last_version= $versions[count($versions)-2];
                $last_version->date_to= $cf->modified;

            }

            $last_version->values[$cf->field]= $cf->value_old;
            #$versions[count($versions)-1]->values[$cf->field]= 'bla';
        }

        ### finally fill out latest values ###
        if(count($versions) > 1) {
            foreach($versions[count($versions)-2]->values as $fname => $value) {
                $versions[count($versions)-1]->values[$fname] = $item->$fname;
            }
            $versions[count($versions)-1]->date_to= getGMTString();

            ### fill in next values ###
            $changed= array();
            foreach(array_reverse($versions) as $v) {
                foreach($v->values as $name=>$value) {
                    if(isset($changed[$name])) {
                        $v->values_next[$name]= $changed[$name];
                    }
                    else {
                        $v->values_next[$name]= $item->$name;
                    }
                    $changed[$name]= $value;
                }
            }
        }
        return $versions;
    }
}















global $g_itemchange_fields;
$g_itemchange_fields=array();
foreach(array(
            ### internal fields ###
            new FieldInternal  (array('name'=>'id',
                'default'=>0,
            )),
            /**
            * id of the item being changed
            */
            new FieldInternal  (array('name'=>'item',
                'default'=>10,
            )),
            new FieldUser     (array('name'=>'modified_by',
                'default'=> FINIT_CUR_USER,
                'view_in_forms'=>false,
            )),

            new FieldDatetime( array('name'=>'modified',
                'default'=>FINIT_NOW,
                'view_in_forms'=>false,
            )),

            /**
            * name of the changed field
            */
            new FieldInternal(array(    'name'=>'field',
                'view_in_forms'=>false,
            )),

            /**
            * old value
            */
            new FieldInternal  (array('name'=>'value_old',
                'view_in_forms'=>false,
            )),

       ) as $f) {
            $g_itemchange_fields[$f->name]=$f;
       }



class ItemChange extends DbItem
{

    public $fields_itemchange;

    /**
    * create empty object-item or querry database
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

            global $g_itemchange_fields;
            $this->fields=&$g_itemchange_fields;
        }

        parent::__construct();

        /**
        * if array is passed, create a new empty object with default-values
        */
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




    static function &getItemChanges( $args=NULL)
    {
        global $auth;
		$prefix = confGet('DB_TABLE_PREFIX');

        ### default params ###
        $item               = NULL;
        $date_min           = NULL;
        $date_max           = NULL;
        $person             = NULL;
        $field              = NULL;
        $project            = NULL;
        $order_by            = 'modified';

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
            ? "AND c.project= $project"
            : '';


        $str_item= $item
            ? "AND c.item=".$item
            : '';


        $str_date_min= $date_min
            ? "AND c.modified >= '$date_min'"
            : '';

        $str_date_max= $date_max
            ? "AND c.modified <= '$date_max'"
            : '';

        $str_field= $field
            ? "AND c.field =`$field`"
            : '';

        $str_person= $person
            ? "AND c.modified_by =$person"
            : '';


        ### show all ###
        $str_query=
        	"SELECT c.*  from {$prefix}itemchange c
            WHERE 1
            $str_project
            $str_item
            $str_person
            $str_field
            $str_date_max
            $str_date_min
            ". getOrderByString($order_by);

            ;

        $dbh = new DB_Mysql;
        $sth= $dbh->prepare($str_query);

    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();
    	$item_changes=array();
        foreach($tmp as $t) {
            $c=new ItemChange($t);
            $item_changes[]=$c;
        }
        return $item_changes;
    }














    /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id)
    {
        $i= new DbItemChange($id);
        if($i->id) {
            return $i;
        }
        return NULL;
    }
}


?>
