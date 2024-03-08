<?php
require_once '../../../config/db/connection.php';
require_once '../log/access_log.php';

$stmt = $conn->prepare("UPDATE orders SET name_order=?,  address=?, tel=? , shipping_date=?, receive_date=?, last_update=CURRENT_TIMESTAMP WHERE order_id=?");
$stmt->bind_param("ssssss", $name_order, $address, $tel, $shipping_date, $receive_date, $order_id);

$order_id = $_POST['order_id'];
$name_order = $_POST['name_order'];
$address = $_POST['address'];
$tel = $_POST['tel'];
$shipping_date = $_POST['shipping_date'];
$receive_date = $_POST['receive_date'];


if ($stmt->execute()) {
    echo "Update data for order ID = <span style='color:red;'> '$order_id' </span> is Successful.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: view_order.php");
exit;
?>
