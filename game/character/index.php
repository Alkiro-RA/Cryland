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
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="../../styles/character.css">
    <!-- Your CSS styles here -->
    <style>
        /* Example styles */
    </style>
    <!-- Your JavaScript -->
    <script>
        function loadCharacterInfo() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("characterInfo").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "character_controller.php", true); // Replace with the actual path
            xhttp.send();
        }

        function upgradeAttribute(attribute) {
            // AJAX request to upgrade the character's attribute
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    loadCharacterInfo();
                }
            };
            xhttp.open("GET", "character_controller.php?upgrade=" + attribute, true);
            xhttp.send();
        }

        // Load character information when the page loads
        window.onload = function() {
            loadCharacterInfo();
        };
    </script>
</head>

<body>
    <!-- Navigation bar -->
    <?php include_once("../../other/navbar.php"); ?>
    <!-- Character -->
    <div class="main-window" id="characterInfo">
        
    </div>

</body>

</html>