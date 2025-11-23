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
    <link rel="stylesheet" href="style.css">
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
                        <a href="index.php" class="btn btn-register">Đã có tài khoản?</a>
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

<script>
    // 1. Khởi tạo các biến DOM
    var modal = document.getElementById("myModal");
    var closeBtn = document.getElementById("closeBtn");
    var redirectBtn = document.getElementById("redirectBtn");
    var modalMessage = document.getElementById("modalMessage");
    var registerForm = document.getElementById("registerForm");

    // 2. Xử lý sự kiện Submit Form
    registerForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Ngăn load lại trang

        // Lấy giá trị mật khẩu để kiểm tra Client-side
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;

        // KIỂM TRA MẬT KHẨU KHỚP NHAU
        if (password !== confirmPassword) {
            // Nếu không khớp, hiện thông báo lỗi ngay
            modalMessage.textContent = "Mật khẩu nhập lại không khớp! Vui lòng kiểm tra.";
            modalMessage.style.color = "red";

            redirectBtn.style.display = "none";
            closeBtn.style.display = "inline-block";
            modal.style.display = "block";

            return; // Dừng lại, không gửi dữ liệu
        }

        // Lấy dữ liệu form
        var formData = new FormData(registerForm);

        // Gửi dữ liệu qua fetch (AJAX)
        fetch("register_handler.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Xử lý kết quả từ register_handler.php
                if (data.success) {
                    // Thành công: Hiển thị modal và nút chuyển hướng
                    modalMessage.textContent = data.message;
                    modalMessage.style.color = "green";

                    redirectBtn.style.display = "inline-block";
                    closeBtn.style.display = "none";
                    modal.style.display = "block";

                    // Chuyển hướng sau khi nhấn nút "Đăng nhập ngay"
                    redirectBtn.onclick = function() {
                        window.location.href = "index.php";
                    }

                } else {
                    // Thất bại (Ví dụ: Tên tài khoản đã tồn tại, lỗi CSDL,...)
                    modalMessage.textContent = data.message;
                    modalMessage.style.color = "red";
                    redirectBtn.style.display = "none";
                    closeBtn.style.display = "inline-block";
                    modal.style.display = "block";
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert("Có lỗi kết nối xảy ra. Vui lòng thử lại sau.");
            });
    });

    // 3. Xử lý đóng modal bằng nút "Đóng"
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // 4. Xử lý đóng modal khi click ra ngoài
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</html>