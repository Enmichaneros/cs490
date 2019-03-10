<?php
$code = 'print("Hello, World!")';

$c = 'echo \'#!/usr/bin/env python\' > test.py';
exec($c);
exec('chmod +x test.py');

file_put_contents("test.py", $code, FILE_APPEND);

$c = escapeshellcmd('./test.py');
$output = shell_exec($c);
echo $output;


?>