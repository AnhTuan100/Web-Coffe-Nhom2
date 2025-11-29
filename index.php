<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Coffee Quy Hòa</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="modules/Login/login.js"></script>
</head>

<body>
    <div class="login-container">
        <div class="left-pane"></div>
        <div class="right-pane">
            <div class="login-box">
                <h2>Coffee Quy Hòa</h2>

                <?php
                // (MỚI) Hiển thị thông báo lỗi nếu có
                if (isset($_GET['error'])) {
                    echo '<p style="color: red; text-align: center;">' . htmlspecialchars($_GET['error']) . '</p>';
                }
                ?>

                <form action="modules/Login/login_handler.php" method="POST">

                    <div class="input-group">
                        <label for="username">Tài khoản</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="input-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <a href="#" class="forgot-password">Quên mật khẩu</a>

                    <div class="button-group">
                        <button type="submit" class="btn btn-login">Đăng nhập</button>
                        <a href="modules/Register/register.php" class="btn btn-register">Đăng Ký</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Thông Báo</h3>
        </div>
        <div class="modal-body">
            <p id="modalMessage">Đăng nhập thành công!</p>
            <p id="modalRole">Quyền: Quản lý</p>
        </div>
        <div class="modal-footer">
            <button id="closeBtn" class="btn-dong">Đóng</button>
        </div>
    </div>
</div>

</html>