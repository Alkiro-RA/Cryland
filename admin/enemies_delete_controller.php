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
            // Prepare the SQL statement to delete the enemy record by ID
            $stmt = $pdo->prepare("DELETE FROM enemies WHERE id = ?");
            $stmt->execute([$id]);

            $_SESSION['success'] = "Enemy id: $id deleted";
            header("Location: index.php");
        } catch(PDOException $e) {
            // Handle any errors with the database connection or query execution
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: index.php");
        }
    } else {
        try {
            // Prepare the SQL statement to fetch the enemy record by ID
            $stmt = $pdo->prepare("SELECT * FROM enemies WHERE id = ?");
            $stmt->execute([$recordId]);
            $enemy = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($enemy) {
                // If the enemy record exists, display the confirmation message
                echo "<h2>Delete Enemy</h2>";
                echo "<p>Are you sure you want to delete the enemy record with ID: {$enemy['id']} and Name: {$enemy['name']}?</p>";
                echo "<form method='post' action='enemies_delete_controller.php?recordId={$enemy['id']}'>";
                echo "<input type='hidden' name='id' value='{$enemy['id']}'>";
                echo "<input type='submit' value='Yes'>";
                echo "</form>";
                echo '<button onclick="showTable(\'enemies\');">No, go back</button>';
            } else {
                $_SESSION['error'] = "Enemy record not found.";
                header("Location: index.php");
            }
        } catch(PDOException $e) {
            // Handle any errors with the database connection or query execution
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: index.php");
        }
    }
} else {
    $_SESSION['error'] = "Record ID not provided.";
    header("Location: index.php");
}
?>
