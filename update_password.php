<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the new password and token
    $new_password = $_POST['new_password'];
    $token = $_POST['token'];

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Database connection
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'your_database';
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Update the password and clear the token
    $sql = "UPDATE users SET password='$hashed_password', reset_token=NULL, token_expiry=NULL WHERE reset_token='$token'";
    if ($conn->query($sql) === TRUE) {
        echo 'Password successfully updated.';
    } else {
        echo 'Error updating password: ' . $conn->error;
    }

    $conn->close();
}
?>
