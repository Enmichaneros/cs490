<?php


    $qid = isset($_POST['QID']) ? $_POST['QID'] : '';


    //posting with curl

    $url = 'https://web.njit.edu/~sk2292/RV/select_questions_middle.php';
    $post_data = array(
        'QID' => $qid,

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

    echo $output;
?>



