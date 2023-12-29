<?php
require_once("../other/authorization.php");
require_once ("admin_verification.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin page</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/admin.css">
    <style>

    </style>
    <!-- JavaScript to handle displaying different tables -->
    <script>
        function showTable(tableName) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('actionContent').innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", tableName + "_controller.php", true);
            xhttp.send();
        }

        function redirectToAction(category, action, recordId = null) {
            var controllerURL = getControllerURL(category, action);

            if (controllerURL !== '') {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('actionContent').innerHTML = this.responseText;
                    }
                };

                if (recordId !== null) {
                    controllerURL += '?recordId=' + recordId;
                }

                xhttp.open("GET", controllerURL, true);
                xhttp.send();
            }
        }

        function getControllerURL(category, action) {
            var controller = category + '_' + action + '_controller.php';
            // Modify the path as per your directory structure
            return controller; // Example: 'controllers/enemy_edit_controller.php'
        }

        // Add this function to toggle the 'active' class
        function toggleActiveClass(linkElement) {
            var sidebarLinks = document.getElementsByClassName('sidebar')[0].getElementsByTagName('a');
            for (var i = 0; i < sidebarLinks.length; i++) {
                sidebarLinks[i].classList.remove('active');
            }
            linkElement.classList.add('active');
        }
    </script>

</head>
<body>
    <!-- Navigation bar -->
    <?php require_once("../other/navbar.php")?>
    <div>
        <!-- Left side navigation bar -->
        <div class="sidebar">
            <a href="#enemies" onclick="showTable('enemies'); toggleActiveClass(this)">Enemies</a>
            <a href="#bosses" onclick="showTable('bosses'); toggleActiveClass(this)">Bosses</a>
            <a href="#users" onclick="showTable('users'); toggleActiveClass(this)">Users</a>
            <a href="#characters" onclick="showTable('characters'); toggleActiveClass(this)">Characters</a>
            <a href="#weapons" onclick="showTable('weapons'); toggleActiveClass(this)">Weapons</a>
        </div>



        <!-- Content area to display tables -->
        <div class="content" id="actionContent">
            <?php if (isset($_SESSION["error"])) {
                echo '<div class="error-box">' . $_SESSION["error"] . '</div>';
                unset($_SESSION["error"]); // Clear the error message after displaying it
            }
            elseif (isset($_SESSION['success'])) {
                echo '<div class="success-box">' . $_SESSION["success"] . '</div>';
                unset($_SESSION["success"]); // Clear the error message after displaying it
            }
            else{
                echo '<div></div>';
            }?>
        </div>
    </div>



</body>

</html>
</DOCTYPE>