<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beluga Phone Phone Shop</title>
    <style>
        body {
          background: linear-gradient(to right, #0B60B0, #B4BDFF, #86B6F6);
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background: linear-gradient(to right, #0B60B0, #B4BDFF, #86B6F6);
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

        main {
            padding-left: 40px;
            padding-right: 40px;
            padding-top: 10px;            
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
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

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .customer-link {
            background-color: #265073;
            color: #fff;
            padding: 15px 20px;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            margin-right: 10px;
        }
        .admin-link {
            background-color: #1B4242;
            color: #fff;
            padding: 15px 20px;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 10px;
        }
    </style>
</head>
<body>

    <header>
       <div class="logo"><img src="./public/beluga_logo1.png" alt="Logo"> <a>Beluga Phone Shop</a></div>
        <?php
            if(isset($_SESSION['user_id'])) {
                echo '<a href="./src/auth/controller/logout.php"><button class="login-btn">ออกจากระบบ</button></a>';
            } else {
                echo '<a href="./src/auth/view/signIn.html"><button class="login-btn">เข้าสู่ระบบ</button></a>';
            }
        ?>
    </header>

    <main>
        <img src="./public/beluga_cover.jpg"/>
    </main>


    <div class="button-container">
        <?php
        if(isset($_SESSION['user_id'])) {
            // If user is logged in, check their role
            if(isset($_SESSION['role'])) {
                $userRole = $_SESSION['role'];
                if($userRole == 'admin') {
                    // header("Location: ./src/admin/product_admin/view_product.php ");
                    // exit();
                    echo '<a href="./src/admin/product_admin/view_product.php" class="admin-link">หน้าแอดมิน</a>';
                } else {
                    echo '<a href="./src/customer/controller/product_list.php" class="customer-link">หน้าลูกค้า</a>';
                }
            } else {
                echo '<a href="./src/customer/controller/product_list.php" class="customer-link">หน้าลูกค้า</a>';
            }
        }
        ?> 
    </div>

    <footer>
        &copy; 2024 Beluga Phone Phone Shop. All rights reserved.
    </footer>

</body>
</html>
