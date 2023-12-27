<?php
// Fetch player and enemy data from the database based on the battle scenario
// For example, select player and enemy based on their IDs
require_once ("../../data/db.php");
require_once("../../other/authorization.php");

try {
    $player = $_SESSION['character'];

    // Check if data was fetched successfully
    if (isset($_SESSION['enemy'])) {
        $enemy = $_SESSION['enemy'];
        $player_action_done = false;
        // Checking if player and enemy are alive
        if ($player['health'] > 0 && $enemy['health'] > 0) {
            // Step 1: Player's Turn
            if ($player['health'] > 0) {
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
                            $enemy['health'] = $enemy['health'] - $dmg;
                            $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' attacked '. $enemy['name'] .' for '.$dmg.'</p>';
                            // Handle attack action
                            // Perform your attack logic here
                            $player_action_done = true;
                            break;

                        case 'potion':
                            if ($player['potion']>0)
                            {
                                $healed_amount = $player['maxhealth'] - $player['health'];
                                $player['health'] = $player['health'] + 10;
                                if($player['health'] > $player['maxhealth']){
                                    $player['health'] = $player['maxhealth'];
                                    $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' healed for '.$healed_amount.' </p>';
                                }
                                else{
                                    $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' healed for 10 </p>';
                                }
                                $player['potion'] = $player['potion'] - 1;

                                // Handle potion action
                                // Perform potion-related logic here
                                $player_action_done = true;
                            }

                            break;

                        case 'consumable':
                            if($player['consumable']>0)
                            {
                                // Aplying paralysis on enemy
                                $_SESSION['paralysis_counter'] = 2;
                                $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' paralized '.$enemy['name'].'</p>';
                                // Handle consumable action
                                // Perform consumable-related logic here
                                $player_action_done = true;
                                $player['consumable'] = $player['consumable'] - 1;
                            }

                            break;

                        case 'consumable_2':
                            if($player['consumable']>0)
                            {
                                // Bomb that ignore defense
                                $dmg = $player['attack']*2;
                                $enemy['health'] = $enemy['health'] - $dmg;
                                $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' attacked '. $enemy['name'] .' for '.$dmg.'</p>';
                                $player_action_done = true;
                                $player['consumable'] = $player['consumable'] - 1;
                            }



                            break;

                        default:
                            // Handle invalid action or no action provided
                            break;
                    }
                } else {
                    // No action parameter provided
                }
                // Perform action based on player's choice
                // Update player/enemy health, check for special actions, etc.

                // Check if the enemy survived the attack
                if ($enemy['health'] <= 0) {
                    $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' won against '. $enemy['name'] .'</p>';
                    $_SESSION['battle_log'] .= '<p>'.$player['name'].' got '.$enemy['lvl'].' points</p>';
                    $player['exp'] = $player['exp'] + $enemy['lvl'];
                    // Update player's data in the database
                    $stmt = $pdo->prepare("UPDATE characters SET health = :health, potion = :potion, consumable = :consumable, exp = :exp WHERE id = :id");
                    $stmt->bindParam(':health', $player['health']);
                    $stmt->bindParam(':potion', $player['potion']);
                    $stmt->bindParam(':consumable', $player['consumable']);
                    $stmt->bindParam(':exp',$player['exp']);
                    $stmt->bindParam(':id', $player['id']);
                    $stmt->execute();
                    // Enemy defeated, handle victory
                    // Break the loop or perform necessary actions

                } else if ($player_action_done) {
                    // Step 2: Enemy's Turn
                    // Enemy attacks the player
                    // Update player's health based on enemy's attack power
                    if ($_SESSION['paralysis_counter'] > 0)
                    {
                        $_SESSION['paralysis_counter'] = $_SESSION['paralysis_counter'] - 1;
                        $_SESSION['battle_log'] .= '<p>' . $enemy['name'] . ' did nothing </p>';
                    }
                    else{
                        $dmg = $enemy['attack'] - $player['defense'];
                        if($dmg < 1) $dmg = 1;
                        $player['health'] = $player['health']- $dmg;
                        $_SESSION['battle_log'] .= '<p>' . $enemy['name'] . ' attacked '. $player['name'] .' for '.$dmg.'</p>';
                    }
                    // Check if the player survived the attack
                    if ($player['health'] <= 0) {
                        $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' lost against '. $enemy['name'] .'</p>';
                        // Player defeated, handle defeat
                        // Break the loop or perform necessary actions
                    }
                }
            }
        }
        // Update player and enemy data in the database after battle
        if ($player && $enemy) {
            $_SESSION['enemy'] = $enemy;
            $_SESSION['character'] = $player;
        }

        $player_action_done = false;

        // Generate the updated battle information HTML
        $battleInfoHTML = '<div class="battle-info">';
        $battleInfoHTML .= '<div class="player-info">';
        $battleInfoHTML .= '<h2>' . $player['name'] . '</h2>';
        $battleInfoHTML .= '<p>HP: ' . $player['health'] . ' / ' . $player['maxhealth'] . '</p>';
        $battleInfoHTML .= '<p>Potions: ' . $player['potion'] . '</p>';
        $battleInfoHTML .= '<p>Scrolls: ' . $player['consumable'] . '</p>';
        $battleInfoHTML .= '</div>';
        $battleInfoHTML .= '<div class="enemy-info">';
        $battleInfoHTML .= '<h2>' . $enemy['name'] . '</h2>';
        if ($_SESSION['paralysis_counter']>0)
            $battleInfoHTML .= '<p><span class="paralized">PARALIZED</span> </p>';
        $battleInfoHTML .= '<p>HP: ' . $enemy['health'] . ' / ' . $enemy['maxhealth'] . '</p>';
        // Add more enemy information as needed
        $battleInfoHTML .= '</div>';
        $battleInfoHTML .= '</div>';

        if ($player['health'] <= 0 || $enemy['health'] <= 0)
        {
            // Inserting the buttons into the battle info HTML
            $battleInfoHTML .= '<div class="battle-buttons">';
            $battleInfoHTML .= '<button onclick="redirectToHome()">Go home</button>';
            $battleInfoHTML .= '</div>'; // Closing buttons div
        }
        else{
            // Inserting the buttons into the battle info HTML
            $battleInfoHTML .= '<button onclick="performAction(\'attack\')">Attack</button>';
            $battleInfoHTML .= '<button onclick="performAction(\'potion\')">Use Potion</button>';
            $battleInfoHTML .= '<button onclick="performAction(\'consumable\')">Use paralysis bomb</button>';
            $battleInfoHTML .= '<button onclick="performAction(\'consumable_2\')">Use fire bomb</button>';
        }


        $battleInfoHTML .= '<div class="wrapper">
                                <div class="scrollable-container">
                                    <div class="content">';
        $battleInfoHTML .= $_SESSION['battle_log'];
        $battleInfoHTML .= '</div></div></div>';




// Echo or return the HTML content
        echo $battleInfoHTML; // This will output the HTML content directly
    } else {

    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>