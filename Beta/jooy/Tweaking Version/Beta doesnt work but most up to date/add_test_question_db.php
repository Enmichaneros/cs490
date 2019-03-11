<?php
    include("db_details.php");

    $testid = $_POST['TestID'];
    $qid = $_POST['QID'];
    $points = $_POST['Points'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $add_test_question = "INSERT INTO TEST_QUES (TestID, QID, Points) VALUES
((SELECT TestID FROM TESTS WHERE TestID = '$testid'), '$qid','$points');";

    ( $atq = mysql_query( $add_test_question )) or die (mysql_error());

    if($atq){
        echo json_encode(array('atq' => 'Yes'));
    }
    else{
        echo json_encode(array('atq' => 'No'));
    }
?>
