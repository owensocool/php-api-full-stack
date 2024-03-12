<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['index']) && isset($_POST['quantity']) && isset($_POST['productId'])) {
        $index = $_POST['index'];
        $quantity = $_POST['quantity'];
        $productId = $_POST['productId'];
        $user_id = $_SESSION['user_id'];

        include_once '../../../../config/db/connection.php';

        $product_id = $productId;
        // $product_id = $_SESSION['cart'][$index]['productId'];

        $sql = "UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $quantity, $user_id, $product_id);
        $stmt->execute();

        // Close the statement and database connection
        $stmt->close();
        $conn->close();

        echo json_encode(['status' => 'success', 'message' => 'Quantity updated successfully']);
        
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid index']);
        }
   
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
