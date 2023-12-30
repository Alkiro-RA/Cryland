<?php

try {
    // Db configuration
    require_once("../data/db.php");
    // Get characters' data from db
    $sql = "SELECT name, level, duel_won FROM Characters";
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute()) {
        throw new Exception();
    }
    // Sort the data
    $characters = $stmt->fetchAll();
    usort($characters, function ($a, $b) {
        return $b['level'] <=> $a['level'];
    });
    
    // Make loop show top 10 players
    // Put data into HTML's table
    foreach ($characters as $char) {
        $fallen_bosses = "";
        $duel_count = $char['duel_won'];
        // Check won duels
        if ($duel_count > 0) {
            $fallen_bosses .= ' Goblin King ';
        }
        if ($duel_count > 1) {
            $fallen_bosses .= ' Smoczex Płaczex ';
        }
        echo
        "<tr>
            <td>{$char['name']}</td>
            <td>{$char['level']}</td>
            <td>{$fallen_bosses}</td>
        </tr>";
    }
} catch (Exception) {
    echo "User's fault.";
}
