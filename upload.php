

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');


$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0755, true);
}

if (isset($_FILES["art"]) && !empty($_FILES["art"]["name"])) {
    $fileName = basename($_FILES["art"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (in_array(strtolower($fileType), $allowedTypes)) {
        if (move_uploaded_file($_FILES["art"]["tmp_name"], $targetFilePath)) {
            echo json_encode([
                "status" => 1,
                "message" => "Upload successful!",
                "path" => $targetFilePath
            ]);
        } else {
            echo json_encode(["status" => 0, "message" => "Failed to move file."]);
        }
    } else {
        echo json_encode(["status" => 0, "message" => "Invalid file type."]);
    }
} else {
    echo json_encode(["status" => 0, "message" => "No file uploaded."]);
}
?>
