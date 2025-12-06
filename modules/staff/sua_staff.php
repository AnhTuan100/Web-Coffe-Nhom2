<?php
require_once '../../include/ketnoi.php';

// --- PHẦN 1: LẤY DỮ LIỆU CŨ ---
$row = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn lấy thông tin nhân viên theo ID
    $sql = "SELECT * FROM nhan_vien WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Không tìm thấy nhân viên này! (Kiểm tra lại ID: $id)");
    }
} else {
    header("Location: staff.php");
    exit();
}

// --- PHẦN 2: XỬ LÝ LƯU (KHI BẤM NÚT) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_update = $_POST['id'];
    $ma_nv = $_POST['ma_nv'];
    $ten_nv = $_POST['ten_nv'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $ca_lam_viec = $_POST['ca_lam_viec'];

    // Câu lệnh cập nhật
    $sql_update = "UPDATE nhan_vien 
                   SET ma_nv='$ma_nv', ten_nv='$ten_nv', ngay_sinh='$ngay_sinh', 
                       gioi_tinh='$gioi_tinh', ca_lam_viec='$ca_lam_viec' 
                   WHERE id='$id_update'";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>
                alert('Cập nhật thành công!'); 
                window.location.href='staff.php';
              </script>";
    } else {
        echo "<script>alert('Lỗi: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa Nhân Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            height: 100vh;
            align-items: center;
        }

        .form-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-save {
            width: 100%;
            padding: 10px;
            background: green;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-cancel {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #333;
        }

        .input-readonly {
            background-color: #eee;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

    <div class="form-box">
        <h2 style="text-align: center;">Cập nhật Nhân viên</h2>

        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="form-group">
                <label>Mã Nhân viên:</label>
                <input type="text" name="ma_nv" value="<?php echo $row['ma_nv']; ?>" required>
            </div>

            <div class="form-group">
                <label>Tên Nhân viên:</label>
                <input type="text" name="ten_nv" value="<?php echo $row['ten_nv']; ?>" required>
            </div>

            <div class="form-group">
                <label>Tên đăng nhập (Không được sửa):</label>
                <input type="text" class="input-readonly" value="<?php echo isset($row['ten_dang_nhap']) ? $row['ten_dang_nhap'] : ''; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Ngày sinh:</label>
                <input type="date" name="ngay_sinh" value="<?php echo $row['ngay_sinh']; ?>">
            </div>

            <div class="form-group">
                <label>Giới tính:</label>
                <select name="gioi_tinh">
                    <option value="Nam" <?php if ($row['gioi_tinh'] == 'Nam') echo 'selected'; ?>>Nam</option>
                    <option value="Nữ" <?php if ($row['gioi_tinh'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
                </select>
            </div>

            <div class="form-group">
                <label>Ca làm việc:</label>
                <input type="text" name="ca_lam_viec" value="<?php echo $row['ca_lam_viec']; ?>">
            </div>

            <button type="submit" class="btn-save">Lưu thay đổi</button>
            <a href="staff.php" class="btn-cancel">Hủy</a>
        </form>
    </div>

</body>

</html>