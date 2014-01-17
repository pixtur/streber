/**
 * js-functionality required for fetching destination folders when moving tasks.
 * Required in task_move.inc.php
 *
 * @author     Thomas Mann
 * @uses:
 * @usedby:
 */


/**
* load html-list for picking destination task
*
* - called directly from home.inc.php -> home() javascript in ahref
*/
function getAjaxListProjectFolders(project_id)
{           
    $.get("index.php",
        { go:'ajaxListProjectFolders', prj:project_id },
        function(data) {
            $('div#folder_list').html(data);
        }
    );
    return;
}

function initMoveTasksUI() 
{
	console.log("init");
	$("#target_prj").change( function(e) {
		console.log(e);
		getAjaxListProjectFolders( e.srcElement.value);
	});
}
