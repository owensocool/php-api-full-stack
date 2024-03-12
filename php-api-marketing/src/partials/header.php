<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beluga Phone Phone Shop</title>
    <link rel="stylesheet" href="./../../public/style/styles.css">
</head>
<body>
<header>
    <div class="logo"><img src="../../public/beluga_logo1.png" alt="Logo"> <a>Beluga Phone Shop</a></div>
    <?php
        session_start();
            if(isset($_SESSION['user_id'])) {
                if(isset($_SESSION['role'])) { 
                    $userRole = $_SESSION['role'];
                    if($userRole == 'admin') {
                        echo '
                        <nav>
                            <a href="../home/index.php">หน้าหลัก</a>
                            <a href="../admin/product_admin/product_view/view_product.php">จัดการสินค้า</a>
                            <a href="../admin/order_admin/order_view/view_order.php">จัดการออเดอร์</a>
                            <a href="../admin/customer_admin/customer_view/view_customer.php">จัดการลูกค้า</a>
                            <a href="../admin/income_admin/revenue.php">รายรับ</a>
                        </nav>
                        <div></div>
                        <a href="../auth/controller/logout.php"><button class="login-btn">ออกจากระบบ</button></a>';
                    }
                } 
            } 
            
            if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 'guess' ){    
                echo '<nav>
                        <a href="../home/index.php">หน้าหลัก</a>
                        <a href="../customer/cart/cart_view/cart.php">ตะกร้า</a>
                        <a href="../customer/order/order_view/search_order.php">ค้นหา Order</a>
                    </nav>
                    <div class="login-btn1"></div>
                    <a></a>
                <a href="../../src/auth/view/signIn.html"><button class="login-btn">เข้าสู่ระบบ</button></a>';
            }
        ?>
        
    </header>
</body>
</html>
