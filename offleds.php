<?php
  // only for development purposes, show errors
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);

  // opens the file that contains the process id
  // of python script that is running the leds sequence
  try {
    $pidfile = 'leds.pid.txt';
    $fp = fopen($pidfile, 'r');
    if(!$fp) {
      die(json_encode(array('result' => false, 'message' => 'error getting pid')));
    }    
    $pid = fread($fp, filesize($pidfile));
    fclose($fp);
  } catch (Exception $e) {
    die(json_encode(array('result' => false, 'message' => $e->getMessage())));
  }

  // it executes a command to kill the process
  try {
    $command = 'sudo kill -9 ' . $pid;
    system($command, $result);
    if($result > 0) {
      die(json_encode(array('result' => false, 'message' => 'error on kill process')));  
    }
  } catch (Exception $e) {
    die(json_encode(array('result' => false, 'message' => $e->getMessage())));
  }

  // it executes a python script that get off all the leds
  try {    
    $command = 'sudo python3 ledsoff.py';
    system($command, $result);    
    if($result > 0) {
      die(json_encode(array('result' => false, 'message' => 'error on turn off leds')));  
    }
  } catch (Exception $e) {
    die(json_encode(array('result' => false, 'message' => $e->getMessage())));
  }

  echo json_encode(array('result' => true));
?>