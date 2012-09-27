<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * classes related to rendering html output
 *
 * @author Thomas Mann
 *
 */
 
 /**
 * @defgroup render Render
 *
 * This group collects classes and function related to renderin html or csv output
 */


require_once(confGet('DIR_STREBER') . "render/render_misc.inc.php");

/**
* pagefunctions for editing the currently displayed obj (eg. Delete a task)
* @ingroup render
*/
class PageFunction extends BaseObject
{
    public $target;             # pageid without params
    public $params;             # pageid without params
    public $url;                # link-target (pageid including params)
    public $name;               # name
    public $icon;               # name of function icon
    public $parent_block;
    public $tooltip;
    public $context_menu=false; # show in context-menus
    public $key;                # used as id in assoc. array  'functions'
}

/**
* group page function with keyword like "*new:* *status:*" etc.
*
* @ingroup render
*/
class PageFunctionGroup extends PageFunction
{

}


/**
* link in TopNavigation
*
* @ingroup render
*/
abstract class NaviLink
{
    public $name        = '';
    public $target_id   = '';       # id of internal target-page / used to get url and for automatically highlighting option
    public $target_url  = '';       # target url including parameters / build from id and target_params
    public $tooltip;                # optional
    public $active=false;           # hightlight as current option
    public $parent_of_active= false; # this is required for advanced css styling of breadcrumbs
    public $target_params=array();  # assoc. array of target-params
    public $type;                   # e.g. 'project', 'task' (addes as additional style-class to a)

    public function __construct( $args)
    {
        global $PH;

        #--- set parameters ---
        foreach($args as $key=>$value) {
            is_null($this->$key);   # cause E_NOTICE if member not defined
            $this->$key= $value;
        }

        #--- hilight active option ---
        if($this->target_id == $PH->cur_page_id) {
            $this->active= true;
        }

        #--- check for valid page ids ----
        #if(!$PH->getValidPage($this->target_id)) {
        #    trigger_error(" could not get page_id of '$this->target_id'<br>", E_USER_WARNING);
        #}

        #--- get url if not already defined ------
        if(!$this->target_url) {
            if(!isset($this->target_id)) {
                trigger_error("NaviOption::__construct() needs either target_id or target_url", E_USER_ERROR);
            }
            $this->target_url= $PH->getUrl($this->target_id, $this->target_params);
        }

        #--- get name, if not already defined ----
        if(!$this->name && $this->target_id) {
            if(isset($PH->hash[$this->target_id])) {
                $this->name = $PH->hash[$this->target_id]->title;
            }
        }
    }
}

/**
* Handles informaion about the parents of a rendered Page
*
* @ingroup render
*/
class NaviCrumb extends NaviLink
{

    public function render()
    {
        global $PH;
        $str_tooltip= $this->tooltip
            ? "title=\"" . asHtml($this->tooltip) . "\""
            : '';

        #--- hide if not a valid link ----
        if(isset($this->target_id) && $this->target_id != "") {
            if($PH->getValidPage($this->target_id)) {

                $classes= array($this->type);   # add type as additional class

                if($this->active) {
                    $classes[]="current";
                }

                if($this->parent_of_active) {
                    $classes[]="parent_of_current";      # sick... this should be either "current" or "active"...
                }

                if($classes) {
                    return "<a class='" . implode(" ", $classes). "' href=\"{$this->target_url}\" $str_tooltip>" . asHtml($this->name). "</a>";
                }
                else {
                    return "<a href=\"{$this->target_url}\" $str_tooltip>". asHtml($this->name) . "</a>";
                }
            }
        }
        #--- external link ------------
        else {
            return "<a href=\"{$this->target_url}\" $str_tooltip>". asHtml($this->name) ."</a>";
        }
    }
}

/**
* Handles information about alternative Pages for a displayed Pages 
*
* @ingroup render
*/
class NaviOption extends NaviLink
{
    public $separated;

    public function render()
    {
        global $PH;
        $str_tooltip= $this->tooltip
            ? "title=\"". asHtml($this->tooltip)."\""
            : '';

        #--- hide if not a valid link ----
        if(isset($this->target_id) && $this->target_id != "") {

            if($PH->getValidPage($this->target_id)) {
                $classes= array();
                if($this->active) {
                    $classes[]="current";
                }
                if($this->parent_of_active) {
                    $classes[]="parent_of_current";      # sick... this should be either "current" or "active"...
                }

                if($classes) {
                    return "<a class='". implode(" ",$classes) . "' href=\"{$this->target_url}\" $str_tooltip>".asHtml($this->name)."</a>";
                }
                else {
                    return "<a href='{$this->target_url}' $str_tooltip>". asHtml($this->name)."</a>";
                }
            }
        }
        #--- external link ------------
        else {
            return "<a href=\"{$this->target_url}\" $str_tooltip>".asHtml($this->name)."</a>";
        }
    }
}


/**
* A page to be rendered
*
* @ingroup render
*/
class Page
{

    #--- members -----
    public  $section_scheme ='misc';    # color-scheme of the active tab. set by renderHeaderTabs() (effects sub_navigtaion) ('projects'|'time'|etc.)
    public  $content_open   =false;      # open content-table
    public  $title          ='';
    public  $title_minor    ='';
    public  $title_minor_html;  # for inserting html-code (e.g. links) use this buffer
    public  $type           ='';
    public  $tabs;              # assoc. array with tab-definition
    public  $cur_tab;
    public  $options;           # assoc. array with NaviOptions-definition
    public  $crumbs;            # assoc. array with breadcrumb-definition
    public  $cur_crumb;         # for overwriting active breadcrumb
    public  $html_close;
    public  $content_col;
    public  $use_jscalendar =false;
    public  $autofocus_field=false;
    public  $functions      =array();
    public  $content_columns=false;
    public  $format         = FORMAT_HTML;
    public  $extra_header_html = '';
    public  $use_autocomplete = false;
    #--- constructor ---------------------------
    public function __construct($args=NULL)
    {
        
        ### set global page-var
        global $_PAGE;
        global $auth;
        global $PH;
        if(isset($_PAGE) && is_object($_PAGE)) {
            trigger_error("'page' global var already defined!", E_USER_NOTICE);
        }
        $_PAGE= $this;

        ### set default-values ###
        $this->content_open=false;    # open content-table

        $sq= get('search_query');
        $old_search_query= get('search_query') && get('search_query') !=""
            ? 'value="'. asHtml($sq). '"'
            : '';

        if(get('format') && get('format') != ''){
            $this->format = get('format');
        }

        $this->tabs=array(
            "home"      =>array(
                'target'=>$PH->getUrl('home'),
                'title'=>__('Home', 'section'),

                #'title'=>__("<span class=accesskey>H</span>ome"),
                'html'=>   buildHomeSelector(),
                'bg'=>"misc"       ,
                'accesskey'=>'h',
                'tooltip'=>__('Go to your home. Alt-h / Option-h')
            ),
            "projects"  =>array(
                'target'    => $PH->getUrl('projList',array()),
                'title'     =>__("<span class=accesskey>P</span>rojects"),
                'html'=>   buildProjectSelector(),
                'tooltip'   =>__('Your projects. Alt-P / Option-P'),
                'bg'        =>"projects",
                'accesskey' =>'p'
            ),
			"people"    =>array(
                'target'    =>$PH->getUrl('personList',array()),
                'title'     =>__("People"),
                'tooltip'   =>__('Your related People'),
                'bg'        =>"people"
            ),
            "companies"  =>array(
                'target'    =>$PH->getUrl('companyList',array()),
                'title'     =>__("Companies"),
                'tooltip'   =>__('Your related Companies'),
                'bg'        =>"people"
            ),
            "search"    =>array(
                'target'    =>'javascript:document.my_form.go.value=\'search\';document.my_form.submit();',
                'title'     =>__("<span class=accesskey>S</span>earch:&nbsp;"),
                'html'      =>'<input class=searchfield accesskey=s '.$old_search_query.' name=search_query onFocus=\'document.my_form.go.value="search";\'>',

                'tooltip'   =>__("Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`")
            )
        );          # assoc. array with tab-definition
        $this->cur_tab="";
        $this->options=array();       # assoc. array with options-definition
        $this->crumbs=array();        # assoc. array with breadcrumb-definition

        ### set params ###
        if($args) {
            foreach($args as $key=>$value) {
                empty($this->$key);        #cause notification for unknown keys
                $this->$key= $value;
            }
        }

        ### put out header, some js-functions and styles for proper error-display
    }


    /**
    * setter members handler
    */
    function __set($name, $val)   {
        if (isset($this->$name) || is_null($this->$name)) {
           $this->$name = $val;
        } 
        else {
           trigger_error("can't set page->$name", E_USER_WARNING);
        }
    }
    
    
    /**
    * setter members handler
    */
    function __get($name)
    {
        if (isset($this->$name) ) {
            return $this->$name;
        } 
        else {
            trigger_error("can't read '$name'", E_USER_WARNING);
        }
    }
   
       
    /**
    * add a page function
    */
    function add_function(PageFunction $fn)
    {
        global $PH;


        if($fn instanceof PageFunctionGroup) {
            $this->functions[$fn->name]=$fn;
            $fn->parent_block= $this;
            return;
        }
        ### cancel, if not enough rights ###
        if(!$PH->getValidPageId($fn->target)) {

            /**
            * it's quiet common that the above statement returns NULL. Do not warn here
            */
            #trigger_error("invalid target $fn->target", E_USER_WARNING);
            return;
        }


        ### build url ###
        if(!$fn->url= $PH->getUrl($fn->target, $fn->params)) {

            /**
            * it's quiet common that the above statement returns NULL. Do not warn here
            *
            * e.g. if links have been disabled for current user
            */
            #trigger_error("invalid for page function target $fn->target", E_USER_WARNING);
            return NULL;
        }


        ### create key ###
        $key=count($this->functions);
        if(isset($fn->target)) {
            $key= $fn->target;
        }
        else if(isset($fn->id)){
            $key= strtolower($fn->id);
        }

        ### warn, if already defined? ###
        if(isset($this->functions[$key])) {
            trigger_error("overwriting function with id '$key'", E_USER_NOTICE);
        }

        ### if not given, get title for page-handle ###
        if(!isset($fn->name)) {
            $phandle=$PH->getValidPage($fn->target);
            $fn->name= $phandle->title;

        }

        $this->functions[$key]=$fn;
        $fn->parent_block= $this;
    }

    function print_presets($args=NULL)
    {
        if(get('format') == FORMAT_CSV) {
            return;
        }
        global $PH;
        
        $pvalue = '';
        
        if(isset($args) && count($args) == 5){
            $preset_location = $args['target'];
            $project_id = $args['project_id'];
            $preset_id = $args['preset_id'];
            $presets = $args['presets'];
            $person_id = $args['person_id'];
            
            echo "<div class=\"presets\">";
            #echo __("Filter-Preset:");
            foreach($presets as $p_id=>$p_settings) {
                if($p_id == $preset_id) {
                    echo $PH->getLink($preset_location, $p_settings['name'], array('prj'=>$project_id,'preset'=>$p_id, 'person'=>$person_id),'current');
                }
                else {
                    echo $PH->getLink($preset_location, $p_settings['name'], array('prj'=>$project_id,'preset'=>$p_id, 'person'=>$person_id));
                }
            }
            echo "</div>";
        }
        else{
            trigger_error("cannot get arguments", E_USER_NOTICE);
        }
    }
}

/**
* Element inside a page 
*
* @ingroup render
*
* - all other elements of a page extend this class
* - maps the global var $page
*/
class PageElement extends BaseObject
{
    public $page;
    public $children=array();
    public $name;
    public $title;

    #--- constructor--------------------------------
    public function __construct($args=NULL)
    {
        if($args) {
            foreach($args as $key=>$value) {
                is_null($this->$key);   # cause E_NOTICE if member not defined
                $this->$key=$value;
            }
        }

        global $_PAGE;

        if(!isset($_PAGE) || !is_object($_PAGE)) {
            trigger_error("Cannot create PageElement s without Page-object", E_USER_WARNING);
        }
        else {
            $this->page= $_PAGE;
        }
    }

    #--- render -------------------------------------
    # note: derived classes should not implement render() but __toString()
    public function render($arg=false)
    {
        if($arg) {
            return $this->__toString($arg);
        }
        else {
            return $this->__toString();
        }
    }

    public function add(PageElement $child)
    {
        if($child->name) {
            $this->children[$child->name]= $child;
        }
        else{
            $this->children[]=$child;
        }
    }
}


/**
* Class for rendering the beginning or an Page in html 
*
* @ingroup render
*/
class PageHtmlStart extends PageElement {

    public function __toString()
    {
        global $auth;
        $onload_javascript = "";

        ### include theme-config ###
        if($theme_config= getThemeFile("theme_config.inc.php")) {
            require_once($theme_config);
        }

        ### Set uft8
        header("Content-type: text/html; charset=utf-8");

        ### Disable page caching ###
        header("Expires: -1");
        header("Cache-Control: post-check=0, pre-check=0");
        header("Pragma: no-cache");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");


        $title= asHtml($this->page->title) . '/'. asHtml($this->page->title_minor).' - ' . confGet('APP_NAME');
        $buffer= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'

        .'<html>'
        .'<head>'
        .'<meta http-equiv="Content-type" content="text/html; charset=utf-8">';
        if(isset($auth->cur_user->language)) {
            $buffer.='<meta http-equiv="Content-Language" content="'.$auth->cur_user->language.'">';
        }
        
        $buffer.='<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">'
        .'<META HTTP-EQUIV="EXPIRES" CONTENT="-1">'
        .'<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">'
        .'<link rel="SHORTCUT ICON" href="./favicon.ico">'
        ."<title>$title</title>";

        /**
        * use Starlight syntax highlighting if enabled and client uses Gecko
        */
        if(confGet('LINK_STAR_LIGHT') && preg_match("/Gecko/i", getServerVar('HTTP_USER_AGENT'),$matches)) {
            $buffer.= "<link rel=\"stylesheet\" href=\"themes/starlight/star-light.css\" type=\"text/css\"/>";
        }

        $buffer.= "<link rel=\"stylesheet\" title=\"top\" media=\"screen\" type=\"text/css\" href=\"". getThemeFile("styles.css") . "?v=" . confGet('STREBER_VERSION') ."\">";
        $buffer.= "<!--[if IE]><link rel=\"stylesheet\" title=\"ie\" media=\"screen\" type=\"text/css\" href=\"". getThemeFile("styles_ie.css") . "?v=" . confGet('STREBER_VERSION') ."\"><![endif]-->";


        ### link print-style ###
        if(confGet('LINK_STYLE_PRINT')) {
            $buffer.="<link rel=\"stylesheet\" media=\"print, embossed\" type=\"text/css\" href=\"". getThemeFile("styles_print.css") . "?v=".confGet('STREBER_VERSION')."\">";
        }

        ### Add iphone layout hints
        if( stristr(getServerVar('HTTP_USER_AGENT'), "iPhone" ) ) {
            $buffer .= '<meta name = "viewport"  content = "initial-scale = 0.7, user-scalable = no">';
            $buffer .= '<link rel="stylesheet"  media="screen" type="text/css" href="'. getThemeFile("iphone.css") . "?v=" . confGet('STREBER_VERSION') .'">';
            $onload_javascript = 'window.scrollTo(0, 1);';
        }

        $buffer.='
        <script type="text/javascript" src="js/jquery-1.2.6.js' . "?v=" . confGet('STREBER_VERSION') . '"></script>
        <script type="text/javascript" src="js/jquery.jeditable.1.5.x.js' . "?v=" . confGet('STREBER_VERSION') . '"></script>
        <script type="text/javascript" src="js/misc.js' . "?v=" . confGet('STREBER_VERSION') . '"></script>
        <script type="text/javascript" src="js/listFunctions.js'. "?v=" . confGet('STREBER_VERSION') . '"></script>';

        if($this->page->use_autocomplete) {
            $buffer.='<script type="text/javascript" src="js/jquery.autocomplete.1.0.2.js' . "?v=" . confGet('STREBER_VERSION') . '"></script>';
            $buffer.='<link rel="stylesheet" type="text/css" href="' . getThemeFile("jquery.autocomplete.css") .'?v=' . confGet('STREBER_VERSION') . '" />';
        }

        $buffer.='
        <script type="text/javascript">
        ';
        
        if(confGet('TASKDETAILS_IN_SIDEBOARD')) {
            $buffer.="var g_enable_sideboard= true;";                    
        }
        else {
            $buffer.="var g_enable_sideboard= false;";                    
        }
        
        ### assemble onLoad function
        $buffer.='
        <!--
            //------ on load -------
            $(document).ready(function(){
        ';

        $buffer.= $onload_javascript;
        if($this->page->use_autocomplete) {
            $buffer .= 'initAutocompleteFields();';
        }

        if($this->page->autofocus_field) {
            $buffer.="
document.my_form." . $this->page->autofocus_field. ".focus();
document.my_form." . $this->page->autofocus_field. ".select();";
        }

        $buffer.='initContextMenus();
                ';

        if($q=get('q')) {
            $q= asCleanString($q);  
            if($ar = explode(" ",$q)) {
                foreach($ar as $q2) {
                    if($q2) {
                        $buffer.= "highlightWord(document.getElementsByTagName('body')[0],'$q2'); ";
                    }
                }
            }
            else {
                $buffer.= "highlightWord(document.getElementsByTagName('body')[0],'$q'); ";
            }
        }


        $buffer.= "misc();
                   listFunctions();

            });

        //-->
        </script>
        <script type=\"text/javascript\" src=\"js/contextMenus.js\"></script>
        <script type=\"text/javascript\" src=\"js/searchhi.js\"></script>
        <script type=\"text/javascript\">
            cMenu.menus=new Object();
        </script>";

        /**
        * for notes on searchi see: http://www.kryogenix.org/code/browser/searchhi/
        */

        ### add calendar-functions for form-pages ###
        # NOTE: including calendar tremedously increases loading time!
        if($this->page->use_jscalendar) {
            $buffer.= '<style type="text/css">@import url(' . getThemeFile('/calendar-win2k-1.css') . ');</style>'
            . '<script type="text/javascript" src="js/calendar.js"></script>'
            . '<script type="text/javascript" src="js/lang/calendar-en.js"></script>'
            . '<script type="text/javascript" src="js/calendar-setup.js"></script>'
            . '<script type="text/javascript" src="js/dragslider.js"></script>';
        }

        ### add extra html ###
        $buffer.= $this->page->extra_header_html;

        $buffer.= "
        </head>";
        $buffer.='<body ';
        global $PH;
        if(isset($PH->cur_page_id)) {
            $buffer.= "class=\"$PH->cur_page_id\"";
        }


        #$buffer.="updateTableColor();";
        $buffer.='>'; # close body tag & onload
        $buffer.= "<div class=\"noscript\"><noscript>";
        $buffer.= __("This page requires java-script to be enabled. Please adjust your browser-settings.");
        $buffer.="</noscript></div><div id=\"outer\">";

        return $buffer;
    }
}



/**
* HTML End
*
* @ingroup render
*/
class PageHtmlEnd extends PageElement {

    public function __toString()
    {
        switch($this->page->format){
            case FORMAT_CSV:
                $buffer = '';
                break;

            default:
                $buffer = $this->PageHtmlEndAsHTML();
                break;
        }

        return $buffer;

    }

    private function PageHtmlEndAsHTML()
    {
        $buffer="";
        $footer= new PageFooter;
        $buffer.= $footer->render();
        $buffer.= "</div><div id=\"sideboard\"><div></div></div></body></html>";
        return $buffer;
    }
}



/**
* Render Header @ingroup render
*/
class PageHeader extends PageElement
{

    public function __toString()
    {
        switch($this->page->format){
            case FORMAT_CSV:
                $buffer = '';
                break;
            default:
                $buffer = $this->PageHeaderAsHTML();
                break;
        }

        return $buffer;
    }

    private function PageHeaderAsHTML(){
        global $PH;
        global $auth;


        echo(new PageHtmlStart);

        $logout_url=$PH->getUrl('logout');
        $app_url= confGet('APP_PAGE_URL');

        $submit_url= confGet('USE_MOD_REWRITE')
                ? 'submit'
                : 'index.php';

        $buffer= '<form name="my_form" action="'. $submit_url .'" method="post" enctype="multipart/form-data" >';
        $buffer.="\n<div id=\"header\">
                <div id=\"logo\">";
        $buffer.="<div class=\"text\">"
                ."<a title=\"" . confGet('APP_NAME') ." - free web based project management\" href=\"$app_url\">"
                .confGet('APP_TITLE_HEADER')
                ."</a>"
                ."</div>".
                "</div>";

        ### account if logged in ###
        if($auth->cur_user) {

            ### login / register if anonymous user ###
            if($auth->cur_user->id == confGet('ANONYMOUS_USER')) {
                $buffer.="<div id=\"user_functions\">"
                       ."<span class=\"features\">"
                       . "<b>".$PH->getLink('loginForm',__('Login'),array()). "</b>";
                if(confGet('REGISTER_NEW_USERS')) {
                   $buffer  .= "<em>|</em>"
                            .  $PH->getLink('personRegister',__('Register'),array());
                }
                $buffer.= "</span>"
                       .  "</div>";

            }

            ### account / logout ###
            else {
                $link_home= $PH->getLink('personView',$auth->cur_user->name,array('person'=>$auth->cur_user->id),'name');;

                $buffer.="<div id=\"user_functions\">"
                       . "<span class=\"user\">". __("you are"). " </span>"
                       . $link_home
                       ."<em>|</em>"
                       ."<span class=\"features\">"
                      #. $PH->getLink('personEdit',__('Profile'),array('person'=>$auth->cur_user->id))
                      #. "<em> | </em>"
                      . "<a href=\"$logout_url\">" . __("Logout") ."</a>"
                      . "</span>"
                      . "</div>";
            }
        }
        else if(confGet('REGISTER_NEW_USERS')) {
                $buffer.="<div id=\"user_functions\">"
                       ."<span class=\"features\">"
                       ."<b>". $PH->getLink('personRegister',__('Register'),array()) . "</b>"
                      . "</span>"
                      . "</div>";

        }

        $tabs= new PageHeaderSections;

        $buffer.= $tabs->render();
        #echo(new PageHeaderSections);
        $buffer.="</div>";


        $crumbs= new PageHeaderNavigation;                   # breadcrumbs and options

        $buffer.=$crumbs->render();


        #--- write message ---
        global $PH;
        if($PH->messages) {
            $buffer.='<div class="messages">';
            foreach($PH->messages as $m) {
                if(is_object($m)) {
                    $buffer.= $m->render();
                }
                else {
                    $buffer.="<p>$m</p>";
                }
            }
            $buffer.='</div>';
        }

        $title=new PageTitle;
        $buffer.=$title->render();

        $functions= new PageFunctions();
        $buffer.= $functions->render();   # actually this should be a string-context for __toString , but it isn't ???

        return $buffer;
    }
}


/**
* Section elements in a page header
*
* @ingroup render
*/
class PageHeaderSections extends PageElement {

    public function __toString()
    {
    #   global $tabs, $cur_tab, $str, $header_cur_tab_bg;

        $buffer= '<div id="sections">';

        $tab_found=false;
        if(!isset($this->page->tabs) || !is_array($this->page->tabs)) {
            trigger_error("tabs not defined", E_USER_WARNING);
            return;
        }

        $page=$this->page;
        foreach($page->tabs  as $tab=>$values){

            $bg=    isset($values['bg'])
                ? $values['bg']
                : "misc";
            $active="";

            /**
            * ignore tabs with out target (e.g. disable links)
            */
            $target= isset($values['target'])
                   ? $values['target']
                   : '';
            if(!$target) {
                continue;
            }

            #--- current tab ----
            if($tab === $this->page->cur_tab) {
                $active="current";
                $page->section_scheme= $bg;
                $tab_found=true;
            }
            else {
                $bg.= "_shade"; # shade non-active tabs
            }
            $bg= "bg_$bg";

            $accesskey= isset($values['accesskey'])
                ? $accesskey='accesskey="'.$values['accesskey'].'" '
                : "";

            $tooltip= isset($values['tooltip'])
                ? 'title="'. asHtml($values['tooltip']).'" '
                : "";

            $html= isset($values['html'])
                ? $html= $values['html']
                : "";
            $active==""
                ? $buffer.= "<span id=\"tab_{$tab}\" class=\"section {$bg}\" $tooltip>\n"
                : $buffer.= "<span id=\"tab_{$tab}\" class=\"section {$active} {$bg}\" $tooltip>\n";
            $buffer.= "<a href=\"$target\"  $accesskey>";
            $buffer.= $values['title'];
            $buffer.= '</a>';
            $buffer.= $html;
            $buffer.= "</span>";
        }
        $buffer.= '</div><b class=doclear></b>';
        /**
        * we do not display sections for crawlers, to do not complain
        */
        global $auth;
        if(!$tab_found && !Auth::isCrawler()) { 
            trigger_error("Could not find tab '{$this->page->cur_tab}' in list...", E_USER_NOTICE);
        }

        return $buffer;
    }
}  


/**
* Navigation structure of a Page (crumbs and options)
*
* @ingroup render
*/
class PageHeaderNavigation extends PageElement
{
    public function __toString() {
        global $PH;

        $scheme=$this->page->section_scheme;
        $buffer="<div id=\"nav_sub\" class=\"bg_$scheme\">";


        ### look for active naviLink ###
        $active_navi_link= NULL;
        $last_navigation_option = NULL;
        foreach($this->page->crumbs as $l) {

            if(!$l instanceof NaviLink) {
                trigger_error("navigation link as invalid type (added string instead of NaviLink-Object?)",E_USER_NOTICE);
            }

            ### overwrite active crumb-setting for tasks
            else if($l->target_id == $this->page->cur_crumb) {
                $l->active = true;
                $active_navi_link= $l;
                if($last_navigation_option) {
                    $last_navigation_option->parent_of_active= true;
                }
                break;                
            }
            else if($l->target_id == $PH->cur_page_id) {
                $l->active = true;
                if($active_navi_link) {
                    $active_navi_link->active=false;
                }
                $active_navi_link= $l;
                if($last_navigation_option) {
                    $last_navigation_option->parent_of_active= true;
                }
            }
            $last_navigation_option = $l;
        }
        foreach($this->page->options as $l) {
            ### overwrite active crumb-setting for tasks
            if($l->target_id == $this->page->cur_crumb) {
                $l->active = true;
                $active_navi_link= $l;
                break;
            }
            else if($l->target_id == $PH->cur_page_id) {
                $l->active = true;
                if($active_navi_link) {
                    $active_navi_link->active=false;
                }
                $active_navi_link= $l;
            }
        }

        if($this->page->crumbs) {

            ### breadcrumbs ###
            $buffer.= '<span class="breadcrumbs">';


            $sep_crumbs="";
            $page=$this->page;

            $count=0;       # count added crumbs to mark the last crumb as current
            $style="";
            foreach($page->crumbs as $crumb) {

                if($crumb instanceOf NaviCrumb) {
                    /**
                    * also see NaviCrumb->render()
                    */
                    if($str= $crumb->render()) {
                        $buffer.=  $sep_crumbs . $str;
                        $sep_crumbs="<em>&gt;</em>";
                    }
                }
            }

            if($this->page->options) {
                $buffer.= $sep_crumbs;
            }
            $buffer.= "</span>";
        }

        ### options ###
        if($this->page->options) {
            $buffer.= '<span class="options">';
            $page= $this->page;
            $tmp_counter=0;                 # HACK! just to highlight a dummy breadcrump to test GUI-style

            $sep_options= "";
            foreach($page->options as $option) {

                $tmp_counter++;

                if($option instanceOf NaviOption) {
                    if($option->separated) {
                        $buffer.= '<em class="sep">|</em>';
                    }
                    else {
                        $buffer.= $sep_options;
                    }
                    $buffer.= $option->render();
                }
                else {
                    trigger_error(sprintf("NaviOption '%s' is has invalid type",$option),E_USER_WARNING);
                }
                $sep_options ="<em>|</em>";
            }
            $buffer.= "</span>";
        }

        ### wiki link ###
        $buffer .='<span class="help">'
                .'<a href="'
                .confGet('STREBER_WIKI_URL') . $PH->cur_page_id
                .'" title="' .__('Documentation and Discussion about this page')
                .'">'
                .__('Help')
                .'</a></span>';

        $buffer.="</div>";
        return $buffer;
    }


}



/**
* Rendering the Title of page
*
* @ingroup render
*/
class PageTitle extends PageElement {


    public function __toString() {
        $buffer="";

        $buffer.= '<div id="headline">';
        if($this->page->type) {
            $buffer.= '<div class="type">'. $this->page->type. '</div>';
        }
        $buffer.= '<h1 class="title">'. asHtml($this->page->title);
        if($this->page->title_minor_html) {
            $buffer.= '<span class="minor"><span class="separator">/</span>'. $this->page->title_minor_html. '</span>';
        }
        else if($this->page->title_minor) {
            $buffer.= '<span class="minor"><span class="separator">/</span>'. asHtml($this->page->title_minor). '</span>';
        }
        $buffer.= "</h1>";
        $buffer.= "</div>";


        return $buffer;
    }
}


/**
* Rendering page functions (normally in the upper right of a page)
*
* @ingroup render
*/
class PageFunctions extends PageElement {


    public function __toString() {
        $buffer="";

        $buffer.='<div class="page_functions">';
        if($this->page->functions) {

            $count= count($this->page->functions);
            foreach($this->page->functions as $key=>$fn) {

                $class_last= (--$count == 0)
                           ? 'class="last"'
                           : '';

                if($fn instanceOf PageFunctionGroup) {
                    $buffer.='<span class="group">'. $fn->name. ': </span>';
                }
                else {
                    if($fn->tooltip) {
                        $buffer.="<a $class_last href=\"$fn->url\" title=\"$fn->tooltip\">";
                    }
                    else {
                        $buffer.="<a $class_last href=\"$fn->url\">";
                    }


                    #if($fn->icon) {
                    #    $buffer.="<img src=\"". getThemeFile("/icons/". $fn->icon . ".gif") . "\">";
                    #}

                    $buffer.="$fn->name</a>";
                }
            }
        }
        $buffer.="</div>";
        return $buffer;
    }
}


/**
* Renders the beginning of a new content block
*
* @ingroup render
*/
class PageContentOpen extends PageElement
{

    public function __toString()
    {
        switch($this->page->format){
            case FORMAT_CSV:
                $buffer = '';
                break;

            default:
                $buffer = $this->PageContentOpenAsHTML();
                break;
        }

        return $buffer;
    }

    private function PageContentOpenAsHTML()
    {
        global $PH;

        if($this->page->content_open) {
            trigger_error("Content-table has already been opened. Wrong HTML-Structure? ", E_USER_WARNING);
        }
        $this->page->content_col=1;
        $this->page->content_open=true;
        $buffer="";

        ### pass from-handle? ###
        if(!$PH->cur_page_md5) {
            if(!($PH->cur_page_md5= get('from')) && !$PH->cur_page->ignore_from_handles) {
                #trigger_error("this page doesn't have a from-handle", E_USER_WARNING);       # this drops too many warnings in unit-tests
                $foo= true;
            }
        }
        else {
            $buffer.='<input type="hidden" name="from" value="'.$PH->cur_page_md5.'">';
        }

        $buffer.= '<div id="layout">';
        return $buffer;
    }
}

/**
* Renderings the beginning of a multiple columne view
*
* @ingroup render
*/
class PageContentOpen_Columns extends PageElement
{

    public function __toString()
    {

        global $PH;
        if($this->page->content_open) {
            trigger_error("Content-table has already been opened. Wrong HTML-Structure? ", E_USER_WARNING);
        }
        $this->page->content_col=1;
        $this->page->content_open=true;
        $this->page->content_columns=true;
        $buffer="";

        ### pass from-handle? ###
        if(!$PH->cur_page_md5) {
            if(!$PH->cur_page_md5= get('from')) {
                trigger_error("this page doesn't have a from-handle", E_USER_NOTICE);
            }
            $buffer.='<input type="hidden" name="from" value="'.$PH->cur_page_md5.'">';
        }
        else {
            $buffer.='<input type="hidden" name="from" value="'.$PH->cur_page_md5.'">';
        }

        $buffer.= '<div id="layout">';
        $buffer.= '<div id="c1">';
        return $buffer;
    }
}

/**
* Closes the content area
*
* @ingroup render
*/
class PageContentClose extends PageElement
{

    public function __toString()
    {
        switch($this->page->format){
            case FORMAT_CSV:
                $buffer = '';
                break;

            default:
                $buffer = $this->PageContentCloseAsHTML();
                break;
        }

        return $buffer;
    }

    private function PageContentCloseAsHTML(){
        global $PH;
        if(!$this->page->content_open) {
            trigger_error("No content-table to close. Wrong HTML-structure?", E_USER_NOTICE);
        }
        $this->page->content_open= false;

        $buffer="";
        $buffer.= "</div>";

        if($this->page->content_columns) {
            $buffer.= "</div>";
        }

        $go= $PH->go_submit
             ? $PH->go_submit
             : 'home';

        $buffer.= '<input type="hidden" name="go" value="'.$go.'">';
        $buffer.= "</form>";

        return $buffer;
    }
}

/**
* Renders the beginning of the next column
*
* @ingroup render
*/
class PageContentNextCol extends PageElement {
    public function __toString() {
        if(!$this->page->content_open) {
            trigger_error("No content-table to close. Wrong HTML-structure?", E_USER_NOTICE);
        }
        $this->page->content_col++;
        $buffer='</div><div id="c2">';
        return $buffer;
    }
}

/**
* Renders the footage of a page
*
* @ingroup render
*/
class PageFooter extends PageElement
{
    public function __toString()
    {
        global $TIME_START;
        global $DB_ITEMS_LOADED;
        global $g_count_db_statements;
        global $time_total;
        global $PH;
        global $auth;

        $view= 'NORMAL';
        if(isset($auth) && $auth->cur_user && ($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
            $view = 'ALL';
        }
        else if(Auth::isAnonymousUser()) {
            $view = 'GUEST';
        }

        $buffer='';

        $buffer.='<div id="footer">'
            .confGet('APP_NAME') . ' ';


        if($view != 'GUEST') {

            $buffer.=  confGet('STREBER_VERSION') . ' (' . confGet('STREBER_VERSION_DATE') . ') ';

            $TIME_END=microtime(1);
            $time_total= $TIME_END- $TIME_START;
            $time=($TIME_END-$TIME_START)*1000;
            $time_str=sprintf("%.0f",$time);
            $buffer.= " / ".__('rendered in')." $time_str ms / ";

            if(function_exists('memory_get_usage')) {
                $buffer.= __('memory used').": ". intval(memory_get_usage() / 1024)." kb / ";
            }

            $buffer .= ' ('. sprintf(__('%s queries / %s fields '), $g_count_db_statements, $DB_ITEMS_LOADED ) . ') ';

            if($view == 'ALL') {
                $buffer .= $PH->getLink('systemInfo','system info');
            }


            $buffer .= "<br/>";

            if(confGet('DISPLAY_ERROR_LIST') != 'NONE') {
                $buffer .= render_errors();
            }
            $buffer .= render_measures();

            if(confGet('LIST_UNDEFINED_LANG_KEYS')) {
                global $g_lang_new;
                if(isset($g_lang_new)) {
                    print "<b>undefined language keys:</b><br/>";
                    foreach($g_lang_new as $n=>$v) {
                        print "'$n'       =>'',<br/>";
                    }
                }
            }
        }

        $buffer.=  "</div>";
        return $buffer;
    }
}

/**
* render and return a table with the measured ids
*/
function render_errors() {
    global $g_error_list;
    global $auth;

    $buffer="";

    if($g_error_list) {
        $buffer.='<div class="error_list">';

        if($auth && $auth->cur_user && ($auth->cur_user->user_rights & RIGHT_VIEWALL)) {
            $str_link= "(see 'errors.log.php' for details)";
        }
        else {
            $str_link= "";
        }
        $buffer.="<em>".count($g_error_list)." errors ... $str_link</em><br/>";
        foreach($g_error_list as $e) {
            $buffer.="\n<p>".asHtml($e)."</p>";                         # 'ERROR:' will be recognized by unit-tests
        }
        $buffer.="\n</div>";
    }
    return $buffer;
}



?>
