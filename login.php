<?php
session_start();  
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: login.html?error=invalidemail");
        exit();
    }

    // Find user by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['created_at'] = $user['created_at'];
            
            // Redirect to index
            header("Location: index.php");
            exit();
        }
    }
    
    // If authentication fails
    header("Location: login.html?error=invalidcredentials");
    exit();
}
?>
