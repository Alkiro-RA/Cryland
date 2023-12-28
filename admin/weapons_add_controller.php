<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");

// Variables to hold the input values
$name = $price = $attack_bonus = $health_bonus = $defense_bonus = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form input
    $name = cleanInput($_POST["name"]);
    $price = cleanInput($_POST["price"]);
    $attack_bonus = cleanInput($_POST["attack_bonus"]);
    $health_bonus = cleanInput($_POST["health_bonus"]);
    $defense_bonus = cleanInput($_POST["defense_bonus"]);

    // Validate input
    if (empty($name) || $price < 0 || $attack_bonus < 0 || $health_bonus < 0 || $defense_bonus < 0) {
        $_SESSION['error'] = "Please enter valid values. Negative values are not allowed.";
        header("Location: index.php");
        exit();
    } else {
        try {
            // Prepare the SQL statement to insert data into the weapons table
            $stmt = $pdo->prepare("INSERT INTO weapons (name, price, attack_bonus, health_bonus, defense_bonus) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $price, $attack_bonus, $health_bonus, $defense_bonus]);

            // Redirect to the weapons table view after adding the record
            $_SESSION['success'] = "$name added into weapons";
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: index.php");
            exit();
        }
    }
}

// Function to sanitize form input
function cleanInput($data) {
    return htmlspecialchars(trim($data));
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Weapon</title>
    <!-- Add your CSS styles here -->
    <style>
        /* Your CSS styles for the form */
    </style>
</head>
<body>
<h2>Add Weapon</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br><br>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" value="<?php echo $price; ?>" min="1"><br><br>

    <label for="attack_bonus">Attack Bonus:</label>
    <input type="number" id="attack_bonus" name="attack_bonus" value="<?php echo $attack_bonus; ?>" min="0"><br><br>

    <label for="health_bonus">Health Bonus:</label>
    <input type="number" id="health_bonus" name="health_bonus" value="<?php echo $health_bonus; ?>" min="0"><br><br>

    <label for="defense_bonus">Defense Bonus:</label>
    <input type="number" id="defense_bonus" name="defense_bonus" value="<?php echo $defense_bonus; ?>" min="0"><br><br>

    <input type="submit" value="Add Weapon">
</form>
<button onclick="showTable('weapons');">Go back</button>
</body>
</html>
