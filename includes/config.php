<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'quan_ly_cafe';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Kết nối database thất bại: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>