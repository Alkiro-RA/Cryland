<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <style>
        .login-container {
            width: 18%;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .login-container h2 {
            text-align: center;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-box{
            text-align: center;
            cursor: default;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            background-color: #cb0000;
            color: antiquewhite;
        }
    </style>
</head>

<body>
    <!-- Navigation bar -->
    <?php
    $_SESSION['logged_in'] = false;
    include_once("styles/navbar.php");

    ?>
    <!-- Login form  -->
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
        }
        else{
            echo '<div></div>';
        }?>
    </div>

</body>

</html>