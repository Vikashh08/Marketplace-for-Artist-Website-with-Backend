<?php
// Start the session first
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to index.php with cache prevention headers
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Location: index.php");
exit();
?>