<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php5 based project management system  (c) 2005 Thomas Mann / thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * classes related to profiling and measuring time
 *
 * called from: index.php
 *
 *
 * @author: Thomas Mann
 * @uses:
 * @usedby:
 *
 */



/**
* some global vars
*/
$measure_times=array();
$measure_counts=array();
$measure_times_started=array();
$time_total=1;

/**
* start measure time with an id
*/
function measure_start($id) {
    global $measure_times_started;
    global $measure_counts;
    global $measure_times;
    if(!isset($measure_times_started[$id])) {
        $measure_times_started[$id]=microtime(1);
    }
    if(isset($measure_counts[$id])) {
        $measure_counts[$id]++;
    }
    else {
        $measure_counts[$id]=1;
    }
    if(!isset($measure_times[$id])) {
        $measure_times[$id]=0;
    }
}

/**
* stop measuring a time with an id
*/
function measure_stop($id){
    global $measure_times_started;
    global $measure_times;
    if($tmp= @$measure_times_started[$id]) {
        $time=microtime(1) - $tmp;
        if(@$measure_times[$id]) {
            if($time>0) {
                $measure_times[$id]+=$time;
            }
        }
        else {
            $measure_times[$id]=$time;
        }
    }
    unset($measure_times_started[$id]);
}

/**
* render and return a table with the measured ids
*/
function render_measures() {
    global $measure_times;
    global $measure_counts;
    global $time_total;
    measure_stop('time_complete');
    $buffer='<table>';
    foreach($measure_times as $key=>$time) {
        $width= round($time/$time_total*100,0)."px";
        $time_ms=round($time*1000,0);
        $buffer.="<tr>";
        $buffer.=
            "<td>$key </td>".
            "<td>$time_ms</td>".
            '<td><img src="themes/'.getCurTheme().'/img/pixel.gif" style="height:3px;width:'.$width.'; background-color:#f00;"></td>';
        $buffer.="</tr>";
    }
    $buffer.='</table>';
    return $buffer;
}
?>