<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$dbname = "workwave_db";
$username = "root";
$password = "";

try {
    
$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die ("Connection error: " . $mysqli->connect_error);
}

return $mysqli;

} catch (Exception $e) {
    die("Connection error: " . $e->getMessage());
}