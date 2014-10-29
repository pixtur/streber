<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}

/**
* Edit this file to overwrite streber-settings
*
* use confChange('NAME', 'Value'); 
*
* read http://www.streber-pm.org/3719  or have a look at conf/conf.inc
*/

confChange('LOG_LEVEL', LOG_MESSAGE_ALL);
confChange('DISPLAY_ERROR_LIST', 'DETAILS');
confChange('USE_MOD_REWRITE', true);
confChange('STOP_IF_INSTALL_DIRECTORY_EXISTS', false);
confChange('HIDE_OTHER_PEOPLES_DETAILS', true);

confChange('ACTIVATION_MAIL_HTML_BODY', $str = <<<EOD
<p><b>Welcome to the tooll.io beta-test.</b></p>
<p>Please follow these steps:</p>
<ol>
<li><a href="%s">Click this link</a> to activate your account and set a password.</li>
<li>Visit <a href="http://tooll.framefield.com">tooll.framefield.com</a> to download the latest version, to get help, and to give us feedback (which is most appreciated).</li>
<li>After installation, start Tooll and have a look at the examples or watch the tutorial-videos.</li>
</ol>
<br>
thanks for your time,<br>
tom
EOD
);

confChange('ACTIVATION_MAIL_PLAIN_BODY', $str = <<<EOD
Welcome to the tooll.io beta-test program.  Please follow these steps:

1. Click the link below to confirm your account and set a password:
   %s

2. At http://tooll.framefield.com you can always download the latest versions, 
   get help, and give us feedback (which is most appreciated).

3. After installation, start Tooll and have a look at the examples 
   or watch the tutorial-videos.

thanks for your time,
tom
EOD
);



confChange('MESSAGE_OFFLINE',"<h1>What a Bummer!</h1>The wiki is offline right now. <br><br>Please come back a minute, or so.");
confChange('EMAIL_ADMINISTRATOR', 'tooll.io@framefield.com');
confChange('NOTIFICATION_EMAIL_SENDER', 'tooll.io <tooll.io@framefield.com>');
confChange('NOTIFICATION_EMAIL_SUBJECT', "tooll.io beta – Updates");
confChange('WELCOME_EMAIL_SUBJECT', "Welcome to the tooll.io beta");

function postInitCustomize() 
{
	global $PH;
	$PH->hash['projView']->req= 'pages/custom_projView.inc.php';
	$PH->hash['projViewFiles']->req= 'pages/custom_projViewFiles.inc.php';

	require_once(confGet('DIR_STREBER') . './std/class_email_notification.inc.php');
}

confChange('TASKDETAILS_IN_SIDEBOARD', true);
?>