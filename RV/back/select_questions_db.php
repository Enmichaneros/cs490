<?php
    include("db_details.php");

    $qid = $_POST['QID'];

    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);


    $out = "";

    $out .= "<style> table, th, caption{margin:auto;} </style>";
    $out .= "<style>th{background : #ffffff ;}</style>";

    //add headers and caption to the table
    $out .= "<table>";

    $out .= "<tr>";
    $out .= "<th> Question </th> <th> Points </th>";
    $out .= "</tr>";

    $qidList = explode(" ", $qid);

    for( $i = 0; $i<count($qidList)-1; $i++ ) {
        
        $select_questions = "SELECT QID, QText FROM QUESTION WHERE QID='$qidList[$i]';";
        ( $select_q = mysql_query( $select_questions ) or die (mysql_error()) );
        
        $r = mysql_fetch_array($select_q);
        $QID=htmlspecialchars($r["QID"]);
        $QText=htmlspecialchars($r["QText"]);
        
        $out .= "<tr>";
        $out .= "<td style='margin-bottom: 5px;'> <p class='selectedQues' id=".$QID.">$QText</p> </td> <td style='margin-bottom: 5px;'> <input type='text' class='pointsToQues' id='pointsToQues' oninput='calcPoints()' style='width: 50px;'> </td>";
        $out .= "</tr>";
        
    }

    $out .= "</table>";

    print $out;
    print "<br><br>";

?>
