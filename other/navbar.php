<head>
    <link rel="stylesheet" href="/cryland/styles/navbar.css">
    <style>
        .flex-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<?php

if ($_SESSION['logged_in'] && $_SESSION['role_id'] == 2) {
    echo '<!-- Navigation bar -->
    <div class="navbar">
        <div class="flex-container">
            <div>
                <a href="/Cryland/game">Home</a>
                <a href="/Cryland/ranking/">Ranking</a>
            </div>
            <div>
                <a href="/cryland/admin">Admin settings</a>
                <a href="/cryland/account">Account</a>
                <a class="logout" href="/cryland/other/logout.php">Logout</a>
            </div>
        </div>
    </div>
        ';
} elseif ($_SESSION['logged_in']) {
    echo '<!-- Navigation bar -->
    <div class="navbar">
        <div class="flex-container">
            <div>
                <a href="/Cryland/game">Home</a>
                <a href="/Cryland/ranking/">Ranking</a>
            </div>
            <div>
                <a href="/cryland/account">Account</a>
                <a class="logout" href="/cryland/other/logout.php">Logout</a>
            </div>
        </div>
    </div>
        ';
} else {
    echo '<!-- Navigation bar -->
    <div class="navbar">
        <div class="flex-container">
            <div>
                <a href="/Cryland/">Home</a>
                <a href="/Cryland/ranking/">Ranking</a>
            </div>
            <div>
                <a href="/Cryland/register/index.php">Register</a>
                <a href="/Cryland">Log in</a>
            </div>
        </div>
    </div>';
}
?>