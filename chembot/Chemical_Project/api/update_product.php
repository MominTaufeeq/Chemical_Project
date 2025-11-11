<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$conn = new mysqli("localhost", "root", "", "chembot");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$name = $data['name'] ?? null;
$formula = $data['formula'] ?? null;
$stock = $data['stock'] ?? null;
$unit = $data['unit'] ?? null;
$price = $data['price'] ?? null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "ID missing"]);
    exit;
}

$sql = "UPDATE products SET
        name = '$name',
        formula = '$formula',
        stock = '$stock',
        unit = '$unit',
        price = '$price'
        WHERE id = $id";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Product updated"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
?>
