<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}

# streber - a php based project management system
# Copyright (c) 2005 Thomas Mann - thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in docs/license.txt

/**\file
 * pages to searching
 *
 * @author Thomas Mann
 */

require_once(confGet('DIR_STREBER') . './db/class_project.inc.php');

define('RATE_TYPE_PROJECT', 10);
define('RATE_TYPE_PERSON', 10);
define('RATE_TYPE_COMPANY', 5);
define('RATE_TYPE_TASK', 2);
define('RATE_TYPE_COMMENT', 1);
define('RATE_TYPE_FILE', 1);
define('RATE_TYPE_EFFORT', 1);

define('RATE_LABEL_WIKI',3);
define('RATE_TASK_STATUS_CLOSED', 0.02);
define('RATE_TASK_STATUS_COMPLETED', 0.05);
define('RATE_TASK_IS_FOLDER',5);
define('RATE_PROJECT_IS_OPEN',3);
define('RATE_PROJECT_IS_CLOSED',0.5);
define('RATE_PROJECT_IS_TEMPLATE',0);

define('RATE_MATCHES_NAME',10);
define('RATE_IN_NAME_START',5);
define('RATE_NAME_START',3);
define('RATE_MATCHES_NAME_WORD',3);
define('RATE_IN_DETAILS',2);

define('RATE_DELETED',0.01);
define('RATE_MODIFIED_20_DAYS_AGO',3);
define('RATE_MODIFIED_2_MONTHS_AGO',2);






/**
* Class for handling information about a search result.
*
* The primary purpose is the rating of the relevance
*/
class SearchResult extends BaseObject
{
    public $type;
    public $status;
    public $name;
    public $project;
    public $html_location;
    public $item;
    public $rating;
    public $extract;
    public $is_done;
    public $jump_id;
    public $jump_params;                                    # parameter-list for $PH->show()

    public function __construct($args)
    {
        parent::__construct($args);
    }


    static function cmp($a, $b)
    {
       if ($a->rating == $b->rating) {
           return 0;
       }
       return ($a->rating < $b->rating) ? -1 : 1;
    }


    static function &RateItem($item)
    {
        $rate=1;
        $age= time() - strToGMTime($item->modified);
        if($age < 24*60*60*20) {
            $rate *= RATE_MODIFIED_20_DAYS_AGO;
        }
        else if($age < 62 *60*60*20) {
            $rate *= RATE_MODIFIED_2_MONTHS_AGO;
        }
        if($item->state != 1) {
            $rate *= $rate_deleted;
        }
        if($item->project && $project= Project::getById($item->project)) {
            if($project->status == STATUS_TEMPLATE) {
                $rate *= RATE_PROJECT_IS_TEMPLATE;
            }
            else if($project->status <= STATUS_OPEN) {
                $rate *= RATE_PROJECT_IS_OPEN;
            }
            else if($project->status > STATUS_COMPLETED) {
                $rate *= RATE_PROJECT_IS_CLOSED;
            }
        }
        return $rate;
    }

    static function &GetExtract($item,$search)
    {
        $strings=array();
        foreach(explode(" ",$search) as $s) {
            if($s=trim($s)) {
                $s=str_replace('+','',$s);
                $s=str_replace('*','',$s);
                $strings[]= $s;
            }
        }
        $extract='';

        $s= implode('.*?',$strings);
        if(isset($item->description)) {
            $diz=$item->description;
            if(preg_match("/(.{0,90}$s.{0,120})/i",$diz, $matches)) {
                $extract= $matches[1];
            }
            else if(preg_match("/(.{0,90}".$strings[0].".{0,120})/i",$diz, $matches)) {
                $extract= $matches[1];
            }

        }
        $foo= asHtml($extract);
        return $foo;
    }

    static function &RateTitle($item, $search)
    {
        $rate=1;

        $strings=array();
        foreach(explode(" ",$search) as $s) {
            if($s=trim($s)) {
                $s=str_replace('+','',$s);
                $s=str_replace('*','',$s);
                $strings[]= $s;
            }
        }

        if(isset($item->name)) {
            foreach($strings as $s) {
                if(preg_match("/\A$s\b/i",$item->name)) {
                    $rate*= RATE_MATCHES_NAME;
                }
                else if(preg_match("/\A$s/i",$item->name)) {
                    $rate*= RATE_IN_NAME_START;
                }
                else if(preg_match("/\b$s\b/i",$item->name)) {
                    $rate*= RATE_MATCHES_NAME_WORD;

                }
            }
        }
        if(isset($item->short)) {
            foreach($strings as $s){
                if(preg_match("/\A$s\b/i",$item->short)) {
                    $rate*= RATE_MATCHES_NAME;
                }
                else if(preg_match("/\A$s/i",$item->short)) {
                    $rate*= RATE_IN_NAME_START;
                }
                else if(preg_match("/\b$s\b/i",$item->short)) {
                    $rate*= RATE_MATCHES_NAME_WORD;
                }
            }
        }
        return $rate;
    }



    static function &getForQuery($search_query, $project=NULL)
    {
        $count_overall=0;
        $resuts=array();
        global $PH;


        /**
        * search companies
        */
        {
            require_once(confGet('DIR_STREBER') . "db/class_company.inc.php");

			$args = array('order_str'=>NULL,
						  'has_id'=>NULL,
						  'search'=>$search_query);

            foreach($companies= Company::getAll($args) as $company) {
                $rate= RATE_TYPE_COMPANY;
                $rate*= SearchResult::RateItem($company);
                $rate*= SearchResult::RateTitle($company, $search_query);

                $results[]= new SearchResult(array(
                            'name'  => $company->name,
                            'rating'=> $rate,
                            'type'=> __('Company'),
                            'jump_id'=>'companyView',
                            'jump_params'=> array('company'=>$company->id,'q'=>$search_query),
                            'item' => $company,

                            ));
            }
        }

        /**
        * search persons
        */
        {
            require_once(confGet('DIR_STREBER') . "db/class_person.inc.php");
            foreach($persons= Person::getPersons(array(
                            'search'=>$search_query   #$search=NULL
                            ))
            as $person) {
                $rate= RATE_TYPE_PERSON;
                $rate*= SearchResult::RateItem($person);
                $rate*= SearchResult::RateTitle($person, $search_query);

                $results[]= new SearchResult(array(
                            'name'  => $person->name,
                            'rating'=> $rate,
                            'type'=> __('Person'),
                            'jump_id'=>'personView',
                            'jump_params'=> array('person'=>$person->id,'q'=> $search_query),
                            'item' => $person,

                            ));
            }
        }

        /**
        * search projects
        */
        {
            require_once(confGet('DIR_STREBER') . "db/class_project.inc.php");
            $projects= Project::getAll(array(
                                   'status_min'=>0,   #$status_min=2,
                                   'status_max'=>10,  #$status_max=5,
                                   'search'=>$search_query #$search=NULL

                                   ));
            if($projects)
            {
                foreach($projects as $project) {
                    $rate= RATE_TYPE_PROJECT;
                    if($project->status == STATUS_TEMPLATE) {
                        $rate*= RATE_PROJECT_IS_TEMPLATE;

                    }
                    else if($project->status < STATUS_COMPLETED) {
                        $rate*= RATE_PROJECT_IS_OPEN;
                    }
                    else{
                        $rate*= RATE_PROJECT_IS_CLOSED;
                    }
                    if($diz=SearchResult::getExtract($project,$search_query)) {
                        $rate*= RATE_IN_DETAILS;
                    }

                    ### status ###
                    global $g_status_names;
                    $status= isset($g_status_names[$project->status])
                           ? $g_status_names[$project->status]
                           : '';
                    if($project->status > STATUS_COMPLETED) {
                        $rate*=RATE_TASK_STATUS_CLOSED;
                    }
                    else if($project->status >= STATUS_COMPLETED) {
                        $rate*=RATE_TASK_STATUS_COMPLETED;
                    }

                    ### for company ###
                    $html_location='';
                    if($company = Company::getVisibleById($project->company)) {
                        $html_location=  __('for'). ' ' . $company->getLink();
                    }

                    $rate*= SearchResult::RateItem($project);
                    $rate*= SearchResult::RateTitle($project, $search_query);

                    $results[]= new SearchResult(array(
                                'name'  => $project->name,
                                'rating'=> $rate,
                                'item'=> $project,
                                'type'=> __('Project'),
                                'jump_id'=>'projView',
                                'jump_params'=> array('prj'=>$project->id,'q' => $search_query),
                                'extract' => $diz,
                                'status' => $status,
                                'html_location' => $html_location,

                                ));
                }
            }
        }

        /**
        * search tasks
        */
        {
            require_once(confGet('DIR_STREBER') . "db/class_task.inc.php");
            $order_str=get('sort_'.$PH->cur_page->id."_tasks");
            $tasks= Task::getAll(array(
                                'order_by'=>$order_str,     #$order_by=NULL,
                                'search'=>$search_query,   #$search=NULL
                                'status_min'=>STATUS_UPCOMING,
                                'status_max'=>STATUS_CLOSED,
                                ));

            if($tasks) {
                foreach($tasks as $task) {
                    $rate= RATE_TYPE_TASK;
                    $rate*= SearchResult::RateItem($task);
                    $rate*= SearchResult::RateTitle($task, $search_query);
                    if($task->category == TCATEGORY_FOLDER) {
                        $rate*= RATE_TASK_IS_FOLDER;
                    }

                    if($diz=SearchResult::getExtract($task,$search_query)) {
                        $rate*= RATE_IN_DETAILS;
                    }

                    global $g_status_names;

                    $status= isset($g_status_names[$task->status])
                           ? $g_status_names[$task->status]
                           : '';
                    if($task->status > STATUS_COMPLETED) {
                        $rate*=RATE_TASK_STATUS_CLOSED;
                    }
                    else if($task->status >= STATUS_COMPLETED) {
                        $rate*=RATE_TASK_STATUS_COMPLETED;
                    }



                    if($project= Project::getVisibleById($task->project)) {
                        $prj= $project->getLink();
                    }
                    else {
                        $prj= '';
                    }
                    $html_location= __('in') . " <b>$prj</b> &gt; ". $task->getFolderLinks();

                    $is_done= $task->status < STATUS_COMPLETED
                            ? false
                            : true;

                    $results[]= new SearchResult(array(
                                'name'  => $task->name,
                                'rating'=> $rate,
                                'extract'=> $diz,
                                'item'=> $task,
                                'type'=> $task->getLabel(),
                                'status'=> $status,
                                'html_location' => $html_location,
                                'is_done'=> $is_done,
                                'jump_id'=>'taskView',
                                'jump_params'=> array('tsk'=>$task->id, 'q'=> $search_query),

                                ));

                }
            }
        }


        /**
        * search comments
        */
        {
            require_once(confGet('DIR_STREBER') . "db/class_comment.inc.php");
            $comments= Comment::getAll(array(
                                'search'=>$search_query   #$search=NULL
                                ));

            if($comments) {
                foreach($comments as $comment) {
                    $rate= RATE_TYPE_COMMENT;
                    $rate*= SearchResult::RateItem($comment);
                    $rate*= SearchResult::RateTitle($comment, $search_query);

                    if($diz=SearchResult::getExtract($comment,$search_query)) {
                        $rate*= RATE_IN_DETAILS;
                    }

                    if($project= Project::getVisibleById($comment->project)) {
                        $prj= $project->getLink();
                    }
                    else {
                        $prj= '';
                    }
                    $html_location= __('on') ." <b>$prj</b>";

                    $is_done=false;
                    if($task= Task::getVisibleById($comment->task)) {

                        if($folders=$task->getFolderLinks()) {
                              $html_location .= ' &gt; '. $folders;
                        }
                        $html_location.=' &gt; '. $task->getLink(false);
                        if($task->status >= STATUS_COMPLETED) {
                            $is_done= true;
                        }
                    }
                    else {
                        $html_location='';
                    }


                    $results[]= new SearchResult(array(
                                'name'  => $comment->name,
                                'rating'=> $rate,
                                'extract'=> $diz,
                                'type'=> __('Comment'),
                                'html_location' => $html_location,
                                'jump_id'=>'commentView',
                                'jump_params'=> array('comment'=>$comment->id,'q'=>$search_query),
                                'item' => $comment,
                                'is_done' => $is_done,
                                ));
                }
            }

            $count_overall+= count($comments);
        }


        /**
        * search efforts
        */
        {
            require_once(confGet('DIR_STREBER') . "db/class_effort.inc.php");
            $efforts= Effort::getAll(array(
                                'search'=>$search_query   #$search=NULL
                                ));

            if($efforts) {
                foreach($efforts as $effort) {
                    $rate= RATE_TYPE_EFFORT;
                    $rate*= SearchResult::RateItem($effort);
                    $rate*= SearchResult::RateTitle($effort, $search_query);

                    if($diz=SearchResult::getExtract($effort,$search_query)) {
                        $rate*= RATE_IN_DETAILS;
                    }

                    if($project= Project::getVisibleById($effort->project)) {
                        $prj= $project->getLink();
                    }
                    else {
                        $prj= '';
                    }
                    $html_location= __('on') ." <b>$prj</b>";

                    $is_done=false;
                    if($task= Task::getVisibleById($effort->task)) {

                        if($folders=$task->getFolderLinks()) {
                              $html_location .= ' &gt; '. $folders;
                        }
                        $html_location.=' &gt; '. $task->getLink(false);
                        if($task->status >= STATUS_COMPLETED) {
                            $is_done= true;
                        }
                    }
                    else {
                        $html_location='';
                    }


                    $results[]= new SearchResult(array(
                                'name'  => $effort->name,
                                'rating'=> $rate,
                                'extract'=> $diz,
                                'type'=> __('Effort'),
                                'html_location' => $html_location,
                                'jump_id'=>'effortView',
                                'jump_params'=> array('effort'=>$effort->id,'q'=>$search_query),
                                'item' => $effort,
                                'is_done' => $is_done,
                                ));
                }
            }

            $count_overall+= count($efforts);
        }


        return $results;
    }
}



/**
* Search of a work @ingroup pages
*/
function search()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . "lists/list_searchresults.inc.php");

    /**
    * note: Default search uses boolean mode. This leads to the problem that a lot of search requests
    * fail, because they include stop words.
    */
    $mysql_default_stopwords=array(
        "a"=>1, "able"=>1, "about"=>1, "above"=>1, "according"=>1, "accordingly"=>1, "across"=>1, "actually"=>1, "after"=>1,
        "afterwards"=>1, "again"=>1, "against"=>1, "ain't"=>1, "all"=>1, "allow"=>1, "allows"=>1, "almost"=>1, "alone"=>1, "along"=>1,
        "already"=>1, "also"=>1, "although"=>1, "always"=>1, "am"=>1, "among"=>1, "amongst"=>1, "an"=>1, "and"=>1, "another"=>1,
        "any"=>1, "anybody"=>1, "anyhow"=>1, "anyone"=>1, "anything"=>1, "anyway"=>1, "anyways"=>1, "anywhere"=>1, "apart"=>1,
        "appear"=>1, "appreciate"=>1, "appropriate"=>1, "are"=>1, "aren't"=>1, "around"=>1, "as"=>1, "aside"=>1, "ask"=>1,
        "asking"=>1, "associated"=>1, "at"=>1, "available"=>1, "away"=>1, "awfully"=>1, "be"=>1, "became"=>1, "because"=>1, "become"=>1,
        "becomes"=>1, "becoming"=>1, "been"=>1, "before"=>1, "beforehand"=>1, "behind"=>1, "being"=>1, "believe"=>1, "below"=>1, "beside"=>1,
        "besides"=>1, "best"=>1, "better"=>1, "between"=>1, "beyond"=>1, "both"=>1, "brief"=>1, "but"=>1, "by"=>1, "c'mon"=>1, "c's"=>1,
        "came"=>1, "can"=>1, "can't"=>1, "cannot"=>1, "cant"=>1, "cause"=>1, "causes"=>1, "certain"=>1, "certainly"=>1, "changes"=>1,
        "clearly"=>1, "co"=>1, "com"=>1, "come"=>1, "comes"=>1, "concerning"=>1, "consequently"=>1, "consider"=>1, "considering"=>1,
        "contain"=>1, "containing"=>1, "contains"=>1, "corresponding"=>1, "could"=>1, "couldn't"=>1, "course"=>1, "currently"=>1,
        "definitely"=>1, "described"=>1, "despite"=>1, "did"=>1, "didn't"=>1, "different"=>1, "do"=>1, "does"=>1, "doesn't"=>1, "doing"=>1,
        "don't"=>1, "done"=>1, "down"=>1, "downwards"=>1, "during"=>1, "each"=>1, "edu"=>1, "eg"=>1, "eight"=>1, "either"=>1, "else"=>1,
        "elsewhere"=>1, "enough"=>1, "entirely"=>1, "especially"=>1, "et"=>1, "etc"=>1, "even"=>1, "ever"=>1, "every"=>1, "everybody"=>1,
        "everyone"=>1, "everything"=>1, "everywhere"=>1, "ex"=>1, "exactly"=>1, "example"=>1, "except"=>1, "far"=>1, "few"=>1, "fifth"=>1,
        "first"=>1, "five"=>1, "followed"=>1, "following"=>1, "follows"=>1, "for"=>1, "former"=>1, "formerly"=>1, "forth"=>1, "four"=>1,
        "from"=>1, "further"=>1, "furthermore"=>1, "get"=>1, "gets"=>1, "getting"=>1, "given"=>1, "gives"=>1, "go"=>1, "goes"=>1,
        "going"=>1, "gone"=>1, "got"=>1, "gotten"=>1, "greetings"=>1, "had"=>1, "hadn't"=>1, "happens"=>1, "hardly"=>1, "has"=>1,
        "hasn't"=>1, "have"=>1, "haven't"=>1, "having"=>1, "he"=>1, "he's"=>1, "hello"=>1, "help"=>1, "hence"=>1, "her"=>1, "here"=>1,
        "here's"=>1, "hereafter"=>1, "hereby"=>1, "herein"=>1, "hereupon"=>1, "hers"=>1, "herself"=>1, "hi"=>1, "him"=>1, "himself"=>1,
        "his"=>1, "hither"=>1, "hopefully"=>1, "how"=>1, "howbeit"=>1, "however"=>1, "i'd"=>1, "i'll"=>1, "i'm"=>1, "i've"=>1, "ie"=>1,
        "if"=>1, "ignored"=>1, "immediate"=>1, "in"=>1, "inasmuch"=>1, "inc"=>1, "indeed"=>1, "indicate"=>1, "indicated"=>1,
        "indicates"=>1, "inner"=>1, "insofar"=>1, "instead"=>1, "into"=>1, "inward"=>1, "is"=>1, "isn't"=>1, "it"=>1, "it'd"=>1,
        "it'll"=>1, "it's"=>1, "its"=>1, "itself"=>1, "just"=>1, "keep"=>1, "keeps"=>1, "kept"=>1, "know"=>1, "knows"=>1, "known"=>1,
        "last"=>1, "lately"=>1, "later"=>1, "latter"=>1, "latterly"=>1, "least"=>1, "less"=>1, "lest"=>1, "let"=>1, "let's"=>1, "like"=>1,
        "liked"=>1, "likely"=>1, "little"=>1, "look"=>1, "looking"=>1, "looks"=>1, "ltd"=>1, "mainly"=>1, "many"=>1, "may"=>1, "maybe"=>1,
        "me"=>1, "mean"=>1, "meanwhile"=>1, "merely"=>1, "might"=>1, "more"=>1, "moreover"=>1, "most"=>1, "mostly"=>1, "much"=>1, "must"=>1,
        "my"=>1, "myself"=>1, "name"=>1, "namely"=>1, "nd"=>1, "near"=>1, "nearly"=>1, "necessary"=>1, "need"=>1, "needs"=>1, "neither"=>1,
        "never"=>1, "nevertheless"=>1, "new"=>1, "next"=>1, "nine"=>1, "no"=>1, "nobody"=>1, "non"=>1, "none"=>1, "noone"=>1, "nor"=>1,
        "normally"=>1, "not"=>1, "nothing"=>1, "novel"=>1, "now"=>1, "nowhere"=>1, "obviously"=>1, "of"=>1, "off"=>1, "often"=>1, "oh"=>1,
        "ok"=>1, "okay"=>1, "old"=>1, "on"=>1, "once"=>1, "one"=>1, "ones"=>1, "only"=>1, "onto"=>1, "or"=>1, "other"=>1, "others"=>1,
        "otherwise"=>1, "ought"=>1, "our"=>1, "ours"=>1, "ourselves"=>1, "out"=>1, "outside"=>1, "over"=>1, "overall"=>1, "own"=>1,
        "particular"=>1, "particularly"=>1, "per"=>1, "perhaps"=>1, "placed"=>1, "please"=>1, "plus"=>1, "possible"=>1, "presumably"=>1,
        "probably"=>1, "provides"=>1, "que"=>1, "quite"=>1, "qv"=>1, "rather"=>1, "rd"=>1, "re"=>1, "really"=>1, "reasonably"=>1,
        "regarding"=>1, "regardless"=>1, "regards"=>1, "relatively"=>1, "respectively"=>1, "right"=>1, "said"=>1, "same"=>1, "saw"=>1,
        "say"=>1, "saying"=>1, "says"=>1, "second"=>1, "secondly"=>1, "see"=>1, "seeing"=>1, "seem"=>1, "seemed"=>1, "seeming"=>1,
        "seems"=>1, "seen"=>1, "self"=>1, "selves"=>1, "sensible"=>1, "sent"=>1, "serious"=>1, "seriously"=>1, "seven"=>1, "several"=>1,
        "shall"=>1, "she"=>1, "should"=>1, "shouldn't"=>1, "since"=>1, "six"=>1, "so"=>1, "some"=>1, "somebody"=>1, "somehow"=>1, "someone"=>1,
        "something"=>1, "sometime"=>1, "sometimes"=>1, "somewhat"=>1, "somewhere"=>1, "soon"=>1, "sorry"=>1, "specified"=>1, "specify"=>1,
        "specifying"=>1, "still"=>1, "sub"=>1, "such"=>1, "sup"=>1, "sure"=>1, "t's"=>1, "take"=>1, "taken"=>1, "tell"=>1, "tends"=>1,
        "th"=>1, "than"=>1, "thank"=>1, "thanks"=>1, "thanx"=>1, "that"=>1, "that's"=>1, "thats"=>1, "the"=>1, "their"=>1, "theirs"=>1,
        "them"=>1, "themselves"=>1, "then"=>1, "thence"=>1, "there"=>1, "there's"=>1, "thereafter"=>1, "thereby"=>1, "therefore"=>1,
        "therein"=>1, "theres"=>1, "thereupon"=>1, "these"=>1, "they"=>1, "they'd"=>1, "they'll"=>1, "they're"=>1, "they've"=>1, "think"=>1,
        "third"=>1, "this"=>1, "thorough"=>1, "thoroughly"=>1, "those"=>1, "though"=>1, "three"=>1, "through"=>1, "throughout"=>1,
        "thru"=>1, "thus"=>1, "to"=>1, "together"=>1, "too"=>1, "took"=>1, "toward"=>1, "towards"=>1, "tried"=>1, "tries"=>1, "truly"=>1,
        "try"=>1, "trying"=>1, "twice"=>1, "two"=>1, "un"=>1, "under"=>1, "unfortunately"=>1, "unless"=>1, "unlikely"=>1, "until"=>1,
        "unto"=>1, "up"=>1, "upon"=>1, "us"=>1, "use"=>1, "used"=>1, "useful"=>1, "uses"=>1, "using"=>1, "usually"=>1, "value"=>1,
        "various"=>1, "very"=>1, "via"=>1, "viz"=>1, "vs"=>1, "want"=>1, "wants"=>1, "was"=>1, "wasn't"=>1, "way"=>1, "we"=>1, "we'd"=>1,
        "we'll"=>1, "we're"=>1, "we've"=>1, "welcome"=>1, "well"=>1, "went"=>1, "were"=>1, "weren't"=>1, "what"=>1, "what's"=>1,
        "whatever"=>1, "when"=>1, "whence"=>1, "whenever"=>1, "where"=>1, "where's"=>1, "whereafter"=>1, "whereas"=>1, "whereby"=>1,
        "wherein"=>1, "whereupon"=>1, "wherever"=>1, "whether"=>1, "which"=>1, "while"=>1, "whither"=>1, "who"=>1, "who's"=>1,
        "whoever"=>1, "whole"=>1, "whom"=>1, "whose"=>1, "why"=>1, "will"=>1, "willing"=>1, "wish"=>1, "with"=>1, "within"=>1,
        "without"=>1, "won't"=>1, "wonder"=>1, "would"=>1, "would"=>1, "wouldn't"=>1, "yes"=>1, "yet"=>1, "you"=>1, "you'd"=>1,
        "you'll"=>1, "you're"=>1, "you've"=>1, "your"=>1, "yours"=>1, "yourself"=>1, "yourselves"=>1, "zero"=>1
    );


    $search_query=get('search_query');
    if(!$search_query) {
        $PH->abortWarning("Nothing entered...");
    }

    /**
    * additionally remove slashes and ? because we are gonny using this in a regex
    */
    $search_query= asMatchString($search_query);
    

    ### direct id -jumps
    if($search_query && intval($search_query) == $search_query) {

        $id= intval($search_query);
        require_once(confGet('DIR_STREBER') . "db/class_company.inc.php");

        ### visibile item?
        if($item = DBProjectItem::getVisibleById($id)) {

            switch($item->type) {
                case ITEM_TASK:
                    $PH->show('taskView',array('tsk'=>$id));
                    exit();
                case ITEM_PROJECT:
                    $PH->show('projView', array('prj'=>$id));
                    exit();
                case ITEM_COMPANY:
                    $PH->show('companyView', array('company'=>$id));
                    exit();
                case ITEM_COMMENT:
                    $PH->show('commentView', array('comment'=>$id));
                    exit();
                case ITEM_FILE:
                    $PH->show('fileView', array('file'=>$id));
                    exit();
                case ITEM_COMPANY:
                    $PH->show('companyView', array('company'=>$id));
                    exit();
                default:
                    new FeedbackMessage(__('cannot jump to this item type'));

            }
        }
    }

    $a= array('q'=>$search_query);
    addRequestVars($a);

    $flag_jump= false;
    if(preg_match("/(.*)!$/", $search_query, $matches)) {
        $flag_jump= true;
        $search_query= $matches[1];
    }


    $found_stop_words=array();
    $found_ok_words=array();

    /**
    * adjust query with more than one word...
    * e.g. "admi task" -> "+admi* +task"
    */
    $search_query = preg_replace("/[\[\]<>;$\t \/(),\*+:\"'.=]/","-",$search_query);
    if(count($ar= explode(' ',$search_query)) >1) {
        $search_query='';
        $sep='+';

        foreach($ar as $a) {
            #$a = preg_replace("/[\t (),\*+:\\_\"'.=]/","",$a);
            if(!$a || strlen($a)<3) {
                continue;
            }
            else if(isset($mysql_default_stopwords[$a])) {
                $found_stop_words[]=$a;
            }
            else {
                $search_query.= $sep.$a;
                $sep= "* +";
                $found_ok_words[]=$a;
            }
        }
    }
    else if(isset($mysql_default_stopwords[$search_query])) {
        $found_stop_words[]= $search_query;
    }
    else if($search_query) {
        $found_ok_words[]= $search_query;
    }

    if($found_stop_words) {
        new FeedbackHint(
            sprintf(__("Due to the implementation of MySQL following words cannot be searched and have been ignored: %s"), join($found_stop_words, ', '))
        );

    }
    if(!$found_ok_words) {
        new FeedbackWarning(__("Sorry, but there is nothing left to search."));
        $results= array();
    }
    else {

        if($results= SearchResult::getForQuery($search_query))
        {
            usort($results,  array("SearchResult", "cmp"));
            $results= array_reverse($results);
        }
    }


    if($flag_jump){
        if(count($results) && isset($results[0]->jump_params)) {
            new FeedbackMessage(sprintf(__('jumped to best of %s search results'), count($results)));
            $PH->show($results[0]->jump_id, $results[0]->jump_params);

            exit();
        }
    }
    else {
        if(!$found_stop_words) {
            new FeedbackHint(__('Add an ! to your search request to jump to the best result.'));
        }
    }


    ### set up page ####
    {
        $page= new Page();

        #$page->tabs['search']=  array('target'=>"index.php?go=error",     'title'=>"Error", 'bg'=>"error");
        $PH->defineFromHandle(array('search_query'=>$search_query));

    	$page->cur_tab='search';
    	$page->options[]= new NaviOption(array(
    	    'target_id' => 'search',
    	));

        if(count($results)) {
            $page->title= sprintf(__("%s search results for `%s`"), count($results), $search_query."*");
        }
        else {
            $page->title= sprintf(__("No search results for `%s`"), $search_query."*");
        }
        $page->type=__("Searching");
        echo(new PageHeader);
    }
    echo (new PageContentOpen);



    if(!count($results)) {
        echo "<p>".__("Sorry. Could not find anything.")."</p>";
        echo "<p>".__("Due to limitations of MySQL fulltext search, searching will not work for...<br>- words with 3 or less characters<br>- Lists with less than 3 entries<br>- words containing special charaters")."</p>";
    }
    else {

        $list= new ListBlock_searchresults();
        $list->print_automatic($results);
    }

    echo (new PageContentClose);
	echo (new PageHtmlEnd);
}








?>