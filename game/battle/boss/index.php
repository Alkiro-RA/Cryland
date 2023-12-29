<!--Authorization-->
<?php require_once("../../../other/authorization.php");?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <Title>Boss Challange</Title>
        <link rel="stylesheet" href="../../../styles/style.css"/>
        <link rel="stylesheet" href="../../../styles/boss.css"/>
    </head>
    <body>
        <!--Navbar-->
        <?php include_once("../../../other/navbar.php"); ?>
        <!--Page-->
        <div class="main-window">
            <h2>Challange</h2>
            <p>You are standing in front of the goblin villiage. </br>
            If you challange the chieftain and defeat him,</br>
            this goblin village will cease harrasing your town.
            </p>
            <p>What is it you will do?</p>
            <button onclick="window.location.href='./boss_controller.php'">Enter inside</button>
            <button onclick="window.location.href='../../index.php'">Run back</button>
        </div>
    </body>
</html>
