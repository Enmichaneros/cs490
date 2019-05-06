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
    

    $add_total = "SELECT Grade FROM EXAM WHERE UCID='$ucid' AND TestID='$testid';";
    ( $add_t = mysql_query( $add_total ) or die (mysql_error()) );


    if(mysql_num_rows($add_t) > 0)
    {
        $exam_grade = "SELECT SUM(EarnedPts) FROM RESULTS WHERE TestID='$testid' AND UCID='$ucid';";
        ( $eg = mysql_query( $exam_grade ) or die (mysql_error()) );
        
        $eg = mysql_fetch_array($eg);
        $grade=htmlspecialchars($eg["SUM(EarnedPts)"]);
        
        $edit_exam = "UPDATE EXAM SET Grade='$grade' WHERE UCID='$ucid' AND TestID='$testid';";
        ( $ee = mysql_query( $edit_exam ) or die (mysql_error()) );
    }
    else {
        $query = "INSERT INTO EXAM (UCID,TestID, Grade, Released) VALUES ('$ucid','$testid','$earnedpts','0');";
        ( $add_points = mysql_query( $query ) or die (mysql_error()) );
    }


    if ($added) {
        echo "Submitted";
    }
?>
