<?php
    include("db_details.php");

    $ucid = $_POST['UCID'];
    $testid = $_POST['TestID'];
    $qid = $_POST['QID'];
    $num = $_POST['Num'];
    $deduct = $_POST['Deduct'];
    $rc = $_POST['RC'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $add_resulttc = "INSERT INTO RESULTS_TC (UCID, TestID, QID, Num, Deduct, RC) VALUES ('$ucid','$testid', '$qid', '$num', '$deduct', '$rc');";
    ( $added = mysql_query( $add_resulttc ) or die (mysql_error()) );
    

    if ($added) {
        echo "Submitted";
    }
?>
