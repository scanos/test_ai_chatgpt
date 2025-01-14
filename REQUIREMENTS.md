1. Approach - use co-pilot to generate code which needs to be added to a github repository

2. requirements added
1. Create a website for a dogminding site with a contact form.
2. Make the website responsive and color scheme blue and white. 
3. Create owasp compliant php files to save the contact form results to a database.
4. Add a testimonials section and a location section. 
5. Add functionality to send an email from the contact form to indicate that the form data has been saved.
6. Add a menu bar.
7. Provide a create table mysql statement for all relevant tables.
8. Provide recommendations for sending emails from the server
9. I'd like to integrate PHPMailer or need help setting up the database!

Note, co-pilot detected vulnerabilities from the sources that it was using and removed them.However, I had
to harden the php files and both were just wrong so I had to rewrite them.

3. Files generated from CHATGPT and added/pasted  into github repository
4. 
index.html
save_contact.php

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

it advised how to create the table
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each contact entry
    name VARCHAR(255) NOT NULL,        -- Name of the contact person
    email VARCHAR(255) NOT NULL,       -- Email address of the contact person
    message TEXT NOT NULL,             -- Message content from the contact form
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of when the entry was created
);

Recommendations for Sending Emails

    Use an SMTP Server: Configure a reliable SMTP service like Gmail, SendGrid, or your hosting provider for better email delivery.
    Avoid Using mail(): Instead, use libraries like PHPMailer or SwiftMailer for more robust email handling.
    Set SPF/DKIM/DMARC: Ensure your domain has proper email authentication records to prevent emails from being flagged as spam.


Integrating PHPMailer for Email Notifications

PHPMailer provides a more robust and reliable way to send emails. Here's how you can integrate it into your project:
1. Install PHPMailer

Use Composer to install PHPMailer:
bash
composer require phpmailer/phpmailer

If you don't have Composer installed, you can download PHPMailer manually from PHPMailer's GitHub page.

2. Configure PHPMailer
Below is the updated PHP script using PHPMailer:

<?php
// save_contact.php

require 'vendor/autoload.php'; // Autoload PHPMailer classes

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com'; // Replace with your SMTP username
        $mail->Password = 'your_password'; // Replace with your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('no-reply@dogminding.com', 'DogMinding Service');
        $mail->addAddress('admin@dogminding.com', 'Admin'); // Replace with the recipient email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "<p><strong>Name:</strong> $name</p>
                       <p><strong>Email:</strong> $email</p>
                       <p><strong>Message:</strong><br>$message</p>";

        $mail->send();
        echo "Contact form submitted successfully.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} catch (Exception $e) {
    die("Error saving data: " . $e->getMessage());
}




