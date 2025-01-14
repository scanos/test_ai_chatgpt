<?php
// save_contact.php

// OWASP-compliant database connection
$db_host = 'localhost';
$db_name = 'dogminding';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Validate and sanitize input
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

if (!$name || !$email || !$message) {
    die("Invalid input.");
}

// Save data to database
try {
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)");
    $stmt->execute([':name' => $name, ':email' => $email, ':message' => $message]);

    // Send email notification
    $to = 'admin@dogminding.com';
    $subject = "New Contact Form Submission";
    $email_message = "Name: $name\nEmail: $email\nMessage: $message";
    $headers = "From: no-reply@dogminding.com";

    if (mail($to, $subject, $email_message, $headers)) {
        echo "Contact form submitted successfully.";
    } else {
        echo "Form submitted, but email notification failed.";
    }
} catch (Exception $e) {
    die("Error saving data: " . $e->getMessage());
}
