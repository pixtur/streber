<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html


define('MAX_PAGE_RECURSIONS', 10);

/**
 * Representation of an internal page (like 'home') or form ('taskEdit')
 *
 * read more at: http://www.streber-pm.org/3392
 *
 */
class PageHandle extends BaseObject
{
    #--- members ----
    public  $id                 = NULL;
    public  $title              = '';
    public  $req                = NULL;
    public  $type               = 'norm';
    public  $rights_required    = 0;
    public  $valid_for_anonymous= false;
    public  $valid_for_tuid     = false;
    public  $http_auth          = false;    # enables http authentication e.g. for RSS feeds

    public  $ignore_from_handles=0;         # this blocks invalid from-handle-warnings
    public  $valid_params       =NULL;
    public  $test_params        =NULL;      # params required for unit-tests
    public  $test               =NULL;      # params required for unit-tests
    public  $called_with_from_handle=false; # links to this pageHandle will NOT include a from-handle
    public  $valid_for_crawlers = true;

    public  $cleanurl           =NULL;      # construction string for usage of clean urls like "123/files"
    public  $cleanurl_mapping   =NULL;      # array with variable mapping to build clean urls



    public function __construct($args=NULL)
    {
        global $PH;
        if(!$args) {
            trigger_error("can't create page-handle without params", E_USER_ERROR);
        }
        foreach($args as $key=>$value) {
            is_null($this->$key);           # cause a notice-message if undefined member used
            $this->$key= $value;
        }

        if(!$this->id || !$this->req) {
            trigger_error("A PageHandle needs at lest 'id' and 'required' as params", E_USER_ERROR);
        }
        $PH->addPage($this);
    }
}


/**
* pages containing forms (e.g. taskEdit). Pass from-handle
*/
class PageHandleForm extends PageHandle
{
    public  $type='form';
    public  $valid_for_crawlers     = false;
    public  $called_with_from_handle=true; # links to this pageHandle will include a from-handle

}

/**
* pages for submitting data, instantly rendering another page, Pass from-handle
*/
class PageHandleSubm extends PageHandle
{
    public  $type                   ='subm';
    public  $valid_for_crawlers     = false;
    public  $called_with_from_handle=true; # links to this pageHandle will include a from-handle
}

/**
* pages for function processing, instantly rendering another pages, Pass from-handle
*
* e.g. tasksDelete
*/
class PageHandleFunc extends PageHandle
{
    public  $type                   ='func';
    public  $valid_for_crawlers     = false;
    public  $called_with_from_handle=true; # links to this pageHandle will include a from-handle
}


/**
* feedback for user
*
* Examples e.g.
*  NOTE: "Updated task xyz".
*  WARNING: "Unsufficient rights to do XYZ"
*  ERROR: "A database error occured".
*
* - FeedbackMessages are collected in $PH->messages[]
* - FeedbackMessages have different types and can be overwritten by styles
*/

define('MESSAGE_NOTE',  __('Note'));
define('MESSAGE_WARNING', __('Warning'));
define('MESSAGE_ERROR', __('Error'));
define('MESSAGE_HINT',  __('Hint'));

class FeedbackMessage extends BaseObject
{
    private $html_text;
    private $type= MESSAGE_NOTE;  # also used as css-class

    /**
    * NOTE:
    * the $html_text must already be cleaned with asHtml()!
    */
    public function __construct($html_text, $type= MESSAGE_NOTE)
    {
        $this->html_text= $html_text;
        $this->type= $type;

        ### add to message-list ###
        global $PH;
        $PH->messages[]= $this;
    }

    public function render() {
        return "<p class=". strtolower($this->type) ."><span class=type>".__($this->type) .": </span>$this->html_text</p>";
    }
}

class FeedbackWarning extends FeedbackMessage
{
    public function __construct($html_text)
    {
        parent::__construct($html_text, MESSAGE_WARNING);
    }
}

class FeedbackError extends FeedbackMessage
{
    public function __construct($html_text)
    {
        parent::__construct($html_text, MESSAGE_ERROR);
    }
}

class FeedbackHint extends FeedbackMessage
{
    public function __construct($html_text)
    {
        parent::__construct($html_text, MESSAGE_HINT);
    }
}

/**
* Master-class for handling pages. This is used by the one global instance $PH
*
* read more on pagehandler:
*
*  - http://www.streber-pm.org/3648
*
*/
class PageHandler extends BaseObject
{
    PUBLIC      $hash;
    PUBLIC      $messages=array();
    public      $cur_page_md5=NULL;
    public      $cur_page_id;
    PUBLIC      $options;
    public      $go_submit=false;   # this is put into go-hidden-field
    public      $cur_page=NULL;     # page-handle object
    public      $page_params=NULL;  # params of the currently rendered page (used for client-view-url)
    public      $valid_global_params= array(
                        'from'      =>'*.',
                        'id'        =>'[\w\d_]*]',
                        'show_client_view'=>'1',
                        );

    public      $recursions=array();

    public function __construct()
    {
        global $PH;
        if(isset($PH)) {
            trigger_error("PageHandle can only be created once", E_USER_WARNING);
        }
        else {
            $this->hash=array();
#            $PH=$this;
        }
        $this->options=array();
    }

    public function addPage(PageHandle $phandle)
    {
        if(!$phandle || !is_object($phandle)){
            trigger_error("PageHandler::addPage requires a pageHandle as argument", E_USER_WARNING);
            return;
        }
        if(!isset($phandle->id) || $phandle->id=='') {
            trigger_error("PageHandler::addPage. PageHandle needs a valid id", E_USER_WARNING);
            return;
        }
        if(isset($this->hash[$phandle->id])) {
            trigger_error("Pagehandle '$phandle->id' has already been added", E_USER_WARNING);
            return;
        }
        $this->hash[$phandle->id]=$phandle;
    }


    /**
    * returns url of the curret page (with all necessary parameters)
    *
    * This function only returns valid Links for 'Normal' pages (not for forms, etc)
    * for all other, it returns NULL
    *
    * if flag_exit is set, returns link to valid original page
    */
    public function getClientViewUrl($flag_exit=false)
    {
        if(get_class($this->cur_page) == 'PageHandle') {
            if(!isset($this->page_params) || !$params=$this->page_params) {
                $params=array();
            }
            if(!$flag_exit) {
                $params['show_client_view']=1;
            }

            return $this->getUrl($this->cur_page->id,$params);
        }
    }

    /**
    * return valid url to this page, checks rights & param
    *
    * for directly referring to a URL overwrite the amp-parameter to "&"
    */
    public function getUrl($id=NULL, $params=NULL, $amp= "&amp;")
    {
        global $auth;
        

        if(!$id || !isset($this->hash[$id]) ) {
            trigger_error("id '$id' is not valid ".confGet('LINK_REPORT_BUGS'),E_USER_WARNING);
        }
        $phandle= $this->hash[$id];

        ### enough rights? ###
        if($phandle->rights_required) {

            /**
            * auth could not be defined, if unit-tests running...
            */
            if(!isset($auth) || !isset($auth->cur_user) || !($phandle->rights_required & $auth->cur_user->user_rights)) {
                return NULL;
            }
        }


        ### valid user? ###
        if(!$phandle->valid_for_crawlers && Auth::isCrawler()) {
            return NULL;            
        }

        $str_params='';
        if($params) {
            if(!is_array($params)) {
                trigger_error("params must be array (is '$params')". confGet('LINK_REPORT_BUGS'),E_USER_WARNING);
                return;
            }
            $str_params='';

            ### get valid params ###
            $valid_params=NULL;
            if(!is_null($phandle->valid_params)) {
                $valid_params =& $phandle->valid_params;

                ### make global params like from handle and id valid ###
                foreach($this->valid_global_params as $key=>$value) {

                    $valid_params[$key]= $value;
                }
            }

            foreach($params as $key=>$value) {
                if(is_null($value) || is_object($value)) {
                    /**
                    * this is common
                    */
                    #trigger_error("getUrl() ignored invalid parameter value for $key",E_USER_WARNING);
                    $value="";
                }

                ### check for valid params ###
                if(!is_null($valid_params) && !isset($valid_params[$key]) && $key!='q') {
                    trigger_error("Undefined paramater for page-handle '$id': '$key'='$value' ", E_USER_WARNING);
                }

                $str_params.= $amp . $key . '=' . $value;
            }
        }


        if(!$phandle->ignore_from_handles && $phandle->called_with_from_handle) {
            if($this->cur_page_md5) {
                $str_params.= $amp . 'from=' . $this->cur_page_md5;
            }
            else {
                /**
                * enable this warning only for debugging...
                * - there are a lot of reasons, why this could happen:
                *   - TriggerSentNotifications
                *   - Activation
                *   - displaying a page after relogin
                */
                #trigger_error("missing from-handle for '{$id}'", E_USER_WARNING);
            }
        }

        $buffer= "index.php?go={$id}{$str_params}";

        if(confGet('USE_MOD_REWRITE')) {
            /*
            $clean_urls= array(
                'taskView'=>array('tsk'=>'item_id'),
                'commentView'=>array('tsk'=>'item_id'),
                'effortView'=>array('tsk'=>'item_id'),
                'projView'=>array('tsk'=>'item_id'),
                'projView'=>array('tsk'=>'item_id'),


            );
            if(isset($clean_urls[$id])) {

                foreach($clean_urls[$id] as $old => $new) {
                    if(isset($params[$old])) {
                        if($new == 'item_id') {
                            $item_id= $params[$old];
                        }
                    }
                }
                $buffer= $item_id;

            }
            */

            if($url= $phandle->cleanurl) {
                if($phandle->cleanurl_mapping) {
                    foreach($phandle->cleanurl_mapping as $old => $new) {
                        if(isset($params[$old])) {
                            $var= $params[$old];
                        }
                        else {
                            $var= '';
                        }
                        $url= str_replace($new, $var, $url);
                    }
                }
                $buffer= $url;
            }
        }
        return $buffer;
    }



    /**
    * getLink (return nothing, if not enough user-rights)
    * - link name will be converted to html
    */
    public function getLink($id=NULL, $name=NULL, $params=NULL,$style=NULL, $allow_html=false)
    {
        ### try to get url ###
        if($url=$this->getUrl($id,$params)) {
            if(!$name && $this->hash[$id]->title) {
                $name= $this->hash[$id]->title;
            }
            else if(!$allow_html) {
                $name= asHtml($name);
            }
            $class=$style
                ? "class='$style'"
                : '';

            $buffer= '<a '.$class.' href="'. $url. '">'. $name .'</a>';
            return $buffer;
        }
        ### probably not enough rights ###
        else {
            return NULL;
        }
    }


    #--------------------------------------------------------------------
    # getPage / checks the id and returns valid page, DOES NOT CHECK FOR RIGHTS
    #--------------------------------------------------------------------
    public function getPage($id)
    {
        global $auth;

        if(!$id || !isset($this->hash[$id]) ) {
            trigger_error("PageHandle::getPage id '$id' is not valid. Please report this bug.",E_USER_WARNING);
            return;
        }
        return $this->hash[$id];
    }

    #--------------------------------------------------------------------
    # getValidPage / checks the id and returns valid page, CHECK FOR RIGHTS
    #--------------------------------------------------------------------
    public function getValidPage($id)
    {
        global $auth;

        if(!$id || !isset($this->hash[$id]) ) {
            trigger_error("PageHandle::getPage id '$id' is not valid", E_USER_WARNING);
            return;
        }

        ### check sufficient user-rights ###
        $handle=$this->hash[$id];
        if($handle->rights_required && !($handle->rights_required & $auth->cur_user->user_rights)) {
            return NULL;
        }
        return $this->hash[$id];
    }

    #--------------------------------------------------------------------
    # getPage / checks the id and returns valid page-id
    #--------------------------------------------------------------------
    public function getValidPageId($id)
    {
        global $auth;

        if(!$id || !isset($this->hash[$id]) ) {
            trigger_error("PageHandle::getPage id '$id' is not valid", E_USER_WARNING);
        }


        ### check sufficient user-rights ###
        $handle=$this->hash[$id];
        if($handle->rights_required) {
            if( !($handle->rights_required & $auth->cur_user->user_rights)) {
                return NULL;
            }
        }
        return $id;
    }


    /**
    * getHandle for the current page
    *
    * A FromHandle links an intern url (including a parameter-list) to an MD5-checksum. Those
    * pairs are stored server sided in './tmp/from_pages.lst'. The from_handle is stored by
    * the page-handler and is appended as GET-parameter to all urls created afterwards.
    *  Additionally it's automatically added as hidden-field at the beginning of PageContentOpen()
    * to pass it on form-submit.
    * For all start-pages (pages with lists), the from-handle should be set by this function before
    * creating a page-object.
    *
    */
    public function defineFromHandle($params=NULL)
    {
        global $auth;
        if(!isset($auth->cur_user)) {
            return NULL;
        }


        #--- create new md5-handle and store page-id and params in local file
        if(!$params) {
            $params=array();
        }
        $params['go']=$this->cur_page_id;
        $from= http_build_query($params);
        $from=str_replace("&amp;",'&',$from);

        $md5= md5($from);

        $this->cur_page_md5= $md5;

        $flag_already_stored=false;
        $stored_handles=array();

        ### use modified version of user-cookie as filename ###
        $filename= confGet('DIR_TEMP').md5($auth->cur_user->identifier);


        ### read current from-handles ###
        if(is_readable($filename)) {
        	if (!($FH = fopen ( $filename, 'r'))) {
                die ('could not open page-history. This might be cause by insufficient directory rights.');
	        }
	        $data = fread ($FH, 64000);
    	    fclose ($FH);

            $arr= preg_split("/\n/",$data);

            ### convert to assoc. array and look for md5 ###
            foreach($arr as $line) {
                $tmp_arr=preg_split("/\|/",$line);
                if(count($tmp_arr)==2) {
                    ### store as assoc. array. ###
                    $stored_handles[$tmp_arr[0]]=$line;
                }
                if(count($stored_handles) > MAX_STORED_FROM_HANDLES) {
                    break;
                }
            }
            ### current from-handle already in there ###
            if(isset($stored_handles[$md5])) {
                $flag_already_stored= true;
            }

        }
        else {
            $arr=array();
        }

        ### add handle and write to file ###
        if(!$flag_already_stored) {

            ### if full remove last ###
            array_unshift($stored_handles, $md5.'|'.$from);

            if(file_exists($filename . '_tmp')) {
                unlink($filename . '_tmp');
            }
           	if(file_exists($filename)) {
        	    $result= rename($filename, $filename . '_tmp');     # surpressing FILE-EXISTs notice
        	}
        	$FH=fopen ($filename."_tmp","w");
        	fputs ($FH, join($stored_handles,"\n"));                       # join the array
        	fclose ($FH);
        	if(file_exists($filename."_tmp")) {
        	    $result= rename($filename."_tmp", $filename);     # surpressing FILE-EXISTs notice
        	}
        }
        #--- write to file --
    	#$result=chmod ("$tmp_dir/$filename", 0777);
        #$result=unlink("$tmp_dir/$filename");
    	#$result=chmod ("$tmp_dir/$filename", 0664);

        $this->page_params=$params;     # keep for client-view-url
        return $md5;
    }



    #--------------------------------------------------------------
    # returns param-array for from-handle
    #--------------------------------------------------------------
    public function getFromParams($from_handle=NULL)
    {
        global $auth;
        if(!$from_handle) trigger_error("getFromParams requires a from-string", E_USER_ERROR);



        ### use modified version of user-cookie as filename ###
        $filename= confGet('DIR_TEMP').md5($auth->cur_user->identifier);


        ### read current from-handles ###
        if(is_readable($filename)) {
        	if (!($FH = fopen ( $filename, 'r'))) {
                trigger_error('could not open page-history. This might be caused by insufficient directory rights.', E_USER_WARNING);
                return NULL;
	        }
	        $data = fread ($FH, 64000);
    	    fclose ($FH);

            $arr= preg_split("/\n/",$data);

            ### convert to assoc. array and look for md5 ###
            $stored_handles=array();
            foreach($arr as $line) {
                $tmp_arr= preg_split("/\|/",$line);
                if(count($tmp_arr)==2) {
                    $stored_handles[$tmp_arr[0]]=$tmp_arr[1];
                }
                if(count($stored_handles) > MAX_STORED_FROM_HANDLES) {
                    break;
                }
            }
            ### current from-handle already in there ###
            if(isset($stored_handles[$from_handle])) {

                $params= array();
                parse_str($stored_handles[$from_handle], $params);
                return $params;
            }
        }
        return NULL;
    }

    #--------------------------------------------------------------------
    # showFromPage if available
    #--------------------------------------------------------------------#
    # NOTE returns false if $from is not available
    public function showFromPage($from_handle=NULL)
    {
        if(!$from_handle) {
            $from_handle= get('from');
            if(!$from_handle) {
                return false;
            }
        }
        global $PH;
        if($params= $PH->getFromParams($from_handle)) {

            if(isset($params['go'])) {
                $go= $PH->getPage($params['go'])->id;       # be sure the page-id is value
                unset($params['go']);                       # don't pass the id as param
                $PH->show($go,$params);
                
                /**
                * Although the following alternative works very nice in theory, 
                * we have to implement a way, to store the flash notices either
                * in a session variable or somewhere in the database.
                * 
                * FlashNotices
                *  uid, timestamp, message
                */
                #header("Location: ".$this->getUrl($go, $params, '&'));
            }
            else {
                trigger_error("no page-id in params got by from_handle.".confGet('LINK_REPORT_BUGS'));
            }
        }
        else {
            return false;
        }
        return true;
    }

    #--------------------------------------------------------------------
    # show()
    #--------------------------------------------------------------------
    public function show($id=NULL, $params=NULL,$fn_argument=NULL)
    {
        global $auth;

        ### echo debug output ###
        if(isset($auth->cur_user)) {
            $user_name= $auth->cur_user->name;
        }
        else {
            $user_name= '__not_logged_in__';
        }
        $crawler= Auth::isCrawler()
                ? 'crawler'
                : '';
                                  
        log_message($user_name . '@' .  getServerVar('REMOTE_ADDR', true) . " -> $id ". getServerVar('REQUEST_URI') . "  (" . getServerVar('HTTP_USER_AGENT') . ") $crawler"  , LOG_MESSAGE_DEBUG);

        if(!$id) {
            $this->show('home');
            exit;
        }
        
        else if( $id != asAlphaNumeric($id)) {
            new FeedbackWarning("Ignored invalid page '". asCleanString($id) ."'");
            $this->show('home');
            exit;
        }            
        else if(!isset($this->hash[$id]) ) {
            trigger_error('try to show undefined page-id '.$id, E_USER_WARNING);
            $this->show('error');
            return;
        }
        $handle=$this->hash[$id];

        ### not authenticated ###
        if(!isset($auth) || !$auth->cur_user) {
            if(!$handle->valid_for_anonymous)
            {
                new FeedbackWarning("As an anonymous user you have not enough rights to view page '$id'");
                $this->show('loginForm');
                exit();
            }
        }

        ### check sufficient user-rights ###
        if($handle->rights_required && !($handle->rights_required & $auth->cur_user->user_rights)) {
            $this->abortWarning("insufficient rights");
        }

    	require_once($handle->req);


        #--- set page-handler-curpage ---
        $keep_cur_page_id= $this->cur_page_id;  # show() might be called again, so we have to keep the page_id

        $this->cur_page_id= $id;

        $keep_cur_page= $this->cur_page;
        $this->cur_page= $handle;


        ### submit ###
        if($handle->type='subm') {
            $tmp= get('from');
            if($tmp) {
                $this->cur_page_md5=$tmp;
            }
        }

        #--- set params ---
        if($params) {
#            global $vars;
#            foreach($params as $key=>$value) {
#                $vars[$key]=$value;
#            }
#            $vars['go']=$id;
            $params['go'] = $id;
            addRequestVars($params);
        }

        #--- avoid endless traps ---
        if(count($this->recursions) > MAX_PAGE_RECURSIONS) {

            trigger_error("maximum page recursions reached! (". implode(",", $this->recursions) .")", E_USER_ERROR);
            return;
        }
        $this->recursions[]= $id;

        #--- use id as function-name ----
        if(function_exists($id)) {
            if($fn_argument) {
                $id($fn_argument);  # pass additional paramenter (eg. non-db-objects to xxxNew()-functions)
            }
            else {
                $id();
            }
        }
        else {

            $this->abortWarning("page-call to undefined functions '$id'",ERROR_FATAL);
        }


        $this->cur_page_id= $keep_cur_page_id;
        $this->cur_page= $keep_cur_page;
    }


    #--------------------------------------------------------------------
    # abort and show error
    # - tries to display from page first
    # - otherwise shows 'home'
    #-------------------------------------------------------------------
    public function abortWarning($warning=NULL ,$type=ERROR_WARNING) {
        $link_report_bugs= confGet('LINK_REPORT_BUGS');

        if($type == ERROR_WARNING) {
            new FeedbackWarning(sprintf(__("Operation aborted (%s)"), $warning));
        }
        else if($type == ERROR_FATAL) {
            new FeedbackError(sprintf(__("Operation aborted with an fatal error (%s)."), $warning). $link_report_bugs);
        }
        else if($type == ERROR_BUG) {
            new FeedbackError(sprintf(__("Operation aborted with an fatal error which was cause by an programming error (%s)."), $warning). $link_report_bugs);
        }
        else if($type == ERROR_RIGHTS) {
            #trigger_error("Abort Warning Insufficient rights", E_USER_NOTICE);
            log_message("Abort Warning Insufficient rights", LOG_MESSAGE_DEBUG);

            if($warning) {
                $str_reason= ' ('. $warning. ')';
            }
            new FeedbackWarning(__("insufficient rights"). $str_reason);
        }
        else if($type == ERROR_DATASTRUCTURE) {
            trigger_error("Error data structure", E_USER_WARNING);
            new FeedbackError(sprintf(__("Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up."), $warning). $link_report_bugs);
        }
        else if($type == ERROR_NOTE) {
            new FeedbackMessage($warning);
        }
        else {
            new FeedbackWarning($warning);
        }


        /**
        * Warnings might be causes because anonymous user have not enough rights.
        * Best continue with the loginForm to use the go_after settings. This enables
        * links from notification mails and from extern.
        */
        if(!$this->showFromPage()) {
            global $auth;
            if(confGet('ANONYMOUS_USER') && $auth->cur_user->id == confGet('ANONYMOUS_USER')) {
                $this->show('loginForm');
            }
            else {
                $this->show('home');
            }
        }
        exit();
    }

    public function getWikiLink($page=NULL, $alt_title=NULL) {
        if(!$page) {
            return "<a href='" . confGet('STREBER_WIKI_URL').  "{$this->cur_page_id}' target='_blank'>Wiki+Help</a>";
        }
        else {
            if($page == "WikiSyntax") {
            $page = confGet('STREBER_WIKISYNTAX');
            }        
            if(!$alt_title) {
                $alt_title= $page;
            }
            return "<a href='" . confGet('STREBER_WIKI_URL').  "{$page}' target='_blank'>$alt_title</a>";
        }
    }
    

    public function getCSVLink($page=NULL, $format= FORMAT_CSV) {
        if(is_null($page)) {
            $page= $this->cur_page_id;
        }
        if(!$page) {
            trigger_error("Can not render format link without page object", E_USER_WARNING);
            return NULL;
        }
        else {
            $str_params =  '?format=' . $format;

            foreach($this->page_params as $key => $value) {
                $str_params .= "&" . $key ."=". $value;
            }

            return "<a href='index.php{$str_params}'>". __("Export as CSV") ."</a>";
        }


    }

    /**
    * return requested pagehandle or loginForm if not valid
    *
    * Does not check for user rights
    */

    public function getRequestedPage() 
    {

        if(isset($this->hash[get('go')])) {
            return $this->hash[get('go')];
        }
        else {
            return $this->hash['loginForm'];
        }       
    }


}

global $PH;
$PH=new PageHandler();

?>
