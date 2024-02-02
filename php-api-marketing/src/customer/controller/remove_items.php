<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        include_once '../../../config/db/connection.php';

        $sql = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $_SESSION['user_id'], $product_id);
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }
}

header("Location: cart.php");
exit();
?>
