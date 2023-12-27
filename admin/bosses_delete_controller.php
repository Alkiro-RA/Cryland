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
            // Prepare the SQL statement to delete the boss record by ID
            $stmt = $pdo->prepare("DELETE FROM bosses WHERE id = ?");
            $stmt->execute([$id]);

            $_SESSION['success'] = "boss id: $id deleted";
            header("Location: index.php");
        } catch(PDOException $e) {
            // Handle any errors with the database connection or query execution
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: index.php");
        }
    } else {
        try {
            // Prepare the SQL statement to fetch the boss record by ID
            $stmt = $pdo->prepare("SELECT * FROM bosses WHERE id = ?");
            $stmt->execute([$recordId]);
            $boss = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($boss) {
                // If the boss record exists, display the confirmation message
                echo "<h2>Delete boss</h2>";
                echo "<p>Are you sure you want to delete the boss record with ID: {$boss['id']} and Name: {$boss['name']}?</p>";
                echo "<form method='post' action='bosses_delete_controller.php?recordId={$boss['id']}'>";
                echo "<input type='hidden' name='id' value='{$boss['id']}'>";
                echo "<input type='submit' value='Yes'>";
                echo "</form>";
                echo '<button onclick="showTable(\'bosses\');">No, go back</button>';
            } else {
                $_SESSION['error'] = "boss record not found.";
                header("Location: index.php");
            }
        } catch(PDOException $e) {
            // Handle any errors with the database connection or query executionR
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: index.php");
        }
    }
} else {
    $_SESSION['error'] = "Record ID not provided.";
    header("Location: index.php");
}
?>
