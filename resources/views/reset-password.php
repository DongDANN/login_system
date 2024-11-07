<?php
date_default_timezone_set("Asia/Manila");

$_token = $_GET["token"];

$_token_hash = hash("sha256", $_token);

$mysqli = require "../../config/connect.php";

$stmt = $mysqli->prepare("CALL get_user_by_token_hash(?)");
$stmt->bind_param("s", $_token_hash);

$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token expired");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="../js/reset-validation.js" defer></script>
</head>
<body>
    <h1>Reset Password</h1>

    <form action="components/process-reset-password.php" method="post" id="reset">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_token) ?>">
        <div>
        <label for="password">New Password</label>
        <input type="password" name="password" id="password">
        </div>
        <div>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
        </div>
        <button>Reset Password</button>
    <p><a href="login.php">Log in</a></p>
    </form>
</body>
</html>