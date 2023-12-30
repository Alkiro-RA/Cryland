<?php
require_once("../../../other/authorization.php");
require_once("../../../data/db.php");

$boss_id = $_SESSION['character']['duel_won'] + 1;
$sql = "SELECT * FROM Bosses WHERE id = :boss_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":boss_id", $boss_id);
$stmt->execute();
$boss = $stmt->fetch();

$_SESSION['paralysis_counter'] = 0;
$_SESSION['enemy'] = $boss;
$_SESSION['boss_fight'] = true;
$_SESSION['boss_charge_attack'] = 10;
$_SESSION['battle_log'] = '<p>Begin of battle with: ' . $boss['name'] . '</p>';
header("Location: ../index.php");