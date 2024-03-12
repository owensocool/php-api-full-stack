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
            background-color: #176B87;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
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
            width: 70%;
        }

    </style>
</head>
<body>

  <header>
        <div class="logo"><img src="../../../../public/beluga_logo1.png" alt="Logo"> <a>Beluga Phone Shop</a></div>
        <nav>
            <a href="../../../home/index.php">หน้าหลัก</a>
            <a href="../../product_admin/product_view/view_product.php">จัดการสินค้า</a>
            <a href="../../order_admin/order_view/view_order.php">จัดการออเดอร์</a>
            <a href="../../customer_admin/customer_view/view_customer.php">จัดการลูกค้า</a>
            <a href="../../income_admin/revenue.php">รายรับ</a>
        </nav>
        <div></div>
        <a href="../../../auth/controller/logout.php"><button class="login-btn">ออกจากระบบ</button></a>
    </header>

    <div>
        <?php
        require_once '../../../../config/db/connection.php';
        $query = "SELECT customer.*, 
                 COUNT(orders.order_id) AS total_orders
          FROM customer
          LEFT JOIN orders ON customer.customer_id = orders.customer_id
          GROUP BY customer.customer_id
          ORDER BY customer.customer_id";
        $result = $conn->query($query);

        if ($result) {
        echo "<br/> <br/>
                <table border='0' style='width: 90%; margin: auto;'>
                <tr>
                    <td width='950px'><a style='font-weight:bold; font-size: 22px;' >รายการข้อมูลลูกค้า</a></td>
                    <!-- <td width='270px'><a style='font-weight:bold; margin-left:40px;'>เพิ่มรายการลูกค้าใหม่ ->></a></td>
                    <td width='140px'> <a href='add_customer.html'><button type='button' style=' background-color: #1B4242; color: white; padding: 12px; border: none; border-radius: 5px;  cursor: pointer;'>+ เพิ่มลูกค้าใหม่</button></a></td> -->
                </tr>
                </table>
        <br />";
       echo "<table border='0' style='width: 90%; border-collapse: collapse; margin: auto; padding-top: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                <tr style='background-color: #5C8374; color: white; text-align: center;'>
                    <th width='200px' style='padding: 10px;'>รหัสลูกค้า</th>
                    <th width='300px' style='padding: 10px;'>ชื่อลูกค้า</th>
                    <th width='300px' style='padding: 10px;'>email</th>
                    <th width='300px' style='padding: 10px;'>เบอร์</th>
                    <th width='300px' style='padding: 10px;'>ที่อยู่</th>
                    <th width='200px' style='padding: 10px;'>จำนวนที่เคยสั่ง</th>
                    <th width='300px' style='padding: 10px;'>อัพเดตล่าสุด</th>
                    <th width='50px' style='padding: 10px;'>U</th>
                    <th width='50px' style='padding: 10px;'>D</th>
                </tr>";
            while ($row = $result->fetch_assoc()) {
                    $name1 = $row['customer_id'];
                    $name2 = $row['name'];
                    $name3 = $row['email'];
                    $name4 = $row['tel'];
                    $name5 = $row['address'];
                    $name6 = $row['total_orders'];
                    $name7 = $row['last_update'];
               
                echo "<tr'>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name1</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name2</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name3</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name4</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name5</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name6</td>
                        <td style='padding: 10px; cursor: pointer; text-align:center;'>$name7</td>
                        <td>
                            <form method='post' action='edit_customer.php'>
                                <input type='hidden' name='customer_id' value='$name1'>
                                <button type='submit' class='edit-btn'>
                                    <img src='../../../../public/edit-50.png' alt='Edit'>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form method='post' action='delete_customer.php'>
                                <input type='hidden' name='customer_id' value='$name1'>
                                <button type='submit' class='delete-btn'>
                                    <img src='../../../../public/Bin-50.png' alt='Delete'>
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

    <footer>
        &copy; 2024 Beluga Phone Phone Shop. All rights reserved.
    </footer>

</body>
</html>
