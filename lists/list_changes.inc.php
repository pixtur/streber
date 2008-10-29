<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**
 * derived ListBlock-class for listing changes of an project (second try)
 *
 * @includedby:     pages/*
 *
 * @author         Thomas Mann
 * @uses:           ListBlock
 * @usedby:

*/

require_once(confGet('DIR_STREBER') . 'db/class_comment.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_page.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . "db/db_itemchange.inc.php");
require_once(confGet('DIR_STREBER') . 'std/class_changeline.inc.php');


class ListBlock_changes extends ListBlock
{
    private  $list_changes_newer_than= '';                      # timestamp
    public   $filters = array();

    public function __construct($args=NULL)
    {
        parent::__construct($args);

        $this->bg_style= 'bg_time';

        global $PH;
        global $auth;

        $this->id='changes';

        $this->title=__("Changes");
        $this->id="changes";
        $this->no_items_html= sprintf(__('Other team members changed nothing since last logout (%s)'), renderDate($auth->cur_user->last_logout));


        $this->add_col( new ListBlockCol_ChangesDate());
        $this->add_col( new ListBlockCol_ChangesWhat());
        $this->add_col( new ListBlockCol_ChangesDetails());
        
    }



    public function print_automatic()
    {
        global $PH;
        global $auth;
                
        ### add filter options ###
        foreach($this->filters as $f) {
            foreach($f->getQuerryAttributes() as $k=>$v) {
                $this->query_options[$k]= $v;
            }
        }
                
        if($auth->cur_user->user_rights & RIGHT_VIEWALL){
            $this->query_options['visible_only'] = false;
        }
        else{
            $this->query_options['visible_only'] = true;
        }
        #$changes= ChangeLine::getChangeLinesForPerson($auth->cur_user, NULL);
        #$this->query_options['not_modified_by']= $auth->cur_user->id;
        $changes= ChangeLine::getChangeLines($this->query_options);

        $this->render_list(&$changes);

    }



    /**
    * render complete
    */
    public function render_list(&$changes=NULL)
    {
        global $PH;



        $this->render_header();

        if(!$changes && $this->no_items_html) {
            $this->render_tfoot_empty();
        }
        else {

            $style='changeList';

            ### render table lines ###
            $this->render_thead();

            $last_group= NULL;
            
            foreach($changes as $c) {

                $this->render_trow(&$c,$style);
            }

            $this->render_tfoot();
        }
    }
}



/**
* prints person causing change (depending what happed last)
*
*/
class ListBlockCol_ChangesDate extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Date');
        $this->tooltip=__("Who changed what when...");
    }

    function render_tr(&$change_line, $style="")
    {
        if($change_line instanceof ChangeLine) {
            if($change_line->person_by) {
                if($person= Person::getVisibleById($change_line->person_by)) {
                    print '<td><span class=date>'.renderDateHtml($change_line->timestamp) .'</span><br><span class="sub who">by '. $person->getLink() .'</span></td>';
                    return;
                }

            }
            print '<td><span class=date>'.renderDateHtml($change_line->timestamp) .'</span></td>';
        }
        else {
            trigger_error('ListBlockCol_ChangesDate() requires instance of ChangeLine',E_USER_WARNING);
            print "<td></td>";
        }
    }
}



/**
* prints person causing change (depending what happed last)
*
*/
class ListBlockCol_ChangesWhat extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('what','column header in change list');
        $this->width ='10%';
    }

    function render_tr(&$change_line, $style="")
    {
        if(!$change_line instanceof ChangeLine) {
            trigger_error('ListBlockCol_ChangesWhat() requires instance of ChangeLine',E_USER_WARNING);
            print "<td></td>";
            return;
        }

        if($change_line->html_what) {
            $str_what= $change_line->html_what;
        }
        else {
            $str_what='';
        }

        $html_assignment= $change_line->html_assignment
                        ? '<span class=assigment>' . $change_line->html_assignment . '</span>'
                        : '';

        print '<td><span class=nowrap>'. $str_what .'</span><br><span class="sub who">'. $html_assignment .'</span></td>';
    }
}




/**
* prints person causing change (depending what happed last)
*
*/
class ListBlockCol_ChangesDetails extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Task');
        $this->width ='80%';
    }

    function render_tr(&$change_line, $style="")
    {
        global $PH;
        if(!$change_line instanceof ChangeLine) {
            trigger_error('ListBlockCol_ChangesDetails() requires instance of ChangeLine',E_USER_WARNING);
            print "<td></td>";
            return;
        }
        $str_item= "";
        $str_details ="";

        if($change_line->task_html) {
            $str_item= $change_line->task_html;
        }
        else if($change_line->item) {
            if($change_line->item->type == ITEM_TASK) {
            
                global $auth;
                $task= $change_line->item;
                
                $str_item= "<b>" . $task->getLink(false) . "</b>" . ' <span class=itemid>#' . $task->id . '</span>';
                
                if($task->status >= STATUS_COMPLETED) {
                    $str_item= '<span class=isDone>'. $str_item.'</span>';
                }

                $str_details= $change_line->html_details
                         ? $change_line->html_details
                         : "";                
            }
            else if($change_line->item->type == ITEM_FILE) {
                $str_item= $PH->getLink('fileView', $change_line->item->name, array('file' => $change_line->item->id)); 
                
                $str_details= $change_line->item->renderLocation();
                
            }
            
        }
        else if($change_line->item_id) {
        }


        print '<td>'.$str_item .'<br><span class="sub">'. $str_details.'</span></td>';
    }
}












/**
* prints person causing change (depending what happed last)
*
*/
class ListBlockCol_ChangesDatePerson extends ListBlockCol
{

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name     =__('Date / by');
        $this->tooltip=__("Who changed what when...");
    }

    function render_tr(&$item, $style="")
    {
        $date_created=  $item->created;
        $date_modified= $item->modified;
        $date_deleted=  $item->deleted;

        $person=NULL;
        $str="";
        if($date_deleted >= $date_modified) {
            $person= Person::getVisibleById($item->deleted_by);
        }
        else if($date_modified > $date_created) {
            $person= Person::getVisibleById($item->modified_by);
        }
        else {
            $person= Person::getVisibleById($item->created_by);
        }

        $str_link="";
        if($person) {
            $str_link=$person->getLink();
        }
        print '<td><span class=date>'.$renderTimestampHtml($date_modified) .'</span><span class=sub>'. $person->getLink() .'</span></td>';
    }
}













/**
* depreciated listing of changes
*/
class ListBlock_AllChanges extends ListBlock
{
    public $bg_style = "bg_time";
    public $filters = array();

    public function __construct($args=NULL)
    {
        parent::__construct($args);

        global $PH;
        global $auth;

        $this->id = 'allchanges';

        $this->title = __("Changes");
        $this->id = "allchanges";
        $this->no_items_html = __('Nothing has changed.');

        $this->add_col( new ListBlockColSelect());
        ## from list_projectchanages.inc.php ##
        $this->add_col(new ListBlockCol_ChangesByPerson());
        $this->add_col(new ListBlockCol_ChangesEditType());
        $this->add_col(new ListBlockCol_ChangesItemType());
        $this->add_col(new ListBlockCol_AllChangesItemName());
        $this->add_col( new listBlockColDate(array(
            'key'=>'modified',
            'name'=>__('modified')
        )));


       ### block style functions ###
        $this->add_blockFunction(new BlockFunction(array(
            'target'=>'changeBlockStyle',
            'key'=>'list',
            'name'=>'List',
            'params'=>array(
                'style'=>'list',
                'block_id'=>$this->id,
                'page_id'=>$PH->cur_page->id,
             ),
             'default'=>true,
        )));
        $this->groupings= new BlockFunction_grouping(array(
            'target'=>'changeBlockStyle',
            'key'=>'grouped',
             'name'=>'Grouped',
             'params'=>array(
               'style'=>'grouped',
               'block_id'=>$this->id,
               'page_id'=>$PH->cur_page->id,
           ),
       ));
       $this->add_blockFunction($this->groupings);


       ### list groupings ###
       $this->groupings->groupings= array(
           new ListGroupingModifiedBy(),
           new ListGroupingItemType(),
       );
   }

    public function print_automatic()
    {
        global $PH;

        if(!$this->active_block_function=$this->getBlockStyleFromCookie()) {
            $this->active_block_function = 'list';
        }

        $this->query_options['alive_only'] = false;

        $this->group_by= get("blockstyle_{$PH->cur_page->id}_{$this->id}_grouping");

        $s_cookie= "sort_{$PH->cur_page->id}_{$this->id}_{$this->active_block_function}";
        if($sort= get($s_cookie)) {
            $this->query_options['order_by']= $sort;
        }

        ### add filter options ###
        foreach($this->filters as $f) {
            foreach($f->getQuerryAttributes() as $k=>$v) {
                $this->query_options[$k]= $v;
            }
        }

        ### grouped view ###
        if($this->active_block_function == 'grouped') {

            /**
            * @@@ later use only once...
            *
            *   $this->columns= filterOptions($this->columns,"CURPAGE.BLOCKS[{$this->id}].STYLE[{$this->active_block_function}].COLUMNS");
            */
            if(isset($this->columns[ $this->group_by ])) {
                unset($this->columns[$this->group_by]);
            }

            ### prepend key to sorting ###
            if(isset($this->query_options['order_by'])) {
                $this->query_options['order_by'] = $this->groupings->getActiveFromCookie() . ",".$this->query_options['order_by'];

            }
            else {
                $this->query_options['order_by'] = $this->groupings->getActiveFromCookie();
            }
        }
        ### list view ###
        else {
            $pass= true;
        }

        $changes = DbProjectItem::getChanges($this->query_options);

        $this->render_list(&$changes);
    }
}

class ListBlockCol_AllChangesItemName extends ListBlockCol
{
    public $width = "80%";

    public function __construct($args=NULL) {
        parent::__construct($args);
        $this->name = __('Name');
    }

    function render_tr(&$obj, $style="")
    {
        global $PH;

        $str_url="";
        $str_name="";
        $str_addon="";
        switch($obj->type) {
            case ITEM_PROJECT:
                if($project = Project::getVisibleById($obj->id)) {
                    $str_name = asHtml($project->name);
                    $str_url = $PH->getUrl('projView',array('prj'=>$project->id));
                }
                break;

            case ITEM_TASK:
                if($task = Task::getVisibleById($obj->id)) {
                    $str_name = asHtml($task->name);
                    $str_url = $PH->getUrl('taskView',array('tsk'=>$task->id));
                    if($project = Project::GetVisibleById($task->project)){
                        $str_addon = "(".$project->getLink(false).")";
                    }
                }
                break;

            case ITEM_COMMENT:
                if($comment = Comment::getVisibleById($obj->id)) {
                    if($comment->name == ''){
                        $str_name = "-";
                    }
                    else{
                        $str_name = asHtml($comment->name);
                    }
                    $str_url = $PH->getUrl('taskView',array('tsk'=>$comment->task));
                    $str_addon .= "(";
                    if($task = Task::getVisibleById($comment->task)){
                        if($project = Project::getVisibleById($task->project)){
                            $str_addon .= $project->getLink(false) . " > ";
                        }
                        $str_addon .= $task->getLink(false);
                        if($comment->comment){
                            if($comm = Comment::getVisibleById($comment->comment)){
                                $str_addon .= " > " . $comm->name;
                            }
                        }
                    }
                    $str_addon .= ")";

                }
                break;

            case ITEM_COMPANY:
                if($c = Company::getVisibleById($obj->id)) {
                    $str_name = asHtml($c->name);
                    $str_url = $PH->getUrl('companyView',array('company'=>$c->id));
                }
                break;

            case ITEM_PERSON:
                if($person = Person::getVisibleById($obj->id)) {
                    $str_name = asHtml($person->name);
                    $str_url = $PH->getUrl('personView',array('person'=>$person->id));
                }
                break;

            case ITEM_PROJECTPERSON:
                if($pp = ProjectPerson::getVisibleById($obj->id)) {
                    if(!$person= new Person($pp->person)) {
                        $PH->abortWarning("ProjectPerson has invalid person-pointer!",ERROR_BUG);
                    }
                    $str_name = asHtml($person->name);
                    $str_url = $PH->getUrl('personView',array('person'=>$person->id));
                    if($project = Project::getVisibleById($pp->project)){
                        $str_addon = "(" . $project->getLink(false) .")";
                    }

                }
                break;

            case ITEM_EMPLOYMENT:
                if($emp= Employment::getById($obj->id)) {
                    if($person= Person::getVisibleById($emp->person)) {
                        $str_name= asHtml($person->name);
                        $str_url= $PH->getUrl('personView',array('person'=>$person->id));
                    }
                    if($company = Company::getVisibleById($emp->company)){
                        $str_addon= "(". $company->getLink(false) .")";
                    }
                }
                break;

            case ITEM_EFFORT:
                if($e= Effort::getVisibleById($obj->id)) {
                    $str_name= asHtml($e->name);
                    $str_url= $PH->getUrl('effortEdit',array('effort'=>$e->id));
                    if($task = Task::getVisibleById($e->task)){
                        if($project = Project::getVisibleById($task->project)){
                            $str_addon .= "(". $project->getLink(false) ;
                            $str_addon .= " > ". $task->getLink(false) .")";
                        }
                    }

                }
                break;

            case ITEM_FILE:
                if($f= File::getVisibleById($obj->id)) {
                    $str_name= asHtml($f->org_filename);
                    $str_url= $PH->getUrl('fileView',array('file'=>$f->id));
                    $str_addon .= "(";
                    if($p = Project::getVisibleById($f->project)){
                        $str_addon .= $p->getLink(false) ;
                    }
                    if($t = Task::getVisibleById($f->parent_item)){
                        $str_addon .= " > " . $t->getLink(false) ;
                    }
                    $str_addon .= ")";
                }
                break;

             case ITEM_ISSUE:
                if($i = Issue::getVisibleById($obj->id)) {
                    if($t = Task::getVisibleById($i->task)){
                        $str_name = asHtml($t->name);
                        $str_url = $PH->getUrl('taskView',array('tsk'=>$t->id));
                        if($p = Project::getVisibleById($t->project)){
                            $str_addon .= "(". $p->getLink(false) .")";
                        }
                    }
                }
                break;

            case ITEM_TASKPERSON:
                if($tp = TaskPerson::getVisibleById($obj->id)) {
                    if($person = Person::getVisibleById($tp->person)){
                        $str_name = asHtml($person->name);
                        $str_url = $PH->getUrl('personView',array('person'=>$person->id));
                    }
                    if($task = Task::getVisibleById($tp->task)){
                        if($project = Project::getVisibleById($task->project)){
                            $str_addon .= "(". $project->getLink(false) ;
                            $str_addon .= " > ". $task->getLink(false) .")";
                        }
                    }
                }
                break;

            default:
                break;

        }
        print "<td><a href='$str_url'>$str_name</a><span class='sub who'> $str_addon</span></td>";
    }
}


?>