<?php
// Thông tin cấu hình cơ sở dữ liệu
$servername = "localhost"; // Tên máy chủ (thường là localhost)
$username = "root";        // Tên người dùng MySQL
$password = "";            // Mật khẩu MySQL (để trống nếu không có)
$dbname = "web_coffe_nhom2"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8");
