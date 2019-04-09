
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
            <a href="https://web.njit.edu/~jj373/RC/student_exam.php">Exam</a>
            <a href="https://web.njit.edu/~jj373/RC/student_grades.php">Grades</a>
            <?php
                if (isset($_SESSION['username'])) {
                    echo '<a class = "disabled" disabled>Hello '.$_SESSION["username"].'</a>';
                    
				    echo '<form action="includes/logout.inc.php" method="POST">
								<button class = "button" type="submit" name = "submit" style="float: right;">Log Out</button>
								</form>';
                }
            ?>
        </div>