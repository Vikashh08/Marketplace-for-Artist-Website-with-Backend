<?php
session_start();
include 'config.php';

// Redirect to login if not authenticated (optional)
// if(!isset($_SESSION['user_id'])) {
//     header("Location: login.html");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>कला घर- Buy & Sell Art</title>
  <link rel="stylesheet" href="style.css" />
  <script src="script.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <!-- Header -->
  <header>
    <div class="container nav">
        <!-- Profile Section (Visible when logged in) -->
  <?php if(isset($_SESSION['user_id'])): ?>
          <h3>Welcome Back, <?= htmlspecialchars($_SESSION['username']) ?>!</h3>
  <?php endif; ?>
      <img id="logo1" src="_Pngtree_face_line_art_logo_with_6847216-removebg-preview.png" alt="">

      <h1 class="logo">कला घर</h1>
      <div class="cart-container">
        <button id="openCart">🛒 Cart (<span id="cartCount">0</span>)</button>
      </div>
      
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="explore.html">Explore</a></li>
          <li><a href="upload.html">Upload Art</a></li>
          <li><a href="About.html">About</a></li>
          <li><a href="Contact.html">Contact</a></li>
        </ul>
      </nav>
      <div class="auth-buttons">
  <?php if(isset($_SESSION['user_id'])): ?>
    <div class="profile-menu">
      <a href="profile.php" class="btn">My Profile</a>
      <a href="logout.php" class="btn btn-primary">Logout</a>
    </div>
  <?php else: ?>
    <a href="Login.html" class="btn">Login</a>
    <a href="register.html" class="btn btn-primary">Sign Up</a>
  <?php endif; ?>
</div>
  </header>

  <!-- Hero Section -->
  <section class="hero" style="background-image: url('diogo-nunes-Wa9ilX9XYOI-unsplash.jpg'); background-repeat: no-repeat; background-size: cover; height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center; color: white; position: relative;">
    <div class="hero-text">
      <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Discover, Buy & Sell Authentic Art</h2>
      <p style="font-size: 1.2rem; margin-bottom: 1.5rem;">Connecting artists and collectors across the globe.</p>
      <a href="explore.html" style="display: inline-block; padding: 0.75rem 1.5rem; font-size: 1rem; text-decoration: none; border-radius: 5px; background-color: #007bff; color: white; transition: background-color 0.3s ease;">Start Exploring</a>
    </div>
  </section>

<!-- Featured Art -->
<section class="featured">
    <h3>Featured Artworks</h3>
    <div class="art-grid">
      <div class="art-card">
        <img src="birmingham-museums-trust-G1Z0cIMYHVM-unsplash.jpg" />
        <h4>Sunset Bliss</h4>
        <p>by Anya Sharma</p>
        <span>$120</span>
        <button class="add-cart">Add to Cart</button>
      </div>
      <div class="art-card">
        <img src="europeana-6c43FgRt0Dw-unsplash.jpg" alt="City Art" />
        <h4>Urban Jungle</h4>
        <p>by Vikrant Rao</p>
        <span>$95</span>
        <button class="add-cart">Add to Cart</button>
      </div>
      <div class="art-card">
        <img src="birmingham-museums-trust-v15kmerLWcA-unsplash.jpg" alt="Watercolor Landscape" />
        <h4>Tranquil Waters</h4>
        <p>by Mira Das</p>
        <span>$145</span>
        <button class="add-cart">Add to Cart</button>
      </div>
      <div class="art-card">
        <img src="yaopey-yong-oDKyhEjOBfc-unsplash.jpg" alt="Digital Portrait" />
        <h4>Virtual Muse</h4>
        <p>by Karan Joshi</p>
        <span>$180</span>
        <button class="add-cart">Add to Cart</button>
      </div>
      <div class="art-card">
        <img src="birmingham-museums-trust-Ct2Q6q29xds-unsplash.jpg" alt="Mixed Media Art" />
        <h4>Fragmented Dreams</h4>
        <p>by Sana Iqbal</p>
        <span>$130</span>
        <button class="add-cart">Add to Cart</button>
      </div>
      <div class="art-card">
        <img src="birmingham-museums-trust-Kv1hYl9LlxU-unsplash.jpg" alt="Color Explosion" />
        <h4>Chroma Burst</h4>
        <p>by Leo Fernandes</p>
        <span>$160</span>
        <button class="add-cart">Add to Cart</button>
      </div>
      <div class="art-card">
        <img src="birmingham-museums-trust-mWsReJ7bWHQ-unsplash.jpg" alt="Color Explosion" />
        <h4>Chroma Burst</h4>
        <p>by Leo Fernandes</p>
        <span>$160</span>
        <button class="add-cart">Add to Cart</button>
      </div>
    </div>
    <a href="#" class="btn">View All Artworks</a>
  </section>
  
  

  <!-- Footer -->
  <footer>
    <div class="container footer-content">
      <p>&copy; 2025 ArtistryHub. All rights reserved.</p>
      <div class="socials">
        <a href="#">Instagram</a>
        <a href="#">Twitter</a>
        <a href="#">Facebook</a>
      </div>
    </div>
  </footer>
  <!-- Cart Modal -->
<div id="cartModal" class="cart-modal">
    <div class="cart-content">
      <span id="closeCart">&times;</span>
      <h3>Your Cart</h3>
      <ul id="cartItems"></ul>
      <p id="cartTotal"></p>
    </div>
  </div>
  
<script src="script.js"></script>

</body>
</html>
