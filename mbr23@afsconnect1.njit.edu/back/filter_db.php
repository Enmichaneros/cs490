<?php
    include("db_details.php");

    $diff = $_POST['Diff'];
    $keyword = $_POST['Keyword'];
    $topic = $_POST['Topic'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    if($diff != 'allDifficulty' and $keyword != '' and $topic != 'allTopics'){
        $filter = "SELECT Q.QID, QText FROM QUESTION Q, QUES_TYPE QT WHERE Q.QID = QT.QID AND QText LIKE '%$keyword%' AND Diff='$diff' AND Topic='$topic';";
    }
    elseif($diff != 'allDifficulty' and $keyword != '' and $topic == 'allTopics'){
        $filter = "SELECT Q.QID, QText FROM QUESTION Q WHERE Diff='$diff' AND QText LIKE '%$keyword%';";
    }
    elseif($diff != 'allDifficulty' and $keyword == '' and $topic != 'allTopics'){
        $filter = "SELECT Q.QID, QText FROM QUESTION Q, QUES_TYPE QT WHERE Q.QID = QT.QID AND Diff='$diff' AND Topic='$topic';";
    }
    elseif($diff == 'allDifficulty' and $keyword != '' and $topic != 'allTopics'){
        $filter = "SELECT Q.QID, QText FROM QUESTION Q, QUES_TYPE QT WHERE Q.QID = QT.QID AND QText LIKE '%$keyword%' AND Topic='$topic';";
    }
    elseif($diff == 'allDifficulty' and $keyword == '' and $topic !='allTopics'){
        $filter = "SELECT Q.QID, QText FROM QUESTION Q, QUES_TYPE QT WHERE Q.QID = QT.QID AND Topic='$topic';";
    }
    elseif($diff == 'allDifficulty' and $keyword != '' and $topic =='allTopics'){
        $filter = "SELECT Q.QID, QText FROM QUESTION Q WHERE QText LIKE '%$keyword%';";
    }  
    elseif($diff != 'allDifficulty' and $keyword == '' and $topic == 'allTopics'){
        $filter = "SELECT Q.QID, QText FROM QUESTION Q WHERE Diff='$diff';";
    }
    elseif($diff == 'allDifficulty' and $keyword == '' and $topic == 'allTopics'){
        $filter = "SELECT Q.QID, QText FROM QUESTION Q;";
    }

    ( $t = mysql_query( $filter )) or die (mysql_error());
    if(mysql_num_rows($t) == 0) die ("No Matches");

    $out = "";

    $out .= "<style> table, th, caption{margin:auto;} </style>";
    $out .= "<style>th{background : #ffffff ;}</style>";

    //add headers and caption to the table
    $out .= "<table cellspacing='30'>";

    $out .= "<tr>";
    $out .= "<th> Select </th> <th> Question </th>";
    $out .= "</tr>";

    while( $r = mysql_fetch_array($t))
    {
        $QID   =htmlspecialchars($r["QID"]);
        $QText  =htmlspecialchars($r["QText"]);

        $out .= "<tr>";
        $out .= "<td style='margin-bottom: 20px;'> <input type='checkbox' class='checkQuestion' id='checkQuestion' name=".$QID."> </td> <td style='margin-bottom: 20px;'> $QText </td> ";
        $out .= "</tr>";
    }
    $out .= "</table>";

    print $out;
    print "<br><br>";
?>
