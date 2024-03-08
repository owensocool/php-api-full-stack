<?php
require_once '../../../config/db/connection.php';
require_once '../log/access_log.php';

$stmt = $conn->prepare("INSERT INTO products (product_id, product_name, product_price, type, model, mark, image_path, product_stock, product_status, last_update) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
$stmt->bind_param("sssssssss", $product_id, $product_name, $product_price, $type, $model, $mark, $image_path, $product_stock, $product_status);

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$type = $_POST['type'];
$model = $_POST['model'];
$mark = $_POST['mark'];

function generateUniqueFilename($originalFilename) {
    $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
    $datetime = new DateTime();
    return $datetime->format('YmdHis') . "." . $extension;
}

$uploadDirectory = '../../../public/product/';

if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $filename = generateUniqueFilename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory . $filename);
    $image_path = $uploadDirectory . $filename;
} else {
    $image_path = null;
}

$product_stock = $_POST['product_stock'];
$product_status = $_POST['product_status'];

if ($stmt->execute()) {
    echo "Insert data = <span style='color:red;'> '$product_id' </span> is Successful.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: view_product.php");
exit;
?>
