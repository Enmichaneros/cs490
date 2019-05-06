<?php 
	session_start();
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>Release Version</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
</head>
<body>
    
    <div class="main">
        <p class="sign" align="center">Sign in</p>

        <form class="form1" action="includes/login.inc.php" method="post">
            <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyfields"){
                            echo '<p class="errorsign">Fill in all the fields!</p>';
                        }
                        else if ($_GET['error'] == "invalidlogin"){
                            echo '<p class="errorsign">Check your credentials!</p>';
                        }
                    }
                ?>
            <input class="un " type="text" name="username" align="center" placeholder="Username">
            <input class="pass" name="password" type="password" align="center" placeholder="Password">
            <button type="submit" class="submit" name="submit">Sign in</button>  
        </form>
                 
    </div>
    
    

</body>
    
</html>
    