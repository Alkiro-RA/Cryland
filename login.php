<?php
try {
    // Db configuration
    require_once("db.php");


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
    $result = $stmt->fetchAll();

    echo $_SESSION["user_id"];

    // Match password
    foreach (($result) as $row) {
        if (password_verify($pass, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            echo "Zalogowano pomyślnie.";
            break;
        }
    }
} catch (Exception) {
    // nic nie robie
    echo "błąd;"
}
?>