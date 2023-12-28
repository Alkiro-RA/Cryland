<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");

// Check if record ID is present in the request
if (isset($_GET['recordId'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get and sanitize form input
        $id = cleanInput($_POST["id"]);
        $roleid = cleanInput($_POST["roleid"]);
        $nickname = cleanInput($_POST["nickname"]);
        $email = cleanInput($_POST["email"]);
        $characterid = cleanInput($_POST["characterid"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

        // Validate input
        if (empty($id) || empty($roleid) || empty($nickname) || empty($email)) {
            $_SESSION['error'] = "Please enter valid values. All fields are required.";
            header("Location: index.php");
        } else {
            try {
                // Prepare the SQL statement to update data
                $stmt = $pdo->prepare("UPDATE users SET roleid = ?, nickname = ?, email = ?, charactersid = ?, password = ? WHERE id = ?");
                $stmt->execute([$roleid, $nickname, $email, $characterid, $password, $id]);

                // Redirect to the users table view after updating the record
                $_SESSION['success'] = "User with ID: $id updated.";
                header("Location: index.php");
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: index.php");
            }
        }
    }

    $recordId = $_GET['recordId'];

    try {
        // Fetch user details by ID
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$recordId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Fetch characters for the select list
            $stmt = $pdo->prepare("SELECT id, name FROM characters");
            $stmt->execute();
            $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Form to edit user details
            echo '<h2>Edit User</h2>';
            echo '<form method="post" action="users_edit_controller.php?recordId=' . $recordId . '">';
            echo '<input type="hidden" name="id" value="' . $user['id'] . '">';
            echo '<label for="roleid">Role:</label>';
            // Display roles in a dropdown list
            echo '<select id="roleid" name="roleid">';
            // Fetch roles from the database and display them in the dropdown
            $stmt = $pdo->prepare("SELECT id, rolename FROM roles");
            $stmt->execute();
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($roles as $role) {
                $selected = ($role['id'] == $user['roleid']) ? 'selected' : '';
                echo '<option value="' . $role['id'] . '" ' . $selected . '>' . $role['rolename'] . '</option>';
            }
            echo '</select><br><br>';

            echo '<label for="nickname">Nickname:</label>';
            echo '<input type="text" id="nickname" name="nickname" value="' . $user['nickname'] . '"><br><br>';
            echo '<label for="email">Email:</label>';
            echo '<input type="email" id="email" name="email" value="' . $user['email'] . '"><br><br>';

            // Display character list for selection
            echo '<label for="characterid">Select Character:</label>';
            echo '<select id="characterid" name="characterid">';
            foreach ($characters as $character) {
                $selectedCharacter = ($character['id'] == $user['charactersid']) ? 'selected' : '';
                echo '<option value="' . $character['id'] . '" ' . $selectedCharacter . '>' . $character['name'] . '</option>';
            }
            echo '</select><br><br>';

            // Input field for new password
            echo '<label for="password">New Password:</label>';
            echo '<input type="password" id="password" name="password"><br><br>';

            echo '<input type="submit" value="Update User">';
            echo '</form>';
        } else {
            $_SESSION['error'] = "User not found.";
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
