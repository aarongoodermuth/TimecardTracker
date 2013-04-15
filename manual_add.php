<html>
<body>
<?php

//manual_add.php

if(isset($_POST['hours']) && isset($_POST['minutes']) )
{
	$hour = $_POST['hours'];
	$min = $_POST['minutes'];
	
	echo "<p style='color:red'>Added " . $hour . ":" . $min . ".</p>";
	//then do shit
	$cur_time = file_get_contents("manual_add.txt");
	$new_time = $cur_time + 60*60*$hour + 60*$min;
	$fp = fopen("manual_add.txt", 'w');
	fwrite($fp, $new_time);
	fclose($fp);
}
?>

<form action="manual_add.php" method="post">
<p>Hours: <input type="text" name="hours"></input><br /> Minutes: <input type="text" name="minutes"></input><br /><input type="submit" text="Submit"></p>
</form>

<p><a href="http://www.personal.psu.edu/ajg5353/test/timecard.php">Return to Timecard</a></p>

</body>
</html>