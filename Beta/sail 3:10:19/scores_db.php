<?php
    include("db_details.php");

    $testid = $_POST['TestID'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $show_tests = "SELECT UCID, QID, EarnedPts, AnsText, Comments FROM RESULTS WHERE TestID='$testid';";

    ( $t = mysql_query( $show_tests )) or die (mysql_error());
    if(mysql_num_rows($t) == 0) die ("no data");

    $out = "";

    $out .= "<style> table, th, caption{margin:auto;} </style>";
    $out .= "<style>th{background : #ffffff ;}</style>";

    //add headers and caption to the table
    $out .= "<table>";

    $out .= "<tr>";
    $out .= "<th> UCID </th> <th> QID </th> <th> EarnedPts </th> <th> AnsText </th> <th> Comments </th>";
    $out .= "</tr>";

    while( $r = mysql_fetch_array($t))
    {
        $UCID =htmlspecialchars($r["UCID"]);
        $QID =htmlspecialchars($r["QID"]);
        $EarnedPts =htmlspecialchars($r["EarnedPts"]);
        $AnsText =htmlspecialchars($r["AnsText"]);
        $Comments =htmlspecialchars($r["Comments"]);

        $out .= "<tr>";
        $out .= "<td align='center'> $UCID </td> <td align='center'> $QID </td> <td align='center'> $EarnedPts </td> <td align='center'> $AnsText </td> <td align='center'> $Comments </td>";
        $out .= "</tr>";
    }
    $out .= "</table>";

    print $out;
    print "<br><br>";
?>
