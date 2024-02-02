<?php
session_start();
// Unset or clear user-related session variables
unset($_SESSION['user_id']);
unset($_SESSION['role']);

header("Location: ../../../index.php");
exit();
?>
