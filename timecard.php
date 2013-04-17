<?php

/***************/
/** CONSTANTS **/
/***************/

$PAGENAME                 =     'timecard.php';
$MANUAL_ADD_PAGE          =     'manual_add.php';
$SHOW_TABLE_PAGE          =     'show_table.php';
$STATE_FILE               =     'cur.txt';
$LOG_FILE                 =     'log.txt';
$NOT_RUNNING_STATE        =     'not running';

/*******************/
/** END CONSTANTS **/
/*******************/

//-----------------------------------------------------------------------------

/***************/
/** FUNCTIONS **/
/***************/

// prints the html header
// (void)
function print_header()
{
  echo '<html><body>';
}

// prints the html footer
// (void)
function print_footer()
{
  echo '</body></html>';
}

// prints the start page
// (void)
function print_start($messege)
{
  global $PAGENAME, $MANUAL_ADD_PAGE, $SHOW_TABLE_PAGE;
  print_header();
  echo $messege;
  echo '<h2 style="text-align:center">Timecard Start</h2>
        <div >
        <center>
        <button onclick="window.location.href=\'' . $PAGENAME . '?next_state=start\'">Start</button>
        <button onclick="window.location.href=\'' . $MANUAL_ADD_PAGE . '\'">Manual Add</button>
        <button onclick="window.location.href=\'' . $SHOW_TABLE_PAGE . '\'">Show Table</button>
        </center></div>';
  print_footer();
}

// prints the stop page
// (void)
function print_stop($messege)
{
  global $PAGENAME, $MANUAL_ADD_PAGE, $SHOW_TABLE_PAGE;
  print_header();
  echo $messege;
  echo '<h2 style="text-align:center">Timecard Stop</h2>
        <div>
        <center>
        <button onclick="window.location.href=\'' . $PAGENAME . '?next_state=stop\'">Stop</button>
        <button onclick="window.location.href=\'' . $MANUAL_ADD_PAGE . '\'">Manual Add</button>
        <button onclick="window.location.href=\'' . $SHOW_TABLE_PAGE . '\'">Show Table</button>
        </center></div>';
  print_footer();
}

// returns whether the state conflicts with the expected state
// (boolean)
function check_state_conflict($expected)
{
  global $STATE_FILE;

  // get current state
  $cur_state = trim( file_get_contents($STATE_FILE) );

  if($cur_state === $expected)
  {
    return false;
  }
  else
  {
    return true;
  }
}

// converts number of seconds into HH:MM:SS
// (string)
function convert_time($total)
{
  return sprintf('%2d:%2d:%2d', intval($total/3600), intval($total/60) % 60, $total % 60);
}

// records the start time in the state file and in the log
// (void)
function start()
{
  global $STATE_FILE, $LOG_FILE;

  $start_time = time();
   
  // log the timer in STATE_FILE
  $fp = fopen($STATE_FILE, 'w');
  fwrite($fp, $start_time);
  fclose($fp);
}

// records the start time in the log and recoreds duration info in the log as well
// (void)
function stop()
{
  global $STATE_FILE, $LOG_FILE, $NOT_RUNNING_STATE;

  $stop_time = time();
  
  // get the start time from STATE_FILE
  $start_time = file_get_contents($STATE_FILE);
  $duration = $stop_time - $start_time;
  
  // log the timer in STATE_FILE
  $start_time = file_get_contents($STATE_FILE);
  $fp = fopen($STATE_FILE, 'w');
  fwrite($fp, $NOT_RUNNING_STATE);
  fclose($fp);
  
  // log the timer in LOG_FILE
  $file_contents = file_get_contents($LOG_FILE);
  $fp = fopen($LOG_FILE, 'w');
  if(filesize($LOG_FILE) > 1)
  {
    fwrite($fp, $file_contents . 'start:' . $start_time . ' stop:' . $stop_time . ' duration:' . $duration . ' week:' . date('W') . '\n');
  }
  else
  {
    fwrite($fp, 'start:' . $start_time . ' stop:' . $stop_time . ' duration:' . $duration . ' week:' . date('W') . "\n");
  }
  fclose($fp);
}

/*******************/
/** END FUNCTIONS **/
/*******************/

//-----------------------------------------------------------------------------

/**************/
/** PHP CODE **/
/**************/

$get_check = false;

if(isset($_GET['next_state']))
{
  $get_check = $_GET['next_state'];
}

if($get_check === 'start') // GET is start
{
  // check to make sure does not conflict
  if(check_state_conflict($NOT_RUNNING_STATE))
  {
    header('refresh:0; url=' . $PAGENAME );
  }
  else
  {
    // log the start
    start();
   
    //show the start
    print_stop('<p style="color:red">Start logged at ' . date("m/d/Y h:i:s a", time()) . '</p>');
  }
}
else if($get_check === 'stop') // GET is stop
{
  // check to make sure does not conflict
  if(!check_state_conflict($NOT_RUNNING_STATE))
  {
    header('refresh:0; url=' . $PAGENAME );
  }
  else
  {
    // log the stop
    $duration = time() - intval(file_get_contents($STATE_FILE));
    stop();
  
    print_start('<p style="color:red">Stop logged at ' . date("m/d/Y h:i:s a", time()) . '</p>'
               . '<p style="color:red">Time recorded: ' . convert_time($duration) . '</p>');
  }
}
else // no GET
{
  // check the current state
  $cur_state = trim( file_get_contents($STATE_FILE) );

  // show relevant page
  if($cur_state === $NOT_RUNNING_STATE)
  {
    print_start('');
  }
  else
  {
    print_stop('');
  }
}

/******************/
/** END PHP CODE **/
/******************/

//-----------------------------------------------------------------------------
?>
