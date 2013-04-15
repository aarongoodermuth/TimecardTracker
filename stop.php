<?php
//stop.php

//get the time from post/get?
$stop_time = time();

//get the start time from cur
$start_time = file_get_contents("cur.txt");
$duration = $stop_time - $start_time;

//log the timer in cur
$fp = fopen("cur.txt", 'w');
fwrite($fp, "not running");
fclose($fp);



//log the timer in log.txt
$file_contents = file_get_contents("log.txt");//echo $file_contents;
$fp = fopen("log.txt", 'w');
fwrite($fp, $file_contents . "stop:" . $stop_time . " " . "duration:" . $duration . " week:" . date("W") . "\n");
fclose($fp);




//redirect to timecard.php
echo "Stop Logged: Redirecting";

header( 'Refresh: 1; url=http://www.personal.psu.edu/ajg5353/test/timecard.php' ) ;


?>