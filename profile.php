<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Get user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile - कला घर</title>
  <link rel="stylesheet" href="profile.css">
</head>
<body>
  <!-- Reuse your header from index.php -->
  <header>
    <div class="container nav">
      <img id="logo1"  alt="">
      <h1 class="logo">कला घर</h1>
      <div class="auth-buttons">
        <div class="profile-menu">
          <a href="profile.php" class="btn active">My Profile</a>
          <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Profile Content -->
  <section class="profile-container">
    <div class="profile-card">
      <div class="profile-header">
        <h2>My Account</h2>
        <p>Manage your art and profile settings</p>
      </div>
      
      <div class="profile-content">
        <div class="profile-details">
          <h3>Personal Information</h3>
          <div class="detail-item">
            <span>Username:</span>
            <p><?= htmlspecialchars($user['username']) ?></p>
          </div>
          <div class="detail-item">
            <span>Email:</span>
            <p><?= htmlspecialchars($user['email']) ?></p>
          </div>
          <div class="detail-item">
            <span>Member Since:</span>
            <p><?= date('F Y', strtotime($user['created_at'])) ?></p>
          </div>
        </div>

        <div class="profile-actions">
          <a href="upload.html" class="btn btn-primary">Upload New Art</a>
          <a href="index.php" class="btn">Back to Gallery</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Reuse your footer from index.php -->
</body>
</html>