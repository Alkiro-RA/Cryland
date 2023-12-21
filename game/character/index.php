<!-- Authorization -->
<?php
require_once("../../other/authorization.php");
?>

<!-- HTML -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Character </title>
    <link rel="stylesheet" href="../../other/navbar.css">
</head>

<body>
    <!-- Navigation bar -->
    <div class="navbar">
        <a href="index.html">Home</a>
        <a href="ranking/index.html">Ranking</a>
        <a href="about/index.html">About</a>
        <a class="logout" href="/cryland/other/logout.php">Logout</a>
    </div>
    <!-- Character -->
    <div>
        <h1> Character </h1>
        </br>
        <a>Zarządzaj:</a>
        <ul>
            <li> hp </li>
            <li> mp </li>
            <li> equipment </li>
        </ul>
    </div>
</body>

</html>