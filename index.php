<?php
session_start();
if(isset($_SESSION['user_id'])){
    $mysqli = require "config/connect.php";

    $stmt= $mysqli->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Demo</title>
</head>
<body>
    <h1>API Demo - Geolocation</h1>
    <?php if (isset($_SESSION["user_id"])): ?>
            <p>Hello <?= htmlspecialchars($user["name"])?></p>
            <p><a href="components/proc_logout.php">Log out</a></p>
    <?php else: ?>
        <p><a href="login.php">Log in</a> or <a href="signup.php">sign up</a></p>
    <?php endif; ?>
</body>
</html>