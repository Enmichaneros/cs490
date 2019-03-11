<?php
    include("db_details.php");

    $qid = $_POST['QID'];
    $qtext = $_POST['QText'];
    $tcnum = $_POST['TCNum'];
    $input = $_POST['Input'];
    $output = $_POST['Output'];
    $diff = $_POST['Diff'];
    $keyword = $_POST['Keyword'];
    $topic = $_POST['Topic'];

    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $add_question = "INSERT INTO QUESTIONS (QID, QText, Diff) VALUES ('$qid','$qtext', '$diff');";
    ( $added = mysql_query( $add_question ) or die (mysql_error()) );

    $add_question_keyword = "INSERT INTO QUES_KEY (QID, Keyword) VALUES ('$qid','$keyword');";
    ( $added_key = mysql_query( $add_question_keyword ) or die (mysql_error()) );

    $add_question_topic = "INSERT INTO QUES_TYPE (QID, Topic) VALUES ('$qid','$topic');";
    ( $added_topic = mysql_query( $add_question_topic ) or die (mysql_error()) );

    $add_question_tc = "INSERT INTO TESTCASES (QID, TCNum, Input, Output) VALUES ('$qid','$tcnum','$input','$output');";
    ( $added_tc = mysql_query( $add_question_tc ) or die (mysql_error()) );


    if($added){
        echo json_encode(array('added_question' => 'Yes'));
    }
    else{
        echo json_encode(array('added_question' => 'No'));
    }

?>
