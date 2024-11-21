<?php
$mysqli = require "../config/connect.php";

$phone = $_POST['phone'];
$otp = random_int(100000, 999999);

$stmt = $mysqli->prepare("UPDATE users SET otp = ? WHERE phone = ?");
$stmt->bind_param("ss", $otp, $phone);
$stmt->execute();
$stmt->close();

header("Location: ../otp_validation.php");
exit();
