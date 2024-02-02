<?php
require_once '../../../config/db/connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = $_POST['order_id'];

// Delete from the detail table first
$stmtDetail = $conn->prepare("DELETE FROM detail WHERE order_id = ?");
$stmtDetail->bind_param("s", $order_id);

if ($stmtDetail->execute()) {
    // After successful deletion from detail, delete from orders
    $stmtOrders = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmtOrders->bind_param("s", $order_id);

    if ($stmtOrders->execute()) {
        echo "Delete data = <span style='color:red;'> '$order_id' </span> is Successful.";
    } else {
        echo "Error: " . $stmtOrders->error;
    }

    $stmtOrders->close();
} else {
    echo "Error: " . $stmtDetail->error;
}

$stmtDetail->close();
$conn->close();

header("Location: view_order.php");
exit;
?>
