<?php
    include("db_details.php");

    $code = $_POST['Code'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $submit_test = "INSERT INTO RESULTS;";

    ( $t = mysql_query( $show_tests )) or die (mysql_error());
    if(mysql_num_rows($t) == 0) die ("no data");

    $out = "";

    $out .= "<style> table, th, caption{margin:auto;} </style>";
    $out .= "<style>th{background : #ffffff ;}</style>";

    //add headers and caption to the table
    $out .= "<table>";

    $out .= "<tr>";
    $out .= "<th> Open </th> <th> Test Name </th> <th> Total Points </th>";
    $out .= "</tr>";

    while( $r = mysql_fetch_array($t))
    {
        $TestName =htmlspecialchars($r["TestName"]);
        $TotalPoints =htmlspecialchars($r["TotalPoints"]);
        $TestID =htmlspecialchars($r["TestID"]);


        $out .= "<tr>";
        $out .= "<td align='center'> <input type='checkbox' id='$TestID' class='openExam'> </td><td align='center'> $TestName </td><td align='center'> $TotalPoints </td>";
        $out .= "</tr>";
    }
    $out .= "</table>";
    $out .= "<input type='button' class='openExam' value='Open Exam' onclick='openExam()'>";
    print $out;
    print "<br><br>";
?>
