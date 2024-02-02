<?php
session_start();

if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$validUsername = "user123";
$validPassword = "password123";
$validRole = "admin";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate user credentials
    if ($username == $validUsername && $password == $validPassword) {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = $username;
        $_SESSION['user_role'] = $validRole;

        // Redirect based on user role
        if ($validRole == "admin") {
            header("Location: ../../index.php");
        } else {
            header("Location: ../../index.php");
        }
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Login</h2>
        <?php if(isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>

</body>
</html>
