<?php
    include("db_details.php");

    $testid = $_POST['TestID'];
    $teacher = $_POST['Teacher'];
    $status = $_POST['Status'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $make_test = "INSERT INTO TESTS (TestID, TUCID, Status) VALUES ('$testid','$teacher','$status');";

    ( $mt = mysql_query( $make_test )) or die (mysql_error());

    if($mt){
        echo json_encode(array('test_created' => 'Yes'));
    }
    else{
        echo json_encode(array('test_created' => 'No'));
    }
?>
