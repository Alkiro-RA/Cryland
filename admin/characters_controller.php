<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");

try {
    // Prepare the SQL statement with a LEFT JOIN to retrieve character details along with their weapons
    $stmt = $pdo->prepare("SELECT c.id, c.name, c.level, c.exp, c.coins, w.name AS weapon_name, c.attack, c.health, c.maxhealth, c.defense, c.potion, c.consumable, c.duel_won
                           FROM characters c
                           LEFT JOIN weapons w ON c.weaponsid = w.id");

    // Execute the statement
    $stmt->execute();

    // Fetch all rows as an associative array
    $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Process the retrieved data (for example, create an HTML table)
    $tableHTML = '<div><button onclick="redirectToAction(\'characters\', \'add\')">Add</button>
<table>';
    $tableHTML .= '<tr><th>ID</th><th>Name</th><th>Level</th><th>Experience</th><th>Coins</th><th>Weapon Name</th><th>Attack</th><th>Health</th><th>Max Health</th><th>Defense</th><th>Potion</th><th>Consumable</th><th>Duel won</th><th>Actions</th></tr>';

    foreach ($characters as $character) {
        $tableHTML .= '<tr>';
        $tableHTML .= '<td>' . $character['id'] . '</td>';
        $tableHTML .= '<td>' . $character['name'] . '</td>';
        $tableHTML .= '<td>' . $character['level'] . '</td>';
        $tableHTML .= '<td>' . $character['exp'] . '</td>';
        $tableHTML .= '<td>' . $character['coins'] . '</td>';
        $tableHTML .= '<td>' . ($character['weapon_name'] ?? 'None') . '</td>'; // Display weapon name or 'None' if no weapon
        $tableHTML .= '<td>' . $character['attack'] . '</td>';
        $tableHTML .= '<td>' . $character['health'] . '</td>';
        $tableHTML .= '<td>' . $character['maxhealth'] . '</td>';
        $tableHTML .= '<td>' . $character['defense'] . '</td>';
        $tableHTML .= '<td>' . $character['potion'] . '</td>';
        $tableHTML .= '<td>' . $character['consumable'] . '</td>';
        $tableHTML .= '<td>' . $character['duel_won'] . '</td>';
        $tableHTML .= '<td><button onclick="redirectToAction(\'characters\',\'edit\',' . $character['id'] . ')">Edit</button><button onclick="redirectToAction(\'characters\',\'delete\',' . $character['id'] . ')">Delete</button></td>';
        $tableHTML .= '</tr>';
    }

    $tableHTML .= '</table></div>';

    echo $tableHTML;
} catch(PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: index.php");
}
?>
