<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * classes related to miscellenious string formatting and rendering
 *
 * included from: render_page.inc
 *
 *
 * @author Thomas Mann
 * @uses:
 * @usedby: throughout everywhere
 *
 */


/**
* Handy function to set a message that welcomes a user after login.
* This message can be adjusted conf
*/
function setWelcomeToProjectMessage($project) 
{
    global $auth;
    $PH->messages[]= sprintf( __("Hello %s. Welcome to project %s"), 
                            "<b>". asHtml($auth->cur_user->name) . "</b>",
                            "<b>". asHtml($project->name) . "</b>"
                    );
}


/**
* get theme-directory (without slashes) from current user-definition
*
* if undefined, return default-theme
*/
function getCurTheme()
{
    global $auth;
    global $PH;
    global $g_theme_names;

    ### make sure theme is define ###
    if(!is_null(confGet('THEME_OVERWRITE'))) {
        $t= confGet('THEME_OVERWRITE');
        if(isset($g_theme_names[$t]) && ($theme= $g_theme_names[$t])) {
            return $theme;
        }
    }
    
    if(isset($auth)
     && isset($auth->cur_user)
     && isset($g_theme_names[$auth->cur_user->theme])
     && ($theme= $g_theme_names[$auth->cur_user->theme])) {
        return $theme;
    }

    return $g_theme_names[confGet('THEME_DEFAULT')];
}



/**
* get url to file from the current theme
*
* Used to access files from a theme. Example:
*
*  echo '<img src="'. getThemeFile("/img/prio_{$obj->prio}.png") . '">';
*
*
* - if file does not exists, returns path to default theme
* - if file does not exists there a warning is been triggered

*/
function getThemeFile($filepath)
{
    $theme= getCurTheme();
    $path= "themes/".getCurTheme()."/".$filepath;
    if(file_exists($path)) {
        return $path;
    }

    ### @@@pixtur:2006-10-11 using clean is not very good. Better would be default theme.
    $path= "themes/clean/". $filepath;
    if(file_exists($path)) {
        return $path;
    }
    else {
        trigger_error("unknown theme file '". $filepath. "'", E_USER_WARNING);
        return "";
    }
}



/**
 * Exception thrown related to rendering
 *
 * Prints message and some debug-output.
*/
class RenderException extends Exception
{
  public $backtrace=NULL;

  function __construct($message=false, $code=false)
  {
	$this->message="";
    if($message) {
        $this->message="<pre>$message";
    }
    $this->backtrace = debug_backtrace();
  }
}

/**
 * convert url to external link-tag (remove http:/ and reduced to reasonable length)
 *
 * add http:/ if missing
 * escapes html entities and returns save string
 */
function url2linkExtern($url, $show=NULL, $maxlen=20) {
    if(!preg_match("/^http:\/\//",$url)) {
        if(!$show) {
            $show= $url;
        }
        $url="http://$url";
    }
    else {
        if(!$show) {
            $show= preg_replace("/^https?:\/\//","",$url);
        }
    }
    if(strlen($show) > $maxlen) {
        $show=substr($show,0,$maxlen)."...";
    }
    return "<a target='_blank' class='extern' href='". asHtml($url) ."'>" . asHtml($show) ."</a>";
}

/**
 * convert url to mail link-tag (remove mail:// and reduced to reasonable length)
*/
function url2linkMail($url,$show=false, $maxlen=32) {
    $url= asHtml($url);

    if(!preg_match("/^mailto:/",$url)) {
        if(!$show) {
            $show= $url;
        }
        $url="mailto:$url";
    }
    else {
        if(!$show) {
            $show= preg_replace("/^mailto?:/","",$url);
        }
    }

    if(strlen($show) > $maxlen) {
        $show=substr($show,0,$maxlen)."...";
    }
    return "<a class='mail' href='".$url. "'>". $show."</a>";
}










/**
* Initialize a page for displaying task related content
*
* - inits: 
*   - breadcrumps
*   - options
*   - current section
*   - navigation
*   - pageType (including task folders)
*   - pageTitle (as Task title)
*/
function initPageForTask($page, $task, $project=NULL) 
{
    global $PH;
    $crumbs=array();

    if(!$project) {
        $project= Project::getVisibleById($task->project);
    }
    
    if($task->category == TCATEGORY_MILESTONE) {
        $page->cur_crumb= 'projViewMilestones';
    }
    else if($task->category == TCATEGORY_VERSION) {
        $page->cur_crumb= 'projViewVersions';
    }
    else if($task->category == TCATEGORY_DOCU || ($task->category == TCATEGORY_FOLDER && $task->show_folder_as_documentation)) {
        $page->cur_crumb= 'projViewDocu';

    }
    else {
        $page->cur_crumb= 'projViewTasks';
    }
    
    $page->crumbs= build_project_crumbs($project);
    $page->options= build_projView_options($project);
	$page->cur_tab='projects';
	$page->title = $task->name;
	if($task->id) {
        $page->title_minor_html= $PH->getLink('taskView', sprintf('#%d', $task->id), array('tsk'=>$task->id));
	}
    
    /**
    * render html buffer with page type of this task, including parent folders
    * and type and status.
    *
    * - This is the tiny text about the page title.
    */
    {
        global $g_status_names;
        $type ="";

        $status=  $task->status != STATUS_OPEN && isset($g_status_names[$task->status])
               ?  ' ('.$g_status_names[$task->status] .')'
               :  '';

        $label=  $task->getLabel();
        if(!$label) {
            $label= __("Task");
        }

        if($folder= $task->getFolderLinks()) {
            $type = $folder ." &gt; " . $label . '  '. $status ;
        }
        else {
            $type =  $label .' ' . $status;
        }
        $page->type = $type;
    }
}




/**
* Initialize a page for displaying comment related content
*
* - inits: 
*   - breadcrumps
*   - options
*   - current section
*   - navigation
*   - pageType (including task folders)
*   - pageTitle (as Task title)
*/
function initPageForComment($page, $comment, $project=NULL) 
{
    global $PH;
    $crumbs=array();

    if(!$project) {
        $project= Project::getVisibleById($comment->project);
    }
    
    $page->cur_crumb= 'projViewTasks';
    if($comment->task) {
        if($task = Task::getVisibleById($comment->task)) {
            if($task->category == TCATEGORY_MILESTONE) {
                $page->cur_crumb= 'projViewMilestones';
            }
            else if($task->category == TCATEGORY_VERSION) {
                $page->cur_crumb= 'projViewVersions';
            }
            else if($task->category == TCATEGORY_DOCU) {
                $page->cur_crumb= 'projViewDocu';
        
            }
        }
    }    
    
    $page->crumbs= build_project_crumbs($project);
    $page->options= build_projView_options($project);
	$page->cur_tab='projects';
	if($comment->name) {
	    $page->title = $comment->name;
	}
	else {
	    $page->title = __('Comment');
	}
    $page->title_minor_html= $PH->getLink('commentView', sprintf('#%d', $comment->id), array('comment'=>$comment->id));


    /**
    * render html buffer with page type of this task, including parent folders
    * and type and status.
    *
    * - This is the tiny text about the page title.
    */
    {
        global $g_status_names;
        $type ="";

        if($task) {
            if($folder= $task->getFolderLinks()) {
                $type = $folder ." &gt; " ;
            }
            $type.= $task->getLink() . ' &gt; ' ;
        }
        $type .= __('Comment');
                
        $page->type = $type;
    }
}



/**
* Initialize a page for displaying file related content
*
* - inits: 
*   - breadcrumps
*   - options
*   - current section
*   - navigation
*   - pageType (including task folders)
*   - pageTitle (as Task title)
*/
function initPageForFile($page, $file, $project=NULL) 
{
    global $PH;
    $crumbs=array();

    if(!$project) {
        $project= Project::getVisibleById($file->project);
    }
    $task = Task::getVisibleById($file->parent_item);
    
    $page->cur_crumb= 'projViewFiles';
    
    
    $page->crumbs= build_project_crumbs($project);
    $page->options= build_projView_options($project);
	$page->cur_tab='projects';
	if($file->name) {
	    $page->title = $file->name;
	}
	else {
	    $page->title = __('File');
	}
    $page->title_minor_html= $PH->getLink('fileView', sprintf('#%d', $file->id), array('file'=>$file->id));


    /**
    * render html buffer with page type of this task, including parent folders
    * and type and status.
    *
    * - This is the tiny text about the page title.
    */
    {
        global $g_status_names;
        $type ="";

        if($task) {
            if($folder= $task->getFolderLinks()) {
                $type = $folder ." &gt; " ;
            }
            $type.= $task->getLink() . ' &gt; ' ;
        }
        $type .= __('File'); 
        $page->type = $type;
    }
}



/**
* Initialize a page for displaying effort related content
*
* - inits: 
*   - breadcrumps
*   - options
*   - current section
*   - navigation
*   - pageType (including task folders)
*   - pageTitle (as Task title)
*/
function initPageForEffort($page, $effort, $project=NULL) 
{
    global $PH;
    $crumbs=array();

    if(!$project) {
        $project= Project::getVisibleById($effort->project);
    }
    $task = Task::getVisibleById($effort->task);
    
    $page->cur_crumb= 'projViewEfforts';
        
    $page->crumbs= build_project_crumbs($project);
    $page->options= build_projView_options($project);
	$page->cur_tab='projects';
	if($effort->name) {
	    $page->title = $effort->name;
	}
	else {
	    $page->title = __('Effort');
	}
    $page->title_minor_html= $PH->getLink('effortView', sprintf('#%d', $effort->id), array('effort'=>$effort->id));


    /**
    * render html buffer with page type of this task, including parent folders
    * and type and status.
    *
    * - This is the tiny text about the page title.
    */
    {
        global $g_status_names;
        $type ="";

        if($task) {
            if($folder= $task->getFolderLinks()) {
                $type = $folder ." &gt; " ;
            }
            $type.= $task->getLink() . ' &gt; ' ;
        }
        $type .= __('Effort'); 
        $page->type = $type;
    }
}





function build_person_crumbs(&$person) {
    $crumbs=array();

	$crumbs[]= new NaviCrumb(array(
		'target_id'     =>'personList',
		'name'          =>__('Other Persons','page option'),
	));
    
    $crumbs[]= new NaviCrumb(array(
        'target_id'     => 'personView',
        'target_params' => array('person'=> $person->id),
        'name'          => $person->name,
        'type'=>'person',
  	));
  	return $crumbs;
}

function build_company_crumbs(&$company) {
    $crumbs=array();

	$crumbs[]= new NaviCrumb(array(
		'target_id'     => 'companyList',
	));

    $crumbs[]= new NaviCrumb(array(
            'target_id'     => 'companyView',
            'name'          => $company->name,
            'target_params' => array('company'=>$company->id),
    ));

  	return $crumbs;
}


function build_project_crumbs($project) {
    $a=array();

    ### breadcrumbs (distinguish active/closed projects ###
	/*if($project->status > 3) {
        $a[]=
    	    new NaviCrumb(array(
	            'target_id'=>'projListClosed',
    	    ));
    }
    else if($project->status == -1) {
        $a[]=
    	    new NaviCrumb(array(
	            'target_id'=>'projListTemplates',
    	    ));
    }
    else {
        $a[]=
    	    new NaviCrumb(array(
	            'target_id'=>'projList',
    	    ));
    }
    */


    $a[]= new NaviCrumb(array(
            'target_id'=>'projView',
            'name'=>    $project->getShort(),
            'tooltip'=> $project->name,
            'target_params'=>array('prj'=>$project->id ),
            'type'=>'project',
        ));

    return $a;
}

/**
* renders the list of open projects that will be display when opening the project selector
*
* The opening is done with javascript. Placing the list beside the Project Selector icon
* is done by css only. This is a little bit tricky, because the Tab-list is already an
* span which allows only further Spans to be included...
*
* The selectorlist is triggered by 
*
* read more at #3867
*/
function buildProjectSelector()
{

    global $auth;
    if(!$auth->cur_user || !$auth->cur_user->id) {
        return "";
    }
    $buffer= "";

    global $PH;

	require_once(confGet('DIR_STREBER') . 'db/class_company.inc.php');
    require_once(confGet('DIR_STREBER') . "db/class_project.inc.php");

    $buffer.="<span id=projectselector class=selector>&nbsp;</span>";
    $buffer.= "<span style='display:none;' id='projectselectorlist' class=selectorlist><span class=selectorlist_content>";

    foreach(Company::getAll() as $c) {
	    if($projects= Project::getAll(array(
	    	'order_by'   => 'c.name',
	        'company'    => $c->id,
	    ))) {
	        $buffer .= "<div class='companies'><span style='float:left;margin-right:3px;'>" . __("for","short for client") . "</span>" . $c->getLink() . "</div>";
	        $buffer .= "<div class='projects'><ul>";
	        foreach($projects as $p) {
	            $buffer.= "<li>" . $PH->getLink('projView',$p->name, array('prj' => $p->id)) . "</li>";
	        }
	        $buffer .= "</ul></div>";
	    }
    }
	/* projects without client */
	if($projects= Project::getAll(array(
       'order_by'   => 'c.name',
       'company'    => 0,
    ))) {
        $buffer .= "<div class='companies'><span style='float:left;margin-right:3px;'>" . __("without client","short for client") . "</span>&nbsp;</div>";
		$buffer .= "<div class='projects'><ul>";
        foreach($projects as $p){
			$buffer.= "<li>" . $PH->getLink('projView',$p->name, array('prj' => $p->id)) . "</li>";
        } 
        $buffer .= "</ul></div>";
    }

    $buffer.="</span></span>";
               
    return $buffer;
}



/**
* renders the list of open pages available in homeView
*
* The opening is done with javascript. Placing the list beside the Home Selector icon
* is done by css only. This is a little bit tricky, because the Tab-list is already an
* span which allows only further Spans to be included...
*
* read more at #3867
*/
function buildHomeSelector()
{
    global $auth;
    global $PH;
    if(!$auth->cur_user || !$auth->cur_user->id) {
        return "";
    }
    $buffer= "";

    $buffer.="<span id=homeselector class=selector>&nbsp;</span>";
    $buffer.= "<span style='display:none;' id='homeselectorlist' class=selectorlist><span class=selectorlist_content>";

    /*
    foreach(array('home', 'homeTasks', 'homeBookmarks', 'homeEfforts', 'homeAllChanges') as $p) {
        $buffer.= $PH->getLink($p,NULL, array());
    }
    */
    $buffer.= $PH->getLink('home',NULL, array());
    $buffer.= $PH->getLink('homeTasks',NULL, array());
    if($auth->cur_user->settings & USER_SETTING_ENABLE_EFFORTS) {
        $buffer.= $PH->getLink('homeEfforts',NULL, array());
    }
    
    if($auth->cur_user->settings & USER_SETTING_ENABLE_BOOKMARKS) {
        $buffer.= $PH->getLink('homeBookmarks',NULL, array());
    }
    $buffer.= $PH->getLink('homeAllChanges',NULL, array());

    $buffer.="</span></span>";
    return $buffer;
}



/**
* build the navigation-options for project view
* Note: for project_breadcrumps see render/render_misc
*/
function build_projView_options($project)
{
    global $auth;
	
    $options=array();
    if($project->settings & PROJECT_SETTING_ENABLE_TASKS) {
        $options[]=  new NaviOption(array(
                'target_id'=>'projViewTasks',
                'name'=>__('Tasks','Project option'),
                'target_params'=>array('prj'=>$project->id )
        ));
    }

    $options[]=  new NaviOption(array(
            'target_id'=>'projViewDocu',
            'name'=>__('Topics','Project option'),
            'target_params'=>array('prj'=>$project->id )
    ));

    if($project->settings & PROJECT_SETTING_ENABLE_MILESTONES) {
        $options[]=  new NaviOption(array(
            'target_id'=>'projViewMilestones',
            'name'=>__('Milestones','Project option'),
            'target_params'=>array('prj'=>$project->id )
        ));
    }

    if($project->settings & PROJECT_SETTING_ENABLE_VERSIONS) {
        $options[]=  new NaviOption(array(
                'target_id'=>'projViewVersions',
                'name'=>__('Versions','Project option'),
                'target_params'=>array('prj'=>$project->id )
        ));
    }

    if($project->settings & PROJECT_SETTING_ENABLE_FILES) {
        $options[]=new NaviOption(array(
            'target_id'=>'projViewFiles',
            'name'=>__('Files','Project option'),
            'target_params'=>array('prj'=>$project->id )
        ));
    }

    if($project->settings & PROJECT_SETTING_ENABLE_EFFORTS) {
        $options[]=  new NaviOption(array(
                'target_id'=>'projViewEfforts',
                'name'=>__('Efforts','Project option'),
                'target_params'=>array('prj'=>$project->id )
        ));
    }
	
	
	
	#if(($auth->cur_user->user_rights & RIGHT_VIEWALL) && ($auth->cur_user->user_rights & RIGHT_EDITALL)){
	#	$options[]=  new NaviOption(array(
    #        'target_id'=>'projViewEffortCalculations',
    #        'name'=>__('Calculation','Project option'),
    #        'target_params'=>array('prj'=>$project->id )
    #    ));
	#}
	
	
    $options[]=  new NaviOption(array(
            'target_id'=>'projViewChanges',
            'name'=>__('Changes','Project option'),
            'target_params'=>array('prj'=>$project->id )
    ));
    return $options;
}


function build_personList_options()
{
    return array(
        new NaviOption(array(
            'target_id'=>'personList',
            'name'=>__('Persons', 'page option')
        ))
    );
}

function build_companyList_options()
{
    return array(
        new NaviOption(array(
            'target_id'=>'companyList',
            'name'=>__('Companies', 'page option')
        )),
    );
}


function build_projList_options()
{
    return array(
        new NaviOption(array(
            'target_id'=>'projList',
            'name'=>__('Active')
        )),
        new NaviOption(array(
            'target_id'=>'projListClosed',
            'name'=>__('Closed')
        )),
        new NaviOption(array(
            'target_id'=>'projListTemplates',
            'name'=>__('Templates'),
            'separated'=> true,
        )),
    );
}


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
* actually this function is obsolete since all error-related debug-output should
* be generated by trigger_error (which has it's own backtrace-function)
*/
function renderBacktrace($arr)
{
    $buffer='';

    ### ignore empty array ###
    if(!count($arr)) {
        return false;
    }

    $buffer.= "<table class=backtrace>";

    ### write header ###
    $buffer.="<tr>";
    foreach($arr[0] as $key=>$value) {
        $buffer.="<th>$key</th>";
    }

    $buffer.="</tr>";

    ### write lines ###
    foreach($arr as $n) {
        $buffer.="<tr>";
        foreach($n as $key=>$value) {
            if(is_array($value)) {
                $buffer.='<td>';
                foreach($value as $no) {
                    if(is_object($no)) {
                        $buffer.=get_class($no);
                    }
                    else {
                        $buffer.=$no;
                    }
                    $buffer.=".<br>";
                }
                $buffer.="</td>";
            }
            else if(is_object($value)) {
                $buffer.='<td>';
                #$buffer.=join("##<br>",$value);
                $buffer.="</td>";
            }
            else {
                $value= str_replace("c:\\programme\\Apache13\\Apache\\htdocs\\nod\\","",$value);
                $buffer.="<td>$value</td>";
            }
        }
        $buffer.="</tr>";
    }
    $buffer.= "</table>";
    return $buffer;
}







/**
* wrapper functions for formatted time output
* cache strings to avoid too many access to the language tables and
* to attempt to fix portability problems with strftime
*/
function getUserFormatDate()
{
    global $g_userFormatDate;
    if(!$g_userFormatDate)
    {
        $g_userFormatDate = __('%b %e, %Y', 'strftime format string');

        // fix %e formatter if not supported (e.g. on Windows)
        if(strftime("%e", mktime(12, 0, 0, 1, 1)) != '1') {
            $g_userFormatDate = str_replace("%e", "%d", $g_userFormatDate);
        }
    }
    return $g_userFormatDate;
}

/**
* Note: we cache the format in a global variable to speed things up
* use clearCachedTimeFormats() when dealing with changing languages.
*/
function getUserFormatTime()
{
    global $g_userFormatTime;
    if(!$g_userFormatTime) {
        $g_userFormatTime = __('%I:%M%P', 'strftime format string');
    }
    return $g_userFormatTime;
}

function getUserFormatTimestamp()
{
    global $g_userFormatTimestamp;
    if(!$g_userFormatTimestamp)
    {
        $g_userFormatTimestamp = __('%a %b %e, %Y %I:%M%P', 'strftime format string');

        # Fix %e formatter if not supported (e.g. on Windows)
        if(strftime("%e", mktime(12, 0, 0, 1, 1)) != '1') {
            $g_userFormatTimestamp = str_replace("%e", "%d", $g_userFormatTimestamp);
        }
    }
    return $g_userFormatTimestamp;
}


/**
* NOTE:
* - all time RENDER functions will ADD user's Time offset to render time in client time
* - vize versa all parseTime functions (see render/render_fields.inc.php) will SUBSTRACT the time offset
*   before storing anything to the DB
*/
function renderTimestamp($t)
{

    if(!$t || $t=="0000-00-00 00:00:00") {
        return "";
    }
    if(is_string($t)) {
        $t= strToClientTime($t);
    }

    ### omit time with exactly midnight
    if(gmdate("H:i:s",$t)=="00:00:00") {
        $str= gmstrftime(getUserFormatDate(), $t);
    }
    else {
        $str= gmstrftime(getUserFormatTimestamp(), $t);
    }
    return $str;
}



function renderTimestampHtml($t)
{
    if(!$str= renderTimestamp($t)) {
        return "-";
    }

    if(is_string($t)) {
        $t= strToClientTime($t);
    }



/*    ### hilight new dates ###
    if(isset($auth) && isset($auth->cur_user) && gmdate("Y-m-d H:i:s",$t) > $auth->cur_user->last_logout) {
        $str_tooltip= __("new since last logout");
        return "<span class=new title='$str_tooltip'>$str</span>";
    }
    else {
    */
        return $str;


}



function renderTime($t)
{
    if(!$t  || $t=="0000-00-00 00:00:00") {
        return "";
    }
    if(is_string($t)) {
        $t= strToClientTime($t);
    }
    return gmstrftime(getUserFormatTime(), $t);
}



function renderDuration($t)
{
    if(!$t  || $t=="0000-00-00 00:00:00") {
        return "";
    }

    if($t > confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60) {
        return sprintf(__('%s weeks'), floor($t / (confGet('WORKDAYS_PER_WEEK') * confGet('WORKHOURS_PER_DAY') * 60 * 60)));
    }
    else if($t > confGet('WORKHOURS_PER_DAY') * 60 * 60) {
        return sprintf(__('%s days'), floor($t / (confGet('WORKHOURS_PER_DAY') * 60 * 60)));
    }
    else if($t > 60 * 60) {
        return sprintf(__('%s hours'), floor($t / (60 * 60)));
    }
    else {
        return sprintf(__('%s min'), floor($t / 60));
    }
}


/**
* expects GMT times!
*/
function renderDate($t, $smartnames= true) {
    if(!$t || $t=="0000-00-00 00:00:00" || $t=="0000-00-00") {
        return "";
    }

    if(is_string($t)) {

        ### do not offset simple dates ###
        if(preg_match("/\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d/", $t)) {
            $t= strToClientTime($t);
        }
        else {
            $t= strToGMTime($t);
        }
    }
    else {
        global $auth;
        $time_offset= 0;
        if(isset($auth->cur_user)) {
            $time_offset = $auth->cur_user->time_offset;
        }
        $t= $time_offset;
    }


    if($smartnames && gmdate('Y-m-d', time()) == gmdate('Y-m-d', $t)) {
        $str= __('Today');
        if(gmdate('H:i:s',$t) !== '00:00:00') {
            $str.= ' ' . gmstrftime(getUserFormatTime(), $t);

            
        }
    }
    else if($smartnames && gmdate('Y-m-d',time()) == gmdate('Y-m-d', $t + 60*60*24)) {
        $str= __('Yesterday');
        #if(gmdate('H:i:s',$t) !== '00:00:00') {
        #    $str.= ' ' . gmstrftime(getUserFormatTime(), $t);
        #}
    }
    else {
        $str= gmstrftime(getUserFormatDate(), $t);
    }
    return $str;

}

function renderDateHtml($t)
{
    global $auth;


    ### this is the visible string ###
    if(!$str= renderDate($t)) {
        return "-";
    }

    ### this is for the tooltip ###
    if(is_string($t)) {
        $t= strToClientTime($t);
    }
    else {
        global $auth;
        $time_offset= 0;
        if(isset($auth->cur_user)) {
            $time_offset = $auth->cur_user->time_offset;
        }
        $t+= $time_offset;
    }

    ### tooltip ? ###
    $str_tooltip='';
    if(gmdate('H:i:s',$t) != '00:00:00') {
        $str_tooltip= gmstrftime(getUserFormatTimestamp(), $t);
    }

    if($str_tooltip){
        return "<span class='date' title='$str_tooltip'>$str</span>";
    }
    else {
        return $str;
    }
}


/**
* renders a time as distance ago... (expects GMT times)
*/
function renderTimeAgo($t)
{
    $duration= time() - strToGMTime($t);

    if(strToGMTime($t) == 0) {
        return __("never");
    }

    if($duration < 60 * 5) {
        return __('just now');
    }
    if($duration < 60 * 60) {
        return sprintf(__('%smin ago'), ceil($duration / 60));
    }
    if($duration < 60 * 60 * 2) {
        return __('1 hour ago');
    }
    if($duration < 60 * 60 * 24) {
        return sprintf(__('%sh ago'), ceil($duration / 60 / 60));
    }

    if($duration < 60 * 60 * 24 * 62) {
        return sprintf(__('%s days ago'), ceil($duration / 60 / 60 / 24));
    }
    if($duration < 60 * 60 * 24 * 365 * 2) { 
        return sprintf(__('%s months ago'), ceil($duration / 60 / 60 / 24 / 30));
    }
    
    if($duration < 60 * 60 * 24 * 365 * 20) { 
        return sprintf(__('%s years ago'), ceil($duration / 60 / 60 / 24 / 365));
    }
}

function renderPubLevelName($pub_level)
{
    global $g_pub_level_names;
    if(isset($g_pub_level_names[$pub_level])) {
        return $g_pub_level_names[$pub_level];
    }
    else {
        return '';
    }
}


/**
* want duration in seconds
*/
function renderEstimatedDuration($duration)
{
    $duration /=  (60 * 60);

    $hours_per_day= confGet('WORKHOURS_PER_DAY');
    $days_per_week= confGet('WORKDAYS_PER_WEEK');

    if(!$duration) {
        return '';
    }

    if($duration <= $hours_per_day) {
        $type= 'hours';
        $str= sprintf(__('%s hours'), $duration);
    }
    else if($duration < $hours_per_day * $days_per_week) {
        $type= 'days';
        $str= sprintf(__('%s days'), $duration / $hours_per_day);
    }
    else {
        $type= 'weeks';
        $str= sprintf(__('%s weeks'), $duration / $hours_per_day / $days_per_week);
    }
    return $str;
}

/**
* renders a html-estimation / completion graph
*
* @used_by: list_tasks, list_milestones
*/
function renderEstimationGraph($estimated, $estimated_max, $completion)
{
    $str= '';
    #if(preg_match("/(\d\d):(\d\d):(\d\d)/", $obj->estimated, $matches)) {
    #    $estimated= ($matches[1]*60*60 + $matches[2]*60 + $matches[3]) / 60;
    if($estimated) {
        $estimated= $estimated/60/60;
        $estimated_max= $estimated_max/60/60;


        $hours_per_day= confGet('WORKHOURS_PER_DAY');
        $days_per_week= confGet('WORKDAYS_PER_WEEK');


        if($estimated_max <= $hours_per_day*2) {
            $type= 'hours';
            $width_estimated= $estimated * 4;
            $width_estimated_max= $estimated_max * 4;
            $str_estimated= sprintf(__('estimated %s hours'), $estimated);
            $str_estimated_max= $estimated_max
                              ? '('. sprintf(__('%s hours max'), $estimated_max) .')'
                              : '';
        }
        else if($estimated_max < $hours_per_day * $days_per_week*2) {
            $type= 'days';
            $width_estimated= $estimated / $hours_per_day * 6;
            $width_estimated_max= $estimated_max / $hours_per_day * 6;
            $str_estimated= sprintf(__('estimated %s days'), $estimated / $hours_per_day);

            $str_estimated_max= $estimated_max
                              ? '('. sprintf(__('%s days max'), $estimated_max / $hours_per_day) .')'
                              : '';

        }
        else {
            $type= 'weeks';
            $width_estimated= $estimated / $hours_per_day / $days_per_week * 12;
            $width_estimated_max= $estimated_max / $hours_per_day / $days_per_week * 12;

            $str_estimated= sprintf(__('estimated %s weeks'), $estimated / $hours_per_day / $days_per_week);
            $str_estimated_max  = $estimated_max
                                ? '('. sprintf(__('%s weeks max'), $estimated_max / $hours_per_day / $days_per_week) .')'
                                : '';
        }

        $str_completion= sprintf(__("%2.0f%% completed"), $completion);
        $html_tooltip= "title='". $str_estimated . " ". $str_estimated_max." / " . $str_completion. "'";

        if($completion) {
            $width_completion= $completion / 100 * $width_estimated;

            $html_completion= "<div  class='estimated {$type}_completed' style='width:{$width_completion}px;'></div>";
        }
        else {
            $html_completion='';
        }

        if($width_estimated_max > $width_estimated) {
            $width_risk= floor($width_estimated_max - $width_estimated)-1;
            $html_risk= "<div class='{$type}_risk'  style='width:{$width_risk}px;'></div>";
        }
        else {
            $html_risk='';
        }


        $str= "<div $html_tooltip class='estimated {$type}' style='width:{$width_estimated_max}px;'>"
            . $html_completion
            . $html_risk
            . "</div>";
    }
    return $str;
}

/**
* renders a date suitable for page titles/subtitles
* e.g.: Monday, 1st
*/
function renderTitleDate($t)
{
    /*
            As far as I (ganesh) know, the strftime %e format is good enough for all languages except English.
            For English we use the S format of function date() to get ordinals, which has no strftime equivalent.
        */
    global $g_lang;
    if($g_lang == 'en')
        $str = date('l, F jS', $t);
    else
        $str = strftime(__('%A, %B %e', 'strftime format string'), $t);
    return $str;
}

function renderFilesize($bytes)
{
    $bytes= intval($bytes);
    if( $bytes < 1024 ) {
        return $bytes;
    }
    else if( $bytes < 1024 * 1024) {
        return intval($bytes / 1024) . "k";
    }
    else {
        return (intval(($bytes / 1024/1024) * 10) / 10.0) . "mb";
    }
}


/**
* @@@ move this somewhere else...
* use difference_engine to render differences between two versions of a texts
*/
function render_changes($text_org,$text_new)
{
    require_once(confGet('DIR_STREBER') . "std/difference_engine.inc.php");

    $buffer= '';

	$ota = explode( "\n", str_replace( "\r\n", "\n", $text_org ) );
	$nta = explode( "\n", str_replace( "\r\n", "\n", $text_new ) );
	$diffs = new Diff( $ota, $nta );

    $debug='';

    $buffer.="<table class=diff>";

	foreach($diffs as $d) {
	    $buffer.="<tr>";
	    $buffer.="<td class=changeblock colspan=2></td></tr><tr>";
	    foreach($d as $do) {

		    if($do->type == 'add') {
		        $buffer.="<tr>";
		        $buffer.="<td class=neutral></td>";
		        $buffer.="<td class=add>". arrayAsHtml($do->closing). "</td>";
		        $buffer.="</tr>";

		    }
		    else if($do->type =='delete') {
		        $buffer.="<tr>";
		        $buffer.="<td class=deleted>". arrayAsHtml($do->orig). "</td>";
		        $buffer.="<td class=neutral></td>";
		        $buffer.="</tr>";

		    }
		    else if($do->type =='change') {
		        $wld= new WordLevelDiff($do->orig, $do->closing);
		        $buffer_org ='';
		        $buffer_new ='';
		        foreach($wld->edits as $e) {
		            switch($e->type) {
		                case 'copy':
		                    $orig= implode('',$e->orig);
		                    $buffer_org.= asHtml($orig);
		                    $buffer_new.= asHtml($orig);
		                    break;

		                case 'add':
		                    $buffer_org.= '<span class=add_place> </span>';
		                    $closing=implode('',$e->closing);
		                    $buffer_new.= '<span class=add>'.asHtml($closing).'</span>';
		                    break;

		                case 'change':
		                    $orig= implode('',$e->orig);
		                    $closing= implode('',$e->closing);
		                    $buffer_org.= '<span class=changed>'.asHtml($orig).'</span>';
		                    $buffer_new.= '<span class=changed>'.asHtml($closing).'</span>';
		                    break;

		                case 'delete':
		                    $orig= implode('',$e->orig);

		                    $buffer_org.= '<span class=deleted>'.asHtml($orig).'</span>';
		                    $buffer_new.= '<span class=delete_place> </span>';
		                    break;

		                default:
		                    trigger_error("undefined edit work edit", E_USER_WARNING);
		                    break;

		            }
		        }
	            $buffer_org= str_replace("\n", '<br>', $buffer_org);
	            $buffer_new= str_replace("\n", '<br>', $buffer_new);

		        $buffer.="<tr>";
		        $buffer.="<td class='changed'>". $buffer_org. "</td>";
		        $buffer.="<td class='changed'>". $buffer_new. "</td>";
		        $buffer.="</tr>";

		    }
		    else if($do->type == 'copy') {
		        $buffer.="<tr>";
		        $buffer.="<td class='copy'>". arrayAsHtml($do->orig). "</td>";
		        $buffer.="<td class='copy'>". arrayAsHtml($do->closing). "</td>";
		        $buffer.="</tr>";

		    }
		    else {
		        trigger_error("unknown diff type");
		    }
		}
	   $buffer.="</tr>";

	}
	$buffer.="</table>";

    return $buffer;
}

/**
* implodes an array of strings into save html output
*
* - used for rendering differences
*/
function arrayAsHtml($strings)
{
    $buffer = '';
    $sep    = '';
    foreach($strings as $s) {
        $buffer.= $sep.asHtml($s);
        $sep = '<br>';
    }
    $buffer= str_replace("  ", "  ", $buffer);
    return $buffer;
}
?>