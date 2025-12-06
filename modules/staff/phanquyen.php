<?php
require_once '../../include/ketnoi.php';

$id_can_sua = 1;

$tb1 = 'them_nhan_vien';
$col_tb1 = [
    'id'            => 'id',
    'ma_nhan_vien'  => 'ma_nhan_vien',
    'ten_nhan_vien' => 'ten_nhan_vien',
    'vai_tro'       => 'vai_tro',
    'ca_lam_viec'   => 'ca_lam_viec'
];

$tb2 = 'nhan_vien';
$col_tb2 = [
    'id'            => 'id',
    'ten_dang_nhap' => 'ten_dang_nhap',
    'mat_khau'      => 'mat_khau'
];

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vai_tro_moi = $_POST['vai_tro'];
    $ca_lam_viec_moi = $_POST['ca_lam_viec'];
    $mat_khau_moi = $_POST['mat_khau'];
    $xac_nhan_mk = $_POST['xac_nhan_mat_khau'];

    $sql1 = "UPDATE $tb1 SET 
             {$col_tb1['vai_tro']} = '$vai_tro_moi', 
             {$col_tb1['ca_lam_viec']} = '$ca_lam_viec_moi' 
             WHERE {$col_tb1['id']} = $id_can_sua";

    $check1 = $conn->query($sql1);

    $check2 = true;
    if (!empty($mat_khau_moi)) {
        if ($mat_khau_moi === $xac_nhan_mk) {
            $mk_hash = md5($mat_khau_moi);
            $sql2 = "UPDATE $tb2 SET {$col_tb2['mat_khau']} = '$mk_hash' 
                     WHERE {$col_tb2['id']} = $id_can_sua";
            $check2 = $conn->query($sql2);
        } else {
            $message = "<p style='color:red'>Mật khẩu xác nhận không khớp!</p>";
            $check2 = false;
        }
    }

    if ($check1 && $check2 && empty($message)) {
        $message = "<p style='color:green'>Cập nhật thành công!</p>";
    } elseif (empty($message)) {
        $message = "<p style='color:red'>Lỗi SQL: " . $conn->error . "</p>";
    }
}

$sql_select = "SELECT t1.*, t2.{$col_tb2['ten_dang_nhap']}, t2.{$col_tb2['mat_khau']} 
               FROM $tb1 t1 
               JOIN $tb2 t2 ON t1.{$col_tb1['id']} = t2.{$col_tb2['id']} 
               WHERE t1.{$col_tb1['id']} = $id_can_sua";

$result = $conn->query($sql_select);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Không tìm thấy dữ liệu.");
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Phân quyền tài khoản</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/stylephanquyen.css">
</head>

<body>

    <div class="modal-container">
        <div class="header">
            <span>Phân quyền</span>
            <span class="close-btn">x</span>
        </div>

        <?php echo $message; ?>

        <form method="POST" action="">
            <div class="form-body">
                <div class="left-col">
                    <div class="form-group">
                        <label>Mã nhân viên <span class="required">(*)</span></label>
                        <input type="text" class="input-readonly" value="<?php echo $row[$col_tb1['ma_nhan_vien']]; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Tên nhân viên <span class="required">(*)</span></label>
                        <input type="text" class="input-readonly" value="<?php echo $row[$col_tb1['ten_nhan_vien']]; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Vai trò</label>
                        <select name="vai_tro">
                            <option value="pha_che" <?php if ($row[$col_tb1['vai_tro']] == 'pha_che') echo 'selected'; ?>>Pha chế</option>
                            <option value="thu_ngan" <?php if ($row[$col_tb1['vai_tro']] == 'thu_ngan') echo 'selected'; ?>>Thu ngân</option>
                            <option value="quan_ly" <?php if ($row[$col_tb1['vai_tro']] == 'quan_ly') echo 'selected'; ?>>Quản lý</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ca làm việc</label>
                        <input type="text" name="ca_lam_viec" value="<?php echo $row[$col_tb1['ca_lam_viec']]; ?>">
                    </div>

                    <div class="form-group">
                        <label>Tên đăng nhập <span class="required">(*)</span></label>
                        <input type="text" class="input-readonly" value="<?php echo $row[$col_tb2['ten_dang_nhap']]; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Mật khẩu <span class="required">(*)</span></label>
                        <input type="password" name="mat_khau" class="input-readonly" style="background: #ccc" placeholder="••••••••">
                    </div>

                    <div class="form-group">
                        <label>Xác nhận mật khẩu <span class="required">(*)</span></label>
                        <input type="password" name="xac_nhan_mat_khau" class="input-readonly" style="background: #ccc" placeholder="••••••••">
                    </div>
                </div>

                <div class="right-col">
                    <fieldset class="avatar-box">
                        <legend style="font-size: 12px; margin-left: 10px; padding: 0 5px;">Ảnh đại diện</legend>
                        <div class="avatar-circle">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </fieldset>
                </div>
            </div>

            <div class="footer-actions">
                <button type="submit" class="btn btn-save">Lưu</button>
                <button type="button" class="btn btn-cancel">Hủy</button>
            </div>
        </form>
    </div>

</body>

</html>