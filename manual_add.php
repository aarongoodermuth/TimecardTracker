<html>
<body>
<?php

$MANUAL_ADD_FILE      =     'manual_add.txt';

if(isset($_POST['hours']) && isset($_POST['minutes']) )
{
	$hour = $_POST['hours'];
	$min = $_POST['minutes'];
	
	echo "<p style='color:red'>Added " . sprintf('%2d:%2d', $hour, $min) . ".</p>";
	// then log it
	$cur_time = file_get_contents($MANUAL_ADD_FILE);
	$new_time = $cur_time + 60*60*$hour + 60*$min;
	$fp = fopen($MANUAL_ADD_FILE, 'w');
	fwrite($fp, $new_time);
	fclose($fp);
}
?>

<form action="manual_add.php" method="post">
<p>Hours: <input type="text" name="hours"></input><br /> Minutes: <input type="text" name="minutes"></input><br /><input type="submit" text="Submit"></p>
</form>

<p><a href="timecard.php">Return to Timecard</a></p>

</body>
</html>
