<?php

$ucid = $_POST['UCID'];
// is an array of all the code strings
// $code = $_POST['code']; // will be a string separated by '```'
$testid = $_POST['TestID'];

// dummy question_info values
$code = "def thatfunction(item):\nprint(True)";
// $code = "def thatfunction(item):\n return True";
// $code = "#hello there and stuff\nprinf(\"True\")";
$question_info = array(
    'input' => '1,-7',
    'output' => 'True,False',
    'points' => '50',
    'for' => False,
    'print' => False,
    'return' => False,
    'while' => False,
);

$test_input = explode(',', $question_info['input']);
$test_output = explode(',', $question_info['output']);
$max_points = intval($question_info['points']);
$total_points = intval($question_info['points']);

$point_decrement = $total_points / sizeof($test_input);
$uses_for = $question_info['for'];
$uses_while = $question_info['while'];
$uses_print = $question_info['print'];
$uses_return = $question_info['return'];


// writing the file and making it executable, hosted onto my personal njit server, so is a local file
$c = 'echo \'#!/usr/bin/env python\' > test.py';
exec($c);
exec('chmod +x test.py'); // make it executable

////////////////////////////////////////////
//////////////////////////////////////////// beginning of error checking section
////////////////////////////////////////////

// for errors detected by autograder, so the teacher knows why points were deducted
$autograder_comments = "";

//////////////////
////////////////// incorrect function name
//////////////////

$function = explode(':', $code, 2);

// TODO: retrieve actual intended function name from
// $function_name = $question_info['function'];
// TODO: This is a dummy value
$function_name = 'thatfunction(item)';
$actual = 'def '.$function_name;

// $autograder_comments = $autograder_comments."Testing function name... >>>>>>";
if ($function[0] != $actual){
    $total_points = $total_points - ($point_decrement / 10);
    $autograder_comments = $autograder_comments."DEDUCT ".($max_points / 10)." -- incorrect function name\n";
    $function[0] = $actual.":";
}
else{
    $function[0] = $function[0].":";
}

//////////////////
////////////////// for loop error (naive implementation)
//////////////////

// TODO: question_info also needs to store/be able to retrieve if a question requires a for loop
// $autograder_comments = $autograder_comments."Testing presence of for loop... >>>>>>";
if ($question_info['for'] == true){ 
    if (strpos($function[1], 'for') == false) {
        $autograder_comments = $autograder_comments."FLAG -- Does not contain for loop when specified\n";
    } 
}

//////////////////
////////////////// TODO: switch if code uses for and if uses print
//////////////////


file_put_contents("test.py", "import sys\n", FILE_APPEND);
foreach ($function as $value) {
    file_put_contents("test.py", $value, FILE_APPEND);
}

// writing the print function to output results, since the question is only to write the function normally
$f = explode('def ', $function[0]);
$function_parts = explode('(', $f[1]);
// if a function with a return statement
// $print_string = "\nprint(".$function_parts[0]."(int(sys.argv[1])))";

// if a print string inside a function (shouldn't be)
$print_string = "\n".$function_parts[0]."(int(sys.argv[1]))";

file_put_contents("test.py", $print_string, FILE_APPEND);


//////////////////
////////////////// the part where we kinda run the code to test for the other errors bc they're less obvious
//////////////////
$max_count = 10;
$count = 10; // number of error iterations so far
$fixable = true; // to check if it's even possible to fix at all
$has_errors = false;

// TODO: rename to something better
// $autograder_comments = $autograder_comments."Testing for runtime errors... >>>>>>";
exec('chmod +x error.py');
$temp = './error.py '.$test_input[0];
$c = escapeshellcmd($temp);
$output = shell_exec($c);
// $autograder_comments = $autograder_comments.$output;
if (strpos($output, 'Error') != false) {
    // $autograder_comments = $autograder_comments."Detected error... >>>>>>";
    $has_errors = true;
} 
else{
    // $autograder_comments = $autograder_comments."Did not detect error... >>>>>>";
}


// TODO: consider adding the line number where the error occured
while ($has_errors && $fixable){
    // $autograder_comments = $autograder_comments."Attempting to deal with error... >>>>>>";
    if (strpos($output, 'Error') != false) {
        // find the line where the error is
        $output_lines = explode("\n", $output);
        $line = explode("line", $output_lines[0]);
        // $autograder_comments = $autograder_comments."Offending line: ".$output_lines[0].">>>>";
        $line_number = intval(trim(preg_replace('/[^0-9]/', '', $line[1])));
        // $autograder_comments = $autograder_comments."Offending line number: ".$line_number.">>>>";

        $code = file_get_contents("test.py");
        // $autograder_comments = $autograder_comments.$code;
        $code_lines = explode("\n", $code);
        $error_line = $code_lines[$line_number-1]; // it starts counting from one
        // $autograder_comments = $autograder_comments."Offending line: ||".$error_line;

        // NameError
        if (strpos($output, 'NameError') != false) {
            // $autograder_comments = $autograder_comments."Detected NameError... >>>>>>";
            $mistake = trim(explode("(", $error_line)[0]);
            // $autograder_comments = $autograder_comments."Mistake: ".$mistake." on line ".$error_line.">>>>";
            similar_text("print", $mistake, $percent);
            // $autograder_comments = $autograder_comments."Similarity factor: ".$percent." >>>>";
            if ($percent > 0.5){
                preg_replace($mistake, 'print', $code_lines[$line_number-1]);  // replace the misspelled "print" with the right word
                $autograder_comments = $autograder_comments."DEDUCT ".($max_points/ 10)." -- function name misspelled, correction attempted\n";
                $count = $count - 1;
            } // TODO: other common functions that could be misspelled
            else{  // else, it's unfixable and we don't know what they were trying to say.
                $autograder_comments = $autograder_comments."ERROR -- unknown function used, could not detect a fix.\n";
                $fixable = false;
            }
        }

        // IndentError
        if (strpos($output, 'IndentationError') != false) {
            // $autograder_comments = $autograder_comments."Detected IndentationError... >>>>>>";
            $indented_string = " ".$error_line;  // it only throws an indent error if there are zero spaces; even one counts as a proper indent apparently
            $code_lines[$line_number-1] = $indented_string;
            // $autograder_comments = $autograder_comments."New line: ".$indented_string;
            $autograder_comments = $autograder_comments."DEDUCT ".($max_points / 10)." -- incorrect indentation\n";
            $count = $count - 1;            
        }

        // SyntaxError
        if (strpos($output, 'SyntaxError') != false) {
            $autograder_comments = $autograder_comments."Detected SyntaxError... >>>>>>";
            // this also applies to missing parentheses and probably other stuff (assuming python3) but for now this is probably good enough for now
            $autograder_comments = $autograder_comments."ERROR -- Unable to automatically fix syntax errors, manual grading may be required\n";
            $fixable = false;
        }

        file_put_contents("test.py", ""); // first input nothing, to rewrite the file (I'm pretty sure this works)
        // $autograder_comments = $autograder_comments."Rewritten Code: ||||";
        foreach ($code_lines as $line) { // then rewrite each line from the code, including the edited one (theoretically)
            // $autograder_comments = $autograder_comments.$line;
            file_put_contents("test.py", $line."\n", FILE_APPEND);
        }
        
        $output = shell_exec($c); // run the error function again, storing the output
        if ($count == 0){ $fixable = false; } // if it keeps having errors, it might not be fixable
    }
    else {
        $has_errors = false;
        $total_points = max(($total_points - ( 5 * ($max_count - $count))), 0); // deduct points, if that's too many then set to 0.
    }
}

//////////////////
////////////////// the part where we kinda run the code again, but for one-off errors
//////////////////

////////////////////////////////////////////
//////////////////////////////////////////// End error checking
////////////////////////////////////////////


// running test cases
for ($i = 0; $i < sizeof($test_input); $i++){
    $temp = './test.py '.$test_input[$i];
    $c = escapeshellcmd($temp);
    $output = shell_exec($c);
    if (trim($output) != $test_output[$i]){
        $total_points = $total_points - $point_decrement;
        $autograder_comments = $autograder_comments."DEDUCT ".$point_decrement." -- Test Case #".$i." did not work successfully. Expected: ".$test_output[$i]." || Actual: ".trim($output)."\n";
    }
}


$total_points = max($total_points, 0); // make sure it's not a negative number after all of the deductions

// Not sending, since this is purely for testing purposes.


echo "Total points: ".$total_points."/".$max_points."   ".$autograder_comments;

// dummy return value
?>