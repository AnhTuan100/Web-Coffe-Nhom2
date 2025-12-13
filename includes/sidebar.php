<!-- Thanh điều hướng bên trái -->
<div class="sidebar">
    <ul>
        <li>
            <a href="don-hang-moi.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'don-hang-moi.php') ? 'class="active"' : ''; ?>>
                <i class="fas fa-clipboard-list"></i> Đơn hàng mới
            </a>
        </li>
        <li>
            <a href="pha-che.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'pha-che.php') ? 'class="active"' : ''; ?>>
                <i class="fas fa-coffee"></i> Pha chế
            </a>
        </li>
        <li>
            <a href="quan-ly-ban.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'quan-ly-ban.php') ? 'class="active"' : ''; ?>>
                <i class="fas fa-th-large"></i> Quản lý bàn
            </a>
        </li>
        <li>
            <a href="thanh-toan.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'thanh-toan.php') ? 'class="active"' : ''; ?>>
                <i class="fas fa-receipt"></i> Thanh toán
            </a>
        </li>
        <li>
            <a href="bao-cao.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'bao-cao.php') ? 'class="active"' : ''; ?>>
                <i class="fas fa-chart-pie"></i> Báo cáo
            </a>
        </li>
        <li>
            <a href="quan-ly-nguyen-lieu.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'quan-ly-nguyen-lieu.php') ? 'class="active"' : ''; ?>>
                <i class="fas fa-boxes"></i> Quản lý nguyên liệu
            </a>
        </li>
    </ul>
</div>