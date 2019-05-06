<?php
    include("db_details.php");

//    $code = $_POST['Code'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $avail_tests = "SELECT DISTINCT E.TestID, T.TestName FROM EXAM E LEFT JOIN TESTS T ON E.TestID = T.TestID;";

    ( $at = mysql_query( $avail_tests )) or die (mysql_error());
    if(mysql_num_rows($at) == 0) die ("no data");

    $out = "<select id='availTest' style='margin-left:20px;'>";

    while( $r = mysql_fetch_array($at))
    {
        $TestName =htmlspecialchars($r["TestName"]);
        $TestID =htmlspecialchars($r["TestID"]);

        $out .= "<option value='$TestID'>$TestName</option>";
    }
    $out .= "</select>";
    $out .= "<input type='button' class='examGrades' value='Show Grades for Exam' onclick='showGradeExam()'>";
    print $out;
    print "<br><br>";
?>
