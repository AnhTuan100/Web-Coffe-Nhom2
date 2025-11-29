<?php
// Tên file: register_handler.php
header('Content-Type: application/json');

// Chuẩn bị mảng kết quả mặc định
$response = [
    'success' => false,
    'message' => 'Yêu cầu không hợp lệ.'
];

// 1. Kết nối cơ sở dữ liệu
// Sử dụng file ketnoi.php đã được bạn cung cấp (sử dụng mysqli)
require_once 'ketnoi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Lấy dữ liệu từ form
    $fullname = $_POST['fullname'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Kiểm tra dữ liệu rỗng
    if (empty($fullname) || empty($username) || empty($password)) {
        $response['message'] = 'Vui lòng điền đầy đủ Họ tên, Tài khoản và Mật khẩu.';
        echo json_encode($response);
        $conn->close();
        exit();
    }

    // 3. Kiểm tra tên tài khoản đã tồn tại chưa (Sử dụng Prepared Statements)
    $check_sql = "SELECT username FROM users WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $response['message'] = 'Tên tài khoản đã tồn tại. Vui lòng chọn tên khác.';
        echo json_encode($response);
        $check_stmt->close();
        $conn->close();
        exit();
    }
    $check_stmt->close();

    // 4. Mã hóa mật khẩu (Bảo mật tối đa)
    // Dùng PASSWORD_DEFAULT (sẽ tự động chọn thuật toán mã hóa mạnh nhất hiện tại)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 5. Thêm người dùng mới vào database (Mặc định Role là 'Khách hàng')
    $insert_sql = "INSERT INTO users (fullname, username, password, role) VALUES (?, ?, ?, 'Khách hàng')";
    $insert_stmt = $conn->prepare($insert_sql);
    // 'sss' là viết tắt của 3 chuỗi (string)
    $insert_stmt->bind_param("sss", $fullname, $username, $hashed_password);

    if ($insert_stmt->execute()) {
        // Đăng ký thành công
        $response['success'] = true;
        $response['message'] = 'Đăng ký tài khoản thành công! Bạn có thể đăng nhập ngay.';
    } else {
        // Lỗi CSDL (thường ít xảy ra nếu code đúng)
        $response['message'] = 'Lỗi hệ thống khi đăng ký: ' . $conn->error;
    }

    $insert_stmt->close();
}

// 6. Trả về kết quả JSON cuối cùng
$conn->close();
echo json_encode($response);
exit();
