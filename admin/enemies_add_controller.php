<?php
// Include the database connection
require_once("../data/db.php");

// Variables to hold the input values
$name = $lvl = $attack = $health = $defense = "";
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form input
    $name = cleanInput($_POST["name"]);
    $lvl = cleanInput($_POST["lvl"]);
    $attack = cleanInput($_POST["attack"]);
    $health = cleanInput($_POST["health"]);
    $defense = cleanInput($_POST["defense"]);

    // Validate input
    if (empty($name) || $lvl < 0 || $attack < 0 || $health < 0 || $defense < 0) {
        $error = "Please enter valid values. Negative values are not allowed.";
    } else {
        try {
            // Prepare the SQL statement to insert data
            $stmt = $pdo->prepare("INSERT INTO enemies (name, lvl, attack, health, defense) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $lvl, $attack, $health, $defense]);
            // Redirect to the enemies table view after adding the record
            //header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
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
    <title>Add Enemy</title>
    <!-- Add your CSS styles here -->
    <style>
        /* Your CSS styles for the form */
    </style>
</head>
<body>
<h2>Add Enemy</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br><br>

    <label for="lvl">Level:</label>
    <input type="number" id="lvl" name="lvl" value="<?php echo $lvl; ?>"><br><br>

    <label for="attack">Attack:</label>
    <input type="number" id="attack" name="attack" value="<?php echo $attack; ?>"><br><br>

    <label for="health">Health:</label>
    <input type="number" id="health" name="health" value="<?php echo $health; ?>"><br><br>

    <label for="defense">Defense:</label>
    <input type="number" id="defense" name="defense" value="<?php echo $defense; ?>"><br><br>

    <input type="submit" value="Add Enemy">
</form>

<?php
// Display error message, if any
if ($error) {
    echo "<p style='color: red;'>Error: $error</p>";
}
?>
</body>
</html>
