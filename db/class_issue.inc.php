<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html


/**
 * Issue-report (adds additional fields to task)
 *
 * @includedby:     *
 *
 * @author         Thomas Mann
 * @uses:
 * @usedby:
 *
 */




class Issue extends DbProjectItem {

	//=== constructor ================================================
	function __construct ($id_or_array=NULL)
    {
        global $g_issue_fields;
        $this->fields= &$g_issue_fields;

        parent::__construct($id_or_array);
        if(!$this->type) {
           $this->type= ITEM_ISSUE;
        }
   	}

    static function initFields() 
    {
        global $g_issue_fields;
        $g_issue_fields=array();
        
        global $REPRODUCIBILITY_VALUES;
        global $SEVERITY_VALUES;
        
        
        addProjectItemFields($g_issue_fields);
        
        foreach(array(
            new FieldInternal(array(    'name'=>'id',
                'default'=>0,
                'in_db_object'=>1,
                'in_db_item'=>1,
            )),
            new FieldInternal(array(    'name'=>'task',             # backlink to task item
                'default'=>0,
            )),
        
            new FieldInt(array(      'name'=>'reproducibility',
                'default'=> REPRODUCIBILITY_HAVE_NOT_TRIED,
                'view_in_forms'=>false,
            )),
            new FieldInt(array(      'name'=>'severity',
                'default'=> SEVERITY_MINOR,
                'view_in_forms'=>false,
            )),
            new FieldString(array(      'name'=>'plattform',
            )),
            new FieldString(array(      'name'=>'os',
                'view_in_forms'=>false,
            )),
            new FieldString(array(      'name'=>'version',
            )),
            new FieldString(array(      'name'=>'production_build',
                'title'=>__('Production build'),
                'view_in_forms'=>true,
            )),
            new FieldText(array(      'name'=>'steps_to_reproduce',
                'title'=>__('Steps to reproduce'),
            )),
            new FieldText(array(      'name'=>'expected_result',
                'title'=>__('Expected result'),
            )),
            new FieldText(array(      'name'=>'suggested_solution',
                'title'=>__('Suggested Solution'),
            )),
        ) as $f) {
            $g_issue_fields[$f->name]=$f;
        }
    }




    /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id)
    {
        $i= new Issue(intval($id));
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
        if($i= Issue::getById(intval($id))) {
            if($p= Project::getById($i->project)) {
                if($p->validateViewItem($i)) {
                    return $i;
                }
            }
            else {
                trigger_error("issue without project?",E_USER_WARNING);
            }
        }
        return NULL;
    }

    /**
    * query if editable for current user
    */
    static function getEditableById($id)
    {
        if($i= Issue::getById(intval($id))) {
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


    /**
    * getIssues($project=false)
    */
    static function getAll($args=Array())
    {
        global $auth;
		$prefix = confGet('DB_TABLE_PREFIX');

        ### default params ###
        $order_by=      "";
        $visible_only=  true;   # use project rights settings
        $alive_only=    true;   # ignore deleted
        $project=       NULL;
        $search=        NULL;

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

        $dbh = new DB_Mysql;

        $str_is_alive= $alive_only
        ? 'AND i.state=' . ITEM_STATE_OK
        : '';

        $AND_match= $search
        ? "AND (MATCH (iss.plattform,iss.os,iss.version,iss.production_build,iss.steps_to_reproduce,iss.expected_result,iss.suggested_solution) AGAINST ('". asCleanString($search). "*' IN BOOLEAN MODE))"
        : "";

        $AND_project1= $project
        ? 'AND upp.project='. intval($project)
        : '';

        $AND_project2= $project
        ? 'AND i.project='. intval($project)
        : '';

        if($visible_only) {
            $str_query=
            "SELECT i.*, iss.* from {$prefix}item i, {$prefix}issue iss, {$prefix}projectperson upp
            WHERE
                    upp.person = {$auth->cur_user->id}
                $AND_project1
                AND upp.state = 1

                AND i.type = '".ITEM_ISSUE."'
                AND i.project = upp.project
                $AND_project2
                $str_is_alive
                AND ( i.pub_level >= upp.level_view
                      OR
                      i.created_by = {$auth->cur_user->id}
                )

                AND iss.id = i.id
                $AND_match
           ";

        }
        else {
            $str_query=
            "SELECT i.*, iss.* from {$prefix}item i, {$prefix}issue iss
            WHERE
                    i.type = '".ITEM_ISSUE."'
                $AND_project2
                $str_is_alive

                AND iss.id = i.id
                $AND_match
            ";


        }

        $sth= $dbh->prepare($str_query);
    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();
    	$issues=array();
        foreach($tmp as $n) {
            $issue=new Issue($n);
            $issues[]= $issue;
        }
        return $issues;

    }

    static function getCreatedRecently($person_id=NULL)
    {
        if(!$person_id) {
            global $auth;
            $person_id= $auth->cur_user->id;
        }
        else {
            $person_id= intval($person_id);
        }

		$prefix= confGet('DB_TABLE_PREFIX');

        require_once(confGet('DIR_STREBER') . 'db/class_issue.inc.php');
        $dbh = new DB_Mysql;
        $sth= $dbh->prepare(
            "SELECT i.*, iss.*
                 from {$prefix}item i,  {$prefix}issue iss
                WHERE   i.created_by={$person_id}
                    AND i.type = '".ITEM_ISSUE."'
                    AND iss.id = i.id
                    AND i.state = 1
                    ORDER BY i.created DESC
                "
        )->execute();
    	$tmp=$sth->fetchall_assoc();
    	$issues=array();
        foreach($tmp as $n) {
            $issue=new Issue($n);
            $issues[]= $issue;
        }
        return $issues;
    }

}
Issue::initFields();


?>