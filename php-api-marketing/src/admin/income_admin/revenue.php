<?php
// Database connection
require_once '../../../config/db/connection.php';

// Default date range: past month
$currentDate = date('Y-m-d');
$oneMonthAgo = date('Y-m-d', strtotime('-1 month', strtotime($currentDate)));

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get start and end dates from the form
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // SQL query with date range condition
    $sql = "SELECT order_id, amount, total_price, order_date FROM orders WHERE order_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize total revenue
    $totalRevenue = 0;

} else {
    // If form is not submitted, use default date range (past month)
    $sql = "SELECT order_id, amount, total_price, order_date FROM orders WHERE order_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $oneMonthAgo, $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize total revenue
    $totalRevenue = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .total-row td {
            text-align: right;
            font-weight: bold;
        }
        .export-form {
            text-align: center;
            margin-top: 20px;
        }
        .export-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .export-btn:hover {
            background-color: #45a049;
        }
        .date-form {
            text-align: center;
            margin-bottom: 20px;
        }
        .date-form input[type="date"] {
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .date-form input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .date-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Revenue Report</h2>

    <!-- Date selection form -->
    <form class="date-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo $oneMonthAgo; ?>" required>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo $currentDate; ?>" required>
        <input type="submit" value="Submit">
    </form>

    <table>
        <tr>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Amount</th>
            <th>Total Price</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['order_date']; ?></td>
            <td><?php echo $row['amount']; ?></td>
            <td><?php echo $row['total_price']; ?></td>
            <?php 
                // Accumulate total revenue
                $totalRevenue += $row['total_price'];
            ?>
        </tr>
        <?php endwhile; ?>
        <!-- Display total revenue in the last row -->
        <tr class="total-row">
            <td colspan="3">Total Revenue:</td>
            <td><?php echo $totalRevenue; ?></td>
        </tr>
    </table>
    
    <!-- Form to submit data for Excel export -->
    <form class="export-form" action="export_excel.php" method="post">
    <!-- Include hidden input fields for start date and end date -->
    <input type="hidden" name="start_date" value="<?php echo $startDate; ?>">
    <input type="hidden" name="end_date" value="<?php echo $endDate; ?>">
    <input class="export-btn" type="submit" name="export_excel" value="Export to Excel">
    </form>
</body>
</html>

<?php
// Close the statement and the database connection
$stmt->close();
$conn->close();
?>