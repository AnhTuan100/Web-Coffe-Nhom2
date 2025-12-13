<?php
function check_login() {
    if (!isset($_SESSION['nhanvien_id'])) {
        header("Location: index.php");
        exit();
    }
}
?>