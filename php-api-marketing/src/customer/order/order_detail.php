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
            <a href="../home/index.php">หน้าหลัก</a>
            <a href="../controller/cart.php">ตะกร้า</a>
            <a href="../order/search_order.php">ค้นหา Order</a>
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
                            <th style='padding: 10px; text-align: start;'>หมายเลขคำสั่งซื้อ : {$order_id} </th>
                            <th width='200px;' style='padding: 10px; font-weight: normal;'>
                                Export PDF:<a href='../../admin/order_admin/export_pdf.php?order={$order_id}' style='padding-left:5px; display: inline-block; vertical-align: middle;'>
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
                                <th width='20%;' style='padding: 10px; text-align: left;'><h2>ใบเสร็จรับเงิน</h2></th>
                                
                                <th width='5%;' style='padding: 10px;'></th>
                            </tr>
  
                             <tr>
                                
                                <th width='50%;' style='padding: 10px; text-align: start;'>
            
                                    <br>
                                    <a>ชื่อผู้สั่ง / customer  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style='font-weight: normal;'>{$row1['name_order']} </a><br></a>
                                    <a>ชื่อผู้รับ   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style='font-weight: normal;'>{$row1['name_receive']} </a><br></a>
                                    <a>ที่อยู่ / Address  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style='font-weight: normal;'>{$row1['address']} </a><br></a>
                                    <a>เลขผู้เสียภาษี / TAX ID : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style='font-weight: normal;'>{$row1['tax_no']} E: </a><br></a>
                                    <a>ชื่อผู้ส่ง / Attention  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style='font-weight: normal;'>{$row1['name_bill']}  T: {$row1['tel']} </a><br></a>
                                    
                                    <hr width= '111%;' />

                                    <a>ผู้ออก : &nbsp;<a width='21%;' style='padding: 10px; text-align: start;'><a>Beluga Group (th) Co.,ltd </a><br></a>
                                    <a style='font-weight: normal;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;888, ถนนประชาสำราญ เขตหนองจอก กรุงเทพมหานคร <br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; โทร 02-888-8888</a></th>
                                </th>

                                <th width='20%;' style='padding: 10px; text-align: start; position: absolute; top: 200px; right: 235px;'>
                                    <a>เลขคำสั่งซื้อ : <a style='font-weight: normal; '>{$row1['order_id']}</a><br></a>
                                    <a>วันที่สั่ง : <a style='font-weight: normal;'>{$row1['order_date']}</a><br></a>
                                    
                                </th>

                                <th width='30%;' style='padding: 10px; text-align: start; position: absolute; top: 405px; right: 230px;'>
                                    <a><a style='font-weight: normal;'>เลขผู้เสียภาษี / TAX ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1552515</a><br></a>
                                    <a><a style='font-weight: normal;'>จัดเตรียมโดย / Prepared by &nbsp;&nbsp;&nbsp;Nattakrit Klindokkeaw</a><br></a>
                                    <a><a style='font-weight: normal;'>T:25 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; E: 63050121@kmitl.ac.th</a><br></a>
                                    <a><a style='font-weight: normal;'>W: https://owen.com</a><br></a>
                                </th>

                            </tr>
                        </table>

                        <hr width= '60%;' />

                        <table border='0' style='width :60%; border-collapse: collapse; margin: auto;'>
                            <tr>
                                <th width='60%;' style='padding: 10px; text-align: start;'><a style='font-weight: bold;'>รายการที่สั่งซื้อ</a></th>
                                <th width='8%;' style='padding: 10px; text-align: center;'><a style='font-weight: bold;'>จำนวน</a></th> 
                                <th width='13%;' style='padding: 10px; text-align: center;'><a style='font-weight: bold;'>ราคาต่อหน่วย</a></th>
                                <th width='13%;' style='padding: 10px; text-align: center;'><a style='font-weight: bold;'>ภาษี</a></th>
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
                                            <th width='13%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal;'>7%</a></th>
                                            <th width='10%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal; '>$name4</a></th>
                                        </tr>";
                                }
                                 $stmt->close();
                            } else {
                                die("Error executing SQL query: " . $stmt->error);
                            }

                                    
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
                            <th width='60%;' style='padding: 10px; text-align: start; '>ราคาสุทธิสินค้าที่เสียภาษี</th>
                            <th width='20%;' style='padding: 10px; text-align: center; font-weight: normal;'>$name3 บาท</th>
                    
                        </tr>
                        <tr>
                            <th width='60%;' style='padding: 10px; text-align: start; '>ภาษีมูลค่าเพิ่ม(บาท)/VAT</th>
                        </tr>
                        <tr>
                            <th width='60%;' style='padding: 10px; text-align: start; '>จำนวนรวมทั้งสิ้น</th>
                            <th width='20%;' style='padding: 10px; text-align: center; font-weight: normal;'>$name4 บาท</th>
                        </tr>
                    </table>";
            }

        } 
        
    ?>
    </div>

    <!-- <footer>
        &copy; 2024 Beluga Phone Phone Shop. All rights reserved.
    </footer> -->
</body>

</html>
