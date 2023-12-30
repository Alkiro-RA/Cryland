<?php
require_once('../other/authorization.php');
// Variable setup
$boss_counter = $_SESSION['character']['duel_won'];
$level = $_SESSION['character']['level'];

// First duel
if ($boss_counter == 0 && $level > 1 ) {
    show_boss_button("Goblin King");
}
// Second duel
else if ($boss_counter == 1 && $level > 9 ) {
    show_boss_button("Smoczex Płaczex");
}
function show_boss_button($boss_name) {
    echo "<button onclick=\"window.location.href='battle/boss/index.php'\">
        Challange " . $boss_name . "</button>";
}
