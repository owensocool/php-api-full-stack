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
            display:none;
        }

        header {
            background: linear-gradient(to right, #0A2647, #144272, #205295);
            width: 100%;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center; 
            position: fixed;
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
            width: 120%;
        }

        .status-dropdown {
            padding: 2px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-size: 12px;
            width: 100%;
            max-width: 200px; /* Adjust max-width as needed */
        }

        /* Style for option elements */
        .status-dropdown option {
            background-color: #fff;
            color: #333;
        }

        /* Hover effect for option elements */
        .status-dropdown option:hover {
            background-color: #ddd;
            color: #333;
        }

        /* Style for modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        /* Modal content */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            position: relative;
        }

        /* Close button */
        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 30px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Modal image */
        .modal-content img {
            width: 100%;
            height: auto;
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
    
    <br/> <br/><br/> <br/><br/>
    <div style="text-align: center;">
    <form id="dateForm" method="GET">
        <label for="selected_date">Select Date:</label>
        <input type="date" id="selected_date" name="selected_date" value="<?php echo isset($_GET['selected_date']) ? htmlspecialchars($_GET['selected_date']) : date('Y-m-d'); ?>">
        <button type="submit">View Orders</button>
    </form>
</div>
<br/>
<!-- Add the search inputs here -->
<div style="text-align: center;">
        <form id="searchForm" method="GET">
            <label for="search_query">Search by Order ID or Customer ID:</label>
            <input type="text" id="search_query" name="search_query" placeholder="Enter Order ID or Customer ID">
            <button type="submit">Search</button>
        </form>
    </div>

    <div>
        <?php
        require_once '../../../../config/db/connection.php';
        if(isset($_GET['selected_date'])) {
            $selected_date = $_GET['selected_date'];
            $query = "SELECT * FROM orders WHERE DATE(order_date) = '$selected_date'";
        } else {
            $query = "SELECT * FROM orders";
        }
        $result = $conn->query($query);
        

    // Define the number of transactions per page
    $transactionsPerPage = 10;

    // Get the current page number, default to 1 if not set
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Calculate the offset for the SQL query
    $offset = ($page - 1) * $transactionsPerPage;

    // Initialize $totalPages
    $totalPages = 10;

    // Check if search query by order ID or customer ID is provided
    if(isset($_GET['search_query'])) {
        $search_query = $_GET['search_query'];

        // Query to select transactions for the specified order ID or customer ID
        $query = "SELECT * FROM orders WHERE order_id = '$search_query' OR customer_id = '$search_query' LIMIT $offset, $transactionsPerPage";
    } else if(isset($_GET['selected_date'])) {
        $selected_date = $_GET['selected_date'];

        // Query to select orders for the selected date
        $query = "SELECT * FROM orders WHERE DATE(order_date) = '$selected_date' LIMIT $offset, $transactionsPerPage";
    } else {
        // Default query to select all orders with pagination
        $query = "SELECT * FROM orders LIMIT $offset, $transactionsPerPage";
    }

    // Execute the query
    $result = $conn->query($query);

    if ($result) {
        echo "
        <table border='0' style='width: 90%; margin: auto;'>
            <tr>
                <td width='950px'><a style='font-weight:bold; font-size: 22px;'>รายการออเดอร์</a></td>
            </tr>
        </table>
        <br />";

        echo "<table border='0' style='width: 90%; border-collapse: collapse; margin: auto; padding-top: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
            <tr style='background-color: #86B6F6; color: white; text-align: center;'>
                <th width='30px' style='padding: 10px;'>V</th>
                <th width='180px' style='padding: 10px;'>รหัสออเดอร์</th>
                <th width='180px' style='padding: 10px;'>รหัสลูกค้า</th>
                <th width='200px' style='padding: 10px;'>ชื่อลูกค้า</th>
                <th width='250px' style='padding: 10px;'>ที่อยู่</th>
                <th width='250px' style='padding: 10px;'>email</th>
                <th width='200px' style='padding: 10px;'>เบอร์</th>
                <th width='100px' style='padding: 10px;'>จำนวน</th>
                <th width='180px' style='padding: 10px;'>ราคารวม</th>
                <th width='200px' style='padding: 10px;'>วันที่สั่ง</th>
                <th width='150px' style='padding: 10px;'>วันที่ส่ง</th>
                <th width='100px' style='padding: 10px;'>สลิป</th>
                <th width='300px' style='padding: 10px;'>สถานะ</th>
                <th width='50px' style='padding: 10px;'>U</th>
                <th width='50px' style='padding: 10px;'>D</th>
            </tr>";

        // Loop through the results and display transaction details
        while ($row = $result->fetch_assoc()) {
            // Extract transaction details
            $name1 = $row['order_id'];
            $name2 = $row['customer_id'];
            $name3 = $row['name_order'];
            $name4 = $row['address'];
            $name11 = $row['email'];
            $name5 = $row['tel'];
            $name6 = $row['amount'];
            $name7 = $row['total_price'];
            $name8 = $row['order_status'];
            $name9 = $row['order_date'];
            $name10 = $row['shipping_date'];
            $name12 = $row['image_path'];

            // Display transaction details in table rows
            echo "<tr>
             <td style='padding: 5px; cursor: pointer; text-align:center;'>
                            <form method='get' action='view_order_detail.php'>
                                <input type='hidden' name='order' value='$name1'>
                                <button type='submit' class='edit-btn'>
                                    <img src='../../../../public/eye-48.png' alt='Edit'>
                                </button>
                            </form></td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>$name1</td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>$name2</td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>$name3</td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>$name4</td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>$name11</td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>$name5</td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>$name6</td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>$name7</td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>$name9</td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>$name10</td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>
                    <div class='img-modal'>
                        <img src='../../../../public/product/$name12' alt='Image' style='max-width: 100%; max-height: 100px;'>
                    </div>
                </td>
                <td style='padding: 10px; cursor: pointer; text-align:center;'>";

            if ($name8 == 'Cancel') {
                echo "<span style='color: red;'>Cancel</span>";
            } else {
                echo "<select class='status-dropdown' onchange='updateOrderStatus(this.value, \"$name1\")'>
                    <option value='Order' " . ($name8 == 'Order' ? 'selected' : '') . ">Order</option>
                    <option value='Processing' " . ($name8 == 'Processing' ? 'selected' : '') . ">Processing</option>
                    <option value='Shipped' " . ($name8 == 'Shipped' ? 'selected' : '') . ">Shipped</option>
                    <option value='Delivered' " . ($name8 == 'Delivered' ? 'selected' : '') . ">Delivered</option>
                </select>";
            }

            
            echo "</td>
                <td>
                    <form method='post' action='edit_order.php'>
                        <input type='hidden' name='order_id' value='$name1'>
                        <button type='submit' class='edit-btn'>
                            <img src='../../../../public/edit-48.png' alt='Edit'>
                        </button>
                    </form>
                </td>
                <td>
                    <form id='cancelForm_$name1' method='post' action='change_status.php'>
                        <input type='hidden' name='orderId' value='$name1'>
                        <input type='hidden' name='status' value='Cancel'>
                        <button type='button' class='delete-btn' onclick='confirmCancel(\"$name1\")'>
                            <img src='../../../../public/cancel-48.png' alt='Delete'>
                        </button>
                    </form>
                </td>
            </tr>";
        }
        echo "</table>";

        // Free result set
        $result->free();

        // Display pagination links
        echo "<div style='text-align: center; margin-top: 20px;'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                echo "<span>$i</span> ";
            } else {
                echo "<a href='view_order.php?page=$i'>$i</a> ";
            }
        }
        echo "</div><br/><br/>";
    } else {
        echo "Error: " . $conn->error;
    }
    ?>
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
    </div>
</div>

    <script>
        var modal = document.getElementById("myModal");
        var modalImg = document.getElementById("img01");
        var images = document.querySelectorAll(".img-modal");

        images.forEach(function(image) {
            image.onclick = function() {
                modal.style.display = "block";
                modalImg.src = this.querySelector('img').src;
            }
        });

        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function updateOrderStatus(status, orderId) {
            $.ajax({
                        type: 'POST',
                        url: './change_status.php',
                        data: {
                            status: status,
                            orderId: orderId
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
            }

             function confirmCancel(orderId) {
                    // Display a confirmation dialog
                    var confirmation = confirm("คุณต้องการยกเลิกรายการนี้หรือไม่?");

                    if (confirmation) {
                        document.getElementById('cancelForm_' + orderId).submit();
                    }
                }
    </script>

</body>
</html>