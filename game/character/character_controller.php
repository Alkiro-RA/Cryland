<?php
require_once ("../../data/db.php");
require_once("../../other/authorization.php");
unset($_SESSION['boss_fight']);
$character = $_SESSION['character']; //Only for test purpose
try{
    if($character['exp']>=$character['level'])
    {
        if (isset($_GET['upgrade'])) {
            $attribute = $_GET['upgrade'];
            switch ($attribute) {
                case 'attack':
                    $character['attack'] += 1;
                    $character['exp'] = $character['exp'] - $character['level'];
                    $character['level'] = $character['level'] + 1;
                    break;
                case 'health':
                    $character['maxhealth'] += 1;
                    $character['health'] = $character['maxhealth'];
                    $character['exp'] = $character['exp'] - $character['level'];
                    $character['level'] = $character['level'] + 1;
                    break;
                case 'defense':
                    $character['defense'] += 1;
                    $character['exp'] = $character['exp'] - $character['level'];
                    $character['level'] = $character['level'] + 1;
                    break;
                default:
                    // Handle if any other action is received
                    break;
            }
        }
    }
    if (isset($_GET['upgrade'])) {
        $attribute = $_GET['upgrade'];
        switch ($attribute) {
            case 'save':
                // Handle logic for 'save' action
                // Perform SQL update to save changes to the database
                $stmt = $pdo->prepare("UPDATE characters SET attack = :attack, health = :health, maxhealth = :maxhealth, defense = :defense, level = :level, exp = :exp WHERE id = :id");
                $stmt->bindParam(':attack', $character['attack']);
                $stmt->bindParam(':health', $character['health']);
                $stmt->bindParam(':maxhealth', $character['maxhealth']);
                $stmt->bindParam(':defense', $character['defense']);
                $stmt->bindParam(':level', $character['level']);
                $stmt->bindParam(':exp', $character['exp']);
                $stmt->bindParam(':id', $_SESSION['char_id']); // Replace 'id' with the appropriate column name for character ID
                $stmt->execute();
                break;
            case 'reset':
                // Handle logic for 'reset' action
                $stmt = $pdo->prepare("SELECT * FROM characters WHERE id = :id");
                $stmt->bindParam('id', $_SESSION['char_id']);
                $stmt->execute();

                $character = $stmt->fetch(PDO::FETCH_ASSOC);
                break;
            case 'potion':
                // Handle logic for 'potion' action
                if($character['exp']<2){
                    echo 'No cheating!!';
                }
                else{
                    $character['potion'] += 1;
                    $character['exp'] -=2;
                }
                break;
            case 'consumable':
                // Handle logic for 'consumable' action
                if($character['exp']<4){
                    echo 'No cheating!!';
                }
                else{
                    $character['consumable'] += 1;
                    $character['exp'] -=4;
                }
                break;
            default:
                // Handle any other action here
                break;
        }
    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$characterInfoHTML = '
<h2>'.$character['name'].'</h2>
    <div class="character-info">                
        <div>
            <p>Attack: '.$character['attack'].' </p>
            <p>Health: '.$character['maxhealth'].' </p>
            <p>Defense: '.$character['defense'].' </p>
        </div>  
        <div>';
if($character['exp']<$character['level']){
    $characterInfoHTML .= '<button class="unclickable-button" id="add-button" onclick="upgradeAttribute(\'attack\')">+</button><br/>
            <button class="unclickable-button" id="add-button" onclick="upgradeAttribute(\'health\')">+</button><br/>
            <button class="unclickable-button" id="add-button" onclick="upgradeAttribute(\'defense\')">+</button><br/>';
}
else{
    $characterInfoHTML .= '<button id="add-button" onclick="upgradeAttribute(\'attack\')">+</button><br/>
            <button id="add-button" onclick="upgradeAttribute(\'health\')">+</button><br/>
            <button id="add-button" onclick="upgradeAttribute(\'defense\')">+</button><br/>';
}

$characterInfoHTML .=        '</div>    
    </div>
    <div class="character-info">
        <p>Level: '.$character['level'].'</p>
        <p>Points: '.$character['exp'].'</p>
        <p>Potions: '.$character['potion'].'</p>
        <p>Scrolls: '.$character['consumable'].'</p>
    </div>';
$characterInfoHTML .='<div class="char-buttons">
        <button onclick="upgradeAttribute(\'save\')">Save</button>
        <button onclick="upgradeAttribute(\'reset\')">Reset</button>
        <button onclick="window.location.href=\'inventory\'">Inventory</button>
        <button onclick="window.location.href=\'../index.php\'">Back</button>';

$characterInfoHTML .=  '</div>';
echo $characterInfoHTML;
// Update the session character data
$_SESSION['character'] = $character;
?>