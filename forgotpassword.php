<?php
require 'connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

// SMTP configuration
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server address
$mail->SMTPAuth = true;
$mail->Username = 'ayraeyra@gmail.com'; // Replace with your SMTP username or email address
$mail->Password = 'ZuhayraN@sriN30'; // Replace with your SMTP password
$mail->SMTPSecure = 'TLS';
$mail->Port = 587;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the email address entered in the form
    $email = $_POST["email"];

    // Validate the email address
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Generate a random password reset token
        $token = bin2hex(random_bytes(32));

        // Store the token and email in the database for the user
        // ... (Database code here)

        // Set email content
        $mail->setFrom('ayraeyra@gmail.com', 'Zuhayra Nasrin Binti Zul Hisham'); // Replace with your email address and name
        $mail->addAddress($email); // Recipient's email address
        $mail->Subject = 'Password Reset';
        $mail->Body = 'Please click the following link to reset your password: https://example.com/reset-password.php?token=' . $token;

        // Send the email
        try {
            $mail->send();
            echo 'An email with instructions to reset your password has been sent to your email address.';
        } catch (Exception $e) {
            echo 'Failed to send the password reset email. Error: ' . $mail->ErrorInfo;
        }
    } else {
        echo 'Invalid email address.';
    }
}
?>

<!-- HTML form for the "Forgot Password" page -->
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="email" name="email" placeholder="Enter your email address" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
