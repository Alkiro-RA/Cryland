<?php
require_once("../../other/authorization.php");
require_once("../../data/db.php");
$error_code = 0;

try {
    // Validate empty inputs
    if (empty($_POST['item'])) {
        $error_code = 1;
        throw new Exception();
    }
    // Recive data
    $item = $_POST['item'];
    // Prepare SQL statement
    $sql = "SELECT * FROM Weapons WHERE name = :name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":name", $item);
    // Search for item
    if (!$stmt->execute()) {
        $error_code = 4;
        throw new Exception();
    }
    $item = $stmt->fetch();
    // Check if item is empty
    if (empty($item)) {
        $error_code = 2;
        throw new Exception();
    }
    $character = $_SESSION['character'];
    // Check if enough coins
    if ($character['coins'] < $item['price']) {
        $error_code = 3;
        throw new Exception();
    }
    // Substract coins from character
    $character['coins'] -= $item['price'];
    $_SESSION['character']['coins'] -= $item['price'];
    // Prepare SQL statement
    $sql = "UPDATE Characters SET coins = :coins WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":coins", $character['coins']);
    $stmt->bindParam(":id", $character['id']);
    // Save changes to database
    if (!$stmt->execute()) {
        $error_code = 4;
        throw new Exception();
    }
    // Redirect to shop
    header("Location: index.php");
} catch (Exception $e) {
    $_SESSION['error'] = get_error_msg($error_code);
    header("Location: index.php");
}

function get_error_msg($error_code)
{
    $message = '';
    switch ($error_code) {
        case 1: {
                $message = "No input given.";
                break;
            }
        case 2: {
                $message = "Store dosen't have such thing.";
                break;
            }
        case 3: {
                $message = "Not enough coins.";
                break;
            }
        case 4: {
                $message = "Database error.";
            }
        default: {
                $message =  "Unknown error.";
                break;
            }
    }
    return $message;
}
