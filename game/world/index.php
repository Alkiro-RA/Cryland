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
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="../../styles/world.css">
</head>

<body>
    <!-- Navigation bar -->
    <?php include_once("../../other/navbar.php");?>
    <!-- World -->
    <div class="world-container">
        <h2> Dark Forest </h2>
        <p> You've left your village and now you're standing at the entrance of the infamous Dark Forest. </p>
        <div class="options">
            <button onclick="window.location.href='exploration.php'">
            Enter</button>
            <button onclick="window.location.href='../index.php'">
            Go Home</button>
        </div>
    </div>
</body>

</html>