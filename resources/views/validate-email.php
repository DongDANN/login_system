<?php 

$mysqli = require "../../config/connect.php";

$stmt = $mysqli->prepare("CALL get_user_by_email(?)");

$stmt->bind_param("s", $_GET["email"]);

$stmt->execute();

$result = $stmt->get_result();
$is_available = $result->num_rows === 0;

header("Content-Type: application/json");

echo json_encode(["available" => $is_available]);