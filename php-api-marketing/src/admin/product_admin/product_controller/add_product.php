<?php
require_once '../../../../config/db/connection.php';
require_once '../../log/access_log.php';
require_once '../product_controller/product_operation.php';

$stmt = $conn->prepare("INSERT INTO products (product_id, product_name, product_price, type, model, mark, image_path, product_stock, product_status, last_update) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
$stmt->bind_param("sssssssss", $product_id, $product_name, $product_price, $type, $model, $mark, $image_path, $product_stock, $product_status);

$product_id = 'P'.rand(10000, 99999);
    $product_id_validate = findproduct_id($product_id);
    while ($product_id == $product_id_validate){
            $product_id = 'P'.rand(10000, 99999);
            $product_id_validate = findproduct_id($product_id);
            if($product_id != $product_id_validate){
                break;
            }
    }

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

if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $filename = generateUniqueFilename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory . $filename);
    $image_path = $filename;
} else {
    $image_path = null;
}

$product_stock = $_POST['product_stock'];
if ($product_stock > 0){
    $product_status = 'in_stock';
}
else{
    $product_status = 'out_stock';
}

if ($stmt->execute()) {
    echo "Insert data = <span style='color:red;'> '$product_id' </span> is Successful.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: ../product_view/view_product.php");
exit;
?>
