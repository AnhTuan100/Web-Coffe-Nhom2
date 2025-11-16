<?php
// Bắt đầu session
session_start();

// 1. Gọi tệp kết nối
require_once 'ketnoi.php';

// Chuẩn bị mảng kết quả để trả về
$response = [
    'success' => false,
    'message' => 'Lỗi không xác định'
];

// 2. Kiểm tra xem form đã được gửi đi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 4. Chuẩn bị câu lệnh SQL
    // (QUAN TRỌNG: Đã thêm cột 'role' vào câu SELECT)
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // 5. Kiểm tra
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // 6. Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Đăng nhập thành công!

            // Lưu Session (vẫn cần thiết)
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Thiết lập kết quả trả về
            $response['success'] = true;
            $response['message'] = 'Đăng nhập thành công';
            $response['role'] = $user['role']; // Lấy quyền từ CSDL

        } else {
            // Sai mật khẩu
            $response['success'] = false;
            $response['message'] = 'Tài khoản hoặc mật khẩu không đúng!';
        }
    } else {
        // Không tìm thấy tài khoản
        $response['success'] = false;
        $response['message'] = 'Tài khoản hoặc mật khẩu không đúng!';
    }

    $stmt->close();
    $conn->close();
} else {
    $response['message'] = 'Yêu cầu không hợp lệ';
}

// 7. In kết quả dưới dạng JSON (JavaScript sẽ đọc cái này)
header('Content-Type: application/json');
echo json_encode($response);
exit(); // Dừng script tại đây
