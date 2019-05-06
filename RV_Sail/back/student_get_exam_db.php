<?php
    include("db_details.php");

    $testid = $_POST['TestID'];
    $ucid = $_POST['UCID'];
//    $testid = '2';
//    $ucid = 'sk2292';

    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);


    $student_info = "SELECT E.Grade, U.Fname, U.Lname FROM USER U, EXAM E WHERE U.UCID='$ucid' AND E.UCID=U.UCID AND E.TestID='$testid';";
    ( $stud_info = mysql_query( $student_info )) or die (mysql_error());

    $testname = "SELECT TestName FROM TESTS T WHERE TestID='$testid';";
    ( $testname = mysql_query( $testname )) or die (mysql_error());


    $show_results = "SELECT Q.QText, R.QID, R.EarnedPts, R.AnsText, R.Comments, TQ.Points FROM RESULTS R, QUESTION Q, TEST_QUES TQ WHERE Q.QID=R.QID AND R.TestID='$testid' AND R.UCID='$ucid' AND TQ.TestID=R.TestID AND TQ.QID=R.QID;";
    ( $sr = mysql_query( $show_results )) or die (mysql_error());
    if(mysql_num_rows($sr) == 0) die ("no data");

    $s_info = mysql_fetch_array($stud_info);
    $fname =htmlspecialchars($s_info["Fname"]);
    $lname =htmlspecialchars($s_info["Lname"]);
    $grade =htmlspecialchars($s_info["Grade"]);

    $testn = mysql_fetch_array($testname);
    $tname =htmlspecialchars($testn["TestName"]);

    $out = "";

    $out .= "<p id='$testid' class='test_info'>Test Name: $tname </p><p id='$ucid' class='student_info'> Name:".$lname.", ".$fname."</p><p>Grade: $grade</p>";

    $out .= "<style> table, th, caption{margin:auto;} </style>";
    $out .= "<style>th{background : #ffffff ;}</style>";

    //add headers and caption to the table
    $out .= "<table>";

    $out .= "<tr>";
    $out .= "<th> Question </th> <th> Your Answer </th> <th> Earned Points </th> <th> Total Points </th><th> Comments </th>";
    $out .= "</tr>";
       

    while( $test = mysql_fetch_array($sr))
    {
        $QID =htmlspecialchars($test["QID"]);
        $QText =htmlspecialchars($test["QText"]);
        $Points =htmlspecialchars($test["Points"]);
        $EarnedPts =htmlspecialchars($test["EarnedPts"]);
        $AnsText =htmlspecialchars($test["AnsText"]);
        $Comments =htmlspecialchars($test["Comments"]);


        $out .= "<tr>";
        $out .= "<td align='center'> $QText </td> <td align='center'> <textarea readonly class='answerCode' rows='50' cols='300' style='width:450px; height: 150px; resize: none;'>$AnsText</textarea> </td> <td align='center'> $EarnedPts </td> <td align='center'> $Points </td> <td align='center'> <textarea readonly class='changesToComments' id='$QID' rows='50' cols='300' style='width: 300px; height: 150px; resize: none;'>$Comments</textarea> </td>";
        $out .= "</tr>";
    }

    $out .= "</table>";

    print $out;
    print "<br><br>";

?>
