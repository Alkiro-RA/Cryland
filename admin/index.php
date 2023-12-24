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
        /* Style the navigation bar */
        .sidenav {
            height: 100%;
            width: 200px;
            left: 0;
            top: 0;
            background-color: #f1f1f1;
            padding-top: 20px;
        }

        .sidenav a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 20px;
            color: #818181;
            display: block;
        }

        .sidenav a:hover {
            color: #000;
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
    </script>

</head>
<body>
    <!-- Navigation bar -->
    <?php require_once("../styles/navbar.php")?>
    <div>
        <!-- Left side navigation bar -->
        <div class="sidenav">
            <a href="#" onclick="showTable('enemies')">Enemies</a>
            <a href="#" onclick="showTable('bosses')">Bosses</a>
            <a href="#" onclick="showTable('users')">Users</a>
            <a href="#" onclick="showTable('weapons')">Weapons</a>
            <a href="#" onclick="showTable('armors')">Armors</a>
        </div>

        <!-- Content area to display tables -->
        <div id="actionContent">

        </div>
    </div>



</body>

</html>
</DOCTYPE>