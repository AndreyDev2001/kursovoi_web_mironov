<?php
include '../includes/functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = loginUser($username, $password);
    if ($user) {
        $_SESSION['user'] = $user;
        if ($user['role'] == 'admin') {
            header("Location: admin_panel.php");
        } else {
            header("Location: shop.php");
        }
    } else {
        echo "Ошибка авторизации!!!!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Авторизация</button>
    </form>
</body>
</html>
