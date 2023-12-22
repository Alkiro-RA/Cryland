<!-- Authorization -->
<?php
require_once("../../other/authorization.php");
?>

<!-- HTML -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Battle </title>
    <link rel="stylesheet" href="../../other/navbar.css">
    <style>
        /* Updated styles */

        .battle-info {
            display: flex;
            justify-content: center;
            align-items: stretch;
            gap: 50px; /* Max distance between player and enemy */
            margin-top: 20px;
            margin-bottom: 20px; /* Spacing between battle info and buttons */
        }

        .player-info, .enemy-info {
            width: 20%; /* Adjust width as needed */
            border: 5px solid #ccc;
            padding: 10px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .buttons button {
            margin: 5px;
            padding: 10px 20px;
        }
    </style>
    <script>
        function loadBattleInfo() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("battleInfo").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "battle_system.php", true); // Replace with the actual path
            xhttp.send();
        }

        function performAction(action) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    loadBattleInfo(); // Refresh battle information after performing the action
                }
            };
            xhttp.open("GET", "battle_system.php?action=" + action, true); // Replace with the actual path
            xhttp.send();
        }

        // Load battle information when the page loads
        window.onload = function() {
            loadBattleInfo();
            // Refresh battle information every few seconds (example: every 5 seconds)
            setInterval(loadBattleInfo, 5000); // Adjust the time interval as needed
        };
    </script>
</head>

<body>
    <!-- Navigation bar -->
    <div class="navbar">
        <a href="index.html">Home</a>
        <a href="ranking/index.html">Ranking</a>
        <a href="about/index.html">About</a>
        <a class="logout" href="/cryland/other/logout.php">Logout</a>
    </div>
    <!-- Battle -->
    <div id="battleInfo">
        <!-- Battle information will be displayed here -->
    </div>

    <div class="buttons">
        <button onclick="performAction('attack')">Attack</button>
        <button onclick="performAction('potion')">Use Potion</button>
        <button onclick="performAction('consumable')">Use paralysis bomb</button>
        <button onclick="performAction('consumable_2')">Use fire bomb</button>
    </div>
</body>

</html>