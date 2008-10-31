<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file
 * miscellenious functions (sorting, toggling etc.)
 *
 * @author         Thomas Mann
 */


/**
* resolve mapping for clean SEF Urls @ingroup pages
*
* This page is only been requested by .htaccess file if mod_rewrite option is enabled
*/
function globalView()
{
    global $PH;
    global $auth;
    $id=get('id');
    foreach($PH->hash as $phandle) {
        if($phandle->cleanurl === $id) {
            
            if( (! $phandle->valid_for_anonymous) 
                &&
                ( 
                    (!$auth->cur_user) 
                    || 
                    ($auth->cur_user->id == 0) 
                ) 
             ) {
                $PH->show('loginForm');
                return;
            }
            $PH->show($phandle->id);
            return;
        }
    }

    if($id === "submit") {
        if($go= get('go')) {

            /**
            * if submit is directly been called, this might be an page refresh without
            * any real data to submit. To fix recursion, we better jump to 'home'.
            */
            if($go == "globalView") {
                $PH->show('home');
            }
            else {
                $PH->show($go);
            }
            return;
        }
    }

    $PH->abortWarning(sprintf(__("Could not find requested page `%s`"), $id));
}



/**
* Change the sorting of a table @ingroup pages
*/
function changeSort()
{
    global $PH;

    ### get sort-order for table-def ###
    $pageid=get('page_id');
    $tableid=get('table_id');
    $col=get('column');
    $list_style=get('list_style');


    if(isset($pageid) && isset($tableid) && isset($col)) {
        $id="sort_".$pageid."_".$tableid;
        if(isset($list_style) && $list_style != "") {
            $id.= '_'. $list_style;
        }

        ### get sorting from cookie ###
        if($tmp=get($id)) {
            $list_old=split(",",$tmp);


            ### just reverse sort order? ###
            if($list_old[0] == "$col ASC") {
                $list_old[0] ="$col DESC";
            }
            else if($list_old[0] == "$col DESC") {
                $list_old[0] ="$col ASC";
            }
            else {
                $new_sort = "$col ASC";
                $list_new=array();

                foreach($list_old as $c) {

                    ### remove inside list ###
                    if($c == "$col ASC") {
                        $new_sort= "$col DESC";
                    }
                    else if($c == "$col DESC") {
                        $new_sort= "$col ASC";
                    }
                    else {
                        $list_new[]= $c;
                    }
                }
                array_unshift($list_new, $new_sort);
                $list_old= $list_new;
            }
            $str=join(",",$list_old);
        }
        else {
            $str="$col ASC";
        }
        setcookie(
            $id,
            $str,
            time()+60*60*24*30,
            '',
            '',
            0);

        ### keep for current page ###
        $ref= array($id => $str);
        addRequestVars($ref);


    }

    ### set up page ####
    if(!$PH->showFromPage()) {
        $PH->show('home',array());
    }
}


/**
* change current task-list-view (tree, list, grouped, etc.) @ingroup pages
*/
function changeBlockStyle()
{
    global $PH;

    $block_id= get('block_id');
    $page_id=get('page_id');

    $style=get('style');


    if(!$block_id || !$style){
        $PH->abortWarning("ChangeBlockStyle() missed parameters",ERROR_BUG);
    }


    $id="blockstyle_". $page_id ."_". $block_id;

    setcookie(
        $id,
        $style,
        time()+60*60*24*30,
        '',
        '',
        0);

    ### keep for current page ###
    $ref= array($id => $style);
    addRequestVars($ref);

    ### return to from-page ###
    if(!$PH->showFromPage()) {
        $PH->show($page_id);
    }
}

/**
* change current task-list-view (tree, list, grouped, etc.) @ingroup pages
*/
function changeBlockGrouping()
{
    global $PH;

    $block_id= get('block_id');
    $page_id=get('page_id');

    $grouping=get('grouping');


    if(!$block_id || !$grouping){
        $PH->abortWarning("ChangeBlockGrouping() missed parameters",ERROR_BUG);
    }

    $id="blockstyle_". $page_id ."_". $block_id ."_grouping";

    setcookie(
        $id,
        $grouping,
        time()+60*60*24*30,
        '',
        '',
        0);

    ### keep for current page ###
    $ref= array($id => $grouping);
    addRequestVars($ref);


    ### return to from-page ###
    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}


/**
* Restoring (i.e. undelete) items @ingroup pages
*/
function itemsRestore()
{
    global $PH;

    ### get effort ####
    $ids= getPassedIds('item','items_*');

    if(!$ids) {
        $PH->abortWarning(__("Select some items to restore"));
        return;
    }

    $counter=0;
    $errors=0;
    foreach($ids as $id) {
        $i= DbProjectItem::getEditableById($id);
        if(!$i) {
            $PH->abortWarning("Invalid item-id!");
        }
        if($i->state != -1) {
            new FeedbackMessage(sprintf(__('Item %s does not need to be restored'), $i->id));
            $errors++;
            continue;
        }
        $i->state=1;
        if($i->update()) {
            $counter++;
        }
        else {
            $errors++;
        }
    }
    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to restore %s items"), $errors));
    }
    else {
        new FeedbackMessage(sprintf(__("Restored %s items"),$counter));
    }

    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}



/**
* show system information @ingroup pages
*/
function systemInfo()
{
    global $PH;
    require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');


    $system_info = getSysInfo();

    ### set up page ####
    {
        $page= new Page();

        $page->tabs['admin']=  array('target'=>"index.php?go=systemInfo",     'title'=>__('Admin','top navigation tab'), 'bg'=>"misc");
    	$page->cur_tab='admin';
    	$page->crumbs[]=new NaviCrumb(array(
    	    'target_id'=>'systemInfo'
    	));

        $page->title=__("System information");
        $page->type=__("Admin");
        #$page->title_minor=get('go');
        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    $block=new PageBlock(array('title'=>__('Overview'),'id'=>'overview'));
    $block->render_blockStart();


    echo "<div class=text>";
    foreach($system_info as $label=>$value) {
        echo "<div class=labeled><label>$label:</label> <span>$value</span></div>";
    }
    echo "</div>";

    global $auth;
    echo "<br>";
    echo "<h2>Timezone detection</h2>";
    echo "<div class=text>";
    echo "<ul>";
    echo "<li> time-offset for user: " . $auth->cur_user->time_offset ."sec";
    echo "<li> renderDateHtml(): " . (renderDateHtml($auth->cur_user->last_login)) ."";
    echo "<li> original db-string (should be GMT): " . ($auth->cur_user->last_login);

    echo "<li> strToClienttime(): " .  strToClientTime($auth->cur_user->last_login);
    echo "<li> gmdate:(strToClientTime) ". gmdate("H:i:s", strToClientTime($auth->cur_user->last_login));
    echo "<li> strToTime(): " .  strToTime($auth->cur_user->last_login);
    echo "<li> date(strToTime): ". date("H:i:s", strToTime($auth->cur_user->last_login));
    echo "</ul>";
    echo "</div>";

    $block->render_blockEnd();

    echo (new PageContentClose);
	echo (new PageHtmlEnd);

}


/**
* assemble system information in assoc array @ingroup pages
*/
function getSysInfo() {
    global $PH;
    $a=array();

    $PH->defineFromHandle(array());


    ### database ###
    #{
    #    $databaseTypeMore = 'MySql';
    #    $MY_DBH = openDatabase();
    #    $local_query = 'SELECT VERSION() as version';
    #    $res = mysql_query($local_query, $MY_DBH);
    #    $databaseVersion = mysql_result($res, 0, 'version');
    #}
    #$a[__('Database Type')]= $databaseTypeMore;

    $filepath='_tmp/errors.log.php';
    if(file_exists($filepath)) {
        $fsize= '('. filesize($filepath). ' bytes)';
    }
    else {
        $fsize='';
    }

    ### php version ###
    $a[__('Error-Log')]=   $PH->getLink('showLog','Filter') .'|'. $PH->getLink('deleteLog','Delete') .' '. $fsize;

    $a[__('PHP Version')]= phpversion() ." (". $PH->getLink('showPhpInfo').")";

    ### php extensions ###
    $a[__('extension directory')]= ini_get('extension_dir');

    $a[__('loaded extensions')]= join(", ",get_loaded_extensions());

    $a[__('include path')] =  ini_get('include_path');

    $a[__('register globals')]= ini_get('register_globals') ? "On":"Off";

    $a[__('magic quotes gpc')]= ini_get('magic_quotes_gpc') ? "On":"Off";

    $a[__('magic quotes runtime')]= ini_get('magic_quotes_runtime') ? "On":"Off";

    $a[__('safe mode')]= ini_get('save_mode') ? "On":"Off";

    $a['mail()']= function_exists('mail') ? "Available":"-";

    $a['SMTP']= ini_get('SMTP');
    $a['upload max filesize']= ini_get('upload_max_filesize');
    $a['http host']= $_SERVER['HTTP_HOST'];

    if(isset($_SERVER['PATH_TRANSLATED'])) {
        $a['path translated']= $_SERVER['PATH_TRANSLATED'];
    }

    $a['server name']= $_SERVER['SERVER_NAME'];
    $a['server port']= $_SERVER['SERVER_PORT'];
    $a['server software']= $_SERVER['SERVER_SOFTWARE'];
    $a['server os']= PHP_OS;
    $a['current locale']= setlocale(LC_TIME, '0');

    return $a;

}


/**
* Render page info @ingroup pages
*
* Because this function is a potential security risk, it is only available for admins
*/
function showPhpInfo()
{
    phpInfo();
}

/**
* Send notification mails to all users @ingroup pages
*
* This page is normally requested by Cron jobs. Read more at http://www.streber-pm.org/2211
*/
function triggerSendNotifications()
{
    require_once(confGet('DIR_STREBER') . 'std/mail.inc.php');
    log_message('triggerSendNotifications()');
    $n= new Notifier();
    $n->sendNotifications();

    global $PH;
    
    $number = count($PH->messages);
    if($number == 1) {
        echo __("One notification sent");
    }
    elseif($number > 1) {
        echo sprintf(__("%s notifications sent"), $count);
    }
    else {
        echo __("No notifications sent");
    }
}


/**
* Show error log @ingroup pages
*/
function showLog()
{
    global $PH;
    echo "<pre>";
    // get contents of a file into a string
    $filename = "_tmp/errors.log.php";
    $handle = fopen($filename, "r");
    $last_error_time= NULL;
    $hide_errors=get('hide_errors');
    $hide_error_hash=array();
    foreach(explode(',', $hide_errors) as $error) {
        if($error) {
            $hide_error_hash[$error]=true;
        }
    }
    if($hide_error_hash) {
        echo "hidden:<br>";
        foreach($hide_error_hash as $key=>$value) {
            $list='';
            foreach($hide_error_hash as $key2=>$value2) {
                if($key2 != $key) {
                    $list.=",".$key2;
                }
            }
            echo "$key (".
            $PH->getLink('showLog','show', array('hide_errors'=> $list));
            echo ")<br>";
        }
    }


        echo $PH->getLink('systemInfo','back to sysInfo') . " | ";
        echo $PH->getLink('showLog','log', array('showlog'=>1)) . " | ";
        echo $PH->getLink('showLog','errors', array()) . " | ";
        echo $PH->getLink('showLog','newbots', array('newbots'=>1)) . " | ";
        echo "<hr>";



    while (!feof($handle)) {
        $line = fgets($handle);
        #echo $line."<br><br>";


        if(preg_match("/(\w+) (\d+)\s*(.*)/", $line, $matches)) {
            $cat= $matches[1];
            $time= $matches[2];
            $rest= $matches[3];

            if(get('newbots')) {
                if(preg_match("/\Sbot/", $rest, $matches)) {
                    if(!preg_match("/ crawler/", $rest)) {
                        echo $line ."<br>";
                    }
                }
            }

            else if(get('time')) {
                if($time && $time==get('time')) {
                    echo asHtml($line);
                }
            }
            else if($cat =='Error') {

                if(preg_match("/(\w+):\s*([^\:\s]+)\s*:\s*(\d+)(.*)/", $rest, $matches)) {

                    $type= $matches[1];
                    $file= trim($matches[2]);
                    $line= $matches[3];
                    $rest= $matches[4];
                    if(!isset($hide_error_hash[$file.':'.$line])) {
                        if($time != $last_error_time) {
                            echo $PH->getLink('showLog', $time, array('time'=> $time));
                            echo " $type: <b>$file:$line</b> -  $rest (";
                            echo $PH->getLink('showLog',__('hide'), array('hide_errors'=> $hide_errors.','.$file.':'.$line));
                            echo ")<br>";
                            $last_error_time= $time;
                        }
                    }
                }
            }
            else if(get('showlog')) {
                echo "$line";
            }
        }
    }
    fclose($handle);
}

/**
* Delete error log file @ingroup pages
*/
function deleteLog()
{
    global $PH;
    $filepath= '_tmp/errors.log.php';
    if(file_exists($filepath)) {
        if(unlink($filepath)) {
            if($FO = fopen(dirname(__FILE__)."/../_tmp/errors.log.php", "w")) {
                fputs($FO,'<? header("Location: ../index.php");exit(); ?>');
            }
            new FeedbackMessage('errors.log.php deleted');
        }
        else {
            new FeedbackWarning('Deleting errors.log.php failed');
        }
    }
    else {
        new FeedbackMessage('errors.log.php empty');
    }


    if(!$PH->showFromPage()) {
        $PH->show('home');
    }
}



/**
* generates an image with a number that is computed as: @ingroup pages
*
*  substr(md5( $key . $auth->cur_user->identifier ), 0, 5)
*
* With captcha tests, the key is been sent in a CRC-protected hidden field.
*/
function imageRenderCaptcha()
{
    global $auth;

    if($key = get('key')) {
        $md5= md5( $key . $auth->cur_user->identifier );
    }
    else {
        $md5= "---";
    }

    $ResultStr = substr($md5,0,5);//trim 5 digit
    $BgImage =imagecreatefrompng(getThemeFile("img/bg_captcha.png"));//image create by existing image and as back ground

    list($width, $height, $type, $attr) = getimagesize(getThemeFile("img/bg_captcha.png"));

    $TextColor = imagecolorallocate($BgImage, 247, 250, 249);//text color-white

    imagestring($BgImage, 3, 50, 9, $ResultStr, $TextColor);

    $NewImage= imagecreatetruecolor($width * 0.5, $height * 0.5);

    #imagecopyresampled($NewImage, $BgImage, 0, 0, 0, 0, $width * 0.5, $height * 0.5, $width, $height);

    #imageantialias($NewImage, true );


    $_SESSION['key'] = $ResultStr;// carry the data through session

    header("Content-type: image/jpeg");// out out the image
    imagejpeg($BgImage);//Output image to browser

}

?>
