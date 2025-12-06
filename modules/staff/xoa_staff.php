<?php
require_once '../../include/ketnoi.php';

// Kiểm tra xem có ID truyền lên không
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM nhan_vien WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Xóa nhân viên thành công!'); 
                window.location.href='staff.php';
              </script>";
    } else {
        echo "Lỗi xóa: " . $conn->error;
    }
} else {
    // Nếu không có ID thì quay về trang danh sách
    header("Location: staff.php");
}
$conn->close();
