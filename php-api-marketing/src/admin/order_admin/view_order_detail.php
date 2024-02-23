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
            width: 120%;
        }

        .order-details {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            max-width: 600px;
            margin: auto;
        }

        .order-section {
            margin-bottom: 20px;
        }

        .order-section h2 {
            border-bottom: 2px solid #0B60B0;
            padding-bottom: 5px;
        }

        .product-details {
            margin: 10px 0;
        }

         #orderButton {
            background-color: #C70039;
            color: white;
            padding: 5px;
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
            <a href="..\product_admin\view_product.php">จัดการสินค้า</a>
            <a href="view_order.php">จัดการออเดอร์</a>
            <a href="..\customer_admin\view_customer.php">จัดการลูกค้า</a>
            <a href="..\income_admin\revenue.php">รายรับ</a>
        </nav>
        <a class="login-btn"></a>
    </header>

        <div>
            <?php
            session_start();
           
            require_once ('../../../config/db/connection.php');
            require_once '../../customer/order/order_operator.php';

            $order_id=isset($_GET['order']) ? $_GET['order'] : '';
            $orders = orderDetail($order_id);

             echo "<br/>
                        <table border='0' style='width: 60%; border-collapse: collapse; margin: auto; padding-top: 5px; '>
                            <tr style='text-align: end;'>
                            <th width='200px;' style='padding: 10px; font-weight: normal;'>Export PDF:
                                <a href='export_pdf.php?order={$order_id}' style='padding-left:5px; display: inline-block; vertical-align: middle;'>
                                    <button id='orderButton' type='submit'>
                                        <img src='../../../public/pdf-50.png' width='30%' alt='pdf' style='vertical-align: middle;'>
                                        <span style='padding-top: 10px; font-weight: bold; text-align:center;'>PDF</span>
                                    </button>
                                </a>
                            </th>
                        </tr>
                          </table>
                        <table border='0' style='width: 60%; border-collapse: collapse; margin: auto; padding-top: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                            <tr style='background-color: #0A2647; color: white; text-align: center;'>
                                <th width='200px;' style='padding: 10px;' >ข้อมูลการสั่งซื้อ</th>
                            </tr>
                        </table>
                  ";

            if (!empty($orders)) {
                foreach ($orders as $row1) {
                    echo "
                        <table border='0' style='width :60%; border-collapse: collapse; margin: auto;'>
                            <tr>
                                <th width='50%;' style='padding: 10px;'><h2>ใบรายการการสั่งซื้อ</h2></th>
                                <th width='5%;' style='padding: 10px;'></th>
                                <th width='21%;' style='padding: 10px; text-align: start;'><a>Beluga Group (th) Co.,ltd <br><hr></a>
                                <a style='font-weight: normal;'>888, ถนนประชาสำราญ เขตหนองจอก กรุงเทพมหานคร <br> โทร 02-888-8888</a></th>
                            </tr>
                             <tr>
                                <th width='50%;' style='padding: 10px; text-align: start;'>
                                    <a style='font-weight: bold;'>ข้อมูลผู้ซื้อ <br></a>
                                    <br>
                                    <a>ชื่อผู้สั่ง : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style='font-weight: normal;'>{$row1['name_order']} </a><br></a>
                                    <a>ชื่อผู้รับ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style='font-weight: normal;'>{$row1['name_receive']} </a><br></a>
                                    <a>ชื่อผู้ส่ง : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style='font-weight: normal;'>{$row1['name_bill']} </a><br></a>
                                    <a>หมายเลขกำกับภาษี : <a style='font-weight: normal;'>{$row1['tax_no']} </a><br></a>
                                    <a>ที่อยู่จัดส่ง : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style='font-weight: normal;'>{$row1['address']} </a><br></a>
                                    <a>หมายเลขโทรศัพท์ : &nbsp;&nbsp;<a style='font-weight: normal;'>{$row1['tel']} </a><br></a>
                                </th>

                                <th width='5%;' style='padding: 10px;'></th>

                                <th width='21%;' style='padding: 10px; text-align: start;'>
                                    <br><br><br><br><br><br>
                                    <a>วันที่สั่ง : <a style='font-weight: normal;'>{$row1['order_date']}</a><br></a>
                                    <a>วันที่ส่ง : <a style='font-weight: normal;'>{$row1['shipping_date']}</a><br></a>
                                    <a>วันที่รับ : <a style='font-weight: normal;'>{$row1['receive_date']}</a><br></a>
                                </th>
                            </tr>
                        </table>

                        <hr width= '60%;' />

                        <table border='0' style='width :60%; border-collapse: collapse; margin: auto;'>
                            <tr>
                                <th width='60%;' style='padding: 10px; text-align: start;'><a style='font-weight: bold;'>รายการที่สั่งซื้อ</a></th>
                                <th width='8%;' style='padding: 10px; text-align: center;'><a style='font-weight: bold;'>จำนวน</a></th> 
                                <th width='13%;' style='padding: 10px; text-align: center;'><a style='font-weight: bold;'>ราคาต่อหน่วย</a></th>
                                <th width='10%;' style='padding: 10px; text-align: center;'><a style='font-weight: bold;'>ราคารวม</a></th>
                            </tr>";

                        $sql = "SELECT d.id, d.order_id, d.amount, d.total_price,p.product_name, p.product_price
                                FROM detail d
                                INNER JOIN products p ON d.product_id = p.product_id
                                WHERE d.order_id = ?
                                ORDER BY d.id
                                ";
                                

                        $stmt = $conn->prepare($sql);

                        if (!$stmt) {
                            die("Error in SQL query preparation: " . $conn->error);
                        }

                        $stmt->bind_param("s", $order_id);
                            // Execute the statement
                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                $line = 0;
                                
                                while ($row = $result->fetch_assoc()) {   
                                    $id = $row['id'];
                                    $name1 = $row['product_name'];
                                    $name2 = $row['amount'];
                                    $name3 = $row['product_price'];
                                    $name4 = $row['total_price'];
                                    $line++;
                            
                                    echo "<tr>
                                            <th width='60%;' style='padding: 10px; text-align: start;'><a style='font-weight: normal;'>$line . $name1</a></th>
                                            <th width='8%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal;'>$name2</a></th> 
                                            <th width='13%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal;'>$name3</a></th>
                                            <th width='10%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal; '>$name4</a></th>
                                        </tr>";
                                }
                                 $stmt->close();
                            } else {
                                die("Error executing SQL query: " . $stmt->error);
                            }

                                    echo "<tr>
                                            <th width='60%;' style='padding: 10px; text-align: start;'><a style='font-weight: normal;'>vat</a></th>
                                            <th width='8%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal;'></a></th> 
                                            <th width='13%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal;'></a></th>
                                            <th width='10%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal; '>7%</a></th>
                                        </tr>";
                                    echo "<tr>
                                            <th width='60%;' style='padding: 10px; text-align: start;'><a style='font-weight: normal;'>shipping cost</a></th>
                                            <th width='8%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal;'></a></th> 
                                            <th width='13%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal;'></a></th>
                                            <th width='10%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal; '>{$row1['shipping_cost']}</a></th>
                                        </tr>";
                            echo "</table>";
                           

                           
            
             echo "
                    <table border='1' style='width :60%; border-collapse: collapse; margin: auto;'>
                        <tr>
                            <th width='60%;' style='padding: 10px; text-align: start; '>จำนวนรวมทั้งสิ้น</th>
                            <th width='20%;' style='padding: 10px; text-align: center; font-weight: normal;'>{$row1['amount']} รายการ</th>
                            <th width='20%;' style='padding: 10px; text-align: end; font-weight: normal;'>{$row1['total_price']} บาท</th>
                        </tr>
                    </table>";
            }

        } 
    ?>
    </div>

    <footer>
        &copy; 2024 Beluga Phone Phone Shop. All rights reserved.
    </footer>
</body>

</html>
