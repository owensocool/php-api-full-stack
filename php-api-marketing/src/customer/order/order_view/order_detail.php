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
        .submit-button {
            width: 100px;
            background-color: #65B741;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px; /* Add margin for spacing */
        }

    </style>
</head>
<body>

    <header>
        <div class="logo"><img src="../../../../public/beluga_logo1.png" alt="Logo"> <a>Beluga Phone Shop</a></div>
        <nav>
            <a href="../../../home/index.php">หน้าหลัก</a>
            <a href="../../cart/cart_view/cart.php">ตะกร้า</a>
            <a href="../../order/order_view">ค้นหา Order</a>
        </nav>
        <a class="login-btn"></a>
    </header>

        <div>
            <?php
            session_start();
           
            require_once ('../../../../config/db/connection.php');
            require_once '../../../customer/order/order_controller/order_operator.php';

            $order_id=isset($_GET['order']) ? $_GET['order'] : '';
            $orders = orderDetail($order_id);

            if (!empty($orders)) {
                foreach ($orders as $row1) {
            echo "<br/>
                        <table border='0' style='width: 40%; border-collapse: collapse; margin: auto; padding-top: 5px; '>
                            <tr style='text-align: end;'>
                            <th style='padding: 10px; text-align: start;'>หมายเลขคำสั่งซื้อ : {$order_id} </th>
                            
                            ";
            if ( $row1['order_status'] == 'Order' ||$row1['order_status'] == 'Reject'){  
                echo "<th width='200px;' style='padding: 10px; font-weight: normal;'></th>";
            
                }
            else {
                echo"
                    <th width='200px;' style='padding: 10px; font-weight: normal;'>
                            Export PDF:<a href='../../../admin/order_admin/invoice/export_pdf.php?order={$order_id}' style='padding-left:5px; display: inline-block; vertical-align: middle;'>
                                    <button id='orderButton' type='submit'>
                                        <img src='../../../../public/pdf-50.png' width='30%' alt='pdf' style='vertical-align: middle;'>
                                        <span style='padding-top: 10px; font-weight: bold; text-align:center;'>PDF</span>
                                    </button>
                                </a>
                    </th>
                    ";
            }         
            echo "  </tr></table>      
                        <table border='0' style='width: 40%; border-collapse: collapse; margin: auto; padding-top: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                            <tr style='background-color: #0A2647; color: white; text-align: center;'>
                                <th width='200px;' style='padding: 10px;' >ข้อมูลการสั่งซื้อ</th>
                            </tr>
                        </table>
                  ";

            // if (!empty($orders)) {
            //     foreach ($orders as $row1) {
                    echo "
                        <table border='0' style='width :40%; border-collapse: collapse; margin: auto;'>

                        <tr>
                            <th width='60%;' style='padding: 10px; text-align: start;'>
                            </th>
                            <th width='60%;' style='padding: 10px; text-align: right;'>
                                <a style='font-weight: bold;'>สถานะออเดอร์ : {$row1['order_status']} </a>
                            </th>
                            
                        </tr>
                        <tr>
                            <th width='60%;' style='padding: 10px; text-align: start;'>
                                <a style='font-weight: bold; padding: 10px;'>ชื่อผู้สั่ง : </a> <a style='font-weight: normal;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$row1['name_order']}</a><br/>
                                <a style='font-weight: bold; padding: 10px;'>ชื่อผู้รับ : </a> <a style='font-weight: normal;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$row1['name_receive']}</a><br/>
                                <a style='font-weight: bold; padding: 10px;'>Email :  </a> <a style='font-weight: normal;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$row1['email']}</a><br/>
                                <a style='font-weight: bold; padding: 10px;'>ที่อยู่ : </a> <a style='font-weight: normal;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$row1['address']}</a><br/>
                                <a style='font-weight: bold; padding: 10px;'>ชื่อออกบิล : </a> <a style='font-weight: normal;'>  &nbsp;1{$row1['name_bill']}</a><br/>
                                <a style='font-weight: bold; padding: 10px;'>เลขผู้เสียภาษี:</a><a style='font-weight: normal;'>{$row1['tax_no']}</a><br/>
                            </th>
                        </tr>
                             
                        </table>

                        <hr width= '40%;' />

                        <table border='0' style='width :40%; border-collapse: collapse; margin: auto;'>
                            <tr>
                                <th width='20%;' style='padding: 10px; text-align: start;'><a style='font-weight: bold;'>รายการที่สั่งซื้อ</a></th>
                                <th width='8%;' style='padding: 10px; text-align: center;'><a style='font-weight: bold;'>จำนวน</a></th> 
                                <th width='13%;' style='padding: 10px; text-align: center;'><a style='font-weight: bold;'>ราคาต่อหน่วย</a></th>
                                <th width='13%;' style='padding: 10px; text-align: center;'><a style='font-weight: bold;'>ภาษี</a></th>
                                <th width='10%;' style='padding: 10px; text-align: center;'><a style='font-weight: bold;'>ราคารวม</a></th>
                            </tr>
                            ";

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
                                            <th width='30%;' style='padding: 10px; text-align: start;'><a style='font-weight: normal;'>$line . $name1</a></th>
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

                                    
                                    echo "
                                    <tr>
                                            <th width='30%;' style='padding: 10px; text-align: start;'><a style='font-weight: normal;'>shipping cost</a></th>
                                            <th width='8%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal;'></a></th> 
                                            <th width='13%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal;'></a></th>
                                            <th width='13%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal;'></a></th>
                                            <th width='10%;' style='padding: 10px; text-align: center;'><a style='font-weight:normal; '>{$row1['shipping_cost']}</a></th>
                                        </tr>";
                            echo "</table>";
                           
             echo " <hr width= '40%;' />
                    <table border='0' style='width :40%; border-collapse: collapse; margin: auto;'>
                        <tr>
                            <th width='40%;' style='padding: 10px; text-align: start; '>ราคาสุทธิสินค้าที่เสียภาษี</th>
                            <th width='10%;' style='padding: 10px; text-align: right; font-weight: normal;'>{$row1['total_price']} บาท</th>
                    
                        </tr>
                        <tr>
                            <th width='40%;' style='padding: 10px; text-align: start; '>ภาษีมูลค่าเพิ่ม(บาท)/VAT</th>
                        </tr>
                        <tr>
                            <th width='40%;' style='padding: 10px; text-align: start; '>จำนวนรวมทั้งสิ้น</th>
                            <th width='40%;' style='padding: 10px; text-align: right; font-weight: normal;'>{$row1['total_price']} บาท</th>
                        </tr>
                    </table>";

                if($row1['order_status'] == 'Reject'){
                    echo "
                    <br/>
                    <table border='1' style='width :40%; border-collapse: collapse; margin: auto; padding-top:30px;'>
                        <tr>
                            <th width='40%;' style='padding: 10px; text-align: start; '>**เนื่องจากสลิปไม่ถูกต้อง กรุณาดำเนินการอัพโหลดใหม่ภายใน 3 วัน หรือ หากยังไม่ทำการชำระเงินให้รีบดำเนินการ**</th>
                        </tr>
                        <tr>
                            <th style='width:'10%;' padding:2px; items-align:left;'>
                                <img src='../../../../public/qr.jpg' alt='QR Image' width='50%'>
                            </th>
                            <th style='width:1%; padding: 10px; text-align:left; '>
                                <form method='post' action='../order_controller/upload_slip.php' name='customerForm' enctype='multipart/form-data'>
                                    <input type='hidden' name='order_id' value={$order_id}>
                                    <input type='file' id='image' name='image' accept='image/*' required>
                                    <input type='submit' value='Upload' class='submit-button'>
                                </form>
                            </th>
                            <th style='width:20%; padding: 2px; text-align:center;'>
                                <div id='imagePreview' style='display:none; align-items: start;'>
                                <img id='previewImage' src='#' alt='Preview Image' style='max-width: 150px; max-height: 150px;'>
                         </div>
                        </th>

                        </tr>
                    </table>";
                }
            }
        } 
        else{
            echo "<center><p>ไม่หลายเลขออเดอร์นี้</p></center>";
        }
        
    ?>
    </div>
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

    <!-- <footer>
        &copy; 2024 Beluga Phone Phone Shop. All rights reserved.
    </footer> -->
</body>

</html>
