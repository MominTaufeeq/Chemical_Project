<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include "../config.php";
// Read raw JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check if data is received
if (!$data) {
    echo json_encode(["success" => false, "message" => "No data received"]);
    exit;
}

$name = $data['name'];
$formula = $data['formula'];
$stock = $data['stock'];
$unit = $data['unit'];
$price = $data['price'];

$query = "INSERT INTO products (name, formula, stock, unit, price)
VALUES ('$name', '$formula', '$stock', '$unit', '$price')";

if ($conn->query($query)) {
    echo json_encode(["success" => true, "message" => "Product added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "DB Error: " . $conn->error]);
}
?>
