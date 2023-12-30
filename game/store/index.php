<!-- Authorization -->
<?php
require_once("../../other/authorization.php");
unset($_SESSION['boss_fight']);
$_POST
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>General Store</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="../../styles/store.css">
</head>

<body>
    <?php include_once("../../other/navbar.php"); ?>
    <div class="main-window">
        <h2>General Store</h2>
        <!-- Display coins -->
        <div class="coin">
            <p>Your coins: </p>
            <p><?php echo $_SESSION['character']['coins']; ?></p>
        </div>
        <!-- Weapons table -->
        <div class="items">
            <p class="signboard">Avaiable Weapons</p>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Attack</th>
                    <th>Health</th>
                    <th>Defence</th>
                    <th>Price</th>
                </tr>
                <?php require_once("./weapons.php"); ?>
            </table>
            <p class="signboard">Consumables</p>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
                <?php require_once("./consumables.php"); ?>
            </table>
        </div>
        <div class="purchase">
            <form method="post" action="purchase.php">
                <input id="button" type="submit" value="Purchase" />
                <input id="item" name="item" placeholder="knife" />
            </form>
            <button onclick="window.location.href='../index.php'">
                Leave Store</button>
        </div>
        <?php if (isset($_SESSION["error"])) {
            echo '<div class="error-box">' . $_SESSION["error"] . '</div>';
            unset($_SESSION["error"]); // Clear the error message after refreshing page
        } else {
            echo '<div></div>';
        } ?>
    </div>
</body>

</html>