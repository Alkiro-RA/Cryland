<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");


try {
    // Prepare the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM bosses");

    // Execute the statement
    $stmt->execute();

    // Fetch all rows as an associative array
    $bosses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Process the retrieved data (for example, create an HTML table)
    $tableHTML = '<div><button onclick="redirectToAction(\'bosses\', \'add\')">Add</button>
<table>';
    $tableHTML .= '<tr><th>ID</th><th>Name</th><th>Attack</th><th>Health</th><th>Defense</th><th>Consumable</th><th>Actions</th></tr>';

    foreach ($bosses as $boss) {
        $tableHTML .= '<tr>';
        $tableHTML .= '<td>' . $boss['id'] . '</td>';
        $tableHTML .= '<td>' . $boss['name'] . '</td>';
        $tableHTML .= '<td>' . $boss['attack'] . '</td>';
        $tableHTML .= '<td>' . $boss['health'] . '</td>';
        $tableHTML .= '<td>' . $boss['defense'] . '</td>';
        $tableHTML .= '<td>' . $boss['consumable'] . '</td>';
        $tableHTML .= '<td><button onclick="redirectToAction(\'bosses\',\'edit\',' . $boss['id'] . ')">Edit</button><button onclick="redirectToAction(\'bosses\',\'delete\',' . $boss['id'] . ')">Delete</button></td>';
        $tableHTML .= '</tr>';
    }

    $tableHTML .= '</table></div>';

    echo $tableHTML;
} catch(PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: index.php");
}
?>
