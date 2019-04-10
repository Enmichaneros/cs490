<?php
    $testname = $_POST['TestName'];
    $qid = $_POST['QID'];
    $points = $_POST['Points'];
    $totalpoints = $_POST['TotalPoints'];


    //posting with curl to SQL

    $url = 'https://web.njit.edu/~sk2292/RC/add_test_questions_db.php';
    $post_data = array(
        'TestName' => $testname,
        'QID' => $qid,
        'Points' => $points,
        'TotalPoints' => $totalpoints,
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); // url to send to
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return output instead of printing
    curl_setopt($ch, CURLOPT_POST, 1); //posting
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //add post variables to request

    $output = curl_exec($ch); //execute request and fetch response
    if ($output == FALSE){ //check if request successful
        echo "2cURL error: " . curl_error($ch);
    }
    curl_close($ch); //close curl

    echo $output;

?>