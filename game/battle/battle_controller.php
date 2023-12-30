<?php
// Fetch player and enemy data from the database based on the battle scenario
// For example, select player and enemy based on their IDs
require_once ("../../data/db.php");
require_once("../../other/authorization.php");

try {
    $player = $_SESSION['character'];
    if($player['weaponsid'] != NULL){
        $stmt = $pdo->prepare("SELECT w.name AS weapon_name, w.attack_bonus AS attack_bonus, w.health_bonus AS health_bonus, w.defense_bonus AS defense_bonus 
                        FROM characters c LEFT JOIN weapons w ON w.id = c.weaponsid WHERE c.id = ?");
        $stmt->execute([$_SESSION["char_id"]]);

        $current_weapon = $stmt->fetch();
    } else {
        $current_weapon = NULL;
    }
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
                            if($current_weapon != NULL){
                                $dmg = $player['attack'] + $current_weapon['attack_bonus'] - $enemy['defense'];
                            }else{
                                $dmg = $player['attack'] - $enemy['defense'];
                            }
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
                                if($current_weapon != NULL){
                                    $player['health'] = $player['health'] + 10 + $current_weapon['health_bonus'];
                                    $healed_amount = 10 + $current_weapon['health_bonus'];
                                }else{
                                    $player['health'] = $player['health'] + 10;
                                    $healed_amount = 10;
                                }
                                if($player['health'] > $player['maxhealth']){
                                    $player['health'] = $player['maxhealth'];
                                    $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' healed for '.$healed_amount.' </p>';
                                }
                                else{
                                    $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' healed for '.$healed_amount.'</p>';
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
                                $_SESSION['paralysis_counter'] = 3;
                                $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' paralized '.$enemy['name'].'</p>';
                                // Handle consumable action
                                // Perform consumable-related logic here
                                $player_action_done = true;
                                $player['consumable'] = $player['consumable'] - 1;
                                InteruptBoss();
                            }

                            break;

                        case 'consumable_2':
                            if($player['consumable']>0)
                            {
                                if ($current_weapon != NULL){
                                    $dmg = $player['attack'] + $current_weapon['health_bonus'];
                                }
                                else{
                                    $dmg = $player['attack'];
                                }
                                // Bomb that ignore defense
                                $dmg = $dmg*2;
                                $enemy['health'] = $enemy['health'] - $dmg;
                                $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' attacked '. $enemy['name'] .' for '.$dmg.'</p>';
                                $player_action_done = true;
                                $player['consumable'] = $player['consumable'] - 1;
                                InteruptBoss();
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
                    if(isset($_SESSION['boss_fight'])){
                        if($player['duel_won'] == 0){
                            $coin_reward = 50;
                            $exp_reward = 200;
                        }else{
                            $coin_reward = 1000;
                            $exp_reward = 10000;
                        }
                    }else{
                        $coin_reward = rand(1, $enemy['lvl']);
                        $exp_reward = $enemy['lvl'];
                    }
                    $_SESSION['battle_log'] .= '<p>' . $player['name'] . ' won against '. $enemy['name'] .'</p>';
                    $_SESSION['battle_log'] .= '<p>'.$player['name'].' got '.$exp_reward.' XP point(s) and '. $coin_reward. ' coin(s)</p>';
                    // XP and Coin rewards 
                    $player['exp'] += $exp_reward;
                    $player['coins'] += $coin_reward;
                    if(isset($_SESSION['boss_fight'])){
                        $player['duel_won']++;
                        // Update player's data in the database
                        $stmt = $pdo->prepare("UPDATE characters SET health = :health, potion = :potion, consumable = :consumable, exp = :exp, coins = :coins, duel_won = :duel_won WHERE id = :id");
                        $stmt->bindParam(':health', $player['health']);
                        $stmt->bindParam(':potion', $player['potion']);
                        $stmt->bindParam(':consumable', $player['consumable']);
                        $stmt->bindParam(':exp',$player['exp']);
                        $stmt->bindParam(':coins', $player['coins']);
                        $stmt->bindParam(":duel_won", $player['duel_won']);
                        $stmt->bindParam(':id', $player['id']);
                        $stmt->execute();
                        // Enemy defeated, handle victory
                        // Break the loop or perform necessary actions
                    }else{
                        // Update player's data in the database
                        $stmt = $pdo->prepare("UPDATE characters SET health = :health, potion = :potion, consumable = :consumable, exp = :exp, coins = :coins WHERE id = :id");
                        $stmt->bindParam(':health', $player['health']);
                        $stmt->bindParam(':potion', $player['potion']);
                        $stmt->bindParam(':consumable', $player['consumable']);
                        $stmt->bindParam(':exp',$player['exp']);
                        $stmt->bindParam(':coins', $player['coins']);
                        $stmt->bindParam(':id', $player['id']);
                        $stmt->execute();
                        // Enemy defeated, handle victory
                    }
                    // Update player's data in the database
                    $stmt = $pdo->prepare("UPDATE characters SET health = :health, potion = :potion, consumable = :consumable, exp = :exp, coins = :coins WHERE id = :id");
                    $stmt->bindParam(':health', $player['health']);
                    $stmt->bindParam(':potion', $player['potion']);
                    $stmt->bindParam(':consumable', $player['consumable']);
                    $stmt->bindParam(':exp',$player['exp']);
                    $stmt->bindParam(':coins', $player['coins']);
                    $stmt->bindParam(':id', $player['id']);
                    $stmt->execute();
                    // Enemy defeated, handle victory
                    // Break the loop or perform necessary actions

                } else if ($player_action_done) {
                    //Boss fight case
                    if(isset($_SESSION['boss_fight'])){
                        if ($_SESSION['paralysis_counter'] > 0)
                        {
                            $_SESSION['paralysis_counter'] = $_SESSION['paralysis_counter'] - 1;
                            $_SESSION['battle_log'] .= '<p>' . $enemy['name'] . ' did nothing </p>';
                        }
                        elseif ($enemy['health']<40 && $enemy['consumable']>0 && $player['duel_won']==0){
                            $enemy['health'] += 30;
                            $enemy['consumable']--;
                            $_SESSION['battle_log'] .='<p>'.$enemy['name'].' healed 30 hp</p>';
                        }elseif ($enemy['health']<200 && $enemy['consumable']>0 && $player['duel_won']>0){
                            $enemy['health'] += 150;
                            $enemy['consumable']--;
                            $_SESSION['battle_log'] .='<p>'.$enemy['name'].' healed 150 hp</p>';
                        }
                        else{
                            $dmg = $enemy['attack'];
                            $_SESSION['boss_charge_attack']--;
                            if($_SESSION['boss_charge_attack'] == 3) $_SESSION['battle_log'] .= '<p>' . $enemy['name'] . ' is preaparing strong attack</p>';
                            if($_SESSION['boss_charge_attack'] == 0){
                                $dmg = $dmg*5;
                                $_SESSION['boss_charge_attack'] = 6;
                            }
                            if($current_weapon!=NUll){
                                $dmg = $dmg - $player['defense'] - $current_weapon['defense_bonus'];
                            }else{
                                $dmg = $dmg - $player['defense'];
                            }
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
                    }else{
                        // Step 2: Enemy's Turn
                        // Enemy attacks the player
                        // Update player's health based on enemy's attack power
                        if ($_SESSION['paralysis_counter'] > 0)
                        {
                            $_SESSION['paralysis_counter'] = $_SESSION['paralysis_counter'] - 1;
                            $_SESSION['battle_log'] .= '<p>' . $enemy['name'] . ' did nothing </p>';
                        }
                        else{
                            if($current_weapon!=NUll){
                                $dmg = $enemy['attack'] - $player['defense'] - $current_weapon['defense_bonus'];
                            }else{
                                $dmg = $enemy['attack'] - $player['defense'];
                            }
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
        if(isset($_SESSION['boss_charge_attack']))
            if($_SESSION['boss_charge_attack']<4)
                $battleInfoHTML .= '<p><span class="charging">CHARGING</span></p>';
        if ($_SESSION['paralysis_counter']>0)
            $battleInfoHTML .= '<p><span class="paralized">PARALIZED</span></p>';
        $battleInfoHTML .= '<p>HP: ' . $enemy['health'] . ' / ' . $enemy['maxhealth'] . '</p>';
        // Add more enemy information as needed
        $battleInfoHTML .= '</div>';
        if ($player['health'] <= 0 || $enemy['health'] <= 0){
            if($player['health']>0)
            $battleInfoHTML .= '<div class="victory-box">You deafeted '.$enemy['name'].'</div>';
            else $battleInfoHTML .= '<div class="deafeted-box">You lost against '.$enemy['name'].'</div>';

        }
        $battleInfoHTML .= '</div>';

        if ($player['health'] <= 0 || $enemy['health'] <= 0)
        {
            // Inserting the buttons into the battle info HTML
            $battleInfoHTML .= '<div class="battle-buttons">';
            $battleInfoHTML .= '<button onclick="redirectToHome()">Go home</button>';
            if($player['health']>0){
                $battleInfoHTML .= '<button onclick="redirectToExplore()">Keep exploring</button>';
            }else{
                $battleInfoHTML .= '<button class="unclickable-button" onclick="redirectToExplore()">Keep exploring</button>';
            }

            $battleInfoHTML .= '</div>'; // Closing buttons div
        }
        else{
            // Inserting the buttons into the battle info HTML
            $battleInfoHTML .= '<button onclick="performAction(\'attack\')">Attack</button>';
            if($player['potion']>0){
                $battleInfoHTML .= '<button onclick="performAction(\'potion\')">Use Potion</button>';
            }else{
                $battleInfoHTML .= '<button class="unclickable-button" onclick="performAction(\'potion\')">Use Potion</button>';
            }
            if($player['consumable']>0){
                $battleInfoHTML .= '<button onclick="performAction(\'consumable\')">Paralisys Curse</button>';
                $battleInfoHTML .= '<button onclick="performAction(\'consumable_2\')">Fire Ball</button>';
            }else{
                $battleInfoHTML .= '<button class="unclickable-button" onclick="performAction(\'consumable\')">Paralisys Curse</button>';
                $battleInfoHTML .= '<button class="unclickable-button" onclick="performAction(\'consumable_2\')">Fire Ball</button>';
            }

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
function InteruptBoss(){
    if(isset($_SESSION['boss_fight'])){
        if($_SESSION['boss_charge_attack']<4){
            $_SESSION['boss_charge_attack']=6;
        }
    }
}

?>