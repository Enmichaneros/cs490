
<?php 
	session_start();
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
            <a href="https://web.njit.edu/~jj373/RC/teacher_add_questions.php">Add Questions</a>
            <a href="https://web.njit.edu/~jj373/RC/teacher_make_test.php">Make Test</a>
            <a href="https://web.njit.edu/~jj373/RC/teacher_grades.php">Grades</a>
            <?php
                if (isset($_SESSION['username'])) {                    
				    echo '<form action="includes/logout.inc.php" method="POST">
								<button class = "button" type="submit" name = "submit" style="float: right;">Log Out</button>
								</form>';
                    echo '<a class = "disabled" disabled style="float:right;">Hello '.$_SESSION["username"].'</a>';
                }
            ?>
        </div>