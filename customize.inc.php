<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}

/**
* Edit this file to overwrite streber-settings
*
* use confChange('NAME', 'Value'); 
*
* read http://www.streber-pm.org/3719  or have a look at conf/conf.inc
*/

#confChange('USE_PROFILER',TRUE);
confChange('DISPLAY_ERROR_LIST', 'DETAILS');
confChange('LOG_LEVEL', LOG_MESSAGE_ALL);
#confChange('CHECK_IP_ADDRESS', false);
#confChange('USE_MOD_REWRITE', true);

### uncomment the following line if you upgraded from mySQL 4
#confChange('DB_USE_UTF8_ENCODING',false);

confChange('ANONYMOUS_USER', 2203);
confChange('SQL_MODE', "STRICT_ALL_TABLES,STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION");
#confChange('SQL_MODE', "STRICT_ALL_TABLES");

confChange('EMAIL_ADMINISTRATOR','thomas@pixtur.de');

confChange('REGISTER_NEW_USERS', true);
confChange('REGISTER_NEW_USERS_TO_PROJECT', 1908);

#function postInitCustomize() 
#{
#    global $PH;
#    $PH->hash['projView']->req= 'pages/custom_projView.inc.php';
#    $PH->hash['projViewFiles']->req= 'pages/custom_projViewFiles.inc.php';
#}

?>