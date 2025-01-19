<?php
$servername = "mysql-8.2";
$username = "root";
$password = "";
$dbname = "magaz";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Соединение не удалось: " . $conn->connect_error);
}
?>
