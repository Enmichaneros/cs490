<?php
// dummy values, replace with _POST values
$code = "def thisfunction(item):\n\treturn item > 0";
$test_input = array("5", "-2");
$test_output = array("True", "False"); 

$total_points = 100;
$point_decrement = 25;


// writing the file and making it executable
$c = 'echo \'#!/usr/bin/env python\' > test.py';
exec($c);
exec('chmod +x test.py');


// beginning of 'error checking section'
// TODO: make into a for loop when other errors need to be checked
$function = explode(':', $code, 2);

// TODO: how to keep track of 'correct' function name?
$actual = 'def thatfunction(item)';

// wrong function name error
if ($function[0] != $actual){
	$total_points = $total_points - $point_decrement;
	$function[0] = $actual.":";
}
else{
	$function[0] = $function[0].":";
}

// printing out 'fixed' code
file_put_contents("test.py", "import sys\n", FILE_APPEND);
foreach ($function as $value) {
	file_put_contents("test.py", $value, FILE_APPEND);
}

// writing the print function to output results
// since the question is only to write the function
$f = explode('def ', $function[0]);
$function_parts = explode('(', $f[1]);
$print_string = "\nprint(".$function_parts[0]."(int(sys.argv[1])))";
file_put_contents("test.py", $print_string, FILE_APPEND);

// running test cases
$results = "";
for ($i = 0; $i < sizeof($test_input); $i++){
    $temp = './test.py '.$test_input[$i];
    $c = escapeshellcmd($temp);
    $output = shell_exec($c);
    if (trim($output) != $test_output[$i]){
        $total_points = $total_points - $point_decrement;
    }
}
echo $total_points;
?>