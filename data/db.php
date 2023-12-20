<?php
// Db configuration
$host = "localhost";
$dbname = "cryland_db";
$username = "root";
$password = "";
$dsn = "mysql:host=" . $host . ";dbname=" . $dbname;


// Create PDO in stance
$pdo = new PDO($dsn, $username, $password);
?>