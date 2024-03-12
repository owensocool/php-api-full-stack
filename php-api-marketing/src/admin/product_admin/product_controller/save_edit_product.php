<?php
require_once '../../../../config/db/connection.php';
require_once '../../log/access_log.php';

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

$uploadDirectory = '../../../../public/product/';
$image_path = null;

// Check if a new image is uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $filename = generateUniqueFilename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory . $filename);
    $image_path = $filename;

    // Delete old image if it exists
    if (!empty($_POST['old_image_path'])) {
        unlink($_POST['old_image_path']);
    }
} else {
    $image_path = $_POST['old_image_path'];
}

$product_stock = $_POST['product_stock'];
$product_status = $_POST['product_status'];

$stmt = $conn->prepare("UPDATE products SET product_name=?, product_price=?, type=?, model=?, mark=?, image_path=?, product_stock=?, product_status=?, last_update=CURRENT_TIMESTAMP WHERE product_id = ?");
$stmt->bind_param("sssssssss", $product_name, $product_price, $type, $model, $mark, $image_path, $product_stock, $product_status, $product_id);


if ($stmt->execute()) {
    echo "Update data for product ID = <span style='color:red;'> '$product_id' </span> is Successful.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: ../product_view/view_product.php");
exit;
?>
