<!-- Authorization -->
<?php
require_once("../other/authorization.php");
?>

<!-- HTML -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Character </title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>

<body>
    <!-- Navigation bar -->
    <div class="navbar">
        <a href="index.html">Home</a>
        <a href="ranking/index.html">Ranking</a>
        <a href="about/index.html">About</a>
        <a class="logout" href="/cryland/other/logout.php">Logout</a>
    </div>
    <!-- Game -->
    <div>
        <h1> Dom </h1>
        </br>
        <a>*Akcje*</a>
        <ul>
            <li> eksploracja </li>
            <li> karta postaci </li>
            <li> boss fight </li>
        </ul>
    </div>
</body>

</html>