<?php
$error_code = 0;

try {
// Db configuration
require_once("db.php");

    // Retrive data
    $nick = $_POST["nickname"];
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
    $sql = "SELECT * FROM Users WHERE nickname = :nick";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nick", $nick); 
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $error_code = "3";
        throw new Exception();
    }

    // Create password hash 
    $pass1 = password_hash($pass1, PASSWORD_DEFAULT);

    // Prep and execute SQL query
    $sql = "INSERT INTO Users 
    (nickname, email, password) VALUES
    (:nick, :email, :pass)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nick", $nick);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pass", $pass1);

    // Create account
    if($stmt->execute()) {
        echo "Pomyślnie zarejestrowano użytkownika.";
    } else {
        $error_code = "1";
        throw new Exception();
    }
} 
catch (Exception $e) {
    echo get_error_msg($error_code);
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
            $message = "Nie udało się dodać użytkownika."; break;
        case 2:
            $message = "Podane hasła nie są identyczne."; break;
        case 3:
            $message = "Podana nazwa użytkownika / adres e-mail są już używane przez innego użytkownika."; break;
        default:
            $message = "Nieznany błąd."; break;
    }
    return $message;
}
?>
