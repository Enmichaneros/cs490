<?php
// dummy values
$code = "def function(item):\n\treturn item > 0";
$test_input = array("5", "2");
$test_output = array("True", "False"); 

$total_points = 100;
$point_decrement = 50;
$counter = 0;


// writing the file
$c = 'echo \'#!/usr/bin/env python\' > test.py';
exec($c);
exec('chmod +x test.py');

// need to figure out how to extract this
$function_name = 'this()';

file_put_contents("test.py", "import sys\n", FILE_APPEND);
file_put_contents("test.py", $code, FILE_APPEND);
file_put_contents("test.py", "\nprint(function(int(sys.argv[1])))", FILE_APPEND);

// test cases
foreach ($test_input as $input) {
    $temp = './test.py ' + intval($input);
    $c = escapeshellcmd($temp);
    $output = shell_exec($c);
    if ($test_output[$counter] != $output){
        $total_points = $total_points - $point_decrement;
    }
}
echo $total_points;
?>