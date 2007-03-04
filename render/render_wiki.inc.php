<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * classes relating to formating wiki into html
 *
 * called from: -
 * the idea of this parser is splitting the tags until all text-tags are atoms or other tags
 *
 *
 * @author Thomas Mann
 * @uses:
 * @usedby:
 *
 */


global $g_replace_list;
$g_replace_list=array();

global $g_wiki_auto_adjusted;
$g_wiki_auto_adjusted= '';


class FormatBlock
{
    public $str="";
    public function __construct($str)
    {
        $this->str=$str;
    }

    public function renderAsHtml()
    {
        return $this->str;
    }
}

class FormatBlockCode extends FormatBlock
{

    public $from="";
    public $url="";
    public $code="";
    public $language= "php";


    public function __construct($str,$options)
    {
        $this->str_code= $str;      # prevent from further processing
        #$this->quote=$str;
        if($options) {

            if(preg_match("/url=\s*&quot;([^\"]*)&quot;/",$options,$matches)) {
                $this->url= $matches[1];
            }

            if(preg_match("/from=\s*&quot;([^\"]*?)&quot;/",$options,$matches)) {
                $this->from= $matches[1];
            }
            if(preg_match("/language=\s*&quot;([^\"]*?)&quot;/",$options,$matches)) {
                $this->language= $matches[1];
            }
        }
    }


    public function renderAsHtml() {
        $buffer= '';

        ### skip empty code blocks ###
        if(preg_match("/^\s*$/",$this->str_code,$matches)) {
            return "<br>";
        }

        ### add from block ###
        else if($this->from) {
            $buffer.= "<p class=code_from>from <span>$this->from</span></p>";
        }
        return $buffer. "<pre class='$this->language'>" . $this->str_code."</pre>";
    }

    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();
        $found = false;
        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                while($text) {
                    #quote(\s*[^\]]*)\](.*?)\[\/quote\
                    if(preg_match("/^(.*?)\[code(\s*[^\]]*)\](.*?)\[\/code\]\r?\n?(.*)$/s", $text, $matches)) {
                    #if(preg_match("/^(.*?)\[code\](.*?)\[\/code\]\r?\n?(.*)$/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockCode($matches[3],$matches[2]);
                        $text= $matches[4];
                        $found = true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]= $b;
            }
        }
        return $blocks_new;
    }
}



class FormatBlockCodeIndented extends FormatBlockCode
{

    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();
        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/\A(.*?)\r?\n[ \t]*\r?\n((?:[ \t]+[^\n]*\n)+)\r?\n?(.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]."\n");
                        $blocks_new[]= new FormatBlockCode($matches[2],'');
                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]=$b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;
    }
}


class FormatBlockBold extends FormatBlock
{
    public function renderAsHtml()
    {
        return "<b>".$this->str."</b>";
    }

    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();

        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/^(.*?)\*([^\*\s][^\*\+\/]*[^\*\s])\*(.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockBold($matches[2]);
                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }

            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;
    }
}




class FormatBlockStrike extends FormatBlock
{
    public function renderAsHtml()
    {
        return "<strike>".$this->str."</strike>";
    }

    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();

        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/^(.*?)~~([^\*\s][^\*\+\/]+[^~\s])~~(.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockStrike($matches[2]);
                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }

            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;
    }
}



class FormatBlockHref extends FormatBlock
{

    private $type;
    private $url;

    public function __construct($type, $url)
    {
        $this->type=$type;
        $this->url= $url;
        $this->str='';      # prevent from further processing
    }


    public function renderAsHtml()
    {
        return "<a href='{$this->type}{$this->url}'>$this->url</a>";
    }


    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();

        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/\A(.*?)\b(http:\/\/|https:\/\/|mailto:|ftp:|ssh:)([^\s\"\'\)]+)(.*)/s",$text, $matches)){
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockHref($matches[2],$matches[3]);
                        $text= $matches[4];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;

    }
}



class FormatBlockQuote extends FormatBlock
{
    public $from="";
    public $url="";

    public function __construct($str,$options)
    {


        $this->str='';      # prevent from further processing
        #$this->quote=$str;
        if($options) {

            if(preg_match("/url=\s*&quot;([^\"]*)&quot;/",$options,$matches)) {
                $this->url= $matches[1];
            }

            if(preg_match("/from=\s*&quot;([^\"]*?)&quot;/",$options,$matches)) {
                $this->from= $matches[1];
            }
        }

        $blocks= array(new FormatBlock($str));

        $blocks= FormatBlockHref::parseBlocks($blocks);

        $blocks= FormatBlockBold::parseBlocks($blocks);
        $blocks= FormatBlockStrike::parseBlocks($blocks);
        $blocks= FormatBlockSub::parseBlocks($blocks);

        $blocks= FormatBlockLinebreak::parseBlocks($blocks);


        $blocks= FormatBlockLink::parseBlocks($blocks);
        $blocks= FormatBlockMonospaced::parseBlocks($blocks);
        $blocks= FormatBlockEmphasize::parseBlocks($blocks);
        $blocks= FormatBlockLongMinus::parseBlocks($blocks);
        $blocks= FormatBlockItemId::parseBlocks($blocks);


        $this->children= FormatBlockLink::parseBlocks($blocks);

    }

    public function renderAsHtml()
    {
        $buffer='';
        $buffer_from='';

        if($this->from) {
            if($this->url) {
                $buffer_from="<p class=quoted_from>" .__("from").  " <a href='$this->url'>$this->from</a></p>";
            }
            else {
                $buffer_from="<p class=quoted_from>". __("from"). " ". $this->from."</p>";

            }
        }
        $buffer= "<p class=quote>".asHtml($this->str);

        foreach($this->children as $b) {
            $buffer.= $b->renderAsHtml();
        }

        $buffer.= $buffer_from. "</p>";
        return $buffer;

    }

    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();

        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/^(.*?)\[quote(\s*[^\]]*)\](.*?)\[\/quote\](.*)$/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockQuote($matches[3], $matches[2]);
                        $text= $matches[4];
                        $found= true;
                    }
                    else if($found){
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }

            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;

    }
}



class FormatBlockEmphasize extends FormatBlock
{
    public function renderAsHtml()
    {
        return "<em>".$this->str."</em>";
    }

    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();

        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/^(.*?)&#039;&#039;(.*?)&#039;&#039;(.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockEmphasize($matches[2]);
                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found){
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }

            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;

    }
}


class FormatBlockMonospaced extends FormatBlock
{
    public function renderAsHtml()
    {
        return "<code>".$this->str."</code>";
    }

    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();

        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/^(.*?)\`([^\`\s][^\`]*[^\`\s])\`(.*)/s", $text, $matches)) {
                    #if(preg_match("/^(.*?)\'(.*?)\'(.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockMonospaced($matches[2]);
                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found){
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }

            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;

    }
}





class FormatBlockSub extends FormatBlock
{
    public function renderAsHtml()
    {
        return "<sub>".$this->str."</sub>";
    }

    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();

        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/^(.*?)\[sub\](.*?)\[\/sub\](.*)$/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockSub($matches[2]);
                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found){
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;
    }
}








class FormatBlockHeadline extends FormatBlock
{
    public $level;
    public $children= array();

    public function __construct($str, $level)
    {

        $blocks= array(new FormatBlock($str));

        $blocks= FormatBlockBold::parseBlocks($blocks);
        $blocks= FormatBlockStrike::parseBlocks($blocks);

        $blocks= FormatBlockSub::parseBlocks($blocks);



        $blocks= FormatBlockMonospaced::parseBlocks($blocks);
        $blocks= FormatBlockEmphasize::parseBlocks($blocks);

        $blocks= FormatBlockHref::parseBlocks($blocks);
        $blocks= FormatBlockItemId::parseBlocks($blocks);

        $this->children= FormatBlockLink::parseBlocks($blocks);

        #$tmp= array(new FormatBlock($str));
        #$this->children= FormatBlockStrike::parseBlocks($tmp);

        $this->str= '';
        $this->level=$level+1;

    }

    public function renderAsHtml()
    {
        $buffer="<h$this->level>";
        foreach($this->children as $b) {
            $buffer.= $b->renderAsHtml();
        }
        $buffer.= "</h$this->level>";
        return $buffer;
    }


    /**
    * the following code is not really brilliant. Too lazy to optimize
    */
    static function parseBlocks(&$blocks)
    {

        $blocks_new= array();
        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/(.*?)\r?==[ \t]*([^\n=]+)==\s*\r?\n[ \t]*(.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockHeadline($matches[2],1);
                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else{
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        $blocks= $blocks_new;
        $blocks_new= array();

        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {
                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/(.*?)\r?===[ \t]*([^\n=]+)===\s*\n[ \t]*(.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockHeadline($matches[2],2);
                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else{
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        $blocks= $blocks_new;
        $blocks_new= array();


        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/^(.*?)([^\r\n]+)[\r\n]+===+[ \t]*[\r\n]+(.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);

                        $blocks_new[]= new FormatBlockHeadline($matches[2],1);
                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else{
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        $blocks= $blocks_new;
        $blocks_new= array();

        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    #if(preg_match("/^(.*?)\n?([^\n]+)\n===+\s*(\n.*)/s", $text, $matches)) {
                    if(preg_match("/(.*?)([^\n\r]+)\r?\n---+[\t]*[\r\n]+(.*)/s", $text, $matches)) {
                    #if(preg_match("/(.*?)([^\n\r]+)[\r\n]+---+[ \t]*[\r\n]+(.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockHeadline($matches[2],2);
                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else{
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;
    }
}


class FormatBlockLinebreak extends FormatBlock
{
    public $level;
    public $children= array();


    public function __construct()
    {
    }

    public function renderAsHtml()
    {
        return '<br>';
    }


    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();
        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {


                    if(preg_match("/^([^\n\r]*?)\r?\n(.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockLinebreak();
                        $text= $matches[2];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;
    }
}


class FormatBlockHr extends FormatBlock
{
    public $level;
    public $children= array();


    public function __construct()
    {
    }

    public function renderAsHtml()
    {
        return '<hr>';
    }


    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();
        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/^\s*____*\s*(.*)/s", $text, $matches)) {

                        $blocks_new[]= new FormatBlockHr();
                        $text= $matches[1];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;
    }
}



class FormatBlockLongMinus extends FormatBlock
{
    public $level;
    public $children= array();


    public function __construct()
    {
    }

    public function renderAsHtml()
    {
        return " \xe2\x80\x94 ";
    }


    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();
        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {


                    if(preg_match("/(.*?) -- (.*)/s", $text, $matches)) {

                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockLongMinus();
                        $text= $matches[2];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;
    }
}






class FormatBlockLink extends FormatBlock
{

    public $level;
    public $children= array();
    public $name;
    public $target;
    public $options;
    private $html;  # use custom html-code instead of link


    public function __construct($str)
    {
        global $PH;
        global $g_wiki_project;

        $this->str='';      # prevent from further processing


        ### id|options|title ###
        if(preg_match("/\A([^\|]+)\|([^|]+)\|([^|]*)$/", $str, $matches)) {
            $this->target= asCleanString($matches[1]);
            $this->options= split(",", preg_replace("/[^a-z,=0-9]/", "", strtolower($matches[2])));
            $this->name=$matches[3];

        }
        ### id|title ###
        else if(preg_match("/\A([^\|]+)\|([^|]+)$/", $str, $matches)) {
            $this->target=asCleanString($matches[1]);
            $this->name  =$matches[2];

        }
        else {
            $this->name  ='';
            $this->target=$str;
        }

        if(preg_match("/\A([\w]+)\:(\d+)/",$this->target, $matches)) {

            $type       = asKey($matches[1]);

            $target     = $matches[2];
            $target     = asCleanString($matches[2]);

            switch($type) {

                /**
                * embedding images...
                */
                case 'image':

                    require_once(confGet('DIR_STREBER') . './db/class_file.inc.php');

                    if( ($item= DbProjectItem::getVisibleById(intVal($target)))
                        &&  $item->type == ITEM_FILE
                        && $file= File::getVisibleById(intval($target))) {
                        $file= $file->getLatest();

                        ### if there are not options ##
                        if(!$this->options && $this->name) {
                            $this->options=split(",", preg_replace("/[^a-z,=0-9]/","",strtolower($this->name)));
                            $this->name = asHtml($file->name);
                        }


                        $flag_optionized= false;
                        $align='';
                        $max_size= '';
                        $framed= false;
                        if($this->options) {
                            foreach($this->options as $o) {
                                if($o == 'left') {
                                    $align= 'left';
                                    $this->html= "<a href='".$PH->getUrl('fileView',array('file'=>$file->id))."'><img class='left' title='".$file->name."' alt='".$file->name."' src='".$PH->getUrl('fileDownloadAsImage',array('file'=>$file->id,'max_size'=>320))."'></a>";
                                    $flag_optionized= true;
                                }
                                else if($o == 'right') {
                                    $align=' right';
                                    $this->html= "<a href='".$PH->getUrl('fileView',array('file'=>$file->id))."'><img class='left' title='".$file->name."' alt='".$file->name."' src='".$PH->getUrl('fileDownloadAsImage',array('file'=>$file->id,'max_size'=>320))."'></a>";
                                    $flag_optionized= true;
                                }
                                else if(preg_match('/maxsize=(\d*)/',$o, $matches)) {
                                    $max_size=$matches[1];
                                }
                                else if($o == 'framed') {
                                    $framed= true;
                                }
                            }
                        }
                        if($framed) {
                            $this->html= "<div class='frame $align'><a href='".$PH->getUrl('fileDownloadAsImage',array('file'=>$file->id))."'><img title='".asHtml($file->name)."' alt='".asHtml($file->name)."' src='".$PH->getUrl('fileDownloadAsImage',array('file'=>$file->id,'max_size'=>$max_size))."'></a>"
                            . '<span>'.asHtml($this->name)
                            ." (". "<a href='".$PH->getUrl('fileView',array('file'=>$file->id))."'>" .  __('Image details').   ")</a>"
                            .'</span>'
                            ."</div>";
                            if(!$align) {
                                $this->html.= '<span class=clear>&nbsp;</span>';
                            }

                        }
                        else {
                            $this->html= "<a href='".$PH->getUrl('fileDownloadAsImage',array('file'=>$file->id))."'><img class='$align' title='".asHtml($file->name)."' alt='".asHtml($file->name)."' src='".$PH->getUrl('fileDownloadAsImage',array('file'=>$file->id,'max_size'=>$max_size))."'></a>";
                        }
                    }
                    else {
                        $this->name = __("Unknown File-Id:"). ' ' .$target;
                    }

                    break;
                case 'project':
                    if( $project= Project::getVisibleById(intval($target))) {
                        $this->name = asHtml($project->name);
                        $this->target= $PH->getUrl('projView',array('prj'=>intval($target)));
                    }
                    else {
                        $this->name = __("Unknown project-Id:"). ' ' .$target;
                    }
                    break;
                case 'item':
                    if($item= DbProjectItem::getVisibleById(intVal($target))) {
                        switch($item->type) {
                            case ITEM_TASK:

                                if($task= Task::getVisibleById($item->id)) {
									if($this->name) {
										$style_isdone= $task->status >= STATUS_COMPLETED ? 'isDone' : '';

                                        $this->html= $PH->getLink('taskView',$this->name,array('tsk'=>$task->id), $style_isdone);
                                    }
                                    else {
                                        $this->html= $task->getLink(false);
                                    }
                                }
                                break;
                            case ITEM_FILE:
                                require_once(confGet('DIR_STREBER') . "db/class_file.inc.php");
                                if($file= File::getVisibleById($item->id)) {
                                    if($this->name) {
                                        $this->html= $PH->getLink('fileView',$this->name,array('file'=>$file->id));
                                    }
                                    else {
                                        $this->html= $PH->getLink('fileView',$file->name,array('file'=>$file->id));
                                    }
                                }
                                break;

                            case ITEM_COMMENT:
                                require_once(confGet('DIR_STREBER') . "db/class_comment.inc.php");
                                if($comment= Comment::getVisibleById($item->id)) {
                                    if($this->name) {
                                        $this->html= $PH->getLink('commentView',$this->name,array('comment'=>$comment->id));
                                    }
                                    else {
                                        $this->html= $PH->getLink('commentView',$comment->name,array('comment'=>$comment->id));
                                    }
                                }
                                break;

                            case ITEM_PERSON:
                                if($person= Person::getVisibleById($item->id)) {
                                    if($this->name) {
                                        $this->html= $PH->getLink('personView',$this->name,array('person'=>$person->id));
                                    }
                                    else {
                                        $this->html= $PH->getLink('personView',$person->name,array('person'=>$person->id));
                                    }
                                }
                                break;

                            default:
                                $this->html = '<em>'. sprintf(__('Cannot link to item of type %s'), $item->type). '</em>';
                                break;
                        }
                    }
                    break;


                default:
                    /**
                    * note, since this message is normally printed after the header,
                    * nobody will read this hint...
                    */
                    new FeedbackHint(sprintf(__('Wiki-format: <b>%s</b> is not a valid link-type'), $type)
                        . " " . sprintf(__("Read more about %s."), $PH->getWikiLink('WikiSyntax')));
            }
        }
        /**
        * try to guess node from name
        * - we prefer the current project (has to be passed by wiki2html()-callers
        */
        else {

            /**
            * start with looking for tasks...
            */
            $decoded_name=strtr($this->target, array_flip(get_html_translation_table(HTML_SPECIALCHARS, ENT_QUOTES)));


            if($g_wiki_project) {
                $tasks= Task::getAll(array(
                    #'name'=>$this->target,
                    'name'=>$decoded_name,
                    'project'=>$g_wiki_project->id,
                    'status_max'=>STATUS_CLOSED,

                ));
            }
            else {
                $tasks= Task::getAll(array(
                    'name'=>$decoded_name,
                    'status_max'=>STATUS_CLOSED,
                ));
            }
            if(count($tasks) == 1) {


                ### matches name ###
                if(!strcasecmp(asHtml($tasks[0]->name), $this->target)) {

                    $style_isdone= $tasks[0]->status >= STATUS_COMPLETED
                                ? 'isDone'
                                : '';

                    if($this->name) {
                        $this->html= "<a  class='item task $style_isdone' href='".$PH->getUrl('taskView',array('tsk'=>intval($tasks[0]->id)))."'>". asHtml($this->name)."</a>";
                        global $g_replace_list;
                        $g_replace_list[$this->target]='item:'. $tasks[0]->id.'|'.$this->name;
                    }
                    else {
                        $this->html= "<a  class='item task $style_isdone' href='".$PH->getUrl('taskView',array('tsk'=>intval($tasks[0]->id)))."'>".asHtml($tasks[0]->name)."</a>";
                        global $g_replace_list;
                        $g_replace_list[$this->target]='item:'. $tasks[0]->id.'|'.$tasks[0]->name;
                    }
                }
                ### matches short name ###
                else if(!strcasecmp($tasks[0]->short, $this->target)) {
                    $style_isdone= $tasks[0]->status >= STATUS_COMPLETED
                                ? 'isDone'
                                : '';

                    if($this->name) {
                        $this->html= "<a  class='item task $style_isdone' href='".$PH->getUrl('taskView',array('tsk'=>intval($tasks[0]->id)))."'>". asHtml($this->name)."</a>";
                        global $g_replace_list;
                        $g_replace_list[$this->target]='item:'. $tasks[0]->id.'|'.$this->name;
                    }
                    else {
                        $this->html= "<a  class='item task $style_isdone' href='".$PH->getUrl('taskView',array('tsk'=>intval($tasks[0]->id)))."'>".asHtml($tasks[0]->name)."</a>";
                        global $g_replace_list;
                        $g_replace_list[$this->target]='item:'. $tasks[0]->id.'|'.$tasks[0]->short;
                    }
                }
                else {
                    $title= __('No task matches this name exactly');
                    $title2= __('This task seems to be related');
                    $this->html= "<span title='$title' class=not_found>$this->name</span>"
                               . "<a href='".$PH->getUrl('taskView',array('tsk'=>intval($tasks[0]->id)))."' title='$title2'>?</a>";
                }
            }
            else if(count($tasks) > 1) {
                $matches= array();
                $best= -1;
                $best_rate= 0;

                foreach($tasks as $t) {

                    if(!strcasecmp($t->name, $this->target) && $g_wiki_project && $t->project == $g_wiki_project->id) {
                        $matches[]= $t;
                    }
                    else if(!strcasecmp($t->short, $this->target)) {
                        $matches[]= $t;
                    }
                }
                if(count($matches) == 1) {
                    $this->html= "<a href='"
                               . $PH->getUrl('taskView',array('tsk'=>intval($matches[0]->id)))
                               . "'>".$matches[0]->name
                               ."</a>";
                }
                else if(count($matches) > 1) {

                    $title= __('No item excactly matches this name.');
                    $title2= sprintf(__('List %s related tasks'), count($tasks));
                    $this->html=
                               "<a class=not_found title= '$title2' href='"
                               .$PH->getUrl('search',array('search_query'=>$this->target))

                               ."'> "
                               . $this->target
                               . " ("
                               . count($matches). ' ' . __('identical') .")</a>";
                }
                else {

                    if($g_wiki_project) {
                        $title= __('No item matches this name. Create new task with this name?');
                        $url= $PH->getUrl('taskNew', asHtml($this->target), array('prj'=>$g_wiki_project->id));
                        $this->html= "<a href='$url' title='$title' class=not_found>$this->target</a>";
                    }
                    else {
                        $title= __('No item matches this name.');
                        $this->html= "<span title='$title' class=not_found>$this->target</span>";
                    }
                }
            }
            else if(!count($tasks)) {

                /**
                * now check for team-members...
                */
                if($g_wiki_project) {
                    $people= $g_wiki_project->getPersons();
                    foreach($people as $person) {
                        if(!strcasecmp($person->nickname, $this->target)) {
                            $title= asHtml($person->name);
                            $nick= asHtml($person->nickname);
                            $this->html=  "<a class='item person' title= '$title' href='".$PH->getUrl('personView',array('person'=>$person->id))."'>$nick</a>";
                            return;
                        }
                    }
                }
                if($g_wiki_project) {


                    $title= __('No item matches this name. Create new task with this name?');
                    global $g_wiki_task;
                    if(isset($g_wiki_task)) {
                        if($g_wiki_task->category == TCATEGORY_FOLDER) {
                            $parent_task= $g_wiki_task->id;
                        }
                        else {
                            $parent_task= $g_wiki_task->parent_task;
                        }
                    }
                    else {
                        $parent_task= 0;
                    }

                    $url= $PH->getUrl('taskNew',  array(
                                                'prj'=>$g_wiki_project->id,
                                                'new_name'=>urlencode($this->target),
                                                'parent_task'=>$parent_task,
                                                ));

                    $this->html= "<a href='$url' title='$title' class=not_found>$this->target</a>";

                }
                /**
                * actually we could add a function to create a new task here, but somebody forgot to tell us the project...
                */
                else {
                    $title= __('No item matches this name');
                    $this->html= "<span title='$title' class=not_found>$this->target</span>";
                    trigger_error('g_wiki_project was not defined. Could not provide create-link.', E_USER_NOTICE);
                }
            }
        }
    }

    public function renderAsHtml()
    {
        if($this->html) {
            return $this->html;
        }
        else {
            return "<a href='$this->target'>$this->name</a>";
        }
    }


    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();
        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {


                    if(preg_match("/^(.*?)\[\[([^\]]*)\]\](.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockLink($matches[2]);

                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found) {

                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;
    }
}


class FormatBlockItemId extends FormatBlock
{
    public function renderAsHtml()
    {
        if($item= DbProjectItem::getVisibleById(intVal($this->str))) {
            global $PH;
            switch($item->type) {
            case ITEM_TASK:
                if($task= Task::getVisibleById(intVal($this->str))) {
                    $style='';
                    if(($task->category == TCATEGORY_TASK || $task->category == TCATEGORY_BUG) && $task->status >= STATUS_COMPLETED) {
                        $style='isDone';
                    }
                    return $PH->getLink('taskView', $task->name, array('tsk' => $task->id),$style);
                }
                break;

            case ITEM_PROJECT:
                if($project= Project::getVisibleById(intVal($this->str))) {
                    $style='';
                    if($project->status >= STATUS_COMPLETED) {
                        $style='isDone';
                    }
                    return $PH->getLink('projView', $project->name, array('prj' => $project->id),$style);
                }
                break;

            case ITEM_COMMENT:
                require_once(confGet('DIR_STREBER') . './db/class_comment.inc.php');
                if($comment= Comment::getVisibleById(intVal($this->str))) {
                    return $PH->getLink('commentView', $comment->name, array('comment' => $comment->id));
                }
                break;

            default:
                return "<em title='".__("Unknown Item Id")."'>Item #".$this->str."?</em>";
            }
        }
        else {
            return "<em title='".__("Unknown Item Id")."'>Item #".$this->str."?</em>";
        }
    }

    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();

        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    /**
                    * this regex is tricky because the #-charecters is also been
                    * used for excaping special html characters. So we have to
                    * look ahead and match only, if the follower is NOT a ; or a digitco
                    */
                    if(preg_match("/^(.*?)#(\d+)(?!;|\d)(.*)/si", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockItemId($matches[2]);
                        $text= $matches[3];
                        $found= true;
                    }
                    else if($found){
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }

            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;

    }
}



class FormatBlockListLine extends FormatBlock
{
    public $level;
    public $children= array();

    public function __construct($str, $level, $type)
    {
        $blocks= array(new FormatBlock($str));

        $blocks= FormatBlockBold::parseBlocks($blocks);
        $blocks= FormatBlockStrike::parseBlocks($blocks);

        $blocks= FormatBlockSub::parseBlocks($blocks);



        $blocks= FormatBlockMonospaced::parseBlocks($blocks);
        $blocks= FormatBlockEmphasize::parseBlocks($blocks);
        $blocks= FormatBlockLongMinus::parseBlocks($blocks);


        $blocks= FormatBlockHref::parseBlocks($blocks);
        $blocks= FormatBlockItemId::parseBlocks($blocks);

        $this->children= FormatBlockLink::parseBlocks($blocks);

        $this->str= '';
        $this->level=$level;
        $this->type= $type;
    }

    public function renderAsHtml()
    {
        $buffer="";
        foreach($this->children as $b) {
            $buffer.= $b->renderAsHtml();
        }
        return $buffer;
    }
}



class FormatBlockList extends FormatBlock
{
    public $children= array();

    public function __construct($str)
    {

        $last_level='';
        $levels=array();    #keep hash with levels
        while($str) {
            if(preg_match("/\A([ \t]*)(\*|\-|\#|\d+\.) ([^\n]*)\n(.*)/s",$str,$matches)) {
                if(isset($levels[$matches[1]])) {
                    $level= $levels[$matches[1]];

                }
                else {
                    $last_level= $matches[1];
                    if(isset($levels[$last_level])) {
                        $level= $levels[$last_level];
                    }
                    else {
                        $level= $levels[$last_level]= count($levels)+1;
                    }
                }
                $str= $matches[4];
            }
            else {
                trigger_error("unknown list-format '$str'",E_USER_NOTICE);
                break;
            }

            $this->children[]= new FormatBlockListLine($matches[3], $level, $matches[2]);

        }

        #$tmp= array(new FormatBlock($str));
        #$this->children= FormatBlockBold::parseBlocks($tmp);

        $this->str= '';
    }



    public function renderAsHtml()
    {
        if($this->children[0]->type=="#" || preg_match("/\d+\./",$this->children[0]->type)) {
            $type="ol";
        }
        else {
            $type="ul";
        }

        $types= array($type);


        $buffer="<$type>";
        $last_level=1;
        foreach($this->children as $b) {
            if ($last_level == $b->level) {
                    if(preg_match("/(\d+)\./", $b->type, $matches)) {
                        $buffer.="<li value=". intval($matches[1]). ">";
                    }
                    else {
                        $buffer.="<li>";
                    }
            }
            else {
                while($b->level > $last_level) {

                    if($b->type=="#" || preg_match("/\d+\./",$b->type)) {
                        $t_type="ol";
                    }
                    else {
                        $t_type="ul";
                    }
                    $types[$last_level]= $t_type;

                    $buffer.="<$t_type>";

                    if(preg_match("/(\d+)\./", $b->type, $matches)) {
                        $buffer.="<li value=". intval($matches[1]). ">";
                    }
                    else {
                        $buffer.="<li>";
                    }


                    $last_level++;
                }
                if($b->level < $last_level) {
                    while($b->level < $last_level) {

                        $last_level--;
                        $type= $types[$last_level];
                        $buffer.="</li></$type>";
                    }

                    if(preg_match("/(\d+)\./", $b->type, $matches)) {
                        $buffer.="<li value=". intval($matches[1]). ">";
                    }
                    else {
                        $buffer.="<li>";
                    }
                }
            }

            $buffer.= $b->renderAsHtml();
        }
        while($last_level > 0) {
            $last_level --;
            $type= $types[$last_level];
            $buffer.= "</$type>";
        }
        return $buffer;
    }


    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();
        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    #if(preg_match("/\A((?: *\-[ \t][^\r\n]+\r?\n)+)[ \t]*(\r?\n.*)/su", $text, $matches)) {
                    #
                    # partly working:
                    #  if(preg_match("/\A((?:(?:\*|\-|\#) [^\r\n]+\r?\n)+)[ \t]*\r?\n?(.*)/su", $text, $matches)) {
                    if(preg_match("/\A((?:[ \t]*(?:\*|\-|\#|\d+\.) [^\r\n]+\r?\n)+)(.*)/su", $text, $matches)) {

                        $blocks_new[]= new FormatBlockList($matches[1]);
                        $text= $matches[2];
                        $found= true;
                    }
                    #else if(preg_match("/(.*?)\n((?:[ \t]*(\-|\*)[ \t][^\r\n]+\r?\n)+)([ \t]*\r?\n.*)/su", $text, $matches)) {
                    else if(preg_match("/(.*?)\n((?:[ \t]*(\-|\*|\#|\d+\.) [^\r\n]+\r?\n)+)\r?\n?(.*)/su", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);

                        $blocks_new[]= new FormatBlockList($matches[2]);
                        $text= $matches[4];
                        $found= true;
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;
    }
}



class FormatBlockTable extends FormatBlock
{
    public $line_cells= array();

    /**
    * further parse the content of the cells
    */
    public function __construct($line_cells)
    {
        foreach($line_cells as $cells) {
            $new_cells= array();
            foreach($cells as $cell) {
                $cell_blocks= array(new FormatBlock($cell));

                $cell_blocks= FormatBlockBold::parseBlocks($cell_blocks);
                $cell_blocks= FormatBlockStrike::parseBlocks($cell_blocks);

                $cell_blocks= FormatBlockSub::parseBlocks($cell_blocks);



                $cell_blocks= FormatBlockMonospaced::parseBlocks($cell_blocks);
                $cell_blocks= FormatBlockEmphasize::parseBlocks($cell_blocks);

                $cell_blocks= FormatBlockHref::parseBlocks($cell_blocks);
                $cell_blocks= FormatBlockItemId::parseBlocks($cell_blocks);

                $new_cells[]=  FormatBlockLink::parseBlocks($cell_blocks);
            }
            $this->line_cells[]= $new_cells;
        }
    }

    public function renderAsHtml()
    {
        $count=0;
        $html='<table>';
        foreach($this->line_cells as $line) {
            $html.= '<tr>';
            foreach($line as $cell_with_blocks) {
            $html.= $count
                  ? '<td>'
                  : '<th>';

            foreach($cell_with_blocks as $b) {
                $html.= $b->renderAsHtml();
            }

            $html.= $count
                  ? '</td>'
                  : '</th>';


            }
            $html.=  '</tr>';
            $count++;
        }
        $html.='</table>';

        return $html;
    }


    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();
        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {

                    if(preg_match("/(.*?)\r?\n((?:\|.*?\|\s*[\r\n]+)+)\s*\r*\n*(.*)/su", $text, $matches)) {

                        $blocks_new[]= new FormatBlock($matches[1]);

                        ### check number of pipes in each line...
                        $lines= explode("\n", $matches[2]);
                        $line_cells=array();
                        $rest= $matches[3];

                        $last_num_cells=-1;
                        $syntax_failure= false;
                        foreach($lines as $line) {
                            if($line= trim($line)) {

                                $tmp_cells=array();
                                $line=trim($line);

                                $line= preg_replace("/\[\[([^\]]*?)\|([^\]]*)\]\]/","[[$1§$2]]",$line);


                                $cells= array_slice(explode("|", $line) , 1, -1);

                                if($last_num_cells == -1) {
                                    $last_num_cells = count($cells);
                                }
                                else if(count($cells) != $last_num_cells) {
                                    $syntax_failure= true;
                                    break;
                                }

                                for($i=0; $i< count($cells); $i++) {
                                    $cells[$i]= str_replace("§",'|', $cells[$i]);
                                }

                                $line_cells[]= $cells;
                            }
                        }

                        if(!$syntax_failure) {
                            $blocks_new[]= new FormatBlockTable($line_cells);
                            $text= $rest;
                            $found= true;
                        }
                        else {
                            $blocks_new[]= $b;
                            break;
                        }
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock($text);
                        break;
                    }
                    else {
                        $blocks_new[]= $b;
                        break;
                    }
                }
            }
            else {
                $blocks_new[]=$b;
            }
        }
        return $blocks_new;
    }
}





/**
* convert text to html-format (add line-breaks)
*
* if project has wiki-link, solve links
*/
global $g_wiki_project;
$g_wiki_project= NULL;                                      # dirty hack to pass project for linking of wiki-pages

function &wiki2html(&$text, $project=NULL, $item_id=NULL, $field_name=NULL)
{

    $text_org = $text;
    $text.="\n";

    ### use conf ###
    $text= asHtml($text);

    ### convert, if id is given ###
    if(!is_object($project)) {
        $project= Project::getVisibleById($project);
    }

    global $g_wiki_project;
    $g_wiki_project= $project;

    $blocks= wiki2blocks($text);

    $str_item_id= is_null($item_id)
                ? ''
                : 'item_id=' . $item_id;


    $str_field  = is_null($field_name)
                ? ''
                : 'field_name=' . $field_name;

    $str_editable = $item_id
                ? 'editable'
                : '';


    $tmp= array();
    $tmp[]= "<div class='wiki $str_editable' $str_item_id $str_field><div class=chapter>";

    foreach($blocks as $b) {
        if($b instanceof FormatBlockHeadline) {
            $tmp[]="</div><div class=chapter>";
        }

        $tmp[]= $b->renderAsHtml();
    }
    $tmp[]= '</div>';
    $tmp[]= '<span class=end> </span></div>';                # end-span to create image-floats

    $out= implode('', $tmp);
    global $g_wiki_auto_adjusted;
    $g_wiki_auto_adjusted= '';
    if(confGet('WIKI_AUTO_INSERT_IDS')) {
        global $g_replace_list;
        if(count($g_replace_list)) {
            foreach($g_replace_list as $org => $new) {
                $text_org= str_replace('[['.$org.']]', '[['.$new.']]', $text_org);
            }
            $g_wiki_auto_adjusted= $text_org;
        }
    }
    return $out;
}


/**
* do actual parsing of wiki text and conversion into blocks
*
* NOTE:
* - g_wiki_project has to be initialized for this function
*/
function &wiki2blocks(&$text)
{
    #if($convert_special_chars) {
    #    $text= htmlSpecialChars($text);
    #}
    $blocks= array(new FormatBlock(&$text));

    ### code-blocks ###
    $blocks= FormatBlockCode::parseBlocks($blocks);
    $blocks= FormatBlockCodeIndented::parseBlocks($blocks);

    $blocks= FormatBlockTable::parseBlocks($blocks);

    $blocks= FormatBlockQuote::parseBlocks($blocks);
    $blocks= FormatBlockHeadline::parseBlocks($blocks);

    $blocks= FormatBlockList::parseBlocks($blocks);

    $blocks= FormatBlockHref::parseBlocks($blocks);

    $blocks= FormatBlockBold::parseBlocks($blocks);
    $blocks= FormatBlockStrike::parseBlocks($blocks);
    $blocks= FormatBlockSub::parseBlocks($blocks);


    $blocks= FormatBlockLinebreak::parseBlocks($blocks);

    $blocks= FormatBlockHr::parseBlocks($blocks);
    $blocks= FormatBlockItemId::parseBlocks($blocks);

    $blocks= FormatBlockLink::parseBlocks($blocks);
    $blocks= FormatBlockMonospaced::parseBlocks($blocks);
    $blocks= FormatBlockEmphasize::parseBlocks($blocks);
    $blocks= FormatBlockLongMinus::parseBlocks($blocks);

    return $blocks;

}

/**
* returns the wikitext without the outer div
*/
function wiki2purehtml($text, $project=NULL)
{

    ### convert, if id is given ###
    if(!is_object($project)) {
        $project= Project::getVisibleById($project);
    }

    global $g_wiki_project;
    $g_wiki_project= $project;


    $blocks = wiki2blocks(asHtml($text), $project);
    $tmp = array();
    $out='';
    $tmp[]= "<div class=chapter>";

    foreach($blocks as $b) {
        if($b instanceof FormatBlockHeadline) {
            $tmp[]="</div><div class=chapter>";
        }

        $tmp[]= $b->renderAsHtml();
    }
    $tmp[]= '</div>';
    $result= implode('',$tmp);
    return $result;
}


/**
* return a fraction of a wiki text
*
* this is used be inline editing functions with ajax
*/
function getOneWikiChapter(&$text, $chapter)
{
    $parts= getWikiChapters(&$text);
    if(isset($parts[$chapter])) {
        return $parts[$chapter];
    }
    else {
        return __("Warning: Could not find wiki chapter");
    }
}


class ChapterBlock {
    public $str="";
    
    public function __construct(&$str) 
    {
        $this->str= $str;
    }
}


class ChapterBlockCode extends ChapterBlock{
}
    

/**
* split wiki text into chapters starting with a headline
*
* - returns array with chapters.
* - First chapter might be empty, if there is no text before the first headline.
*/
function &getWikiChapters(&$text)
{
    $regex_headlines= array(
        "/(.*?)(\r?==[ \t]*[^\n=]+==\s*\r?\n[ \t]*)(.*)/s",
        "/(.*?)(\r?===[ \t]*([^\n=]+)===\s*\n[ \t]*)(.*)/s",
        "/(.*?)([^\r\n]+[\r\n]+===+[ \t]*[\r\n]+)(.*)/s",
        "/(.*?)([^\n\r]+\r?\n---+[\t]*[\r\n]+)(.*)/s",
        #"/(.*?)(\[code(\s*[^\]]*)\](.*?)\[\/code\]\r?\n?)(.*)$/s",
    );

    $blocks= array();
    

    ### split into codeblocks ###
    $rest = $text;
    
    while($rest) {
        ### ignore code blocks ###
        if(preg_match("/(.*?)(\[code\s*[^\]]*\].*?\[\/code\]\r?\n?)(.*)$/s", $rest, $matches)) {
            if($matches[1]) {
                $blocks[]= new ChapterBlock($matches[1]);
            }
            $blocks[]= new ChapterBlockCode($matches[2]);
            $rest= $matches[3];
        }
        ### indented code ###
        else if(preg_match("/\A(.*?)(\r?\n[ \t]*\r?\n((?:[ \t]+[^\n]*\n)+)\r?\n?)(.*)/s", $rest, $matches)) {
            if($matches[1]) {
                $blocks[]= new ChapterBlock($matches[1]);
            }
            $blocks[]= new ChapterBlockCode($matches[2]);
            $rest= $matches[4];
        }
        else {
            $blocks[]= new ChapterBlock($rest);
            $rest= "";
        }
    }

    foreach($blocks as $b) {
        if ($b instanceof ChapterBlockCode) {
            continue;
        }
        $rest= $b->str;
        
        foreach($regex_headlines as $reg) {
            $new_buffer= "";
    
            while($rest) {
                if(preg_match($reg, $rest, $matches)) {
                    $new_buffer.= $matches[1]. "__SPLITTER__" . $matches [2];
                    $rest=$matches[3];
                }
                else {
                    $new_buffer.= $rest;
                    $rest= "";
                }
            }
            $rest= $new_buffer;
        }
        $b->str= $rest;
    }
    
    $tmp= array();
    foreach($blocks as $b) {
        $tmp[]= $b->str;
    }
    $buffer= implode("",$tmp);
    $parts= explode('__SPLITTER__', $buffer);
    

    return $parts;
}





?>