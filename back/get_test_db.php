<?php
    include("db_details.php");

    $testid = $_POST['TestID'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $show_tests = "SELECT QText, Input, Output FROM TESTS T, TEST_QUES TQ, QUESTIONS Q, TESTCASES TC WHERE TQ.QID = Q.QID AND Q.QID = TC.QID AND T.TestID = TQ.TestID AND TQ.TestID='$testid';";

    ( $t = mysql_query( $show_tests )) or die (mysql_error());
    if(mysql_num_rows($t) == 0) die ("no data");

    $out = "";

    //add headers and caption to the table

    while( $r = mysql_fetch_array($t))
    {
        $QText =htmlspecialchars($r["QText"]);
        $Input =htmlspecialchars($r["Input"]);
        $Output =htmlspecialchars($r["Output"]);


        $out .= "<p> Question: $QText </p> <p> Input: $Input </p> <p> Output: $Output </p>";
        $out .= "<code><textarea id = 'myTextArea' rows = '10' cols = '80'>Write Code Here</textarea></code> <br><br><br>";
    }

    print $out;
    print "<br><br>";
?>
