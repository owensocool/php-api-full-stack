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

        footer {
            background: linear-gradient(to right, #092635, #5C8374, #1B4242);
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }


        .edit-btn, .delete-btn {
        border: none;
        background: none;
        cursor: pointer;
        }

        .edit-btn img, .delete-btn img {
            width: 120%;
        }

        .status-dropdown {
            padding: 2px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-size: 12px;
            width: 100%;
            max-width: 200px; /* Adjust max-width as needed */
        }

        /* Style for option elements */
        .status-dropdown option {
            background-color: #fff;
            color: #333;
        }

        /* Hover effect for option elements */
        .status-dropdown option:hover {
            background-color: #ddd;
            color: #333;
        }


    </style>
</head>
<body>

    <header>
        <div class="logo"><img src="../../../public/beluga_logo1.png" alt="Logo"> <a>Beluga Phone Shop</a></div>
        <nav>
            <a href="../../../index.php">หน้าหลัก</a>
            <a href="..\product_admin\view_product.php">จัดการสินค้า</a>
            <a href="view_order.php">จัดการออเดอร์</a>
            <a href="..\customer_admin\view_customer.php">จัดการลูกค้า</a>
        </nav>
        <a class="login-btn"></a>
    </header>

    <div>
        <?php
        require_once '../../../config/db/connection.php';
        $query = " SELECT * FROM orders";
        $result = $conn->query($query);

        if ($result) {
        echo "<br/> <br/>
                <table border='0' style='width: 90%; margin: auto;'>
                <tr>
                    <td width='950px'><a style='font-weight:bold; font-size: 22px;' >รายการออเดอร์</a></td>
                    <!--<td width='270px'><a style='font-weight:bold; margin-left:40px;'>เพิ่มรายการออเดอร์ใหม่ ->></a></td>
                    <td width='140px'> <a href='add_product.html'><button type='button' style=' background-color: #0B60B0; color: white; padding: 12px; border: none; border-radius: 5px;  cursor: pointer;'>+ เพิ่มออเดอร์ใหม่</button></a></td> -->
                </tr>
                </table>
        <br />";
       echo "<table border='0' style='width: 90%; border-collapse: collapse; margin: auto; padding-top: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                <tr style='background-color: #86B6F6; color: white; text-align: center;'>
                    <th width='30px' style='padding: 10px;'>V</th>
                    <th width='180px' style='padding: 10px;' >รหัสออเดอร์</th>
                    <th width='180px' style='padding: 10px;'>รหัสลูกค้า</th>
                    <th width='200px' style='padding: 10px;'>ชื่อลูกค้า</th>
                    <th width='250px' style='padding: 10px;'>ที่อยู่</th>
                    <th width='200px' style='padding: 10px;'>เบอร์</th>
                    <th width='100px' style='padding: 10px;'>จำนวน</th>
                    <th width='180px' style='padding: 10px;'>ราคารวม</th>
                    <th width='200px' style='padding: 10px;'>วันที่สั่ง</th>
                    <th width='150px' style='padding: 10px;'>วันที่ส่ง</th>
                    <th width='300px' style='padding: 10px;'>สถานะ</th>
                    <th width='50px' style='padding: 10px;'>U</th>
                    <th width='50px' style='padding: 10px;'>D</th>
                </tr>";
            while ($row = $result->fetch_assoc()) {
                $name1 = $row['order_id'];
                $name2 = $row['customer_id'];
                $name3 = $row['name_order'];
                $name4 = $row['address'];
                $name5 = $row['tel'];
                $name6 = $row['amount'];
                $name7 = $row['total_price'];
                $name8 = $row['order_status'];
                $name9 = $row['order_date'];
                $name10 = $row['shipping_date'];
                $name12 = $row['last_update'];
               
                echo "<tr>
                        <td style='padding: 5px; cursor: pointer; text-align:center;'>
                            <form method='get' action='view_order_detail.php'>
                                <input type='hidden' name='order' value='$name1'>
                                <button type='submit' class='edit-btn'>
                                    <img src='../../../public/eye-48.png' alt='Edit'>
                                </button>
                            </form></td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name1</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name2</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name3</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name4</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name5</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name6</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name7</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name9</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name10</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>";

                        if ($name8 == 'Cancel') {
                            echo "<span style='color: red;'>Cancel</span>";
                        } else {
                            echo "<select class='status-dropdown' onchange='updateOrderStatus(this.value, \"$name1\")'>
                                <option value='Order' " . ($name8 == 'Order' ? 'selected' : '') . ">Order</option>
                                <option value='Processing' " . ($name8 == 'Processing' ? 'selected' : '') . ">Processing</option>
                                <option value='Shipped' " . ($name8 == 'Shipped' ? 'selected' : '') . ">Shipped</option>
                                <option value='Delivered' " . ($name8 == 'Delivered' ? 'selected' : '') . ">Delivered</option>
                            </select>";
                        }
                    
                        echo "</td>
                                <td>
                                    <form method='post' action='edit_order.php'>
                                        <input type='hidden' name='order_id' value='$name1'>
                                        <button type='submit' class='edit-btn'>
                                            <img src='../../../public/edit-48.png' alt='Edit'>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form id='cancelForm_$name1' method='post' action='change_status.php'>
                                        <input type='hidden' name='orderId' value='$name1'>
                                        <input type='hidden' name='status' value='Cancel'>
                                        <button type='button' class='delete-btn' onclick='confirmCancel(\"$name1\")'>
                                            <img src='../../../public/cancel-48.png' alt='Delete'>
                                        </button>
                                    </form>
                                </td>

                            </tr>";
                    }
            echo "</table>";
    $result->free();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
</div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function updateOrderStatus(status, orderId) {
            $.ajax({
                        type: 'POST',
                        url: './change_status.php',
                        data: {
                            status: status,
                            orderId: orderId
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
            }

             function confirmCancel(orderId) {
                    // Display a confirmation dialog
                    var confirmation = confirm("คุณต้องการยกเลิกรายการนี้หรือไม่?");

                    if (confirmation) {
                        document.getElementById('cancelForm_' + orderId).submit();
                    }
                }
    </script>
</body>

</html>
