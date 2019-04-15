<?php
    include("db_details.php");

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

    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $add_question = "INSERT INTO QUESTION (QText, Diff, FuncName) VALUES ('$qtext','$diff', '$funcname');";
    ( $added = mysql_query( $add_question ) or die (mysql_error()) );

    $qid = "SELECT QID FROM QUESTION WHERE FuncName='$funcname' AND QText='$qtext' AND Diff='$diff';";

    ( $t = mysql_query( $qid )) or die (mysql_error());
    if(mysql_num_rows($t) == 0) die ("no data");

    $r = mysql_fetch_array($t);
    $QID=htmlspecialchars($r["QID"]);


    $add_question_keyword = "INSERT INTO QUES_KEY (QID, Keyword) VALUES ('$QID','$keyword');";
    ( $added_key = mysql_query( $add_question_keyword ) or die (mysql_error()) );

    $add_question_topic = "INSERT INTO QUES_TYPE (QID, Topic) VALUES ('$QID','$topic');";
    ( $added_topic = mysql_query( $add_question_topic ) or die (mysql_error()) );

    $add_question_nec = "INSERT INTO QUES_NEC (QID, ForLoop, WhileLoop, ReturnStatement, PrintStatement) VALUES ('$QID','$forloop', '$whileloop', '$return', '$print');";
    ( $added_nec = mysql_query( $add_question_nec ) or die (mysql_error()) );

    $inputTC = explode("```", $input);
    $outputTC = explode("```", $output);

    for( $i = 0; $i<count($inputTC)-1; $i++ ) {
        $tcnum = $i;
        $add_question_tc = "INSERT INTO TESTCASES (QID, TCNum, Input, Output) VALUES ('$QID','$tcnum','$inputTC[$i]','$outputTC[$i]');";
        ( $added_tc = mysql_query( $add_question_tc ) or die (mysql_error()) );
    }


    if($added){
        echo json_encode(array('added_question' => 'Yes'));
    }
    else{
        echo json_encode(array('added_question' => 'No'));
    }

?>
