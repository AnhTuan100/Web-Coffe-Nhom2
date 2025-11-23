const { initLogin } = require('./login.js');

// Hàm hỗ trợ: Chờ cho tất cả các Promise hoàn thành (quan trọng)
const flushPromises = () => new Promise(resolve => setTimeout(resolve, 0));

describe('Chức năng Đăng nhập Coffee Quy Hòa', () => {
    let modal, loginForm, usernameInput, passwordInput;

    // Thiết lập HTML giả lập trước mỗi bài test
    beforeEach(() => {
        document.body.innerHTML = `
            <div class="login-box">
                <form action="login_handler.php" method="POST">
                    <input type="text" id="username" name="username" value="testuser">
                    <input type="password" id="password" name="password" value="123456">
                    <button type="submit" class="btn btn-login">Đăng nhập</button>
                </form>
            </div>
            <div id="myModal" class="modal" style="display: none;">
                <p id="modalMessage"></p>
                <p id="modalRole"></p>
                <button id="closeBtn">Đóng</button>
            </div>
        `;

        // Gán lại các biến DOM
        modal = document.getElementById('myModal');
        loginForm = document.querySelector('.login-box form');
        usernameInput = document.getElementById('username');
        passwordInput = document.getElementById('password');

        // Giả lập (Mock) hàm fetch
        global.fetch = jest.fn();
        // Giả lập hàm alert
        global.alert = jest.fn();
        // Giả lập console.error để không bị rác màn hình khi test lỗi
        global.console.error = jest.fn();

        // Khởi chạy logic JS
        initLogin();
    });

    afterEach(() => {
        jest.clearAllMocks(); // Xóa dữ liệu mock sau mỗi test
    });

    test('Nên hiển thị Modal thành công khi API trả về success: true', async () => {
        // 1. Giả lập API trả về thành công
        global.fetch.mockResolvedValueOnce({
            json: async () => ({ success: true, message: 'Đăng nhập thành công!', role: 'Quản lý' }),
        });

        // 2. Kích hoạt sự kiện submit
        loginForm.dispatchEvent(new Event('submit'));

        // 3. (QUAN TRỌNG) Chờ xử lý xong hết các Promise
        await flushPromises();

        // 4. Kiểm tra kết quả (Assert)
        expect(global.fetch).toHaveBeenCalledTimes(1);
        expect(modal.style.display).toBe('block');
        expect(document.getElementById('modalMessage').textContent).toBe('Đăng nhập thành công!');
        expect(document.getElementById('modalRole').textContent).toBe('Quyền: Quản lý');
    });

    test('Nên hiển thị Alert lỗi khi API trả về success: false', async () => {
        // 1. Giả lập API trả về thất bại
        global.fetch.mockResolvedValueOnce({
            json: async () => ({ success: false, message: 'Sai mật khẩu' }),
        });

        // 2. Kích hoạt sự kiện submit
        loginForm.dispatchEvent(new Event('submit'));

        // 3. Chờ xử lý
        await flushPromises();

        // 4. Kiểm tra kết quả
        expect(modal.style.display).toBe('none');
        expect(global.alert).toHaveBeenCalledWith('Sai mật khẩu');
    });

    test('Nên đóng Modal khi nhấn nút Đóng', () => {
        // Mở modal trước
        modal.style.display = 'block';

        // Tìm và nhấn nút đóng
        const closeBtn = document.getElementById('closeBtn');
        closeBtn.click();

        // Kiểm tra modal đã đóng chưa
        expect(modal.style.display).toBe('none');
    });

    test('Nên xử lý lỗi mạng (Network Error) đúng cách', async () => {
        // 1. Giả lập fetch bị lỗi mạng
        global.fetch.mockRejectedValueOnce(new Error('Network Error'));

        // 2. Submit form
        loginForm.dispatchEvent(new Event('submit'));

        // 3. Chờ xử lý
        await flushPromises();

        // 4. Kiểm tra alert lỗi chung
        expect(global.alert).toHaveBeenCalledWith("Có lỗi xảy ra, vui lòng thử lại.");
    });
});