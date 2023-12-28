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
        $price = cleanInput($_POST["price"]);
        $attack_bonus = cleanInput($_POST["attack_bonus"]);
        $health_bonus = cleanInput($_POST["health_bonus"]);
        $defense_bonus = cleanInput($_POST["defense_bonus"]);

        // Validate input
        if (empty($id) || empty($name) || $price < 0 || $attack_bonus < 0 || $health_bonus < 0 || $defense_bonus < 0) {
            $_SESSION['error'] = "Please enter valid values. Negative values are not allowed.";
            header("Location: index.php");
            exit();
        } else {
            try {
                // Prepare the SQL statement to update data
                $stmt = $pdo->prepare("UPDATE weapons SET name = ?, price = ?, attack_bonus = ?, health_bonus = ?, defense_bonus = ? WHERE id = ?");
                $stmt->execute([$name, $price, $attack_bonus, $health_bonus, $defense_bonus, $id]);

                // Redirect to the weapons table view after updating the record
                $_SESSION['success'] = "Weapon ID: $id updated";
                header("Location: index.php");
                exit();
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: index.php");
                exit();
            }
        }
    }

    $recordId = $_GET['recordId'];

    try {
        // Fetch weapon details by ID
        $stmt = $pdo->prepare("SELECT * FROM weapons WHERE id = ?");
        $stmt->execute([$recordId]);
        $weapon = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($weapon) {
            // Form to edit the weapon details
            echo '<h2>Edit Weapon</h2>';
            echo '<form method="post" action="weapons_edit_controller.php?recordId=' . $recordId . '">';
            echo '<input type="hidden" name="id" value="' . $weapon['id'] . '">';
            echo '<label for="name">Name:</label>';
            echo '<input type="text" id="name" name="name" value="' . $weapon['name'] . '"><br><br>';
            echo '<label for="price">Price:</label>';
            echo '<input type="number" id="price" name="price" value="' . $weapon['price'] . '" min="1"><br><br>';
            echo '<label for="attack_bonus">Attack Bonus:</label>';
            echo '<input type="number" id="attack_bonus" name="attack_bonus" value="' . $weapon['attack_bonus'] . '" min="0"><br><br>';
            echo '<label for="health_bonus">Health Bonus:</label>';
            echo '<input type="number" id="health_bonus" name="health_bonus" value="' . $weapon['health_bonus'] . '" min="0"><br><br>';
            echo '<label for="defense_bonus">Defense Bonus:</label>';
            echo '<input type="number" id="defense_bonus" name="defense_bonus" value="' . $weapon['defense_bonus'] . '" min="0"><br><br>';
            echo '<input type="submit" value="Update Weapon">';
            echo '</form>';
        } else {
            $_SESSION['error'] = "Weapon not found.";
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Record ID is missing.";
    header("Location: index.php");
    exit();
}

// Function to sanitize form input
function cleanInput($data) {
    return htmlspecialchars(trim($data));
}
?>
