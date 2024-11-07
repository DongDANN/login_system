<?php

  $is_invalid = false;

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require "../../config/connect.php";

    $stmt = $mysqli->prepare("CALL get_user_by_email(?)");

    $stmt->bind_param("s", $_POST["email"]);

    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
      if (password_verify($_POST["password"], $user["password_hash"])){
        session_start();
        session_regenerate_id();
        $_SESSION["user_id"] = $user["id"];
        header("Location: index.php");
        exit;
      }
    }
    
    $is_invalid = true;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Log In</h1>

    <?php if ($is_invalid): ?>
      <em>Invalid login</em>
    <?php endif; ?>

    <form method="post">
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button>Log In</button>
    </form>

    <a href="forgot-password.php">Forgot Password</a>
</body>
</html>
