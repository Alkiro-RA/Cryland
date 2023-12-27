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
            background-color: #3b3b4f;
        }

        button,
        input[type="submit"]{
            display: inline;
            height: auto;
            width: auto;
            min-width: auto;
            margin: 5px;
            padding: 10px 20px;
            background-color: #3b3b4f;
            border-color: black;
            color: white;
        }

        button:hover,
        input[type="submit"]:hover{
            cursor: pointer;
            background-color: #606080;
        }

        /*FORMS*/
        /* Main style theme */

        /* General form styles */
        form {
            padding: 20px;
            background-color: #3b3b4f;
            border: 1px solid black;
            border-radius: 5px;
            width: 80%;
            margin: 0;
        }

        /* Input fields */
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            color: #333;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #66afe9;
            /* Example: Change border color on focus */
        }

        .error-box {
            background-color: #ff6347;
            margin-top: 5px;
            padding: 10px 20px
        }

        .success-box{
            background-color: #039f0c;
            margin-top: 5px;
            padding: 10px 20px
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
    <?php require_once("../other/navbar.php")?>
    <div>
        <!-- Left side navigation bar -->
        <div class="sidebar">
            <a href="#enemies" onclick="showTable('enemies'); toggleActiveClass(this)">Enemies</a>
            <a href="#bosses" onclick="showTable('bosses'); toggleActiveClass(this)">Bosses</a>
            <a href="#users" onclick="showTable('users'); toggleActiveClass(this)">Users</a>
            <a href="#characters" onclick="showTable('characters'); toggleActiveClass(this)">Characters</a>
            <a href="#weapons" onclick="showTable('weapons'); toggleActiveClass(this)">Weapons</a>
            <a href="#armors" onclick="showTable('armors'); toggleActiveClass(this)">Armors</a>
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