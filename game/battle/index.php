<!-- Authorization -->
<?php
require_once("../../other/authorization.php");
if($_SESSION['enemy']['health']<=0 || ($_SESSION['character']['health']<=0)) {unset($_SESSION['enemy']);}
if(!isset($_SESSION['enemy'])) header("Location: ../");
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
            xhttp.open("GET", "battle_controller.php", true); // Replace with the actual path
            xhttp.send();
        }

        function performAction(action) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    loadBattleInfo(); // Refresh battle information after performing the action
                }
            };
            xhttp.open("GET", "battle_controller.php?action=" + action, true); // Replace with the actual path
            xhttp.send();
        }

        function redirectToHome() {
            // Create an anchor element
            var link = document.createElement('a');

            // Set the href attribute to the URL you want to navigate to
            link.href = '../world/exploration.php'; // Replace with your desired URL

            // Set any other attributes if needed
            link.setAttribute('target', '_self'); // Opens the link in the same window/tab

            // Append the anchor element to the document body
            document.body.appendChild(link);

            // Programmatically trigger a click event on the anchor element
            link.click();
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

<?php

?>