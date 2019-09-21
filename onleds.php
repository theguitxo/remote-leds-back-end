<?php  
  // only for development purposes, show errors
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);

  // gets, from the received post data, the information to play the sequence
  if(!array_key_exists('data', $_POST)) {
    die(json_encode(array('result' => false, 'message' => 'no data key')));
  } else {
    $data = $_POST['data'];
    $steps = json_decode($_POST['data']);
    $objectForFile =  array('steps' => $steps);
  } 

  // saves the information into a json file, this file is used
  // by the python script that play the sequence
  try {
    $fp = fopen('data.json', 'w');
    if(!$fp) {
      die(json_encode(array('result' => false, 'message' => 'error encoding data')));
    }    
    $result = fwrite($fp, json_encode($objectForFile));
    if(!$result) {
      die(json_encode(array('result' => false, 'message' => 'error saving data')));
    }
    fclose($fp);
  } catch(Exception $e) {
    // exception when trying to save JSON file with data
    die(json_encode(array('result' => false, 'message' => $e->getMessage())));
  }

  // execute the python script,        
  try {   
    $command = 'sudo python3 ledson.py >/dev/null &';
    system($command, $result);  
    if($result > 0) {
      die(json_encode(array('result' => false, 'message' => 'error on turn on leds')));
    }
  } catch(Exception $e) {
    // exception when trying to execute python script
    die(json_encode(array('result' => false, 'message' => $e->getMessage())));
  }
  
  // all OK, sends true to front-end
  echo json_encode(array('result' => true));   
?>