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
           <a href="../home/index.php">หน้าหลัก</a>
            <a href="../controller/cart.php">ตะกร้า</a>
            <a href="search_order.php">ค้นหา Order</a>
        </nav>
        <a class="login-btn"></a>
    </header>

        <div>
            <?php
            session_start();

            // if (!isset($_SESSION['user_id'])) {
            //     header("Location: ../../auth/view/signIn.html");
            //     exit();
            // }

            $user_id = $_SESSION['user_id'];
            $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
           
            require_once '../../../config/db/connection.php';
            require_once '../order/order_operator.php';

            echo "<br/> <br/>
                    <table border='0' style='width: 90%; margin: auto;'>
                         <tr>
                            <td width='950px'><a style='font-weight:bold; font-size: 22px;' > 
                            <form method='GET' action='search_order.php'>
                                <label for='order_id'>ค้นหาเลขออเดอร์ : </label>
                                <input type='text' id='order_id' name='order_id'>
                                <button type='submit'>ค้นหา</button>
                            </form>
                            </a></td>
                        </tr>

                    </table>
                    <br />";
            
            if($order_id){
                $orders= orderList($order_id);
                if($orders){
                    echo "<table border='0' style='width: 90%; border-collapse: collapse; margin: auto; padding-top: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                        <tr style='background-color: #0A2647; color: white; text-align: center;'>
                            <th width='200px' style='padding: 10px;' >รหัสออเดอร์</th>
                            <th width='300px' style='padding: 10px;'>ชื่อผู้รับ</th>
                            <th width='300px' style='padding: 10px;'>ที่อยู่จัดส่ง</th>
                            <th width='150px' style='padding: 10px;'>เบอร์โทรศัพท์</th>
                            <th width='80px' style='padding: 10px;'>จำนวน</th>
                            <th width='180px' style='padding: 10px;'>ราคารวม</th>
                            <th width='200px' style='padding: 10px;'>สถานะ</th>
                            <th width='200px' style='padding: 10px;'>วันที่สั่ง</th>
                            <th width='150px' style='padding: 10px;'>วันที่ส่ง</th>            
                        </tr>";
                    foreach ($orders as $row) {
                        $name1 = $row['order_id'];
                        $name2 = $row['customer_id'];
                        $name3 = $row['name_receive'];
                        $name4 = $row['address'];
                        $name5 = $row['tel'];
                        $name6 = $row['amount'];
                        $name7 = $row['total_price'];
                        $name8 = $row['order_status'];
                        $name9 = $row['order_date'];
                        $name10 = $row['shipping_date'];
                
                    echo "<tr onclick='redirectToEditPage(\"$name1\")'>
                            <td style='padding: 10px; cursor: pointer; text-align:center;'>$name1</td>
                            <td style='padding: 10px; cursor: pointer; text-align:center;'>$name3</td>
                            <td style='padding: 10px; cursor: pointer; text-align:center;'>$name4</td>
                            <td style='padding: 10px; cursor: pointer; text-align:center;'>$name5</td>
                            <td style='padding: 10px; cursor: pointer; text-align:center;'>$name6</td>
                            <td style='padding: 10px; cursor: pointer; text-align:center;'>$name7</td>
                            <td style='padding: 10px; cursor: pointer; text-align:center;'>$name8</td>
                            <td style='padding: 10px; cursor: pointer; text-align:center;'>$name9</td>
                            <td style='padding: 10px; cursor: pointer; text-align:center;'>$name10</td>
                        </tr>";
                }
                echo "</table>";
        } else {
            echo "<table border='0' style='width: 90%; border-collapse: collapse; margin: auto; padding-top: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                        <tr style='background-color: #0A2647; color: white; text-align: center;'>
                            <th width='200px' style='padding: 10px;' >รหัสออเดอร์</th>
                            <th width='300px' style='padding: 10px;'>ชื่อผู้รับ</th>
                            <th width='300px' style='padding: 10px;'>ที่อยู่จัดส่ง</th>
                            <th width='150px' style='padding: 10px;'>เบอร์โทรศัพท์</th>
                            <th width='80px' style='padding: 10px;'>จำนวน</th>
                            <th width='180px' style='padding: 10px;'>ราคารวม</th>
                            <th width='200px' style='padding: 10px;'>สถานะ</th>
                            <th width='200px' style='padding: 10px;'>วันที่สั่ง</th>
                            <th width='150px' style='padding: 10px;'>วันที่ส่ง</th>            
                        </tr></table>
                   
                <center><p>ไม่พบรายการที่สั่งซื้อ</p></center>";
        }
    }

    ?>
    </div>

     <footer>
        &copy; 2024 Beluga Phone Phone Shop. All rights reserved.
    </footer>
    <script>
        function redirectToEditPage(orderId) {
            window.location.href = 'order_detail.php?order=' + orderId;
        }
    </script>

</body>
</html>
