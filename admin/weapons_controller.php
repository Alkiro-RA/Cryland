<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");

try {
    // Prepare the SQL statement to retrieve all weapons
    $stmt = $pdo->prepare("SELECT * FROM weapons");

    // Execute the statement
    $stmt->execute();

    // Fetch all rows as an associative array
    $weapons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Process the retrieved data (for example, create an HTML table)
    $tableHTML = '<div><button onclick="redirectToAction(\'weapons\', \'add\')">Add</button>
<table>';
    $tableHTML .= '<tr><th>ID</th><th>Name</th><th>Price</th><th>Attack Bonus</th><th>Health Bonus</th><th>Defense Bonus</th><th>Actions</th></tr>';

    foreach ($weapons as $weapon) {
        $tableHTML .= '<tr>';
        $tableHTML .= '<td>' . $weapon['id'] . '</td>';
        $tableHTML .= '<td>' . $weapon['name'] . '</td>';
        $tableHTML .= '<td>' . $weapon['price'] . '</td>';
        $tableHTML .= '<td>' . $weapon['attack_bonus'] . '</td>';
        $tableHTML .= '<td>' . $weapon['health_bonus'] . '</td>';
        $tableHTML .= '<td>' . $weapon['defense_bonus'] . '</td>';
        $tableHTML .= '<td><button onclick="redirectToAction(\'weapons\',\'edit\',' . $weapon['id'] . ')">Edit</button><button onclick="redirectToAction(\'weapons\',\'delete\',' . $weapon['id'] . ')">Delete</button></td>';
        $tableHTML .= '</tr>';
    }

    $tableHTML .= '</table></div>';

    echo $tableHTML;
} catch(PDOException $e) {
    // Handle any errors with the database connection or query execution
    $_SESSION['error'] = $e->getMessage();
    header("Location: index.php");
}
?>
