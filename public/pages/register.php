<?php
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (registerUser($username, $password)) {
        header("Location: login.php");
    } else {
        echo "Ошибка при регистрации!!!!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Регистрация</button>
    </form>
</body>
</html>
