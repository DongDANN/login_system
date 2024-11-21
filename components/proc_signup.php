<?php
 $mysqli = require "../config/connect.php";

 $activation_token = bin2hex(random_bytes(16));
 $activation_token_hash = hash("sha256", $activation_token);

 $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

 $stmt= $mysqli->prepare("INSERT INTO users (email, phone, name, password_hash, activation_token_hash) VALUES (?, ?, ?, ?, ?)");
 $stmt->bind_param("sssss", $_POST["email"], $_POST["phone"], $_POST["name"], $password_hash,  $activation_token_hash);

 try {
    $stmt->execute();
    
    header("Location: ../login.php");
    exit;
} catch (mysqli_sql_exception $e) {
    die($e->getMessage());
}