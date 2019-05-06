<?php
    include("db_details.php");

   $testid = $_POST['TestID'];
    

    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $send_tc = "SELECT QID FROM TEST_QUES TQ WHERE TQ.TestID='$testid'";

    ( $t = mysql_query( $send_tc )) or die (mysql_error());

    while( $r = mysql_fetch_array($t))
    {
        $Points =htmlspecialchars($r["Points"]);
        $Input =htmlspecialchars($r["Input"]);
        $Output =htmlspecialchars($r["Output"]);
        echo json_encode(array('input' => "$Input",'output' => "$Output",'points' => "$Points"));

    }

?>
