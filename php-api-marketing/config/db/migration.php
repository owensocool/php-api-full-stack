<?php
require_once './connection.php';

// Migrate products table
$sqlProducts = "
    CREATE TABLE IF NOT EXISTS products (
        product_id VARCHAR(6) PRIMARY KEY,
        product_name VARCHAR(255) NOT NULL,
        product_price float(2) NOT NULL,
        type VARCHAR(255) NOT NULL,
        model VARCHAR(255),
        mark VARCHAR(255),
        image_path TEXT,
        product_stock INT NOT NULL,
        product_status VARCHAR(15) NOT NULL,
        last_update timestamp
)";

if ($conn->query($sqlProducts) === TRUE) {
    echo "Table 'products' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$sqlOrders = "
    CREATE TABLE IF NOT EXISTS orders (
        order_id VARCHAR(20) PRIMARY KEY,
        customer_id VARCHAR(20) NOT NULL,
        name_order VARCHAR(255) NOT NULL,
        name_receive VARCHAR(255) NOT NULL,
        name_bill VARCHAR(255) NOT NULL,
        tax_no  VARCHAR(255),
        email VARCHAR(100),
        image_path TEXT,
        address VARCHAR(255) NOT NULL,
        tel VARCHAR(14) NOT NULL,
        order_date timestamp,
        shipping_date timestamp,
        receive_date timestamp,
        amount INT,
        shipping_cost float(2),
        vat float(2),
        total_price float(2) NOT NULL,
        order_status VARCHAR(15) NOT NULL,
        last_update timestamp
)";

if ($conn->query($sqlOrders) === TRUE) {
    echo "Table 'orders' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Migrate detail table
$sqlDetails = "
    CREATE TABLE IF NOT EXISTS detail (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id VARCHAR(20)  NOT NULL,
        product_id VARCHAR(20)  NOT NULL,
        amount INT NOT NULL,
        total_price float(2) NOT NULL,
        last_update timestamp
    )
";

if ($conn->query($sqlDetails) === TRUE) {
    echo "Table 'detail' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Migrate customer table
$sqlCustomers = "
    CREATE TABLE IF NOT EXISTS customer (
        customer_id VARCHAR(20) PRIMARY KEY,
        user_id VARCHAR(20) NOT NULL,
        name VARCHAR(255) NOT NULL,
        sex VARCHAR(7)  NOT NULL,
        email VARCHAR(100),
        address VARCHAR(255) NOT NULL,
        tel VARCHAR(14),
        last_update timestamp
    )
";

if ($conn->query($sqlCustomers) === TRUE) {
    echo "Table 'customer' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Migrate users table
$sqlUsers = "
    CREATE TABLE IF NOT EXISTS users (
        user_id VARCHAR(20) PRIMARY KEY,
        username VARCHAR(20)  NOT NULL,
        password VARCHAR(255)  NOT NULL,
        role VARCHAR(12) NOT NULL,
        last_update timestamp
    )
";

if ($conn->query($sqlUsers) === TRUE) {
    echo "Table 'user' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Migrate users-cart table
$sqlCart = "
    CREATE TABLE IF NOT EXISTS cart_items (
    cart_item_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(20),
    product_id VARCHAR(6),
    product_name VARCHAR(255) NOT NULL,
    product_price float(2) NOT NULL,
    quantity INT NOT NULL
)";

if ($conn->query($sqlCart) === TRUE) {
    echo "Table 'cart' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Migrate access log table
$sqlCart = "
    CREATE TABLE IF NOT EXISTS access_log (
    uuid VARCHAR(255) PRIMARY KEY,
    timestamp timestamp,
    username VARCHAR(20),
    ip_address VARCHAR(20),
    action VARCHAR(255) NOT NULL
)";

if ($conn->query($sqlCart) === TRUE) {
    echo "Table 'cart' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}


$conn->close();
