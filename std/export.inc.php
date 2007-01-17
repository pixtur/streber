<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php5 based project management system  (c) 2005 Thomas Mann / thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
 * Export
 *
 *
 * @author: Esther Burger
 * @uses
 * @usedby
 *
 */

function exportToCSV($header, $content)
{
    global $PH;
    $pagename= $PH->cur_page_id;

    #header('Content-Type: text/plain');
	header('Content-Type: text/csv; charset=utf-8');
	#header('Content-Type: text/csv; charset=iso-8859-15');
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Content-Disposition: attachment; filename=' . $pagename . '.csv');
	header('Pragma: no-cache');

	$export = "";
	$num_col = count($header);
	$len = count($content);

	## build export-string ##
	foreach($header as $key => $value){
		$str = $value;
		$str = iconv("utf-8", "iso-8859-15//TRANSLIT", $str); /* necessary for German characters like ä and ß*/
		$export .= "" . $str . ";";
	}

	$export .= "\r\n";

	for($i = 1; $i < $len; $i++)
	{
		if(fmod($i, $num_col) == 0){
			$str = $content[$i-1];
			$str = iconv("utf-8", "iso-8859-15//TRANSLIT", $str); /* necessary for German characters like ä and ß*/
			$export .= "" . $str . ";\r\n";
		}
		else{
			$str = $content[$i-1];
			$str = iconv("utf-8", "iso-8859-15//TRANSLIT", $str); /* necessary for German characters like ä and ß*/
			$export .= "" . $str . ";";
		}
	}

	$export .= "\r\n";


	echo $export;
}

?>
