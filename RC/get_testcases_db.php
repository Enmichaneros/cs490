<?php
    include("db_details.php");

    $qid = $_POST['QID'];
    $testid = $_POST['TestID'];

    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $send_tc = "SELECT Input, Output, Points FROM TEST_QUES TQ, TESTCASES TC WHERE TC.QID=TQ.QID AND TQ.TestID='$testid' AND TC.QID='$qid';";
    ( $t = mysql_query( $send_tc )) or die (mysql_error());

    $uses = "SELECT ForLoop, WhileLoop, ReturnStatement, PrintStatement FROM QUES_NEC WHERE QID='$qid';";
    ( $u = mysql_query( $uses )) or die (mysql_error());

    $func = "SELECT FuncName FROM QUESTION WHERE QID='$qid';";
    ( $name = mysql_query( $func )) or die (mysql_error());

    $points_string = "";
    $input_string = "";
    $output_string = "";
    while( $r = mysql_fetch_array($t))
    {
        $Points =htmlspecialchars($r["Points"]);
        $Input =htmlspecialchars($r["Input"]);
        $Output =htmlspecialchars($r["Output"]);
        
        $points_string = $Points;
        $input_string .= $Input . "```";
        $output_string .= $Output . "```";
    }


    $use = mysql_fetch_array($u);
    $for =htmlspecialchars($r["ForLoop"]);
    $while =htmlspecialchars($r["WhileLoop"]);
    $return =htmlspecialchars($r["ReturnStatement"]);
    $print =htmlspecialchars($r["PrintStatement"]);
        

    $funcName = mysql_fetch_array($name);
    $func_name =htmlspecialchars($r["FuncName"]);
        
    echo json_encode(array('input' => "$input_string",'output' => "$output_string",'points' => "$points_string",'for' => "$for",'while' => "$while",'return' => "$return",'print' => "$print",'function' => "$func_name"));

?>
