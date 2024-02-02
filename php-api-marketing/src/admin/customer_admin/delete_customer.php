<?php
require_once '../../../config/db/connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_id = $_POST['customer_id'];

$stmtUsers = $conn->prepare("DELETE FROM users WHERE customer_id = ?");
$stmtUsers->bind_param("s", $customer_id);

if ($stmtUsers->execute()) {
    $stmtCustomer = $conn->prepare("DELETE FROM customer WHERE customer_id = ?");
    $stmtCustomer->bind_param("s", $customer_id);

    if ($stmtCustomer->execute()) {
        echo "Delete data = <span style='color:red;'> '$customer_id' </span> is Successful.";
    } else {
        echo "Error: " . $stmtCustomer->error;
    }

    $stmtCustomer->close();
} else {
    echo "Error: " . $stmtUsers->error;
}

$stmtUsers->close();
$conn->close();

header("Location: view_customer.php");
exit;
?>
