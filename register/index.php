<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Form</title>
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <!-- Navigation bar -->
    <?php
    $_SESSION['logged_in'] = false;
    include_once("../other/navbar.php");?>
    <!-- Register form -->
    <div class="main-window">
    <div class="login-container">
        <h2>Register</h2>
        <form action="register.php" method="post">
            <label for="char_name">Character's name:</label>
            <input type="text" id="char_name" name="char_name" required>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="pass1" name="pass1" required>

            <label for="password">Confirm password:</label>
            <input type="password" id="pass2" name="pass2" required>

            <input type="submit" value="Register">
        </form>
        <?php if (isset($_SESSION["error"])) {
            echo '<div class="error-box">' . $_SESSION["error"] . '</div>';
            unset($_SESSION["error"]); // Clear the error message after refreshing page
        } else { echo '<div></div>'; }?>
    </div>
    </div>
</body>

</html>