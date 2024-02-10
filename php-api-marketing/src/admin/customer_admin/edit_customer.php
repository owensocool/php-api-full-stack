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
        <div class="logo"><img src="../../../public/beluga_logo1.png" alt="Logo"> <a>Beluga Phone Shop</a></div>
        <nav>
            <a href="../../../index.php">หน้าหลัก</a>
            <a href="..\product_admin\view_product.php">จัดการสินค้า</a>
            <a href="..\order_admin\view_order.php">จัดการออเดอร์</a>
            <a href="view_customer.php">จัดการลูกค้า</a>
        </nav>
        <a class="login-btn"></a>
    </header>

    <center>
    <br/>
    <h2>แก้ไขข้อมูลลูกค้า</h2>
       <hr style='width: 85%; border: 1px solid #3A4D39;' />
        <br/>

         <?php
            require_once '../../../config/db/connection.php';

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $customer_id = $_POST['customer_id'];
            $stmt = $conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
            $stmt->bind_param("s", $customer_id);
            $stmt->execute();

            $result = $stmt->get_result();


            if ($result && $row = $result->fetch_assoc()) {
        ?>

        <form method="post" action="save_edit_customer.php">
            <table> <tr style='background-color: #3A4D39;'>
                    <td width='500px' style='padding: 10px; font-weight: bold; color: white; '>ข้อมูลลูกค้า</td>
                </tr>
            </table>
            <table width='500px'>
                <tr>
                    <td width='100px' style='padding: 10px; font-weight: bold;'>รหัสลูกค้า<a style="color:red;"> *</a></td>
                    <td><input type="hidden" name="customer_id" required style="width: 95%; padding: 8px; margin: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; background-color: #EEEEEE;" value="<?php echo $row['customer_id']; ?>"> <a style="width: 95%; padding: 8px; margin: 10px;" ><?php echo $row['customer_id']; ?></a> </td>
                </tr>
                <tr>
                    <td width='100px' style='padding: 10px; font-weight: bold;'>ชื่อ-นามสกุล<a style="color:red;"> *</a></td>
                    <td><input type="text" name="name" required style="width: 95%; padding: 8px; margin: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; background-color: #EEEEEE;" value="<?php echo $row['name']; ?>"></td>
                </tr>
                <tr>
                    <td width='100px' style='padding: 10px; font-weight: bold;'>เพศ<a style="color:red;"> *</a></td>
                    <td>
                        <select name="sex" required style="width: 95%; padding: 8px; margin: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; background-color: #EEEEEE;"value="<?php echo $row['sex']; ?>">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male">ชาย</option>
                            <option value="female">หญิง</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width='100px' style='padding: 10px;font-weight: bold;'>ที่อยู่<a style="color:red;"> *</a></td>
                    <td><input type="text" name="address" required style="width: 95%; padding: 8px; margin: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; background-color: #EEEEEE;" value="<?php echo $row['address']; ?>"></td>
                </tr>
                <tr>
                    <td width='100px' style='padding: 5px; font-weight: bold;'>เบอร์โทรศัพท์<a style="color:red;"> *</a></td>
                    <td><input type="text" name="tel" required style="width: 95%; padding: 8px; margin: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; background-color: #EEEEEE;"   value="<?php echo $row['tel']; ?>"></td>
                </tr>
                <tr>
                    <td width='100px' style='padding: 10px;font-weight: bold;'>E-mail<a style="color:red;"> *</a></td>
                    <td><input type="email" name="email" style="width: 95%; padding: 8px; margin: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; background-color: #EEEEEE;"  value="<?php echo $row['email']; ?>"></td>
                </tr>
                
            </table>
            <br />
            <input type="submit" value="ยืนยัน" style="width: 150px; background-color: #3A4D39; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">
            <input type="button" onclick="window.location.href='view_customer.php'" value="ยกเลิก" style="width: 150px; background-color: #B06161; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">
        </form>
    </center>
    <?php
            mysqli_close($conn);
            } else {
                echo "Error fetching customer data";
            }
    ?>

    <footer>
        &copy; 2024 Beluga Phone Phone Shop. All rights reserved.
    </footer>

</body>
</html>
