<?php
session_start();

$user_id = $_SESSION['user_id'];
include_once '../../../../config/db/connection.php';

$order_id = $_POST['order_id'];
$order_status = 'Order';

function generateUniqueFilename($originalFilename) {
    $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
    $datetime = new DateTime();
    return $datetime->format('YmdHis') . "." . $extension;
}

$uploadDirectory = '../../../../public/slips/';
    
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $filename = generateUniqueFilename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory . $filename);
        $image_path = $filename;
    } else {
        $image_path = null;
}

$updateQuery = "UPDATE orders SET image_path = ?, order_status = ?, last_update = CURRENT_TIMESTAMP WHERE order_id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("sss", $image_path, $order_status, $order_id);
$stmt->execute();
$stmt->close();

header("Location: ../order_view/order_detail.php?order=" . $order_id);
exit();

?>