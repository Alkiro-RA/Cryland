<?php
session_start();
try {
    // Db configuration
    require_once("data/db.php");

    // Check for missing data
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            throw new Exception();
        }
    }
    // Retrive data
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Prepare SQL statement
    $sql = "SELECT * FROM Users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $email);

    // Execute and fetch results
    if (!$stmt->execute()) {
        throw new Exception();
    }
    $result = $stmt->fetch();

    // Match password
        if (password_verify($pass, $result["password"])) {
            // Create new session ID for user
            session_start();
            $_SESSION["logged_in"] = true;
            $_SESSION["user_id"] = $result["id"];
            $_SESSION["char_id"] = $result["charactersid"];
            $_SESSION["role_id"] = $result["roleid"];
            header("Location: account/index.php");
        } else {
            $_SESSION["error"] = "Wrong password or email";
            header("Location: index.php");
        }
}
 catch (Exception $e) {
     $_SESSION["error"] = array($e->getMessage());
     header("Location: index.php");
}
?>