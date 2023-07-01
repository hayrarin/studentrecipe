<?php
$conn = mysqli_connect("localhost","root","","recipebook");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a random reset token
function generateResetToken() {
    // Implement your logic to generate a random token
    // Example: Generate a random 8-character alphanumeric token
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $token = '';
    for ($i = 0; $i < 8; $i++) {
        $index = mt_rand(0, strlen($characters) - 1);
        $token .= $characters[$index];
    }
    return $token;
}

// Function to send the reset token to the user
function sendResetTokenToUser($resetToken) {
    // Implement your logic to send the reset token to the user
    // Example: Send an email with the reset token
    $to = 'user@example.com';
    $subject = 'Password Reset';
    $message = 'Your password reset token is: ' . $resetToken;
    $headers = 'From: your_email@example.com' . "\r\n" .
        'Reply-To: your_email@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
}

// Step 1: Generate a reset token and update the user record
$resetToken = generateResetToken();
$expiryTime = date('Y-m-d H:i:s', strtotime('+1 hour'));
$email = 'user@example.com'; // Assuming the user's email for demonstration purposes

$updateQuery = "UPDATE `user` SET `reset_token` = '$resetToken', `reset_token_expiry` = '$expiryTime' WHERE `email` = '$email'";
$conn->query($updateQuery);

// Step 2: Send the reset token to the user
sendResetTokenToUser($resetToken);

// Step 3: Verify the reset token
if (isset($_POST['reset_token'])) {
    $resetToken = $_POST['reset_token'];

    $selectQuery = "SELECT * FROM `user` WHERE `reset_token` = '$resetToken' AND `reset_token_expiry` > NOW()";
    $result = $conn->query($selectQuery);

    if ($result->num_rows == 1) {
        // Reset token is valid and not expired
        // Proceed to password reset step
        if (isset($_POST['new_password'])) {
            $newPassword = $_POST['new_password'];
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $user = $result->fetch_assoc();
            $userId = $user['userID'];

            $updateQuery = "UPDATE `user` SET `password` = '$hashedPassword', `reset_token` = NULL, `reset_token_expiry` = NULL WHERE `userID` = $userId";
            $conn->query($updateQuery);

            // Password has been successfully reset
            // Redirect the user to a login page or display a success message
            echo "Password has been reset successfully.";
        } else {
            // Display the password reset form
            echo "
                <form action='' method='post'>
                    <input type='password' name='new_password' placeholder='New Password' required><br>
                    <input type='submit' value='Reset Password'>
                </form>
            ";
        }
    } else {
        // Invalid or expired reset token
        // Show an error message to the user
        echo "Invalid or expired reset token.";
    }
}

// Close the database connection
$conn->close();
?>
