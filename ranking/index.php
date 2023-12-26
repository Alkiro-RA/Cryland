<!-- HTML -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Player Ranking </title>
    <link rel="stylesheet" href="./ranking.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <section id="ranking">
        <table>
            <tr>
                <th>Name</th>
                <th>Level</th>
            </tr>
            <?php require_once("./ranking_controller.php"); ?>
        </table>
    </section>
</body>

</html>