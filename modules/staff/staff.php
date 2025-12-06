<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhân Viên</title>
    <link rel="stylesheet" href="../../css/stylemenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            (<?php session_start();
                echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Admin'; ?>)
            <?php echo isset($_SESSION['ten_nv']) ? $_SESSION['ten_nv'] : 'User'; ?>
            👤
        </div>
    </div>

    <div class="toolbar">
        <a class="btn" href="them_staff.php" style="background: green; color: white;">+ Thêm</a>
        <a class="btn" href="phanquyen.php" style="background: #007bff; color: white;">Phân Quyền</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Tên đăng nhập</th>
                    <th>Tên Nhân viên</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Ca làm việc</th>
                    <th style="text-align: center;">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../../include/ketnoi.php';

                // Lấy danh sách nhân viên
                $sql = "SELECT * FROM nhan_vien";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Xử lý hiển thị ngày sinh (VN)
                        $ngay_sinh_vn = date("d/m/Y", strtotime($row["ngay_sinh"]));

                        // Lấy ID để sửa xóa (Ưu tiên cột id, nếu không có thì dùng ma_nv)
                        $id = isset($row['id']) ? $row['id'] : $row['ma_nv'];

                        echo "<tr>";
                        echo "<td>" . $row["ma_nv"] . "</td>";
                        echo "<td>" . $row["ten_dang_nhap"] . "</td>";
                        echo "<td>" . $row["ten_nv"] . "</td>";
                        echo "<td>" . $ngay_sinh_vn . "</td>";
                        echo "<td>" . $row["gioi_tinh"] . "</td>";
                        echo "<td>" . $row["ca_lam_viec"] . "</td>";

                        // Cột Chức năng: Sửa và Xóa
                        echo "<td style='text-align: center;'>
                                <a href='sua_staff.php?id=$id' class='btn-action btn-edit' title='Sửa'><i class='fa-solid fa-pen'></i></a>
                                <a href='xoa_staff.php?id=$id' class='btn-action btn-delete' title='Xóa' onclick='return confirm(\"Bạn có chắc chắn muốn xóa nhân viên: " . $row['ten_nv'] . " không?\");'><i class='fa-solid fa-trash'></i></a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center'>Chưa có nhân viên nào</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <style>
        .btn-action {
            padding: 6px 10px;
            border-radius: 4px;
            color: #fff;
            text-decoration: none;
            margin: 0 4px;
            display: inline-block;
        }

        .btn-edit {
            background-color: #f0ad4e;
        }

        .btn-delete {
            background-color: #d9534f;
        }

        .btn-action:hover {
            opacity: 0.8;
        }
    </style>
</body>

</html>