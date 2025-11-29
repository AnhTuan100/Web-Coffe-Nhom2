<?php
// FILE: modules/Sales/sales_data.php
session_start();
require_once '../../include/ketnoi.php';

// 1. Hàm định dạng tiền (Dùng function_exists để tránh lỗi trùng lặp nếu include nhiều nơi)
if (!function_exists('formatMoney')) {
    function formatMoney($number)
    {
        if ($number == 0 || $number == null) return "0";
        return number_format($number, 0, ',', '.') . ' VND';
    }
}

// 2. Lấy dữ liệu Bán hàng theo Ngày
// Giả sử bảng hóa đơn là 'hoa_don', cột ngày là 'ngay_tao', tổng tiền là 'tong_tien'
// Dùng hàm DATE() để cắt bỏ giờ phút giây, chỉ lấy ngày tháng năm
$sql = "SELECT DATE(ngay_tao) as ngay_ban, SUM(tong_tien) as tong_ngay 
        FROM hoa_don 
        GROUP BY DATE(ngay_tao) 
        ORDER BY ngay_ban DESC";

$result = $conn->query($sql);
$sales_list = [];
$grand_total = 0; // Tổng cộng toàn bộ

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sales_list[] = $row;
        $grand_total += $row['tong_ngay']; // Cộng dồn vào tổng cuối
    }
}
