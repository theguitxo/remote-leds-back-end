#!/usr/bin/env python3
'''
' This class helps us to use 8 LEDs 
' through an integrated circuit 74hc595
' Uses RPi.GPIO module'
'''
import RPi.GPIO as GPIO

class shifter74hc595():

  # Pins for data, clock and latch of 74hc595
  data = None;
  clock = None;
  latch = None;

  # Array with the state of the 8 LEDs
  leds = [None, None, None, None, None, None, None, None]

  '''
  ' inits the values for LEDs and GPIO
  ' settings, then, turns off all LEDs
  '''
  def __init__(self, data, clock, latch):    
    self.data = data;
    self.clock = clock;
    self.latch = latch;
    
    GPIO.setmode(GPIO.BOARD)
    GPIO.setwarnings(False)    
    GPIO.setup(self.data, GPIO.OUT)
    GPIO.setup(self.clock, GPIO.OUT)
    GPIO.setup(self.latch, GPIO.OUT)

    self.setAll(GPIO.LOW)
    self.sendData()

  '''
  ' when the object is deleted, turns off
  ' all LEDs and cleans GPIO settings
  '''    
  def __del__(self):    
    self.setAll(GPIO.LOW)
    self.sendData()
    GPIO.cleanup()

  '''
  ' sets values for all leds
  '''
  def setAll(self, value):
    for i in range(len(self.leds)):
      self.leds[i] = value
  
  '''
  ' sets the value to a specific led
  '''
  def setLed(self, led, value):
    self.leds[led] = value

  '''
  ' turns off a led, setting their pin to low
  '''
  def setOnLed(self, led):
    self.setLed(led, GPIO.HIGH)        
  
  '''
  ' turns on a led, setting their pin to high
  '''
  def setOffLed(self, led):
    self.setLed(led, GPIO.LOW)

  '''
  ' through the clock, sets the eight values for 74hc595
  '''
  def __setDataPin(self, state):
    GPIO.output(self.clock, GPIO.LOW)
    GPIO.output(self.data, state)
    GPIO.output(self.clock, GPIO.HIGH)
  
  '''
  ' opens the latch, sends data to 74hc595 and, finally, closes the latch
  '''
  def sendData(self):
    GPIO.output(self.latch, GPIO.LOW)
    for i in reversed(self.leds):
      self.__setDataPin(i)
    GPIO.output(self.latch, GPIO.HIGH)

'''
' nothing to do if it's executed as the main file
'''
if __name__ == "__main__":
  pass
