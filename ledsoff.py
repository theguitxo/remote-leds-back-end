#!/usr/bin/env python3

from shifter74hc595.shifter74hc595 import shifter74hc595
import sys

shifter = shifter74hc595(11, 15, 13)

if __name__ == '__main__':
  shifter.setAll(0)
  shifter.sendData()
  del(shifter)
  sys.exit()
