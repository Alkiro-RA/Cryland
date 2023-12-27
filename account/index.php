<!-- Authorization -->
<?php
try {
    require_once("../other/authorization.php");
    require_once("../data/db.php");

    // Get character details
    $char_id = $_SESSION["char_id"];
    $sql = "SELECT * FROM Characters WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $char_id);
    if (!$stmt->execute()) {
        throw new Exception();
    }
    $character = $stmt->fetch();

    // Save characeter to session
    $_SESSION["character"] = $character;
} catch (Exception) {
    echo "Błąd bazy danych.";
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Account manager </title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/account.css">
</head>

<body>
    <!-- Navigation bar -->
    <?php require_once("../other/navbar.php") ?>

    <div class="main-window">
        <h2>Character Details</h2>
        <div class=details-container>
            <article class="detail">
                <label> Name: </label>
                <p><?php echo $character["name"]; ?></p>
            </article>
            <article class="detail">
                <label> Level: </label>
                <p><?php echo $character["level"]; ?></p>
            </article>
            <article class="detail">
                <label> Experience: </label>
                <p><?php echo $character["exp"]; ?></p>
            </article>
        </div>
        <button onclick="window.location.href='../game/index.php'">Play</button>
    </div>

</body>

</html>