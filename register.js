// Tên file: register.js

function initRegister() {
    // 1. Khởi tạo các biến DOM
    var modal = document.getElementById("myModal");
    var closeBtn = document.getElementById("closeBtn");
    var redirectBtn = document.getElementById("redirectBtn");
    var modalMessage = document.getElementById("modalMessage");
    var registerForm = document.getElementById("registerForm");

    // Chỉ chạy nếu form tồn tại
    if (!registerForm) return;

    // 2. Xử lý sự kiện Submit Form
    registerForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Ngăn load lại trang

        // Lấy giá trị mật khẩu để kiểm tra Client-side
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;

        // KIỂM TRA MẬT KHẨU KHỚP NHAU
        if (password !== confirmPassword) {
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
            .then(response => {
                if (!response.ok) {
                    throw new Error('Lỗi mạng hoặc server trả về trạng thái không thành công.');
                }
                return response.json();
            })
            .then(data => {
                // Xử lý kết quả từ register_handler.php
                if (data.success) {
                    // Thành công
                    modalMessage.textContent = data.message;
                    modalMessage.style.color = "green";

                    redirectBtn.style.display = "inline-block";
                    closeBtn.style.display = "none";
                    modal.style.display = "block";

                    // Chuyển hướng sau khi nhấn nút "Đăng nhập ngay"
                    redirectBtn.onclick = function () {
                        window.location.href = "index.php";
                    }

                } else {
                    // Thất bại
                    modalMessage.textContent = data.message;
                    modalMessage.style.color = "red";
                    redirectBtn.style.display = "none";
                    closeBtn.style.display = "inline-block";
                    modal.style.display = "block";
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                // Sử dụng alert cho lỗi mạng/kết nối không xác định
                alert("Có lỗi kết nối xảy ra. Vui lòng thử lại sau.");
            });
    });

    // 3. Xử lý đóng modal bằng nút "Đóng"
    if (closeBtn) {
        closeBtn.onclick = function () {
            modal.style.display = "none";
        }
    }

    // 4. Xử lý đóng modal khi click ra ngoài
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

// Xuất hàm để Jest có thể import
module.exports = { initRegister };