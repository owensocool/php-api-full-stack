<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/view/signIn.html");
    exit();
}

$user_id = $_SESSION['user_id'];
include_once '../../../config/db/connection.php';

// Fetch cart items from the database
$sql = "SELECT * FROM cart_items WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cartItems = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement and database connection
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beluga Phone Phone Shop</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background: linear-gradient(to right, #0A2647, #144272, #205295);
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            width: 18%;     
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
            padding: 20px;
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
            background-color: #007BFF; 
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .card button:hover {
            background-color: #0056b3; 
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

         .quantity-input {
        width: 40px;
        text-align: center;
        margin: 0 5px;
        }

        .delete-link {
            color: red;
            cursor: pointer;
        }
        
        #orderButton:disabled {
            background-color: #EEEEEE;
            color: #000;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: not-allowed;
        }

        #orderButton {
            background-color: #65B741;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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

     <?php
    echo "<br/> <br/>
        <table border='0' style='width: 90%; margin: auto;'>
        <tr>
            <td width='950px'><a style='font-weight:bold; font-size: 22px;' >รายการสินค้าในตะกร้า</a></td>
        </tr>
        </table>
        <br />";

    if (!empty($cartItems)) {
        $totalPrice = 0; // Variable to store the total price

        echo "<form method='post' action='../order/order_form.php'>"; // Form to submit the order
        echo "<table border='0' style='width: 90%; border-collapse: collapse; margin: auto; padding-top: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                <tr style='background-color: #0A2647; color: white; text-align: center;'>
                    <th width='50px' style='padding: 10px;'>Product Name</th>
                    <th width='50px' style='padding: 10px;'>Price</th>
                    <th width='50px' style='padding: 10px;'>Quantity</th>
                    <th width='50px' style='padding: 10px;'>Total</th>
                    <th width='50px' style='padding: 10px;'>Select</th>
                    <th width='50px' style='padding: 10px;'>Delete</th>
                </tr>";

        foreach ($cartItems as $index => $item) {
            $productId = $item['product_id'];
            $productName = $item['product_name'];
            $productPrice = $item['product_price'];
            $quantity = $item['quantity'];
            $total = $productPrice * $quantity;

            echo "<tr>
                    <td style='padding: 10px; cursor: pointer;'>{$productName}</td>
                    <td style='padding: 10px; cursor: pointer; text-align:center;'>{$productPrice} THB</td>
                    <td style='padding: 10px; text-align:center;'>
                        <input class='quantity-input' type='number' name='quantity[]' value='{$quantity}' min='1' onchange='updateTotal(this, {$productPrice}, {$index}, \"{$productId}\")'>
                    </td>
                    <td class='total' style='padding: 10px; cursor: pointer; text-align:center;'>{$total} THB</td>
                    <td style='padding: 10px; text-align:center;'>
                        <input type='checkbox' id='productCheckbox' name='selected_products[]' value='{$item['product_id']}'>
                    </td>
                    <td style='padding: 10px; text-align:center;'>
                        <a href='remove_items.php?product_id={$item['product_id']}'>Delete</a>
                    </td>
                </tr>";
            $totalPrice += $total; // Accumulate the total price
        }

        echo "</table>";

        echo "<br/> <br/>
            <table border='0' style='width: 80%; margin: auto;'>
                <tr>
                    <td width='850px'><a style='font-weight:bold; font-size: 22px;' >Total Price: <span id='totalPrice'>{$totalPrice}</span> THB</a></td>
                    <td width='150px'></td>
                    <td width='300px'><a href='#'onclick='calculateTotalPrice()'><button type='button' style=' background-color: #365486; color: white; padding: 12px; border: none; border-radius: 5px;  cursor: pointer;'>รวมราคาทั้งหมด</button></a><a style='padding-left:20px;'><button id='orderButton' type='submit'>สั่งสินค้า</button></a></td>
                </tr>
            </table>
            <br />";

        echo "</form>";

    } else {
        echo "<table border='0' style='width: 90%; border-collapse: collapse; margin: auto; padding-top: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                <tr style='background-color: #0A2647; color: white; text-align: center;'>
                    <th width='50px' style='padding: 10px;'>Product Name</th>
                    <th width='50px' style='padding: 10px;'>Price</th>
                    <th width='50px' style='padding: 10px;'>Quantity</th>
                    <th width='50px' style='padding: 10px;'>Total</th>
                    <th width='50px' style='padding: 10px;'>Select</th>
                    <th width='50px' style='padding: 10px;'>Delete</th>
                </tr></table>";
        echo "<center><p>ไม่พบสินค้าในตะกร้า</p></center>";
    }
    ?>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    // Get references to the checkboxes and button
                    var checkboxes = document.querySelectorAll("[name='selected_products[]']");
                    var orderButton = document.getElementById("orderButton");

                    checkboxes.forEach(function (checkbox) {
                        checkbox.addEventListener("change", function () {
                            orderButton.disabled = !Array.from(checkboxes).some(checkbox => checkbox.checked);
                        });
                    });

                    orderButton.disabled = true;
                });


                function calculateTotalPrice() {
                    var checkboxes = document.getElementsByName('selected_products[]');
                    var totalPrice = 0;

                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].checked) {
                            var row = checkboxes[i].closest('tr');
                            var totalCell = row.cells[3];
                            var totalValue = parseFloat(totalCell.textContent.replace(' THB', ''));
                            totalPrice += totalValue;
                        }
                    }

                    document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
                }
                
                function updateTotal(input, productPrice, index, productId) {
                    var quantity = parseInt(input.value);
                    console.log(productId);
                    $.ajax({
                        type: 'POST',
                        url: 'update_cart.php',
                        data: {
                            index: index,
                            productId: productId,
                            quantity: quantity
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });

                    var totalCell = document.getElementsByClassName('total')[index];
                    var total = productPrice * quantity;
                    totalCell.textContent = total.toFixed(2) + ' บาท';

                    calculateTotalPrice();
                }

            </script>

</body>
</html>
