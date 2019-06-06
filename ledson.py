#!/usr/bin/env python3

from shifter74hc595.shifter74hc595 import shifter74hc595
import sys
import os
from time import sleep
import json

shifter = shifter74hc595(11, 15, 13)


if __name__ == '__main__': 

  # get the pid
  pid = os.getpid()
  file = open('leds.pid.txt', 'w')
  file.write(str(pid))
  file.close()

  # open json data file
  with open('data.json', 'r') as file:
    leds_steps = json.load(file)
  
  try:
    while True:
      for step in leds_steps['steps']:
        for idx, state in enumerate(step['states']):
          shifter.setLed(idx, state)
        shifter.sendData()
        sleep(float(step['sleep']))

  except KeyboardInterrupt:
    del(shifter)
    sys.exit()    
