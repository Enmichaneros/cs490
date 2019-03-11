<?php
    include("db_details.php");

    $testid = $_POST['TestID'];
    $ucid = $_POST['UCID'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);
  
    $show_scores = "SELECT QID, EarnedPts, Comments FROM RESULTS WHERE UCID='$ucid' AND TestID='$testid';";
    $show_sum = "SELECT SUM(EarnedPts) FROM RESULTS WHERE UCID='$ucid' AND TestID='$testid';";
    $show_total_sum = "SELECT SUM(Points) FROM TEST_QUES WHERE TestID='$testid';";

    ( $t = mysql_query( $show_scores )) or die (mysql_error());
    ( $s = mysql_query( $show_sum )) or die (mysql_error());
    ( $ts = mysql_query( $show_total_sum )) or die (mysql_error());

    if(mysql_num_rows($t) == 0) die ("no data");

    $out = "";

    $out .= "<style> table, th, caption{margin:auto;} </style>";
    $out .= "<style>th{background : #ffffff ;}</style>";

    //add headers and caption to the table
    $out .= "<table>";

    $out .= "<tr>";
    $out .= "<th> QID </th> <th> EarnedPts </th> <th> Comments </th> ";
    $out .= "</tr>";

    while( $r = mysql_fetch_array($t))
    {
        $QID =htmlspecialchars($r["QID"]);
        $EarnedPts =htmlspecialchars($r["EarnedPts"]);
        $Comments =htmlspecialchars($r["Comments"]);


        $out .= "<tr>";
        $out .= "<td align='center'> $QID </td> <td align='center'> $EarnedPts </td> <td align='center'> $Comments </td>";
        $out .= "</tr>";
    }
    $out .= "</table>";

    $es = mysql_fetch_assoc($s); 
    $totals = mysql_fetch_assoc($ts); 
    $earned_sum = $es['SUM(EarnedPts)'];
    $total_sum = $totals['SUM(Points)'];
//    $out .= "<p> Grade: " . $earned_sum . "/" . $total_sum . " </p>";
    print $out;
    print "<br><br>";
?>
