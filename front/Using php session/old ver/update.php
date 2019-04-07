<?php

    $testid = isset($_POST['TestID']) ? $_POST['TestID'] : '';
    $ucid = isset($_POST['UCID']) ? $_POST['UCID'] : '';
    $qid = isset($_POST['QID']) ? $_POST['QID'] : '';
    $earnedpts = isset($_POST['EarnedPts']) ? $_POST['EarnedPts'] : '';
    $comments = isset($_POST['Comments']) ? $_POST['Comments'] : '';

    

    //posting with curl

    $url = 'https://web.njit.edu/~mbr23/Beta/update_middle.php';
    $post_data = array(
        'TestID' => $testid,
        'UCID' => $ucid,
        'QID' => $qid,
        'EarnedPts' => $earnedpts,
        'Comments' => $comments,
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
    if($output['updated']=='Yes'){
        print_r('Updated</br>');
    }
    elseif($output['updated']=='No'){
        print_r('Not Updated</br>');
    }
    else{
        print_r('Did not work</br>');
    }

?>



