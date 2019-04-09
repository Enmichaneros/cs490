<?php 
	session_start();
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>Release Candidate</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
    <main>
        <div class="login-page">
            <div class="form">
                <form class="login-form" action="includes/login.inc.php" method="post">
                    <h2>Sign In</h2>
                    <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == "emptyfields"){
                                echo '<p class="loginerror">Fill in all the fields!</p>';
                            }
                            else if ($_GET['error'] == "invalidlogin"){
                                echo '<p class="loginerror">Check your credentials!</p>';
                            }
                        }
                    ?>
                    <input type="text" name="username" placeholder="UCID">
                    <input type="password" name="password" placeholder="PASSWORD">
                    <button type="submit" name="submit">Login</button>  
                </form>
            </div>
        </div>
    </main>
</body>
    
</html>
    
