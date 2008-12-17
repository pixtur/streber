<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * functions related to parsing field-times to forms and parse form-params into db-format
 *
 *
 * for rendering as HTML see render/render_form.inc
 *
 * included by: db/db_item.inc
 *
 * @author Thomas Mann
 * @uses:
 * @usedby:
 *
 */


#====================================================================================
function FieldString_getFormElement(&$field,&$obj, $title= NULL) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    $required= isset($field->required);
    if($title === NULL) {
        $title= $field->title;
    }

    $f=new Form_Input($field_id, $title, $obj->$name, $field->tooltip, $required);
    if($field->invalid) {
        $f->invalid= true;
    }
    return $f;
}

function FieldString_parseForm(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    $value=get($field_id);

    if($value || $value==="" || $value===FALSE) {
        $obj->$name= $value;
    }
}

#====================================================================================
function FieldPassword_getFormElement(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;

    return new Form_Password($field_id, $field->title, $obj->$name, $field->tooltip);
}

function FieldPassword_parseForm(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    $value=get($field_id);
    if($value || $value==="" || $value===FALSE) {
        $obj->$name= $value;
    }
}



#====================================================================================
function FieldInt_getFormElement(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    return new Form_Input($field_id, $field->title, $obj->$name, $field->tooltip);
}

function FieldInt_parseForm(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    $value=get($field_id);
    if(!is_null($value)) {
        $obj->$name= $value;
    }
}

#====================================================================================
function FieldPercentage_getFormElement(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    return new Form_Input($field_id, $field->title, $obj->$name, $field->tooltip);
}

function FieldPercentage_parseForm(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    $value=get($field_id);
    if(!is_null($value)) {
        $obj->$name= $value;
    }
}

#====================================================================================
function FieldBool_getFormElement(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    return new Form_Checkbox($field_id, $field->title, $obj->$name, $field->tooltip);
}

/**
* Bug/ToDo
* there is no way to see wether a checkbox was turned of or not rendered in the form.
* The option will always be turned off !!
*/
function FieldBool_parseForm(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;

    if(get($field_id . "_was_checkbox")) {
        if(get($field_id)=="on") {
            $obj->$name= 1;
        }
        else {
            $obj->$name= 0;
        }
    }
}


#====================================================================================

function FieldText_getFormElement(&$field,&$obj,$title=NULL, $height=5) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;

    if($title === NULL) {
        $title= $field->title;
    }

    return new Form_Edit($field_id, $title, $obj->$name, $field->tooltip,$height);
}

function FieldText_parseForm(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    $value=get($field_id);
    if($value || $value==="") {
        $obj->$name= $value;
    }
}

#====================================================================================
function FieldDatetime_getFormElement(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;

    return new Form_DateTime($field_id, $field->title, $obj->$name, $field->tooltip);
}

function FieldDatetime_parseForm(&$field,&$obj) {

    $name= $field->name;


    $field_id= $obj->_type.'_'.$name;

    $value_date=get($field_id.'_date');
    if($value_date ==="" || $value_date ==="-") {
        $value_date="0000-00-00";
    }

    $value_time=get($field_id.'_time');
    if($value_time==="" || $value_time=== "-") {
        $value_time="00:00:00";
    }

    if($value_date && $value_time) {
        $value= $value_date." ". $value_time;

        # dd.mm.yyyyy hh:mm:ss
        if(
            preg_match("/\b(\d?\d)[^\d](\d?\d)[^\d](\d\d\d\d)\s+(\d\d)[^\d](\d?\d)[^\d](\d?\d)\b/",$value,$matches)
            && count($matches)==7
        ) {
            $value=$matches[3].'-'.$matches[2].'-'.$matches[1] .' '. $matches[4] .':'. $matches[5] .':'. $matches[6];
        }
        # yyyy-mm-dd hh:mm:ss
        else if(
            preg_match("/\b(\d\d\d\d)[^\d](\d?\d)[^\d](\d?\d)\s+(\d\d)[^\d](\d\d)[^\d](\d\d)\b/",$value,$matches)
            && count($matches)==7
        ) {
            # $value=$value;        # just fine...
        }
        # Thursday, January 01, 1970 01:00:00
        else if(
            preg_match("/(\w*)\s(\d\d),\s*(\d\d\d\d)\s+(\d\d)[^\d](\d\d)[^\d](\d\d)/i", $value, $matches)
            && count($matches)==7
            && $mon=string2month($matches[1])
        ) {
            $value=$matches[3].'-'.$mon.'-'.$matches[2] .' '. $matches[4] .':'. $matches[5] .':'. $matches[6];
        }
        # Thursday, January 01, 1970 01:00
        else if(
            preg_match("/(\w*)\s(\d\d),\s*(\d\d\d\d)\s+(\d\d)[^\d](\d\d)/i", $value, $matches)
            && count($matches)==6
            && $mon=string2month($matches[1])
        ) {
            $value=$matches[3].'-'.$mon.'-'.$matches[2] .' '. $matches[4] .':'. $matches[5] .':00';
        }
        # Thursday, January 01, 1970
        else if(
            preg_match("/(\w*)\s(\d\d),\s*(\d\d\d\d)/i", $value, $matches)
            && count($matches)==4
            && $mon=string2month($matches[1])
        ) {
            $value=$matches[3].'-'.$mon.'-'.$matches[2] .' 00-00-00';
        }
        # Donnerstag, 30. Novemeber 1970 12:12:00
        else if(
            preg_match("/(\d?\d)\.\s*(\w*)\s*(\d\d\d\d)\s+(\d\d)[^\d](\d\d)[^\d](\d\d)/i", $value, $matches)
            && count($matches)==7
            && $mon=string2month($matches[2])
        ) {
            $value=$matches[3].'-'.$mon.'-'.$matches[1] .' '. $matches[4] .':'. $matches[5] .':'. $matches[6];
        }

        # Tue, 31.12.2001 12:12:00
        else if(
            preg_match("/(\d\d)\.\s*(\d\d)\.\s*(\d\d\d\d)\s+(\d\d)[^\d](\d\d)[^\d](\d\d)/i", $value, $matches)
            && count($matches)==7
        ) {
            $value=$matches[3].'-'.$mon.'-'.$matches[1] .' '. $matches[4] .':'. $matches[5] .':'. $matches[6];
        }

        # Tue, 31.12.2001 12:12
        else if(
            preg_match("/(\d\d)\.\s*(\d\d)\.\s*(\d\d\d\d)\s+(\d?\d)[^\d](\d?\d)/i", $value, $matches)
            && count($matches)==6
        ) {
            $value=$matches[3].'-'.$matches[2].'-'.$matches[1] .' '. $matches[4] .':'. $matches[5] .':00';
        }


        else {
            new FeedbackMessage(sprintf(__("<b>%s</b> is not a known format for date."), $value));
            $value="0000-00-00 00:00:00";
        }

        global $auth;

        if($value != "0000-00-00 00:00:00") {
            $value= clientTimeStrToGMTString($value);
        }

        $obj->$name= $value;
    }
}

#====================================================================================
function FieldDate_getFormElement(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    return new Form_Date($field_id, $field->title, $obj->$name, $field->tooltip);
}

function FieldDate_parseForm(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    $value=get($field_id);
    if($value || $value==="") {

        # dd.mm.yyyyy
        if($value=="" ||$value == "-" ) {
            $value="0000-00-00";
        }
        else if(
            preg_match("/\b(\d?\d)[^\d](\d?\d)[^\d](\d\d\d\d)/",$value,$matches)
            && count($matches)==4
        ) {
            $value=$matches[3].'-'.$matches[2].'-'.$matches[1];
        }
        # yyyy-mm-dd
        else if(
            preg_match("/\b(\d\d\d\d)[^\d](\d?\d)[^\d](\d?\d)\b/",$value,$matches)
            && count($matches)==4
        ) {
            # $value=$value;        # just fine...
        }
        # Thursday, January 01, 1970
        else if(
            preg_match("/(\w*)\s(\d\d),\s*(\d\d\d\d)/i", $value, $matches)
            && count($matches)==4
            && $mon=string2month($matches[1])
        ) {
            $value=$matches[3].'-'.$mon.'-'.$matches[2];
        }
        # Thursday, January 01, 1970
        else if(
            preg_match("/(\w*)\s(\d\d),\s*(\d\d\d\d)/i", $value, $matches)
            && count($matches)==4
            && $mon=string2month($matches[1])
        ) {
            $value=$matches[3].'-'.$mon.'-'.$matches[2];
        }
        # Donnerstag, 30. Novemeber 1970 12:12:00
        else if(
            preg_match("/(\d?\d)\.\s*(\w*)\s*(\d\d\d\d)/i", $value, $matches)
            && count($matches)==4
            && $mon=string2month($matches[2])
        ) {
            $value=$matches[3].'-'.$mon.'-'.$matches[1];
        }
        else {
            if($value != "-") {
                new FeedbackMessage(sprintf(__("<b>%s</b> is not a known format for date."), $value));
                $value="0000-00-00";
            }
        }
        $obj->$name= $value;
    }
}




#====================================================================================
function FieldHidden_getFormElement(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    return new Form_HiddenField($field_id, $field->title, $obj->$name, $field->tooltip);
}

function FieldHidden_parseForm(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    $value=get($field_id);
    if(!is_null($value)) {
        $obj->$name= $value;
    }
}

#====================================================================================
/**
* if rendered at all (off by default) internal fields are rendered as HiddenField
*/
function FieldInternal_getFormElement(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    return new Form_HiddenField($field_id, $field->title, $obj->$name);
}

function FieldInternal_parseForm(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    $value=get($field_id);
    if(!is_null($value)) {
        $obj->$name= $value;
    }
}
#====================================================================================
function FieldUser_getFormElement(&$field,&$obj) {
    return new Form_CustomHtml("");
}

function FieldUser_parseForm(&$field,&$obj) {
    $pass=true;
}


#====================================================================================
function FieldOption_getFormElement(&$field,&$obj) {
    return new Form_CustomHtml("");
}
/*
 todo: - add options-attribute to field
*/
/*function FieldOption_getFormElement(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type.'_'.$name;
    return new Form_Option($field_id, $field->title, $obj->$name);
}*/

/**
* Bug/ToDo
* there is no way to see wether a checkbox was turned of or not rendered in the form.
* The option will always be turned off !!
*/
function FieldOption_parseForm(&$field,&$obj) {
    $name= $field->name;
    $field_id= $obj->_type . '_' . $name;

    $value= get($field_id);
    if(isset($value)) {
        $obj->$name= $value;
    }
}

?>