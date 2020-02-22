<?php

/* Check if file exists and is writable */
$curr_dir = dirname(__FILE__).'/../..';
include("$curr_dir/defaultLang.php");
include("$curr_dir/language.php");
include("$curr_dir/lib.php");
$file_path = "$curr_dir/ajax_combo.php";

$location=0;
$ajax_combo = @file_get_contents($file_path);
if (!filesize($file_path)>0){
    if(!$ajax_combo) die('{ "error": "Error Unable to access ajax_" }');
}

/* Find extras function */
$search = "/(return json)/" ;
preg_match_all($search, $ajax_combo, $matches, PREG_OFFSET_CAPTURE);
if(count($matches) < $location + 1) die('{ "error": "Could not determine correct function location_1" }');
$end = $matches[0][0][1] - 9 ;

/* Find extras function */
$search = '/(drop-downs config)/' ;
preg_match_all($search, $ajax_combo, $matches, PREG_OFFSET_CAPTURE);
if(count($matches) < $location + 1) die('{ "error": "Could not determine correct function location_2" }');
$start = $matches[0][0][1];

$get_function_code = substr($ajax_combo, $start-3, $end-$start);

eval($get_function_code);

$prepared_data = [];

			$res = sql($combo->Query, $eo);
			while($row = db_fetch_row($res)){
				$prepared_data[] = "\"".to_utf8($row[0])."\":\"". to_utf8($xss->xss_clean($row[1]))."\"";
			}

header('Content-type: application/json');

/* return json */
echo json_encode('{'.implode(",",$prepared_data).'}');


