<?php
// Thông tin cấu hình cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_coffe_nhom2";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8");
