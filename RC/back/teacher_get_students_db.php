<?php
    include("db_details.php");

    $testid = $_POST['TestID'];


    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $avail_tests = "SELECT U.Fname, U.Lname, E.UCID FROM USER U, EXAM E LEFT JOIN TESTS T ON E.TestID = T.TestID WHERE E.TestID='$testid' AND E.UCID=U.UCID;";

    ( $at = mysql_query( $avail_tests )) or die (mysql_error());
    if(mysql_num_rows($at) == 0) die ("no data");

    $out = "<select id='availStudents' style='margin-left:20px;'>";

    while( $r = mysql_fetch_array($at))
    {
        $UCID =htmlspecialchars($r["UCID"]);
        $fname =htmlspecialchars($r["Fname"]);
        $lname =htmlspecialchars($r["Lname"]);

        $out .= "<option value='$UCID'>".$lname.", ".$fname."</option>";
    }
    $out .= "</select>";
    $out .= "<input type='button' value='Show Grade for Student' onclick='showGradeStudent()'>";
    print $out;
    print "<br><br>";
?>
