<!-- Authorization -->
<?php
require_once("../../other/authorization.php");
?>

<!-- HTML -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Overworld </title>
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
    <!-- World -->
    <div>
        <h1> Dark Forest </h1>
        <a> You've left your village and now you're standing at the entrance of the infamous Dark Forest </a> </br>
        <a href="exploration.php"> "I fear not darkness nor forests!"</a> <a> <b>(Enter)</b> </a>
    </div>
</body>

</html>