// login.js
function initLogin() {
    var modal = document.getElementById("myModal");
    var closeBtn = document.getElementById("closeBtn");
    var loginForm = document.querySelector(".login-box form");
    var modalMessage = document.getElementById("modalMessage");
    var modalRole = document.getElementById("modalRole");

    if (!loginForm) return;

    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();
        var formData = new FormData(loginForm);

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
    module.exports = { initLogin };
} else {
    document.addEventListener('DOMContentLoaded', initLogin);
}