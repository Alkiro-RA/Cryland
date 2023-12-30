<?php
require_once ("../../../data/db.php");
require_once ("../../../other/authorization.php");
unset($_SESSION['boss_fight']);
if (isset($_GET['equip'])) {
    $eqid = $_GET['equip'];

    try {
        if($_SESSION['character']['weaponsid'] == NULL){
            // Retrieve the weapon ID from the 'eq' table based on $eqid
            $stmt = $pdo->prepare("SELECT weaponid FROM eq WHERE id = ?");
            $stmt->execute([$eqid]);
            $eqWeaponId = $stmt->fetchColumn();

            // Update the 'characters' table to equip the selected weapon
            $stmt = $pdo->prepare("UPDATE characters SET weaponsid = ? WHERE id = ?");
            $stmt->execute([$eqWeaponId, $_SESSION["char_id"]]);

            $stmt = $pdo->prepare("DELETE FROM eq WHERE eq.id = ?");
            $stmt->execute([$eqid]);
            $_SESSION['character']['weaponsid'] = $eqWeaponId;
        } else {
            // Retrieve the weapon ID from the 'eq' table based on $eqid
            $stmt = $pdo->prepare("SELECT weaponid FROM eq WHERE id = ?");
            $stmt->execute([$eqid]);
            $eqWeaponId = $stmt->fetchColumn();

            // Update the 'characters' table to equip the selected weapon
            $stmt = $pdo->prepare("UPDATE characters SET weaponsid = ? WHERE id = ?");
            $stmt->execute([$eqWeaponId, $_SESSION["char_id"]]);

            $stmt = $pdo->prepare("UPDATE eq SET weaponid = ? WHERE id = ?");
            $stmt->execute([$_SESSION['character']['weaponsid'],$eqid]);
            $_SESSION['character']['weaponsid'] = $eqWeaponId;
        }
    } catch (PDOException $e) {
        // Handle exceptions
        // For instance, you can set a session error message
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: index.php");
        exit();
    }
}

if(isset($_SESSION['character'])){
    $character = $_SESSION['character'];
    try{
        if($character['weaponsid'] != NULL){
            $stmt = $pdo->prepare("SELECT w.name AS weapon_name, w.attack_bonus AS weapon_attack, w.health_bonus AS weapon_health, w.defense_bonus AS weapon_defense 
                        FROM characters c LEFT JOIN weapons w ON w.id = c.weaponsid WHERE c.id = ?");
            $stmt->execute([$_SESSION["char_id"]]);

            $current_weapon = $stmt->fetch();
        } else {
            $current_weapon = NULL;
        }

        // Prepare the SQL statement to retrieve all weapons
        $stmt = $pdo->prepare("SELECT e.id, w.name AS weapon_name, w.attack_bonus AS weapon_attack, w.health_bonus AS weapon_health, w.defense_bonus AS weapon_defense
                        FROM eq e LEFT JOIN weapons w ON w.id = e.weaponid WHERE characterid = ?");
// Execute the statement
        $stmt->execute([$_SESSION["char_id"]]);
// Fetch all rows as an associative array
        $eq = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $eqHTML = '<h2>Inventory</h2>';
        $eqHTML .= '<table>';
        $eqHTML .= '<tr><th>Weapon</th><th>Attack Bonus</th><th>Magic Bonus</th><th>Defense Bonus</th></tr>';
        if(!empty($current_weapon)){
            $eqHTML .= '<tr>';
            $eqHTML .= '<td>' . $current_weapon['weapon_name'] . '</td>';
            $eqHTML .= '<td>' . $current_weapon['weapon_attack'] . '</td>';
            $eqHTML .= '<td>' . $current_weapon['weapon_health'] . '</td>';
            $eqHTML .= '<td>' . $current_weapon['weapon_defense'] . '</td>';
            $eqHTML .= '</tr>';
        } else{
            $eqHTML .= '<tr>';
            $eqHTML .= '<td>None</td>';
            $eqHTML .= '<td>0</td>';
            $eqHTML .= '<td>0</td>';
            $eqHTML .= '<td>0</td>';
            $eqHTML .= '</tr>';
        }


        $eqHTML .= '</table>';
        $eqHTML .= '<table>';
        $eqHTML .= '<tr><th>Weapon</th><th>Attack Bonus</th><th>Healing Bonus</th><th>Defense Bonus</th></tr>';

        foreach ($eq as $item) {
            $eqHTML .= '<tr>';
            $eqHTML .= '<td>' . $item['weapon_name'] . '</td>';
            $eqHTML .= '<td>' . $item['weapon_attack'] . '</td>';
            $eqHTML .= '<td>' . $item['weapon_health'] . '</td>';
            $eqHTML .= '<td>' . $item['weapon_defense'] . '</td>';
            $eqHTML .= '<td class="td-button"><button class="equip-button" onclick="equip(' . $item['id'] . ')">Equip</button></td>';
            $eqHTML .= '</tr>';
        }

        $eqHTML .= '</table>';
        $eqHTML .= '<button onclick="window.location.href=\'../\'">Back</button>';
        echo $eqHTML;

    }catch (PDOException $e)
    {

    }
}
