<?php
require_once 'config.php';

$username = $_GET['username'] ?? 'vikash';

$sql = "SELECT * FROM artworks WHERE uploaded_by = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$artworks = [];
while ($row = $result->fetch_assoc()) {
    $artworks[] = $row;
}
echo json_encode($artworks);
?>
