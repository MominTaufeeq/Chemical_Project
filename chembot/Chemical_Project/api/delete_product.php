<?php
include "../config.php";
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];

$sql = "DELETE FROM products WHERE id=$id";

if($conn->query($sql)){
    echo json_encode(["message" => "Product Deleted"]);
} else {
    echo json_encode(["message" => "Error deleting product"]);
}
?>
