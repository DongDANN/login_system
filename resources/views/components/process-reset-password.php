<?php
date_default_timezone_set("Asia/Manila");

$_token = $_POST["token"];

$_token_hash = hash("sha256", $_token);

$mysqli = require "../../../config/connect.php";

$stmt = $mysqli->prepare("CALL get_user_by_token_hash(?)");
$stmt->bind_param("s", $_token_hash);

$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->free_result();
$mysqli->next_result();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Password does not match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("CALL reset_password(?,?)");
$stmt->bind_param("ss", $password_hash, $user["id"]);

$stmt->execute();

header("Location: ../login.php");

