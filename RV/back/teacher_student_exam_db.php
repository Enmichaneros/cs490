<?php
    include("db_details.php");

    $testid = $_POST['TestID'];
    $ucid = $_POST['UCID'];


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
    $out .= "<th> Question </th> <th> Student Answer </th> <th> Earned Points </th> <th> Total Points </th><th>  </th>";
    $out .= "</tr>";
       

    while( $test = mysql_fetch_array($sr))
    {
        $QID =htmlspecialchars($test["QID"]);
        $QText =htmlspecialchars($test["QText"]);
        $Points =htmlspecialchars($test["Points"]);
        $EarnedPts =htmlspecialchars($test["EarnedPts"]);
        $AnsText =htmlspecialchars($test["AnsText"]);
        $Comments =htmlspecialchars($test["Comments"]);

        $result_tc = "SELECT Deduct, RC FROM RESULTS_TC T WHERE TestID='$testid' AND QID='$QID' AND UCID='$ucid';";
        ( $resulttc = mysql_query( $result_tc )) or die (mysql_error());
        
        $out .= "<tr>";
        $out .= "<td align='center'> $QText </td> <td align='center'> <textarea readonly class='answerCode codearea' rows='50' cols='300' style='width:450px; height: 150px; resize: none;'>$AnsText</textarea> </td> <td align='center'> $EarnedPts </td><td align='center'> $Points </td> <td align='center'> <table> <tr> <th>Deduction</th><th>Comment</th></tr>";
        
        while( $t = mysql_fetch_array($resulttc)) {
            
            $Deduct =htmlspecialchars($t["Deduct"]);
            $RC =htmlspecialchars($t["RC"]);
            $out .= "<tr>";
            $out .= "<td align='center'> <input type='text' value='$Deduct' class='changesToPoints' id='$QID'> </td><td align='center'> <textarea class='changesToComments codearea' id='$QID' rows='15' cols='200' style='width: 200px; height: 75px; resize: none;'>$RC</textarea>";
            $out .= "</tr>";
        }
        
        $out .= "</table></td>";
        $out .= "</tr>";
    }

    $out .= "</table>";

    print $out;
    print "<br><br>";

?>
