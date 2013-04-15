<?php
//start.php

//get the time from post/get?
$start_time = time();

//log the timer in cur
$fp = fopen("cur.txt", 'w');
fwrite($fp, $start_time);
fclose($fp);

//log the timer in log.txt
$file_contents = file_get_contents("log.txt");
$fp = fopen("log.txt", 'w');
fwrite($fp, $file_contents . "start:" . $start_time . " ");
fclose($fp);

//redirect to timecard.php
echo "Start Logged: Redirecting";

header( 'Refresh: 1; url=http://www.personal.psu.edu/ajg5353/test/timecard.php' ) ;


?>