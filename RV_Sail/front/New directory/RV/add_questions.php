<?php


    $qtext = isset($_POST['QText']) ? $_POST['QText'] : '';
    $funcname = isset($_POST['FuncName']) ? $_POST['FuncName'] : '';
    $input = isset($_POST['Input']) ? $_POST['Input'] : '';
    $output = isset($_POST['Output']) ? $_POST['Output'] : '';
    $diff = isset($_POST['Diff']) ? $_POST['Diff'] : '';
//    $keyword = isset($_POST['Keyword']) ? $_POST['Keyword'] : '';
    $topic = isset($_POST['Topic']) ? $_POST['Topic'] : '';
    $forloop = isset($_POST['ForLoop']) ? $_POST['ForLoop'] : '';
    $whileloop = isset($_POST['WhileLoop']) ? $_POST['WhileLoop'] : '';
    $print = isset($_POST['Print']) ? $_POST['Print'] : '';
    $return = isset($_POST['Return']) ? $_POST['Return'] : '';



    //posting with curl

    $url = 'https://web.njit.edu/~mbr23/RV/add_questions_middle.php';
    $post_data = array(
        'QText' => $qtext,
        'FuncName' => $funcname,
        'Input' => $input,
        'Output' => $output,
        'Diff' => $diff,
//        'Keyword' => $keyword,
        'Topic' => $topic,
        'ForLoop' => $forloop,
        'WhileLoop' => $whileloop,
        'Print' => $print,
        'Return' => $return,
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


//    echo $output;

    $output = json_decode($output,true);

    if($output['added_question']=='Yes'){
        print_r('Added</br>');
    }
    elseif($output['added_question']=='No'){
        print_r('Not Added</br>');
    }
    else{
        print_r('Did not work</br>');
    }
?>



