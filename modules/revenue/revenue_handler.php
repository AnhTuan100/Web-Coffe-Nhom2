<?php
// FILE: modules/revenue/revenue_handler.php
session_start();
require_once '../../include/ketnoi.php';

// --- 1. ĐỊNH NGHĨA HÀM (CHỈ VIẾT 1 LẦN) ---
function formatMoney($number)
{
    if ($number == 0 || $number == null) return "0";
    return number_format($number, 0, ',', '.');
}

// Hàm lấy chi phí theo loại
function getExpense($conn, $type)
{
    // Kiểm tra kết nối trước
    if (!$conn) return 0;

    $sql = "SELECT SUM(so_tien) as total FROM chi_phi WHERE loai_chi_phi = '$type'";
    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        return $row['total'] ? $row['total'] : 0;
    }
    return 0;
}

// --- 2. TÍNH TOÁN DỮ LIỆU ---

// A. Doanh thu
$tien_ban_hang = 0;
if ($conn) {
    $sql_dt = "SELECT SUM(tong_tien) as total FROM hoa_don";
    $result_dt = $conn->query($sql_dt);
    if ($result_dt) {
        $row_dt = $result_dt->fetch_assoc();
        $tien_ban_hang = $row_dt['total'] ? $row_dt['total'] : 0;
    }
}

$tien_dich_vu = 0;
$tien_thu_khac = 0;
$tong_doanh_thu = $tien_ban_hang + $tien_dich_vu + $tien_thu_khac;

// B. Chi phí
$chi_phi_nguyen_lieu = getExpense($conn, 'nguyen_lieu');
$chi_phi_nhan_vien   = getExpense($conn, 'nhan_vien');
$chi_phi_khac        = getExpense($conn, 'khac');

$tong_chi_phi = $chi_phi_nguyen_lieu + $chi_phi_nhan_vien + $chi_phi_khac;

// C. Lợi nhuận
$loi_nhuan = $tong_doanh_thu - $tong_chi_phi;
