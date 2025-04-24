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
    <title><?= htmlspecialchars($user['username']) ?>'s Profile - कला घर</title>
    <link rel="stylesheet" href="newprofile.css">
</head>
<body>
    <header>
        <!-- Same header as index.php -->
    </header>

    <div class="profile-container">
        <div class="profile-sidebar">
            <div class="profile-card">
                <img src="default-avatar.jpg" alt="Profile Picture" class="profile-avatar">
                <h2><?= htmlspecialchars($user['username']) ?></h2>
                <p class="profile-email"><?= htmlspecialchars($user['email']) ?></p>
                <p class="profile-member-since">Member since: <?= date('F Y', strtotime($user['created_at'])) ?></p>
                <nav class="profile-nav">
                    <a href="#my-artworks" class="active">My Artworks</a>
                    <a href="#settings">Account Settings</a>
                    <a href="index.php">Back to Gallery</a>
                </nav>
            </div>
        </div>

        <div class="profile-content">
            <section id="my-artworks">
                <h3>My Uploaded Artworks</h3>
                <div class="art-grid">
                    <!-- PHP code to fetch user's artworks -->
                    <?php
                    $artStmt = $conn->prepare("SELECT * FROM artworks WHERE user_id = ?");
                    $artStmt->execute([$_SESSION['user_id']]);
                    while($art = $artStmt->fetch()):
                    ?>
                    <div class="art-card">
                        <img src="uploads/<?= htmlspecialchars($art['image_path']) ?>" alt="<?= htmlspecialchars($art['title']) ?>">
                        <div class="art-details">
                            <h4><?= htmlspecialchars($art['title']) ?></h4>
                            <p><?= htmlspecialchars($art['description']) ?></p>
                            <span class="price">₹<?= number_format($art['price'], 2) ?></span>
                            <div class="art-actions">
                                <button class="edit-btn">Edit</button>
                                <button class="delete-btn">Delete</button>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <section id="upload-art">
                <h3>Upload New Artwork</h3>
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Artwork Title</label>
                        <input type="text" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Price (₹)</label>
                        <input type="number" name="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Artwork Image</label>
                        <input type="file" name="art_image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Artwork</button>
                </form>
            </section>
        </div>
    </div>

    <footer>
        <!-- Same footer as index.php -->
    </footer>
</body>
</html>