<?php
session_start();
include 'config.php';

try {
    $stmt = $conn->query("SELECT 1");
    echo "Database connection successful!";
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}