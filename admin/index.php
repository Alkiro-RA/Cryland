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
    <style>
        .sidebar {
            margin: 0;
            padding: 0;
            width: 200px;
            background-color: #f1f1f1;
            position: fixed;
            height: 100%;
            overflow: auto;
        }

        .sidebar a {
            display: block;
            color: black;
            padding: 16px;
            text-decoration: none;
        }

        .sidebar a.active {
            background-color: #343434;
            color: white;
        }

        .sidebar a:hover:not(.active) {
            background-color: #555;
            color: white;
        }

        /* Center content */
        .content {
            margin-left: 200px;
            padding: 20px;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
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
    <?php require_once("../styles/navbar.php")?>
    <div>
        <!-- Left side navigation bar -->
        <div class="sidebar">
            <a href="#enemies" onclick="showTable('enemies'); toggleActiveClass(this)">Enemies</a>
            <a href="#bosses" onclick="showTable('bosses'); toggleActiveClass(this)">Bosses</a>
            <a href="#users" onclick="showTable('users'); toggleActiveClass(this)">Users</a>
            <a href="#weapons" onclick="showTable('weapons'); toggleActiveClass(this)">Weapons</a>
            <a href="#armors" onclick="showTable('armors'); toggleActiveClass(this)">Armors</a>
        </div>

        <!-- Content area to display tables -->
        <div class="content" id="actionContent">

        </div>
    </div>



</body>

</html>
</DOCTYPE>