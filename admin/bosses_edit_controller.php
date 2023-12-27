<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");

// Check if record ID is present in the request
if (isset($_GET['recordId'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get and sanitize form input
        $id = cleanInput($_POST["id"]);
        $name = cleanInput($_POST["name"]);
        $attack = cleanInput($_POST["attack"]);
        $health = cleanInput($_POST["health"]);
        $defense = cleanInput($_POST["defense"]);
        $consumable = cleanInput($_POST["consumable"]);

        // Validate input
        if (empty($id) || empty($name) || $attack < 0 || $health < 0 || $defense < 0 || $consumable < 0) {
            $_SESSION['error'] = "Please enter valid values. Negative values are not allowed.";
            header("Location: index.php");
        } else {
            try {
                // Prepare the SQL statement to update data
                $stmt = $pdo->prepare("UPDATE bosses SET name = ?, attack = ?, health = ?, maxhealth = ?, defense = ?, consumable = ? WHERE id = ?");
                $stmt->execute([$name, $attack, $health, $health, $defense, $consumable, $id]);

                // Redirect to the bosses table view after updating the record
                $_SESSION['success'] = "ID: $id Name: $name edited";
                header("Location: index.php");
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: index.php");
            }
        }
    }

    $recordId = $_GET['recordId'];

    try {
        // Fetch boss details by ID
        $stmt = $pdo->prepare("SELECT * FROM bosses WHERE id = ?");
        $stmt->execute([$recordId]);
        $boss = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($boss) {
            // Form to edit the boss details
            echo '<h2>Edit Boss</h2>';
            echo '<form method="post" action="bosses_edit_controller.php?recordId=' . $recordId . '">';
            echo '<input type="hidden" name="id" value="' . $boss['id'] . '">';
            echo '<label for="name">Name:</label>';
            echo '<input type="text" id="name" name="name" value="' . $boss['name'] . '"><br><br>';
            echo '<label for="attack">Attack:</label>';
            echo '<input type="number" id="attack" name="attack" value="' . $boss['attack'] . '" min="1"><br><br>';
            echo '<label for="health">Health:</label>';
            echo '<input type="number" id="health" name="health" value="' . $boss['health'] . '" min="1"><br><br>';
            echo '<label for="defense">Defense:</label>';
            echo '<input type="number" id="defense" name="defense" value="' . $boss['defense'] . '" min="0"><br><br>';
            echo '<label for="consumable">Consumable:</label>';
            echo '<input type="number" id="consumable" name="consumable" value="' . $boss['consumable'] . '" min="0"><br><br>';
            echo '<input type="submit" value="Update Boss">';
            echo '</form>';
        } else {
            $_SESSION['error'] = "Boss not found.";
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
