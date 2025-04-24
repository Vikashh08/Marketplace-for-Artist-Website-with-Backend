
<?php
error_reporting(0);
header('Content-Type: application/json');

require 'config.php';

try {
    // Get JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    
    if ($data === null) {
        throw new Exception('Invalid JSON input');
    }

    // Validate required fields
    $required = ['name', 'email', 'message'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Sanitize inputs
    $name = htmlspecialchars($data['name']);
    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($data['message']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }

    // Database insertion
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);

    echo json_encode(['success' => true]);
    exit;

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit;
}
header('Content-Type: application/json');
require 'config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

try {
    // Get form data
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validate input
    if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
        throw new Exception('All fields are required');
    }

    $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($data['message'], FILTER_SANITIZE_STRING);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }

    // Store in database
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);

    // Send email
    $to = 'admin@yourdomain.com'; // Replace with your email
    $subject = 'New Contact Form Submission';
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $email_body = "
        <h2>New Contact Form Submission</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Message:</strong></p>
        <p>{$message}</p>
    ";

    $mail_sent = mail($to, $subject, $email_body, $headers);

    if (!$mail_sent) {
        throw new Exception('Failed to send email');
    }

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}