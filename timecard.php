<?php

$temp_file = "cur.txt";
$not_running_file_contents = "not running";
$file_contents = file_get_contents($temp_file);
$output_file_contents = "bug found";

if(0 == strcmp($file_contents, $not_running_file_contents))
{
	$output_file_contents = file_get_contents("start.html");
}
else
{
	$output_file_contents = file_get_contents("stop.html");
}


echo $output_file_contents;


?>