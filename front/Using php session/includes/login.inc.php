<?php


    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    //posting with curl

    //MICHELLE'S MIDDLE.PHP URL IN THE NEXT LINE 
    $url = 'https://web.njit.edu/~sk2292/Beta/middle.php';
    $post_data = array(
        'username' => $username,
        'password' => $password,
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


    $output = json_decode($output,true);


    if($output['acctype']=='Student'){
        echo '<input type="button" value="Student" onclick="student()">';
        //print_r('Student');
    }
    elseif($output['acctype']=='Teacher'){
        echo '<input type="button" value="Teacher" onclick="teacher()">';
    }
    else{
        print_r('Try Again</br>');
    }

?>



