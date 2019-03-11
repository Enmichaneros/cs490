<?php

    $testid = isset($_POST['TestID']) ? $_POST['TestID'] : '';
    $teacher = isset($_POST['Teacher']) ? $_POST['Teacher'] : '';
    $status = isset($_POST['Status']) ? $_POST['Status'] : '';


    //posting with curl

    $url = 'https://web.njit.edu/~sk2292/Beta/make_test_middle.php';
    $post_data = array(
        'TestID' => $testid,
        'Teacher' => $teacher,
        'Status' => $status,
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

    if($output['test_created']=='Yes'){
        print_r('Test Created<br><br>');
        echo '<input type="text" value="' . $testid . '" id="TestIDQues"/>';
        echo '<input type="text" placeholder="Question ID" id="QIDQues"/>';
        echo '<input type="text" placeholder="Number of Points" id="PointsQues"/>';
        echo '<input type="button" value="Add Test Question" onclick="addTestQuestion()">';
        echo '<p id="question_content"></p>';

    }
    elseif($output['test_created']=='No'){
        print_r('Test Not Created</br>');
    }
    else{
        print_r('Did not work</br>');
    }

?>



