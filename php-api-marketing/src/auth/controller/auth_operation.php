<?php
require_once('../../../config/db/connection.php'); 

function getUsername($username){
    global $conn;
    $sql = "SELECT username FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query preparation: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
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

function getUser_id($user_id){
    global $conn;
    $sql = "SELECT user_id FROM users WHERE user_id = ?";
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

function getCus_id($customer_id){
    global $conn;
    $sql = "SELECT customer_id FROM customer WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query preparation: " . $conn->error);
    }
    $stmt->bind_param("s", $customer_id);
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

function createUsr($user_id,$username, $password, $role) {
    global $conn;
    try {
        $sql = "INSERT INTO users (user_id,username, password, role,last_update) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";
        $stmt = $conn->prepare($sql);
        // Bind parameters
        $stmt->bind_param('ssss', $user_id, $username, $password, $role);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}

function createCustomer($customer_id,$user_id,$name, $email, $sex, $tel,$address) {
    global $conn;
    try {
        $sql = "INSERT INTO customer (customer_id,user_id,name,email, sex, tel,address,last_update) VALUES (?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";
        $stmt = $conn->prepare($sql);
        // Bind parameters
        $stmt->bind_param('sssssss', $customer_id,$user_id,$name, $email, $sex, $tel,$address);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}

function machingUsr($username) {
    global $conn;
    $sql = "SELECT user_id, username,password,role  FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query preparation: " . $conn->error);
    }
    $stmt->bind_param("s", $username);

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
