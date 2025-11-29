<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Thực Đơn</title>
    <link rel="stylesheet" href="../../css/stylemenu.css">
</head>

<body>

    <div class="header">
        <div class="nav-left">
            <span class="menu-icon">&#9776;</span>
            <a href="#" class="nav-item active">Thực Đơn</a>
            <a href="../staff/staff.php" class="nav-item">Nhân viên</a>
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
        <button class="btn" onclick="alert('Chức năng đang phát triển')">Thêm</button>
        <button class="btn" onclick="alert('Chức năng đang phát triển')">Sửa</button>
        <button class="btn" onclick="alert('Chức năng đang phát triển')">Xóa</button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Loại món</th>
                    <th>Mã món</th>
                    <th>Tên món</th>
                    <th>Nhóm thực đơn</th>
                    <th>Đơn vị</th>
                    <th>Giá</th>
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
                $conn->set_charset("utf8"); // Hiển thị tiếng Việt

                // Kiểm tra kết nối
                if ($conn->connect_error) {
                    die("<tr><td colspan='6'>Kết nối thất bại: " . $conn->connect_error . "</td></tr>");
                }

                // 2. TRUY VẤN DỮ LIỆU
                $sql = "SELECT * FROM thuc_don";
                $result = $conn->query($sql);

                // 3. HIỂN THỊ DỮ LIỆU RA BẢNG
                if ($result->num_rows > 0) {
                    // Lặp qua từng dòng dữ liệu
                    while ($row = $result->fetch_assoc()) {
                        // Định dạng tiền tệ (VD: 65000 -> 65.000 VND)
                        $gia_formatted = number_format($row["gia"], 0, ',', '.') . ' VND';

                        echo "<tr>";
                        echo "<td>" . $row["loai_mon"] . "</td>";
                        echo "<td>" . $row["ma_mon"] . "</td>";
                        echo "<td>" . $row["ten_mon"] . "</td>";
                        echo "<td>" . $row["nhom_thuc_don"] . "</td>";
                        echo "<td>" . $row["don_vi"] . "</td>";
                        echo "<td>" . $gia_formatted . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Chưa có dữ liệu nào</td></tr>";
                }

                // 4. ĐÓNG KẾT NỐI
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