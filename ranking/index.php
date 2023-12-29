<!-- HTML -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Player Ranking </title>
    <link rel="stylesheet" href="../styles/ranking.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <?php 
    session_start();
    include_once("../other/navbar.php"); ?>
    <div class="main-window">
        <h2> Top Players </h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Level</th>
                <th>Bosses Defeated</th>
            </tr>
            <?php require_once("./ranking_controller.php"); ?>
        </table>
        <button onclick="window.location.href='../index.php'">Back</button>
    </div>
</body>

</html>