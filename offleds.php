<?php
  // only for development purposes, show errors
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);

  // opens the file that contains the process id
  // of python script that is running the leds sequence
  $pidfile = 'leds.pid.txt';
  $fp = fopen($pidfile, 'r');
  $pid = fread($fp, filesize($pidfile));
  fclose($fp);

  // it executes a command to kill the process
  $command = escapeshellcmd('sudo kill -9 ' . $pid);
  exec($command);

  // it executes a python script that get off all the leds
  $command = escapeshellcmd('sudo python3 ledsoff.py');
  exec($command);
?>