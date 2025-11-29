<?php
// modules/Login/login_handler.php
session_start();

// 1. Kết nối CSDL (Kiểm tra kỹ đường dẫn này)
require_once '../../include/ketnoi.php';

// Kiểm tra xem có phải gửi từ Form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Lọc dữ liệu đầu vào để an toàn hơn
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // 2. Chuẩn bị câu lệnh SQL
    // Chọn đúng các cột bạn cần dùng
    $sql = "SELECT id, ten_dang_nhap, mat_khau, role FROM nhan_vien WHERE ten_dang_nhap = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind tham số (s = string)
        $stmt->bind_param("s", $username);

        // Thực thi
        if ($stmt->execute()) {
            $stmt->store_result();

            // 3. Kiểm tra xem có tìm thấy tài khoản không
            if ($stmt->num_rows == 1) {
                // Bind kết quả vào các biến để sử dụng
                // Lưu ý: Thứ tự biến phải khớp với thứ tự trong câu SELECT ở trên
                $stmt->bind_result($id, $ten_dang_nhap, $hashed_password, $role);
                $stmt->fetch();

                // 4. Kiểm tra mật khẩu
                // Lưu ý: Database phải lưu mật khẩu đã mã hóa bằng password_hash()
                if ($password == $hashed_password || password_verify($password, $hashed_password)) {

                    // --- ĐĂNG NHẬP THÀNH CÔNG ---

                    // Lưu Session
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $ten_dang_nhap;
                    $_SESSION['role'] = $role;

                    // Điều hướng phân quyền
                    if ($role === 'admin') {
                        // Chuyển hướng đến trang Admin (Staff)
                        header("Location:  ../menu/Menu.php");
                    } else {
                        // Chuyển hướng đến trang Menu cho nhân viên
                        header("Location: ../staff/staff.php");
                    }
                    exit(); // Dừng mã ngay lập tức

                } else {
                    // Mật khẩu không đúng
                    header("Location: ../../index.php?error=Mật khẩu không đúng!");
                    exit();
                }
            } else {
                // Không tìm thấy tên đăng nhập
                header("Location: ../../index.php?error=Tài khoản không tồn tại!");
                exit();
            }
        } else {
            echo "Lỗi thực thi truy vấn.";
        }
        $stmt->close();
    }
    $conn->close();
} else {
    // Truy cập trái phép
    header("Location: ../../index.php");
    exit();
}
