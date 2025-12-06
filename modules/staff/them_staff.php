<?php
// Nhúng file kết nối
require_once '../../include/ketnoi.php';

$message = "";

// Kiểm tra xem người dùng có nhấn nút Lưu không
if (isset($_POST['btn_luu'])) {
    // 1. Lấy dữ liệu từ form
    $ma_nv = $_POST['ma_nhan_vien'];
    $ten_nv = $_POST['ten_nhan_vien'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $so_cmnd = $_POST['so_cmnd'];
    $ngay_cap = $_POST['ngay_cap'];
    $vai_tro = $_POST['vai_tro'];
    $ca_lam_viec = $_POST['ca_lam_viec'];

    // 2. Xử lý upload ảnh
    $avatar_name = "";
    if (isset($_FILES['anh_dai_dien']) && $_FILES['anh_dai_dien']['name'] != "") {
        $target_dir = "../../uploads/";
        $avatar_name = basename($_FILES["anh_dai_dien"]["name"]);
        $target_file = $target_dir . $avatar_name;
        move_uploaded_file($_FILES["anh_dai_dien"]["tmp_name"], $target_file);
    }

    $sql = "INSERT INTO them_nhan_vien (ma_nhan_vien, ten_nhan_vien, gioi_tinh, ngay_sinh, so_cmnd, ngay_cap, vai_tro, ca_lam_viec, anh_dai_dien) 
            VALUES ('$ma_nv', '$ten_nv', '$gioi_tinh', '$ngay_sinh', '$so_cmnd', '$ngay_cap', '$vai_tro', '$ca_lam_viec', '$avatar_name')";

    // 4. Thực thi
    if ($conn->query($sql) === TRUE) {
        $message = "<div style='color: green; font-weight: bold; margin-bottom: 10px;'>Thêm nhân viên thành công!</div>";
    } else {
        $message = "<div style='color: red; font-weight: bold; margin-bottom: 10px;'>Lỗi: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm nhân viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .modal-content {
            background-color: #fff;
            width: 90%;
            max-width: 900px;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 2px solid #e0e0e0;
        }

        .modal-title {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }

        .close-btn {
            background: #000;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        .modal-body {
            padding: 25px 30px;
            display: flex;
            gap: 30px;
        }

        .form-section-left {
            flex: 2;
            display: grid;
            grid-template-columns: auto 1fr auto 1fr;
            row-gap: 15px;
            column-gap: 15px;
            align-items: center;
        }

        .form-label {
            font-weight: 500;
            white-space: nowrap;
        }

        .required {
            color: red;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 10px 12px;
            background-color: #cfd3d6;
            border: none;
            border-radius: 3px;
        }

        .form-input[readonly] {
            background-color: #bfc3c6;
            color: #555;
        }

        .full-width-input {
            grid-column: 2 / span 3;
        }

        .form-section-right {
            flex: 1;
            max-width: 250px;
        }

        .avatar-container {
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
        }

        .avatar-placeholder {
            width: 150px;
            height: 150px;
            border: 3px solid #333;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
            overflow: hidden;
        }

        .avatar-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-footer {
            padding: 15px 30px 25px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 10px 25px;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-save {
            background-color: #a0a0a0;
        }

        .btn-cancel {
            background-color: #c0c0c0;
        }
    </style>
</head>

<body>

    <div class="modal-content">
        <form method="POST" action="" enctype="multipart/form-data">

            <div class="modal-header">
                <h2 class="modal-title">Thêm nhân viên</h2>
                <button type="button" class="close-btn"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div style="padding: 10px 30px;"><?php echo $message; ?></div>

            <div class="modal-body">
                <div class="form-section-left">
                    <label class="form-label">Mã nhân viên <span class="required">(*)</span></label>
                    <input type="text" name="ma_nhan_vien" class="form-input full-width-input" value="PC03">

                    <label class="form-label">Tên nhân viên <span class="required">(*)</span></label>
                    <input type="text" name="ten_nhan_vien" class="form-input full-width-input" value="Jack 5 củ">

                    <label class="form-label">Giới tính</label>
                    <select name="gioi_tinh" class="form-select">
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>

                    <label class="form-label" style="justify-self: end;">Ngày sinh</label>
                    <input type="date" name="ngay_sinh" class="form-input" value="2004-11-20">

                    <label class="form-label">Số CMND</label>
                    <input type="text" name="so_cmnd" class="form-input" value="023456789">

                    <label class="form-label" style="justify-self: end;">Ngày cấp</label>
                    <input type="date" name="ngay_cap" class="form-input" value="2019-08-11">

                    <label class="form-label">Vai trò</label>
                    <input type="text" name="vai_tro" class="form-input full-width-input" value="Pha chế">

                    <label class="form-label">Ca làm việc</label>
                    <input type="text" name="ca_lam_viec" class="form-input full-width-input" value="Chiều, Tối">
                </div>

                <div class="form-section-right">
                    <div class="avatar-container">
                        <span style="display:block; margin-bottom:10px; font-weight:500;">Ảnh đại diện</span>
                        <div class="avatar-placeholder">
                            <i class="fa-solid fa-user" id="avatarIcon"></i>
                            <img id="avatarPreview" src="#" alt="" style="display:none;">
                        </div>

                        <input type="file" name="anh_dai_dien" id="fileInput" accept="image/*" style="margin-top: 10px; font-size: 12px;">

                        <p style="font-size: 12px; color: #666; margin-top: 10px;">
                            Chọn các ảnh có định dạng<br>(.jpg, .jpeg, .png, .gif)
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" name="btn_luu" class="btn btn-save">Lưu</button>
                <button type="button" class="btn btn-cancel">Hủy</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('fileInput').onchange = function(evt) {
            var tgt = evt.target || window.event.srcElement,
                files = tgt.files;

            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function() {
                    document.getElementById('avatarIcon').style.display = 'none';
                    document.getElementById('avatarPreview').src = fr.result;
                    document.getElementById('avatarPreview').style.display = 'block';
                }
                fr.readAsDataURL(files[0]);
            }
        }
    </script>
</body>

</html>