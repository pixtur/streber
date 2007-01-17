<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}

/**
* Edit this file to overwrite streber-settings
*
* use confChange('NAME', 'Value'); 
*
* read http://www.streber-pm.org/3719  or have a look at conf/conf.inc
*/

#confChange('USE_PROFILER',TRUE);
#confChange('DISPLAY_ERROR_LIST', 'DETAILS');
#confChange('LOG_LEVEL', LOG_ALL);
#confChange('CHECK_IP_ADDRESS', false);
#confChange('USE_MOD_REWRITE', true);

### uncomment the following line if you upgraded from mySQL 4
#confChange('DB_USE_UTF8_ENCODING',false);

?>