<?php 
session_start(); 
// Database connection 
require "../../pdo2.php"; 
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if the user is logged in 
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}
$loggedInUser = $_SESSION['username']; 
// Fetch contacts for the logged-in user securely using prepared statements 

$sql = "SELECT  response_to_customer, message, created_at FROM contacts WHERE username = ?";
 $stmt = $conn->prepare($sql); 

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("s", $loggedInUser); $stmt->execute(); 
$result = $stmt->get_result(); ?> 
<!DOCTYPE html> <html lang="en"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #0073e6;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 1.2em;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            margin: 20px auto;
            max-width: 800px;
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #0073e6;
            color: white;
        }
        .logout-btn {
            margin-top: 20px;
            background-color: #0073e6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #005bb5;
        }
    </style> </head> <body>
    <nav>
        <div>
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($loggedInUser); ?></h1>
        <h2>Your Contact Submissions</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Message</th>
                        <th>Response</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                            <td><?php echo htmlspecialchars($row['response_to_customer']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No contact submissions found.</p>
        <?php endif; ?>
        <button class="logout-btn" onclick="location.href='logout.php'">Logout</button>
    </div> </body> </html> <?php $stmt->close(); $conn->close(); ?>
