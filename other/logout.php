<?php
require_once("authorization.php");
$_SESSION["user_id"] = 0;
$_SESSION["logged_in"] = false;
session_destroy();
header("Location: /Cryland/index.php");
?>