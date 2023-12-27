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
        $lvl = cleanInput($_POST["lvl"]);
        $attack = cleanInput($_POST["attack"]);
        $health = cleanInput($_POST["health"]);
        $defense = cleanInput($_POST["defense"]);

        // Validate input
        if (empty($id) || empty($name) || $lvl < 0 || $attack < 0 || $health < 0 || $defense < 0) {
            $_SESSION['error'] = "Please enter valid values. Negative values are not allowed.";
            header("Location: index.php");
        } else {
            try {
                // Prepare the SQL statement to update data
                $stmt = $pdo->prepare("UPDATE enemies SET name = ?, lvl = ?, attack = ?, health = ?, maxhealth = ?, defense = ? WHERE id = ?");
                $stmt->execute([$name, $lvl, $attack, $health, $health, $defense, $id]);

                // Redirect to the enemies table view after updating the record
                $_SESSION['success'] = "Id: $id Name: $name edited ";
                header("Location: index.php");
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: index.php");
            }
        }
    }

    $recordId = $_GET['recordId'];

    try {
        // Fetch enemy details by ID
        $stmt = $pdo->prepare("SELECT * FROM enemies WHERE id = ?");
        $stmt->execute([$recordId]);
        $enemy = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($enemy) {
            // Form to edit the enemy details
            echo '<h2>Edit Enemy</h2>';
            echo '<form method="post" action="enemies_edit_controller.php?recordId=' . $recordId . '">';
            echo '<input type="hidden" name="id" value="' . $enemy['id'] . '">';
            echo '<label for="name">Name:</label>';
            echo '<input type="text" id="name" name="name" value="' . $enemy['name'] . '"><br><br>';
            echo '<label for="lvl">Level:</label>';
            echo '<input type="number" id="lvl" name="lvl" value="' . $enemy['lvl'] . '"min="1"><br><br>';
            echo '<label for="attack">Attack:</label>';
            echo '<input type="number" id="attack" name="attack" value="' . $enemy['attack'] . '"min="1"><br><br>';
            echo '<label for="health">Health:</label>';
            echo '<input type="number" id="health" name="health" value="' . $enemy['health'] . '" min="1"><br><br>';
            echo '<label for="defense">Defense:</label>';
            echo '<input type="number" id="defense" name="defense" value="' . $enemy['defense'] . '" min="0"><br><br>';
            echo '<input type="submit" value="Update Enemy">';
            echo '</form>';
        } else {
            $_SESSION['error'] = "Enemy not found.";
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
