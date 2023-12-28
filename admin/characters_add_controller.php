<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");

// Variables to hold the input values
$name = $level = $exp = $coins = $weaponsid = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form input
    $name = cleanInput($_POST["name"]);
    $level = cleanInput($_POST["level"]);
    $exp = cleanInput($_POST["exp"]);
    $coins = cleanInput($_POST["coins"]);
    $weaponsid = cleanInput($_POST["weaponsid"]);

    // Validate input (perform additional validation if necessary)
    if (empty($name) || $level < 1 || $exp < 0 || $coins < 0) {
        $_SESSION['error'] = "Please enter valid values.";
        header("Location: index.php");
    } else {
        try {
            // Prepare the SQL statement to insert data
            $stmt = $pdo->prepare("INSERT INTO characters (name, level, exp, coins, weaponsid) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $level, $exp, $coins, $weaponsid]);

            // Redirect to the characters table view after adding the record
            $_SESSION['success'] = "$name added into characters";
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
    <title>Add Character</title>
    <!-- Add your CSS styles here -->
    <style>
        /* Your CSS styles for the form */
    </style>
</head>
<body>
<h2>Add Character</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br><br>

    <label for="level">Level:</label>
    <input type="number" id="level" name="level" value="<?php echo $level; ?>" min="1"><br><br>

    <label for="exp">Experience:</label>
    <input type="number" id="exp" name="exp" value="<?php echo $exp; ?>" min="0"><br><br>

    <label for="coins">Coins:</label>
    <input type="number" id="coins" name="coins" value="<?php echo $coins; ?>" min="0"><br><br>

    <label for="weaponsid">Weapon:</label>
    <select id="weaponsid" name="weaponsid">
        <option value="">Null</option>
        <?php
        // Fetch all weapons from the database
        $stmt = $pdo->prepare("SELECT id, name FROM weapons");
        $stmt->execute();
        $weapons = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the list of weapons as options in the dropdown
        foreach ($weapons as $weapon) {
            echo '<option value="' . $weapon['id'] . '">' . $weapon['name'] . '</option>';
        }
        ?>
    </select><br><br>

    <input type="submit" value="Add Character">
</form>
<button onclick="showTable('characters');">Go back</button>
</body>
</html>
