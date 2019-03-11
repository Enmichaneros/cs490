<?php

    $testid = isset($_POST['TestID']) ? $_POST['TestID'] : '';
    $qid = isset($_POST['QID']) ? $_POST['QID'] : '';
    $points = isset($_POST['Points']) ? $_POST['Points'] : '';


    //posting with curl

    $url = 'https://web.njit.edu/~sk2292/Beta/add_test_question_middle.php';
    $post_data = array(
        'TestID' => $testid,
        'QID' => $qid,
        'Points' => $points,
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


    $output = json_decode($output,true);

    if($output['atq']=='Yes'){
        print_r('Test Question Added<br><br>');
    }
    elseif($output['atq']=='No'){
        print_r('Test Question Not Added</br>');
    }
    else{
        print_r('Did not work</br>');
    }

?>



