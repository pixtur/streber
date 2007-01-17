<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}

require_once(confGet('DIR_STREBER') . "db/class_task.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_project.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list.inc.php");


#---------------------------------------------------------------------------
# quicknew
#---------------------------------------------------------------------------
function quickNew(){
    global $PH;

    $type=get('type');

    switch($type) {
    case 'task':
        $PH->show('taskNew');
        break;
    case 'effort':
        $PH->show('effortNew');
        break;
    case 'comment':
        $PH->show('commentNew');
        break;
    default:
        $PH->abortWarning("unknown type for quicknew $type");
        break;
    }
}



?>