<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "chembot");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB Connection Failed"]);
    exit;
}

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode(["success" => true, "data" => $products]);
?>
