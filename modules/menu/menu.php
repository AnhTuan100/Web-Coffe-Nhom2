<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Thực Đơn</title>
    <link rel="stylesheet" href="../../css/stylemenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            (<?php session_start();
                echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Admin'; ?>)
            <?php echo isset($_SESSION['ten_nv']) ? $_SESSION['ten_nv'] : 'User'; ?>
            👤
        </div>
    </div>

    <div class="toolbar">
        <a class="btn" href="them_menu.php" style="background-color: green; color: white; text-decoration: none; padding: 10px;">+ Thêm món mới</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Loại món</th>
                    <th>Mã món</th>
                    <th>Tên món</th>
                    <th>Nhóm</th>
                    <th>Đơn vị</th>
                    <th>Giá</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../../include/ketnoi.php';
                $sql = "SELECT * FROM thuc_don";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $gia_formatted = number_format($row["gia"], 0, ',', '.') . ' VND';

                        $id = $row['id'];

                        echo "<tr>";
                        echo "<td>" . $row["loai_mon"] . "</td>";
                        echo "<td>" . $row["ma_mon"] . "</td>";
                        echo "<td>" . $row["ten_mon"] . "</td>";
                        echo "<td>" . $row["nhom_thuc_don"] . "</td>";
                        echo "<td>" . $row["don_vi"] . "</td>";
                        echo "<td>" . $gia_formatted . "</td>";

                        echo "<td style='text-align: center;'>
                                <a href='sua_menu.php?id=$id' class='btn-action btn-edit' title='Sửa'><i class='fa-solid fa-pen'></i></a>
                                <a href='xoa_menu.php?id=$id' class='btn-action btn-delete' title='Xóa' onclick='return confirm(\"Bạn có chắc chắn muốn xóa món: " . $row['ten_mon'] . " không?\");'><i class='fa-solid fa-trash'></i></a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Chưa có dữ liệu nào</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <style>
        .btn-action {
            padding: 8px 12px;
            border-radius: 4px;
            color: #fff;
            text-decoration: none;
            margin: 0 5px;
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