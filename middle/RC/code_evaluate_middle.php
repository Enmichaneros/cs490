<?php
$ucid = $_POST['UCID'];
// $code = $_POST['code']; // will be a string separated by '```'
$testid = $_POST['TestID'];
$answers = explode('```',  $_POST['code']);


// inputs are put into one string
// outputs are put into one string
// split by comma
// explode and then create 

// TODO: php file that connects to backend and retrieves questions, in order of QID
$url = "https://web.njit.edu/~mbr23/RC/get_test_qids_db.php"
$post_data = array(
    'ucid' => $ucid,
    'TestID' => $testid,
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url); // url to send to
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return output instead of printing
curl_setopt($ch, CURLOPT_POST, 1); //posting
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //add post variables to request

$output = curl_exec($ch); //execute request and fetch response
if ($output == FALSE){ //check if request successful
    echo "cURL error: " . curl_error($ch);
}
curl_close($ch); //close curl

$questions = $output['questions'];
$question_ids = explode(',', $questions);

////////////////////////////////////////////
//////////////////////////////////////////// beginning of for loop for questions
////////////////////////////////////////////

for ($q = 0; $q < sizeof($answers); $q++){
    // dummy question_info values
    // $code = "def thatfunction(item):\nprint(True)";
    // $question_info = array(
    //     'input' => '1,-7',
    //     'output' => 'True,False',
    //     'points' => '50',
    //     'for' => False,
    //     'print' => False,
    //     'return' => False,
    //     'while' => False,
    // );

    $code = $answers[$q];
    $qid = $question_ids[$q];

    // grab the values from the database
    // TODO: check correct posting format
    $url = 'https://web.njit.edu/~sk2292/RC/get_testcases_db.php';
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

    // TODO: these will be comma separated values
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

    // TODO: retrieve actual intended function name from somewhere
    $function_name = $question_info['function'];
    $actual = 'def '.$function_name;

    // $autograder_comments = $autograder_comments."Testing function name... >>>>>>";
    if ($function[0] != $actual){
        $total_points = $total_points - ($point_decrement / 10);
        $autograder_comments = $autograder_comments."DEDUCT ".($max_points / 10)." -- incorrect function name\n";
        $function[0] = $actual.":";
    }
    else{ $function[0] = $function[0].":"; }

    //////////////////
    ////////////////// for loop error (naive implementation)
    //////////////////

    // TODO: question_info also needs to store/be able to retrieve if a question requires a for loop
    if ($uses_for){ 
        if (strpos($function[1], 'for') == false) {
            $autograder_comments = $autograder_comments."FLAG -- Does not contain for loop when specified\n";
        } 
    }

    //////////////////
    ////////////////// TODO: switch if code uses for and if uses print
    //////////////////


    file_put_contents("test.py", "import sys\n", FILE_APPEND);
    foreach ($function as $value) { file_put_contents("test.py", $value, FILE_APPEND); }

    // print results to console (if required to edit)
    $f = explode('def ', $function[0]);
    $function_parts = explode('(', $f[1]);

    if ($uses_for){ $print_string = "\nprint(".$function_parts[0]."(int(sys.argv[1])))"; }
    else if ($uses_print) { $print_string = "\n".$function_parts[0]."(int(sys.argv[1]))"; }
    else { $print_string = ""; }
    file_put_contents("test.py", $print_string, FILE_APPEND);


    //////////////////
    ////////////////// the part where we kinda run the code to test for the other errors bc they're less obvious
    //////////////////

    $max_count = 10; // limit of errors; manually set
    $count = 10; // number of error iterations so far; manually set                                                                                                                                                          
    $fixable = true; // to check if it's even possible to fix at all
    $has_errors = false;

    exec('chmod +x error.py');
    $temp = './error.py '.$test_input[0];
    $c = escapeshellcmd($temp);
    $output = shell_exec($c);
    if (strpos($output, 'Error') != false) { $has_errors = true; } 


    // TODO: consider adding the line number where the error occured
    while ($has_errors && $fixable){
        if (strpos($output, 'Error') != false) {
            // find the line where the error is
            $output_lines = explode("\n", $output);
            $line = explode("line", $output_lines[0]);
            $line_number = intval(trim(preg_replace('/[^0-9]/', '', $line[1])));

            $code = file_get_contents("test.py");
            $code_lines = explode("\n", $code);
            $error_line = $code_lines[$line_number-1]; // it starts counting from one

            // NameError
            if (strpos($output, 'NameError') != false) {
                $mistake = trim(explode("(", $error_line)[0]);
                similar_text("print", $mistake, $percent);
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

            file_put_contents("test.py", ""); // first input nothing, to rewrite the file
            foreach ($code_lines as $line) { // then rewrite each line from the code, including the edited one
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

    // TODO: In progress, 
    // though it would be skipped if it did not include a loop of some sort probably

    //////////////////
    ////////////////// the part where we actually run the code for all the test cases
    //////////////////

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

    ////////////////////////////////////////////
    //////////////////////////////////////////// End autograder
    ////////////////////////////////////////////


    // submitting results back to database
    // TODO: this part **should** largely remain the same, shouldn't have to change
    // actually since we add the questions to the database, will need to see how that's formatted too
    // the important part, of course, is to make sure the error checking works for one question
    // then we can scale! yay!
    $url = 'https://web.njit.edu/~sk2292/Beta/add_results_db.php';

    // TODO: I'm pretty sure that if I just send multiple post requests it should work.

    $post_data = array(
        'UCID' => $ucid,
        'QID' => $qid,
        'TestID' => $testid,
        'EarnedPts' => $total_points,
        'AnsText' => $code, // the original code, not the one used to run the test cases
        'Comments' => $autograder_comments,
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

    $question_info = curl_exec($ch);
    if ($output == FALSE){
        echo "cURL error: " . curl_error($ch);
    }
    curl_close($ch);

} // end for loop






// send something back to front-end -- success/failure maybe? idk
// echo 'Success';
// dummy return value
echo "Total points: ".$total_points."/".$max_points."   ".$autograder_comments;

?>