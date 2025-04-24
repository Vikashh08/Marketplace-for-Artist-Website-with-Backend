<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once 'config.php'; // Contains DB connection

$data = json_decode(file_get_contents("php://input"), true);

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$category = $_POST['category'] ?? '';
$price = $_POST['price'] ?? 0;
$path = $_POST['imagePath'] ?? '';
$username = $_POST['username'] ?? 'anonymous';

if ($path && $title && $description && $category) {
    $stmt = $conn->prepare("INSERT INTO artworks (title, description, category, price, image_path, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $title, $description, $category, $price, $path, $username);

    if ($stmt->execute()) {
        echo json_encode(["status" => 1, "message" => "Artwork saved to DB"]);
    } else {
        echo json_encode(["status" => 0, "message" => "DB error: " . $stmt->error]);
    }
} else {
    echo json_encode(["status" => 0, "message" => "Missing fields"]);
}
?>
