<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");

// Check if the recordId is passed through GET request
if (isset($_GET['recordId'])) {
    $recordId = $_GET['recordId'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id = $_POST['id'];

        try {
            // Prepare the SQL statement to delete the character record by ID
            $stmt = $pdo->prepare("DELETE FROM characters WHERE id = ?");
            $stmt->execute([$id]);

            $_SESSION['success'] = "Character ID: $id deleted";
            header("Location: index.php");
            exit();
        } catch(PDOException $e) {
            // Handle any errors with the database connection or query execution
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: index.php");
            exit();
        }
    } else {
        try {
            // Prepare the SQL statement to fetch the character record by ID
            $stmt = $pdo->prepare("SELECT * FROM characters WHERE id = ?");
            $stmt->execute([$recordId]);
            $character = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($character) {
                // If the character record exists, display the confirmation message
                echo "<h2>Delete Character</h2>";
                echo "<p>Are you sure you want to delete the character record with ID: {$character['id']} and Name: {$character['name']}?</p>";
                echo "<form method='post' action='characters_delete_controller.php?recordId={$character['id']}'>";
                echo "<input type='hidden' name='id' value='{$character['id']}'>";
                echo "<input type='submit' value='Yes'>";
                echo "</form>";
                echo '<button onclick="showTable(\'characters\');">No, go back</button>';
            } else {
                $_SESSION['error'] = "Character record not found.";
                header("Location: index.php");
                exit();
            }
        } catch(PDOException $e) {
            // Handle any errors with the database connection or query execution
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: index.php");
            exit();
        }
    }
} else {
    $_SESSION['error'] = "Record ID not provided.";
    header("Location: index.php");
    exit();
}
?>
