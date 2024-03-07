<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags, title, and styles -->
</head>
<body>

    <header>
        <!-- Logo and navigation links -->
        
        <a href="../../auth/controller/logout.php"><button class="login-btn">ออกจากระบบ</button></a>

        <!-- Add the button here -->
        <a href="add_order.php"><button class="login-btn">+ เพิ่มออเดอร์ใหม่</button></a>
    </header>

    <div>
        <?php
            require_once '../../../config/db/connection.php';

            // Retrieve sales orders data from the database
            $query = "SELECT * FROM orders";
            $result = $conn->query($query);

            if ($result) {
                echo "<h2>รายงานสรุปการขาย</h2>";

                // Display sales orders in a table
                echo "<table border='1'>
                        <tr>
                            <th>รหัสออเดอร์</th>
                            <th>ชื่อลูกค้า</th>
                            <th>จำนวนสินค้า</th>
                            <th>ราคารวม</th>
                            <th>วันที่สั่ง</th>
                            <th>สถานะ</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['name_order'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['total_price'] . "</td>";
                    echo "<td>" . $row['order_date'] . "</td>";
                    echo "<td>" . $row['order_status'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";

                $result->free();
            } else {
                echo "Error: " . $conn->error;
            }

            $conn->close();
        ?>
    </div>
    
    <!-- JavaScript code -->
</body>
</html>
