<?php
// Fetch player and enemy data from the database based on the battle scenario
// For example, select player and enemy based on their IDs
require_once ("../../data/db.php");


try {
    // Fetch player data by ID (change '1' to the player's actual ID)
    $player_id = 1;
    $stmt = $pdo->prepare("SELECT * FROM characters WHERE id = :id");
    $stmt->bindParam(':id', $player_id);
    $stmt->execute();
    $player = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch enemy data by ID (change '1' to the enemy's actual ID)
    $enemy_id = 1;
    $stmt = $pdo->prepare("SELECT * FROM enemies WHERE id = :id");
    $stmt->bindParam(':id', $enemy_id);
    $stmt->execute();
    $enemy = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if data was fetched successfully
    if ($player && $enemy) {
        // Do something with $player and $enemy data
        var_dump($player); // Example: Output player data
        var_dump($enemy); // Example: Output enemy data
    } else {
        echo "Player or enemy not found!";
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$player_health = $player['health'];
$enemy_health = $enemy['health'];
$paralysis_bomb = 0;
// Loop until either player or enemy health reaches 0
while ($player_health > 0 || $enemy_health > 0) {
    // Step 1: Player's Turn
    if ($player_health > 0) {
        // Display options for the player (attack, use potion, etc.)
        // Get player's action (from form submission, for instance)
        if (isset($_GET['action'])) {
            $action = $_GET['action'];

            // Handle different actions based on the parameter
            switch ($action) {
                case 'attack':
                    $dmg = $player['attack'] - $enemy['defense'];
                    if ($dmg < 1) {
                        $dmg = 1;
                    }
                    $enemy_health = $enemy_health - $dmg;
                    // Handle attack action
                    // Perform your attack logic here
                    break;

                case 'potion':
                    $player_health = $player_health + 10;
                    if($player_health > $player['health']){
                        $player_health = $player['health'];
                    }
                    // Handle potion action
                    // Perform potion-related logic here
                    break;

                case 'consumable':
                    // Aplying paralysis on enemy
                    $paralysis_bomb = 2;
                    // Handle consumable action
                    // Perform consumable-related logic here
                    break;

                case 'consumable_2':
                    $dmg = $player['attack']*2;
                    $enemy_health = $enemy_health - $dmg;


                    break;

                default:
                    // Handle invalid action or no action provided
                    echo "Invalid action!";
                    break;
            }
        } else {
            // No action parameter provided
            echo "No action specified!";
        }
        // Perform action based on player's choice
        // Update player/enemy health, check for special actions, etc.

        // Check if the enemy survived the attack
        if ($enemy_health <= 0) {
            // Enemy defeated, handle victory
            // Break the loop or perform necessary actions
            echo "You won!!";
            break;

        } else {
            // Step 2: Enemy's Turn
            // Enemy attacks the player
            // Update player's health based on enemy's attack power
            if ($paralysis_bomb > 0)
            {
                $paralysis_bomb --;
            }
            else{
                $dmg = $enemy['atack'] - $player['defense'];
                if($dmg < 1) $dmg = 1;
                $player_health =- $dmg;
            }
            // Check if the player survived the attack
            if ($player_health <= 0) {
                // Player defeated, handle defeat
                // Break the loop or perform necessary actions
                echo "You loose";
                break;
            }
        }
    }
}
?>