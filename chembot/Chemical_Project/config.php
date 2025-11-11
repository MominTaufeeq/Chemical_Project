<?php
$host = "localhost";
$user = "root";        // your mysql username
$pass = "";            // your mysql password
$db   = "chembot";     // your database name

$conn = new mysqli($host, $user, $pass, $db);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}
?>


