<!-- Authorization -->
<?php
require_once("../../other/authorization.php");
require_once("../../data/db.php");
try {
    // Get a list of potential enemies 
    $char_level = $_SESSION['character']['level'] + 2;
    $sql = "SELECT * FROM Enemies WHERE lvl <= :char_level";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":char_level", $char_level);
    if (!$stmt->execute()) {
        throw new Exception();
    }
    $enemies = $stmt->fetchAll();
    $enemy_id_pool = array();
    foreach ($enemies as $enemy) {
        array_push($enemy_id_pool, $enemy['id']);
    }
    // Draw random ID
    $chosen_enemy_id = $enemy_id_pool[rand(0, count($enemy_id_pool) - 1)];
    foreach ($enemies as $enemy) {
        if ($enemy['id'] == $chosen_enemy_id) {
            // Create new enemy
            $new_enemy = $enemy;
            // Add enemy to session
            $_SESSION['enemy'] = $enemy;
        }
    }
} catch (Exception) {
    echo "<h3> Błąd bazy danych </h3>";
}
?>



<!-- HTML -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Overworld </title>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="../../styles/world.css">
</head>

<body>
    <!-- Navigation bar -->
    <?php include_once("../../other/navbar.php"); ?>

    <!-- Exploration -->
    <div class="world-container">
        <h2> Dark Forest </h1>
            <p>"You've encountered an enemy! It is:</p>
            <p><b><?php echo  $new_enemy['name']; ?></b></p>
            <!-- gdzieś tu zaczyna sie walka -->
            <div class="options">
                <?php 
                $_SESSION['paralysis_counter'] = 0;
                $_SESSION['battle_log'] = '<p>Begin of battle with: ' . $new_enemy['name'] . '</p>'; ?>
                <button onclick="window.location.href='../battle/index.php'">Fight</button>
                <button onclick="window.location.href='../index.php'">Run</button>
            </div>
    </div>

</body>

</html>