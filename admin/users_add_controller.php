<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");

// Variables to hold the input values
$nickname = $email = $password = $roleid = "";

// Fetch roles from the database to display in the dropdown
try {
    $roleStmt = $pdo->prepare("SELECT id, rolename FROM roles");
    $roleStmt->execute();
    $roles = $roleStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Error fetching roles: " . $e->getMessage();
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form input
    $nickname = cleanInput($_POST["nickname"]);
    $email = cleanInput($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $roleid = cleanInput($_POST["roleid"]);

    // Validate input
    if (empty($nickname) || empty($email) || empty($password) || empty($roleid)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: index.php");
        exit();
    } else {
        try {
            // Start a transaction
            $pdo->beginTransaction();

            // Insert a new character for the user
            $defaultCharacterStmt = $pdo->prepare("INSERT INTO characters (name, level, exp, coins, attack, health, maxhealth, defense, potion, consumable) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $defaultCharacterStmt->execute([$nickname, 1, 0, 0, 5, 5, 5, 2, 1, 1]);
            $characterId = $pdo->lastInsertId(); // Get the ID of the newly inserted character

            // Insert user into the users table
            $userStmt = $pdo->prepare("INSERT INTO users (roleid, charactersid, nickname, email, password) VALUES (?, ?, ?, ?, ?)");
            $userStmt->execute([$roleid, $characterId, $nickname, $email, $password]);
            $userId = $pdo->lastInsertId(); // Get the ID of the newly inserted user

            // Commit the transaction
            $pdo->commit();

            $_SESSION['success'] = "$nickname added as a user";
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            // Roll back the transaction if something went wrong
            $pdo->rollBack();

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
    <title>Add User</title>
    <!-- Add your CSS styles here -->
    <style>
        /* Your CSS styles for the form */
    </style>
</head>
<body>
<h2>Add User</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="nickname">Nickname:</label>
    <input type="text" id="nickname" name="nickname" value="<?php echo $nickname; ?>"><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>

    <label for="roleid">Role:</label>
    <select id="roleid" name="roleid">
        <?php foreach ($roles as $role): ?>
            <option value="<?php echo $role['id']; ?>"><?php echo $role['rolename']; ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" value="Add User">
</form>
<button onclick="showTable('users');">Go back</button>
</body>
</html>
