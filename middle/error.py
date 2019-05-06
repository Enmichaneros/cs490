#!/usr/bin/env python

import subprocess
import sys
# to pass an argument into the test.py, so that it runs correctly as intended

# testcase =  sys.argv[1]
def run(cmd):
    proc = subprocess.Popen(cmd,
        stdout = subprocess.PIPE,
        stderr = subprocess.PIPE,
    )
    stdout, stderr = proc.communicate()
 
    return proc.returncode, stdout, stderr 
# code, out, stuff = run([sys.executable, 'test.py', testcase])
code, out, stuff = run([sys.executable, 'test.py'])
 
# print()
# print("err: '{}'".format(err))
# keep this one so we can physically see what would be considered "normal"
print(stuff.decode('UTF-8'))