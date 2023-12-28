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
            // Prepare the SQL statement to delete the weapon record by ID
            $stmt = $pdo->prepare("DELETE FROM weapons WHERE id = ?");
            $stmt->execute([$id]);

            $_SESSION['success'] = "Weapon id: $id deleted";
            header("Location: index.php");
        } catch(PDOException $e) {
            // Handle any errors with the database connection or query execution
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: index.php");
        }
    } else {
        try {
            // Prepare the SQL statement to fetch the weapon record by ID
            $stmt = $pdo->prepare("SELECT * FROM weapons WHERE id = ?");
            $stmt->execute([$recordId]);
            $weapon = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($weapon) {
                // If the weapon record exists, display the confirmation message
                echo "<h2>Delete weapon</h2>";
                echo "<p>Are you sure you want to delete the weapon record with ID: {$weapon['id']} and Name: {$weapon['name']}?</p>";
                echo "<form method='post' action='weapons_delete_controller.php?recordId={$weapon['id']}'>";
                echo "<input type='hidden' name='id' value='{$weapon['id']}'>";
                echo "<input type='submit' value='Yes'>";
                echo "</form>";
                echo '<button onclick="showTable(\'weapons\');">No, go back</button>';
            } else {
                $_SESSION['error'] = "weapon record not found.";
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
