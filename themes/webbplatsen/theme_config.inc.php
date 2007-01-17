<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}

/**
* list row color-settings (depend on javascript)
* 
* set some odd/even-colors for 	 "table.list tr.odd" to avoid flickering
*/

/***
confChange('LIST_COLOR_SELECTED', '#ffde00');
confChange('LIST_COLOR_ODD', '#ffffff');
confChange('LIST_COLOR_EVEN', '#f8f8f8');
confChange('LIST_COLOR_HOVER', '#DDF0F0');
***/
confChange('LIST_COLOR_SELECTED', '#e2e2e2');
confChange('LIST_COLOR_ODD', '#eeeeee');
confChange('LIST_COLOR_EVEN', '#eeeeee');
confChange('LIST_COLOR_HOVER', '#e2e2e2');


?>