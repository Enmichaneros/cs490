<?php
    include("db_details.php");

    $diff = $_POST['Diff'];
    $keyword = $_POST['Keyword'];
    $topic = $_POST['Topic'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    if($diff != '' and $keyword != '' and $topic != ''){
        $filter = "SELECT Q.QID, QText, Diff FROM QUESTIONS Q, QUES_KEY QK, QUES_TYPE QT WHERE Q.QID = QK.QID AND Q.QID = QT.QID AND Diff='$diff' AND Keyword='$keyword' AND Topic='$topic';";
    }
    elseif($diff != '' and $keyword != '' and $topic == ''){
        $filter = "SELECT Q.QID, QText, Diff FROM QUESTIONS Q, QUES_KEY QK WHERE Q.QID = QK.QID AND Diff='$diff' AND Keyword='$keyword';";
    }
    elseif($diff != '' and $keyword == '' and $topic != ''){
        $filter = "SELECT Q.QID, QText, Diff FROM QUESTIONS Q, QUES_TYPE QT WHERE Q.QID = QT.QID AND Diff='$diff' AND Topic='$topic';";
    }
    elseif($diff == '' and $keyword != '' and $topic !=''){
        $filter = "SELECT Q.QID, QText, Diff FROM QUESTIONS Q, QUES_KEY QK, QUES_TYPE QT WHERE Q.QID = QK.QID AND Q.QID = QT.QID AND Keyword='$keyword' AND Topic='$topic';";
    }
    elseif($diff == '' and $keyword == '' and $topic !=''){
        $filter = "SELECT Q.QID, QText, Diff FROM QUESTIONS Q, QUES_TYPE QT WHERE Q.QID = QT.QID AND Topic='$topic';";
    }
    elseif($diff == '' and $keyword != '' and $topic ==''){
        $filter = "SELECT Q.QID, QText, Diff FROM QUESTIONS Q, QUES_KEY QK WHERE Q.QID = QK.QID AND Keyword='$keyword';";

    }  
    elseif($diff != '' and $keyword == '' and $topic ==''){
        $filter = "SELECT Q.QID, QText, Diff FROM QUESTIONS Q WHERE Diff='$diff';";

    }

    ( $t = mysql_query( $filter )) or die (mysql_error());
    if(mysql_num_rows($t) == 0) die ("no data");

    $out = "";

    $out .= "<style> table, th, caption{margin:auto;} </style>";
    $out .= "<style>th{background : #ffffff ;}</style>";

    //add headers and caption to the table
    $out .= "<table>";

    $out .= "<tr>";
    $out .= "<th> QID </th> <th> QText </th> <th> Diff </th> ";
    $out .= "</tr>";

    while( $r = mysql_fetch_array($t))
    {
        $QID   =htmlspecialchars($r["QID"]);
        $QText  =htmlspecialchars($r["QText"]);
        $Diff = htmlspecialchars($r["Diff"]);

        $out .= "<tr>";
        $out .= "<td align='center'> $QID </td> <td align='center'> $QText </td> <td align='center'> $Diff </td> ";
        $out .= "</tr>";
    }
    $out .= "</table>";

    print $out;
    print "<br><br>";
?>
