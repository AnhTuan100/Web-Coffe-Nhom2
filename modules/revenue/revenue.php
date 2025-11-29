<?php
// FILE: modules/Revenue/Revenue.php

require_once 'revenue_handler.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Báo cáo Doanh Thu</title>
    <link rel="stylesheet" href="../../css/stylerevenue.css">
</head>

<body>

    <div class="navbar">
        <div class="menu-items">
            <span class="icon-hamburger">&#9776;</span> <a href="../menu/Menu.php">Thực Đơn</a>
            <a href="../Staff/Staff.php">Nhân viên</a>
            <a href="#" class="active">Doanh Thu</a>
            <a href="../sales/sales.php">Bán Hàng</a>
        </div>
        <div class="user-info">
            (<?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Admin'; ?>)
            <?php echo isset($_SESSION['ten_nv']) ? $_SESSION['ten_nv'] : 'User'; ?>
            <span style="font-size: 20px;">👤</span>
        </div>
    </div>

    <div class="page-title">
        Báo cáo Doanh Thu
        <a href="#" class="export-excel">Xuất file Excel</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Khoản mục</th>
                    <th>Tiền</th>
                </tr>
            </thead>
            <tbody>
                <tr class="row-section">
                    <td>I</td>
                    <td>Tổng Doanh thu</td>
                    <td><?php echo formatMoney($tong_doanh_thu); ?></td>
                </tr>
                <tr class="row-item">
                    <td>1</td>
                    <td>Tiền bán hàng</td>
                    <td><?php echo formatMoney($tien_ban_hang); ?></td>
                </tr>
                <tr class="row-item">
                    <td>2</td>
                    <td>Tiền thu từ dịch vụ</td>
                    <td><?php echo formatMoney($tien_dich_vu); ?></td>
                </tr>
                <tr class="row-item">
                    <td>3</td>
                    <td>Tiền thu khác</td>
                    <td><?php echo formatMoney($tien_thu_khac); ?></td>
                </tr>

                <tr class="row-section">
                    <td>II</td>
                    <td>Tổng Chi phí</td>
                    <td><?php echo formatMoney($tong_chi_phi); ?></td>
                </tr>
                <tr class="row-item">
                    <td>1</td>
                    <td>Chi phí nguyên liệu</td>
                    <td><?php echo formatMoney($chi_phi_nguyen_lieu); ?></td>
                </tr>
                <tr class="row-item">
                    <td>2</td>
                    <td>Chi phí nhân viên</td>
                    <td><?php echo formatMoney($chi_phi_nhan_vien); ?></td>
                </tr>
                <tr class="row-item">
                    <td>3</td>
                    <td>Chi phí khác (điện, nước, wifi)</td>
                    <td><?php echo formatMoney($chi_phi_khac); ?></td>
                </tr>

                <tr class="row-profit">
                    <td>III</td>
                    <td>Lợi nhuận</td>
                    <td><?php echo formatMoney($loi_nhuan); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>