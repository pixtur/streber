<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}


/**\file
* Function related to generating rss feeds
*/


require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_changes.inc.php');
require_once(confGet('DIR_STREBER') . 'lib/class_feedcreator.inc.php');
require_once(confGet('DIR_STREBER') . 'std/class_changeline.inc.php');



/**
* StreberPM Project RSS Feed Integration Class
*
* original code by: Dirk Henning
*/
class RSS
{

    /**
    * records history events in rss/rss_$project->id.xml
    *
    * must be called from a project-related page!
    *
    *
    * @param project - current project object used in: proj.inc.php <- function call
    */
    static function updateRSS($project)
    {
        global $PH;
        global $auth;
        
        if(!$project) {
            return NULL;
        }

        /**
        * only show changes by others
        */
        if(Auth::isAnonymousUser()) {
            $not_modified_by = NULL;
        }
        else {
            $not_modified_by= $auth->cur_user->id;
        }

        ### get all the changes (array of history items) ##
        $changes= ChangeLine::getChangeLines(array(
            'project'           => $project->id,
            'unviewed_only'     => false,
            'limit_rowcount'    => 30,
            'not_modified_by'   => $not_modified_by,
            'type'              => array(ITEM_TASK),
        ));
        
        /*
        $changes= DbProjectItem::getAll(array(
            'project'           => $project->id,        # query only this project history
            'alive_only'        => false,               # get deleted entries
            'visible_only'      => false,               # ignore user viewing rights
            'limit_rowcount'    => 20,                  # show only last 20 entries in rss feed
            #'show_assignments'  => false,              # ignore simple assignment events
        ));
        */

        $url= confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');   # url part of the link to the task
        $from_domain = confGet('SELF_DOMAIN');                      # domain url

        if(confGet('USE_MOD_REWRITE')) {
            $url= str_replace('index.php','',$url);
        }

        ### define general rss file settings ###
        $rss = new UniversalFeedCreator();
        $rss->title = "StreberPM: ".$project->name;
        $rss->description = "Latest Project News";
        $rss->link = "$url?go=projView&prj={$project->id}";
        $rss->syndicationURL = $url;


        # go through all retrieved changes and create rss feed

        foreach($changes as $ch) {

            $item = $ch->item;

            $name_author = __('???');            
            if($person = Person::getVisibleById($item->modified_by)) {
                $name_author= $person->name;
            }


            $str_updated= '';
            if($new= $ch->item->isChangedForUser()) {
                if($new == 1) {
                    $str_updated= __('New');
                }
                else {
                    $str_updated= __('Updated');
                }
            }


            ### adding rss item
            {

                $feeditem = new FeedItem();
                $feeditem->title = $item->name  . " (" . $ch->txt_what .' ' . __("by") . ' ' . $name_author . ")";
                $feeditem->link = $url . "?go=itemView&item=$item->id";
                $feeditem->date = gmdate("r", strToGMTime($item->modified));
                $feeditem->source = $url;
                $feeditem->author = $name_author;

                
                switch($ch->type) {
                    case ChangeLine::COMMENTED:
                        $feeditem->description = $ch->html_details;
                        
                        break;
                        
                    case ChangeLine::NEW_TASK:
                        $feeditem->description = str_replace("\n", "<br>", $item->description );
                        break;
                        
                    default:
                        $feeditem->description = $ch->type . " " . str_replace("\n", "<br>", $item->description );
                        break;
                }




                $rss->addItem($feeditem);
            }
        }

        /**
        * all history items processed ...
        * save the rss 2.0 feed to rss/rss_$project->id.xml ...
        * false stands for not showing the resulting feed file -> create in background
        */
        $rss->saveFeed("RSS2.0", "_rss/proj_$project->id.xml", false);
    }
}

?>