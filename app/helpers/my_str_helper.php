<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function sanitizeString($str){	
	$new_str =addslashes( lineBreaksToBr($str));
	return $new_str;
}

function lineBreaksToBr($str){
	//convert linebreaks to <br/> tags
	$order   = array("\r\n", "\n", "\r");// Processes \r\n's first so they aren't converted twice.
	$new_str = str_replace($order, '<br/>', $str);
	return $new_str;
}

function encodeQuot($str){
	$new_str = str_replace('"','&quot;',$str);
	return $new_str;
}

function escapeDbQuot($str){
	$new_str = str_replace('"','\"',$str);
	return $new_str;
}

function addLineBreaks($str){
	//convert linebreaks to <br/> tags
	$new_str = str_replace('<br/>', "<br/>\r\n", $str);
	return $new_str;
}

function removeBreaks($str){
	$new_str1 = str_replace('<br/>', "", $str);
	$new_str2 = str_replace('<br>', "", $new_str1);
	return $new_str2;
}

function contentText($str){
	//adds linebreaks without removing breaks (for prettyprint code) and decodes any special characters for display
	$new_str = addLineBreaks(utf8_decode($str));
	return $new_str;
}

function slugify($str){
	$slug_str = urlencode(str_replace(array(' ','"',"'"), array('-','',''),strtolower($str)));
	return $slug_str;
}

function is_selected($val,$set){
	if($val == $set){
		return 'selected="selected"';
	}
}

function is_active($name,$selected){	
	if($name == $selected)
	{
		return 'class="active"';
	}
}

function randAnswers($question){
	$answers = array();
	$answers[] = $question['answer'];
	$answers[] = $question['wrong_1'];
	if($question['wrong_2'] != '')
	{
		$answers[] = $question['wrong_2'];
	}
	if($question['wrong_3'] != '')
	{
		$answers[] = $question['wrong_3'];
	}
	shuffle($answers);
	return $answers;
}

?>