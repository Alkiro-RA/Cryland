<?php
require_once("../../../other/authorization.php");
require_once("../../../data/db.php");

$sql = "SELECT * FROM Bosses WHERE id = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$boss = $stmt->fetch();

$_SESSION['paralysis_counter'] = 0;
$_SESSION['enemy'] = $boss;
$_SESSION['boss_fight'] = true;
$_SESSION['boss_charge_attack'] = 10;
$_SESSION['battle_log'] = '<p>Begin of battle with: ' . $boss['name'] . '</p>';
header("Location: ../index.php");