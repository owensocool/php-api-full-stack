<?php
require_once('../../../config/db/connection.php'); 

function getOrder_id($order_id){
    global $conn;
    $sql = "SELECT order_id FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query preparation: " . $conn->error);
    }
    $stmt->bind_param("s", $order_id);
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

function getCustomer_id($user_id){
    global $conn;
    $sql = "SELECT customer_id FROM customer WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query preparation: " . $conn->error);
    }
    $stmt->bind_param("s", $user_id);
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
function orderList($customer_id){
    global $conn;
    $sql = "SELECT * FROM orders WHERE customer_id = ? ORDER BY order_date";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query preparation: " . $conn->error);
    }

    $stmt->bind_param("s", $customer_id);

    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $rows;
    } else {
        die("Error executing SQL query: " . $stmt->error);
    }
}

function orderDetail($order_id){
    global $conn;
    $sql = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query preparation: " . $conn->error);
    }

    $stmt->bind_param("s", $order_id);

    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $rows;
    } else {
        die("Error executing SQL query: " . $stmt->error);
    }
}

function findStock($product_id){
    global $conn;
    $sql = "SELECT product_stock,product_status FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query preparation: " . $conn->error);
    }

    $stmt->bind_param("s", $product_id);

    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $rows;
    } else {
        die("Error executing SQL query: " . $stmt->error);
    }
}


?>
