<?php
require_once '../../admin/log/access_log.php';
session_start();
// Unset or clear user-related session variables
unset($_SESSION['user_id']);
unset($_SESSION['role']);

logMessage("logout successfully");

header("Location: ../../customer/home/index.php");
exit();
?>
