<?php
session_start();
require_once('../controller/auth_operation.php');

if(isset($_SESSION['user_id'])) {
    header("Location: ../../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (!empty($username) && !empty($password)) {
        $message = null;
        $row = machingUsr($username);

        if ($row !== null ) {
            $storedHashedPassword = $row['password'];

            if (password_verify($password, $storedHashedPassword)) {
                // Redirect based on user role (you need to have the role in your data)
                $role = $row['role'];
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['role'] = $row['role'];
                $message = "Authentication successful";

                if ($role == "admin") {
                    header("Location: ../../../index.php"); // Redirect to admin page
                } else {
                    header("Location: ../../../index.php"); // Redirect to user page
                }
                exit();
            } else {
                $message = "Username or password is incorrect";
                header("Location: ../view/signIn.html");
            }
        } else {
            $message = "Username or password is incorrect";
            header("Location: ../view/signIn.html");
        }
    } else {
        $message = "Empty field(s)";
        header("Location: ../view/signIn.html");
    }
}
?>
