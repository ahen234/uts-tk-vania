
<?php
session_start();
require_once "../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM admin WHERE username = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && $admin["password"] === md5($password)) {
        $_SESSION["admin"] = $admin["username"];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - MyStore</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: white;
            width: 360px;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,.2);
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
        }

        p {
            text-align: center;
            color: #666;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 7px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>MyStore</h2>
    <p>Admin Login Panel</p>

    <?php if ($error !== "") : ?>
        <p class="error">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <input type="text"
               name="username"
               placeholder="Username Admin"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button type="submit" name="login">LOGIN</button>
    </form>
</div>

</body>
</html>
