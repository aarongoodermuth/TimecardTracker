<?php

// this file feels a little hacky, but it still works, and I do not know what 
//    I want it to look like, so refactoring will have to wait

header( 'Refresh: 60; url=show_table.php' ) ;


//Constants
$HOURS_PER_WEEK     =  19;
$LOG_FILE           =  'log.txt';
$MANUAL_ADD_FILE    =  'manual_add.txt';
$STATE_FILE         =  'cur.txt';
$NOT_RUNNING_STATE  =  'not running';

//read LOG_FILE
$file = file_get_contents($LOG_FILE);

//read MANUAL_ADD_FILE
$manual_add = file_get_contents($MANUAL_ADD_FILE);

//read STATE_FILE
$cur = file_get_contents($STATE_FILE);


//parse LOG_FILE
$line = explode("\n", $file);

$total = $manual_add;
for($i=0; $i<count($line)-1; $i++)
{
	
	//parse up line parts
	$line_parts = explode(" ", $line[$i]);
	
	$start[$i] = $line_parts[0];
	$stop[$i] = $line_parts[1];
	$duration[$i] = $line_parts[2];
	$week_num[$i] = $line_parts[3];
	
	// parse out the title in the variables
	$duration[$i] = substr($duration[$i], strpos($duration[$i], ":") + 1);
	$stop[$i]     = substr($stop[$i],     strpos($stop[$i],     ":") + 1);
	$start[$i]    = substr($start[$i],    strpos($start[$i],    ":") + 1);
	$week_num[$i] = substr($week_num[$i],    strpos($week_num[$i], ":") + 1);
	
	$total = $total + $duration[$i];

	$seconds[$i] = $duration[$i] % 60;
	$minutes[$i] = (($duration[$i] - $seconds[$i]) / 60) % 60;
	$hours[$i] = ($duration[$i] - 60*$minutes[$i] - $seconds[$i]) / 3600; 
	//echo $i+1  . ":    Hours: " . $hours[$i] . " Minutes " . $minutes[$i] . " Seconds: " . $seconds[$i] . "<br>";
}

if((strcmp($cur, $NOT_RUNNING_STATE)))
{
	$total = $total + time() - (int)$cur;
}


$first_week = $week_num[0];	//assume the first log entry is the first week we have
$total_needed = 60 * 60 *(date("W") - $first_week + 1) * $HOURS_PER_WEEK; //total number of seconds needed to be logged

$delta = $total_needed - $total;
$delta_seconds = $delta % 60;
$delta_minutes = (($delta - $delta_seconds) / 60) % 60;
$delta_hours = ($delta - 60*$delta_minutes - $delta_seconds) / 3600; 

$total = $HOURS_PER_WEEK*60*60 - $delta;

$total_seconds = $total % 60;
$total_minutes = (($total - $total_seconds) / 60) % 60;
$total_hours = ($total - 60*$total_minutes - $total_seconds) / 3600;

echo "Need to Work:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $delta_hours." : ".$delta_minutes." : ".$delta_seconds. "<br>";
echo "Time Worked This Week:&nbsp;&nbsp;&nbsp;&nbsp;" . $total_hours . " : " . $total_minutes . " : " . $total_seconds . "<br>";

//format table
$table = 
"<br><br><br><center><table border='1' width='100%' style='border-style:solid;'>
<thead><td>Start Time</td><td>Stop Time</td><td>Duration</td></thead>";

for($i = 0; $i<count($start); $i++)
{
	$table = $table . "<tr><td>" . $start[$i] . "</td><td>" . $stop[$i] . "</td><td>" . $duration[$i] . "</td></tr>\n";
}

$table = $table . "<tr><td>" . "manual add" . "</td><td>" . "manual add" . "</td><td>" . $manual_add . "</td></tr>\n";
$table = $table . "</table></cent>";

$go_back_button = 
"<br><br><br>
<div><center>
<button onclick='window.location=\"timecard.php\"'>
Go Back!
</button>
</center></div>
";

echo $go_back_button;

echo $table;

?>
