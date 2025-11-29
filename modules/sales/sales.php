<?php
// Kết nối với file Logic
require_once 'sales_handler.php';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Báo cáo Bán Hàng</title>
    <link rel="stylesheet" href="../../css/stylesales.css">
</head>

<body>

    <div class="navbar">
        <div class="menu-items">
            <span class="icon-hamburger">&#9776;</span>
            <a href="../menu/Menu.php">Thực Đơn</a>
            <a href="../Staff/Staff.php">Nhân viên</a>
            <a href="../Revenue/Revenue.php">Doanh Thu</a>
            <a href="#" class="active">Bán Hàng</a>
        </div>
        <div class="user-info">
            (<?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Admin'; ?>)
            <?php echo isset($_SESSION['ten_nv']) ? $_SESSION['ten_nv'] : 'User'; ?>
            👤
        </div>
    </div>

    <div class="page-title">
        Báo cáo Bán Hàng
        <a href="#" class="export-excel">Xuất file Excel</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Ngày</th>
                    <th style="width: 25%;">Tổng</th>
                    <th style="width: 20%;">Tiền hàng</th>
                    <th style="width: 20%;">Tiền thu từ dịch vụ</th>
                    <th style="width: 20%;">Tiền thu khác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sales_list)): ?>
                    <?php foreach ($sales_list as $row): ?>
                        <tr>
                            <td><?php echo date("d/m/Y", strtotime($row['ngay_ban'])); ?></td>

                            <td><?php echo formatMoney($row['tong_ngay']); ?></td>

                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Chưa có dữ liệu bán hàng</td>
                    </tr>
                <?php endif; ?>
            </tbody>

            <tfoot>
                <tr>
                    <td>Tổng</td>
                    <td><?php echo formatMoney($grand_total); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>

</html>