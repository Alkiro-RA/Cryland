<?php
session_start();
// Check access rights
if(has_no_access()){
    // Przed ścieżką zawsze: '/'
    header("Location: /Cryland");
    exit();
}

function has_no_access() 
{ 
    $is_logged = $_SESSION["logged_in"];
    if (empty($is_logged) || $is_logged == false) {
        return true;
    } else {
        return false;
    }
}
?>