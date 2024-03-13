<?php
require_once('../../../../config/db/connection.php'); 

function findproduct_id($product_id){
    global $conn;
    $sql = "SELECT product_id FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query preparation: " . $conn->error);
    }
    $stmt->bind_param("s", $product_id);
    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $result->close();
            $stmt->close();
            return $row;
        } else {
            $result->close();
            $stmt->close();
            return null;
        }
    } else {
        die("Error executing SQL query: " . $stmt->error);
    }
}
?>