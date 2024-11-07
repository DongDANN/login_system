<?php 
$email = $_POST["email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

date_default_timezone_set("Asia/Manila");
$expiry = date("Y-m-d H:i:s",time() + 60 * 30);

$mysqli = require "../../../config/connect.php";

$sql = "CALL update_reset_token(?, ?, ?)";

$stmt = $mysqli->prepare("CALL update_reset_token(?,?,?)");
$stmt->bind_param("sss", $_POST["email"], $token_hash, $expiry);

$stmt->execute();

if ($mysqli->affected_rows) {
    $mail = require "mailer.php";

    $mail->setFrom('r.sullano2003@gmail.com', 'WorkWave Password Reset');
    $mail->addReplyTo('noreply@example.com', 'No Reply');
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    Click <a href="http://localhost/login_system/resources/views/reset-password.php?token=$token">here</a> to reset your password.

    END;

    try {
        $mail->send();
    } catch (Exception $e) {
        die("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

header("Location: ../password-reset-success.php");
exit;