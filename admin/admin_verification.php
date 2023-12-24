<?php
// Check access rights
if(no_admin()){
    // Przed ścieżką zawsze: '/'
    header("Location: /cryland/account/index.php");
    exit();
}

function no_admin()
{
    if ($_SESSION['role_id']<2) {
        return true;
    } else {
        return false;
    }
}
?>