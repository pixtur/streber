<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * classes related to formating wiki into html
 *
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
                    if(preg_match("/^(.*?)\[code(\s*[^\]]*)\](.*?)\[\/code\]\r?\n?(.*)$/s", $text, $matches)) {
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

/**
* we extend from code block to prevent further inline formatting
*/
class FormatBlockLatex extends FormatBlockCode
{
    public function __construct($str) {
        $this->str = $str;
    }
    public function renderAsHtml() {
        return '<a title= "Open codecogs latex editor" href="http://www.codecogs.com/components/equationeditor/editor.php" class=latex target=blank>'
            . '<img  src="http://www.codecogs.com/gif.latex?'
            . $this->str
            . '" /></a>';
    }

    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();
        $found = false;
        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                while($text) {
                    if(preg_match("/^(.*?)\[latex\](.*?)\[\/latex\]\r?\n?(.*)$/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockLatex($matches[2]);
                        $text= $matches[3];
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



/**
* turn leading spaces into nonbreaking spaces
*/
class FormatBlockLeadingSpaces extends FormatBlock
{

    public function renderAsHtml()
    {
        return str_repeat("&nbsp;", strlen($this->str));
    }

    static function parseBlocks(&$blocks)
    {
        $blocks_new= array();

        foreach($blocks as $b) {

            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {


                    if(preg_match("/\A(.*?)\r?\n([ \t]+)(.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]."\n");
                        $blocks_new[]= new FormatBlockLeadingSpaces($matches[2]);
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


/**
* highlight changes
*
* [added]...[/added]
* [changed]...[/changed]
* [deleted something]
* [deleted word] .. [/deleted word]
* [changed word] .. [/changed word]
* [added word] .. [/added word]
* 
* The original changes are added by DbItem->getTextfieldWithUpdateNotes()
*/
class FormatBlockChangemarks extends FormatBlock
{
    public function renderAsHtml()
    {
        if ($this->str == "changed") {
            return "<span class='updatemarker update open'>" . __('Update','wiki change marker') . "➜</span>";
        }
        elseif ($this->str == "/changed") {
            return "<span class='updatemarker update close'>" . "]" . "</span>";
        }
        elseif ($this->str == "added") {
            return "<span class='updatemarker new open'>" . __('New','wiki change marker') . "➜</span>";
        }
        elseif ($this->str == "/added") {
            return "<span class='updatemarker new close'>" . "]" . "</span>";
        }
        elseif ($this->str == "deleted something") {
            return "<span class='updatemarker deleted'>" . __('Deleted','wiki change marker') . "</span>";
        }
        elseif ($this->str == "added word") {
            return "<span class='wiki_word_change added'>";
        }
        elseif ($this->str == "/added word") {
            return "</span>";
        }
        elseif ($this->str == "deleted word") {
            return "<span class='wiki_word_change deleted'>";
        }
        elseif ($this->str == "/deleted word") {
            return "</span>";
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

                    if(preg_match("/^(.*?)\[(\/?changed|\/?added|deleted something|\/?added word|\/?changed word|\/?deleted word)\](.*)/s", $text, $matches)) {
                        $blocks_new[]= new FormatBlock($matches[1]);
                        $blocks_new[]= new FormatBlockChangemarks($matches[2]);
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

                    if(preg_match("/^(.*?)\*([^\*\s][^\*]*[^\*\s])\*(.*)/s", $text, $matches)) {
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

                    if(preg_match("/^(.*?)~~([^\*\s].+[^~\s])~~(.*)/s", $text, $matches)) {
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
        return "<a class=extern href='{$this->type}{$this->url}' target='blank'>{$this->type}{$this->url}</a>";
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

        $blocks= FormatBlockChangemarks::parseBlocks($blocks);

        $blocks= FormatBlockBold::parseBlocks($blocks);
        $blocks= FormatBlockStrike::parseBlocks($blocks);
        $blocks= FormatBlockSub::parseBlocks($blocks);

        $blocks= FormatBlockLinebreak::parseBlocks($blocks);


        $blocks= FormatBlockLink::parseBlocks($blocks);
        $blocks= FormatBlockHref::parseBlocks($blocks);
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
        $buffer= "<div class=quote><blockquote>" . asHtml($this->str);
        foreach($this->children as $b) {
            $buffer.= $b->renderAsHtml();
        }
        $buffer.= "</blockquote>";
        $buffer.= $buffer_from. "</div>";
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
        measure_start("blockHeadlineConstruction");

        $blocks= array(new FormatBlock($str));
        $blocks= FormatBlockChangemarks::parseBlocks($blocks);

        $blocks= FormatBlockBold::parseBlocks($blocks);
        $blocks= FormatBlockStrike::parseBlocks($blocks);

        $blocks= FormatBlockSub::parseBlocks($blocks);

        $blocks= FormatBlockMonospaced::parseBlocks($blocks);
        $blocks= FormatBlockEmphasize::parseBlocks($blocks);

        $blocks= FormatBlockLink::parseBlocks($blocks);
        $blocks= FormatBlockHref::parseBlocks($blocks);
        $this->children= FormatBlockItemId::parseBlocks($blocks);

        $this->str= '';
        $this->level=$level+1;
        
        measure_stop("blockHeadlineConstruction");
    }

    public function renderAsHtml()
    {
        $buffer="<h$this->level>";
        foreach($this->children as $b) {
            $buffer.= $b->renderAsHtml();
        }
        $buffer.= "<a name='" . asIdentifier($b->renderAsHtml()) .  "'  href='#"  . asIdentifier($b->renderAsHtml())  . "' title='" . __("Link to this chapter")  . "'  class='anchor' >π</a>";        
        $buffer.= "</h$this->level>";
        return $buffer;
    }

    /**
    * the following code is not really brilliant. Too lazy to optimize
    */
    static function parseBlocks(&$blocks)
    {
        measure_start("blockHeadline1");
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
        measure_stop("blockHeadline1");
        measure_start("blockHeadline2");

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

        measure_stop("blockHeadline2");
        measure_start("blockHeadline3");

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

        measure_stop("blockHeadline3");
        measure_start("blockHeadline4");

        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                while($text) {
                    if(preg_match("/(.*?)([^\n\r]+)\r?\n---+[\t]*[\r\n]+(.*)/s", $text, $matches)) {
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
        measure_stop("blockHeadline4");

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


/**
* all tags inside double square brackets like [[...]]
*/
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

        measure_start("blockLink::__construct");
        global $PH;
        global $g_wiki_project;

        $this->str='';      # prevent from further processing


        ### id|options|title ###
        if(preg_match("/\A([^\|]+)\|([^|]+)\|([^|]*)$/", $str, $matches)) {
            $this->target= asCleanString($matches[1]);
            $this->options= explode(",", preg_replace("/[^a-z,=0-9]/", "", strtolower($matches[2])));
            $this->name=$matches[3];

        }
        ### id|title ###
        else if(preg_match("/\A([^\|]+)\|([^|]+)$/", $str, $matches)) {
            $this->target="#" . asCleanString($matches[1]);            
            $this->name  =$matches[2];
        }
        else {
            $this->name  ='';
            $this->target=$str;
        }


        /**
        * urls
        */
        if(preg_match("/\A([\w]+)\:\/\/(\S+)/",$this->target, $matches)) {
            $type       = asKey($matches[1]);

            $target     = $matches[2];
            
            ### avoid breaking of url by double encoding of "&"-symbol...
            $target_url = str_replace( "&amp;" , "&", asHtml($target));
                    
            if($this->name) {
                $this->html= "<a rel='nofollow' class=extern title='" . asHtml($this->target).  "' href='". $type. "://" . $target_url . "'>" . asHtml($this->name) . "</a>";
            }
            else {
                $this->html= "<a  class=extern  title='" . asHtml($this->target).  "' href='". $type. "://" . $target_url . "'>" . asHtml($this->target) . "</a>";
            }
        }
        /**
        * short item ala [[#234|some name]]
        */
        else if(preg_match("/\A\#(\d+)/",$this->target, $matches)){
            
            
            $id= intVal( $matches[1]);
            $this->html= FormatBlockLink::renderLinkFromItemId($id, $this->name);
        }
        
        /**
        * type:???
        */
        else if(preg_match("/\A([\w]+)\:(\d+)/",$this->target, $matches)) {

            $type       = asKey($matches[1]);
            $target     = asCleanString($matches[2]);

            switch($type) {

                /**
                * embedding images...
                */
                case 'image':
                    measure_start("blockLink::__construct::image");
                    require_once(confGet('DIR_STREBER') . './db/class_file.inc.php');

                    if( ($item= DbProjectItem::getVisibleById(intVal($target)))
                        &&  $item->type == ITEM_FILE
                        && $file= File::getVisibleById(intval($target))) {
                        $file= $file->getLatest();

                        ### if there are not options ##
                        if(!$this->options && $this->name) {
                            $this->options=explode(",", preg_replace("/[^a-z,=0-9]/","",strtolower($this->name)));
                            $this->name = asHtml($file->name);
                        }

                        $align='';
                        $max_size= 680;
                        $framed= false;
                        if($this->options) {
                            foreach($this->options as $o) {
                                if($o == 'left') {
                                    $align= 'left';
                                }
                                else if($o == 'right') {
                                    $align='right';
                                }
                                else if(preg_match('/maxsize=(\d*)/',$o, $matches)) {
                                    $max_size=$matches[1];
                                }
                                else if($o == 'framed') {
                                    $framed= true;
                                }
                            }
                        }
                        if(!$dimensions = $file->getImageDimensions($max_size)) {
                            $this->html = '<em>' . sprintf(__("Item #%s is not an image"), $file->id) . "</em>";
                            return;
                        }
                        if($framed) {
                            $this->html = "<div class='frame $align'>"
                                        . "<a href='" . $PH->getUrl('fileDownloadAsImage',array('file'=>$file->id))."'>"
                                        . "<img class=uploaded title='".asHtml($file->name)."'"
                                        .     " alt='".asHtml($file->name)."'"
                                        .     " src='".$PH->getUrl('fileDownloadAsImage',array('file'=>$file->id,'max_size'=>$max_size))."'"
                                        .     " height=" .intval( $dimensions['new_height'])
                                        .     " width=" .intval( $dimensions['new_width'])    
                                        . "></a>"
                                        . '<span>'.asHtml($this->name)
                                        . " (". "<a href='".$PH->getUrl('fileView',array('file'=>$file->id))."'>" .  __('Image details').   ")</a>"
                                        . '</span>'
                                        . "</div>";
                            if(!$align) {
                                $this->html.= '<span class=clear>&nbsp;</span>';
                            }
                        }
                        else {
                            $this->html= "<a href='".$PH->getUrl('fileDownloadAsImage',array('file'=>$file->id))."'>"
                                       . "<img class='$align uploaded'"
                                       .     " title='" . asHtml($file->name) ."'"
                                       .     " alt='" . asHtml($file->name) ."'"
                                       #.     " src='" . $PH->getUrl('fileDownloadAsImage',array('file'=>$file->id,'max_size'=>$max_size))."'"
                                       .    " src='" . $file->getCachedUrl($max_size)."'"
                                       .     " height=" .intval( $dimensions['new_height'])    
                                       .     " width=" .intval( $dimensions['new_width'])    
                                       . "></a>";
                        } 
                    }
                    else {
                        $this->name = __("Unknown File-Id:"). ' ' .$target;
                    }
                    measure_stop("blockLink::__construct::image");

                    break;

                /**
                * item
                */
                case 'item':
                    $this->html= FormatBlockLink::renderLinkFromItemId($target, $this->name);
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
        * - we prefer the current project (has to be passed by wikifieldAsHtml()-callers
        */
        else {
            $this->html= FormatBlockLink::renderLinkFromTargetName($this->target, $this->name);
        }
        measure_stop("blockLink::__construct");

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

    /**
    * tries to build a valid a href-link to an item.
    *
    * - uses $this->name
    * - sets -this-html
    * - does all the neccessary security checks, styles and conversions
    */
    static function renderLinkFromItemId($target_id, $name="")
    {
        global $PH;
        $target_id = intval($target_id);
        $html= "";
        
        if(!$item= DbProjectItem::getVisibleById($target_id)) {
            $html= '<em>'. sprintf(   __("Unkwown item %s"), $target_id) . '</em>';
        }
        else {          
            switch($item->type) {
                case ITEM_TASK:
                    if($task= Task::getVisibleById($item->id)) {
                        $style_isdone= $task->status >= STATUS_COMPLETED ? 'isDone' : '';
                        if($name) {
                            $html= $PH->getLink('taskView',$name,array('tsk'=>$task->id), $style_isdone, true);
                        }
                        else {
                            $html= $task->getLink(false);
                        }
                    }
                    break;

                case ITEM_FILE:
                    require_once(confGet('DIR_STREBER') . "db/class_file.inc.php");
                    if($file= File::getVisibleById($item->id)) {
                        if($name) {
                            $html= $PH->getLink('fileDownloadAsImage',$name,array('file'=>$file->id), NULL, true);
                        }
                        else {
                            $html= $PH->getLink('fileDownloadAsImage',$file->name,array('file'=>$file->id));
                        }
                    }
                    break;

                case ITEM_COMMENT:
                    require_once(confGet('DIR_STREBER') . "db/class_comment.inc.php");
                    if($comment= Comment::getVisibleById($item->id)) {
                        if($name) {
                            $html= $PH->getLink('commentView',$name,array('comment'=>$comment->id), NULL, true);
                        }
                        else {
                            $html= $PH->getLink('commentView',$comment->name,array('comment'=>$comment->id));
                        }
                    }
                    break;

                case ITEM_PERSON:
                    if($person= Person::getVisibleById($item->id)) {
                        if($name) {
                            $html= $PH->getLink('personView',$name,array('person'=>$person->id), NULL, true);
                        }
                        else {
                            $html= $PH->getLink('personView',$person->name,array('person'=>$person->id));
                        }
                    }
                    break;

                case ITEM_PROJECT:
                    if( $project= Project::getVisibleById($item->id)) {
                        if($name == "") {
                            $name = asHtml($project->name);
                        }
                        $html= $PH->getLink('projView', $name, array('prj'=>$project->id), NULL, true);
                    }
                    break;                

                default:
                    $html = '<em>'. sprintf(__('Cannot link to item #%s of type %s'), intval($target_id), $item->type). '</em>';
                    break;
            }
        }
        return $html;
    }
    
    static function renderLinkFromTargetName($target, $name)
    {
        measure_start("BlockLink::renderLinkFromTargetName");
        global $PH;
        global $g_replace_list;
        global $g_wiki_project;
        $html= "";

        /**
        * start with looking for tasks...
        */
        $decoded_name=strtr($target, array_flip(get_html_translation_table(HTML_SPECIALCHARS, ENT_QUOTES)));

        measure_start("BlockLink::renderLinkFromTargetName::getTasks");

        if($g_wiki_project) {
            $tasks= Task::getAll(array(
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
        measure_stop("BlockLink::renderLinkFromTargetName::getTasks");

        if(count($tasks) == 1) {


            ### matches name ###
            if(!strcasecmp(asHtml($tasks[0]->name), $target)) {

                $style_isdone= $tasks[0]->status >= STATUS_COMPLETED
                            ? 'isDone'
                            : '';

                if($name) {
                    $html= "<a  class='item task $style_isdone' href='".$PH->getUrl('taskView',array('tsk'=>intval($tasks[0]->id)))."'>". asHtml($name)."</a>";
                    global $g_replace_list;
                    $g_replace_list[$target]='#'. $tasks[0]->id.'|'.$name;
                }
                else {
                    $html= "<a  class='item task $style_isdone' href='".$PH->getUrl('taskView',array('tsk'=>intval($tasks[0]->id)))."'>".asHtml($tasks[0]->name)."</a>";
                    global $g_replace_list;
                    $g_replace_list[$target]='#'. $tasks[0]->id.'|'.$tasks[0]->name;
                }
            }
            ### matches short name ###
            else if(!strcasecmp($tasks[0]->short, $target)) {
                $style_isdone= $tasks[0]->status >= STATUS_COMPLETED
                            ? 'isDone'
                            : '';

                if($name) {
                    $html= "<a  class='item task $style_isdone' href='".$PH->getUrl('taskView',array('tsk'=>intval($tasks[0]->id)))."'>". asHtml($name)."</a>";
                    global $g_replace_list;
                    $g_replace_list[$target]='#'. $tasks[0]->id.'|'.$name;
                }
                else {
                    $html= "<a  class='item task $style_isdone' href='".$PH->getUrl('taskView',array('tsk'=>intval($tasks[0]->id)))."'>".asHtml($tasks[0]->name)."</a>";
                    global $g_replace_list;
                    $g_replace_list[$target]='#'. $tasks[0]->id.'|'.$tasks[0]->short;
                }
            }
            else {
                $title= __('No task matches this name exactly');
                $title2= __('This task seems to be related');
                $html= "<span title='$title' class=not_found>$name</span>"
                           . "<a href='".$PH->getUrl('taskView',array('tsk'=>intval($tasks[0]->id)))."' title='$title2'>?</a>";
            }
        }
        else if(count($tasks) > 1) {
            measure_start("BlockLink::renderLinkFromTargetName::iterateSeveralTasks");

            $matches= array();
            $best= -1;
            $best_rate= 0;

            foreach($tasks as $t) {

                if(!strcasecmp($t->name, $target) && $g_wiki_project && $t->project == $g_wiki_project->id) {
                    $matches[]= $t;
                }
                else if(!strcasecmp($t->short, $target)) {
                    $matches[]= $t;
                }
            }
            if(count($matches) == 1) {
                $html= "<a href='"
                           . $PH->getUrl('taskView',array('tsk'=>intval($matches[0]->id)))
                           . "'>".$matches[0]->name
                           ."</a>";
            }
            else if(count($matches) > 1) {

                $title= __('No item excactly matches this name.');
                $title2= sprintf(__('List %s related tasks'), count($tasks));
                $html=
                           "<a class=not_found title= '$title2' href='"
                           .$PH->getUrl('search',array('search_query'=>$target))

                           ."'> "
                           . $target
                           . " ("
                           . count($matches). ' ' . __('identical') .")</a>";
            }
            else {
                if($g_wiki_project) {
                    $title= __('No item matches this name. Create new task with this name?');
                    $url= $PH->getUrl('taskNew', asHtml($target), array('prj'=>$g_wiki_project->id));
                    $html= "<a href='$url' title='$title' class=not_found>$target</a>";
                }
                else {
                    $title= __('No item matches this name...');
                    $html= "<span title='$title' class=not_found>$target</span>";
                }
            }
            measure_stop("BlockLink::renderLinkFromTargetName::iterateSeveralTasks");
        }
        else if(0 == count($tasks)) {

            measure_start("BlockLink::renderLinkFromTargetName::notATaskItem");

            /**
            * now check for team-members...
            */
            if($g_wiki_project) {
                $people = Person::getPeople(array(
                                'project'=> $g_wiki_project->id,
                                'search'=> $target,
                            ));
                if(count($people) == 1) {
                    return  "<a class='item person' title= '" .asHtml( $people[0]->name) . "' href='".$PH->getUrl('personView',array('person'=>$people[0]->id))."'>" . asHtml($target) . "</a>";
                }                
                measure_stop("BlockLink::renderLinkFromTargetName::getPeople");
            }
            /**
            * Link to create new task or topic
            */
            if($g_wiki_project) {
                $title= __('No item matches this name. Create new task with this name?');
                global $g_wiki_task;
                if(isset($g_wiki_task) && $g_wiki_task->type == ITEM_TASK) {
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
                                            'new_name'=>urlencode($target),
                                            'parent_task'=>$parent_task,
                                            ));

                $html= "<a href='$url' title='$title' class=not_found>$target</a>";
            }
            /**
            * actually we could add a function to create a new task here, but somebody forgot to tell us the project...
            */
            else {
                $title= __('No item matches this name');
                $html= "<span title='$title' class=not_found>$target</span>";
                trigger_error('g_wiki_project was not defined. Could not provide create-link.', E_USER_NOTICE);
            }
            measure_stop("BlockLink::renderLinkFromTargetName::notATaskItem");

        }
        measure_stop("BlockLink::renderLinkFromTargetName");

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
        return FormatBlockLink::renderLinkFromItemId(intVal($this->str) );
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
        $blocks= FormatBlockLatex::parseBlocks($blocks);
        $blocks= FormatBlockBold::parseBlocks($blocks);
        $blocks= FormatBlockStrike::parseBlocks($blocks);

        $blocks= FormatBlockSub::parseBlocks($blocks);

        $blocks= FormatBlockMonospaced::parseBlocks($blocks);
        $blocks= FormatBlockEmphasize::parseBlocks($blocks);
        $blocks= FormatBlockLongMinus::parseBlocks($blocks);

        $blocks= FormatBlockLink::parseBlocks($blocks);
        $blocks= FormatBlockHref::parseBlocks($blocks);
        $this->children= FormatBlockItemId::parseBlocks($blocks);

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
                    if(preg_match("/\A((?:[ \t]*(?:\*|\-|\#|\d+\.) [^\r\n]+\r?\n)+)(.*)/su", $text, $matches)) {

                        $blocks_new[]= new FormatBlockList($matches[1]);
                        $text= $matches[2];
                        $found= true;
                    }
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

                $cell_blocks= FormatBlockChangemarks::parseBlocks($cell_blocks);

                $cell_blocks= FormatBlockBold::parseBlocks($cell_blocks);
                $cell_blocks= FormatBlockStrike::parseBlocks($cell_blocks);

                $cell_blocks= FormatBlockSub::parseBlocks($cell_blocks);



                $cell_blocks= FormatBlockMonospaced::parseBlocks($cell_blocks);
                $cell_blocks= FormatBlockEmphasize::parseBlocks($cell_blocks);

                $cell_blocks= FormatBlockLink::parseBlocks($cell_blocks);
                $cell_blocks= FormatBlockHref::parseBlocks($cell_blocks);
                $new_cells[]= FormatBlockItemId::parseBlocks($cell_blocks);

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
        $placeholder_for_pipes = "\x03";
        $blocks_new= array();
        foreach($blocks as $b) {
            if($b->str && !($b instanceof FormatBlockCode)) {

                $text= $b->str;
                $found= false;
                
                while($text) {

                    ### replace pipes inside links with special character ####
                    $text= FormatBlockTable::replacePipesInsideLinks($text, $placeholder_for_pipes);

                    if(preg_match("/(.*?)((?:\|.*?\|\s*[\r\n]+)+)\s*\r*\n*(.*)/su", $text, $matches)) {

                        $keep_previous_block= new FormatBlock( str_replace( $placeholder_for_pipes, '|', $matches[1]));

                        ### check number of pipes in each line...

                        $lines= explode("\n", $matches[2]);
                        $line_cells=array();
                        $rest= $matches[3];

                        $last_num_cells=-1;
                        $syntax_failure= false;
                        foreach($lines as $line) {
                            $line= trim($line);
                            if( $line ) {

                                $tmp_cells=array();
                                $line=trim($line);

                                $cells= array_slice(explode("|", $line) , 1, -1);

                                if($last_num_cells == -1) {
                                    $last_num_cells = count($cells);
                                }
                                else if(count($cells) != $last_num_cells) {
                                    $syntax_failure= true;
                                    break;
                                }
                                
                                $cells_clean = array();
                                foreach($cells as $cell_with_pipeplaceholder) {
                                    $cells_clean[] = str_replace($placeholder_for_pipes, '|', $cell_with_pipeplaceholder);
                                }
                                $line_cells[]= $cells_clean;
                            }
                            else{
                                $last_num_cells = -1;
                            }
                        }

                        if(!$syntax_failure) {
                            $blocks_new[]= $keep_previous_block;
                            $blocks_new[]= new FormatBlockTable( str_replace($placeholder_for_pipes, '|', $line_cells) );
                            $text= $rest;
                            $found= true;
                        }
                        else {
                            $blocks_new[]= $b;
                            $found= false;
                            break;
                        }
                    }
                    else if($found) {
                        $blocks_new[]= new FormatBlock( str_replace($placeholder_for_pipes, '|', $text));
                        $found= false;
                        $syntax_failure= false;
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
    
    
    static function replacePipesInsideLinks($string, $char){
        $output = '';
        $rest = $string;

        while($rest) {
            if(preg_match("/^(.*?)\[\[([^\]]*)\]\](.*)/s", $rest, $matches)) {
                $pre = $matches[1];
                $inside = $matches[2];
                $rest= $matches[3];
                
                $output.= $pre . '[['. str_replace("|", $char, $inside) . ']]';
            }
            else {
                $output.= $rest;
                $rest = '';
            }
        }
        return $output;
    }
}

function wikiAsHtml($wikitext) {
    
}

function wikifieldAsHtml($item, $field_name=NULL, $args= NULL)
{
    if(is_null($item) || !is_object($item)) {
        trigger_error("Can't render field for null item", E_USER_WARNING);
        return "";        
    }
    
    $editable= $item->isEditable();
    $empty_text = '';

    ### filter params ###
    if($args) {
        foreach($args as $key=>$value) {
            if(!isset($$key) && !is_null($$key) && !$$key==="") {
                trigger_error("unknown parameter",E_USER_NOTICE);
            }
            else {
                $$key= $value;
            }
        }
    }

    measure_start("render_wiki");
    $text= $item->getTextfieldWithUpdateNotes($field_name);
    if(trim($text) == "") {
        $text= $empty_text;
    }
    $text_org = $text;
    $text.="\n";

    ### use conf ###
    $text= asHtml($text);

    ### convert, if id is given ###
    if($item->type == ITEM_PROJECT) {
        $project= $item;
    }
    else {
        $project= Project::getVisibleById($item->project);
    }

    global $g_wiki_project;
    $g_wiki_project= $project;

    $blocks= wiki2blocks($text);

    $str_item_id= is_null($item->id)
                ? ''
                : 'item_id=' . $item->id;


    $str_field  = is_null($field_name)
                ? ''
                : 'field_name=' . $field_name;

    
    $str_editable = $editable
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
    $tmp[]= '<span class="end doClear"> </span></div>';                # end-span to create image-floats

    $out= implode('', $tmp);
    measure_stop("render_wiki");

    return $out;
}

/**
* Automatically add ids or clarifying wiki syntax stuff
*
* Returns:
* - New wiki string if adjustments were necessary
* - NULL if nothing was changed
*
* Notes:
* This works only for the wiki-text directly rendered before with wikifieldAsHtml()
*/
function applyAutoWikiAdjustments($text_org)
{
    global $g_replace_list;

    if(count($g_replace_list)) {
        $adjusted_text= $text_org;
        foreach($g_replace_list as $org => $new) {
            $adjusted_text= str_replace('[['.$org.']]', '[['.$new.']]', $adjusted_text);
        }
        $g_replace_list= array();
        return $adjusted_text;
    }
    else {
        return $text_org;
    }
}

function checkAutoWikiAdjustments() {
    global $g_replace_list;
    return count($g_replace_list);
}

/**
* do actual parsing of wiki text and conversion into blocks
*
* NOTE:
* - g_wiki_project has to be initialized for this function
*/
function wiki2blocks(&$text)
{
    measure_start("wiki2blocks");

    $blocks= array(new FormatBlock($text));

    ### code-blocks ###
    measure_start("blockCode");
    $blocks= FormatBlockCode::parseBlocks($blocks);
    measure_stop("blockCode");

    measure_start("blockTable");
    $blocks= FormatBlockTable::parseBlocks($blocks);
    measure_stop("blockTable");

    measure_start("blockQuote");
    $blocks= FormatBlockQuote::parseBlocks($blocks);
    measure_stop("blockQuote");

    measure_start("blockHeadline");
    $blocks= FormatBlockHeadline::parseBlocks($blocks);
    measure_stop("blockHeadline");

    measure_start("blockChangemarks");
    $blocks= FormatBlockChangemarks::parseBlocks($blocks);
    measure_stop("blockChangemarks");
    
    measure_start("blockLists");
    $blocks= FormatBlockList::parseBlocks($blocks);
    measure_stop("blockLists");
    measure_start("blockLatex");
    $blocks= FormatBlockLatex::parseBlocks($blocks);
    measure_stop("blockLatex");

    $blocks= FormatBlockLeadingSpaces::parseBlocks($blocks);

    $blocks= FormatBlockBold::parseBlocks($blocks);
    $blocks= FormatBlockStrike::parseBlocks($blocks);
    $blocks= FormatBlockSub::parseBlocks($blocks);

    measure_start("blockLink");    
    $blocks= FormatBlockLink::parseBlocks($blocks);
    measure_stop("blockLink");    
    $blocks= FormatBlockHref::parseBlocks($blocks);

    $blocks= FormatBlockLinebreak::parseBlocks($blocks);

    $blocks= FormatBlockHr::parseBlocks($blocks);
    measure_start("blockItemId");    
    $blocks= FormatBlockItemId::parseBlocks($blocks);
    measure_stop("blockItemId");    

    $blocks= FormatBlockMonospaced::parseBlocks($blocks);
    $blocks= FormatBlockEmphasize::parseBlocks($blocks);
    $blocks= FormatBlockLongMinus::parseBlocks($blocks);

    measure_stop("wiki2blocks");

    return $blocks;

}

/**
* returns the wikitext without the outer div
*/
function wiki2purehtml($text, $project=NULL)
{
    global $g_wiki_project;
    $t= $g_wiki_project;

    $text.="\n";
    
    ### convert, if id is given ###
    if($project) {
        if(!is_object($project)) {
            $project= Project::getVisibleById($project);
        }
        $g_wiki_project= $project;
    }

    $text= asHtml($text);
    $blocks = wiki2blocks($text);

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
function getOneWikiChapter($text, $chapter)
{
    $parts= getWikiChapters($text);
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
function getWikiChapters($text)
{
    if(!preg_match("/\n$/s", $text)) {
        $text.= "\n";
    }
    $regex_headlines= array(
        "/(.*?)(\r?==[ \t]*[^\n=]+==\s*\r?\n[ \t]*)(.*)/s",
        "/(.*?)(\r?===[ \t]*[^\n=]+===\s*\n[ \t]*)(.*)/s",
        "/(.*?)([^\r\n]+[\r\n]+===+[ \t]*[\r\n]+)(.*)/s",
        "/(.*?)([^\n\r]+\r?\n---+[\t]*[\r\n]+)(.*)/s",
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