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
#confChange('CHECK_IP_ADDRESS', false);
#confChange('LINK_STAR_LIGHT', true);		# syntaxhighlighting for Gheckobased browsers
confChange('SQL_MODE', 'STRICT_ALL_TABLES');
confChange('TASKDETAILS_IN_SIDEBOARD', true);
confChange('USE_FIREPHP', true);
confChange("STOP_IF_INSTALL_DIRECTORY_EXISTS", false)
### uncomment the following line if you upgraded from mySQL 4
#confChange('DB_USE_UTF8_ENCODING',true);

#confChange('EMAIL_ADMINISTRATOR','mail.somedomain.de');
#confChange('SMTP','mail.yourdomain.de');

?>