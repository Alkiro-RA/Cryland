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
    <!-- Your CSS styles here -->
    <style>
        /* Example styles */
        .character-info {
            width: 400px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin-bottom: 10px;
        }
        .character-info p {
            text-align: left;
            margin: 5px;
        }
        .upgrade-button {
            display: inline-block;
            padding: 5px 10px;
            margin: 5px;
        }
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
    <?php include_once("../../styles/navbar.php");?>
    <!-- Character -->
    <div id="characterInfo">

    </div>
</body>

</html>