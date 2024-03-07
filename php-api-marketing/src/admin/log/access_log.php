<?php
session_start();
require_once '../../../config/db/connection.php';

// Assuming $db_connection is already established in connection.php
function logMessage($message) {
    
    global $conn; // Assuming $conn is your PDO connection variable
    $username = $_SESSION['username'];
    $timestamp = date('Y-m-d H:i:s');
    $userIP = file_get_contents("https://ipv4.icanhazip.com/");
    $uuid = uniqid();
    
    $stmt = $conn->prepare("INSERT INTO access_log (uuid, timestamp, username, ip_address, action) VALUES (?, CURRENT_TIMESTAMP, ?, ?, ?)");
    $stmt->bind_param("ssss", $uuid ,$username, $userIP, $message);

    if ($stmt->execute()) {
        echo "Insert data success= <span style='color:red;'> '$uuid' </span> is Successful.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

}
?>
