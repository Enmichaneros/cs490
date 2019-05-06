<?php

    $testid = isset($_POST['TestID']) ? $_POST['TestID'] : '';
    $ucid = isset($_POST['UCID']) ? $_POST['UCID'] : '';


    //posting with curl

    $url = 'https://web.njit.edu/~mbr23/RV/teacher_student_exam_middle.php';
    $post_data = array(
        'TestID' => $testid,
        'UCID' => $ucid,
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

    echo $output;

?>



