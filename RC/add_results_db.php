<?php
    include("db_details.php");

    $ucid = $_POST['UCID'];
    $testid = $_POST['TestID'];
    $qid = $_POST['QID'];
    $earnedpts = $_POST['EarnedPts'];
    $anstext = $_POST['AnsText'];
    $comments = $_POST['Comments'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $add_result = "INSERT INTO RESULTS (UCID, TestID, QID, EarnedPts, AnsText, Comments) VALUES ('$ucid','$testid', '$qid', '$earnedpts', '$anstext', '$comments');";
    ( $added = mysql_query( $add_result ) or die (mysql_error()) );
    
    if ($added) {
        echo "Submitted";
    }
?>
