<?php
require 'includes/config.php';

if (isset($_SESSION['nhanvien_id'])) {
    header("Location: don-hang-moi.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taikhoan = trim($_POST['taikhoan']);
    $matkhau = trim($_POST['matkhau']);

    $sql = "SELECT id, hoten FROM nhanvien WHERE (email = ? OR sodienthoai = ?) AND matkhau = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $taikhoan, $taikhoan, $matkhau);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['nhanvien_id'] = $row['id'];
        $_SESSION['nhanvien_hoten'] = $row['hoten'];
        header("Location: don-hang-moi.php");
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập nhân viên</title>
    <style>
        body { margin:0; padding:0; font-family: Arial; background: #f4f4f4; display:flex; align-items:center; justify-content:center; height:100vh; }
        .login-box { width:360px; background:white; padding:40px; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.1); text-align:center; }
        input { width:100%; padding:12px; margin:10px 0; border:1px solid #ddd; border-radius:5px; }
        button { width:100%; padding:12px; background:#2c3e50; color:white; border:none; border-radius:5px; cursor:pointer; font-size:16px; }
        .error { color:red; margin-top:10px; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Coffee Quy Hòa</h2>
    <p>Đăng nhập nhân viên</p>
    <form method="POST">
        <input type="text" name="taikhoan" placeholder="Email hoặc Số điện thoại" required>
        <input type="password" name="matkhau" placeholder="Mật khẩu" required>
        <button type="submit">Đăng nhập</button>
    </form>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
</div>
</body>
</html>