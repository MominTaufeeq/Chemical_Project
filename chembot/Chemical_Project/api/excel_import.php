<?php
include("../config.php");

$data = json_decode(file_get_contents("php://input"), true);

foreach ($data as $row) {
    $name = $row["name"];
    $price = $row["price"];
    $stock = $row["stock"];
    $description = $row["description"];
    $status = $stock > 0 ? "In Stock" : "Out Of Stock";

    $conn->query("INSERT INTO products (name,description,price,stock,status)
    VALUES ('$name','$description','$price','$stock','$status')");
}

echo json_encode(["status" => "success", "message" => "Excel Data Imported"]);
?>
