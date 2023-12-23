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
    <link rel="stylesheet" href="../../styles/style.css">
    <style>
        /* <!-- For testing more styles in future --> */
    </style>
    <script>
        function loadBattleInfo() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("battleInfo").innerHTML = this.responseText;

                    // Delay the scroll operation to ensure the new content is rendered
                    setTimeout(function() {
                        var scrollContainer = document.querySelector('.scrollable-container');
                        scrollContainer.scrollTop = scrollContainer.scrollHeight;
                    }, 1); // Adjust this delay as needed
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
            setInterval(loadBattleInfo, 15000); // Adjust the time interval as needed
        };

    </script>
</head>

<body>
    <!-- Navigation bar -->
    <?php include_once("../../styles/navbar.php");?>
    <!-- Battle -->
    <div id="battleInfo">
        <!-- Battle information will be displayed here -->
    </div>
</body>

</html>