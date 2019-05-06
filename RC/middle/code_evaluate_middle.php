<?php
$ucid = $_POST['UCID'];
$testid = $_POST['TestID'];
$question_ids = explode('```',  $_POST['QID']);
$answers = explode('```',  $_POST['Code']);

////////////////////////////////////////////
//////////////////////////////////////////// beginning of for loop for questions
////////////////////////////////////////////

for ($q = 0; $q < sizeof($question_ids)-1; $q++){
    // dummy values
    // $code = "def thatfunction(item):\nprint(True)";
    // $question_info = array(
    //     'input' => '1```-7',
    //     'output' => 'True```False',
    //     'points' => '100',
    //     'for' => 'false',
    //     'print' => 'false',
    //     'return' => 'true',
    //     'while' => 'false',
    //     'function' => 'thatfunction(n)',
    // );

    $code = $answers[$q];
    $original_code = $answers[$q];
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

    $output = curl_exec($ch); //execute request and fetch response
    if ($output == FALSE){ //check if request successful
        echo "1cURL error: " . curl_error($ch);
    }
    curl_close($ch); //close curl

    $question_info = json_decode($output, true);

    $test_input = explode('```', htmlspecialchars_decode($question_info['input']));
    $test_output = explode('```', $question_info['output']);
    $max_points = intval($question_info['points']);
    $total_points = intval($question_info['points']);

    

    $point_decrement = floor($total_points / (sizeof($test_input) - 1));
    $uses_for = $question_info['for'];
    $uses_while = $question_info['while'];
    $uses_print = $question_info['print'];
    $uses_return = $question_info['return'];

    // writing the file and making it executable, hosted onto my personal njit server, so is a local file
    // reminder: in a new folder you need to write "fs setacl ~/public_html/target_dir http write"
    $c = 'echo \'#!/usr/bin/env python\' > test.py';
    exec($c);
    exec('chmod +x test.py'); // make it executable

    ////////////////////////////////////////////
    //////////////////////////////////////////// beginning of error checking section
    ////////////////////////////////////////////

    // for errors detected by autograder, so the teacher knows why points were deducted
    $autograder_comments = "";
    // $autograder_comments = htmlspecialchars_decode($question_info['input'])."\n\n";

    //////////////////
    ////////////////// incorrect function name
    //////////////////

    // this breaks if the colon is missing
    $function = explode(':', $code, 2);

    $function_name = $question_info['function'];
    // $function_name = 'thatfunction(item)';
    $actual = 'def '.$function_name;

    // $autograder_comments = $autograder_comments."Testing function name... >>>>>>";
    if ($function[0] != $actual){
        $total_points = $total_points - floor($point_decrement / 2);
        $autograder_comments = $autograder_comments."DEDUCT ".floor($point_decrement / 2)." -- incorrect function name\n";
        $function[0] = $actual.":";
    }
    else{
        $function[0] = $function[0].":";
    }

    // $code_lines = explode("\n", $code);
    // // foreach ($code_lines as $line){
    // for ($i = 0; $i < sizeof($code_lines)-1; $i++){
    //     if (strpos($line, 'def') != false) {
    //         $count = $i;
    //         break;
    //     }
    // }




    // // TODO: retrieve actual intended function name from somewhere
    // $function_name = $question_info['function'];
    // // dummy value
    // // $function_name = "thatfunction(n)";
    // $actual = 'def '.$function_name.":";

    // // $autograder_comments = $autograder_comments."Testing function name... >>>>>>";
    // if ($count >= sizeof($code_lines) && $code_lines[$count] != $actual){
    //     $points = floor($point_decrement / 2);
    //     $total_points = $total_points - $points;
    //     $autograder_comments = $autograder_comments."DEDUCT ".$points." -- incorrect function name\n";
    //     $code_lines[$count] = $actual;
    // }
    // else{ $function[0] = $function[0].":"; }


    //////////////////
    ////////////////// for loop error (naive implementation)
    //////////////////

    // TODO: question_info also needs to store/be able to retrieve if a question requires a for loop
    if ($uses_for == 'true'){ 
        if (strpos($code, 'for') == false) {
            $autograder_comments = $autograder_comments."FLAG -- Does not contain for loop when specified\n";
        } 
    }
    if ($uses_while == 'true'){ 
        if (strpos($code, 'while') == false) {
            $autograder_comments = $autograder_comments."FLAG -- Does not contain while loop when specified\n";
        } 
    }
    if ($uses_return == 'true'){ 
        if (strpos($code, 'return') == false) {
            $autograder_comments = $autograder_comments."FLAG -- Does not contain return statement when specified\n";
        } 
    }
    if ($uses_print == 'true'){ 
        if (strpos($code, 'print') == false) {
            $autograder_comments = $autograder_comments."FLAG -- Does not contain print statement when specified\n";
        } 
    }

    //////////////////
    ////////////////// print statement vs. return statement
    //////////////////


    file_put_contents("test.py", "import sys\n", FILE_APPEND);
    // foreach ($code_lines as $value) { file_put_contents("test.py", $value."\n", FILE_APPEND); }

    foreach ($function as $value) { file_put_contents("test.py", $value."\n", FILE_APPEND); }

    // print results to console (if required to edit)
    // $f = explode('def ', $function[0]);
    // $function_parts = explode('(', $f[1]);

    // if ($uses_return == 'true'){ 
    //     $print_string = "\nprint(".$function_parts[0]."(int(sys.argv[1])))"; 
    // }
    // else if ($uses_print == 'true') { 
    //     $print_string = "\n".$function_parts[0]."(int(sys.argv[1]))"; 
    // }
    // else { $print_string = ""; }
    // file_put_contents("test.py", $print_string, FILE_APPEND);

    $base_code = file_get_contents("test.py");
    $code_lines = explode("\n", $base_code);

    // adding the first test case for code testing purposes
    // this is assuming that the test input includes the necessary print files
    file_put_contents("test.py", "\n".trim($test_input[0]), FILE_APPEND);

    //////////////////
    ////////////////// the part where we kinda run the code to test for the other errors bc they're less obvious
    //////////////////

    $max_count = 10; // limit of errors; manually set
    $count = 10; // number of error iterations so far; manually set                                                                                                                                                          
    $fixable = true; // to check if it's even possible to fix at all
    $has_errors = false;
    $points = floor($point_decrement / 2);

    exec('chmod +x error.py');
    $temp = './error.py';
    $c = escapeshellcmd($temp);
    $output = shell_exec($c);
    if (strpos($output, 'Error') != false) { $has_errors = true; } 

    while ($has_errors && $fixable){
        if (strpos($output, 'Error') != false) {

            $pattern='~line \d~';

            $success = preg_match($pattern, $output, $match);
            if ($success) { 
                // the error we want to fix is probably the last one in the error stack
                $line_number = intval(trim(preg_replace('/[^0-9]/', '', $match[sizeof($match)-1]))); 
            }
            else{ $fixable = false; }

            $error_line = $code_lines[$line_number-1]; // it starts counting from one

            // NameError
            if (strpos($output, 'NameError') != false) {
                $mistake = trim(explode("(", $error_line)[0]);
                similar_text("print", $mistake, $percent);
                if ($percent > 0.5){
                    $incorrect_line = $code_lines[$line_number-1];
                    preg_replace($mistake, 'print', $incorrect_line); 
                    $code_lines[$line_number-1] = $incorrect_line; // replace the misspelled "print" with the right word
                    $autograder_comments = $autograder_comments."DEDUCT ".$points." -- function name misspelled, correction attempted:\n".$code_lines[$line_number-1];
                    $count = $count - 1;
                } // TODO: other common functions that could be misspelled
                else{  // else, it's unfixable and we don't know what they were trying to say.
                    $autograder_comments = $autograder_comments."ERROR -- unknown function used, could not detect a fix.\n";
                    $fixable = false;
                }
            }

            // IndentError
            if (strpos($output, 'IndentationError') != false) {
                $indented_string = "\t".$error_line;  // it only throws an indent error if there are zero spaces; even one counts as a proper indent apparently
                $code_lines[$line_number-1] = $indented_string;
                $autograder_comments = $autograder_comments."DEDUCT ".$points." -- incorrect indentation:\n".$output;
                $count = $count - 1;            
            }

            // SyntaxError
            if (strpos($output, 'SyntaxError') != false) {
                $autograder_comments = $autograder_comments."Detected SyntaxError... >>>>>>";
                // this also applies to missing parentheses and probably other stuff (assuming python3) but for now this is probably good enough for now
                $autograder_comments = $autograder_comments."ERROR -- Unable to automatically fix syntax errors, manual grading may be required:\n".$output;
                $fixable = false;
            }

            file_put_contents("test.py", ""); // first input nothing, to rewrite the file
            foreach ($code_lines as $line) { // then rewrite each line from the code, including the edited one
                file_put_contents("test.py", $line."\n", FILE_APPEND);
            }
            // then add the input afterwards
            file_put_contents("test.py", "\n".$test_input[0], FILE_APPEND);
            
            $output = shell_exec($c); // run the error function again, storing the output
            if ($count == 0){ $fixable = false; } // if it keeps having errors, it might not be fixable
        }
        else {
            $has_errors = false;
            $total_points = max(($total_points - ( $points * ($max_count - $count))), 0); // deduct points, if that's too many then set to 0.
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

        file_put_contents("test.py", ""); // first input nothing, to rewrite the file just in case
        // then rewrite each line from the base code
        foreach ($code_lines as $line) { file_put_contents("test.py", $line."\n", FILE_APPEND);}

        echo "testinput: ".$test_input[$i];
        file_put_contents("test.py", "\n".trim($test_input[$i]), FILE_APPEND); // then add the input afterwards
        // $autograder_comments = $autograder_comments."\nTesting:\n".file_get_contents("test.py")."\n";
        // run the code
        $temp = './test.py';
        $c = escapeshellcmd($temp);
        $output = shell_exec($c);
        if (trim($output) != $test_output[$i]){
            $total_points = $total_points - $point_decrement;
            $autograder_comments = $autograder_comments."DEDUCT ".$point_decrement." -- Test Case #".($i+1)." did not match. Expected: ".$test_output[$i]." || Actual: ".trim($output)."\n";
        }
    }


    $total_points = max($total_points, 0); // make sure it's not a negative number after all of the deductions

    ////////////////////////////////////////////
    //////////////////////////////////////////// End autograder
    ////////////////////////////////////////////

    $url = 'https://web.njit.edu/~sk2292/RC/add_results_db.php';

    // TODO: I'm pretty sure that if I just send multiple post requests it should work.
    
//    echo $ucid . "<br>" . $qid . "<br>" . $testid . "<br>" . $total_points . "<br>" . $code . "<br>" . $comments. "<br>";
    
    $end_code = file_get_contents("test.py"); // for debugging purposes
    
    $post_data = array(
        'UCID' => $ucid,
        'QID' => $qid,
        'TestID' => $testid,
        'EarnedPts' => $total_points,
        'AnsText' => $original_code, // the original code, not the one used to run the test cases
        'Comments' => $autograder_comments,
    );
//    $post_data = array(
//        'UCID' => 'sk2292',
//        'QID' => '1',
//        'TestID' => '2',
//        'EarnedPts' => '0',
//        'AnsText' => 'answercode', // the original code, not the one used to run the test cases
//        'Comments' => 'hello',
//    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

    $output = curl_exec($ch);
    if ($output == FALSE){
        echo "2cURL error: " . curl_error($ch);
    }
    curl_close($ch);

} // end for loop






// send something back to front-end -- success/failure maybe? idk
// echo 'Success';
// dummy return value
// echo "Total points: ".$total_points."/".$max_points."   ".$autograder_comments;
echo "Submitted";

?>