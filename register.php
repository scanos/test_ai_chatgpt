<?php // register.php 
// OWASP-compliant database connection 
//$db_host = 'localhost'; $db_name = 'dogminding'; $db_user = 'root'; $db_pass = ''; 
require "../../pdo2.php";

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
// Validate and sanitize input 
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING); $password = filter_input(INPUT_POST, 'password', 
FILTER_SANITIZE_STRING); 
if (!$username || !$password) {die("Invalid input.");}
// Hash the password 
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); 
// Insert the user into the database 
try {
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->execute([':username' => $username, ':password' => $hashed_password]);
    echo "Registration successful. <a href='login.html'>Login here</a>";
} catch (PDOException $e) {
    if ($e->getCode() == 23000) { // Duplicate entry
        die("Username already exists. Please choose another.");
    } else {
        die("Error during registration: " . $e->getMessage());
    }
}
