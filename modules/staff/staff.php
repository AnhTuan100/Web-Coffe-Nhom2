<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhân Viên</title>
    <link rel="stylesheet" href="../../css/stylemenu.css">
</head>

<body>

    <div class="header">
        <div class="nav-left">
            <span class="menu-icon">&#9776;</span>
            <a href="../menu/menu.php" class="nav-item">Thực Đơn</a>
            <a href="#" class="nav-item active">Nhân viên</a>
            <a href="../revenue/revenue.php" class="nav-item">Doanh Thu</a>
            <a href="../sales/sales.php" class="nav-item">Bán Hàng</a>
        </div>
        <div class="user-info">
            (<?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Admin'; ?>)
            <?php echo isset($_SESSION['ten_nv']) ? $_SESSION['ten_nv'] : 'User'; ?>
            👤
        </div>
    </div>

    <div class="toolbar">
        <button class="btn">Thêm</button>
        <button class="btn">Sửa</button>
        <button class="btn">Xóa</button>
        <button class="btn">Phân Quyền</button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã nhân viên</th>
                    <th>Tên đăng nhập</th>
                    <th>Tên Nhân viên</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Ca làm việc</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 1. KẾT NỐI DATABASE
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "web_coffe_nhom2";

                $conn = new mysqli($servername, $username, $password, $dbname);
                $conn->set_charset("utf8");

                if ($conn->connect_error) {
                    die("<tr><td colspan='6'>Kết nối thất bại: " . $conn->connect_error . "</td></tr>");
                }

                // 2. TRUY VẤN DỮ LIỆU NHÂN VIÊN
                $sql = "SELECT * FROM nhan_vien";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Xử lý ngày sinh: Database lưu 2005-06-15 -> Hiển thị 15/06/2005
                        $ngay_sinh_vn = date("d/m/Y", strtotime($row["ngay_sinh"]));

                        echo "<tr>";
                        echo "<td>" . $row["ma_nv"] . "</td>";
                        echo "<td>" . $row["ten_dang_nhap"] . "</td>";
                        echo "<td>" . $row["ten_nv"] . "</td>";
                        echo "<td>" . $ngay_sinh_vn . "</td>";
                        echo "<td>" . $row["gioi_tinh"] . "</td>";
                        echo "<td>" . $row["ca_lam_viec"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Chưa có nhân viên nào</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <span class="page-btn">&lt;&lt;</span>
        <span class="page-btn">&lt;</span>
        <span>| Trang <span class="page-number">1</span> trên 7 trang |</span>
        <span class="page-btn">&gt;</span>
        <span class="page-btn">&gt;&gt;</span>
    </div>

</body>

</html>