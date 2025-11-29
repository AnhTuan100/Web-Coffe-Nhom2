<?php
// Tên file: register.php
// Đảm bảo PHP có thể xử lý việc nhúng file JS và CSS
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - Coffee Quy Hòa</title>
    <link rel="stylesheet" href="../../css/style.css">
    <script src="register.js"></script>
    </body>
</head>

<body>
    <div class="login-container">
        <div class="left-pane"></div>

        <div class="right-pane">
            <div class="login-box">
                <h2>Đăng Ký Tài Khoản</h2>

                <?php
                if (isset($_GET['error'])) {
                    echo '<p style="color: red; text-align: center;">' . htmlspecialchars($_GET['error']) . '</p>';
                }
                ?>

                <form id="registerForm" action="register_handler.php" method="POST">

                    <div class="input-group">
                        <label for="fullname">Họ và tên</label>
                        <input type="text" id="fullname" name="fullname" required placeholder="Nhập họ tên đầy đủ">
                    </div>

                    <div class="input-group">
                        <label for="username">Tài khoản</label>
                        <input type="text" id="username" name="username" required placeholder="Tên đăng nhập">
                    </div>

                    <div class="input-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
                    </div>

                    <div class="input-group">
                        <label for="confirm_password">Nhập lại mật khẩu</label>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Xác nhận mật khẩu">
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-login">Đăng Ký Ngay</button>
                        <a href="../../index.php" class="btn btn-register">Đã có tài khoản?</a>
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
            <p id="modalMessage"></p>
        </div>
        <div class="modal-footer">
            <button id="closeBtn" class="btn-dong">Đóng</button>
            <button id="redirectBtn" class="btn-login" style="display: none; padding: 10px 20px;">Đăng nhập ngay</button>
        </div>
    </div>
</div>

</html>