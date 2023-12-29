<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");


try {
    // Prepare the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM enemies");

    // Execute the statement
    $stmt->execute();

    // Fetch all rows as an associative array
    $enemies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Process the retrieved data (for example, create an HTML table)
    $tableHTML = '<div><button onclick="redirectToAction(\'enemies\', \'add\')">Add</button>
<table>';
    $tableHTML .= '<tr><th>ID</th><th>Name</th><th>Level</th><th>Attack</th><th>Health</th><th>Defense</th><th>Actions</th></tr>';

    foreach ($enemies as $enemy) {
        $tableHTML .= '<tr>';
        $tableHTML .= '<td>' . $enemy['id'] . '</td>';
        $tableHTML .= '<td>' . $enemy['name'] . '</td>';
        $tableHTML .= '<td>' . $enemy['lvl'] . '</td>';
        $tableHTML .= '<td>' . $enemy['attack'] . '</td>';
        $tableHTML .= '<td>' . $enemy['health'] . '</td>';
        $tableHTML .= '<td>' . $enemy['defense'] . '</td>';
        $tableHTML .= '<td><button onclick="redirectToAction(\'enemies\',\'edit\',' . $enemy['id'] . ')">Edit</button><button onclick="redirectToAction(\'enemies\',\'delete\',' . $enemy['id'] . ')">Delete</button></td>';
        $tableHTML .= '</tr>';
    }

    $tableHTML .= '</table></div>';

    echo $tableHTML;
} catch(PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: index.php");
}
?>
