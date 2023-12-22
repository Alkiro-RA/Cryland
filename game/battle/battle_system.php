<?php
// Fetch player and enemy data from the database based on the battle scenario
// For example, select player and enemy based on their IDs
require_once ("../../data/db.php");
require_once("../../other/authorization.php");

try {
    // Fetch user data by ID
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch player data by ID
    $player_id = $user['charactersid'];
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

    $_SESSION['enemy'] = $enemy;

    // Check if data was fetched successfully
    if ($player && $enemy) {
        // Do something with $player and $enemy data
        //var_dump($player); // Example: Output player data
        //var_dump($enemy); // Example: Output enemy data
    } else {
        echo "Player or enemy not found!";
    }
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
                        if($player['consumable_2']>0)
                        {
                            // Bomb that ignore defense
                            $dmg = $player['attack']*2;
                            $enemy['health'] = $enemy['health'] - $dmg;
                            $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' attacked '. $enemy['name'] .' for '.$dmg.'</p>';
                            $player_action_done = true;
                            $player['consumable_2'] = $player['consumable_2'] - 1;
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
        // Update player's data in the database
        $stmt = $pdo->prepare("UPDATE characters SET health = :health, potion = :potion, consumable = :consumable, consumable_2 = :consumable_2 WHERE id = :id");
        $stmt->bindParam(':health', $player['health']);
        $stmt->bindParam(':potion', $player['potion']);
        $stmt->bindParam(':consumable', $player['consumable']);
        $stmt->bindParam(':consumable_2',$player['consumable_2']);
        $stmt->bindParam(':id', $player_id);
        $stmt->execute();

        // Update enemy's data in the database
        $stmt = $pdo->prepare("UPDATE enemies SET health = :health WHERE id = :id");
        $stmt->bindParam(':health', $enemy['health']);
        $stmt->bindParam(':id', $enemy_id);
        $stmt->execute();
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$player_action_done = false;

// Generate the updated battle information HTML
$battleInfoHTML = '<div class="battle-info">';
$battleInfoHTML .= '<div class="player-info">';
$battleInfoHTML .= '<h2>' . $player['name'] . '</h2>';
$battleInfoHTML .= '<p>HP: ' . $player['health'] . ' / ' . $player['maxhealth'] . '</p>';
$battleInfoHTML .= '<p>Potions: ' . $player['potion'] . '</p>';
$battleInfoHTML .= '<p>Paralysis bombs: ' . $player['consumable'] . '</p>';
$battleInfoHTML .= '<p>Fire bombs: ' . $player['consumable_2'] . '</p>';
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
    $battleInfoHTML .= '<div class="buttons">';
    $battleInfoHTML .= '<button onclick="performAction(\'go_home\')">Go home</button>';
    $battleInfoHTML .= '</div>'; // Closing buttons div
}
else{
    // Inserting the buttons into the battle info HTML
    $battleInfoHTML .= '<div class="buttons">';
    $battleInfoHTML .= '<button onclick="performAction(\'attack\')">Attack</button>';
    $battleInfoHTML .= '<button onclick="performAction(\'potion\')">Use Potion</button>';
    $battleInfoHTML .= '<button onclick="performAction(\'consumable\')">Use paralysis bomb</button>';
    $battleInfoHTML .= '<button onclick="performAction(\'consumable_2\')">Use fire bomb</button>';
    $battleInfoHTML .= '</div>'; // Closing buttons div
}


$battleInfoHTML .= '<div class="wrapper">
<div class="scrollable-container">
    <div class="content">';
$battleInfoHTML .= $_SESSION['battle_log'];
$battleInfoHTML .= '</div></div></div>';

// Check for the action performed
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Handle different actions based on the parameter
    switch ($action) {
        // Other cases...

        case 'go_home':
            // Redirect to the parent directory (one folder higher)
            header("Location: ../"); // Modify the URL path if needed
            exit(); // Terminate script execution after redirection
            break;

        default:
            // Handle invalid action or no action provided
            break;
    }
}

// Echo or return the HTML content
echo $battleInfoHTML; // This will output the HTML content directly
?>