<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}


/** 
*	
*/


require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_person.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_projectchanges.inc.php');
require_once(confGet('DIR_STREBER') . 'lib/class_feedcreator.inc.php');


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
	static function updateRSS(&$project) 
	{
	    if(!$project) {
	        return NULL;
	    }

		$list= new ListBlock_projectchanges();
    	$list->query_options['project']= $project->id;				# query only this project history
        $list->query_options['alive_only']=false;					# get deleted entries
        $list->query_options['visible_only']=false;					# ignore user viewing rights
        $list->query_options['limit']=20;							# show only last 20 entries in rss feed
        $list->query_options['show_assignments']=false;				# ignore simple assignment events

		$pass= true;												# setting for list view
        $changes= Project::getChanges($list->query_options);		# get all the changes (array of history items)

        $url= confGet('SELF_PROTOCOL').'://'.confGet('SELF_URL');	# url part of the link to the task
    	$from_domain = confGet('SELF_DOMAIN');						# domain url

		
        # define general rss file settings
        $rss = new UniversalFeedCreator();
		#$rss->useCached();
		$rss->title = "StreberPM: ".$project->name;
		$rss->description = "Latest Project News";
		$rss->link = "$url?go=projView&prj={$project->id}";
		$rss->syndicationURL = $url;
        
        
        # go through all retrieved changes and create rss feed
        
        foreach($changes as $ch) {
        
	        ### analyze history entries:
	        {

	        	### person name
	            $date_created=$ch->created;
		        $date_modified=$ch->modified;
		        $date_deleted=$ch->deleted;
		
		        $prs=NULL;
				$person=NULL;
		        $str="";
		        if($date_deleted >= $date_modified) {
		            $prs= Person::getById($ch->deleted_by);
		        }
		        else if($date_modified > $date_created) {
		            $prs= Person::getById($ch->modified_by);
		        }
		        else {
		            $prs= Person::getById($ch->created_by);
		        }
				$person_name = $prs->name;

		        
	        	### action
	        	$date_created=$ch->created;
        		$date_modified=$ch->modified;
        		$date_deleted=$ch->deleted;
        		$action="";
        		if($date_deleted >= $date_modified) {
            		$action= "Deleted";
        		}
        		else if($date_modified > $date_created) {
            		$action= "Modified";
        		}
       			else {
            		$action= "New";
        		}	        
	        	
        		
        		### type of item
				$item_names =array(
				    ITEM_PROJECT    	=> 'Project',
				    ITEM_TASK       	=>'Task',
				    ITEM_PERSON     	=>'Person',
				    ITEM_PROJECTPERSON	=>'Team Member',
				    ITEM_COMPANY    	=>'Company',
				    ITEM_EMPLOYMENT 	=>'Employment',
				    ITEM_ISSUE      	=>'Issue',
				    ITEM_EFFORT     	=>'Effort',
				    ITEM_TASK_EFFORT	=>'Effort',
				    ITEM_COMMENT    	=>'Comment',
				    ITEM_FILE       	=>'File',
				    ITEM_TASKPERSON 	=>'Task assignment'
				);
        		if(!$typename= $item_names[$ch->type]) {
            		$typename="?";
        		}
        		
        		
        		### item name - consists of 
				#		str_url (direct link),
				#		str_name (name as string)
				#		str_addon (extra link description)
        		global $PH;
		        $str_url="";
				$str_name="";
		        $str_addon="";
		        switch($ch->type) {
		            case ITEM_TASK:
		                if($task= Task::getById($ch->id)) {
							$str_name= $task->name;
		                    $str_url= "$url?go=taskView&tsk={$task->id}";
		                }
		                break;
		
		            case ITEM_COMMENT:
		                require_once("db/class_comment.inc.php");
		                if($comment= Comment::getById($ch->id)) {
							$str_name= $comment->name;
		                    if($comment->comment) {
		                        $str_url= "$url?go=taskView&tsk={$comment->task}";
		                        $str_addon="(on comment)";
		                    }
		
		                    else if($comment->task) {
		                        $str_url= "$url?go=taskView&tsk={$comment->task}";
		                        $str_addon="(on task)";
		
		                    }
		
		                    else {
		                        $str_url= "$url?go=projView&prj={$comment->project}";
		                        $str_addon="(on project)";
		                    }
		                }
		                break;
		
		            case ITEM_PROJECTPERSON:
		                if($pp= Person::getById(ProjectPerson::getById($ch->id)->person)) {
							$str_name= $pp->name;
		                    $str_url= "$url?go=personView&person={$pp->id}";
		                }
		                break;
		
		            case ITEM_EFFORT:
		                require_once("db/class_effort.inc.php");
		                if($e= Effort::getById($ch->id)) {
		                    $str_name= $e->name;
		                    $str_url= "$url?go=effortEdit&effort={$e->id}";			
		                }
		                break;
		            case ITEM_FILE:
		                require_once("db/class_file.inc.php");
		                if($f= File::getById($ch->id)) {
		                    $str_name= $f->org_filename;
		                    $str_url= "$url?go=fileView&file={$f->id}";
		                }
		            default:
		                break;
	        	}
        		
        		
        		### modified at which time
        		$modified = strtotime($ch->modified);
        	}
        		

			### adding rss item
			{
		
			    $item = new FeedItem();
			    $item->title = $str_name;
			    $item->link = $str_url;
			    $item->description = $person_name." - ".$action." ".$typename.": ".$str_name;
			    $item->date = $modified;
			    $item->source = $url;
			    $item->author = "StreberPM";
			    
			    $rss->addItem($item);
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