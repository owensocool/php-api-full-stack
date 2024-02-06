<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['status']) && isset($_POST['orderId'])) {
        $status = $_POST['status'];
        $orderId = $_POST['orderId'];

        include_once '../../../config/db/connection.php';

        $order_id = $orderId;

        $sql = "UPDATE orders SET order_status = ? WHERE order_id = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $status,$order_id);
        $stmt->execute();

        // Close the statement and database connection
        $stmt->close();
        $conn->close();

        echo json_encode(['status' => 'success', 'message' => 'updated successfully']);
        
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid index']);
        }
   
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

header("Location: view_order.php");
exit;
?>
