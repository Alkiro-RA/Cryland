<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");


// Variables to hold the input values
$name = $attack = $health = $defense = $consumable = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form input
    $name = cleanInput($_POST["name"]);
    $attack = cleanInput($_POST["attack"]);
    $health = cleanInput($_POST["health"]);
    $defense = cleanInput($_POST["defense"]);
    $consumable = cleanInput($_POST["consumable"]);

    // Validate input
    if (empty($name) || $attack < 0 || $health < 0 || $defense < 0 || $consumable < 0) {
        $_SESSION['error'] = "Please enter valid values. Negative values are not allowed.";
        header("Location: index.php");
    } else {
        try {
            // Prepare the SQL statement to insert data
            $stmt = $pdo->prepare("INSERT INTO bosses (name, attack, health, maxhealth, defense, consumable) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $attack, $health, $health, $defense, $consumable]);
            // Redirect to the bosses table view after adding the record
            $_SESSION['success'] = "$name added into bosses";
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: index.php");
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
    <title>Add boss</title>
    <!-- Add your CSS styles here -->
    <style>
        /* Your CSS styles for the form */
    </style>
</head>
<body>
<h2>Add boss</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br><br>

    <label for="attack">Attack:</label>
    <input type="number" id="attack" name="attack" value="<?php echo $attack; ?>" min="1"><br><br>

    <label for="health">Health:</label>
    <input type="number" id="health" name="health" value="<?php echo $health; ?>" min="1"><br><br>

    <label for="defense">Defense:</label>
    <input type="number" id="defense" name="defense" value="<?php echo $defense; ?>" min="0"><br><br>

    <label for="consumable">Consumable:</label>
    <input type="number" id="consumable" name="consumable" value="<?php echo $consumable; ?>" min="0"><br><br>

    <input type="submit" value="Add boss">
</form>
<button onclick="showTable('bosses');">Go back</button>
</body>
</html>