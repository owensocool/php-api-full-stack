<?php
require_once '../../../config/db/connection.php';
require_once '../log/access_log.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = $_POST['product_id'];
$stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
$stmt->bind_param("s", $product_id);

if ($stmt->execute()) {
    echo "Delete data = <span style='color:red;'> '$product_id' </span> is Successful.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
header("Location: view_product.php");
exit;

?>