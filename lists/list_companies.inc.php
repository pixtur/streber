<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * derived ListBlock-class for listing companies
 *
 * @includedby:     pages/*
 *
 * @author:         Thomas Mann
 * @uses:           ListBlock
 * @usedby:
 *
 */

class ListBlock_companies extends ListBlock
{

	public $format;

    public function __construct($args=NULL)
    {
		parent::__construct($args);

        $this->id       ='companies';
        $this->bg_style ='bg_people';
		$this->title    =__("related companies");

        $this->add_col( new ListBlockColSelect());
   		$this->add_col( new ListBlockColFormat(array(
			'key'=>'short',
			'name'=>__("Name Short"),
			'tooltip'=>__("Shortnames used in other lists"),
			'sort'=>0,
			'format'=>'<nobr><a href="index.php?go=companyView&amp;company={?id}">{?short}</a></nobr>'
		)));
   		$this->add_col( new ListBlockCol_CompanyName());
   		$this->add_col( new ListBlockColFormat(array(
			'key'=>'phone',
			'name'=>__("Phone"),
			'tooltip'=>__("Phone-Number"),
			'format'=>'<nobr>{?phone}</nobr>'
		)));
   		$this->add_col( new ListBlockColLinkExtern(array(
			'key'=>'homepage',
			'name'=>"Homepage",
		)));
    	$this->add_col( new ListBlockColMethod(array(
    		'name'=>__("Proj"),
    		'tooltip'=>__("Number of open Projects"),
    		'func'=>'getNumOpenProjects',
            'style'=>'right'
    	)));
    	$this->add_col( new ListBlockColMethod(array(
    		'name'=>__("People"),
            'id'=>"people",
    		'tooltip'=>__("People working for this person"),
    		'sort'=>0,
            'style'=>'nowrap',
    		'func'=>'getPersonLinks',
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
            'target'=>$PH->getPage('companyEdit')->id,
            'name'  =>__('Edit company'),
            'id'    =>'companyEdit',
            'icon'  =>'edit',
            'context_menu'=>'submit',
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('companyDelete')->id,
            'name'  =>__('Delete company'),
            'id'    =>'companyDelete',
            'icon'  =>'delete'
        )));
        $this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('companyNew')->id,
            'name'  =>__('Create new company'),
            'id'    =>'companyNew',
            'icon'  =>'new',
            'context_menu'=>'submit',
        )));
		$this->add_function(new ListFunction(array(
            'target'=>$PH->getPage('itemsAsBookmark')->id,
            'name'  =>__('Mark as bookmark'),
            'id'    =>'itemsAsBookmark',
            'context_menu'=>'submit',
        )));
    }
}


class ListBlockCol_CompanyName extends ListBlockCol
{
    public $key= 'name';
    public $width='90%';

    public function __construct($args=NULL)
    {
        parent::__construct($args);
        $this->name=__('Company','Column header');
        #$this->id='name';
    }


	public function render_tr(&$obj, $style="")
	{
        global $PH;

		if(!isset($obj) || !$obj instanceof Company) {
   			return;
		}

		$str= $PH->getLink('companyView',asHtml($obj->name), array('company'=>$obj->id),'item company',true);
		print "<td>$str</td>";
	}
}




?>