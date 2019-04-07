<?php 
	session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>Release Candidate</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <main>
        <div class="wrapper-main">
            <section class="section-default">
                <h1>Sign In</h1>
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
                <form class="signup-form" action="includes/login.inc.php" method="post">
                    <input type="text" name="UCID" placeholder="UCID">
                    <input type="password" name="Pass" placeholder="PASSWORD">
                    <button type="submit" name="submit">Login</button>  
                </form>
            </section>
        </div>
    </main>
</body>
    
</html>
    

