<?php
require_once("../../../other/authorization.php");
require_once("../../../data/db.php");

$sql = "SELECT * FROM Bosses WHERE id = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$boss = $stmt->fetch();

$_SESSION['enemy'] = $boss;
$_SESSION['boss_fight'] = true;
$_SESSION['boss_charge_attack'] = 10;
header("Location: ../index.php");