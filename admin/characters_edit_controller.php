<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");

// Check if the record ID is present in the request
if (isset($_GET['recordId'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get and sanitize form input
        $id = cleanInput($_POST["id"]);
        $name = cleanInput($_POST["name"]);
        $level = cleanInput($_POST["level"]);
        $exp = cleanInput($_POST["exp"]);
        $coins = cleanInput($_POST["coins"]);
        $weaponsid = cleanInput($_POST["weaponsid"]);
        $attack = cleanInput($_POST["attack"]);
        $health = cleanInput($_POST["health"]);
        $maxhealth = cleanInput($_POST["maxhealth"]);
        $defense = cleanInput($_POST["defense"]);
        $potion = cleanInput($_POST["potion"]);
        $consumable = cleanInput($_POST["consumable"]);
        $duel_won = cleanInput($_POST["duel_won"]);

        if (empty($weaponsid)){
            $weaponsid = NULL;
        }
        // Validate input
        if (empty($id) || empty($name) || $level < 1 || $exp < 0 || $coins < 0 || $attack < 0 || $health < 0 || $maxhealth < 0 || $defense < 0 || $potion < 0 || $consumable < 0 || $duel_won < 0) {
            $_SESSION['error'] = "Please enter valid values. All fields are required.";
            header("Location: index.php");
        } else {
            try {
                // Prepare the SQL statement to update character data
                $stmt = $pdo->prepare("UPDATE characters 
                                        SET name = ?, level = ?, exp = ?, coins = ?, weaponsid = ?, 
                                        attack = ?, health = ?, maxhealth = ?, defense = ?, potion = ?, consumable = ?,
                                        duel_won = ?
                                        WHERE id = ?");
                $stmt->execute([$name, $level, $exp, $coins, $weaponsid, $attack, $health, $maxhealth, $defense, $potion, $consumable, $duel_won, $id]);

                // Redirect to the characters table view after updating the record
                $_SESSION['success'] = "Character with ID: $id updated.";
                header("Location: index.php");
                exit();
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: index.php");
            }
        }
    }

    $recordId = $_GET['recordId'];

    try {
        // Fetch character details by ID
        $stmt = $pdo->prepare("SELECT * FROM characters WHERE id = ?");
        $stmt->execute([$recordId]);
        $character = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($character) {
            // Form to edit character details
            echo '<h2>Edit Character</h2>';
            echo '<form method="post" action="characters_edit_controller.php?recordId=' . $recordId . '">';
            echo '<input type="hidden" name="id" value="' . $character['id'] . '">';
            echo '<label for="name">Name:</label>';
            echo '<input type="text" id="name" name="name" value="' . $character['name'] . '"><br><br>';
            echo '<label for="level">Level:</label>';
            echo '<input type="number" id="level" name="level" value="' . $character['level'] . '" min="1"><br><br>';
            echo '<label for="exp">Experience:</label>';
            echo '<input type="number" id="exp" name="exp" value="' . $character['exp'] . '" min="0"><br><br>';
            echo '<label for="coins">Coins:</label>';
            echo '<input type="number" id="coins" name="coins" value="' . $character['coins'] . '" min="0"><br><br>';
            echo '<label for="weaponsid">Weapon:</label>';
            echo '<select id="weaponsid" name="weaponsid">';
            echo '<option value="">Null</option>';

// Fetch all weapons from the database
            $stmt = $pdo->prepare("SELECT id, name FROM weapons");
            $stmt->execute();
            $weapons = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the list of weapons as options in the dropdown
            foreach ($weapons as $weapon) {
                $selected = ($weapon['id'] == $character['weaponsid']) ? 'selected' : '';
                echo '<option value="' . $weapon['id'] . '" ' . $selected . '>' . $weapon['name'] . '</option>';
            }

            echo '</select><br><br>';


            echo '<label for="attack">Attack:</label>';
            echo '<input type="number" id="attack" name="attack" value="' . $character['attack'] . '" min="0"><br><br>';
            echo '<label for="health">Health:</label>';
            echo '<input type="number" id="health" name="health" value="' . $character['health'] . '" min="0"><br><br>';
            echo '<label for="maxhealth">Max Health:</label>';
            echo '<input type="number" id="maxhealth" name="maxhealth" value="' . $character['maxhealth'] . '" min="0"><br><br>';
            echo '<label for="defense">Defense:</label>';
            echo '<input type="number" id="defense" name="defense" value="' . $character['defense'] . '" min="0"><br><br>';
            echo '<label for="potion">Potion:</label>';
            echo '<input type="number" id="potion" name="potion" value="' . $character['potion'] . '" min="0"><br><br>';
            echo '<label for="consumable">Consumable:</label>';
            echo '<input type="number" id="consumable" name="consumable" value="' . $character['consumable'] . '" min="0"><br><br>';
            echo '<label for="duel_won">Duels won:</label>';
            echo '<input type="number" id="duel_won" name="duel_won" value="' . $character['duel_won'] . '" min="0"><br><br>';
            echo '<input type="submit" value="Update Character">';
            echo '</form>';
        } else {
            $_SESSION['error'] = "Character not found.";
            header("Location: index.php");
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: index.php");
    }
} else {
    $_SESSION['error'] = "Record ID is missing.";
    header("Location: index.php");
}

// Function to sanitize form input
function cleanInput($data) {
    return htmlspecialchars(trim($data));
}
?>
