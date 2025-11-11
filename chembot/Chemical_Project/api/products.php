<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// DB Connection
$conn = new mysqli("localhost", "root", "", "chembot");

if ($conn->connect_errno) {
    echo json_encode(["status" => "error", "message" => "Failed to connect DB"]);
    exit;
}

// READ products
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $sql = "SELECT * FROM products ORDER BY id DESC";
    $result = $conn->query($sql);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $row['stock'] = (int)$row['stock'];
        $row['price'] = (int)$row['price'];

        // Auto status calculate backend
        $row['status'] = ($row['stock'] > 0) ? "Active" : "Out of Stock";
        
        $products[] = $row;
    }

    echo json_encode(["status" => "success", "products" => $products]);
}

// INSERT product
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    $name = $data["name"];
    $formula = $data["formula"];
    $stock = $data["stock"];
    $unit = $data["unit"];
    $price = $data["price"];

    $sql = "INSERT INTO products (name, formula, stock, unit, price)
            VALUES ('$name', '$formula', '$stock', '$unit', '$price')";

    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "Product added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

// UPDATE product
if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data["id"];
    $name = $data["name"];
    $formula = $data["formula"];
    $stock = $data["stock"];
    $unit = $data["unit"];
    $price = $data["price"];

    $sql = "UPDATE products SET 
            name='$name', formula='$formula', stock='$stock',
            unit='$unit', price='$price'
            WHERE id='$id'";

    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "Product updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

// DELETE product
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"];

    $sql = "DELETE FROM products WHERE id='$id'";

    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "Product deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

$conn->close();
?>
