<?php
// --- PHẦN XỬ LÝ PHP (BACKEND) ---
$thong_bao = "";

// Kết nối Database 
require_once '../../include/ketnoi.php';

// Xử lý khi người dùng nhấn nút "Lưu"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_mon = $_POST['ma_mon'];
    $ten_mon = $_POST['ten_mon'];
    $loai_mon = $_POST['loai'];
    $gia_ban = $_POST['gia_ban'];
    $nhom_thuc_don = $_POST['nhom_thuc_don'];
    $don_vi_tinh = $_POST['don_vi_tinh'];
    $anh_dai_dien = "";

    // Xử lý upload ảnh
    if (isset($_FILES['anh_dai_dien']) && $_FILES['anh_dai_dien']['error'] == 0) {
        $target_dir = "../../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $filename = time() . "_" . basename($_FILES["anh_dai_dien"]["name"]);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES["anh_dai_dien"]["tmp_name"], $target_file)) {
            $anh_dai_dien = $target_file;
        }
    }

    $sql = "INSERT INTO them_thuc_don (ma_mon, ten_mon, loai_mon, gia_ban, nhom_thuc_don, don_vi_tinh, anh_dai_dien) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $ma_mon, $ten_mon, $loai_mon, $gia_ban, $nhom_thuc_don, $don_vi_tinh, $anh_dai_dien);

    if ($stmt->execute()) {
        $thong_bao = "<div class='alert alert-success'>Thêm món thành công!</div>";
    } else {
        $thong_bao = "<div class='alert alert-danger'>Lỗi: " . $stmt->error . "</div>";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm món mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 20px auto;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-weight: bold;
            font-size: 1.25rem;
        }

        .custom-input {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 0;
        }

        .required {
            color: red;
        }

        .img-preview-box {
            border: 1px dashed #ccc;
            width: 100%;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8f9fa;
            position: relative;
            overflow: hidden;
        }

        .img-preview-box img {
            max-width: 100%;
            max-height: 100%;
        }

        .table-custom thead {
            background-color: #a89388;
            color: white;
        }

        .btn-close-custom {
            background: black;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: bold;
        }

        .section-title {
            border-top: 1px solid #ccc;
            margin-top: 20px;
            pt-2;
            position: relative;
        }

        .section-title span {
            background: #fff;
            padding-right: 10px;
            font-weight: bold;
            color: #555;
            position: absolute;
            top: -12px;
            left: 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-container">
            <div class="modal-header">
                <div class="modal-title">Thêm món</div>
                <a href="#" class="btn-close-custom">×</a>
            </div>

            <?= $thong_bao ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label fw-bold">Loại</label>
                            <div class="col-sm-9 d-flex align-items-center">
                                <div class="form-check me-4">
                                    <input class="form-check-input" type="radio" name="loai" id="do_uong" value="do_uong" checked>
                                    <label class="form-check-label" for="do_uong">Đồ uống</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="loai" id="mon_an" value="mon_an">
                                    <label class="form-check-label" for="mon_an">Món ăn</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label fw-bold">Tên món <span class="required">(*)</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="ten_mon" class="form-control custom-input" placeholder="Trà Dưa Lưới" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-sm-6 col-form-label fw-bold">Mã món <span class="required">(*)</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" name="ma_mon" class="form-control custom-input" placeholder="U06" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-sm-4 col-form-label fw-bold text-end">Giá bán <span class="required">(*)</span></label>
                                    <div class="col-sm-8 d-flex">
                                        <input type="number" name="gia_ban" class="form-control custom-input" placeholder="65000" required>
                                        <span class="input-group-text border-0 bg-transparent">VND</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-sm-6 col-form-label fw-bold">Nhóm thực đơn</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="nhom_thuc_don" class="form-control custom-input" placeholder="Trà">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-sm-4 col-form-label fw-bold text-end">Đơn vị tính <span class="required">(*)</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="don_vi_tinh" class="form-control custom-input" placeholder="Ly" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold mb-2">Ảnh đại diện</label>
                        <div class="img-preview-box mb-2" id="previewBox">
                            <span class="text-muted">No Image</span>
                        </div>
                        <input type="file" name="anh_dai_dien" id="fileInput" class="form-control form-control-sm" accept=".jpg, .jpeg, .png, .gif" onchange="previewImage(event)">
                        <small class="text-muted d-block mt-1 text-center">Chọn các ảnh có định dạng (.jpg, .jpeg, .png, .gif)</small>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="fw-bold border-bottom pb-2">Định lượng nguyên vật liệu <span class="required">(*)</span></h6>
                    <table class="table table-bordered table-custom text-center align-middle">
                        <thead>
                            <tr>
                                <th>Mã NVL</th>
                                <th>Nguyên vật liệu</th>
                                <th>Số lượng</th>
                                <th>Đơn vị tính</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>DUALUOI</td>
                                <td>Dưa Lưới</td>
                                <td>15</td>
                                <td>gram</td>
                            </tr>
                            <tr>
                                <td>TRA</td>
                                <td>Trà</td>
                                <td>60</td>
                                <td>ml</td>
                            </tr>
                            <tr>
                                <td>SUATUOI</td>
                                <td>Sữa tươi không đường</td>
                                <td>20</td>
                                <td>ml</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <button type="submit" class="btn btn-secondary px-4">Lưu</button>
                    <button type="button" class="btn btn-light border px-4">Hủy</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Hàm hiển thị ảnh xem trước
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('previewBox');
                output.innerHTML = '<img src="' + reader.result + '" alt="Preview">';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>

</html>