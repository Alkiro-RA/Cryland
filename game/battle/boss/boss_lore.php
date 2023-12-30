<?php
require_once("../../../other/authorization.php");

$lore = $_SESSION['character']['duel_won'];
switch($lore) {
    case 0: {
        echo "You are standing in front of the goblin villiage. </br>
        If you challange the chieftain and defeat him,</br>
        this goblin village will cease harrasing your town.";
        break;
    }
    case 1: {
        echo "You've approached giant, grim-looking cave. </br>
        The outside walls are all scribbled in elephants. </br>
        You can hear unsettling whispers coming from the inside: </br>
        \"alwayssss hasssh passwordssss\" - could you gather..

        ";
        break;
    }
    default: {
        header("Location: ../../index.php");
        break;
    }
}