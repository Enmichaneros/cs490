<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <Title>Beta Login</Title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <>
    </head>

    <body>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="index.html">Index</a></li>
        </ul>

        <?php
            $_SESSION['username'] = "dani9481";
            echo $_SESSION['username'];
        ?>
    </body>
</html>