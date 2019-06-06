<?php  
  // only for development purposes, show errors
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);

  // gets, from the received post data, the information to play the sequence
  $data = $_POST['data'];
  $steps = json_decode($_POST['data']);
  $objectForFile =  array('steps' => $steps);

  // saves the information into a json file, this file is used
  // by the python script that play the sequence
  $fp = fopen('data.json', 'w');
  fwrite($fp, json_encode($objectForFile));
  fclose($fp);

  // execute the python script,
  $command = escapeshellcmd('sudo python3 ledson.py > /dev/null');
  exec($command);
?>