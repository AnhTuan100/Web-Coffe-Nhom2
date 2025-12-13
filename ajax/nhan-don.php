<?php
require '../includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['nhanvien_id'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit();
}

$id = intval($_POST['id']);
$sql = "UPDATE donhang SET trangthai = 'da_nhan' WHERE id = $id AND trangthai = 'cho_xac_nhan'";

if (mysqli_query($conn, $sql) && mysqli_affected_rows($conn) > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hoặc đã xử lý']);
}
?>