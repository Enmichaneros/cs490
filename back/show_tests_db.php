<?php
    include("db_details.php");

    $status = $_POST['Status'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $show_tests = "SELECT TestID FROM TESTS WHERE Status='$status';";

    ( $t = mysql_query( $show_tests )) or die (mysql_error());
    if(mysql_num_rows($t) == 0) die ("no data");

    $out = "";

    $out .= "<style> table, th, caption{margin:auto;} </style>";
    $out .= "<style>th{background : #ffffff ;}</style>";

    //add headers and caption to the table
    $out .= "<table>";

    $out .= "<tr>";
    $out .= "<th> TestID </th> ";
    $out .= "</tr>";

    while( $r = mysql_fetch_array($t))
    {
        $TestID =htmlspecialchars($r["TestID"]);

        $out .= "<tr>";
        $out .= "<td align='center'> $TestID </td>";
        $out .= "</tr>";
    }
    $out .= "</table>";

    print $out;
    print "<br><br>";
?>
