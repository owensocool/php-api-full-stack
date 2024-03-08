<?php
require_once '../../../config/db/connection.php';
require_once '../log/access_log.php';

$stmt = $conn->prepare("INSERT INTO customer (customer_id, name, sex, email, address, tel, last_update) VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
$stmt->bind_param("sssssss", $customer_id, $name, $sex, $email, $address, $tel);

$customer_id = $_POST['customer_id'];
$name = $_POST['name'];
$sex = $_POST['sex'];
$email = $_POST['email'];
$address = $_POST['address'];
$tel = $_POST['tel'];

if ($stmt->execute()) {
    echo "Insert data = <span style='color:red;'> '$customer_id' </span> is Successful.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: view_customer.php");
exit;
?>
