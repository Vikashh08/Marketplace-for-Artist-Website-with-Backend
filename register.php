
<?php
session_start();  // Add this at the top
include 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate inputs
    if(empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: register.html?error=emptyfields");
        exit();
    }

    if($password !== $confirm_password) {
        header("Location: register.html?error=passwordmismatch");
        exit();
    }

    // Check existing email
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if($stmt->rowCount() > 0) {
        header("Location: register.html?error=emailtaken");
        exit();
    }

    // Hash password and create user
    try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password]);
        header("Location: login.html?registration=success");
    } catch(PDOException $e) {
        header("Location: register.html?error=dberror");
    }
    exit();
}
?>