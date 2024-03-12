<?php
session_start();
require_once('../controller/auth_operation.php');
require_once('../../admin/log/access_log.php');

// if(!isset($_SESSION['user_id']) || $_SESSION['role'] == 'admin'){
//     header("Location: ../../customer/home/index.php");
//     exit();
// }

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
                $_SESSION['username'] = $row['username'];

                if ($role == "admin") {
                    header("Location: ../../home/index.php"); // Redirect to admin page
                    $message = "admin login success";
                } else {
                    header("Location: ../../home/index.php"); // Redirect to user page
                    $message ="customer login success";
                }
            logMessage($message);    
            exit();
            } else {
                $message1 = "Username or password is incorrect";
                header("Location: ../view/signIn.html");
            }
        } else {
            $message1 = "Username or password is incorrect";
            header("Location: ../view/signIn.html");
        }
    } else {
        header("Location: ../view/signIn.html");
    }
    
}
?>
