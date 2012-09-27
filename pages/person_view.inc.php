<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file
 * remove items of certain types and own
 *
 * @author Thomas Mann
 *
 */

require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_comment.inc.php');
require_once(confGet('DIR_STREBER') . 'db/db_itemchange.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_misc.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_wiki.inc.php');

/**
* Person View @ingroup pages
*/
function personView()
{
    global $PH;
    global $auth;

    ### get current person ###
    $id=getOnePassedId('person','people_*');
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
                'tooltip'=>__('Add task for this people (optionally creating project and effort on the fly)','Tooltip for page function'),
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
                'name'=>__('Edit','Page function edit person'),
            )));

            $page->add_function(new PageFunction(array(
                'target'=>'personEditRights',
                'params'=>array('person'=>$person->id),
                'icon'=>'edit',
                'tooltip'=>__('Edit user rights','Tooltip for page function'),
                'name'=>__('Edit rights','Page function for edit user rights'),
            )));
            
            if($person->id != $auth->cur_user->id) {
                $page->add_function(new PageFunction(array(
                    'target'=>'personDelete',
                    'params'=>array('person'=>$person->id),
    #                'icon'=>'delete',
    #                'tooltip'=>__('Remove','Tooltip for page function'),
                    'name'=>__('Delete'),
                )));            
            }

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
                    'target'=>'peopleFlushNotifications',
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
        $list->render_list($companies);
    }

    echo(new PageContentNextCol);


    #--- description ----------------------------------------------------------------
    if($person->description!="") {
        $block=new PageBlock(array(
            'title'=>__('Person details'),
            'id'=>'persondetails',

        ));
        $block->render_blockStart();


        echo "<div class=text>";

        echo wikifieldAsHtml($person, 'description');

        echo "</div>";

        $block->render_blockEnd();
    }


    ### list projects ###
    {
        /**
        *  \Note: passing colum to person->getProject is not simple...
        *  the sql-querry currently just querry project-people, which do not contain anything usefull
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

            $list->render_list($projects);
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

?>