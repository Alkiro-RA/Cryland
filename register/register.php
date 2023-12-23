<?php
session_start();
$error_code = 0;

try {
    // Db configuration
    require_once("../data/db.php");

    // Retrive data
    $name = $_POST["char_name"];
    $email = $_POST["email"];
    $pass1 = $_POST["pass1"];
    $pass2 = $_POST["pass2"];

    // Check for missing data
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $error_code = "1";
            throw new Exception();
        }
    }

    // Check if passwords match
    if ($pass1 != $pass2) {
        $error_code = "2";
        throw new Exception();
    }

    // Look for dubleton
    $sql = "SELECT * FROM Users WHERE email = :email OR nickname = :nickname";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":nickname", $name);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $error_code = "3";
        throw new Exception();
    }

    // Create password hash 
    $pass1 = password_hash($pass1, PASSWORD_DEFAULT);

    // Prep new character
    $sql = "INSERT INTO Characters
    (name, level, exp, weaponsid, armorsid, attack, health, maxhealth, defense, potion, consumable, consumable_2) VALUES
    (:char_name, 1, 0, NULL, NULL, 5, 5, 5, 5, 1, 1, 1)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":char_name", $name);

    // Create character
    if ($stmt->execute()) {
        // Prep SQL to get character's ID
        $sql = "SELECT * FROM Characters WHERE name = :name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->execute();
    } else {
        $error_code = "1";
        throw new Exception();
    }

    // Fetch character's ID
    $result = $stmt->fetch();
    $char_id = $result['id'];

    // Prep and execute SQL query
    $sql = "INSERT INTO Users 
    (charactersid, nickname, email, password) VALUES
    (:charactersid, :char_name, :email, :pass)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":charactersid", $char_id);
    $stmt->bindParam(":char_name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pass", $pass1);


    // Create account
    if ($stmt->execute()) {
        echo "udało się";
        header("Location: ../index.php");
    } else {
        $error_code = "0";
        throw new Exception();
    }
} catch (Exception $e) {
    $_SESSION['error'] = get_error_msg($error_code);
    header("Location: index.php");
}

function verify_email($email)
{
    if ($email == "") {
        return false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

function get_error_msg($error_code)
{
    $message = '';
    switch ($error_code) {
        case 1:
            $message = "Unable to add user";
            break;
        case 2:
            $message = "Passwords didn't match";
            break;
        case 3:
            $message = "Nickname / e-mail are taken";
            break;
        default:
            $message = "Error";
            break;
    }
    return $message;
}
