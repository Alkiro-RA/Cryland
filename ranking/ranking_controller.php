<?php
// Db configuration
require_once("../data/db.php");

try {
    // Get characters' data from db
    $sql = "SELECT name, level FROM Characters";
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute()) {
        throw new Exception();
    }
    // Sort the data
    $characters = $stmt->fetchAll();
    usort($characters, function ($a, $b) {
        return $b['level'] <=> $a['level'];
    });
    // Put data into HTML's table
    foreach ($characters as $char) {
        echo 
        "<tr>
            <td>{$char['name']}</td>
            <td>{$char['level']}</td>
        </tr>";
    }
} 
catch (Exception) {
    echo "User's fault.";
}
