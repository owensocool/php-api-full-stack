<?php
session_start();

// if (!isset($_SESSION['user_id'])) {
//     header("Location: ../../auth/view/signIn.html");
//     exit();
// }

$user_id = $_SESSION['user_id'];

include_once '../../../../config/db/connection.php';

// Check if products are selected
if (isset($_POST['selected_products'])) {
    $selectedProducts = $_POST['selected_products'];

    $placeholder = str_repeat('?,', count($selectedProducts) - 1) . '?';

    $sql = "SELECT * FROM cart_items WHERE user_id = ? AND product_id IN ($placeholder)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('s' . str_repeat('s', count($selectedProducts)), $user_id, ...$selectedProducts);

    $stmt->execute();
    $result = $stmt->get_result();
    $cartItems = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch image paths for all products in a single query
    $productIds = array_column($cartItems, 'product_id');
    $placeholder = str_repeat('?,', count($productIds) - 1) . '?';
    $query = "SELECT product_id, image_path FROM products WHERE product_id IN ($placeholder)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('s', count($productIds)), ...$productIds);
    $stmt->execute();
    $stmt->bind_result($productId, $imagePath);

    $imagePaths = [];
    while ($stmt->fetch()) {
        $imagePaths[$productId] = $imagePath;
    }

    $stmt->close();

    $totalAmount = 0;
    $totalPrice = 0;

    foreach ($cartItems as $item) {
        $productId = $item['product_id'];
        $item['image_path'] = !empty($imagePaths[$productId]) ? $imagePaths[$productId] : null;

        $totalAmount += $item['quantity'];
        $totalPrice += $item['product_price'] * $item['quantity'];
    }

    $shippingCost = 50;
    $totalPriceWithShipping = $totalPrice + $shippingCost;
}
else{
    header("Location: ../controller/cart.php");
    exit();
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
            display: none;
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

        .container {
            width: 40%;
            padding: 10px;
            margin: auto;
            padding-top:80px;
            padding-bottom: 80px;
        }

        form {
            display: grid;
            gap: 15px;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        footer {
            background: linear-gradient(to right, #092635, #5C8374, #1B4242);
            color: #fff;
            text-align: center;
            padding: 10px;
            display: flex;

        }

    </style>
</head>
<body>

    <header>
        <div class="logo"><img src="../../../../public/beluga_logo1.png" alt="Logo"> <a>Beluga Phone Shop</a></div>
        <nav>
            <a href="../../../home/index.php">หน้าหลัก</a>
            <a href="../../cart/cart_view/cart.php">ตะกร้า</a>
            <a href="../order_view/search_order.php">ค้นหา Order</a>
        </nav>
        <a class="login-btn"></a>
    </header>

   <div class="container">
        <div id="page1" class="page">
            <table border='1' style='width: 100%; border-collapse: collapse; margin: auto; padding-top: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                    <tr style='background-color: #0A2647; color: white; text-align: center;'>
                        <th width='200px;' style='padding: 10px;' >Customer Information</th>
                    </tr>
            </table>
            <?php
                require_once '../../../../config/db/connection.php';
            ?>
        <form id="customerForm" method="post" action="../order_controller/order_save.php" name="customerForm" enctype="multipart/form-data">
                <!-- <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $row['customer_id']; ?>"> -->
                <label for="name_receive"> ชื่อ-นามสกุล (ผู้สั่ง): </label>
                <input type="text" id="name_order" name="name_order" required>
                <label for="name_receive"> ชื่อ-นามสกุล (ผู้รับ): </label>
                <input type="text" id="name_receive" name="name_receive" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="tel">เบอร์โทรศัพท์:</label>
                <input type="text" id="tel" name="tel" required>
                <label for="address">ที่อยู่จัดส่ง:</label>
                <input type="text" id="address" name="address" required>
                <label for="name_bill">ชื่อ-นามสกุล: (ชื่อผู้ออกบิล) </label>
                <input type="text" id="name_bill" name="name_bill" required>
                <label for="tax_no">หมายเลขประจำตัวผู้เสียภาษี (ถ้ามี):</label>
                <input type="text" id="tax_no" name="tax_no" >
                <input type="hidden" name="cart_items" value="<?php echo htmlspecialchars(json_encode($cartItems)); ?>">
        </div>

        <div style='padding-top: 20px;'>
        <table border='0' style='width: 100%; border-collapse: collapse; margin: auto; padding-top: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                    <tr style='background-color: #0A2647; color: white; text-align:center;'>
                        <th style='padding: 10px;width:100px;' >การชำระเงิน</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                     <tr>
                        <td style='padding: 2px; text-align:center;'>
                            <img src='../../../../public/qr.jpg' alt='QR Image' width='100%'>
                              
                        </td>
                                <td style='width:80px; padding: 30px; text-align:left;'>ชำระด้วย QR Code </td>
                                <td style='width:120px; padding: 10px; text-align:center;'>
                                    <label for="image">กรุณาอัพโหลดสลิป</label>
                                    <input type="file" id="image" name="image" accept="image/*" required>
                                </td>
                        <td style='width:140px; padding: 2px; text-align:center;'>
                                <div id="imagePreview" style="display:none; align-items: start;">
                                <img id="previewImage" src="#" alt="Preview Image" style="max-width: 150px; max-height: 150px;">
                         </div>
                        </td>
                    </tr>
        </table>
        </form>
        </div>

        <div id="page2" class="page">
            <h2>Items in Cart</h2>
            <?php if (!empty($cartItems)) : ?>
                <table border='0' style='width: 100%; border-collapse: collapse; margin: auto; padding-top: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                    <tr style='background-color: #0A2647; color: white; text-align: center;'>
                        <th width='200px;' style='padding: 10px;' ></th>
                        <th width='400px;' style='padding: 10px;'>สินค้า</th>
                        <th width='200px;' style='padding: 10px;'>ราคา</th>
                        <th width='100px;' style='padding: 10px;'>จำนวน</th>
                        <th width='200px;' style='padding: 10px;'>รวม</th>
                    </tr>
                    <?php
                    // Fetch image paths for all products in a single query
                    $productIds = array_column($cartItems, 'product_id');
                    $placeholder = str_repeat('?,', count($productIds) - 1) . '?';
                    $query = "SELECT product_id, image_path FROM products WHERE product_id IN ($placeholder)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param(str_repeat('s', count($productIds)), ...$productIds);
                    $stmt->execute();
                    $stmt->bind_result($productId, $imagePath);

                    $imagePaths = [];
                    while ($stmt->fetch()) {
                        $imagePaths[$productId] = $imagePath;
                    }

                    $stmt->close();

                    foreach ($cartItems as $item) :
                    ?>
                        <tr>
                            <td style='padding: 2px; text-align:center;'>
                                <?php
                                $productId = $item['product_id'];
                                if (!empty($imagePaths[$productId])) : ?>
                                    <img src='../../../../public/product/<?php echo $imagePaths[$productId]; ?>' alt='Product Image' width='100%'>
                                <?php else : ?>
                                    <p>No image found</p>
                                <?php endif; ?>
                            </td>
                            <td style='padding: 10px; text-align:center;'><?php echo $item['product_name']; ?></td>
                            <td style='padding: 10px; text-align:center;'><?php echo $item['product_price']; ?> บาท</td>
                            <td style='padding: 10px; text-align:center;'><?php echo $item['quantity']; ?></td>
                            <td style='padding: 10px; text-align:center;'><?php echo $item['product_price'] * $item['quantity']; ?> บาท</td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>No items in the cart.</p>
            <?php endif; ?>
            <br />

            <h2>Order Summary</h2>
            <p>Total Amount: <?php echo $totalAmount; ?></p>
            <p>Shipping Cost: <?php echo $shippingCost; ?> บาท</p>
            <p>Total Price (with Shipping): <?php echo $totalPriceWithShipping; ?> บาท</p>

            <br><br>

            <?php $conn->close();?>
            <center>
                <input
                type="button"
                value="ย้อนกลับ"
                style="
                    width: 150px;
                    background-color: #0A2647;
                    color: white;
                    padding: 10px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    margin-right: 10px;
                "
                onclick="window.location.href='../../cart/cart_view/cart.php'"
                />

                <input
                type="button"
                value="ยืนยันคำสั่งซื้อ"
                style="
                    width: 150px;
                    background-color: #65B741;
                    color: white;
                    padding: 10px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    margin-left: 10px;
                "
                onclick="submitForm()"
                /></center>
                
        </div>
    </div>

    <script>
    // function nextPage() {
    //     document.getElementById('page1').classList.add('hidden');
    //     document.getElementById('page2').classList.remove('hidden');
    // }

    // function previousPage() {
    //     document.getElementById('page2').classList.add('hidden');
    //     document.getElementById('page1').classList.remove('hidden');
    // }

    function submitForm() {
        var nameOrder = document.getElementById('name_order').value.trim();
        var nameReceive = document.getElementById('name_receive').value.trim();
        var email = document.getElementById('email').value.trim();
        var tel = document.getElementById('tel').value.trim();
        var address = document.getElementById('address').value.trim();
        //var nameBill = document.getElementById('name_bill').value.trim();
        var slip = document.getElementById('image')

        if (nameOrder === '' || nameReceive === '' || email === '' || tel === '' || address === '') {
            alert('Please fill in all required fields.');
            return false;
        }

        // Check if a file has been uploaded
        if (slip.files.length === 0) {
            alert('Please upload a slip.');
            return false;
        }

        document.getElementById('customerForm').submit();
    }
</script>
<script>
            document.getElementById('image').addEventListener('change', function(e) {
              var file = e.target.files[0];
              if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                  document.getElementById('imagePreview').style.display = 'block';
                  document.getElementById('previewImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
              }
            });
    </script>

</body>
</html>
