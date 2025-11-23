// register.js
function initRegister() {
    var modal = document.getElementById("myModal");
    var closeBtn = document.getElementById("closeBtn");
    var redirectBtn = document.getElementById("redirectBtn");
    var modalMessage = document.getElementById("modalMessage");
    var registerForm = document.getElementById("registerForm");

    if (!registerForm) return;

    registerForm.addEventListener("submit", function (event) {
        event.preventDefault();
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;

        if (password !== confirmPassword) {
            modalMessage.textContent = "Mật khẩu nhập lại không khớp! Vui lòng kiểm tra.";
            modalMessage.style.color = "red";
            redirectBtn.style.display = "none";
            closeBtn.style.display = "inline-block";
            modal.style.display = "block";
            return;
        }

        var formData = new FormData(registerForm);

        fetch("register_handler.php", {
            method: "POST",
            body: formData
        })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    modalMessage.textContent = data.message;
                    modalMessage.style.color = "green";
                    redirectBtn.style.display = "inline-block";
                    closeBtn.style.display = "none";
                    modal.style.display = "block";
                    redirectBtn.onclick = function () {
                        window.location.href = "index.php";
                    }
                } else {
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

    if (closeBtn) {
        closeBtn.onclick = function () {
            modal.style.display = "none";
        }
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = { initRegister };
} else {
    document.addEventListener('DOMContentLoaded', initRegister);
}