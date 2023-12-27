<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/style.css">
    <style>

    </style>
</head>

<body>
    <!-- Navigation bar -->
    <?php
    $_SESSION['logged_in'] = false;
    include_once("other/navbar.php");

    ?>
    <!-- Login form  -->
    <div class="main-window">
        <div class="login-container">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" value="Login">
            </form>
            <?php if (isset($_SESSION["error"])) {
                echo '<div class="error-box">' . $_SESSION["error"] . '</div>';
                unset($_SESSION["error"]); // Clear the error message after displaying it
            } else {
                echo '<div></div>';
            } ?>
        </div>
    </div>

</body>

</html>