TimecardTracker
================

Provides a web interface for "punching in" and "punching out" and logs how much time has yet to be worked

Note
===============

This is not the best impementation. A better implementation would iclude a database.

I also have several additional ideas for this that include:
  
  -- multiple user support
  
  -- multiple projects for a user
  
  -- more configurability
  
  -- more helpful log info
  
  -- more than just a web interface (mobile)

In the meantime, anyone is free to use this code and free to make their own modifications and improvements. 

Installation
=================

Put all of these files into the same directory on a web server

Navigate to timecard.php

Known Issues
===================

  --  Time yet to work breaks on the new year rollover (solution: reset log.txt to blank, cur.txt to 'not running', manual_add.txt to 0)
