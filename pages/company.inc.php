<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file  pages relating to company */

require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_company.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_companies.inc.php');


/**
* companyList
*
* @ingroup pages
*
* - requires prj or task or tsk_*
*/
function companyList() {
    global $PH;
    global $auth;



    ### create from handle ###
    $PH->defineFromHandle();

	### set up page and write header ####
	{
		$page= new Page();
		$page->cur_tab='companies';
		$page->title=__("Companies");
		if(!($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
			$page->title_minor=sprintf(__("related projects of %s"), $page->title_minor=$auth->cur_user->name);
		}
		else {
			$page->title_minor=__("admin view");
		}
		$page->type=__("List");

		/*$page->crumbs[]= new NaviCrumb(array(
			'target_id'     => 'companyList',
		));*/
		$page->options=build_companyList_options();


		### page functions ###
		if($auth->cur_user->user_rights & RIGHT_COMPANY_CREATE) {

			### page functions ###
			$page->add_function(new PageFunctionGroup(array(
				'name'      => __('new:')
			)));
			$page->add_function(new PageFunction(array(
				'target'=>'companyNew',
				'name'=>__('Company'),
				'params'=>array('company_category'=>CCATEGORY_UNDEFINED),
			)));
		}

		### render title ###
		echo(new PageHeader);
	}
	echo (new PageContentOpen);

	#--- list projects --------------------------------------------------------
	{


		$list= new ListBlock_companies();

		### may user create companies? ###
		if($auth->cur_user->user_rights & RIGHT_COMPANY_CREATE) {
			$list->no_items_html=$PH->getLink('companyNew','',array('person'=>$auth->cur_user->id));
		}
		else {
			$list->no_items_html=__("no companies");
		}


		$order_str= get("sort_".$PH->cur_page->id."_".$list->id);

		$order_str= str_replace(",",", ", $order_str);
		$companies=Company::getAll(array('order_str'=>$order_str));

		$list->title= $page->title;
		$list->render_list(&$companies);

		### Link to start cvs export ###
		$format = get('format');
		if($format == FORMAT_HTML || $format == ''){
			#echo "<div class=description>" . $PH->getLink('companyList', __('Export as CSV'),array('format'=>FORMAT_CSV)) . "</div>";
			echo $PH->getCSVLink();
		}
	}

	echo(new PageContentClose);
	echo(new PageHtmlEnd);

}

/**
* List companies in Client category
*
* @ingroup pages
*/
function companyListClient()
{
	global $PH;
    global $auth;

    ### create from handle ###
    $PH->defineFromHandle();

	### set up page and write header ####
	{
		$page= new Page();
		$page->cur_tab='companies';
		$page->title=__("Clients");
		if(!($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
			$page->title_minor=sprintf(__("related companies of %s"), $page->title_minor=$auth->cur_user->name);
		}
		else {
			$page->title_minor=__("admin view");
		}
		$page->type=__("List", "page type");

		$page->options=build_companyList_options();

		### page functions ###
		if($auth->cur_user->user_rights & RIGHT_COMPANY_CREATE) {

			### page functions ###
			$page->add_function(new PageFunctionGroup(array(
				'name'      => __('new:')
			)));
			$page->add_function(new PageFunction(array(
				'target'=>'companyNew',
				'name'=>__('Company'),
				'params'=>array('company_category'=>CCATEGORY_CLIENT),
			)));
		}


		### render title ###
		echo(new PageHeader);
	}
	echo (new PageContentOpen);

	#--- list projects --------------------------------------------------------
	{
		$list= new ListBlock_companies();

		### may user create companies? ###
		if($auth->cur_user->user_rights & RIGHT_COMPANY_CREATE) {
			$list->no_items_html=$PH->getLink('companyNew','',array('person'=>$auth->cur_user->id));
		}
		else {
			$list->no_items_html=__("no companies");
		}


		$order_str= get("sort_".$PH->cur_page->id."_".$list->id);

		$order_str= str_replace(",",", ", $order_str);

		$comcat = CCATEGORY_CLIENT;

		$companies=Company::getAll(array(
							'order_str'=>$order_str,
							'has_id'=>NULL,
							'search'=>NULL,
							'comcat'=>$comcat
							));

		$list->title= $page->title;
		$list->render_list(&$companies);

		## Link to start cvs export ##
		$format = get('format');
		if($format == FORMAT_HTML || $format == ''){
			#echo "<div class=description>" . $PH->getLink('companyListClient', __('Export as CSV'),array('format'=>FORMAT_CSV)) . "</div>";
		    echo $PH->getCSVLink();
		}
	}

	echo(new PageContentClose);
	echo(new PageHtmlEnd);

}

/**
* List all prospective clients
* @ingroup pages
*/
function companyListProsClient()
{
	global $PH;
    global $auth;

    ### create from handle ###
    $PH->defineFromHandle();

	### set up page and write header ####
	{
		$page= new Page();
		$page->cur_tab='companies';
		$page->title=__("Prospective Clients");
		if(!($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
			$page->title_minor=sprintf(__("related companies of %s"), $page->title_minor=$auth->cur_user->name);
		}
		else {
			$page->title_minor=__("admin view");
		}
		$page->type=__("List", "page type");

		$page->options=build_companyList_options();


		### page functions ###
		if($auth->cur_user->user_rights & RIGHT_COMPANY_CREATE) {

			### page functions ###
			$page->add_function(new PageFunctionGroup(array(
				'name'      => __('new:')
			)));
			$page->add_function(new PageFunction(array(
				'target'=>'companyNew',
				'name'=>__('Company'),
				'params'=>array('company_category'=>CCATEGORY_PROSCLIENT),
			)));
		}

		### render title ###
		echo(new PageHeader);
	}
	echo (new PageContentOpen);

	#--- list projects --------------------------------------------------------
	{
		$list= new ListBlock_companies();

		### may user create companies? ###
		if($auth->cur_user->user_rights & RIGHT_COMPANY_CREATE) {
			$list->no_items_html=$PH->getLink('companyNew','',array('person'=>$auth->cur_user->id));
		}
		else {
			$list->no_items_html=__("no companies");
		}

		$order_str= get("sort_".$PH->cur_page->id."_".$list->id);

		$order_str= str_replace(",",", ", $order_str);

		$comcat = CCATEGORY_PROSCLIENT;

		$companies=Company::getAll(array(
							'order_str'=>$order_str,
							'has_id'=>NULL,
							'search'=>NULL,
							'comcat'=>$comcat
							));

		$list->title= $page->title;
		$list->render_list(&$companies);

		## Link to start cvs export ##
		$format = get('format');
		if($format == FORMAT_HTML|| $format == ''){
			#echo "<div class=description>" . $PH->getLink('companyListProsClient', __('Export as CSV'),array('format'=>FORMAT_CSV)) . "</div>";
		    echo $PH->getCSVLink();
		}
	}

	echo(new PageContentClose);
	echo(new PageHtmlEnd);
}

/**
* list all supplier
* @ingroup pages
*/
function companyListSupplier()
{
	global $PH;
    global $auth;

    ### create from handle ###
    $PH->defineFromHandle();

	### set up page and write header ####
	{
		$page= new Page();
		$page->cur_tab='companies';
		$page->title=__("Suppliers");
		if(!($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
			$page->title_minor=sprintf(__("related companies of %s"), $page->title_minor=$auth->cur_user->name);
		}
		else {
			$page->title_minor=__("admin view");
		}
		$page->type=__("List", "page type");

		$page->options=build_companyList_options();

		### page functions ###
		if($auth->cur_user->user_rights & RIGHT_COMPANY_CREATE) {

			### page functions ###
			$page->add_function(new PageFunctionGroup(array(
				'name'      => __('new:')
			)));
			$page->add_function(new PageFunction(array(
				'target'=>'companyNew',
				'name'=>__('Company'),
				'params'=>array('company_category'=>CCATEGORY_SUPPLIER),
			)));
		}

		### render title ###
		echo(new PageHeader);
	}
	echo (new PageContentOpen);

	#--- list projects --------------------------------------------------------
	{
		$list= new ListBlock_companies();

		### may user create companies? ###
		if($auth->cur_user->user_rights & RIGHT_COMPANY_CREATE) {
			$list->no_items_html=$PH->getLink('companyNew','',array('person'=>$auth->cur_user->id));
		}
		else {
			$list->no_items_html=__("no companies");
		}

		$order_str= get("sort_".$PH->cur_page->id."_".$list->id);

		$order_str= str_replace(",",", ", $order_str);

		$comcat = CCATEGORY_SUPPLIER;

		$companies=Company::getAll(array(
							'order_str'=>$order_str,
							'has_id'=>NULL,
							'search'=>NULL,
							'comcat'=>$comcat
							));

		$list->title= $page->title;
		$list->render_list(&$companies);

		## Link to start cvs export ##
		$format = get('format');
		if($format == FORMAT_HTML|| $format == ''){
			#echo "<div class=description>" . $PH->getLink('companyListSupplier', __('Export as CSV'),array('format'=>FORMAT_CSV)) . "</div>";
			echo $PH->getCSVLink();
		}
	}

	echo(new PageContentClose);
	echo(new PageHtmlEnd);

}

/**
* List all partner companies
*
* @ingroup pages
*/
function companyListPartner()
{
	global $PH;
    global $auth;

    ### create from handle ###
    $PH->defineFromHandle();

	### set up page and write header ####
	{
		$page= new Page();
		$page->cur_tab='companies';
		$page->title=__("Partners");
		if(!($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
			$page->title_minor=sprintf(__("related companies of %s"), $page->title_minor=$auth->cur_user->name);
		}
		else {
			$page->title_minor=__("admin view");
		}
		$page->type=__("List", "page type");

		$page->options=build_companyList_options();

		### page functions ###
		if($auth->cur_user->user_rights & RIGHT_COMPANY_CREATE) {

			### page functions ###
			$page->add_function(new PageFunctionGroup(array(
				'name'      => __('new:')
			)));
			$page->add_function(new PageFunction(array(
				'target'=>'companyNew',
				'name'=>__('Company'),
				'params'=>array('company_category'=>CCATEGORY_PARTNER),
			)));
		}

		### render title ###
		echo(new PageHeader);
	}
	echo (new PageContentOpen);

	#--- list projects --------------------------------------------------------
	{
		$list= new ListBlock_companies();

		### may user create companies? ###
		if($auth->cur_user->user_rights & RIGHT_COMPANY_CREATE) {
			$list->no_items_html=$PH->getLink('companyNew','',array('person'=>$auth->cur_user->id));
		}
		else {
			$list->no_items_html=__("no companies");
		}

		$order_str= get("sort_".$PH->cur_page->id."_".$list->id);

		$order_str= str_replace(",",", ", $order_str);

		$comcat = CCATEGORY_PARTNER;

		$companies=Company::getAll(array(
							'order_str'=>$order_str,
							'has_id'=>NULL,
							'search'=>NULL,
							'comcat'=>$comcat
							));

		$list->title= $page->title;
		$list->render_list(&$companies);

		## Link to start cvs export ##
		$format = get('format');
		if($format == FORMAT_HTML || $format == ''){
			#echo "<div class=description>" . $PH->getLink('companyListPartner', __('Export as CSV'),array('format'=>FORMAT_CSV)) . "</div>";
			echo $PH->getCSVLink();
		}
	}

	echo(new PageContentClose);
	echo(new PageHtmlEnd);
}

/**
* View a company 
*
* @ingroup pages
*/
function companyView()
{

    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

	### get current company ###
    $id=getOnePassedId('company','companies_*');
    $company= Company::getVisibleById($id);
	if(!$company) {
        $PH->abortWarning("invalid company-id");
		return;
	}

	## is viewed by user ##
	$company->nowViewedByUser();

    $company->validateView();

    ### create from handle ###
    $PH->defineFromHandle(array('company'=>$company->id));



    ### set up page ####
    {
        $page= new Page();
    	$page->cur_tab='companies';
        $page->title=$company->name;
        $page->title_minor=__("Overview");
        $page->type=__("Company");


        ### breadcrumbs  ###
        $page->crumbs= build_company_crumbs($company);


        ### page functions ###
        $page->add_function(new PageFunctionGroup(array(
            'name'      => __('edit:')
        )));

        $page->add_function(new PageFunction(array(
            'target'    =>'companyEdit',
            'params'    =>array('company'=>$company->id),
            'icon'      =>'edit',
            'tooltip'   =>__('Edit this company'),
            'name'      =>__('Company'),
        )));
		
		$item = ItemPerson::getAll(array('person'=>$auth->cur_user->id,'item'=>$company->id));
		if((!$item) || ($item[0]->is_bookmark == 0)){
			$page->add_function(new PageFunction(array(
				'target'    =>'itemsAsBookmark',
				'params'    =>array('company'=>$company->id),
				'tooltip'   =>__('Mark this company as bookmark'),
				'name'      =>__('Bookmark'),
			)));
		}
		else{
			$page->add_function(new PageFunction(array(
				'target'    =>'itemsRemoveBookmark',
				'params'    =>array('company'=>$company->id),
				'tooltip'   =>__('Remove this bookmark'),
				'name'      =>__('Remove Bookmark'),
			)));
		} 
		
		if($company->state == 1) {
			$page->add_function(new PageFunction(array(
				'target'=>'companyDelete',
				'params'=>array('company'=>$company->id),
				'icon'=>'delete',
				'tooltip'=>__('Delete this company'),
				'name'=>__('Delete')
			)));
        }

        $page->add_function(new PageFunctionGroup(array(
            'name'      => __('new:')
        )));

        $page->add_function(new PageFunction(array(
            'target'    =>'personNew',
            'params'    =>array('company'=>$company->id),
            'icon'      =>'new',
            'tooltip'   =>__('Create new person for this company'),
            'name'      =>__('Person'),
        )));
        $page->add_function(new PageFunction(array(
            'target'    =>'projNew',
            'params'    =>array('company'=>$company->id),
            'icon'      =>'new',
            'tooltip'   =>__('Create new project for this company'),
            'name'      =>__('Project'),
        )));
        $page->add_function(new PageFunction(array(
            'target'    =>'companyLinkPersons',
            'params'    =>array('company'=>$company->id),
            'icon'      =>'add',
            'tooltip'   =>__('Add existing persons to this company'),
            'name'      =>__('Persons'),
        )));




    	### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);


    #--- write info block ------------
    {
        $block=new PageBlock(array('title'=>__('Summary'), 'id'=>'summary'));
        $block->render_blockStart();
        echo "<div class=text>";

        if($company->comments) {
            echo wiki2html($company->comments);
        }
        if($company->street) {
            echo '<p><label>'. __('Adress') . ':</label>' . asHtml($company->street) .'</p>';
        }
        if($company->zipcode) {
            echo '<p><label></label>' . asHtml($company->zipcode). '</p>';
        }
        if($company->phone) {
            echo '<p><label>'. __('Phone') . ':</label>' . asHtml($company->phone) .'</p>';
        }
        if($company->fax) {
            echo '<p><label>'. __('Fax') . ':</label>' . asHtml($company->fax) .'</p>';
        }


        if($company->homepage) {
            echo '<p><label>'. __('Web') . ':</label>'.url2linkExtern($company->homepage).'</p>';
        }
        if($company->intranet) {
            echo '<p><label>'. __('Intra') . ':</label>'.url2linkExtern($company->intranet).'</p>';
        }
        if($company->email) {
            echo '<p><label>'. __('Mail') . ':</label>'.url2linkMail($company->email).'</p>';
        }

        echo "</div>";

        $block->render_blockEnd();
    }

    #--- list persons -------------------------------
    {
        require_once(confGet('DIR_STREBER') . 'pages/person.inc.php');
        $list= new ListBlock_persons();

        $persons= $company->getPersons();

        $list->title= __('related Persons');
        $list->id="related_persons";
        unset($list->columns['tagline']);
        unset($list->columns['nickname']);
        unset($list->columns['profile']);
        unset($list->columns['projects']);

        unset($list->columns['personal_phone']);
        unset($list->columns['office_phone']);
        unset($list->columns['companies']);
        unset($list->columns['changes']);
        unset($list->columns['last_login']);

        unset($list->functions['personDelete']);
        unset($list->functions['personEditRights']);

        /**
        * \NOTE We should provide a list-function to link more
        * people to this company. But therefore we would need to
        * pass the company's id, which is not possible right now...
        */
        $list->add_function(new ListFunction(array(
            'target'=>$PH->getPage('companyLinkPersons')->id,
            #'params'    =>array('company'=>$company->id),
            'name'  =>__('Link Persons'),
            'id'    =>'companyLinkPersons',
            'icon'  =>'add',
        )));
		$list->add_function(new ListFunction(array(
            'target'=>$PH->getPage('companyPersonsDelete')->id,
            'name'  =>__('Remove person from company'),
            'id'    =>'companyPersonsDelete',
            'icon'  =>'sub',
            'context_menu'=>'submit',
        )));

        if($auth->cur_user->user_rights & RIGHT_COMPANY_EDIT) {
            $list->no_items_html=
                $PH->getLink('companyLinkPersons',__('link existing Person'),array('company'=>$company->id))
                ." ". __("or")." "
                .$PH->getLink('personNew',__('create new'),array('company'=>$company->id));
        }
        else {
            $list->no_items_html=__("no persons related");
        }

        #$list->render_list(&$persons);
		$list->print_automatic(&$persons);
    }


    echo(new PageContentNextCol);


    #--- list open projects------------------------------------------------------------

    {
        require_once(confGet('DIR_STREBER') . 'lists/list_projects.inc.php');
        $order_by= get('sort_'.$PH->cur_page->id."_projects");

        $list= new ListBlock_projects();

        $list->title=__("Active projects");
        $list->id="active_projects";
        $list->groupings= NULL;
        $list->block_functions = NULL;

        unset($list->columns['company']);

        unset($list->functions['projNew']);
        unset($list->functions['projDelete']);
		$list->query_options['status_min']= STATUS_UPCOMING;
        $list->query_options['status_max']= STATUS_OPEN;
		$list->query_options['company']= $company->id;


        if($auth->cur_user->user_rights & RIGHT_PROJECT_CREATE) {
            $list->no_items_html=$PH->getLink('projNew',__('Create new project'),array('company'=>$company->id))." ".
            __(" Hint: for already existing projects please edit those and adjust company-setting.");
        }
        else {
            $list->no_items_html=__("no projects yet");
        }

		$list->print_automatic();

    }


    #--- list closed projects------------------------------------------------------------
    {
		$list= new ListBlock_projects();
		$list->groupings= NULL;
		$list->block_functions = NULL;

		$list->title=__("Closed projects");
		$list->id="closed_projects";
		unset($list->columns['company']);

		unset($list->functions['projNew']);
		unset($list->functions['projDelete']);
		$list->query_options['status_min']= STATUS_BLOCKED;
		$list->query_options['status_max']= STATUS_CLOSED;
		$list->query_options['company']= $company->id;

		$list->print_automatic();
    }

    ### add company-id ###
    # note: some pageFunctions like personNew can use this for automatical linking
    echo "<input type=hidden name=company value='$company->id'>";


    echo (new PageContentClose);
	echo (new PageHtmlEnd);
}


/**
* create a new company
*
* @ingroup pages
* - requires prj or task or tsk_*
*/
function companyNew() {
    global $PH;

    $name=get('new_name')
        ? get('new_name')
        :__("New Company");


    if(get('company_category')) {
        $category= get('company_category');
    }
    else {
        $category= CCATEGORY_UNDEFINED;
    }

    ### build new object ###
    $newCompany= new Company(array(
        'id'=>0,
        'name'=>$name,
        'category'=>$category,
        )
    );
    $PH->show('companyEdit',array('company'=>$newCompany->id),$newCompany);
}


/**
* Edit a company
* @ingroup pages
*/
function companyEdit($company=NULL)
{
    global $PH;
    global $auth;

    ### use object or get from database ###
    if(!$company) {
        $id= getOnePassedId('company','companies_*');   # WARNS if multiple; ABORTS if no id found
        $company= Company::getEditableById($id);
        if(!$company) {
            $PH->abortWarning("ERROR: could not get Company");
            return;
        }
    }

    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>true, 'autofocus_field'=>'company_name'));
    	$page->cur_tab='companies';
        $page->type=__("Edit Company");
        $page->title=$company->name;

    	$page->crumbs= build_company_crumbs($company);
    	$page->options[]= new NaviOption(array(
    	    'target_id'     => 'companyEdit',
    	));

        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    $block=new PageBlock(array(
        'id'    =>'edit',
        'reduced_header' => true,
    ));
    $block->render_blockStart();

    ### write form #####
    {
		global $g_ccategory_names;
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');

        $form=new PageForm();
        $form->button_cancel=true;

        foreach($company->fields as $field) {
            $form->add($field->getFormElement(&$company));
        }

		### dropdown menu for company category ###
		if($c= get('comcat')){
			$comcat = $c;
		}
		else {
			$comcat = $company->category;
		}
		$form->add(new Form_Dropdown('ccategory',  __('Category','form label'),array_flip($g_ccategory_names), $comcat));

        ### create another  ###
        if($auth->cur_user->user_rights & RIGHT_COMPANY_CREATE && $company->id == 0) {
            $checked= get('create_another')
            ? 'checked'
            : '';

            $form->form_options[]="<span class=option><input id='create_another' name='create_another' class='checker' type=checkbox $checked><label for='create_another'>" . __("Create another company after submit") . "</label></span>";     ;
        }


        echo ($form);

        $PH->go_submit='companyEditSubmit';

		### pass person-id? ###
        if($p = get('person')) {
            echo "<input type='hidden' name='person' value='$p'>";
        }

        echo "<input type=hidden name='company' value='$company->id'>";
    }
    $block->render_blockEnd();

    echo (new PageContentClose);
	echo (new PageHtmlEnd);

}

/**
* Submit change to a company
*
* @ingroup pages
*/
function companyEditSubmit()
{
    global $PH;
    global $auth;

    ### cancel ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('home',array());
        }
        exit();
    }

    ### get company ####
    $id= getOnePassedId('company');

    ### temporary object ###
    if($id == 0) {
        $company=new Company(array());
    }
    ### get from db ###
    else {
        $company= Company::getEditableById($id);
        if(!$company) {
            $PH->abortWarning("Could not get company");
            return;
        }
    }

    $company->validateEditRequestTime();

	### company category ###
	$ccategory = get('ccategory');
	if($ccategory != NULL)
	{
		$company->category = $ccategory;
	}

    # retrieve all possible values from post-data
    # NOTE:
    # - this could be an security-issue.
    # - TODO: as some kind of form-edit-behaviour to field-definition
    foreach($company->fields as $f) {
        $name=$f->name;
        $f->parseForm(&$company);
    }

    ### write to db ###
    if($company->id == 0) {
        if($company->insert()){
			### link to a company ###
            if($p_id = get('person')) {
                require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');

                if($p = Person::getVisibleById($p_id)) {
                    require_once(confGet('DIR_STREBER') . 'db/class_employment.inc.php');
                    $e = new Employment(array(
                        'id'=>0,
                        'person'=>$p->id,
                        'company'=>$company->id
                    ));
                    $e->insert();
                }
			}

		}

        ### show 'create another' -form
        if(get('create_another')) {
            $PH->show('companyNew',array());
            exit();
        }
    }
    else {
        $company->update();
    }

	### notify on change ###
	$company->nowChangedByUser();

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('home',array());
    }
}

/**
* Link Persons to company
*
* @ingroup pages
*/
function companyLinkPersons() {
    global $PH;

    $id= getOnePassedId('company','companies_*');   # WARNS if multiple; ABORTS if no id found
    $company= Company::getEditableById($id);
    if(!$company) {
        $PH->abortWarning("ERROR: could not get Company");
        return;
    }

    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>true, 'autofocus_field'=>'company_name'));
    	$page->cur_tab='companies';
        $page->type=__("Edit Company");
        $page->title=sprintf(__("Edit %s"),$company->name);
        $page->title_minor=__("Add persons employed or related");


    	$page->crumbs= build_company_crumbs($company);
    	$page->options[]= new NaviOption(array(
    	    'target_id'     => 'companyLinkPersons',
    	));

        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . 'pages/person.inc.php');
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
        $persons= Person::getPersons();
        $list= new ListBlock_persons();
        $list->show_functions=false;
        $list->show_icons=false;


        $list->render_list(&$persons);

        $PH->go_submit='companyLinkPersonsSubmit';
        echo "<input type=hidden name='company' value='$company->id'>";
        echo "<input class=button2 type=submit>";

    }
    echo (new PageContentClose);
	echo (new PageHtmlEnd);

}




/**
* Submit linked persons to a company
*
* @ingroup pages 
*/
function companyLinkPersonsSubmit()
{
    global $PH;
    require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');

    $id= getOnePassedId('company','companies_*');
    $company= Company::getEditableById($id);
    if(!$company) {
        $PH->abortWarning("Could not get object...");
    }

    $person_ids= getPassedIds('person','persons*');
    if(!$person_ids) {
        $PH->abortWarning(__("No persons selected..."));
    }

    $employments= $company->getEmployments();

    foreach($person_ids as $pid) {
        if(!$person= Person::getEditableById($pid)) {
            $PH->abortWarning("Could not access person by id");
        }

        #### person already employed? ###
        $already_in=false;
        foreach($employments as $e) {
            if($e->person == $person->id) {
                $already_in= true;
                break;
            }
        }
        if(!$already_in) {
            $e_new= new Employment(array(
                'id'=>0,
                'person'=>$person->id,
                'company'=>$company->id,
            ));
            $e_new->insert();
        }
        else {
            new FeedbackMessage(__("Person already related to company"));
        }
    }
    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('companyView',array('company'=>$company->id));
    }
}

/**
* Remove persons from a company 
*
* @ingroup pages
*/
function companyPersonsDelete()
{
	global $PH;

	$id= getOnePassedId('company','companies_*');
    $company= Company::getEditableById($id);
    if(!$company) {
        $PH->abortWarning("Could not get object...");
    }

    $person_ids= getPassedIds('person','persons*');
    if(!$person_ids) {
        $PH->abortWarning(__("No persons selected..."));
    }

	$employments= $company->getEmployments();

	$counter = 0;
	$errors = 0;
	foreach($person_ids as $pid) {
        if(!$person= Person::getEditableById($pid)) {
            $PH->abortWarning("Could not access person by id");
        }

		$assigned_to=false;
        foreach($employments as $e) {
            if($e->person == $person->id) {
                $assigned_to= true;
				$e_id = $e->id;

				if($assigned_to){
					$e_remove = Employment::getEditableById($e_id);
					if(!$e_remove) {
						 $PH->abortWarning("Could not access employment by id");
					}
					else {
						if($e_remove->delete()) {
							$counter++;
						}
						else {
							$errors++;
						}
					}
				}
				else {
					$PH->abortWarning("Contact person isn't related to this company");
				}
            }
        }
	}

	if($errors) {
        new FeedbackWarning(sprintf(__("Failed to remove %s contact person(s)"),$errors));
    }
    else {
        new FeedbackMessage(sprintf(__("Removed %s contact person(s)"), $counter));
    }

	if(!$PH->showFromPage()) {
		$PH->show('companyView',array('company'=>$company->id));
	}
}

/**
* Delete a company 
*
* @ingroup pages
*/
function companyDelete()
{
    global $PH;

    ### get company ####
    $ids= getPassedIds('company','companies_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some companies to delete"));
        return;
    }

    $counter=0;
    $errors=0;
    foreach($ids as $id) {
        $c= Company::getEditableById($id);
        if(!$c) {
            $PH->abortWarning("Invalid company-id!");
            continue;
        }
        if($c->delete()) {
            $counter++;
        }
        else {
            $errors++;
        }
    }
    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to delete %s companies"), $errors));
    }
    else {
        new FeedbackMessage(sprintf(__("Moved %s companies to trash"),$counter));
    }

    ### display companyList ####
	$PH->show('companyList');
}

/** @} */

?>
