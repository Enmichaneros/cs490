<?php
    include("db_details.php");

   $qid = $_POST['QID'];
   $testid = $_POST['TestID'];
    // $qid = '3';
    // $testid = '5';
    

    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $send_tc = "SELECT Input, Output, Points FROM TEST_QUES TQ, TESTCASES TC WHERE TC.QID=TQ.QID AND TQ.TestID='$testid' AND TQ.QID='$qid';";

    ( $t = mysql_query( $send_tc )) or die (mysql_error());

    while( $r = mysql_fetch_array($t))
    {
        $Points =htmlspecialchars($r["Points"]);
        $Input =htmlspecialchars($r["Input"]);
        $Output =htmlspecialchars($r["Output"]);
        echo json_encode(array('input' => "$Input",'output' => "$Output",'points' => "$Points"));

    }

?>
