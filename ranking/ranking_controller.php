<?php
session_start();

try {
    // Db configuration
    require_once("../data/db.php");
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
        "<tr id='row'>
            <td id='name'>{$char['name']}</td>
            <td>{$char['level']}</td>
            <td></td>
        </tr>";
    }
} 
catch (Exception) {
    echo "User's fault.";
}
