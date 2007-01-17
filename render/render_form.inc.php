<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php5 based project management system  (c) 2005 Thomas Mann / thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
* classes for rendering forms
*
* Usage:<pre>
*
*    $form=new PageForm();
*    $form->add(new Form_checkbox('checkbox_id',"Label",$value));
*    $form->add(new Form_input('input_id','Another label',$other_value));
*
*    ### add all fields of dbItem with view_in_forms==TRUE to form ###
*    foreach($effort->fields as $field) {
*        $form->add($field->getFormElement(&$effort));
*    }
*    echo ($form);
*
*</pre>
*
*
* @includedby  render/render_page.inc
*
* @author     Thomas Mann
* @uses       pageElement
* @usedby     most pages
*/

#====================================================================================
# PageFormElement
#====================================================================================
class PageFormElement extends PageElement{
    public  $name;
    public  $value;
    public  $type;
    public  $title;
    public  $tooltip;
    public  $required;
    public  $invalid;
	public  $id;
	public  $display;
	public  $func;

    PUBLIC function __construct() {
        return;
    }
}



class Form_Captcha extends PageFormElement
{
    public $required=false;

    PUBLIC function __construct($key)
    {
        $this->type=    'input';
        parent::__construct();

        $this->name=    'captcha_input';
        $this->title=   __("Please copy the text");
        $this->value=   $key;
        $this->tooltip= __("Sorry. To reduce the efficiency of spam bots, guests have to copy the text");

    }

    PUBLIC function __toString()
    {
        global $PH;

        $url= $PH->getUrl('imageRenderCaptcha',array('key' => $this->value));

        $buffer= "<p title='$this->tooltip' $this->id $this->display>
            <label>$this->title</label>
            <img src='$url'>

                    <input class='inp captcha' name='$this->name' value=''>
                   </p>";

        return $buffer;
    }
}

/*
*/


class Form_Input extends PageFormElement {
    public $required=false;

    PUBLIC function __construct($name=false, $title="", $value=false, $tooltip=NULL, $required=false, $id="", $display="")
    {
        $this->type='input';
        parent::__construct();
        $this->name=    $name;
        $this->title=   $title;
        $this->value=   $value;
        $this->tooltip= $tooltip;
        $this->required=$required;
		$this->id=      $id;
		$this->display= $display;
    }

    PUBLIC function __toString()
    {
        $str_tooltip= $this->tooltip
                  ? "title='$this->tooltip'"
                  : "";
        $str_required=$this->required
                      ? 'required'
                      : '';
        $str_invalid=$this->invalid
                      ? 'invalid'
                      : '';
        $buffer= "<p $str_tooltip $this->id $this->display><label>$this->title</label><input class='inp $str_required $str_invalid' name='$this->name' value='".htmlspecialchars($this->value, ENT_QUOTES)."'></p>";
        return $buffer;
    }
}


class Page_TabGroup extends PageElement {

    PUBLIC function __construct($name="", $title="")
    {
        parent::__construct();
        $this->name=    $name;
        $this->title=   $title;
    }

    PUBLIC function __toString()
    {


        $buffer='<div class="tabgroup">'
            .'<ul>';

        foreach($this->children as $name=>$c) {
            $buffer.= '<li class="tab_header" id="'. $name. '"><a href="#">'. $c->title.'</a></li>';
        }
        $buffer.='</ul>';

        foreach($this->children as $name=>$c) {
            $buffer.='<div class="tab_body" id="' . $name . '-body">'. $c->render() . '</div>';
        }

        $buffer.='</div>';

        return $buffer;
    }
}


class Page_Tab extends PageElement
{

    PUBLIC function __construct($name="", $title="")
    {
        parent::__construct();
        $this->name=    $name;
        $this->title=   $title;
    }

    PUBLIC function __toString()
    {

        $buffer= '';
        foreach($this->children as $c) {
            $buffer.= $c->render();
        }
        return $buffer;
    }
}





#====================================================================================
# Password
#====================================================================================
class Form_Password extends PageFormElement {

    PUBLIC function __construct($name=false, $title="", $value=false, $tooltip=NULL)
    {
        $this->type='input';
        parent::__construct();
        $this->name=    $name;
        $this->title=   $title;
        $this->value=   $value;
        $this->tooltip= $tooltip;
    }

    PUBLIC function __toString()
    {
        $str_tooltip= $this->tooltip
                  ? "title='$this->tooltip'"
                  : "";

        $style_required =$this->required
                        ? 'required'
                        : '';

        $buffer= "<p $str_tooltip><label>$this->title</label><input class='inp $style_required' type='password' name='$this->name' value='".htmlspecialchars($this->value, ENT_QUOTES)."'></p>";
        return $buffer;
    }
}



#====================================================================================
# HiddenField
#====================================================================================
class Form_HiddenField extends PageFormElement {

    PUBLIC function __construct($name=false, $title="", $value=false, $tooltip=NULL)
    {
        $this->type='input';
        parent::__construct();
        $this->name=    $name;
        $this->title=   $title;
        $this->value=   $value;
    }

    PUBLIC function __toString()
    {
        $buffer= "<input type=hidden name='$this->name' value='$this->value'>";
        return $buffer;
    }
}



class Form_DateTime extends PageFormElement
{
    PUBLIC function __construct($name=false, $title="", $value=false, $tooltip=NULL)
    {
        $this->type='datetime';
        parent::__construct();
        $this->name=    $name;
        $this->title=   $title;
        $this->value=   $value;
        $this->tooltip= $tooltip;
    }

    PUBLIC function __toString()
    {

        $value_date= "-";
        $value_time= "-";



        if($this->value != "0000-00-00 00:00:00" && $this->value != "0000-00-00" ) {

            $time= strToClientTime($this->value);

            /**
            * if strToClientTime fails, use try mySQL
            */
            if($time < 0 || $time==false) {
                $str_array=mysqlDatetime2utc($this->value);
                $str= $str_array['year']  ."-".
                        $str_array['mon'] .'-'.
                        $str_array['day'] ." ".
                        $str_array['hour'].":".
                        $str_array['min']  .":".
                        $str_array['sec'];
                $time= strToClientTime($str);
            }

            /**
            * @@@ this format must be parsable by jsCalendar
            */
            if($time != -1) {
                $value_date= gmdate("D, d.m.Y",$time);
                $value_time= gmdate("H:i",$time);
            }
        }
        else {
            $time = 0;
        }

        $label=isset($this->title)
            ? $this->title
            : ucwords(str_replace('_',' ',$this->name));
        $tooltip= isset($this->tooltip)
            ? "title='$this->tooltip'"
            :  ucwords($this->name);

        $field_id= $this->name;

        $buffer= "<p $tooltip class=datetime>"
            ."<label>$label</label>"
            ."<input class=inp_date id='{$field_id}_date' name='{$field_id}_date' value='$value_date'>"
            ."<span class=button_calendar id='trigger_{$field_id}_date'>...</span>"

            ."<input class=inp_time id='{$field_id}_time' name='{$field_id}_time' value='$value_time'>"
            ."<span class=slider_time id='drag_{$field_id}' >&nbsp;&nbsp;</span>"
            ."</p>"
            ."<script>"
            ."DragSlider.init('drag_{$field_id}','{$field_id}_time','time');
              Calendar.setup(
                {
                  inputField  : \"{$field_id}_date\",         // ID of the input field
                  ifFormat    : \"%a, %d.%m.%Y\",    // the date format
                  button      : \"trigger_{$field_id}_date\"       // ID of the button
                }
              );"
            ."</script>";

        return $buffer;
    }
}

#====================================================================================
# Date
#====================================================================================
class Form_Date extends PageFormElement {

    PUBLIC function __construct($name=false, $title="", $value=false)
    {
        $this->type='date';
        parent::__construct();
        $this->name=    $name;
        $this->title=   $title;
        $this->value=   $value;
    }

    PUBLIC function __toString()
    {
        $str_value=$this->value;
        if($str_value=="0000-00-00") {
            $str_value="-";
        }


        $buffer= "<p class=datetime >"
            ."<label>$this->title</label>"
            ."<input class=inp_date name='$this->name' id='$this->name' value='$str_value'>"
            ."<span class=button_calendar id='trigger_{$this->name}'>...</span>"
            ."</p>";

        $buffer.="<script type=\"text/javascript\">
          Calendar.setup(
            {
              inputField  : \"$this->name\",         // ID of the input field
              ifFormat    : \"%a, %d.%m.%Y\",    // the date format
              button      : \"trigger_{$this->name}\"       // ID of the button
            }
          );
          DragSlider('drag_{$this->name}','{$this->name}');
        </script>" ;
        return $buffer;
    }
}

#====================================================================================
# Time
#====================================================================================
class Form_Time extends PageFormElement {

    PUBLIC function __construct($name=false, $title="", $value=false)
    {
        $this->type='time';
        parent::__construct();
        $this->name=    $name;
        $this->title=   $title;
        $this->value=   $value;
    }

    PUBLIC function __toString()
    {
        $str_value=$this->value;
        if($str_value=="0000-00-00" || $str_value=="00-00-00") {
            $str_value="-";
        }

        $tooltip= isset($field->tooltip)
            ? "title='$this->tooltip'"
            :  ucwords($this->name);

        $buffer= "<p $tooltip class=datetime>"
            ."<label>$this->title</label>"
            ."<input class=inp_time id='{$this->name}' name='{$this->name}' value='$str_value'>"
            ."<span class=slider_time id='drag_{$this->name}' >%</span>"
            ."</p>"
            ."<script>"
            ."DragSlider.init('drag_{$this->name}','{$this->name}','time');
            </script>
            ";


        return $buffer;
    }
}

#====================================================================================
# Form_Edit
#====================================================================================
class Form_Edit extends PageFormElement {

    public $rows;
    PUBLIC function __construct($name=false, $title="", $value=false, $tooltip=NULL, $rows=5)
    {
        $this->type='edit';
        parent::__construct();
        $this->name=    $name;
        $this->title=   $title;
        $this->value=   $value;
        $this->rows= $rows;
    }

    PUBLIC function __toString()
    {
        global $PH;
        $hint= "<span class=hint_wiki_syntax><br>(". $PH->getWikiLink('WikiSyntax', __('Wiki format')).")</span>";

        $buffer= "<p><label>$this->title $hint</label><textarea rows=$this->rows name='$this->name'>".htmlspecialchars($this->value, ENT_QUOTES)."</textarea></p>"

        ;
        return $buffer;
    }
}

#====================================================================================
# Form_Dropdown
#====================================================================================
class Form_Dropdown extends PageFormElement {

    private $options;

    PUBLIC function __construct($name=false, $title="", $options=array(), $value=false, $id="", $display="")
    {
        $this->type='dropdown';
        parent::__construct();
        $this->name=    $name;
        $this->title=   $title;
        $this->value=   $value;
		$this->id=      $id;
		$this->display= $display;
        $this->options=$options;
        $this->options=$options
            ? $options
            :array();
    }

    PUBLIC function __toString()
    {
        $buffer= "<p $this->id $this->display><label>$this->title</label>";
        $buffer.="<select size=1 name='$this->name' id='$this->name'>";
        foreach($this->options as $key=>$value) {
            $str_selected= ($this->value==$value)
                 ? "selected='selected'"
                 :"";

            $buffer.='<option ' . $str_selected .' value="' . asHtml($value) . '" >' . asHtml($key) . '</option>';
        }
        $buffer.="</select></p>";
        return $buffer;
    }
}

#====================================================================================
# Form_Checkbox
#====================================================================================
class Form_Checkbox extends PageFormElement {

    private $options;
    public  $checked;

    PUBLIC function __construct($name=false, $title="", $checked=0, $func="", $value=NULL)
    {
        $this->type='checkbox';
        parent::__construct();
        $this->name     = $name;
        $this->title    = $title;
        $this->value    = $value;                             # add additional value parameter
		$this->func     = $func;                              # to add javascript functions
		$this->checked  = $checked;
    }

    PUBLIC function __toString()
    {
        $checked = $this->checked
            ? 'checked'
            : '';

        $str_value= (!is_null($this->value))
                  ? "value='{$this->value}'"
                  : '';

        $buffer= "<p>";
        $buffer.="<span class=checker><input type='checkbox' id='$this->name' name='$this->name' $str_value $this->func $checked><label for='$this->name'>$this->title</label></span>";
        $buffer.="</p>";
        return $buffer;
    }
}


/**
* add readable text to the form, e.g. to provide additional help
* on what fields are about.
*
* The text is NOT converted to html. You have to use asHtml to
* convert it before.
*/
class Form_Text extends PageFormElement
{

	private $html = '';

    PUBLIC function __construct($html, $name="")
    {
        $this->type     = 'html';
		$this->name     = $name;
        parent::__construct();
        $this->html     = $html;
    }

    PUBLIC function __toString()
    {
        return "<p class=text>" . $this->html . "</p>";
    }
}


class Form_CustomHTML extends PageFormElement {

	private $html = '';

    PUBLIC function __construct($html='',$name=false)
    {
        $this->type='html';
		$this->name=$name; ## changed ##
        parent::__construct();
        $this->html=  $html;
    }

    PUBLIC function __toString()
    {
        return $this->html;
    }
}






/**
* PageForm
*
* - holds a list of controls (like input-fields, buttons, etc.)
* - it does not render the actuall form-tag (which is done in render_page.inc)
*   the action of the major-form is always just index.php method POST
* - the target is given by go
*
*/
class PageForm extends PageElement
{
    public  $button_cancel= false;    # set to true to render
    public  $button_apply= false;     # set to true to render
    public  $button_submit= "Submit";

    public  $form_options=array();  # currently a list of html-snips

    PUBLIC function __construct()
    {
        $this->children=array();

        /**
        * NOTE:
        * - adding the edit_request_time as form hidden field would
        *   cause additional entries in the from-handle file. So we
        *   add it as a none checked field.
        */
        echo "<input type=hidden name=edit_request_time value='" . time(). "'>";
        $this->button_submit= __("Submit");
        parent::__construct();
    }

    PUBLIC function __toString()
    {
        $buffer= "<div class=form>";

        $hidden= array();
        foreach($this->children as $key=>$field) {
            if($field instanceof Form_HiddenField) {
                $hidden[$field->name]= $field->value;
            }
            $buffer.=$field->render();
        }

        ### if logged in, add crc-checksum for hidden fields ###
        global $auth;
        if(isset($auth->cur_user)) {
            global $PH;
            $handle_for_hidden_values= $PH->defineFromHandle($hidden);
            echo "<input type=hidden name=hidden_crc value='$handle_for_hidden_values'>";
        }


        $buffer.="<div class=formbuttons>";

        ### form options ###
        if($this->form_options) {
            $buffer .="<div class=formoptions>";
            foreach($this->form_options as $fo) {
                $buffer.= $fo;
            }
            $buffer .="</div>";
        }


        ### form - buttons ###
        if($str= $this->button_cancel) {
            if(!is_string($str)) {
                $str=__('Cancel');
            }
            $buffer.= "<input class='button cancel' tabindex='200' type=button value='$str' onclick=\"javascript:document.my_form.form_do_cancel.value='1';document.my_form.submit();\">";
            $buffer.= "<input type=hidden name=form_do_cancel value=0>";


        }

        if($str= $this->button_apply) {
            if(!is_string($str)) {
                $str=__('Apply');
            }
            $buffer.= "<input class='button apply'  type=button value='$str' onclick=\"javascript:document.my_form.form_do_apply.value='1';document.my_form.submit();\">";
            $buffer.= "<input type=hidden name=form_do_apply value=0>";
        }

        if($str= $this->button_submit) {
            $buffer.= "<input class='button submit' type=submit value='$str'>";        #@@@ add correct style h
        }

        $buffer.="</div>";

        $buffer.="</div>";
        return $buffer;
    }


    PUBLIC function addCaptcha()
    {
        $key= substr( md5(microtime()), 0,5);
        $this->add(new Form_Captcha( $key ));
        $this->add(new Form_HiddenField('captcha_key', '', $key));

    }
}

?>