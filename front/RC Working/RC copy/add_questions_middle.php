<?php
    $qtext = $_POST['QText'];
    $funcname = $_POST['FuncName'];
    $input = $_POST['Input'];
    $output = $_POST['Output'];
    $diff = $_POST['Diff'];
    $keyword = $_POST['Keyword'];
    $topic = $_POST['Topic'];
    $forloop = $_POST['ForLoop'];
    $whileloop = $_POST['WhileLoop'];
    $print = $_POST['Print'];
    $return = $_POST['Return'];


    //posting with curl to SQL

    $url = 'https://web.njit.edu/~sk2292/RC/add_questions_db.php';
    $post_data = array(
        'QText' => $qtext,
        'FuncName' => $funcname,
        'Input' => $input,
        'Output' => $output,
        'Diff' => $diff,
        'Keyword' => $keyword,
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

    echo $output;

?>