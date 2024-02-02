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

    </style>
</head>
<body>

    <header>
        <div class="logo"><img src="../../../public/beluga_logo1.png" alt="Logo"> <a>Beluga Phone Shop</a></div>
        <nav>
            <a href="../../../index.php">หน้าหลัก</a>
            <a href="view_product.php">จัดการสินค้า</a>
            <a href="..\order_admin\view_order.php">จัดการออเดอร์</a>
            <a href="..\customer_admin\view_customer.php">จัดการลูกค้า</a>
        </nav>
        <a class="login-btn"></a>
    </header>

    <div>
        <?php
        require_once '../../../config/db/connection.php';
        $query = "SELECT * FROM products ORDER BY product_id";
        $result = $conn->query($query);

        if ($result) {
        echo "<br/> <br/>
                <table border='0' style='width: 1250px; margin: auto;'>
                <tr>
                    <td width='950px'><a style='font-weight:bold; font-size: 22px;' >รายการสินค้า</a></td>
                    <td width='250px'><a style='font-weight:bold; margin-left:40px;'>เพิ่มรายการสินค้าใหม่ ->></a></td>
                    <td width='120px'> <a href='add_product.html'><button type='button' style=' background-color: #472183; color: white; padding: 12px; border: none; border-radius: 5px;  cursor: pointer;'>+ เพิ่มสินค้าใหม่</button></a></td>
                </tr>
                </table>
        <br />";
         echo "<table border='0' style='width: 90%; border-collapse: collapse; margin: auto; padding-top: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                <tr style='background-color: #7B66FF; color: white; text-align: center;'>
                    <th width='50px' style='padding: 10px;'>ID</th>
                    <th width='100px' style='padding: 10px;'>Image</th>
                    <th width='250px' style='padding: 10px;'>Product Name</th>
                    <th width='150px' style='padding: 10px;'>Type</th>
                    <th width='150px' style='padding: 10px;'>Model</th>
                    <th width='150px' style='padding: 10px;'>Price</th>
                    <th width='150px' style='padding: 10px;'>Stock</th>
                    <th width='150px' style='padding: 10px;'>Status</th>
                    <th width='200px' style='padding: 10px;'>หมายเหตุ</th>
                    <th width='200px' style='padding: 10px;'>Last Update</th>
                    <th width='40px' style='padding: 10px;'>U</th>
                    <th width='40px' style='padding: 10px;'>D</th>
                </tr>";
            while ($row = $result->fetch_assoc()) {
                $name1 = $row['product_id'];
                $name2 = $row['image_path'];
                $name3 = $row['product_name'];
                $name4 = $row['type'];
                $name5 = $row['model'];
                $name6 = $row['product_price'];
                $name7 = $row['product_stock'];
                $name8 = $row['product_status'];
                $name9 = $row['mark'];
                $name10 = $row['last_update'];
               
                echo "<tr>
                    <td style='padding: 10px; cursor: pointer; text-align:center;'>$name1</td>
                    <td style='padding: 10px; cursor: pointer; text-align:center;'><img src='$name2' alt='Image' style='max-width: 100%; max-height: 100px;'></td>
                    <td style='padding: 10px; cursor: pointer; text-align:center;'>$name3</td>
                    <td style='padding: 10px; cursor: pointer; text-align:center;'>$name4</td>
                    <td style='padding: 10px; cursor: pointer; text-align:center;'>$name5</td>
                    <td style='padding: 10px; cursor: pointer; text-align:center;'>$name6</td>
                    <td style='padding: 10px; cursor: pointer; text-align:center;'>$name7</td>
                    <td style='padding: 10px; cursor: pointer; text-align:center;'>$name8</td>
                    <td style='padding: 10px; cursor: pointer; text-align:center;'>$name9</td>
                    <td style='padding: 10px; cursor: pointer; text-align:center;'>$name10</td>

                    <td style='padding: 5px; cursor: pointer;'>
                    <form method='post' action='edit_product.php'>
                        <input type='hidden' name='product_id' value='$name1'>
                            <button type='submit' style='border: none; background: none; cursor: pointer;'>
                                <img src='../../../public/edit-50.png' width='120%' alt='Edit'>
                            </button>
                        </form>
                    </td>

                    <td style='padding: 5px; cursor: pointer;'>
                        <form method='post' action='delete_product.php'>
                            <input type='hidden' name='product_id' value='$name1'>
                            <button type='submit' style='border: none; background: none; cursor: pointer;'>
                                <img src='../../../public/Bin-50.png' width='120%' alt='delete'>
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
