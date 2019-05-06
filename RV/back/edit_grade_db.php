<?php
    include("db_details.php");

    $ucid = $_POST['UCID'];
    $testid = $_POST['TestID'];
    $qid = explode("```", $_POST['QID']);
    $deduct = explode("```", $_POST['EarnedPts']);
    $comments = explode("```", $_POST['Comments']);
    $num = explode("```", $_POST['Num']);
    
    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);
        
    for ($i = 0; $i < count($num); $i++) {
        $edit_resulttc = "UPDATE RESULTS_TC SET Deduct='$deduct[$i]', RC='$comments[$i]' WHERE UCID='$ucid' AND TestID='$testid' AND QID='$qid[$i]' AND Num='$num[$i]';";
        
        ( $editted = mysql_query( $edit_resulttc ) or die (mysql_error()) );
                
        $p = "SELECT SUM(Deduct) FROM RESULTS_TC WHERE TestID='$testid' AND QID='$qid[$i]' AND UCID='$ucid';";
        ( $tp = mysql_query( $p ) or die (mysql_error()) );
        
        $tp = mysql_fetch_array($tp);
        $t=htmlspecialchars($tp["SUM(Deduct)"]);
        
         $total_points = "SELECT Points FROM TEST_QUES WHERE TestID='$testid' AND QID='$qid[$i]';";
        ( $tqp = mysql_query( $total_points ) or die (mysql_error()) );
        
        $tqp = mysql_fetch_array($tqp);
        $tpoints=htmlspecialchars($tqp["Points"]);
        
        $cpoints = intval($tpoints) - intval($t);
        
        $edit_result = "UPDATE RESULTS SET EarnedPts='$cpoints' WHERE UCID='$ucid' AND TestID='$testid' AND QID='$qid[$i]';";
        ( $er = mysql_query( $edit_result ) or die (mysql_error()) );
        
    }

    $exam_grade = "SELECT SUM(Deduct) FROM RESULTS_TC WHERE TestID='$testid' AND UCID='$ucid';";
    ( $eg = mysql_query( $exam_grade ) or die (mysql_error()) );

    $eg = mysql_fetch_array($eg);
    $grade=htmlspecialchars($eg["SUM(Deduct)"]);

    $total_grade = "SELECT TotalPoints FROM TESTS WHERE TestID='$testid';";
    ( $tg = mysql_query( $total_grade ) or die (mysql_error()) );

    $tg = mysql_fetch_array($tg);
    $tgrade=htmlspecialchars($tg["TotalPoints"]);

    $cgrade = intval($tgrade) - intval($grade);

    $edit_exam = "UPDATE EXAM SET Grade='$cgrade' WHERE UCID='$ucid' AND TestID='$testid';";
    ( $ee = mysql_query( $edit_exam ) or die (mysql_error()) );


    if ($editted) {
        echo "Editted Grades";
    }
?>
