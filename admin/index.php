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
            background-color: #3b3b4f;
            position: fixed;
            height: 100%;
            overflow: auto;
        }

        .sidebar a {
            display: block;
            color: whitesmoke;
            padding: 16px;
            text-decoration: none;
        }

        .sidebar a.active {
            background-color: #29293b;
            color: white;
        }

        .sidebar a:hover:not(.active) {
            background-color: #464662;
            color: white;
        }

        /* Center content */
        .content {
            color: whitesmoke;
            margin-left: 200px;
            padding: 20px;
        }

        /* Table styles */
        table {
            color: whitesmoke;
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            color: whitesmoke;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            color:whitesmoke;
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
            color: whitesmoke;
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
        input[type="number"],
        input[type="email"],
        input[type="password"]{
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
        input[type="number"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus{
            outline: none;
            border-color: #66afe9;
            /* Example: Change border color on focus */
        }

        /* Style for select dropdown and its options */
        select {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            color: #333;
        }

        select:focus {
            outline: none;
            border-color: #66afe9;
            /* Change border color on focus */
        }

        select option {
            /* Add your styles here */
            background-color: #f1f1f1;
            color: #333;
            padding: 6px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-top-left-radius: 1px;
            border-top-right-radius: 1px;
        }

        select option:hover {
            /* Add hover effect */
            background-color: #e0e0e0;
            cursor: pointer;
        }

        .error-box {
            border-color:black;
            background-color: #b40000;
            margin-top: 5px;
            padding: 10px 20px;
            border-radius: 3px;
        }

        .success-box{
            text-align: center;
            background-color: #039f0c;
            margin-top: 5px;
            padding: 10px 20px;
            border-radius: 3px;
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