<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Coffee Quy Hòa</title>
    <link rel="stylesheet" href="style.css">
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

                <form action="login_handler.php" method="POST">

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
                        <a href="/dang-ky" class="btn btn-register">Đăng Ký</a>
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

<script>
    // Lấy các đối tượng DOM
    var modal = document.getElementById("myModal");
    var closeBtn = document.getElementById("closeBtn");
    var loginForm = document.querySelector(".login-box form");

    // Lấy các element để hiển thị thông báo
    var modalMessage = document.getElementById("modalMessage");
    var modalRole = document.getElementById("modalRole");

    // 1. Khi người dùng nhấp vào nút "Đăng nhập"
    loginForm.addEventListener("submit", function(event) {
        // Ngăn form gửi đi theo cách truyền thống
        event.preventDefault();

        // Lấy dữ liệu từ form
        var formData = new FormData(loginForm);

        // Gửi dữ liệu bằng AJAX (fetch)
        fetch("login_handler.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json()) // Chuyển kết quả sang JSON
            .then(data => {
                // 2. Xử lý kết quả trả về từ login_handler.php
                if (data.success) {
                    // Nếu đăng nhập thành công
                    modalMessage.textContent = data.message;
                    modalRole.textContent = "Quyền: " + data.role; // Hiển thị quyền
                    modal.style.display = "block"; // Hiển thị bảng thông báo
                } else {
                    // Nếu đăng nhập thất bại
                    alert(data.message); // Hiển thị thông báo lỗi đơn giản
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert("Có lỗi xảy ra, vui lòng thử lại.");
            });
    });

    // 3. Khi người dùng nhấp nút "Đóng"
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // 4. Khi người dùng nhấp ra ngoài bảng thông báo
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</html>