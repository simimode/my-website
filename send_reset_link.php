<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection (You'll need a database to store users and reset tokens)
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'your_database';
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Get the email from POST data
    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour

        // Store the token in the database with an expiry time
        $sql = "UPDATE users SET reset_token='$token', token_expiry='$expiry' WHERE email='$email'";
        $conn->query($sql);

        // Create the password reset link
        $reset_link = "http://yourdomain.com/resetpassword.php?token=$token";

        // Send the email
        $subject = "Password Reset Request";
        $message = "Hello, \n\nWe received a request to reset your password. Please click the link below to reset your password:\n\n$reset_link\n\nIf you did not request a password reset, please ignore this email.";
        $headers = 'From: no-reply@yourdomain.com';

        // Mail function (requires a working mail server)
        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email address.";
        } else {
            echo "There was an error sending the email. Please try again.";
        }
    } else {
        echo "Email not found.";
    }

    $conn->close();
}
?>
