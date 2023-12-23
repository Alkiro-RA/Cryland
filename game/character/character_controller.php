<?php
require_once ("../../data/db.php");
require_once("../../other/authorization.php");
$character = $_SESSION['character']; //Only for test purpose
try{
    /*$userID = $_SESSION['user_id']; // Replace with your actual session variable name

    $stmt = $pdo->prepare("SELECT * FROM characters WHERE id = (SELECT charactersid FROM users WHERE id = :userID)");
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();

    $character = $stmt->fetch(PDO::FETCH_ASSOC);*/

    // Check if the user has upgraded any attributes
    if (isset($_GET['upgrade'])) {
        $attribute = $_GET['upgrade'];
        switch ($attribute) {
            case 'attack':
                $character['attack'] += 1;
                break;
            case 'health':
                $character['health'] += 1;
                break;
            case 'defense':
                $character['defense'] += 1;
                break;
            default:
                // Handle if any other action is received
                break;
        }
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$characterInfoHTML = '
        <h1>'.$character['name'].'</h1>
        <p>Attack: '.$character['attack'].' <button class="upgrade-button" onclick="upgradeAttribute(\'attack\')">+</button></p>
        <p>Health: '.$character['health'].' <button class="upgrade-button" onclick="upgradeAttribute(\'health\')">+</button></p>
        <p>Defense: '.$character['defense'].' <button class="upgrade-button" onclick="upgradeAttribute(\'defense\')">+</button></p>
';
echo $characterInfoHTML;
// Update the session character data
$_SESSION['character'] = $character;
?>