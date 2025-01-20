<?php // save_contact.php // OWASP-compliant database connection 
require "../../pdo2.php";

//try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
//} catch (PDOException $e) {
//    die("Database connection failed: " . $e->getMessage());
//}
// Validate and sanitize input 
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING); 
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);


//chatgpt put this is the wrong place so commented
 //if ( !$name || !$email || !$message || !$username) {die("Invalid input.");}
//
// Save data to database 
//try {
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message,username) VALUES (:name, :email, :message, :username)");
    $stmt->execute([':name' => $name, ':email' => $email, ':message' => $message,':username' => $username ]);
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
//} 

//catch (Exception $e) {
//    die("Error saving data: " . $e->getMessage());
//}


?>
<!DOCTYPE html>
<html lang="en">
<head> <meta http-equiv='Refresh' content='0;

<?php echo " url=index.php' /></head>";
//$referringpage = $_SERVER['HTTP_REFERER'];


echo "<script> alert('Thanks ".$username."! we will reply soon.');</script>";
?>

