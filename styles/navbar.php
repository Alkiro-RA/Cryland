<head>
    <link rel="stylesheet" href="/Cryland/other/navbar.css">
    <style>
        .flex-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<?php
if ($_SESSION['logged_in'])
{
    echo '<!-- Navigation bar -->
    <div class="navbar">
        <div class="flex-container">
            <div>
                <a href="/Cryland/account">Home</a>
                <a href="/Cryland/game/character">Character</a>
                <a href="ranking/index.html">Ranking</a>
                <a href="about/index.html">About</a>
            </div>
            <div>
                <a class="logout" href="/cryland/other/logout.php">Logout</a>
            </div>
        </div>
    </div>
        ';
}
else{
    echo '<!-- Navigation bar -->
    <div class="navbar">
        <div class="flex-container">
            <div>
            
            </div>
            <div>
                <a href="/Cryland/register/index.php">Register</a>
                <a href="/Cryland">Log in</a>
            </div>
        </div>
    </div>';
}
?>