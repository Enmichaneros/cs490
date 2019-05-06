<?php
    include("db_details.php");

    $testid = $_POST['TestID'];

    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);


    $show_test = "SELECT TQ.QID, Q.QText, TQ.Points FROM TEST_QUES TQ, QUESTION Q WHERE TQ.QID=Q.QID AND TQ.TestID='$testid';";
    ( $t = mysql_query( $show_test )) or die (mysql_error());
    if(mysql_num_rows($t) == 0) die ("no data");

    $show_test_info = "SELECT TestID, TestName, TotalPoints FROM TESTS WHERE TestID='$testid';";
    ( $ti = mysql_query( $show_test_info )) or die (mysql_error());
    if(mysql_num_rows($ti) == 0) die ("no data");

    $r = mysql_fetch_array($ti);
    $TestID =htmlspecialchars($r["TestID"]);
    $TestName =htmlspecialchars($r["TestName"]);
    $TotalPoints =htmlspecialchars($r["TotalPoints"]);


    $out = "";

    $out .= "<p id='$TestID' class='exam_info'> Test: $TestName </p><p>Total Points: $TotalPoints</p>";

    $out .= "<style> table, th, caption{margin:auto;} </style>";
    $out .= "<style>th{background : #ffffff ;}</style>";

    //add headers and caption to the table
    $out .= "<table>";

    $out .= "<tr>";
    $out .= "<th> Question </th> <th> Write Code Here </th> <th> Points </th>";
    $out .= "</tr>";
       

    while( $test = mysql_fetch_array($t))
    {
        $QID =htmlspecialchars($test["QID"]);
        $QText =htmlspecialchars($test["QText"]);
        $Points =htmlspecialchars($test["Points"]);
        

        $out .= "<tr>";
        $out .= "<td align='center'> $QText </td> <td align='center'> <textarea class='answerCode codearea' id='$QID' rows='50' cols='300' style='width: 600px; height: 300px; resize: none;'></textarea> </td> <td align='center'> $Points </td>";
        $out .= "</tr>";
    }

    $out .= "</table>";

    print $out;
    print "<br><br>";

?>
