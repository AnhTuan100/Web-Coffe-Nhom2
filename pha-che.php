<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login();

// Header chống cache
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pha chế</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family: Arial, Helvetica, sans-serif; }
        body { display:flex; height:100vh; background:#f0f2f5; color:#2c3e50; }

        .sidebar { width: 260px; background: #ecf0f1; border-right: 1px solid #bdc3c7; }
        .sidebar ul { list-style:none; }
        .sidebar li a { display: flex; align-items: center; padding: 18px 25px; color: #34495e; text-decoration: none; font-size: 16px; transition: background 0.3s; }
        .sidebar li a i { margin-right: 18px; font-size: 22px; width: 30px; text-align: center; color: #7f8c8d; }
        .sidebar li a:hover { background: #d6dbdc; }
        .sidebar li a.active { background: #bdc3c7; font-weight: bold; color: #2c3e50; }

        .main { flex: 1; display: flex; flex-direction: column; }
        .header { background: white; padding: 20px 30px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .header h1 { font-size: 26px; font-weight: normal; }
        .user-info { display: flex; align-items: center; gap: 20px; font-size: 15px; }
        .user-info i { font-size: 22px; color: #7f8c8d; cursor: pointer; position: relative; }
        .user-info i::after { content: '3'; position: absolute; top: -8px; right: -8px; background: #e74c3c; color: white; font-size: 12px; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .avatar { width: 45px; height: 45px; border-radius: 50%; background: #3498db; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px; }

        .content { padding: 30px; flex: 1; overflow-y: auto; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .search-input { padding: 12px 20px; width: 350px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; background: white url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="%23999" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>') no-repeat 95% center; }
        .filter-btn { padding: 12px 20px; background: white; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; cursor: pointer; display: flex; align-items: center; gap: 8px; }

        table { width: 100%; background: white; border-collapse: separate; border-spacing: 0; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
        th { background: #f8f9fa; padding: 18px 20px; text-align: left; font-weight: normal; color: #34495e; font-size: 15px; }
        td { padding: 18px 20px; border-top: 1px solid #eee; vertical-align: top; }
        .actions button { border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; font-size: 14px; }
        .btn-dang-lam { background: #f39c12; color: white; }
        .btn-hoan-thanh { background: #27ae60; color: white; }
        .btn-huy { background: #e74c3c; color: white; }
        .btn-in { background: #3498db; color: white; margin-left: 10px; }
        .no-data { text-align: center; padding: 80px; color: #95a5a6; font-size: 18px; }
        .mon-list { list-style: none; }
        .mon-item { margin-bottom: 10px; }
        .mon-item span { font-weight: bold; }
        .trang-thai { font-size: 14px; padding: 5px 10px; border-radius: 4px; }
        .dang-pha-che { background: #f39c12; color: white; }
        .hoan-thanh { background: #27ae60; color: white; }
        .gap-su-co { background: #e74c3c; color: white; }
    </style>
</head>
<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">
        <div class="header">
            <h1>Pha chế</h1>
            <div class="user-info">
                <i class="far fa-bell"></i>
                <span>Nhân viên</span>
                <div class="avatar">
                    <?= strtoupper(substr($_SESSION['nhanvien_hoten'] ?? 'NV', 0, 2)) ?>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="top-bar">
                <input type="text" class="search-input" placeholder="Tìm kiếm">
                <button class="filter-btn">Đơn cần pha <i class="fas fa-chevron-down"></i></button>
            </div>

            <?php
            $sql = "SELECT * FROM donhang WHERE trangthai IN ('da_nhan', 'dang_pha_che') ORDER BY thoigiannhan ASC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 0): ?>
                <div class="no-data">Hiện tại không có đơn hàng cần pha chế!</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Món</th>
                            <th>Số lượng</th>
                            <th>Ghi chú</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="danh-sach-don">
                        <?php while ($don = mysqli_fetch_assoc($result)): ?>
                            <tr data-id="<?= $don['id'] ?>">
                                <td><strong><?= htmlspecialchars($don['madon']) ?></strong></td>
                                <td><?= htmlspecialchars($don['khachhang']) ?></td>
                                <td>
                                    <ul class="mon-list">
                                        <?php
                                        $ct_sql = "SELECT id, tenmon, soluong, trangthai_mon FROM chitietdonhang WHERE donhang_id = " . $don['id'];
                                        $ct_res = mysqli_query($conn, $ct_sql);
                                        while ($ct = mysqli_fetch_assoc($ct_res)) {
                                            $status = $ct['trangthai_mon'] ?? 'dang_pha_che';
                                            $status_label = [
                                                'dang_pha_che' => 'Đang pha chế',
                                                'hoan_thanh' => 'Hoàn thành',
                                                'gap_su_co' => 'Gặp sự cố'
                                            ][$status];
                                            $status_class = $status;
                                            echo '<li class="mon-item" data-mon-id="' . $ct['id'] . '">';
                                            echo htmlspecialchars($ct['tenmon']) . ' x' . $ct['soluong'];
                                            echo ' <span class="trang-thai ' . $status_class . '">' . $status_label . '</span>';
                                            echo '</li>';
                                        }
                                        ?>
                                    </ul>
                                </td>
                                <td>
                                    <?php
                                    $tong_sql = "SELECT SUM(soluong) AS tong_sl FROM chitietdonhang WHERE donhang_id = " . $don['id'];
                                    $tong_res = mysqli_query($conn, $tong_sql);
                                    $tong_row = mysqli_fetch_assoc($tong_res);
                                    echo $tong_row['tong_sl'] ?? 0;
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($don['ghichu'] ?? '-') ?></td>
                                <td class="actions">
                                    <button class="btn-in" onclick="inNhan(<?= $don['id'] ?>)">In nhãn</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
    // Cập nhật trạng thái món
    $('.mon-item').on('click', function() {
        let monId = $(this).data('mon-id');
        let newStatus = prompt("Cập nhật trạng thái (dang_pha_che / hoan_thanh / gap_su_co):");
        if (newStatus) {
            $.post("ajax/cap-nhat-trang-thai-mon.php", { mon_id: monId, status: newStatus }, function(res) {
                if (res.success) {
                    location.reload(); // Reload để cập nhật
                } else {
                    alert("Lỗi: " + res.message);
                }
            }, "json");
        }
    });

    // In nhãn (in đơn giản)
    function inNhan(id) {
        let don = $('tr[data-id=' + id + ']');
        let printContent = '<h2>Mã đơn: ' + don.find('td:first').text() + '</h2>';
        printContent += '<p>Khách: ' + don.find('td:nth-child(2)').text() + '</p>';
        printContent += '<p>Món: ' + don.find('td:nth-child(3)').html() + '</p>';
        printContent += '<p>Ghi chú: ' + don.find('td:nth-child(5)').text() + '</p>';
        let w = window.open();
        w.document.write(printContent);
        w.print();
        w.close();
    }

    // Check đơn mới và phát âm thanh
    setInterval(function() {
        $.get('ajax/kiem-tra-don-pha-moi.php', function(soDon) {
            if (soDon > 0) {
                let audio = new Audio('assets/sound/new-order.mp3');
                audio.play();
                location.reload();
            }
        });
    }, 10000);
    </script>
</body>
</html>