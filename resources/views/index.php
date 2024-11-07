<?php 
    session_start();

    if(isset($_SESSION['user_id'])){
        $mysqli = require "../../config/connect.php";

        $stmt = $mysqli->prepare("CALL get_user_by_id(?)");

        $stmt->bind_param("i", $_SESSION['user_id']);

        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $name = $user;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Homepage</h1>
    <?php if (isset($_SESSION["user_id"])): ?>
            <p>Hello <?= htmlspecialchars($user["name"])?></p>
    <?php else: ?>
        <p><a href="login.php">Log in</a> or <a href="signup.php">sign up</a></p>
    <?php endif; ?>
    <p><a href="components/logout.php">Log out</a></p>
</body>
</html>