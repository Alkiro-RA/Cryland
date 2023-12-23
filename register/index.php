<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Form</title>
    <style>
        .register-container {
            width: 18%;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .register-container h2 {
            text-align: center;
        }

        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .register-container input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .register-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Navigation bar -->
    <?php
    session_start();
    $_SESSION['logged_in'] = false;
    include_once("../styles/navbar.php");?>
    <!-- Register form -->
    <div class="register-container">
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
    </div>
</body>

</html>