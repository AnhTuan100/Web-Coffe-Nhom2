<?php
require_once '../../include/ketnoi.php';

// Kiểm tra xem có ID được truyền lên không
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM thuc_don WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Xóa thành công thì quay lại trang danh sách
        echo "<script>
                alert('Xóa thành công!'); 
                window.location.href='menu.php';
              </script>";
    } else {
        echo "Lỗi xóa: " . $conn->error;
    }
} else {
    // Nếu không có ID thì quay về trang chủ
    header("Location: menu.php");
}
$conn->close();
