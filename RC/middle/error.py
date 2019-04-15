#!/usr/bin/env python

import subprocess
import sys
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

print(stuff.decode('UTF-8'))