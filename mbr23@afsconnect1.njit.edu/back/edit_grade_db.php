<?php
    include("db_details.php");

    $ucid = $_POST['UCID'];
    $testid = $_POST['TestID'];
    $qid = explode("```", $_POST['QID']);
    $earnedpts = explode("```", $_POST['EarnedPts']);
    $comments = explode("```", $_POST['Comments']);


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    for ($i = 0; $i < count($qid); $i++) {
        $edit_result = "UPDATE RESULTS SET EarnedPts='$earnedpts[$i]', Comments='$comments[$i]' WHERE UCID='$ucid' AND TestID='$testid' AND QID='$qid[$i]';";
        ( $editted = mysql_query( $edit_result ) or die (mysql_error()) );
        
        $exam_grade = "SELECT SUM(EarnedPts) FROM RESULTS WHERE TestID='$testid' AND UCID='$ucid';";
        ( $eg = mysql_query( $exam_grade ) or die (mysql_error()) );
        
        $eg = mysql_fetch_array($eg);
        $grade=htmlspecialchars($eg["SUM(EarnedPts)"]);
        
        $edit_exam = "UPDATE EXAM SET Grade='$grade' WHERE UCID='$ucid' AND TestID='$testid';";
        ( $ee = mysql_query( $edit_exam ) or die (mysql_error()) );
    }


    if ($editted) {
        echo "Editted Grades";
    }
?>
