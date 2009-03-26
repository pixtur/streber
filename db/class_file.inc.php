<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * file object
 *
 * @author         Thomas Mann
 */




/**
* class for handling project - files
*/
class File extends DbProjectItem
{
    public $tmp_filename="";                               #  filename relative to index.php to which file is moved unti insert()

	//=== constructor ================================================
	function __construct ($id_or_array=false)
    {
        global $g_file_fields;
        $this->fields= &$g_file_fields;

        parent::__construct($id_or_array);
        if(!$this->type) {
            $this->type= ITEM_FILE;
        }
   	}

    /**
    *  setup the database fields for file-object as global assoc-array
    */
    static function initFields() 
    {
        global $g_file_fields;
        $g_file_fields= array();
        addProjectItemFields(&$g_file_fields);
    
        foreach(array(
            new FieldInternal(array(    'name'=>'id',
                'default'=>0,
                'in_db_object'=>1,
                'in_db_item'=>1,
            )),
                new FieldString(array(      'name'=>'name',
                    'title'=>__('Name'),
                    'view_in_forms'=>true
                )),
                new FieldString(array(      'name'=>'org_filename',
                    'view_in_forms'=>false
                )),
    
                /**
                * filepath and name under which file is stored on server
                * - relative to DIR_FILES
                * - cleaned from special chars
                * - with appended_version_number
                *
                * e.g. prj321/bla.gif
                *      prj321/bla.gif.1
                */
                new FieldString(array(      'name'=>'tmp_filename',
                    'view_in_forms'=>false
                )),
    
                new FieldString(array(      'name'=>'tmp_dir',
                    'view_in_forms'=>false
                )),
    
                new FieldString(array(      'name'=>'mimetype',
                    'view_in_forms'=>false
                )),
                new FieldInternal(array(    'name'=>'status',
                    'view_in_forms'=>false
                )),
                new FieldInt(array(         'name'=>'filesize',
                    'view_in_forms'=>false
                )),
                new FieldInt(array(         'name'=>'version',
                    'view_in_forms'=>false,
                    'default'=>1,
                )),
    
                /**
                * DEPRECIATED: if true, a thumbnail will be displayed in wiki-texts
                * 
                * The filetype is taken from mimetype
                */
                new FieldBool(array(         'name'=>'is_image',
                    'view_in_forms' =>false,
                    'default'       =>0
                )),
    
                /**
                * if several versions of a file with the same filenames are uploaded,
                * the current / recent version is marked with this flag
                */
                new FieldBool(array(         'name'=>'is_latest',
                    'view_in_forms' =>false,
                    'default'       =>1
                )),
    
                /**
                * if a thumbnail has been created this is the absolute
                * path
                */
                new FieldString(array(      'name'=>'thumbnail',
                    'view_in_forms'=>false
                )),
    
                new FieldInternal(array(      'name'=>'parent_item',
                    'view_in_forms'=>false
                )),
    
                /**
                * if this is not zero file is and update of file with this id
                */
                new FieldInternal(array(      'name'=>'org_file',
                    'view_in_forms'=>false
                )),
    
    
                new FieldText(array(        'name'=>'description',
                    'title'=>__('Description'),
    
                )),
        ) as $f) {
            $g_file_fields[$f->name]=$f;
        }
    }


    /**
    * query from db
    *
    * - returns NULL if failed
    */
    static function getById($id)
    {
        $c= new File(intval($id));
        if($c->id) {
            return $c;
        }
        return NULL;
    }


    static function getVisibleById($id)
    {
        if($c= File::getById(intval($id))) {
            if($c->id) {
                if($p= Project::getById($c->project)) {
                    if($p->validateViewItem($c,false)) {
                        return $c;
                    }
                }
            }
        }
        return NULL;
    }


    /**
    * query if editable for current user
    */
    static function getEditableById($id)
    {
        if($c= File::getById(intval($id))) {
            if($p= Project::getById($c->project)) {
                if($p->validateEditItem($c,false)) {
                    return $c;
                }
            }
        }
        return NULL;
    }

    /**
    * return files attached to project
    * @@@ todo:
    * - refacture status_min/max evaluation only if !is_null
    *
    */
    static function getAll( $args=NULL)
        {
        global $auth;
		$prefix = confGet('DB_TABLE_PREFIX');

        ### default params ###
        $project            = NULL;
        $latest_only        = true;
        $order_by           = "name";
        $status_min         = STATUS_UNDEFINED;
        $status_max         = STATUS_CLOSED;
        $visible_only       = true;       # use project rights settings
        $alive_only         = true;       # ignore deleted
        $parent_item        = NULL;       #
        $images_only        = false;
        $date_min           = NULL;
        $date_max           = NULL;
        $org_file           = NULL;
		$id			        = NULL;
	    $created_by         = NULL;

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

        $str_project= $project
            ? 'AND i.project=' . intval($project)
            : '';

        $str_project2= $project
            ? 'AND upp.project=' . intval($project)
            : '';

        $str_is_alive= $alive_only
            ? 'AND i.state=' . ITEM_STATE_OK
            : '';


        $str_date_min= $date_min
            ? "AND i.modified >= '" . asCleanString($date_min) . "'"
            : '';

        $str_date_max= $date_max
            ? "AND i.modified <= ' ". asCleanString($date_max) . "'"
            : '';

        $str_is_image= $images_only
            ? 'AND f.is_image!=0'
            : '';

        $str_latest_only= $latest_only
            ? 'AND f.is_latest!=0'
            : '';

        $str_created_by= $created_by
            ? 'AND i.modified_by ='. intval($created_by)
            : '';

        $str_parent_item= !is_null($parent_item)
            ? 'AND f.parent_item=' . intval($parent_item)
            : '';

        $str_org_file= $org_file
            ? "AND f.org_file = '" . intval($org_file) . "'"
            : "";

		$str_id = $id
            ? "AND f.id = " . intval($id)
            : "";

		if ($auth->cur_user->user_rights & RIGHT_VIEWALL)
		{
			$str_projectperson = "";
		}
		else
		{
			$str_projectperson = "AND upp.person = {$auth->cur_user->id}";
		}

        if($visible_only) {
            $str_query=
            "SELECT DISTINCT i.*, f.* from {$prefix}item i, {$prefix}file f, {$prefix}projectperson upp
            WHERE
                    i.type = '".ITEM_FILE."'
                $str_project
                $str_projectperson
                $str_project2

                $str_is_alive
                AND ( i.pub_level >= upp.level_view
                      OR
                      i.created_by = {$auth->cur_user->id}
                )

                AND i.id = f.id
				 $str_id
                 $str_created_by
                 $str_is_image
                 $str_parent_item
                 $str_org_file
                 $str_latest_only
                 AND f.status >= $status_min
                 AND f.status <= $status_max
                 $str_date_max
                 $str_date_min

            ". getOrderByString($order_by)
            ;
        }
        ### show all ###
        else {
            $str_query=
        	"SELECT i.*, f.* from {$prefix}item i, {$prefix}file f
            WHERE
                i.type = '".ITEM_FILE."'
            $str_project
            $str_is_alive

            AND i.id = f.id
			 $str_id
             $str_created_by
             $str_parent_item
             $str_latest_only
             AND f.status >= $status_min
             AND f.status <= $status_max
             $str_org_file
             $str_date_max
             $str_date_min

            ". getOrderByString($order_by)
            ;
        }

        $dbh = new DB_Mysql;
        $sth= $dbh->prepare($str_query);

    	$sth->execute("",1);
    	$tmp=$sth->fetchall_assoc();
    	$files=array();
        require_once(confGet('DIR_STREBER') . 'db/class_file.inc.php');
        foreach($tmp as $t) {
            $file=new File($t);
            $files[]=$file;
        }
        return $files;
    }

    /**
    * returns the original version of a file (could be itself)
    */
    public function getOriginal()
    {
        if($this->org_file == 0) {
            return $this;
        }
        if($org_file= File::getVisibleById($this->org_file)) {    # NOTE: this is slow!
            return $org_file;
        }
        else {
            trigger_error("failed to get original file of $file->id", E_USER_WARNING);
            return NULL;
        }
    }

    /**
    * returns the latest version of a file (could be itself)
    */
    public function getLatest()
    {
        if($this->is_latest) {
            return $this;
        }
        $org_file= $this->org_file;

        if($org_file == 0) {
            $org_file= $this->id;
        }

        if(!$project= Project::getVisibleById($this->project)) {
            trigger_error("file $file->id has no project", E_USER_WARNING);
            return NULL;
        }

        $files= File::getAll(array(
            'latest_only' => true,
            'org_file'    => $org_file,
            'project'     => $project->id,
        ));
        if(count($files) > 1) {

            foreach($files as $f) {
                $list[]=$f->id;
            }

            trigger_error("unexpected number (". join(",",$list) .") of latest files for file id $this->id", E_USER_WARNING);
            $files[0];
        }
        return $files[0];
    }


    /**
    * scan post-vars for uploaded files
    * 1. move temp-file to another temporary location until File->insert() moves it into the file folder
    * 2. setup all necessary variables
    * 3. checks for updates
    *
    * You MUST set project to the returned project
    *
    */
    public static function getUploaded()
    {
        global $auth;

        $upload_id= 'userfile';                            # id of upload field

        switch ($_FILES[$upload_id]['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_INI_SIZE:
                trigger_error("The uploaded file exceeds the upload_max_filesize directive (".ini_get("upload_max_filesize").") in php.ini.", E_USER_NOTICE);
                break;
            case UPLOAD_ERR_FORM_SIZE:
                trigger_error("The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.", E_USER_NOTICE);
                break;
            case UPLOAD_ERR_PARTIAL:
                trigger_error("The uploaded file was only partially uploaded.", E_USER_NOTICE);
                break;
            case UPLOAD_ERR_NO_FILE:
                trigger_error("No file was uploaded.", E_USER_NOTICE);
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                trigger_error("Missing a temporary folder.", E_USER_NOTICE);
                break;
            case UPLOAD_ERR_CANT_WRITE:
                trigger_error("Failed to write file to disk", E_USER_NOTICE);
                break;
            default:
                trigger_error("Unknown File Error", E_USER_NOTICE);
        }

        $org_filename=  $_FILES[$upload_id]['name'];
        $filesize=      $_FILES[$upload_id]['size'];

        if(!$filesize || $org_filename == "") {
            #trigger_error("there was nothing to upload", E_USER_NOTICE);
            return NULL;
        }

        $tmp_filename   = preg_replace("/[^a-z0-9-_]/i", '_', $org_filename);

        ### figure mimetype ###
        {
            $mimetype       = $_FILES[$upload_id]['type'];
        }

        ### is an image ? ###

        ### check temporary upload dir ###
        $upload_dir = confGet('DIR_TEMP') . 'uploads';


        if(!file_exists($upload_dir)) {
            if(!mkdir($upload_dir)) {
                trigger_error("could not create temporary file upload directory: '$upload_dir'");
                return NULL;
            }
        }

        if(move_uploaded_file($_FILES[$upload_id]['tmp_name'], $upload_dir."/".$tmp_filename)) {

            $f= new File(array(
                'id'            =>0,
                'name'          => $org_filename,
                'org_filename'  => $org_filename,
                'tmp_filename'  => $tmp_filename,
                'mimetype'      => $mimetype,
                'filesize'      => $filesize,
            ));
            return $f;

        }
        else {
            #print "Possible file upload attack!  Here's some debugging info:\n";
            #print_r($_FILES);
            trigger_error("failure getting uploaded file-object", E_USER_NOTICE);
            return NULL;
        }
    }



    /**
    * insert uploaded files to database is done AFTER moving the
    * file to the appropriate project directory
    *
    * overwrites original insert function of DbProjectItem
    *
    */
    public function insert()
    {
        $upload_filepath= confGet('DIR_TEMP') . 'uploads/' . $this->tmp_filename;
        if(!file_exists($upload_filepath)) {
            trigger_error("Uploaded field no longer exists in $upload_filepath",  E_USER_WARNING);
            return NULL;
        }
        if(!file_exists(confGet('DIR_FILES'))) {
            trigger_error("Directory for files '" . confGet('DIR_FILES') .  "' does not exists",  E_USER_WARNING);
            return NULL;
        }

        ### create project directory ###
        $this->tmp_dir= "prj{$this->project}";
        if(! file_exists(confGet('DIR_FILES') . $this->tmp_dir)) {
            if(  !mkdir(confGet('DIR_FILES') . $this->tmp_dir, 0777)) {
                trigger_error("could not create target directory for uploaded file '" .confGet('DIR_FILES') . $this->tmp_dir. "/'", E_USER_WARNING);
                return NULL;
            }
        }

        /**
        * insert into DB to get the item-id as prefix for temp-name
        *
        * This has to be done before moving the file, because we need the 
        * new item id for the filename.
        */        
        if(! parent::insert() || !$this->id ) {
            trigger_error("inserting file object failed");
            return NULL;
        }
        $this->tmp_filename= $this->id . "_" .$this->tmp_filename;

        ### use original function to write to Db
        parent::update();

        ### move file ###
        if(!rename($upload_filepath, confGet('DIR_FILES') . $this->tmp_dir ."/". $this->tmp_filename)) {
            trigger_error("could not move uploaded file from '$upload_filepath' to '" .confGet('DIR_FILES') . $this->tmp_dir ."/". $this->tmp_filename. "'", E_USER_WARNING);

            ### remove invalid database entry ###
            $this->DeleteFromDb();
            return NULL;
        }

        return true;
    }



    /**
    * send the attached file as download
    */
    public function download()
    {
        $filepath= confGet('DIR_FILES') . $this->tmp_dir . '/'. $this->tmp_filename;

        if(file_exists($filepath)) {
            header('Content-Length: '   . filesize($filepath));
            header('Content-Type: '     . $this->mimetype);
            header("Content-Disposition: attachment; filename=\"$this->org_filename\"");
            header("Cache-Control: public");
            readfile_chunked($filepath);
        }
        else {
            trigger_error("can not find file '$filepath'");
        }
    }

    public function view()
    {
        $filepath= confGet('DIR_FILES') . $this->tmp_dir . '/' . $this->tmp_filename;
        $filesize= filesize($filepath);
        if(file_exists($filepath)) {
            header('Content-Length: '   . $filesize);
            header('Content-Type: '     . $this->mimetype);
            header("Content-Disposition: inline; filename=\"$this->org_filename\"");
            header("Cache-Control: public");
            header('Last-Modified: '    . gmdate("D, j M Y G:i:s T", strToClientTime($this->modified)));
            if( $filesize > 1000000) {
                readfile_chunked($filepath);
            }
            else {
                #ob_clean();
                #flush();
                readfile($filepath);
            }
        }
        else {
            log_message("file::download($this->id) can not find file '$filepath'",LOG_MESSAGE_MISSING_FILES);
        }
    }

    /**
    * return assoc. array with 'height' and 'width'
    *
    * - returns NULL on failure
    */
    public function getImageDimensions($max_size = 0)
    {
        $filepath= confGet('DIR_FILES') . $this->tmp_dir . '/'. $this->tmp_filename;
        if(file_exists($filepath)) {
            list($width, $height, $type, $attr) = getimagesize($filepath);
        }
        else {
            return;
        }

        if ($max_size && ($width > $max_size || $height > $max_size)) {
            $ratio= $width/$height;
            if ($width > $height) {
                $new_width= $max_size;
                $new_height= $max_size / $ratio;
            }
            else {
                $new_height=  $max_size;
                $new_width= $max_size * $ratio;
            }
            $downscale = true;
        }
        else {
            $downscale = false;
            $new_width = $width;
            $new_height = $height;
        }
        return array(
            'new_width' => $new_width, 
            'new_height'=> $new_height, 
            'width'     => $width,
            'height'    => $height,
            'downscale' => $downscale,
            'filepath'  => $filepath
        );
    }


    public function viewAsImage($max_size = 0)
    {
        $max_size = intval($max_size);
        if (!$dimensions= $this->getImageDimensions($max_size)) {
            log_message("file::viewAsImage($this->id) can not find file1 '$filepath'",LOG_MESSAGE_MISSING_FILES);
            return;
        }
        $filepath   = $dimensions['filepath'];
        $new_width  = $dimensions['new_width'];
        $new_height = $dimensions['new_height'];
        $width  = $dimensions['width'];
        $height = $dimensions['height'];
        $filesize= filesize($filepath);
        
        /**
        * just provide the original file
        */
        if (! $dimensions['downscale'] ) {
            header('Content-Length: '   . $filesize);
            header('Content-Type: '     . $this->mimetype);
            header("Content-Disposition: inline; filename=$this->org_filename");
            header("Cache-Control: public");
            header('Last-Modified: '    . gmdate("D, j M Y G:i:s T", strToClientTime($this->modified)));
            if($filesize > 1000000) {
                readfile_chunked($filepath);
            }
            else {
                readfile($filepath);                
            }
            return;
        }

        /**
        * rescale with gd
        */
        if(!function_exists('imagecreatetruecolor')) {
            log_message("file::viewAsImage($this->id) gd not installed",LOG_MESSAGE_MISSING_FILES);
            return; 
        }
        
        ### check if cached file exists
        $md5= md5( http_build_query(array('filepath'=> $filepath,
                        'new_width' => $new_width,
                        'new_height' => $new_height,
                    )));
        $cached_filepath= confGet('DIR_IMAGE_CACHE') . "/" . $md5;

        if( file_exists($cached_filepath )) {
            header('Content-Length: '   . filesize($cached_filepath));
            header('Content-Type: '     . $this->mimetype);
            header("Content-Disposition: inline; filename= $this->org_filename");
            header("Cache-Control: public");
            header('Last-Modified: '    . gmdate("D, j M Y G:i:s T", strToClientTime($this->modified)));
            readfile($cached_filepath);           
            return;
        }
        
        $image_new = NULL;

        ### downscale
        if($this->mimetype == 'image/jpeg'
           ||
           $this->mimetype == 'image/jpg'
           ||
           $this->mimetype == 'image/pjpeg'
        ) {
            header('Content-Type: ' . 'image/jpeg');
            header("Cache-Control: public");
            header("Last-Modified: ". gmdate('r',strToClientTime($this->modified)));

            $image=     imagecreatefromjpeg($filepath);
            $image_new= imagecreatetruecolor($new_width,$new_height)  or die("Cannot Initialize new GD image stream");
            if(imagecopyresampled(
                 $image_new,                    #resource dst_im,
                 $image,                        #resource src_im,
                 0,                             #int dstX,
                 0,                             #int dstY,
                 0,                             #int srcX,
                 0,                             #int srcY,
                 $new_width,      #int dstW,
                 $new_height,     #int dstH,
                 $width,          #int srcW,
                 $height          #int srcH
            )) {
                imagejpeg($image_new);
            }
            else {
                imagejpeg($image);
            }
        }
        else if($this->mimetype == 'image/png' || $this->mimetype == 'image/x-png') {
            header('Content-Type: '     . $this->mimetype);
            header("Cache-Control: public");
            header("Last-Modified: ". gmdate('r',strToClientTime($this->modified)));

            $image=     imagecreatefrompng($filepath);
            $image_new= imagecreatetruecolor($new_width,$new_height)  or die("Cannot Initialize new GD image stream");
            if(imagecopyresampled(
                 $image_new,       #resource dst_im,
                 $image,       #resource src_im,
                 0,       #int dstX,
                 0,       #int dstY,
                 0,       #int srcX,
                 0,       #int srcY,
                 $new_width,      #int dstW,
                 $new_height,     #int dstH,
                 $width,          #int srcW,
                 $height          #int srcH
            )) {
                imagejpeg($image_new);
            }
            else {
                imagejpeg($image);
            }
        }
        else if($this->mimetype == 'image/gif') {
            header('Content-Type: '     . 'image/gif');
            header("Cache-Control: public");
            header("Last-Modified: ". gmdate('r',strToClientTime($this->modified)));
            $image=     imagecreatefromgif($filepath);
            $image_new= imagecreatetruecolor($new_width,$new_height)  or die("Cannot Initialize new GD image stream");
            if(imagecopyresampled(
                 $image_new,                    #resource dst_im,
                 $image,                        #resource src_im,
                 0,                             #int dstX,
                 0,                             #int dstY,
                 0,                             #int srcX,
                 0,                             #int srcY,
                 $new_width,      #int dstW,
                 $new_height,     #int dstH,
                 $width,          #int srcW,
                 $height          #int srcH
            )) {
                imagejpeg($image_new);
            }
            else {
                imagejpeg($image);
            }
        }
        else {
             return NULL;
        }

        ### write cached file
        if($image_new) {
            log_message("writing file $cached_filepath", LOG_MESSAGE_DEBUG);
            imagejpeg( $image_new, $cached_filepath );
            imagedestroy($image_new);
        }
    }
    
    
    /**
    * renders the location of the file as a html string with links to project and parent tasks
    *
    */    
    public function renderLocation($project=NULL, $show_project = true) 
    {
        if(is_null($project)) {
            if(!$project = Project::getVisibleById($this->project)) {
                trigger_error("file without visible project?", E_USER_NOTICE);                
                $show_project = false;
            }
            
        }
        
        $html= __('in');
        if($show_project) {
            $html.=  " <b>" . $project->getLink() . " </b>"; 
        }

        if($this->parent_item) {        
            if($task= Task::getVisibleById($this->parent_item)) {
                if($folders= $task->getFolderLinks()) {
                      $html .= ' &gt; '. $folders;
                }
                $html.=' &gt; '. $task->getLink(false);
            }
        }
        return $html;
    }
    
}
File::initFields();

?>