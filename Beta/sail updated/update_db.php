<?php
    include("db_details.php");

    $testid = $_POST['TestID'];
    $ucid = $_POST['UCID'];
    $qid = $_POST['QID'];
    $earnedpts = $_POST['EarnedPts'];
    $comments = $_POST['Comments'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);
    
    if($earnedpts != ''){
        $query1 = "UPDATE RESULTS SET EarnedPts='$earnedpts' WHERE TestID='$testid' AND UCID='$ucid' AND QID='$qid';";
        ( $t = mysql_query( $query1 )) or die (mysql_error());
    }
    if($comments != ''){
        $query2 = "UPDATE RESULTS SET Comments='$comments' WHERE TestID='$testid' AND UCID='$ucid' AND QID='$qid';";
        ( $r = mysql_query( $query2 )) or die (mysql_error());
    }
    
    if($t or $r){
        echo json_encode(array('updated' => 'Yes'));
    }
    else{
        echo json_encode(array('updated' => 'No'));
    }
?>
