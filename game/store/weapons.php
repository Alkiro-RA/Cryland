<?php
require_once("../../other/authorization.php");
require_once("../../data/db.php");

try {
    // Fetch weapons from DB
    $sql = "SELECT * FROM Weapons";
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute()) {
        throw new Exception();
    }
    $weapons = $stmt->fetchAll();
    // Display weapons 
    foreach($weapons as $weapon) {
        echo 
        "<tr>
            <td>{$weapon['name']}</td>
            <td>{$weapon['attack_bonus']}</td>
            <td>{$weapon['health_bonus']}</td>
            <td>{$weapon['defense_bonus']}</td>
            <td>{$weapon['price']}</td>
        </tr>";
    }  
} catch (Exception) {
    echo "Database error.";
}