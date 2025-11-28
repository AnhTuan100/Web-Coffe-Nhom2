// Tên file: register.test.js
const { initRegister } = require('./register.js');

// Hàm hỗ trợ: Chờ cho tất cả các Promise hoàn thành (Async utility)
const flushPromises = () => new Promise(resolve => setTimeout(resolve, 0));

describe('Chức năng Đăng Ký Tài Khoản', () => {
    let modal, registerForm, modalMessage, passwordInput, confirmPasswordInput, redirectBtn;

    // Thiết lập HTML giả lập trước mỗi bài test
    beforeEach(() => {
        document.body.innerHTML = `
            <div class="login-box">
                <form id="registerForm" action="register_handler.php" method="POST">
                    <input type="text" id="fullname" name="fullname" value="Nguyễn Văn A">
                    <input type="text" id="username" name="username" value="newuser">
                    <input type="password" id="password" value="123456">
                    <input type="password" id="confirm_password" value="123456">
                    <button type="submit" class="btn btn-login">Đăng Ký Ngay</button>
                </form>
            </div>
            <div id="myModal" class="modal" style="display: none;">
                <div class="modal-body">
                    <p id="modalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button id="closeBtn">Đóng</button>
                    <button id="redirectBtn" style="display: none;">Đăng nhập ngay</button>
                </div>
            </div>
        `;

        // Gán lại các biến DOM
        modal = document.getElementById('myModal');
        registerForm = document.getElementById('registerForm');
        modalMessage = document.getElementById('modalMessage');
        passwordInput = document.getElementById('password');
        confirmPasswordInput = document.getElementById('confirm_password');
        redirectBtn = document.getElementById('redirectBtn');

        // Giả lập (Mock) hàm fetch và alert
        global.fetch = jest.fn();
        global.alert = jest.fn();
        global.console.error = jest.fn();

        // Khởi chạy logic JS
        initRegister();
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    // TEST CASE 1: Đăng ký thành công
    test('Nên hiển thị Modal thành công và nút chuyển hướng khi API trả về success: true', async () => {
        // 1. Giả lập API trả về thành công
        global.fetch.mockResolvedValueOnce({
            json: async () => ({ success: true, message: 'Đăng ký thành công!' }),
            ok: true,
        });

        // 2. Kích hoạt sự kiện submit
        registerForm.dispatchEvent(new Event('submit'));

        // 3. Chờ xử lý xong hết các Promise
        await flushPromises();

        // 4. Kiểm tra kết quả
        expect(global.fetch).toHaveBeenCalledTimes(1);
        expect(modal.style.display).toBe('block');
        expect(modalMessage.textContent).toBe('Đăng ký thành công!');
        expect(redirectBtn.style.display).toBe('inline-block'); // Kiểm tra nút chuyển hướng có hiện không
    });

    // TEST CASE 2: Đăng ký thất bại do Username đã tồn tại
    test('Nên hiển thị Modal lỗi khi API trả về success: false', async () => {
        // 1. Giả lập API trả về thất bại (ví dụ: Username đã tồn tại)
        global.fetch.mockResolvedValueOnce({
            json: async () => ({ success: false, message: 'Tên tài khoản đã tồn tại.' }),
            ok: true,
        });

        // 2. Kích hoạt sự kiện submit
        registerForm.dispatchEvent(new Event('submit'));

        // 3. Chờ xử lý
        await flushPromises();

        // 4. Kiểm tra kết quả
        expect(modal.style.display).toBe('block');
        expect(modalMessage.textContent).toBe('Tên tài khoản đã tồn tại.');
        expect(modalMessage.style.color).toBe('red');
        expect(redirectBtn.style.display).toBe('none'); // Nút chuyển hướng không được hiện
    });

    // TEST CASE 3: Kiểm tra mật khẩu nhập lại không khớp (Client-side validation)
    test('Nên hiển thị Modal lỗi và KHÔNG gọi API khi mật khẩu không khớp', async () => {
        // Thay đổi mật khẩu để chúng không khớp
        confirmPasswordInput.value = 'khongkhop';
        passwordInput.value = '123456';

        // Kích hoạt sự kiện submit
        registerForm.dispatchEvent(new Event('submit'));

        // Không cần await flushPromises vì logic này là đồng bộ (không gọi fetch)

        // Kiểm tra kết quả
        expect(global.fetch).not.toHaveBeenCalled(); // QUAN TRỌNG: API không được gọi
        expect(modal.style.display).toBe('block');
        expect(modalMessage.textContent).toContain('Mật khẩu nhập lại không khớp!');
        expect(modalMessage.style.color).toBe('red');
    });

    // TEST CASE 4: Xử lý lỗi mạng
    test('Nên hiển thị Alert lỗi khi có lỗi mạng (catch block)', async () => {
        // 1. Giả lập fetch bị lỗi mạng (vào catch block)
        global.fetch.mockRejectedValueOnce(new Error('Network Error'));

        // 2. Submit form
        registerForm.dispatchEvent(new Event('submit'));

        // 3. Chờ xử lý
        await flushPromises();

        // 4. Kiểm tra alert
        expect(global.alert).toHaveBeenCalledWith("Có lỗi kết nối xảy ra. Vui lòng thử lại sau.");
    });
});