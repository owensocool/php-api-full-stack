<?php
$host = 'localhost';
$username = 'admin_annisa';
$password = 'password';
$database = 'full-stack-store';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}