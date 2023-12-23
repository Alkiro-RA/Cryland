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
    <link rel="stylesheet" href="../other/navbar.css">
</head>

<body>
    <!-- Navigation bar -->
    <?php require_once("../styles/navbar.php")?>

    <div>
        <h3>Character's details:</h3>
        <label> Name: </label>
        <?php echo $character["name"]; ?> </br>
        <label> Level: </label> 
        <?php echo $character["level"]; ?> </br>
        <label> Experience: </label>
        <?php echo $character["exp"]; ?> </br>
        </br>
        <button onclick="window.location.href='../game/index.php'">Graj</button>
    </div>

</body>

</html>