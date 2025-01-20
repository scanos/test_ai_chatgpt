1. HTML Login Form

    A responsive login form styled with CSS.
    Fields for username and password.
    Form submission via POST to login.php.

2. PHP Login Script

    Validates user credentials against the users table.
    Starts a session on successful login and redirects to a dashboard.php.
    Sanitizes inputs and uses password_verify for secure password comparison.

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP );

Hashing Passwords for User Registration 
When adding users to the users table, ensure the passwords are hashed: 
$password = password_hash('user_password', PASSWORD_BCRYPT);

