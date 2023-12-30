<?php
require_once('../data/db.php');
require_once('../other/authorization.php');
unset($_SESSION['boss_fight']);

if(isset($_GET['buy']))
{
    $buy = $_GET['buy'];
    if($buy) {
        $_SESSION['character']['health'] = $_SESSION['character']['maxhealth'];
        $_SESSION['character']['coins'] = $_SESSION['character']['coins'] - 5;
        if ($_SESSION['character']['coins'] < 0) {
            $_SESSION['character']['health'] = 1;
        }
    }
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> INN </title>
    <link rel="stylesheet" href="../styles/style.css">
    <script>
        function buyMealAndBeer() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload(); // Refresh the window
                }
            };
            xhttp.open("GET", "inn_controller.php?buy=true", true); // Replace with the actual path to your PHP file
            xhttp.send();
        }
    </script>
</head>

<body>
<!-- Navigation bar -->
<?php include_once("../other/navbar.php"); ?>
<!-- Main menu -->
<div class="main-window">
    <h2> INN </h2>
    <p>Welcome to my INN</p>
    <p>I can serve you proper meal</p>
    <p>For only 5 coins!</p>
    <?php echo'<p> Health:'.$_SESSION['character']['health'].'/'.$_SESSION['character']['maxhealth'].' coins: '.$_SESSION['character']['coins'].'</p>'; ?>
    <div class="options">
        <?php
        if ($_SESSION['character']['coins'] < 5) {
            echo '<button class="unclickable-button">Buy meal and beer</button>';
        } else {
            echo '<button onclick="buyMealAndBeer()">Buy meal and beer</button>';
        }
        ?>
        <button onclick="window.location.href='index.php'">Go back</button>
    </div>
</div>
</body>

</html>
