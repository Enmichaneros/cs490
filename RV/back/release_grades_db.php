<?php
    include("db_details.php");

    $testid = $_POST['TestID'];

    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

        
    $update = "UPDATE EXAM SET Released='1' WHERE TestID='$testid';";
    ( $update_r = mysql_query( $update ) or die (mysql_error()) );

    if ($update_r){
        echo "Released";
    }

?>
