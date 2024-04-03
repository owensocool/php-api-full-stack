<?php
// Database connection
require_once '../../../config/db/connection.php';
require_once '../log/access_log.php';


// Query to retrieve revenue data from the database
$sql = "SELECT order_id, amount, total_price, order_date FROM orders";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Calculate the sum of total prices
$totalPriceSum = 0;
while ($row = $result->fetch_assoc()) {
    $totalPriceSum += $row['total_price'];
}

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="revenue_data.xls"');

// Output Excel file content
echo "Order ID\tAmount\tTotal Price\tOrder Date\n";
$result->data_seek(0); // Reset result pointer to the beginning
while ($row = $result->fetch_assoc()) {
    echo "{$row['order_id']}\t{$row['amount']}\t{$row['total_price']}\t{$row['order_date']}\n";
}
// Include the sum in the last row of the Excel file
echo "\n\tTotal Revenue\t{$totalPriceSum}\n";

// Close the database connection
$stmt->close();
$conn->close();
?>
