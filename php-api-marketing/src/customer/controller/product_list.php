<?php
session_start();

require_once ('../../../config/db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
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
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .hidden {
            display:none;
        }

        header {
            background: linear-gradient(to right, #0A2647, #144272, #205295);
            width: 100%;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center; 
            position: fixed;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 50px;
            padding-left: 30px;
            margin-right: 10px;
        }

        .logo a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            padding-right: 30px;
        }

        nav {
            display: flex;
            gap: 20px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
        }

        .login-btn { 
            margin-right: 30px;
            margin-left: auto;
            padding: 10px 16px; 
            color: #fff;
            border: none;
            font-weight: bold;
        }

        .card-container {
            display: flex;
            width: 100%;
            flex-wrap: wrap;
            justify-content: start;
        }

        .card {
            width: 20%;     
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
            padding: 30px;
            text-align: center;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 80%;
            border-radius: 5px;
        }

        .card button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #007BFF; /* Primary color, you can adjust this */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .card button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .card input {
            width: 40px;
            text-align: center;
            margin: 0 5px;
        }

        footer {
            background: linear-gradient(to right, #092635, #5C8374, #1B4242);
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo"><img src="../../../public/beluga_logo1.png" alt="Logo"> <a>Beluga Phone Shop</a></div>
        <nav>
            <a href="../../../index.php">หน้าหลัก</a>
            <a href="product_list.php">หน้ารวมสินค้า</a>
            <a href="cart.php">ตะกร้า</a>
            <a href="../order/order_list.php">รายการที่สั่ง</a>
        </nav>
        <a class="login-btn"></a>
    </header>

<div style='padding-left:60px; padding-right:60px; padding-top:70px;'>
        <h3>หน้ารวมสินค้า</h3>
        <div class="card-container">
           <?php
            require_once '../../../config/db/connection.php';

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
                            <img src='{$row['image_path']}' alt='Product Image'>
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
            ?>

        </div>
</div>
</body>
</html>