<?php

    $testid = isset($_POST['TestID']) ? $_POST['TestID'] : '';
    

    //posting with curl

    $url = 'https://web.njit.edu/~mbr23/Beta/scores_middle.php';
    $post_data = array(
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

    if($output != "no data"){
        print_r($output);
        echo "<p>Change Score/Comment</p><br>";
        echo '<input type="text" value="' . $testid . '" id="TestIDScore"/>';
        echo '<input type="text" placeholder="UCID" id="UCIDScore"/>';
        echo '<input type="text" placeholder="QID" id="QIDScore"/>';
        echo '<input type="text" placeholder="Change Earned Points" id="EarnedPtsScore"/>';
        echo '<input type="text" placeholder="Change Comments" id="CommentsScore"/>';

        echo '<input type="button" value="Update" onclick="updateResults()">';

    }

?>



