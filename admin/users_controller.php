<?php
require_once("../data/db.php");
require_once("../other/authorization.php");
require_once("admin_verification.php");

try {
    // Prepare the SQL statement with JOIN operations to retrieve role name and character details
    $stmt = $pdo->prepare("SELECT u.id, r.rolename, c.id AS character_id, c.name AS character_name, u.nickname, u.email 
                           FROM users u
                           LEFT JOIN roles r ON u.roleid = r.id
                           LEFT JOIN characters c ON u.charactersid = c.id");

    // Execute the statement
    $stmt->execute();

    // Fetch all rows as an associative array
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Process the retrieved data (for example, create an HTML table)
    $tableHTML = '<div><button onclick="redirectToAction(\'users\', \'add\')">Add</button>
<table>';
    $tableHTML .= '<tr><th>ID</th><th>Role</th><th>Character ID</th><th>Character Name</th><th>Nickname</th><th>Email</th><th>Actions</th></tr>';

    foreach ($users as $user) {
        $tableHTML .= '<tr>';
        $tableHTML .= '<td>' . $user['id'] . '</td>';
        $tableHTML .= '<td>' . $user['rolename'] . '</td>';
        $tableHTML .= '<td>' . $user['character_id'] . '</td>';
        $tableHTML .= '<td>' . $user['character_name'] . '</td>';
        $tableHTML .= '<td>' . $user['nickname'] . '</td>';
        $tableHTML .= '<td>' . $user['email'] . '</td>';
        $tableHTML .= '<td><button onclick="redirectToAction(\'users\',\'edit\',' . $user['id'] . ')">Edit</button><button onclick="redirectToAction(\'users\',\'delete\',' . $user['id'] . ')">Delete</button></td>';
        $tableHTML .= '</tr>';
    }

    $tableHTML .= '</table></div>';

    echo $tableHTML;
} catch(PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: index.php");
}
?>
