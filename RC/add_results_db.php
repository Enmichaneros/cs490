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
        $r = mysql_fetch_array($add_t);
        $grade=htmlspecialchars($r["Grade"]); 
        $updated_grade = intval($grade) + intval($earnedpts);
        $query = "UPDATE EXAM SET Grade='$updated_grade' WHERE UCID='$ucid' AND TestID='$testid';";
    }
    else {
        $query = "INSERT INTO EXAM (UCID,TestID, Grade) VALUES ('$ucid','$testid','$earnedpts');";
    }


    ( $add_points = mysql_query( $query ) or die (mysql_error()) );

    if ($added) {
        echo "Submitted";
    }
?>
