<?php
session_start();

require_once ('../../config/db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
        $productId = $_POST['product_id'];
        $productName = $_POST['product_name'];
        $productPrice = $_POST['product_price'];
        $amount = $_POST['amount'];

        try {
            // Check if the product is already in the user's cart
            $stmt = $conn->prepare("SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param('ss', $user_id, $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            $existingCartItem = $result->fetch_assoc();

            if ($existingCartItem) {
                // Update the quantity if the product is already in the cart
                $newQuantity = $existingCartItem['quantity'] + $amount;
                $updateStmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
                $updateStmt->bind_param('iss', $newQuantity, $user_id, $productId);
                $updateStmt->execute();
            } else {
                // Insert a new item into the cart
                $insertStmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, product_name, product_price, quantity) VALUES (?, ?, ?, ?, ?)");
                $insertStmt->bind_param('sssdi', $user_id, $productId, $productName, $productPrice, $amount);
                $insertStmt->execute();
            }

            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beluga Phone Phone Shop</title>
    <link rel="stylesheet" href="./../../public/style/styles.css">
</head>
<body>
    <div id="header"></div>
    <main>
            <img src="../../public/beluga_cover.jpg"/>
    </main>


    <div class="button-container">

        <?php
        if((isset($_SESSION['user_id']) || isset($_SESSION['user_id']) !== 'guess') && isset($_SESSION['role']) == 'admin') {
            echo '<div style="padding-top:30px;">
            <a href="../admin/product_admin/product_view/view_product.php" class="admin-link">หน้าแอดมิน</a></div>';
        }  

        else if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] === 'guess') {
        echo "<div style='padding-left:80px; padding-right:60px; padding-top:30px;'>
        <div class='card-container'>";
          
            require_once '../../config/db/connection.php';

            $query = "SELECT * FROM products";
            $result = $conn->query($query);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    // Check if the product is out of stock
                    $disabled = ($row['product_stock'] == 0) ? 'disabled' : '';
                    $buttonColor = ($row['product_stock'] == 0) ? 'background-color: #cccccc;' : '';
                    $statusColor = ($row['product_stock'] > 0) ? 'green' : 'red';

                    $maxAmount = ($row['product_stock'] == 0) ? 0 : $row['product_stock'];

                   echo "<div class='card'>
                            <img src='../../public/product/{$row['image_path']}' alt='Product Image'>
                            <h3>{$row['product_name']}</h3>
                            <p>Price: {$row['product_price']} THB</p>
                            <p style='color: $statusColor;'>{$row['product_status']}</p>
                            <form method='post'>
                                <label for='amount{$row['product_id']}'>Amount:</label>
                                <input type='number' name='amount' id='amount{$row['product_id']}' value='1' min='1' max='$maxAmount'>
                                <input type='hidden' name='product_id' value='{$row['product_id']}'>
                                <input type='hidden' name='product_name' value='{$row['product_name']}'>
                                <input type='hidden' name='product_price' value='{$row['product_price']}'>
                                <button type='submit' name='add_to_cart' $disabled style='$buttonColor'>Add to Cart</button>
                            </form>
                        </div>";
                }
                $result->free();
            } else {
                echo "Error: " . $conn->error;
            }

            $conn->close();
            }
    ?> 
    </div>
<script>
        // Fetch and insert the header content
        fetch('../partials/header.php')
            .then(response => response.text())
            .then(html => {
                document.getElementById('header').innerHTML = html;
            });
    </script>
</body>
</html>
