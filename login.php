<?php
// login.php

session_start();
require "../../pdo2.php";
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
// Validate and sanitize input 
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING); 
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); 
if (!$username || !$password) {
    die("Invalid input.");
}
// Fetch user data from database
 try {
    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        // Password matches, set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<div class='error'>Invalid username or password.</div>";
    }
} catch (Exception $e) {
    die("Error processing login: " . $e->getMessage());
}
?>
