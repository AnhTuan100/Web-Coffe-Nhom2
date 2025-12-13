<?php
require '../includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['nhanvien_id'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit();
}

$id = intval($_POST['id']);
$lydo = mysqli_real_escape_string($conn, $_POST['lydo']);

$sql = "UPDATE donhang SET trangthai = 'da_tu_choi', ghichu = CONCAT('Từ chối: ', '$lydo') WHERE id = $id AND trangthai = 'cho_xac_nhan'";

if (mysqli_query($conn, $sql) && mysqli_affected_rows($conn) > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn']);
}
?>