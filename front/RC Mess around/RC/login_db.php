<?php
    include("db_details.php");

    $user = $_POST['username'];
    $pass = $_POST['password'];

    ($dbh = mysql_connect ($hostname,$username,$password))
            or die("Unable to connect to MySQL database");

    mysql_select_db($project);

    $logintype = "SELECT AccType FROM USER WHERE UCID='$user' AND Pass='$pass';";
    $row = mysql_fetch_assoc(mysql_query( $logintype )); 
    $acctype = $row['AccType'];

    if($acctype=='Teacher'){
        echo json_encode(array('acctype' => 'Teacher'));
    }
    elseif($acctype=='Student'){
        echo json_encode(array('acctype' => 'Student'));
    }
    else{
        echo json_encode(array('acctype' => 'Neither'));
    }

?>
