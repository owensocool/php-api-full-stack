<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
        background: linear-gradient(to right, #092635, #5c8374, #1b4242);
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
      <div class="logo">
        <img src="../../../public/beluga_logo1.png" alt="Logo" />
        <a>Beluga Phone Shop</a>
      </div>
      <nav>
        <a href="../../../index.php">หน้าหลัก</a>
        <a href="view_product.php">จัดการสินค้า</a>
        <a href="..\order_admin\view_order.php">จัดการออเดอร์</a>
        <a href="..\customer_admin\view_customer.php">จัดการลูกค้า</a>
      </nav>
      <a class="login-btn"></a>
    </header>

    <center>
        <br/>
        <h2>เพิ่มข้อมูลสินค้าใหม่</h2>
        <?php
            require_once '../../../config/db/connection.php';

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $product_id = $_POST['product_id'];
            $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
            $stmt->bind_param("s", $product_id);
            $stmt->execute();

            $result = $stmt->get_result();


            if ($result && $row = $result->fetch_assoc()) {
        ?>
            <form method="post" action="save_edit_product.php"  enctype="multipart/form-data">
            <table>
            <tr style="background-color: #AA77FF">
                <td
                width="1000px"
                style="padding: 10px; font-weight: bold; color: white"
                >
                แก้ไขรายการสินค้า
                </td>
            </tr>
            </table>
            <table width="1000px" border="0">
            <tr >
                <td width="100px" style="padding: 5px; font-weight: bold">รหัสสินค้า<a style="color:red;"> *</a></td>
                <td>
                <input
                    type="hidden"
                    name="product_id"
                    maxlength="6"
                    required
                    value="<?php echo $row['product_id']; ?>"
                    style="
                    width: 95%;
                    padding: 8px;
                    margin: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                    background-color: #EEEEEE;
                    "
                />
                <a style="width: 95%; padding: 8px; margin: 10px;" ><?php echo $row['product_id']; ?></a> 
                </td>
                <td width="100px" style="padding:5px; font-weight: bold">ชื่อสินค้า<a style="color:red;"> *</a></td>
                <td>
                <input
                    type="text"
                    name="product_name"
                    required
                    value="<?php echo $row['product_name']; ?>"
                    style="
                    width: 95%;
                    padding: 8px;
                    margin: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                    background-color: #EEEEEE;
                    "
                />
                </td>
            </tr>

            <tr >
                <td width="100px" style="padding: 5px; font-weight: bold">ราคาสินค้า<a style="color:red;"> *</a></td>
                <td>
                <input
                    type="float"
                    name="product_price"
                    required
                    value="<?php echo $row['product_price']; ?>"
                    style="
                    width: 95%;
                    padding: 8px;
                    margin: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                    background-color: #EEEEEE;
                    "
                />
                </td>
                <td width="100px" style="padding:0px; font-weight: bold">ประเภทสินค้า<a style="color:red;"> *</a></td>
                <td>
                <input
                    type="text"
                    name="type"
                    required
                    value="<?php echo $row['type']; ?>"
                    style="
                    width: 95%;
                    padding: 8px;
                    margin: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                    background-color: #EEEEEE;
                    "
                />
                </td>
            </tr>

            <tr >
                <td width="100px" style="padding: 5px; font-weight: bold">โมเดล</td>
                <td>
                <input
                    type="text"
                    name="model"
                    value="<?php echo $row['model']; ?>"
                    style="
                    width: 95%;
                    padding: 8px;
                    margin: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                    background-color: #EEEEEE;
                    "
                />
                </td>
                <td width="100px" style="padding:5px; font-weight: bold">จำนวนที่เพิ่ม<a style="color:red;"> *</a></td>
                <td>
                <input
                    type="integer"
                    name="product_stock"
                    required
                    value="<?php echo $row['product_stock']; ?>"
                    style="
                    width: 95%;
                    padding: 8px;
                    margin: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                    background-color: #EEEEEE;
                    "
                />
                </td>
            </tr>

            <tr >
                <td width="100px" style="padding: 5px; font-weight: bold">หมายเหตุ</td>
                <td>
                <input
                    type="text"
                    name="mark"
                    value="<?php echo $row['mark']; ?>"
                    style="
                    width: 95%;
                    padding: 8px;
                    margin: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                    background-color: #EEEEEE;
                    "
                />
                </td>
                <td width="100px" style="padding:5px; font-weight: bold">สถานะสินค้า<a style="color:red;"> *</a></td>
                <td>
                <select
                    name="product_status"
                    required
                    value="<?php echo $row['product_status']; ?>"
                    style="
                        width: 95%;
                        padding: 8px;
                        margin: 10px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        box-sizing: border-box;
                        background-color: #EEEEEE;
                    "
                >
                    <option value="in_stock">มีสต็อกพร้อมส่ง</option>
                    <option value="out_of_stock">หมดสต็อกรอสินค้า</option>
                </select>
                </td>
            </tr>

            <tr>
                <td width="100px" style="padding: 5px; font-weight: bold">เปลี่ยนรูปภาพ</td>
                <td>
                    <input
                        type="file" name="image" id="image"
                        style="
                            width: 95%;
                            padding: 5px;
                            margin: 8px;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                            box-sizing: border-box;
                            background-color: #EEEEEE;
                        "
                    />
                    <?php
                        if (!empty($row['image_path'])) {
                            echo "<img src='" . $row['image_path'] . "' alt='Current Product Image' style='max-width: 100px;'>";
                        }
                    ?>
                    <!-- Add a hidden input to store the existing image path -->
                    <input type="hidden" name="old_image_path" value="<?php echo $row['image_path']; ?>">
                </td>
            </tr>
            </table>
            <br />
            <input
            type="submit"
            value="ยืนยัน"
            style="
                width: 150px;
                background-color: #472183;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            "
            />
            <input
            type="button"
            onclick="window.location.href='view_product.php'"
            value="ยกเลิก"
            style="
                width: 150px;
                background-color: #b06161;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            "
            />
        </form>
       <?php
            mysqli_close($conn);
            } else {
                echo "Error fetching product data";
            }
        ?>
    </center>
</body>

</html>
