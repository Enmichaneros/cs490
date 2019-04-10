#!/usr/bin/env python

import subprocess
import sys
 
# TODO: needs to pass an argument into the test.py, so that it runs correctly as intended

testcase =  sys.argv[1]
def run(cmd):
    proc = subprocess.Popen(cmd,
        stdout = subprocess.PIPE,
        stderr = subprocess.PIPE,
    )
    stdout, stderr = proc.communicate()
 
    return proc.returncode, stdout, stderr 
code, out, stuff = run([sys.executable, 'test.py', testcase])
 
# print()
# print("err: '{}'".format(err))
# this captures both together, so we can check if there is any error or not in one fell swoop!
# huzzah!
# keep this one so we can physically see what would be considered "normal"
print(stuff.decode('UTF-8'))

# would it be easier to parse if we split by \n?
# maybe, since every
# array_of_stuff = stuff.decode('UTF-8').split('\n')
# for stuff in array_of_stuff:
# 	print(stuff)

# this circles back to my original question... should I debug in a python program instead?
# since I'm not actually running the program directly anymore with this setup. I
# also, because fuck php and I need to learn Python eventually
# yes, I'm going to keep ranting here
# I didn't take my break? shit, well I'm yawning so I guess it doesn't matter anyway
# I guess I'm sleeping on this decision now... eh