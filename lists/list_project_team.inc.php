<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * derived ListBlock-class for listing project persons
 *
 * @includedby:     pages/company.inc, pages/person.inc, pages/proj.inc
 *
 * @author         Thomas Mann
 * @uses:           ListBlock
 * @usedby:
 *
 */

class ListBlock_projectTeam extends ListBlock
{

    public function __construct($args=NULL)
    {
		parent::__construct($args);

        $this->id='projectpersons';
        $this->bg_style='bg_people';
		$this->title=__("Your related persons");

        $this->add_col( new ListBlockColSelect());
   		/*$this->add_col( new ListBlockColFormat(array(
			'key'=>'nickname',
			'name'=>"Name Short",
			'tooltip'=>"Shortnames used in other lists",
			'sort'=>0,
			'format'=>'<nobr><a href="index.php?go=personView&amp;person={?id}">{?nickname}</a></nobr>'
		)));*/

   		$this->add_col( new ListBlockCol_ProjectPersonName());
   		$this->add_col( new ListBlockCol_ProjectJob());
   		$this->add_col( new ListBlockCol_ProjectPersonLastLogin());
   		#$this->add_col( new ListBlockColFormat(array(
		#	'key'=>'role',
		#	'name'=>__("Rights"),
		#	'tooltip'=>__("Persons rights in this project"),
		#	'format'=>'{?role}'
		#)));
   		/*
        $this->add_col( new ListBlockColFormat(array(
			'key'=>'phone_personal',
			'name'=>"Private",
			'format'=>'<nobr>{?phone_personal}</nobr>'
		)));
   		$this->add_col( new ListBlockColFormat(array(
			'key'=>'mobile',
			'name'=>"Mobil",
			'format'=>'<nobr>{?phone_mobile}</nobr>'
		)));
   		$this->add_col( new ListBlockColFormat(array(
			'key'=>'office',
			'name'=>"Office",
			'format'=>'<nobr>{?phone_office}</nobr>'
		)));
   		$this->add_col( new ListBlockColFormat(array(
			'key'=>'tagline',
			'name'=>"Tagline",
			'format'=>'{?tagline}'
		)));
    	$this->add_col( new ListBlockColMethod(array(
    		'name'=>"Companies",
    		'sort'=>0,
    		'func'=>'getCompanyLinks',
    	)));

        /*$this->add_col( new ListBlockCol_ProjectEffortSum);

    	$this->add_col( new ListBlockColMethod(array(
    		'name'=>"Tasks",
    		'tooltip'=>"Number of open Tasks",
    		'sort'=>0,
    		'func'=>'getNumTasks',
            'style'=>'right'
    	)));
   		$this->add_col( new ListBlockColDate(array(
			'key'=>'date_start',
			'name'=>"Opened",
			'tooltip'=>"Day the Project opened",
			'sort'=>0,
		)));
   		$this->add_col( new ListBlockColDate(array(
			'key'=>'date_closed',
			'name'=>"Closed",
			'tooltip'=>"Day the Project state changed to closed",
			'sort'=>0,
		)));
        */

        #---- functions ----
        global $PH;
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('projectPersonEdit')->id,
            'name'  =>__('Edit team member'),
            'id'    =>'projectPersonEdit',
            'icon'  =>'edit',
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('projAddPerson')->id,
            'name'  =>__('Add team member'),
            'id'    =>'projectPersonAdd',
            'icon'  =>'add',
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('projectPersonDelete')->id,
            'name'  =>__('Remove person from team'),
            'id'    =>'projectPersonDelete',
            'icon'  =>'sub',
            'context_menu'=>'submit',
        )));
        /*$this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('personDelete')->id,
            'name'  =>'Delete person',
            'id'    =>'personDelete',
            'icon'  =>'delete'
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('personNew')->id,
            'name'  =>'Create new person',
            'id'    =>'personNew',
            'icon'  =>'new',
            'context_menu'=>'submit',
        )));
        */
    }

	public function print_automatic(&$project)
    {
        global $PH;
		global $auth;

        if(!$this->active_block_function=$this->getBlockStyleFromCookie()) {
            $this->active_block_function = 'list';
        }

        $this->group_by= get("blockstyle_{$PH->cur_page->id}_{$this->id}_grouping");

        $s_cookie= "sort_{$PH->cur_page->id}_{$this->id}_{$this->active_block_function}";
        if($sort= get($s_cookie)) {
            $this->query_options['order_by']= $sort;
        }

        if($auth->cur_user->user_rights & RIGHT_VIEWALL) {
	   		$this->query_options['alive_only'] = true;
			$this->query_options['visible_only'] = false;
        }
        else {
            $this->query_options['alive_only'] = true;
			$this->query_options['visible_only'] = true;
        }

        #$team_members = &$project->getProjectPersons($this->query_options['order_by'], $this->query_options['alive_only'], $this->query_options['visible_only']);
		$team_members = $project->getProjectPersons($this->query_options);
        $this->render_list(&$team_members);
    }
}

class ListBlockCol_ProjectPersonName extends ListBlockCol
{
    public $name;
    public $key='pp.person';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('Name');
        $this->id= 'member';
        $this->width= "60%";
    }

	function render_tr(&$pp, $style="") {

        if($person= $pp->getPerson()) {

		    print "<td>".$person->getLink()."</td>";
        }
	}
}


class ListBlockCol_ProjectRole extends ListBlockCol
{
    public $name;
    public $key='view_level';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('Role');
        $this->id='role';
        $this->width= "1%";
    }

	/*function render_tr(&$obj, $style="")
	{


		print "<td><span class=small>$obj->name</span></td>";
	}*/
	function render_tr(&$pp, $style="")
	{
		global $g_user_profile_names;

		print "<td><span class=small>". $g_user_profile_names[intval($pp->role)] . "</span></td>";
	}
}

class ListBlockCol_ProjectJob extends ListBlockCol
{
    public $name;
    public $key='pp.name';

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('job');
        $this->id='name';
    }

	function render_tr(&$pp, $style="")
	{
		print "<td><span class=small>$pp->name</span></td>";
	}
}

class ListBlockCol_ProjectPersonLastLogin extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name=__('last Login','column header');
    }

	function render_tr(&$pp, $style="")
	{

        if($person= $pp->getPerson()) {

		    print "<td class=small>".renderDateHtml($person->last_login)."</td>";
        }
	}
}
?>