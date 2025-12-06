<?php
require_once '../../include/ketnoi.php';

// 1. LẤY DỮ LIỆU CŨ ĐỂ HIỆN LÊN FORM
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM thuc_don WHERE id = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Không tìm thấy món ăn này.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_update = $_POST['id'];
    $ten_mon = $_POST['ten_mon'];
    $gia = $_POST['gia'];
    $don_vi = $_POST['don_vi'];
    $loai_mon = $_POST['loai_mon'];
    $ma_mon = $_POST['ma_mon'];
    $nhom_thuc_don = $_POST['nhom_thuc_don'];

    $sql_update = "UPDATE thuc_don 
                   SET ten_mon='$ten_mon', gia='$gia', don_vi='$don_vi', loai_mon='$loai_mon', nhom_thuc_don='$nhom_thuc_don', ma_mon='$ma_mon'
                   WHERE id='$id_update'";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>
                alert('Cập nhật thành công!'); 
                window.location.href='menu.php';
              </script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa món ăn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-save {
            background: green;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-cancel {
            background: #ccc;
            color: black;
            display: block;
            text-align: center;
            text-decoration: none;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2 style="text-align: center;">Cập nhật món ăn</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="form-group">
                <label>Mã món:</label>
                <input type="text" name="ma_mon" value="<?php echo $row['ma_mon']; ?>">
            </div>

            <div class="form-group">
                <label>Tên món:</label>
                <input type="text" name="ten_mon" value="<?php echo $row['ten_mon']; ?>" required>
            </div>

            <div class="form-group">
                <label>Loại món:</label>
                <input type="text" name="loai_mon" value="<?php echo $row['loai_mon']; ?>">
            </div>

            <div class="form-group">
                <label>Nhóm thực đơn:</label>
                <input type="text" name="nhom_thuc_don" value="<?php echo $row['nhom_thuc_don']; ?>">
            </div>

            <div class="form-group">
                <label>Đơn vị tính:</label>
                <input type="text" name="don_vi" value="<?php echo $row['don_vi']; ?>">
            </div>

            <div class="form-group">
                <label>Giá:</label>
                <input type="number" name="gia" value="<?php echo $row['gia']; ?>" required>
            </div>

            <button type="submit" class="btn-save">Lưu thay đổi</button>
            <a href="menu.php" class="btn-cancel">Hủy</a>
        </form>
    </div>

</body>

</html>