<?php
// Bắt đầu session để có thể lưu trạng thái đăng nhập
session_start();

// 1. Gọi tệp kết nối
require_once 'ketnoi.php'; // $conn sẽ có sẵn từ đây

// 2. Kiểm tra xem người dùng có nhấn nút "Đăng nhập" không
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Lấy dữ liệu an toàn từ form
    $username_form = $_POST['username'];
    $password_form = $_POST['password'];

    // 4. BẢO MẬT: Chống SQL Injection bằng Prepared Statements
    // Đây là phần "lấy dữ liệu từ SQL"

    // Chuẩn bị câu lệnh: Chọn tất cả các cột từ bảng 'users' 
    // nơi mà cột 'username' khớp với ? (placeholder)
    $sql = "SELECT id, username, password FROM users WHERE username = ?";

    // Chuẩn bị
    $stmt = $conn->prepare($sql);

    // Gắn biến vào placeholder
    // "s" có nghĩa là biến $username_form là kiểu String (chuỗi)
    $stmt->bind_param("s", $username_form);

    // 5. Thực thi câu lệnh
    $stmt->execute();

    // 6. Lấy kết quả
    $result = $stmt->get_result();

    // 7. Kiểm tra xem có tìm thấy (num_rows == 1)
    if ($result->num_rows == 1) {
        // Lấy hàng dữ liệu tìm được
        $user = $result->fetch_assoc();

        // 8. BẢO MẬT: Kiểm tra mật khẩu
        // $password_form là mật khẩu người dùng gõ vào
        // $user['password'] là mật khẩu đã BĂM ($2y$...) trong CSDL
        if (password_verify($password_form, $user['password'])) {

            // Đăng nhập thành công!
            // Lưu thông tin vào Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Chuyển hướng đến trang chào mừng (ví dụ)
            header("Location: welcome.php");
            exit();
        } else {
            // Sai mật khẩu
            header("Location: index.php?error=Sai mật khẩu");
            exit();
        }
    } else {
        // Không tìm thấy tài khoản
        header("Location: index.php?error=Tài khoản không tồn tại");
        exit();
    }

    // 9. Đóng kết nối
    $stmt->close();
    $conn->close();
} else {
    // Nếu ai đó gõ trực tiếp URL /login_handler.php
    header("Location: index.php");
    exit();
}
