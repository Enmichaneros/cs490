<?php
    include("db_details.php");

    $testname = $_POST['TestName'];
    $qid = $_POST['QID'];
    $points = $_POST['Points'];
    $totalpoints = $_POST['TotalPoints'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);


    $add_test = "INSERT INTO TESTS (TestName, TotalPoints) VALUES ('$testname','$totalpoints');";
        ( $added_test = mysql_query( $add_test ) or die (mysql_error()) );



    $select_test = "SELECT TestID FROM TESTS WHERE TestName='$testname' AND TotalPoints='$totalpoints';";
        ( $select_t = mysql_query( $select_test ) or die (mysql_error()) );
        
    $r = mysql_fetch_array($select_t);
    $TestID=htmlspecialchars($r["TestID"]);

    $QIDList = explode(" ", $qid);
    $pointsList = explode(" ", $points);

    for( $i = 0; $i<count($QIDList)-1; $i++ ) {
        $QID = intval($QIDList[$i]);
        $Points = intval($pointsList[$i]);
        $add_test_ques = "INSERT INTO TEST_QUES (TestID, QID, Points) VALUES ('$TestID','$QID','$Points');";
        ( $added_tq = mysql_query( $add_test_ques ) or die (mysql_error()) );
    }
    
    if ($added_tq and $added_test) {
        echo "Created";
    }
    else {
        echo "Did Not Create";
    }
?>
