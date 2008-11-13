<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file
 * pages relating to persons
 *
 * @author Thomas Mann
 *
 */

require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_company.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_persons.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_projects.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_efforts.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

/**
* NOTE: for crumbs see render_misc.inc
*/
function build_person_options(&$person) {

    return array(
		new NaviOption(array(
            'target_id'=>'personViewProjects',
            'name'=>__('Projects'),
            'target_params'=>array('person'=>$person->id )
        )),
		new NaviOption(array(
            'target_id'=>'personViewTasks',
            'name'=>__('Tasks'),
            'target_params'=>array('person'=>$person->id )
        )),
        new NaviOption(array(
            'target_id'=>'personViewEfforts',
            'name'=>__('Efforts'),
            'target_params'=>array('person'=>$person->id )
        )),
		new NaviOption(array(
            'target_id'=>'personViewChanges',
            'name'=>__('Changes'),
            'target_params'=>array('person'=>$person->id )
        )),
    );
}



/**
* personList active @ingroup pages
*/
function personList()
{
    global $PH;
    global $auth;
	
	$presets= array(
        ### all ###
        'all_persons' => array(
            'name'=> __('all'),
            'filters'=> array(
                'person_category'=> array(
                    'id'        => 'person_category',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => PCATEGORY_UNDEFINED,
                    'max'       => PCATEGORY_PARTNER,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'tree',
                )
            )
        ),
        ### without account ###
        'persons_without_account' => array(
            'name'=> __('without account'),
            'filters'=> array(
                'can_login'=> array(
                    'id'        => 'can_login',
					'value'     => '0',
                    'visible'   => true,
                    'active'    => true,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        ### with account ###
        'persons_with_account' => array(
            'name'=> __('with account'),
            'filters'=> array(
                'can_login'=> array(
                    'id'        => 'can_login',
					'value'     => '1', 
                    'visible'   => true,
                    'active'    => true,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
        ### employee ###
        'person_employee' => array(
            'name'=> __('employees'),
            'filters'=> array(
                'person_category'=> array(
                    'id'        => 'person_category',
                    'visible'   => false,
                    'active'    => true,
                    'min'       => PCATEGORY_STAFF,
                    'max'       => PCATEGORY_EXEMPLOYEE,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
        ### contact persons ###
        'person_contact' => array(
            'name'=> __('contact persons'),
            'filters'=> array(
                'person_category'=> array(
                    'id'        => 'person_category',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => PCATEGORY_CLIENT,
                    'max'       => PCATEGORY_PARTNER,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        ### deleted persons ###
        'deleted_persons' => array(
            'name'=> __('deleted'),
            'filters'=> array(
                'person_is_alive'=> array(
                    'id'        => 'person_is_alive',
					'value'     => false,
                    'visible'   => true,
                    'active'    => true,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
    );

	## set preset location ##
	$preset_location = 'personList';

    ### get preset-id ###
    {
        $preset_id= 'persons_with_account';                           # default value
        if($tmp_preset_id= get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_personList_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id= get('STREBER_personList_preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }
        }
    }
	
    ### create from handle ###
	$PH->defineFromHandle(array('preset_id'=>$preset_id));

    ### set up page and write header ####
    {
        $page= new Page();
		$page->cur_tab='people';
        $page->title=__('Persons','Pagetitle for person list');
        if(!($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
            $page->title_minor= sprintf(__("relating to %s","Page title Person list title add on"), asHtml($auth->cur_user->name));
        }
        else {
            $page->title_minor=__("admin view","Page title add on if admin");
        }
     
        $page->type=__('List','page type');

        $page->options=build_personList_options();


        ### page functions ###
        $page->add_function(new PageFunction(array(
            'target'    =>'personNew',
            'params'    =>array(),
            'icon'      =>'new',
            'tooltip'   =>__('New person'),
        )));


        ### render title ###
        echo(new PageHeader);
    }
	
    echo (new PageContentOpen);
	
    #--- list persons --------------------------------------------------------
    {
        if($order_by=get('sort_'.$PH->cur_page->id."_persons_list")) {
            $order_by= str_replace(",",", ", $order_by);
        }
        else {
            $order_by='name';
        }

        $list= new ListBlock_persons();
        $list->reduced_header= true;
        $list->title= $page->title;
        unset($list->columns['profile']);
        unset($list->columns['projects']);
		#if(!confGet('PERSON_LAST_LOGIN')){
        #	unset($list->columns['last_login']);
		#}
        unset($list->columns['changes']);
		
		$list->filters[] = new ListFilter_persons();
		{
		    
			$preset = $presets[$preset_id];
			foreach($preset['filters'] as $f_name=>$f_settings) {
				switch($f_name) {
					case 'person_category':
						$list->filters[]= new ListFilter_person_category_min(array(
							'value'=>$f_settings['min'],
						));
						$list->filters[]= new ListFilter_person_category_max(array(
							'value'=>$f_settings['max'],
						));
						break;
					case 'can_login':
						$list->filters[]= new ListFilter_can_login(array(
							'value'=>$f_settings['value'],
						));
						break;
					case 'person_is_alive':
						$list->filters[]= new ListFilter_is_alive(array(
							'value'=>$f_settings['value'],
						));
						break;
					default:
						trigger_error("Unknown filter setting $f_name", E_USER_WARNING);
						break;
				}
			}
	
			$filter_empty_folders =  (isset($preset['filter_empty_folders']) && $preset['filter_empty_folders'])
								  ? true
								  : NULL;
		}
		
        if($auth->cur_user->user_rights & RIGHT_PERSON_CREATE) {
            $list->no_items_html=$PH->getLink('personNew','');
        }
        else {
            $list->no_items_html=__("no related persons");
        }
		
		$page->print_presets(array(
		    'target' => $preset_location,
		    'project_id' => '',
		    'preset_id' => $preset_id,
		    'presets' => $presets,
		    'person_id' => ''));
			
        
		$list->query_options['order_by'] = $order_by;
		$list->print_automatic();
		
        ## Link to start cvs export ##
        $format = get('format');
        if($format == FORMAT_HTML || $format == ''){
            echo $PH->getCSVLink();
        }
    }

    echo(new PageContentClose);
    echo(new PageHtmlEnd);

}

/**
* personListEmployee (all kinds of employees) @ingroup pages
*/
/*function personListEmployee()
{
    global $PH;
    global $auth;

    ### create from handle ###
    $PH->defineFromHandle();

    ### set up page and write header ####
    {
        $page= new Page();
        $page->cur_tab='people';
        $page->title=__('Employees','Pagetitle for person list');
        if(!($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
            $page->title_minor= sprintf(__("relating to %s","Page title Person list title add on"), asHtml($auth->cur_user->name));
        }
        else {
            $page->title_minor=__("admin view","Page title add on if admin");
        }
        #$page->type="List";
        $page->type=__('List','page type');

        $page->options=build_personList_options();

        ### page functions ###
        $page->add_function(new PageFunction(array(
            'target'    =>'personNew',
            'params'    =>array('perscat'=>PCATEGORY_STAFF),
            'icon'      =>'new',
            'tooltip'   =>__('New person'),
        )));

        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    #--- list persons --------------------------------------------------------
    {
        if($order_by=get('sort_'.$PH->cur_page->id."_persons_list")) {
            $order_by= str_replace(",",", ", $order_by);
        }
        else {
            $order_by='name';
        }

        $persons=Person::getPersons(array(
            'order_by'=>$order_by,
            'perscat'=>PCATEGORY_EMPLOYEE
        ));

        $list= new ListBlock_persons();
        $list->reduced_header= true;
        $list->title= $page->title;
        unset($list->columns['profile']);
        unset($list->columns['projects']);
        unset($list->columns['last_login']);
        unset($list->columns['changes']);

        if($auth->cur_user->user_rights & RIGHT_PERSON_CREATE) {
            $list->no_items_html=$PH->getLink('personNew','');
        }
        else {
            $list->no_items_html=__("no related persons");
        }
        #$list->render_list(&$persons);
        $list->print_automatic(&$persons);

        ## Link to start cvs export ##
        $format = get('format');
        if($format == FORMAT_HTML || $format == ''){
            #echo "<div class=description>" . $PH->getLink('personListEmployee', __('Export as CSV'),array('format'=>FORMAT_CSV)) . "</div>";
            echo $PH->getCSVLink();
        }
    }

    echo(new PageContentClose);
    echo(new PageHtmlEnd);
}*/


/**
* personListContact (all contact persons)  @ingroup pages
*/
/*function personListContact()
{
    global $PH;
    global $auth;

    ### create from handle ###
    $PH->defineFromHandle();

    ### set up page and write header ####
    {
        $page= new Page();
        $page->cur_tab='people';
        $page->title=__('Contact Persons','Pagetitle for person list');
        if(!($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
            $page->title_minor= sprintf(__("relating to %s","Page title Person list title add on"), asHtml($auth->cur_user->name));
        }
        else {
            $page->title_minor=__("admin view","Page title add on if admin");
        }
        #$page->type="List";
        $page->type=__('List','page type');

        $page->options=build_personList_options();

        ### page functions ###
        $page->add_function(new PageFunction(array(
            'target'    =>'personNew',
            'params'    =>array('perscat'=>PCATEGORY_CLIENT),
            'icon'      =>'new',
            'tooltip'   =>__('New person'),
        )));


        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    #--- list persons --------------------------------------------------------
    {
        if($order_by=get('sort_'.$PH->cur_page->id."_persons_list")) {
            $order_by= str_replace(",",", ", $order_by);
        }
        else {
            $order_by='name';
        }

        $persons=Person::getPersons(array(
            'order_by'=>$order_by,
             'perscat'=>PCATEGORY_CONTACT
        ));

        $list= new ListBlock_persons();
        $list->reduced_header= true;
        $list->title= $page->title;
        unset($list->columns['profile']);
        unset($list->columns['projects']);
        unset($list->columns['last_login']);
        unset($list->columns['changes']);

        if($auth->cur_user->user_rights & RIGHT_PERSON_CREATE) {
            $list->no_items_html=$PH->getLink('personNew','');
        }
        else {
            $list->no_items_html=__("no related persons");
        }
        #$list->render_list(&$persons);
        $list->print_automatic(&$persons);

        ## Link to start cvs export ##
        $format = get('format');
        if($format == FORMAT_HTML || $format == ''){
            #echo "<div class=description>" . $PH->getLink('personListContact', __('Export as CSV'),array('format'=>FORMAT_CSV)) . "</div>";
            echo $PH->getCSVLink();
        }
    }

    echo(new PageContentClose);
    echo(new PageHtmlEnd);
}*/

/**
* personListDeleted (all deleted persons)  @ingroup pages
*/
/*function personListDeleted()
{
    global $PH;
    global $auth;

    ### create from handle ###
    $PH->defineFromHandle();

    ### set up page and write header ####
    {
        $page= new Page();
        $page->cur_tab='people';
        $page->title=__("Deleted People");
        if(!($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
            $page->title_minor=sprintf(__('relating to %s','page title add on listing pages relating to current user'), $page->title_minor=$auth->cur_user->name);
        }
        else {
            $page->title_minor=__("admin view");
        }
        #$page->type=__("List");
        $page->type=__('List','page type');

        $page->options=build_personList_options();

        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    #--- list persons --------------------------------------------------------
    {
        if($order_by=get('sort_'.$PH->cur_page->id."_persons_list")) {
            $order_by= str_replace(",",", ", $order_by);
        }
        else {
            $order_by='name';
        }

        $persons=Person::getPersons(array(
            'order_by'=>$order_by,
            'is_alive'=>false,
        ));

        $list= new ListBlock_persons();
        $list->reduced_header= true;
        $list->add_col( new listBlockColDate(array(
            'key'=>'modified',
            'name'=>__('deleted')
        )));

        #$list->add_col( new ListBlockCol_ChangesByPerson());
        #$list->add_col( new ListBlockCol_ChangesItemState());

        $list->title= __("People/Project Overview");
        unset($list->columns['office_phone']);
        unset($list->columns['tagline']);
        unset($list->columns['personal_phone']);
        unset($list->columns['companies']);
        unset($list->columns['changes']);

        if($auth->cur_user->user_rights & RIGHT_PERSON_CREATE) {
            $list->no_items_html=$PH->getLink('personNew','');
        }
        else {
            $list->no_items_html=__("no related persons");
        }
        #$list->render_list(&$persons);
        $list->print_automatic(&$persons);

        ## Link to start cvs export ##
        $format = get('format');
        if($format == FORMAT_HTML || $format == ''){
            #echo "<div class=description>" . $PH->getLink('personListDeleted', __('Export as CSV'),array('format'=>FORMAT_CSV)) . "</div>";
            echo $PH->getCSVLink();
        }
    }

    echo(new PageContentClose);
    echo(new PageHtmlEnd);
}*/


/**
* Person View @ingroup pages
*/
function personView()
{
    global $PH;
    global $auth;

    ### get current person ###
    $id=getOnePassedId('person','persons_*');
    if(!$person= Person::getVisibleById($id)) {
        $PH->abortWarning("invalid person-id");
        return;
    }

    ### create from handle ###
    $PH->defineFromHandle(array('person'=>$person->id));

    ## is viewed by user ##
    $person->nowViewedByUser();

    ### set up page ####
    {
        $page= new Page();
        $page->cur_tab='people';
        if($person->can_login) {
            $page->title= $person->nickname;
            $page->title_minor= $person->name;
        }
        else {
            $page->title= $person->name;
            if($person->category) {
                global $g_pcategory_names;
                if(isset($g_pcategory_names[$person->category])) {
                    $page->title_minor= $g_pcategory_names[$person->category];
                }
            }
        }
        $page->type=__("Person");

        $page->crumbs = build_person_crumbs($person);
        $page->options= build_person_options($person);

        ### skip edit functions ###
        if($edit= Person::getEditableById($person->id)) {

            ### page functions ###
            $page->add_function(new PageFunction(array(
                'target'=>'taskNoteOnPersonNew',
                'params'=>array('person'=>$person->id),
                'tooltip'=>__('Add task for this persons (optionally creating project and effort on the fly)','Tooltip for page function'),
                'name'=>__('Add note','Page function person'),
            )));
            #$page->add_function(new PageFunction(array(
            #'target'    =>'personLinkCompanies',
            #'params'    =>array('person'=>$person->id),
            #'tooltip'   =>__('Add existing companies to this person'),
            #'name'      =>__('Companies'),
            #)));

            $page->add_function(new PageFunction(array(
                'target'=>'personEdit',
                'params'=>array('person'=>$person->id),
                'icon'=>'edit',
                'tooltip'=>__('Edit this person','Tooltip for page function'),
                'name'=>__('Edit profile','Page function edit person'),
            )));

            $page->add_function(new PageFunction(array(
                'target'=>'personEditRights',
                'params'=>array('person'=>$person->id),
                'icon'=>'edit',
                'tooltip'=>__('Edit User Rights','Tooltip for page function'),
                'name'=>__('Edit user Rights','Page function for edit user rights'),
            )));

            $item = ItemPerson::getAll(array('person'=>$auth->cur_user->id,'item'=>$person->id));
            if((!$item) || ($item[0]->is_bookmark == 0)){
                #$page->add_function(new PageFunction(array(
                #    'target'    =>'itemsAsBookmark',
                #    'params'    =>array('person'=>$person->id),
                #    'tooltip'   =>__('Mark this person as bookmark'),
                #    'name'      =>__('Bookmark'),
                #)));
            }
            else{
                $page->add_function(new PageFunction(array(
                    'target'    =>'itemsRemoveBookmark',
                    'params'    =>array('person'=>$person->id),
                    'tooltip'   =>__('Remove this bookmark'),
                    'name'      =>__('Remove Bookmark'),
                )));
            }

            if($person->state == ITEM_STATE_OK && $person->can_login && ($person->personal_email || $person->office_email)) {
                $page->add_function(new PageFunction(array(
                    'target'=>'personSendActivation',
                    'params'=>array('person'=>$person->id),
                )));
                $page->add_function(new PageFunction(array(
                    'target'=>'personsFlushNotifications',
                    'params'=>array('person'=>$person->id),
                )));
            }
        }


        ### render title ###
        echo(new PageHeader);
    }
    echo (new PageContentOpen_Columns);

    ### write info block (but only for registed users)
    global $auth;
    if($auth->cur_user->id != confGet('ANONYMOUS_USER')) {
        $block=new PageBlock(array('title'=>__('Summary','Block title'),'id'=>'summary'));
        $block->render_blockStart();
        echo "<div class=text>";
        #if($person->description) {
        #    echo wiki2html($person->description);
        #}

        if($person->mobile_phone) {
            echo "<div class=labeled><label>" . __('Mobile','Label mobilephone of person'). '</label>'. asHtml($person->mobile_phone). '</div>';
        }
        if($person->office_phone) {
            echo "<div class=labeled><label>" . __('Office','label for person'). '</label>'. asHtml($person->office_phone) . '</div>';
        }
        if($person->personal_phone) {
            echo "<div class=labeled><label>" . __('Private','label for person'). '</label>'. asHtml($person->personal_phone) .'</div>';
        }
        if($person->office_fax) {
            echo "<div class=labeled><label>" . __('Fax (office)','label for person'). '</label>'. asHtml($person->office_fax) .'</div>';
        }


        if($person->office_homepage) {
            echo "<div class=labeled><label>" . __('Website','label for person'). '</label>'.url2linkExtern($person->office_homepage).'</div>';
        }
        if($person->personal_homepage) {
            echo "<div class=labeled><label>" . __('Personal','label for person'). '</label>'.url2linkExtern($person->personal_homepage).'</div>';
        }

        if($person->office_email) {
            echo "<div class=labeled><label>" . __('E-Mail','label for person office email'). '</label>'.url2linkMail($person->office_email).'</div>';
        }
        if($person->personal_email) {
            echo "<div class=labeled><label>" . __('E-Mail','label for person personal email'). '</label>'.url2linkMail($person->personal_email).'</div>';
        }


        if($person->personal_street) {
            echo "<div class=labeled><label>" . __('Adress Personal','Label'). '</label>'. asHtml($person->personal_street) . '</div>';
        }
        if($person->personal_zipcode) {
            echo '<div class=labeled><label></label>'. asHtml($person->personal_zipcode) . '</div>';
        }

        if($person->office_street) {
            echo "<div class=labeled><label>" . __('Adress Office','Label'). '</label>'. asHtml($person->office_street) .'</div>';
        }
        if($person->office_zipcode) {
            echo "<div class=labeled><label></label>". asHtml($person->office_zipcode).'</div>';
        }

        if($person->birthdate && $person->birthdate != "0000-00-00") {
            echo "<div class=labeled><label>" . __('Birthdate','Label'). "</label>".renderDateHtml($person->birthdate)."</div>";
        }
		
		if($person->last_login) {
			echo "<div class=labeled><label>" . __('Last login','Label'). '</label>'. renderDateHtml($person->last_login) .'</div>';
		}
		

        ### functions ####
        echo "</div>";
        $block->render_blockEnd();
    }


    #--- list companies -----------------------------------
    {
        require_once(confGet('DIR_STREBER') . 'lists/list_companies.inc.php');
        $companies = $person->getCompanies();
        $list = new ListBlock_companies();
        $list->title = __('works for','List title');
        unset($list->columns['short']);
        unset($list->columns['homepage']);
        unset($list->columns['people']);
        unset($list->functions['companyDelete']);
        #unset($list->functions['companyNew']);

        /**
        * \todo We should provide a list-function to link more
        * people to this company. But therefore we would need to
        * pass the company's id, which is not possible right now...
        */
        $list->add_function(new ListFunction(array(
            'target'=>$PH->getPage('personLinkCompanies')->id,
            'name'  =>__('Link Companies'),
            'id'    =>'personLinkCompanies',
            'icon'  =>'add',
        )));
        $list->add_function(new ListFunction(array(
            'target'=>$PH->getPage('personCompaniesDelete')->id,
            'name'  =>__('Remove companies from person'),
            'id'    =>'personCompaniesDelete',
            'icon'  =>'sub',
            'context_menu'=>'submit',
        )));

        if($auth->cur_user->user_rights & RIGHT_PERSON_EDIT) {
            $list->no_items_html=
                $PH->getLink('personLinkCompanies',__('link existing Company'),array('person'=>$person->id))
                ." ". __("or")." "
                .$PH->getLink('companyNew',__('create new'),array('person'=>$person->id));
        }
        else {
            $list->no_items_html=__("no companies related");
        }
        #$list->no_items_html=__("no company");
        $list->render_list(&$companies);
    }

    echo(new PageContentNextCol);


    #--- description ----------------------------------------------------------------
    if($person->description!="") {
        $block=new PageBlock(array(
            'title'=>__('Person details'),
            'id'=>'persondetails',
            #'reduced_header'=>true,

        ));
        $block->render_blockStart();


        echo "<div class=text>";

        echo wiki2html($person->description);

        echo "</div>";

        $block->render_blockEnd();
    }


    ### list projects ###
    {
        /**
        *  \Note: passing colum to person->getProject is not simple...
        *  the sql-querry currently just querry project-persons, which do not contain anything usefull
        *  Possible solutions:
        *   - rewrite the querry-string
        *   - rewrite all order-keys to something like company.name
        */
        $order_by= get('sort_'.$PH->cur_page->id."_projects");

        require_once(confGet('DIR_STREBER') . 'lists/list_projects.inc.php');

        $projects= $person->getProjects($order_by);
        if($projects || $person->can_login) {

            $list=new ListBlock_projects();

            $list->title=__('works in Projects','list title for person projects');
            $list->id="works_in_projects";

            unset($list->columns['date_closed']);
            unset($list->columns['date_start']);
            unset($list->columns['tasks']);
            unset($list->columns['efforts']);

            unset($list->functions['projDelete']);
            unset($list->functions['projNew']);
            if($auth->cur_user->user_rights & RIGHT_PROJECT_CREATE) {
                $list->no_items_html=$PH->getLink('projNew','',array());
            }
            else {
                $list->no_items_html=__("no active projects");
            }

            $list->render_list(&$projects);
        }
    }

    ### list assigned tasks ###
    {
        require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');
        $list= new ListBlock_tasks(array(
            'active_block_function'=>'list'
        ));

        $list->query_options['assigned_to_person']= $person->id;
        unset($list->columns['created_by']);
        unset($list->columns['planned_start']);
        unset($list->columns['assigned_to']);
        $list->title= __('Assigned tasks');
        $list->no_items_html= __('No open tasks assigned');

        if(isset($list->block_functions['tree'])) {
            unset($list->block_functions['tree']);
            $list->block_functions['grouped']->default= true;
        }
        $list->print_automatic();
    }

    ### add company-id ###
    # note: some pageFunctions like personNew can use this for automatical linking
    #
    echo "<input type='hidden' name='person' value='$person->id'>";

    #echo "<a href=\"javascript:document.my_form.go.value='tasksMoveToFolder';document.my_form.submit();\">move to task-folder</a>";
    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}

/**
* display projects for person...  @ingroup pages
*/
function personViewProjects()
{
	global $PH;
    
    ### get current project ###
    $id = getOnePassedId('person','persons_*');
    
    if(!$person = Person::getVisibleById($id)) {
        $PH->abortWarning("invalid person-id");
        return;
    }
	
	$presets= array(
        ### all ###
        'all_related_projects' => array(
            'name'=> __('all'),
            'filters'=> array(
                'project_status'=> array(
                    'id'        => 'project_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => STATUS_UNDEFINED,
                    'max'       => STATUS_CLOSED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),

        ### open projects ###
        'open_related_projects' => array(
            'name'=> __('open'),
            'filters'=> array(
                'project_status'=> array(
                    'id'        => 'project_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => STATUS_UNDEFINED,
                    'max'       => STATUS_OPEN,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### closed projects ###
        'closed_related_projects' => array(
            'name'=> __('closed'),
            'filters'=> array(
                'project_status'=> array(
                    'id'        => 'project_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => STATUS_BLOCKED,
                    'max'       => STATUS_CLOSED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
	);
	
	## set preset location ##
    $preset_location = 'personViewProjects';
    
    ### get preset-id ###
    {
        $preset_id = 'all_related_projects';                           # default value
        if($tmp_preset_id = get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id = $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_personViewProjects_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id = get('STREBER_personViewProjects_preset')) {
            if(isset($presets[$tmp_preset_id])) {

                $preset_id = $tmp_preset_id;
            }
        }
    }
    ### create from handle ###
    $PH->defineFromHandle(array('person'=>$person->id, 'preset_id' =>$preset_id));
	
	### set up page ####
    {
        $page = new Page();
        $page->cur_tab = 'people';
        $page->title = $person->name;
        $page->title_minor = __('Projects','Page title add on');
        $page->type = __("Person");

        $page->crumbs = build_person_crumbs($person);
        $page->options = build_person_options($person);

        echo(new PageHeader);
    }
    echo (new PageContentOpen);
	
	#--- list projects --------------------------------------------------------------------------
    {
        $order_by = get('sort_'.$PH->cur_page->id."_projects");

        require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
        
        $list= new ListBlock_projects();
		unset($list->functions['effortNew']);
        unset($list->functions['projNew']);
        unset($list->functions['projNewFromTemplate']);
        $list->no_items_html= __('no projects yet');
        
        #$list->filters[] = new ListFilter_projects();
        {
            $preset = $presets[$preset_id];
            foreach($preset['filters'] as $f_name=>$f_settings) {
                switch($f_name) {
                    case 'project_status':
                        $list->filters[]= new ListFilter_status_min(array(
                            'value'=>$f_settings['min'],
                        ));
                        $list->filters[]= new ListFilter_status_max(array(
                            'value'=>$f_settings['max'],
                        ));
                        break;
                    default:
                        trigger_error("Unknown filter setting $f_name", E_USER_WARNING);
                        break;
                }
            }
    
            $filter_empty_folders =  (isset($preset['filter_empty_folders']) && $preset['filter_empty_folders'])
                                  ? true
                                  : NULL;
        }
        
        $page->print_presets(array(
        'target' => $preset_location,
        'project_id' => '',
        'preset_id' => $preset_id,
        'presets' => $presets,
        'person_id' => $person->id));
        
        $list->query_options['order_by'] = $order_by;
        $list->query_options['person'] = $person->id;
        $list->print_automatic();
        
        //$list->render_list(&$efforts);
    }
    
    echo '<input type="hidden" name="person" value="'.$person->id.'">';
	
	echo (new PageContentClose);
    echo (new PageHtmlEnd());
}

function personViewTasks()
{
	global $PH;
	global $auth;
    
    ### get current project ###
    $id = getOnePassedId('person','persons_*');
    
    if(!$person = Person::getVisibleById($id)) {
        $PH->abortWarning("invalid person-id");
        return;
    }
	
	$presets= array(
        ### all ###
        'all_tasks' => array(
            'name'=> __('all'),
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => STATUS_NEW,
                    'max'       => STATUS_CLOSED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            )
        ),
		
		### open tasks ###
        'new_tasks' => array(
            'name'=> __('new'),
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => STATUS_NEW,
                    'max'       => STATUS_NEW,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            )
        ),
		
        ### open tasks ###
        'open_tasks' => array(
            'name'=> __('open'),
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => STATUS_OPEN,
                    'max'       => STATUS_OPEN,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            )
        ),
		
        ### blocked tasks ###
        'blocked_tasks' => array(
            'name'=> __('blocked'),
            'filter_empty_folders'=>true,
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => STATUS_BLOCKED,
                    'max'       => STATUS_BLOCKED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            )
        ),


        ### to be approved ###
        'approve_tasks' => array(
            'name'=> __('needs approval'),
            'filter_empty_folders'=>true,
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => STATUS_COMPLETED,
                    'max'       => STATUS_COMPLETED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            )
        ),

        ### closed tasks ###
        'closed_tasks' => array(
            'name'=> __('closed'),
            'filter_empty_folders'=>false,
            'filters'=> array(
                'task_status'=> array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'values'    => array( STATUS_APPROVED, STATUS_CLOSED),
                    'min'       => STATUS_APPROVED,
                    'max'       => STATUS_CLOSED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(
                        ''
                    ),
                    'style'=> 'list',
                )
            )
        ),
    );

	## set preset location ##
	$preset_location = 'personViewTasks';

    ### get preset-id ###
    {
        $preset_id= 'all_tasks';                           # default value
        if($tmp_preset_id= get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_personViewTasks_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id= get('STREBER_personViewTasks_preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }
        }
    }

    ### create from handle ###
    $PH->defineFromHandle(array('person'=>$person->id, 'preset_id' =>$preset_id));
	
	### set up page ####
    {
        $page = new Page();
        $page->cur_tab = 'people';
        $page->title = $person->name;
        $page->title_minor = __('Tasks','Page title add on');
        $page->type = __("Person");

        $page->crumbs = build_person_crumbs($person);
        $page->options = build_person_options($person);

        echo(new PageHeader);
    }
    echo (new PageContentOpen);
	
	#--- list projects --------------------------------------------------------------------------
    {
        $order_by = get('sort_'.$PH->cur_page->id."_tasks");

        require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
        
		$list= new ListBlock_tasks(array(
            'active_block_function'=>'list'
        ));

        unset($list->columns['created_by']);
        unset($list->columns['planned_start']);
        unset($list->columns['assigned_to']);
		//unset($list->columns['efforts_estimated']);
        $list->no_items_html= __('no tasks yet');
        
        $list->filters[] = new ListFilter_tasks();
        {

        	$preset= $presets[$preset_id];
			foreach($preset['filters'] as $f_name=>$f_settings) {
				switch($f_name) {
	
					case 'task_status':
						$list->filters[]= new ListFilter_status_min(array(
							'value'=>$f_settings['min'],
						));
						$list->filters[]= new ListFilter_status_max(array(
							'value'=>$f_settings['max'],
						));
						break;
	
					default:
						trigger_error("Unknown filter setting $f_name", E_USER_WARNING);
						break;
				}
			}
	
			$filter_empty_folders=  (isset($preset['filter_empty_folders']) && $preset['filter_empty_folders'])
								 ? true
								 : NULL;
		}

    
        
        $page->print_presets(array(
        'target' => $preset_location,
        'project_id' => '',
        'preset_id' => $preset_id,
        'presets' => $presets,
        'person_id' => $person->id));
        
        
		$list->query_options['assigned_to_person']= $person->id;
		$list->query_options['person'] = $person->id;
        $list->print_automatic(NULL, NULL, true);
        
    }
    
    echo '<input type="hidden" name="person" value="'.$person->id.'">';
	
	echo (new PageContentClose);
    echo (new PageHtmlEnd());
}


/**
* display efforts for person...  @ingroup pages
*/
function personViewEfforts()
{
    global $PH;
	global $auth;
    
    ### get current project ###
    $id=getOnePassedId('person','persons_*');
    
    if(!$person= Person::getVisibleById($id)) {
        $PH->abortWarning("invalid person-id");
        return;
    }
    
    $presets= array(
        ### all ###
        'all_efforts' => array(
            'name'=> __('all'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_NEW,
                    'max'       => EFFORT_STATUS_BALANCED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),

        ### new efforts ###
        'new_efforts' => array(
            'name'=> __('new'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_NEW,
                    'max'       => EFFORT_STATUS_NEW,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### open efforts ###
        'open_efforts' => array(
            'name'=> __('open'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_OPEN,
                    'max'       => EFFORT_STATUS_OPEN,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### discounted efforts ###
        'discounted_efforts' => array(
            'name'=> __('discounted'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_DISCOUNTED,
                    'max'       => EFFORT_STATUS_DISCOUNTED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### not chargeable efforts ###
        'notchargeable_efforts' => array(
            'name'=> __('not chargeable'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_NOTCHARGEABLE,
                    'max'       => EFFORT_STATUS_NOTCHARGEABLE,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### balanced efforts ###
        'balanced_efforts' => array(
            'name'=> __('balanced'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_BALANCED,
                    'max'       => EFFORT_STATUS_BALANCED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
		
		## last logout ##
		'last_logout' => array(
            'name'=> __('last logout'),
            'filters'=> array(
                'last_logout'   => array(
                    'id'        => 'last_logout',
                    'visible'   => true,
                    'active'    => true,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		
		## 1 week ##
		'last_week' => array(
            'name'=> __('1 week'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
                    'visible'   => true,
                    'active'    => true,
					'factor'    => 7,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		
		## 2 weeks ##
		'last_two_weeks' => array(
            'name'=> __('2 weeks'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
                    'visible'   => true,
                    'active'    => true,
					'factor'    => 14,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		
		## 3 weeks ##
		'last_three_weeks' => array(
            'name'=> __('3 weeks'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
                    'visible'   => true,
                    'active'    => true,
					'factor'    => 21,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		
		## 1 month ##
		'last_month' => array(
            'name'=> __('1 month'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
                    'visible'   => true,
                    'active'    => true,
					'factor'    => 28,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		
		## prior ##
		'prior' => array(
            'name'=> __('prior'),
            'filters'=> array(
                'prior'    => array(
                    'id'        => 'prior',
                    'visible'   => true,
                    'active'    => true,
					'factor'    => 29,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
    );

    ## set preset location ##
    $preset_location = 'personViewEfforts';
    
    ### get preset-id ###
    {
        $preset_id= 'all_efforts';                           # default value
        if($tmp_preset_id= get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_personViewEfforts_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id= get('STREBER_personViewEfforts_preset')) {
            if(isset($presets[$tmp_preset_id])) {

                $preset_id= $tmp_preset_id;
            }
        }
    }
    ### create from handle ###
    $PH->defineFromHandle(array('person'=>$person->id, 'preset_id' =>$preset_id));

    ### set up page ####
    {
        $page= new Page();
        $page->cur_tab='people';
        $page->title=$person->name;
        $page->title_minor=__('Efforts','Page title add on');
        $page->type=__("Person");

        $page->crumbs = build_person_crumbs($person);
        $page->options= build_person_options($person);

        echo(new PageHeader);
    }
    echo (new PageContentOpen);



    #--- list efforts --------------------------------------------------------------------------
    {
        $order_by=get('sort_'.$PH->cur_page->id."_efforts");

        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');

        $list= new ListBlock_efforts();
        unset($list->functions['effortNew']);
        unset($list->functions['effortNew']);
        $list->no_items_html= __('no efforts yet');
        
        $list->filters[] = new ListFilter_efforts();
        {
            $preset = $presets[$preset_id];
            foreach($preset['filters'] as $f_name=>$f_settings) {
                switch($f_name) {
                    case 'effort_status':
                        $list->filters[]= new ListFilter_effort_status_min(array(
                            'value'=>$f_settings['min'],
                        ));
                        $list->filters[]= new ListFilter_effort_status_max(array(
                            'value'=>$f_settings['max'],
                        ));
                        break;
					case 'last_logout':
						$list->filters[]= new ListFilter_last_logout(array(
							'value'=>$f_settings['value'],
						));
					    break;
					case 'last_weeks':
						$list->filters[]= new ListFilter_min_week(array(
							'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
						));
						break;
					case 'prior':
						$list->filters[]= new ListFilter_max_week(array(
							'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
						));
					    break;
                    default:
                        trigger_error("Unknown filter setting $f_name", E_USER_WARNING);
                        break;
                }
            }
    
            $filter_empty_folders =  (isset($preset['filter_empty_folders']) && $preset['filter_empty_folders'])
                                  ? true
                                  : NULL;
        }
        
        $page->print_presets(array(
        'target' => $preset_location,
        'project_id' => '',
        'preset_id' => $preset_id,
        'presets' => $presets,
        'person_id' => $person->id));
        
        $list->query_options['order_by'] = $order_by;
        $list->query_options['person'] = $person->id;
        $list->print_automatic();
    }
    
    echo '<input type="hidden" name="person" value="'.$person->id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}

function personViewChanges()
{
	global $PH;
    global $auth;
	
    ### get current project ###
    $id = getOnePassedId('person','persons_*');
    
    if(!$person = Person::getVisibleById($id)) {
        $PH->abortWarning("invalid person-id");
        return;
    }
	
	### sets the presets ###
	$presets = array(
        ### all ###
        'all_changes' => array(
            'name'=> __('all'),
            'filters'=> array(
			    'task_status'   =>  array(
                    'id'        => 'task_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'    =>  STATUS_UNDEFINED,
					'max'    =>  STATUS_CLOSED,
                ),
			),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
		## last logout ##
		'last_logout' => array(
            'name'=> __('last logout'),
            'filters'=> array(
                'last_logout'   => array(
                    'id'        => 'last_logout',
                    'visible'   => true,
                    'active'    => true,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		## 1 week ##
		'last_week' => array(
            'name'=> __('1 week'),
            'filters'=> array(
                'last_week'   => array(
                    'id'        => 'last_week',
                    'visible'   => true,
                    'active'    => true,
					'factor'    => 7,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
		## 2 week ##
		'last_two_weeks' => array(
            'name'=> __('2 weeks'),
            'filters'=> array(
                'last_two_weeks'   => array(
                    'id'        => 'last_two_weeks',
                    'visible'   => true,
                    'active'    => true,
					'factor'    => 14,
					'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
    );

	## set preset location ##
	$preset_location = 'personViewChanges';

    ### get preset-id ###
    {
        $preset_id= 'last_two_weeks';                           # default value
        if($tmp_preset_id= get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_personViewChanges_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id= get('STREBER_personViewChanges_preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }
        }
    }

	### create from handle ###
    $PH->defineFromHandle(array('person'=>$person->id, 'preset_id'=>$preset_id));
	
	### set up page ####
    {
        $page= new Page();
        $page->cur_tab='people';
        $page->title=$person->name;
        $page->title_minor=__('Changes','Page title add on');
        $page->type=__("Person");

        $page->crumbs = build_person_crumbs($person);
        $page->options= build_person_options($person);

        echo(new PageHeader);
    }
    echo (new PageContentOpen);
	
	#--- list efforts --------------------------------------------------------------------------
    {
        require_once(confGet('DIR_STREBER') . './lists/list_changes.inc.php');
        

        $list= new ListBlock_changes();
        $list->no_items_html= __('no changes yet');
        
        $list->filters[] = new ListFilter_changes();
		{
			$preset = $presets[$preset_id];
			foreach($preset['filters'] as $f_name=>$f_settings) {
				switch($f_name) {
					case 'task_status':
						$list->filters[]= new ListFilter_status_min(array(
							'value'=>$f_settings['min'],
						));
						#$list->filters[]= new ListFilter_status_max(array(
						#    'value'=>$f_settings['max'],
						#));
						break;
					case 'last_logout':
						$list->filters[]= new ListFilter_last_logout(array(
							'value'=>$f_settings['value'],
						));
						break;
					case 'last_week':
						$list->filters[]= new ListFilter_min_week(array(
							'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
						));
						#$list->filters[]= new ListFilter_max_week(array(
						#	'value'=>$f_settings['value'],
						#));
						break;
					case 'last_two_weeks':
						$list->filters[]= new ListFilter_min_week(array(
							'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
						));
						#$list->filters[]= new ListFilter_max_week(array(
						#	'value'=>$f_settings['value'],
						#));
						break;
					default:
						trigger_error("Unknown filter setting $f_name", E_USER_WARNING);
						break;
				}
			}
	
			$filter_empty_folders =  (isset($preset['filter_empty_folders']) && $preset['filter_empty_folders'])
								  ? true
								  : NULL;
        }
        
        $page->print_presets(array(
        'target' => $preset_location,
        'project_id' => '',
        'preset_id' => $preset_id,
        'presets' => $presets,
        'person_id' => $person->id));
        
        $list->query_options['modified_by'] = $person->id;
        $list->print_automatic();
    }
    
    echo '<input type="hidden" name="person" value="'.$person->id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
	
}


/**
* Create a new person  @ingroup pages
*/
function personNew() {
    global $PH;
    global $auth;
    global $g_user_profile_names;
    global $g_user_profiles;

    $name=get('new_name')
        ? get('new_name')
        :__("New person");


    $default_profile_num= confGet('PERSON_PROFILE_DEFAULT');
    $default_profile    = $g_user_profiles[$default_profile_num];
    if(! $default_rights= $default_profile['default_user_rights']) {
        trigger_error("Undefined default profile requested. Check conf.inc.php and customize.inc.php.", E_USER_ERROR);
    }

    ### build new object ###
    $person_new= new Person(array(
        'id'                    => 0,                                           # temporary new
        'name'                  => $name,
        'profile'               => confGet('PERSON_PROFILE_DEFAULT'),
        'user_rights'           => $default_rights,
        'language'              => $auth->cur_user->language,
        'notification_period'   => 3,                                            # in days
        'can_login'             => 1,
        )
    );

    $PH->show('personEdit',array('person' => $person_new->id),$person_new);

}


/**
* Edit a person  @ingroup pages
*/
function personEdit($person=NULL)
{
    global $PH;
    global $auth;


    ### new object not in database ###
    if(!$person) {
        $id= getOnePassedId('person','persons_*');   # WARNS if multiple; ABORTS if no id found
        if(!$person= Person::getEditableById($id)) {
            $PH->abortWarning("ERROR: could not get Person");
            return;
        }
    }

    ### validate rights ###

    if(
        (
         $auth->cur_user->id == $person->id
         &&
         $auth->cur_user->user_rights & RIGHT_PERSON_EDIT_SELF
        )
        ||
        ($auth->cur_user->user_rights & RIGHT_PERSON_EDIT)
        ||
        (($auth->cur_user->user_rights & RIGHT_PERSON_CREATE)
         &&
         $person->id == 0

        )
    ) {
        $pass= true;
    }
    else {
        $PH->abortWarning(__("not allowed to edit"),ERROR_RIGHTS);

    }

    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>true, 'autofocus_field'=>'person_name'));
        $page->cur_tab='people';
        $page->type=__('Edit Person','Page type');
        $page->title=$person->name;
        $page->title_minor='';

        $page->crumbs= build_person_crumbs($person);
        $page->options=array(
            new NaviOption(array(
                'target_id' => 'personEdit',
            )),
        );
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### form background ###
    $block=new PageBlock(array(
        'id'    =>'person_edit',
        'reduced_header' => true,
    ));
    $block->render_blockStart();

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
        global $g_pcategory_names;

        $form=new PageForm();
        $form->button_cancel=true;

        $form->add($person->fields['name']->getFormElement(&$person));
		
		        
        ### profile and login ###
        if($auth->cur_user->user_rights & RIGHT_PERSON_EDIT_RIGHTS) {
            /**
            * if checkbox not rendered, submit might reset $person->can_login.
            * ...be sure the user_rights match
            */
            $form->add(new Form_checkbox("person_can_login",__('Person with account (can login)','form label'),$person->can_login));

        }

        $form->add($tab_group=new Page_TabGroup());

        ### account ###
        {
            $tab_group->add($tab=new Page_Tab("account",__("Account")));
            $fnick=$person->fields['nickname']->getFormElement(&$person);
            if($person->can_login) {
                $fnick->required= true;
            }
            $tab->add($fnick);

            ### show password-fields if can_login ###
            /**
            * since the password as stored as md5-hash, we can initiate current password,
            * but have have to make sure the it is not changed on submit
            */
            $fpw1=new Form_password('person_password1',__('Password','form label'),"__dont_change__", $person->fields['password']->tooltip);
            if($person->can_login) {
                $fpw1->required= true;
            }
            $tab->add($fpw1);

            $fpw2=new Form_password('person_password2',__('confirm Password','form label'),"__dont_change__",  $person->fields['password']->tooltip);
            if($person->can_login) {
                $fpw2->required= true;
            }
            $tab->add($fpw2);
			
			### authentication ###
			if(confGet('LDAP')){
				$authentication = array('streber'=>0, 'ldap'=>1);
				$tab->add(new Form_Dropdown('person_auth', __("Authentication with","form label"), $authentication, $person->ldap));
			}

            ### profile and login ###
            if($auth->cur_user->user_rights & RIGHT_PERSON_EDIT_RIGHTS) {
                global $g_user_profile_names;
                global $g_user_profiles;



                ### display "undefined" profile if rights changed ###
                # will be skipped when submitting
                $profile_num= $person->profile;
                $reset="";

                if(! $default_rights= $g_user_profiles[$profile_num]['default_user_rights']) {
                    trigger_error("undefined/invalid profile requested ($profile_num)", E_USER_ERROR);
                }

                $list = $g_user_profile_names;

                if($default_rights != $person->user_rights) {
                    $profile_num='-1';
                    $list['-1']= __('-- reset to...--');
                }

                $tab->add(new Form_Dropdown(
                    'person_profile',
                    __("Profile","form label"),
                    array_flip($list),
                    $profile_num
                ));
            }

            ### notification ###
            {
                $a=array(
                	sprintf(__('ASAP'),  -1)        => -1,
                    sprintf(__('daily'),  1)        =>  1,
                    sprintf(__('each 3 days'), 3)   =>  3,
                    sprintf(__('each 7 days'), 7)   =>  7,
                    sprintf(__('each 14 days'), 14) => 14,
                    sprintf(__('each 30 days'), 30) => 30,
                    __('Never')                     =>  0,
                );
                $p= $person->notification_period;
                if(!$person->settings & USER_SETTING_NOTIFICATIONS) {
                    $p= 0;
                }
                $tab->add(new Form_Dropdown('person_notification_period',  __("Send notifications","form label"), $a, $p));
                #$tab->add(new Form_checkbox("person_html_mail",__('Send mail as html','form label'),$person->settings & USER_SETTING_HTML_MAIL));
            }


            ## assigne to project ##
            {
                if($person->id == 0){
                    $prj_num = '-1';

                    $prj_names = array();
                    $prj_names['-1'] = __('- no -');

                    ## get all projects ##
                    if($projects = Project::getAll()){
                        foreach($projects as $p){
                            $prj_names[$p->id] = $p->name;
                        }

                        ## assigne new person to ptoject ##
                        $tab->add(new Form_Dropdown('assigned_prj', __('Assigne to project','form label'), array_flip($prj_names), $prj_num));
                    }
                }

            }

        }

        ### details ###
        {
            $tab_group->add($tab=new Page_Tab("details",__("Details")));

            ### category ###
            if($p= get('perscat')){
                $perscat = $p;
            }
            else {
                $perscat = $person->category;
            }
            $tab->add(new Form_Dropdown('pcategory',  __('Category','form label'),array_flip($g_pcategory_names), $perscat));


            $tab->add($person->fields['office_email']->getFormElement(&$person));
            $tab->add($person->fields['mobile_phone']->getFormElement(&$person));
            $tab->add($person->fields['office_phone']->getFormElement(&$person));
            $tab->add($person->fields['office_fax']->getFormElement(&$person));
            $tab->add($person->fields['office_street']->getFormElement(&$person));
            $tab->add($person->fields['office_zipcode']->getFormElement(&$person));
            $tab->add($person->fields['office_homepage']->getFormElement(&$person));

            $tab->add($person->fields['personal_email']->getFormElement(&$person));
            $tab->add($person->fields['personal_phone']->getFormElement(&$person));
            $tab->add($person->fields['personal_fax']->getFormElement(&$person));
            $tab->add($person->fields['personal_street']->getFormElement(&$person));
            $tab->add($person->fields['personal_zipcode']->getFormElement(&$person));
            $tab->add($person->fields['personal_homepage']->getFormElement(&$person));
            $tab->add($person->fields['birthdate']->getFormElement(&$person));
        }

        ### description ###
        {
            $tab_group->add($tab=new Page_Tab("description",__("Description")));

            $e= $person->fields['description']->getFormElement(&$person);
            $e->rows=20;
            $tab->add($e);
        }


        ### options ###
        {
            $tab_group->add($tab=new Page_Tab("options",__("Options")));


            $tab->add(new Form_checkbox("person_enable_efforts",__('Enable efforts'), $person->settings & USER_SETTING_ENABLE_EFFORTS));
            $tab->add(new Form_checkbox("person_enable_bookmarks",__('Enable bookmarks'), $person->settings & USER_SETTING_ENABLE_BOOKMARKS));


            ### theme and language ###
            {
                global $g_theme_names;
                if(count($g_theme_names)> 1) {
                    $tab->add(new Form_Dropdown('person_theme',  __("Theme","form label"), array_flip($g_theme_names), $person->theme));
                }

                global $g_languages;
                $tab->add(new Form_Dropdown('person_language', __("Language","form label"), array_flip($g_languages), $person->language));
            }

            ### time zone ###
            {
                global $g_time_zones;
                $tab->add(new Form_Dropdown('person_time_zone', __("Time zone","form label"), $g_time_zones, $person->time_zone));
            }



            ### effort-style ###
            $effort_styles=array(
                __("start times and end times")=> 1,
                __("duration")=> 2,
            );
            $effort_style= ($person->settings & USER_SETTING_EFFORTS_AS_DURATION)
                         ? 2
                         : 1;

            $tab->add(new Form_Dropdown('person_effort_style',  __("Log Efforts as"), $effort_styles, $effort_style));
            


            $tab->add(new Form_checkbox("person_filter_own_changes",__('Filter own changes from recent changes list'), $person->settings & USER_SETTING_FILTER_OWN_CHANGES));
        }
		
		## internal area ##
		{
			if((confGet('INTERNAL_COST_FEATURE')) && ($auth->cur_user->user_rights & RIGHT_VIEWALL) && ($auth->cur_user->user_rights & RIGHT_EDITALL)){
				$tab_group->add($tab=new Page_Tab("internal",__("Internal")));
				$tab->add($person->fields['salary_per_hour']->getFormElement(&$person));
			}
		}

        ### temp uid for account activation ###
        if($tuid = get('tuid')) {
            $form->add(new Form_Hiddenfield('tuid','',$tuid));
        }

        ### create another person ###
        if($auth->cur_user->user_rights & RIGHT_PERSON_CREATE && $person->id == 0) {
            #$form->add(new Form_checkbox("create_another","",));
            $checked= get('create_another')
            ? 'checked'
            : '';

            $form->form_options[]="<span class=option><input id='create_another' name='create_another' class='checker' type=checkbox $checked><label for='create_another'>" . __("Create another person after submit") . "</label></span>";     ;
        }

        #echo "<input type=hidden name='person' value='$person->id'>";
        $form->add(new Form_HiddenField('person','',$person->id));

        echo ($form);

        $PH->go_submit= 'personEditSubmit';

        ### pass company-id? ###
        if($c= get('company')) {
            echo "<input type=hidden name='company' value='$c'>";
        }

    }


    $block->render_blockEnd();

    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}



/**
* Submit changes to a person @ingroup pages
*/
function personEditSubmit()
{
    global $PH;
    global $auth;
    
    global $g_user_profile_names;
    global $g_user_profiles;
    

    ### cancel ? ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('home',array());
        }
        exit();
    }

    ### Validate form integrity
    if(!validateFormCrc()) {
        $PH->abortWarning(__('Invalid checksum for hidden form elements'));
    }

    ### get person ####
    $id= getOnePassedId('person');

    ### temporary obj, not in db
    if($id == 0) {
        $person= new Person(array('id'=>0));
    }
    else {
        if($tuid= get('tuid')) {
            // setCurUserByIdentifier have already been called, but somehow it was
            // called too early. Calling it a second time here won't hurt and fixes bug #3817
            $user= $auth->setCurUserByIdentifier($tuid); // will call asKey($tuid)
            if(!$user || $user->id != $id) {
                $PH->abortWarning(__("Malformed activation url"));
            }
        }
        if(!$person= Person::getEditableById($id)) {
            $PH->abortWarning(__("Could not get person"));
            return;
        }
    }

    ### person category ###
    $pcategory = get('pcategory');
    if($pcategory != NULL)
    {
        if($pcategory == -1)
        {
            $person->category = PCATEGORY_STAFF;
        }
        else if ($pcategory == -2)
        {
            $person->category = PCATEGORY_CONTACT;
        }
        else
        {
            $person->category = $pcategory;
        }
    }

    ### validate rights ###
    if(
        (
         $auth->cur_user->id == $person->id
         &&
         $auth->cur_user->user_rights & RIGHT_PERSON_EDIT_SELF
        )
        ||
        ($auth->cur_user->user_rights & RIGHT_PERSON_EDIT)
        ||
        (($auth->cur_user->user_rights & RIGHT_PERSON_CREATE)
         &&
         $person->id == 0

        )
    ) {
        $pass= true;
    }
    else {
        $PH->abortWarning(__("not allowed to edit"),ERROR_RIGHTS);
    }


    $flag_ok=true;      # update valid?

    # retrieve all possible values from post-data
    # NOTE:
    # - this could be an security-issue.
    # - TODO: as some kind of form-edit-behaviour to field-definition
    foreach($person->fields as $f) {
        $name=$f->name;
        $f->parseForm(&$person);
    }



    ### rights & theme & profile ###
    if($auth->cur_user->user_rights & RIGHT_PERSON_EDIT_RIGHTS) {

        /**
        * if profile != -1, it will OVERWRITE (or reinit) user_rights
        *
        * therefore persEdit set profil to 0 if rights don't fit profile. It will
        * then be skipped here
        */
        $profile_num= get('person_profile');

        if(!is_null($profile_num )) {
            if($profile_num != -1) {
                $person->profile= $profile_num;
                if(isset($g_user_profiles[$profile_num]['default_user_rights'])) {
                    $rights=$g_user_profiles[$profile_num]['default_user_rights'];
                    $person->user_rights= $rights;

                    /**
                    * add warning on changed profile
                    */
                    if($person->user_rights != $rights && $person->id) {
                        new FeedbackHint(__('The changed profile <b>does not affect existing project roles</b>! Those has to be adjusted inside the projects.'));
                    }
                }
                else {
                    trigger_error("Undefined profile requested ($profile_num)", E_USER_ERROR);
                }
            }
        }


        /**
        * NOTE, if checkbox is not rendered in editForm, user-account will be disabled!
        * there seems no way the be sure the checkbox has been rendered, if it is not checked in form
        */
        if($can_login= get('person_can_login')) {
            $person->can_login= 1;
        }
        else {
            $person->can_login= 0;
        }
    }

    ### notifications ###
    {
        $period= get('person_notification_period');

        ### turn off ###
        if($period === 0 || $period === "0") {
            $person->settings &= USER_SETTING_NOTIFICATIONS ^ RIGHT_ALL;
            $person->notification_period= 0;
        }
        else {
            $person->settings |= USER_SETTING_NOTIFICATIONS;

            $person->notification_period= $period;

            if($person->can_login && !$person->personal_email && !$person->office_email) {
                $flag_ok = false;
                $person->fields['office_email']->required=true;
                $person->fields['personal_email']->required=true;
                new FeedbackWarning(__("Sending notifactions requires an email-address."));
            }

        }

        if(get('person_html_mail')) {
            $person->settings |= USER_SETTING_HTML_MAIL;

        }
        else {
            $person->settings &= USER_SETTING_HTML_MAIL ^ RIGHT_ALL;
        }
    }

    ### effort style ###
    if($effort_style= get('person_effort_style')) {
        if($effort_style == EFFORT_STYLE_TIMES) {
            $person->settings &= USER_SETTING_EFFORTS_AS_DURATION ^ RIGHT_ALL;
        }
        else if($effort_style ==EFFORT_STYLE_DURATION) {
            $person->settings |= USER_SETTING_EFFORTS_AS_DURATION;
        }
        else {
            trigger_error("undefined person effort style", E_USER_WARNING);
        }
    }

    ### filter own changes ###
    if(get('person_filter_own_changes')) {
        $person->settings |= USER_SETTING_FILTER_OWN_CHANGES;
    }
    else {
        $person->settings &= USER_SETTING_FILTER_OWN_CHANGES ^ RIGHT_ALL;        
    }

    
    ### enable bookmarks ###
    if(get('person_enable_bookmarks')) {
        $person->settings |= USER_SETTING_ENABLE_BOOKMARKS;
    }
    else {
        $person->settings &= USER_SETTING_ENABLE_BOOKMARKS ^ RIGHT_ALL;        
    }

    if(get('person_enable_efforts')) {
        $person->settings |= USER_SETTING_ENABLE_EFFORTS;
    }
    else {
        $person->settings &= USER_SETTING_ENABLE_EFFORTS ^ RIGHT_ALL;        
    }


    ### time zone ###
    {
        $zone= get('person_time_zone');
        if($zone != NULL && $person->time_zone != (1.0 * $zone)) {
            $person->time_zone = 1.0 * $zone;

            if($zone == TIME_OFFSET_AUTO) {
                new FeedbackMessage(__("Using auto detection of time zone requires this user to relogin."));
            }
            else{
                $person->time_offset= $zone * 60.0 * 60.0;
                if($person->id == $auth->cur_user->id) {
                    $auth->cur_user->time_offset= $zone * 60.0 * 60.0;
                }
            }
        }
    }

    ### theme and lanuage ###
    {
        $theme= get('person_theme');
        if($theme != NULL) {
            $person->theme= $theme;

            ### update immediately / without page-reload ####
            if($person->id == $auth->cur_user->id) {
                $auth->cur_user->theme = $theme;
            }
        }

        $language= get('person_language');
        global $g_languages;
        if(isset($g_languages[$language])) {
            $person->language= $language;

            ### update immediately / without page-reload ####
            if($person->id == $auth->cur_user->id) {
                $auth->cur_user->language =$language;
                setLang($language);
            }
        }
    }

    $t_nickname= get('person_nickname');

    ### check if changed nickname is unique
    if($person->can_login || $person->nickname != "") {

        /**
        * actually this should be mb_strtolower, but this is not installed by default
        */
        if($person->nickname != strtolower($person->nickname)) {
            new FeedbackMessage(__("Nickname has been converted to lowercase"));
            $person->nickname = strtolower($person->nickname);
        }
		
		### authentication ###
		$p_auth = get('person_auth');
		if($p_auth){
			$person->ldap = 1;
		}
		else{
			$person->ldap = 0;
		}
		
        if($p2= Person::getByNickname($t_nickname)) { # another person with this nick?
            if($p2->id != $person->id) {
                new FeedbackWarning(__("Nickname has to be unique"));
                $person->fields['nickname']->required=true;
                $flag_ok = false;
            }
        }
    }

    ### password entered? ###
    $t_password1= get('person_password1');
    $t_password2= get('person_password2');
    $flag_password_ok=true;
    if(($t_password1 || $t_password2) && $t_password1!="__dont_change__") {

        ### check if password match ###
        if($t_password1 !== $t_password2) {
            new FeedbackWarning(__("Passwords do not match"));
            $person->fields['password']->required=true;
            $flag_ok = false;
            $flag_password_ok = false;
            $person->cookie_string= $auth->cur_user->calcCookieString();
        }

        ### check if password is good enough ###
        if($person->can_login) {
            $password_length= strlen($t_password1);
            $password_count_numbers= strlen(preg_replace('/[^\d]/','',$t_password1));
            $password_count_special= strlen(preg_replace('/[^\wd]/','',$t_password1));

            $password_value= -7 + $password_length + $password_count_numbers*2 + $password_count_special*4;
            if($password_value < confGet('CHECK_PASSWORD_LEVEL')){
                new FeedbackWarning(__("Password is too weak (please add numbers, special chars or length)"));
                $flag_ok= false;
                $flag_password_ok = false;
            }
        }

        if($flag_password_ok) {
            $person->password= md5($t_password1);
        }
    }


    if($flag_ok && $person->can_login) {
        if(!$person->nickname) {
            new FeedbackWarning(__("Login-accounts require a unique nickname"));
            $person->fields['nickname']->required=true;
            $person->fields['nickname']->invalid=true;

            $flag_ok=false;
        }
    }


    ### repeat form if invalid data ###
    if(!$flag_ok) {
        $PH->show('personEdit',NULL,$person);

        exit();
    }

    /**
    * store indentifier-string for login from notification & reminder - mails
    */
    $person->identifier= $person->calcIdentifierString();

    ### insert new object ###
    if($person->id == 0) {

        if(($person->settings & USER_SETTING_NOTIFICATIONS) && $person->can_login) {
            $person->settings |= USER_SETTING_SEND_ACTIVATION;
            new FeedbackHint(sprintf(__("A notification / activation  will be mailed to <b>%s</b> when you log out."), $person->name). " " . sprintf(__("Read more about %s."), $PH->getWikiLink('notifications')));
        }

        $person->notification_last = getGMTString(time() - $person->notification_period * 60*60*24 - 1);

        $person->cookie_string= $person->calcCookieString();

        if($person->insert()) {

            ### link to a company ###
            if($c_id= get('company')) {
                require_once(confGet('DIR_STREBER') . 'db/class_company.inc.php');

                if($c= Company::getVisibleById($c_id)) {
                    require_once(confGet('DIR_STREBER') . 'db/class_employment.inc.php');
                    $e= new Employment(array(
                        'id'=>0,
                        'person'=>$person->id,
                        'company'=>$c->id
                    ));
                    $e->insert();
                }
            }

            ## assigne to project ##
            require_once(confGet('DIR_STREBER') . 'db/class_projectperson.inc.php');
            $prj_num = get('assigned_prj');

            if(isset($prj_num)){
                if($prj_num != -1){
                    if($p= Project::getVisibleById($prj_num)){
                        $prj_person = new ProjectPerson(array(
                                'person' => $person->id,
                                'project' => $p->id,
                                'name' => $g_user_profile_names[$person->profile],
                                ));
                        $prj_person->insert();
                    }
                }
            }
            new FeedbackMessage(sprintf(__('Person %s created'), $person->getLink()));
        }
        else {
            new FeedbackError(__("Could not insert object"));
        }
    }

    ### ... or update existing ###
    else {
        $person->update();
    }

    if($auth->cur_user->id == $person->id) {
        $auth->cur_user= $person;
    }

    ### notify on change ###
    $person->nowChangedByUser();

    ### store cookie, if accountActivation ###
    if(get('tuid')) {
        $auth->removeUserCookie();
        $auth->storeUserCookie();
    }

    ### create another person ###
    if(get('create_another')) {
        if($c_id= get('company')) {
            $PH->show('personNew',array('company'=>$c_id));
        }
        else {
            $PH->show('personNew');
        }
    }
    else {
        ### display fromPage ####
        if(!$PH->showFromPage()) {
            $PH->show('home',array());
        }
    }
}


/**
* Delete a person
*/
function personDelete()
{
    global $PH;

    ### get person ####
    $ids= getPassedIds('person','persons_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some persons to delete"));
        return;
    }

    $counter=0;
    $errors=0;
    foreach($ids as $id) {
        if(!$p= Person::getEditableById($id)) {
            $PH->abortWarning("Invalid person-id!");
        }

        ### persons in project can't be deleted ###
        if($p->getProjectPersons(array(
            'alive_only' => false,
            'visible_only' => false 
        ))) {
          new FeedbackWarning(sprintf(__('<b>%s</b> has been assigned to projects and can not be deleted. But you can deativate his right to login.'), $p->getLink()));
        }
        else {
            if($p->delete()) {
                $counter++;
            }
            else {
                $errors++;
            }
        }
    }
    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to delete %s persons"), $errors));
    }
    else {
        new FeedbackMessage(sprintf(__("Moved %s persons to trash"),$counter));
    }

    ### display personList ####
    $PH->show('personList');

}


/**
* Send activation mail to a person @ingroup pages
*/
function personSendActivation()
{
    global $PH;

    ### get person ####
    $person_id= getOnePassedId('person','persons_*');

    if(!$person = Person::getEditableById($person_id)) {
        $PH->abortWarning(__("Insufficient rights"));
        exit();
    }


    if(!$person->office_email && !$person->personal_email) {
        $PH->abortWarning(__("Sending notifactions requires an email-address."));
        exit();
    }


    if(! ($person->user_rights & RIGHT_PERSON_EDIT_SELF)) {
        $PH->abortWarning(__("Since the user does not have the right to edit his own profile and therefore to adjust his password, sending an activation does not make sense."), ERROR_NOTE);
        exit();
    }

    if(! $person->can_login) {
        $PH->abortWarning(__("Sending an activation mail does not make sense, until the user is allowed to login. Please adjust his profile."), ERROR_NOTE);
        exit();
    }

    $person->settings |= USER_SETTING_NOTIFICATIONS;
    $person->settings |= USER_SETTING_SEND_ACTIVATION;

    {
        require_once(confGet('DIR_STREBER') . 'std/mail.inc.php');
        $n= new Notifier();
        if($n->sendPasswordReminder($person)) {
            new FeedbackMessage(__("Activation mail has been sent."));
        }
        #else {
        #    new FeedbackMessage(__("Sending notification e-mail failed."));
        #}
    }


    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('projView',array('prj'=>$person->project));
    }
}


/**
* Send notication mail for one person right now @ingroup pages
*/
function personsFlushNotifications()
{
    global $PH;
    global $auth;

    ### get person ####
    $ids= getPassedIds('person','persons_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some persons to notify"));
        return;
    }

    $counter=0;
    $errors=0;

    foreach($ids as $id) {
        if(!$p= Person::getEditableById($id)) {
            $PH->abortWarning("Invalid person-id!");
        }

        require_once(confGet('DIR_STREBER') . 'std/mail.inc.php');
        $n= new Notifier();

        ### persons in project can't be deleted ###
        if($n->sendNotifcationForPerson($p)) {
            $counter++;
        }
        else {
            $errors++;
        }
    }

    ### reset language ###
    setLang($auth->cur_user->language);
    
    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to mail %s persons"), $errors));
    }
    else {
        new FeedbackMessage(sprintf(__("Sent notification to %s person(s)"),$counter));
    }

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('projView',array('prj'=>$person->project));
    }
}


/**
* edit user rights of a person 
*
* @ingroup pages
*
* the user-rights-validation is checked by pageHandler (requires RIGHT_PERSON_EDIT_RIGHTS)
*/
function personEditRights($person=NULL)
{
    global $PH;
    global $auth;
    global $g_user_right_names;

    ### get person ####
    if(!$person) {
        $ids= getPassedIds('person','persons_*');

        if(!$ids) {
            $PH->abortWarning(__("Select some persons to edit"));
            return;
        }
        if(!$person= Person::getEditableById($ids[0])) {
            $PH->abortWarning(__("Could not get Person"));
        }
    }

    ### set up page and write header ####
    {
        $page= new Page(array('autofocus_field'=>'person_nickname'));
        $page->cur_tab='people';

        $page->crumbs= build_person_crumbs($person);
        $page->options=array(
            new NaviOption(array(
                'target_id' => 'personEditRights',
            )),
        );

        $page->type=__('Edit Person','page type');
        $page->title= $person->name;
        $page->title_minor=  __('Adjust user-rights');
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');

        echo "<div>";
        echo __("Please consider that activating login-accounts might trigger security-issues.");
        echo "</div>";

        $form=new PageForm();
        $form->button_cancel=true;

        $form->add(new Form_checkbox("person_can_login",__('Person can login','form label'),$person->can_login));

        foreach($g_user_right_names as $value=>$key) {
            $form->add(new Form_checkbox("right_".$value, $key, $person->user_rights & $value));
        }
        echo ($form);

        $PH->go_submit= $PH->getValidPageId('personEditRightsSubmit');
        echo "<input type=hidden name='person' value='$person->id'>";

    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}




/**
* Submit changes to user rights of a person
*
* @ingroup pages
*
* the user-rights-validation is checked by pageHandler (requires RIGHT_PERSON_EDIT_RIGHTS)
*/
function personEditRightsSubmit()
{
    global $PH;
    global $g_user_right_names;


    ### cancel ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('home',array());
        }
        exit();
    }

    ### get person ####
    $id= getOnePassedId('person');  # aborts if not found
    if(!$person = Person::getEditableById($id)) {
        $PH->abortWarning(__("Could not get person"));
        return;
    }

    $flag_ok= TRUE;     # was required for advanced form-validation (currently not required)


    ### get rights ###
    foreach($g_user_right_names as $value=>$key) {
        if(get("right_".$value)) {
            $person->user_rights |= $value;
        }
        else {
            $person->user_rights &= $value ^ RIGHT_ALL;
        }
    }


    /**
    * NOTE, if checkbox is not rendered in editForm, user-account will be disabled!
    * there seems no way the be sure the checkbox has been rendered, if it is not checked in form
    */
    if($can_login= get('person_can_login')) {
        $person->can_login= 1;
    }
    else {
        $person->can_login= 0;
    }

    ### if anything fine, update and go back ###
    if($flag_ok) {
        $person->update();
        new FeedbackMessage(__("User rights changed"));

        ### display taskView ####
        if(!$PH->showFromPage()) {
            $PH->show('home',array());
        }
    }
    ### otherwise return to form ###
    else {
        $PH->show('personEditRights',NULL,$person);
    }
}



/**
* Register a new Person @ingroup pages
*
*/
function personRegister($person=NULL)
{
    global $PH;
    global $auth;

    if(!confGet('REGISTER_NEW_USERS')) {
        $PH->abortWarning(__("Registering is not enabled"));

    }
    $person=new Person(array(
        'id'=>0,
        'description'=>__('Because we are afraid of spam bots, please provide some information about you and why you want to register.'),
    ));

    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>true, 'autofocus_field'=>'person_name'));
        $page->cur_tab='people';
        $page->type=__('Edit Person','Page type');
        $page->title= __("Register as a new user");
        $page->title_minor='';

        $page->crumbs= build_person_crumbs($person);
        $page->options=array(
            new NaviOption(array(
                'target_id' => 'personEdit',
            )),
        );
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
        global $g_pcategory_names;

        $form=new PageForm();
        $form->button_cancel=true;

        $form->add($person->fields['name']->getFormElement(&$person));

        $f= $person->fields['office_email']->getFormElement(&$person);
        $f->required= true;
        $form->add($f);

        #$form->add($person->fields['mobile_phone']->getFormElement(&$person));
        #$form->add($person->fields['office_phone']->getFormElement(&$person));
        #$form->add($person->fields['office_fax']->getFormElement(&$person));
        #$form->add($person->fields['office_street']->getFormElement(&$person));
        #$form->add($person->fields['office_zipcode']->getFormElement(&$person));
        #$form->add($person->fields['office_homepage']->getFormElement(&$person));

        #$form->add($person->fields['personal_email']->getFormElement(&$person));
        #$form->add($person->fields['personal_phone']->getFormElement(&$person));
        #$form->add($person->fields['personal_fax']->getFormElement(&$person));
        #$form->add($person->fields['personal_street']->getFormElement(&$person));
        #$form->add($person->fields['personal_zipcode']->getFormElement(&$person));
        #$form->add($person->fields['personal_homepage']->getFormElement(&$person));

        #$form->add($person->fields['birthdate']->getFormElement(&$person));


        ### profile and login ###

        #if($auth->cur_user->user_rights & RIGHT_PERSON_EDIT_RIGHTS) {
        #    /**
        #    * if checkbox not rendered, submit might reset $person->can_login.
        #    * ...be sure the user_rights match
        #    */
        #    $form->add(new Form_checkbox("person_can_login",__('Person with account (can login)','form label'),$person->can_login));
#
        #}


        $fnick=$person->fields['nickname']->getFormElement(&$person);
        $fnick->required= true;
        $form->add($fnick);

        ### show password-fields if can_login ###
        /**
        * since the password as stored as md5-hash, we can initiate current password,
        * but have have to make sure the it is not changed on submit
        */
        $fpw1=new Form_password('person_password1',__('Password','form label'),"", $person->fields['password']->tooltip);
        $fpw1->required= true;
        $form->add($fpw1);

        $fpw2=new Form_password('person_password2',__('confirm Password','form label'),"",  $person->fields['password']->tooltip);
        $fpw2->required= true;
        $form->add($fpw2);

        ### dropdown menu for person category ###
        if($p= get('perscat')){
            $perscat = $p;
        }
        else {
            $perscat = $person->category;
        }
        $form->add(new Form_Dropdown('pcategory',  __('Category','form label'),array_flip($g_pcategory_names), $perscat));

        ### notification ###
        {
            $a=array(
                sprintf(__('daily'),  1)        =>1,
                sprintf(__('each 3 days'), 3)   =>3,
                sprintf(__('each 7 days'), 7)   =>7,
                sprintf(__('each 14 days'), 14)  =>14,
                sprintf(__('each 30 days'), 30)  =>30,
                __('Never')                     =>0,
            );
            $p= $person->notification_period;
            if(!$person->settings & USER_SETTING_NOTIFICATIONS) {
                $p= 0;
            }
            $form->add(new Form_Dropdown('person_notification_period',  __("Send notifications","form label"), $a, $p));
            #$form->add(new Form_checkbox("person_html_mail",__('Send mail as html','form label'),$person->settings & USER_SETTING_HTML_MAIL));
        }


        ### theme and language ###
        {

            global $g_theme_names;
            if(count($g_theme_names)> 1) {
                $form->add(new Form_Dropdown('person_theme',  __("Theme","form label"), array_flip($g_theme_names), $person->theme));
            }

            global $g_languages;
            $form->add(new Form_Dropdown('person_language', __("Language","form label"), array_flip($g_languages), $person->language));
        }


        ### time zone ###
        {
            global $g_time_zones;

            $form->add(new Form_Dropdown('person_time_zone', __("Time zone","form label"), $g_time_zones, $person->time_zone));

        }
        $form->add($person->fields['description']->getFormElement(&$person));

        $form->addCaptcha();

        echo ($form);

        $PH->go_submit= 'personRegisterSubmit';


        ### pass company-id? ###
        if($c= get('company')) {
            echo "<input type=hidden name='company' value='$c'>";
        }
    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd);
}



/**
* Submit data of a newly registered person @ingroup pages
*/
function personRegisterSubmit()
{
    global $PH;
    global $auth;

    ### cancel ? ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('home',array());
        }
        exit();
    }

    if(!validateFormCrc()) {
        $PH->abortWarning(__('Invalid checksum for hidden form elements'));
    }


    $person= new Person(array('id'=>0));
    $person->user_rights= RIGHT_PERSON_EDIT_SELF;

    ### person category ###
    $pcategory = get('pcategory');
    if($pcategory != NULL)
    {
        if($pcategory == -1)
        {
            $person->category = PCATEGORY_STAFF;
        }
        else if ($pcategory == -2)
        {
            $person->category = PCATEGORY_CONTACT;
        }
        else
        {
            $person->category = $pcategory;
        }
    }
    

    $flag_ok=true;      # update valid?

    # retrieve all possible values from post-data
    # NOTE:
    # - this could be an security-issue.
    # - TODO: as some kind of form-edit-behaviour to field-definition
    foreach($person->fields as $f) {
        $name=$f->name;
        $f->parseForm(&$person);
    }

    $person->can_login= 1;

    ### notifications ###
    {
        $period= get('person_notification_period');

        ### turn off ###
        if($period === 0 || $period === "0") {
            $person->settings &= USER_SETTING_NOTIFICATIONS ^ RIGHT_ALL;
            $person->notification_period= 0;
        }
        else {
            $person->settings |= USER_SETTING_NOTIFICATIONS;

            $person->notification_period= $period;

            if($person->can_login && !$person->personal_email && !$person->office_email) {
                $flag_ok = false;
                $person->fields['office_email']->required=true;
                $person->fields['personal_email']->required=true;
                new FeedbackWarning(__("Sending notifactions requires an email-address."));
            }

        }

        if(get('person_html_mail')) {
            $person->settings |= USER_SETTING_HTML_MAIL;

        }
        else {
            $person->settings &= USER_SETTING_HTML_MAIL ^ RIGHT_ALL;
        }
    }


    ### time zone ###
    {
        $zone= get('person_time_zone');
        if($zone != NULL && $person->time_zone != (1.0 * $zone)) {
            $person->time_zone = 1.0 * $zone;

            if($zone == TIME_OFFSET_AUTO) {
                new FeedbackMessage(__("Using auto detection of time zone requires this user to relogin."));
            }
            else{
                $person->time_offset= $zone * 60.0 * 60.0;
                if($person->id == $auth->cur_user->id) {
                    $auth->cur_user->time_offset= $zone * 60.0 * 60.0;
                }
            }
        }
    }

    ### theme and lanuage ###
    {
        $theme= get('person_theme');
        if($theme != NULL) {
            $person->theme= $theme;

            ### update immediately / without page-reload ####
            if($person->id == $auth->cur_user->id) {
                $auth->cur_user->theme = $theme;
            }
        }

        $language= get('person_language');
        global $g_languages;
        if(isset($g_languages[$language])) {
            $person->language= $language;

            ### update immediately / without page-reload ####
            if($person->id == $auth->cur_user->id) {
                $auth->cur_user->language =$language;
                setLang($language);
            }
        }
    }

    if(!$person->name) {
        new FeedbackWarning(__("Login-accounts require a full name."));
        $person->fields['name']->required=true;
        $person->fields['name']->invalid=true;
        $flag_ok=false;
        
    }



    if(!$person->office_email) {
        new FeedbackWarning(__("Please enter an e-mail address."));
        $person->fields['office_email']->required=true;
        $person->fields['office_email']->invalid=true;
        $flag_ok=false;        
    }


    $t_nickname= get('person_nickname');
    if(!$person->nickname) {
        new FeedbackWarning(__("Login-accounts require a unique nickname"));
        $person->fields['nickname']->required=true;
        $person->fields['nickname']->invalid=true;

        $flag_ok=false;
    }


    ### check if changed nickname is unique
    if($person->can_login || $person->nickname != "") {

        /**
        * \todo actually this should be mb_strtolower, but this is not installed by default
        */
        if($person->nickname != strtolower($person->nickname)) {
            new FeedbackMessage(__("Nickname has been converted to lowercase"));
            $person->nickname = strtolower($person->nickname);
        }

        if($p2= Person::getByNickname($t_nickname)) { # another person with this nick?
            if($p2->id != $person->id) {
                new FeedbackWarning(__("Nickname has to be unique"));
                $person->fields['nickname']->required=true;
                $flag_ok = false;
            }
        }
    }

    ### password entered? ###
    $t_password1= get('person_password1');
    $t_password2= get('person_password2');
    $flag_password_ok=true;

    
    if(($t_password1 || $t_password2) && $t_password1!="__dont_change__") {

        ### check if password match ###
        if($t_password1 !== $t_password2) {
            new FeedbackWarning(__("Passwords do not match"));
            $person->fields['password']->required=true;
            $flag_ok = false;
            $flag_password_ok = false;
            $person->cookie_string= $auth->cur_user->calcCookieString();
        }
    }
    

    ### check if password is good enough ###
    $password_length= strlen($t_password1);
    $password_count_numbers= strlen(preg_replace('/[^\d]/','',$t_password1));
    $password_count_special= strlen(preg_replace('/[^\wd]/','',$t_password1));

    $password_value= -7 + $password_length + $password_count_numbers*2 + $password_count_special*4;
    if($password_value < confGet('CHECK_PASSWORD_LEVEL')){
        new FeedbackWarning(__("Password is too weak (please add numbers, special chars or length)"));
        $flag_ok= false;
        $flag_password_ok = false;
    }

    if($flag_password_ok) {
        $person->password= md5($t_password1);
    }


    if(! validateFormCaptcha()) {
        new FeedbackWarning(__("Please copy the text from the image."));
        $flag_ok=false;
    }



    ### repeat form if invalid data ###
    if(!$flag_ok) {
        $PH->show('personRegister',NULL,$person);
        exit();
    }
    
    /**
    * store indentifier-string for login from notification & reminder - mails
    */
    $person->identifier= $person->calcIdentifierString();

    ### insert new object ###

    if(($person->settings & USER_SETTING_NOTIFICATIONS) && $person->can_login) {
        $person->settings |= USER_SETTING_SEND_ACTIVATION;
        new FeedbackHint(sprintf(__("A notification / activation  will be mailed to <b>%s</b> when you log out."), $person->name). " " . sprintf(__("Read more about %s."), $PH->getWikiLink('notifications')));
    }

    $person->notification_last = getGMTString(time() - $person->notification_period * 60*60*24 - 1);

    $person->cookie_string= $person->calcCookieString();

    if($person->insert()) {
        new FeedbackHint(__("Thank you for registration! After your request has been approved by a moderator, you will can an email."));
        ### link to a company ###
        if($c_id= get('company')) {
            require_once(confGet('DIR_STREBER') . 'db/class_company.inc.php');

            if($c= Company::getVisibleById($c_id)) {
                require_once(confGet('DIR_STREBER') . 'db/class_employment.inc.php');
                $e= new Employment(array(
                    'id'=>0,
                    'person'=>$person->id,
                    'company'=>$c->id
                ));
                $e->insert();
            }
        }

        ## assigne to project ##
        require_once(confGet('DIR_STREBER') . 'db/class_projectperson.inc.php');
        $prj_num = confGet('REGISTER_NEW_USERS_TO_PROJECT');

        global $g_user_profile_names;
        if(isset($prj_num)){
            if($prj_num != -1){
                if($p= Project::getVisibleById($prj_num)){
                    $prj_person = new ProjectPerson(array(
                            'person' => $person->id,
                            'project' => $p->id,
                            'name' => $g_user_profile_names[$person->profile],
                            ));
                    $prj_person->insert();
                }
            }
        }
        new FeedbackMessage(sprintf(__('Person %s created'), $person->getLink()));

        ### automatically login ###
        $foo= array(
            'login_name' => $person->nickname,
            'login_password_md5' => $person->password,
        );
        addRequestVars($foo);
        $PH->show('loginFormSubmit',array());
        exit();
    }
    else {
        new FeedbackError(__("Could not insert object"));
    }

    ### display fromPage ####
    if(!$PH->showFromPage()) {
        $PH->show('home',array());
    }
}


/**
* Link companies to person @ingroup pages
*/
function personLinkCompanies() {
    global $PH;

    $id = getOnePassedId('person','persons_*');   # WARNS if multiple; ABORTS if no id found
    $person = Person::getEditableById($id);
    if(!$person) {
        $PH->abortWarning("ERROR: could not get Person");
        return;
    }

    ### set up page and write header ####
    {
        $page = new Page(array('use_jscalendar'=>true, 'autofocus_field'=>'company_name'));
        $page->cur_tab = 'people';
        $page->type = __("Edit Person");
        $page->title = sprintf(__("Edit %s"),$person->name);
        $page->title_minor = __("Add related companies");


        $page->crumbs = build_person_crumbs($person);
        $page->options[] = new NaviOption(array(
            'target_id'     => 'personLinkCompanies',
        ));

        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . 'pages/company.inc.php');
        require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
        $companies = Company::getAll();
        $list = new ListBlock_companies();
        $list->show_functions = false;
        $list->show_icons = false;

        $list->render_list(&$companies);

        $PH->go_submit = 'personLinkCompaniesSubmit';

        echo "<input type=hidden name='person' value='$person->id'>";
        echo "<input class=button2 type=submit>";

    }
    echo (new PageContentClose);
    echo (new PageHtmlEnd);

}

/**
* companyLinkPersonsSubmit @ingroup pages
*/
function personLinkCompaniesSubmit()
{
    global $PH;
    require_once(confGet('DIR_STREBER') . 'db/class_company.inc.php');

    $id = getOnePassedId('person','persons_*');
    $person = Person::getEditableById($id);
    if(!$person) {
        $PH->abortWarning("Could not get object...");
    }

    $company_ids = getPassedIds('company','companies_*');
    if(!$company_ids) {
        $PH->abortWarning(__("No companies selected..."));
    }

    $employments = $person->getEmployments();

    foreach($company_ids as $cid) {
        if(!$company = Company::getEditableById($cid)) {
            $PH->abortWarning("Could not access company by id");
        }

        #### company already related to person? ###
        $already_in = false;
        foreach($employments as $e) {
            if($e->company == $company->id) {
                $already_in = true;
                break;
            }
        }
        if(!$already_in) {
            $e_new = new Employment(array(
                'id'=>0,
                'person'=>$person->id,
                'company'=>$company->id,
            ));
            $e_new->insert();
        }
        else {
            new FeedbackMessage(__("Company already related to person"));
        }
    }
    ### display personView ####
    if(!$PH->showFromPage()) {
        $PH->show('personView',array('person'=>$person->id));
    }
}

/**
* Unlink a person from a company @ingroup pages
*/
function personCompaniesDelete()
{
    global $PH;

    $id = getOnePassedId('person','persons_*');
    $person = Person::getEditableById($id);
    if(!$person) {
        $PH->abortWarning("Could not get object...");
    }

    $company_ids = getPassedIds('company','companies_*');
    if(!$company_ids) {
        $PH->abortWarning(__("No companies selected..."));
    }

    $employments = $person->getEmployments();

    $counter = 0;
    $errors = 0;
    foreach($company_ids as $cid) {
        if(!$company = Company::getEditableById($cid)) {
            $PH->abortWarning("Could not access company by id");
        }

        $assigned_to = false;
        foreach($employments as $e) {
            if($e->company == $company->id) {
                $assigned_to = true;
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
                    $PH->abortWarning("Company isn't related to this person");
                }
            }
        }
    }

    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to remove %s companies"),$errors));
    }
    else {
        new FeedbackMessage(sprintf(__("Removed %s companies"), $counter));
    }

    if(!$PH->showFromPage()) {
        $PH->show('personView',array('person'=>$person->id));
    }
}






/**
* Mark all items of a person as been viewed @ingroup pages
*
* if an item is viewed (not changed) depends on two facts:
* 1. item_person item exists
* 2. item.modfied < person.date_highlight_changes
*/
function personAllItemsViewed()
{
    global $PH;
    global $auth;

    $id = intval(getOnePassedId('person','persons_*'));
    if($id) {
        if($id == $auth->cur_user->id) {
            $person= $auth->cur_user;
        }
        else {
            $person = Person::getEditableById($id);
            if(!$person) {
                $PH->abortWarning("Could not get object...");
            }
        }
    }
    else {
        ### profile and login ###
        if($auth->cur_user->user_rights & RIGHT_PERSON_EDIT_RIGHTS) {
            $person= $auth->cur_user;
        }
        else {
            $PH->abortWarning("Could not get object...");
        }
    }

    $person->date_highlight_changes = getGMTString();
    $person->update(array('date_highlight_changes'),false);

    /**
    * note, we have to update the current user to get an emmidate effect
    */
    if($auth->cur_user->id == $person->id) {
        $auth->cur_user->date_highlight_changes = getGMTString();
    }

    new FeedbackMessage(sprintf(__("Marked all previous items as viewed.")));

    if(!$PH->showFromPage()) {
        $PH->show('personView',array('person'=>$person->id));
    }
}



/**
* Filter own changes
*
*/
function personToggleFilterOwnChanges()
{
    global $PH;
    global $auth;

    ### get person ####
    $id= getOnePassedId('person','persons_*');

    if(!$p= Person::getEditableById($id)) {
        $PH->abortWarning("Invalid person-id!");
    }

    $p->settings ^= USER_SETTING_FILTER_OWN_CHANGES;
    $p->update(array('settings'), false);

    if( $auth->cur_user && $p->id == $auth->cur_user->id) {
      $auth->cur_user->settings ^= USER_SETTING_FILTER_OWN_CHANGES;    
    }

    ### display taskView ####
    if(!$PH->showFromPage()) {
        $PH->show('projView',array('prj'=>$person->project));
    }
}


?>
