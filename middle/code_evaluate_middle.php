<?php
// _POST values, assuming a single question
$ucid = $_POST['UCID'];
$code = $_POST['code'];
$testid = $_POST['TestID'];
$qid = $_POST['QID'];

// some url for getting info about questions from database
$url = 'https://web.njit.edu/~sk2292/Beta/get_testcases_db.php';
$post_data = array(
    'QID' => $qid,
    'TestID' => $testid,
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url); // url to send to
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return output instead of printing
curl_setopt($ch, CURLOPT_POST, 1); //posting
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //add post variables to request

$question_info = curl_exec($ch); //execute request and fetch response
if ($question_info == FALSE){ //check if request successful
    echo "cURL error: " . curl_error($ch);
}
curl_close($ch); //close curl

// grab the values from the database
$test_input = $question_info['input'];
$test_output = $question_info['output'];
$total_points = intval($question_info['points']);
$point_decrement = $total_points / sizeof(test_input);


// writing the file and making it executable
$c = 'echo \'#!/usr/bin/env python\' > test.py';
exec($c);
exec('chmod +x test.py');

//
/////////////////// beginning of error checking section
//

// for syntax errors detected by code
$autograder_comments = "";
// TODO: make into a for loop when other errors need to be checked
$function = explode(':', $code, 2);

// TODO: how to keep track of 'correct' function name?
// for now it's hardcoded as a 'default' question name
$actual = 'def thatfunction(item)';

// wrong function name error
if ($function[0] != $actual){
	$total_points = $total_points - ($point_decrement / 2);
    $autograder_comments = $autograder_comments."Incorrect function name\n";
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

//
/////////////////// End error checking
//


// running test cases
// NOTE: at the moment just assuming one test case. 
// (see test_code.php for WIP loop)
$temp = './test.py '.$test_input;
$c = escapeshellcmd($temp);
$output = shell_exec($c);
if (trim($output) != $test_output){
    $total_points = $total_points - $point_decrement;
}

// submitting results back to database
$url = 'https://web.njit.edu/~sk2292/Beta/add_results_db.php';
$post_data = array(
    'UCID' => $ucid,
    'QID' => $qid,
    'TestID' => $testid,
    'EarnedPts' => $total_points,
    'AnsText' => $code,
    'Comments' => $autograder_comments,
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url); // url to send to
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return output instead of printing
curl_setopt($ch, CURLOPT_POST, 1); //posting
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //add post variables to request

$question_info = curl_exec($ch); //execute request and fetch response
if ($output == FALSE){ //check if request successful
    echo "cURL error: " . curl_error($ch);
}
curl_close($ch); //close curl

// send something back to front-end -- success/failure maybe? idk
echo 'Success';
?>