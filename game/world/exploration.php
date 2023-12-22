<!-- Authorization -->
<?php
require_once("../../other/authorization.php");
require_once("../../data/db.php");
try {
    // Get a list of potential enemies 
    $char_level = $_SESSION['character']['level'];


    echo "char_level = " . $char_level . "</br>";

    
    $sql = "SELECT * FROM Enemies WHERE lvl <= 3";
    $stmt = $pdo->prepare($sql);
    //$stmt->bindParam(":char_level", $char_level);
    if (!$stmt->execute()) {
        throw new Exception();
    }
    $enemies = $stmt->fetchAll();
    $enemy_id_pool = array();
    $i = 0;
    foreach ($enemies as $enemy) {


        echo $enemy['name'] . "</br>";


        array_push($enemy_id_pool, $enemy['id']);


        echo $enemy_id_pool[0];
    }
    // Generate random enemy
    $new_enemy = "";
    $chosen_enemy_id = $enemy_id_pool[rand(0, count($enemy_id_pool) - 1)];
    foreach ($enemies as $enemy) {
        if ($enemy['id'] = $chosen_enemy_id) {
            // Add enemy to session
            $_SESSION['enemy'] = '';
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
    <link rel="stylesheet" href="../../other/navbar.css">
</head>

<body>
    <!-- Navigation bar -->
    <div class="navbar">
        <a href="index.html">Home</a>
        <a href="ranking/index.html">Ranking</a>
        <a href="about/index.html">About</a>
        <a class="logout" href="/cryland/other/logout.php">Logout</a>
    </div>

    <!-- Exploration -->
    <div>
        <h1> Dark Forest </h1>
        <p>You've encountered new enemy! It is </p>
        <?php echo $new_enemy['name'];?>
        <!-- gdzieś tu zaczyna sie walka -->
        <?php $_SESSION['paralysis_counter'] = 0;
            $_SESSION['battle_log'] = ''; ?>
    </div>

</body>

<!--  
    Dodaj przeciwnika do sesji
    $enemy_id = 1;
    $stmt = $pdo->prepare("SELECT * FROM enemies WHERE id = :id");
    $stmt->bindParam(':id', $enemy_id);
    $stmt->execute();
    $enemy = $stmt->fetch(PDO::FETCH_ASSOC);

   
-->

</html>