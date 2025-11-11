<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include("../config.php");

// ✅ Get raw POST body safely
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$email = $data["email"];
$password = $data["password"];

// ✅ Prepared statement (Security)
$stmt = $conn->prepare("SELECT * FROM admins WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        echo json_encode(["status" => "success", "token" => "server-generated-token"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid password"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}

$conn->close();
?>
