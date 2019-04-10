
<?php 
	session_start();
    $_SESSION['fname'] = "John";
    $_SESSION["username"] = "jj";
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
	<title>Release Candidate</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
	<div class="navbar">
            <a href="https://web.njit.edu/~sk2292/RC/teacher_add_questions.html">Add Questions</a>
            <a href="https://web.njit.edu/~sk2292/RC/teacher_make_test.html">Make Test</a>
            <a href="https://web.njit.edu/~sk2292/RC/teacher_grades.html">Grades</a>
            <?php
                if (isset($_SESSION['username'])) {
                    echo '<a class = "disabled" disabled>Hello '.$_SESSION["fname"].'</a>';
                    
				    echo '<form action="includes/logout.inc.php" method="POST">
								<button class = "button" type="submit" name = "submit" style="float: right;">Log Out</button>
								</form>';
                }
            ?>
        </div>