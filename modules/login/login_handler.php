<?php
session_start();
require_once '../../include/ketnoi.php'; // Đảm bảo đường dẫn đúng

// Kiểm tra xem có phải gửi từ Form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Dùng Prepared Statement (Chống Hack SQL Injection - Cực xịn để khoe giáo viên)
    $sql = "SELECT id, ten_dang_nhap, mat_khau, role FROM nhan_vien WHERE ten_dang_nhap = ?";

    // Lưu ý: Kiểm tra lại tên bảng là 'nhan_vien' hay 'users' trong database của bạn nhé

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // 2. Kiểm tra kết quả
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // 3. Kiểm tra mật khẩu (Dùng password_verify nếu DB đã mã hóa, hoặc so sánh == nếu chưa)
        // Nếu database bạn đang lưu pass thường (ví dụ '123456') thì dùng dòng dưới:
        // if ($password == $user['password']) { 

        // Nếu database đã mã hóa Bcrypt/MD5 thì dùng dòng này:
        if (password_verify($password, $user['password'])) {

            // --- ĐĂNG NHẬP THÀNH CÔNG ---

            // A. Lưu Session (QUAN TRỌNG NHẤT)
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['ten_dang_nhap'];
            $_SESSION['role'] = $user['role']; // <--- Bắt buộc phải có dòng này để phân quyền

            // B. Điều hướng phân quyền
            if ($user['role'] === 'admin') {
                header("Location: ../Staff/Staff.php"); // Admin vào trang quản lý
            } else {
                header("Location: ../menu/Menu.php");   // Nhân viên vào trang Menu
            }
            exit();
        } else {
            // Sai mật khẩu -> Quay về Login báo lỗi
            header("Location: ../../index.php?error=Mật khẩu không đúng!");
            exit();
        }
    } else {
        // Không tìm thấy tài khoản
        header("Location: ../../index.php?error=Tài khoản không tồn tại!");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Truy cập trái phép
    header("Location: ../../index.php");
    exit();
}
