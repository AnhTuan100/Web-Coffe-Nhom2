// login.js

function initLogin() {
    // Lấy các đối tượng DOM
    var modal = document.getElementById("myModal");
    var closeBtn = document.getElementById("closeBtn");
    var loginForm = document.querySelector(".login-box form");
    var modalMessage = document.getElementById("modalMessage");
    var modalRole = document.getElementById("modalRole");

    if (!loginForm) return; // Bảo vệ nếu không tìm thấy form

    // 1. Xử lý submit form
    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();

        var formData = new FormData(loginForm);
        // Chuyển FormData thành object đơn giản để giả lập trong test dễ hơn (tuỳ chọn)
        // Ở đây giữ nguyên logic fetch của bạn

        fetch("login_handler.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    modalMessage.textContent = data.message;
                    modalRole.textContent = "Quyền: " + data.role;
                    modal.style.display = "block";
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert("Có lỗi xảy ra, vui lòng thử lại.");
            });
    });

    // 2. Xử lý nút đóng
    if (closeBtn) {
        closeBtn.onclick = function () {
            modal.style.display = "none";
        }
    }

    // 3. Xử lý click ngoài modal
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

// Export hàm để test gọi được
module.exports = { initLogin };