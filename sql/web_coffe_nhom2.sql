-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 29, 2025 lúc 11:11 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `web_coffe_nhom2`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_phi`
--

CREATE TABLE `chi_phi` (
  `id` int(11) NOT NULL,
  `ten_chi_phi` varchar(100) DEFAULT NULL,
  `loai_chi_phi` varchar(50) DEFAULT NULL,
  `so_tien` decimal(15,0) DEFAULT NULL,
  `ngay_chi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_phi`
--

INSERT INTO `chi_phi` (`id`, `ten_chi_phi`, `loai_chi_phi`, `so_tien`, `ngay_chi`) VALUES
(1, 'Nhập cafe hạt', 'nguyen_lieu', 2000000, '2025-11-29 16:40:08'),
(2, 'Nhập sữa tươi', 'nguyen_lieu', 1500000, '2025-11-29 16:40:08'),
(3, 'Lương nhân viên A', 'nhan_vien', 3000000, '2025-11-29 16:40:08'),
(4, 'Tiền điện tháng 10', 'khac', 1000000, '2025-11-29 16:40:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoa_don`
--

CREATE TABLE `hoa_don` (
  `id` int(11) NOT NULL,
  `ma_hd` varchar(20) DEFAULT NULL,
  `tong_tien` decimal(15,0) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hoa_don`
--

INSERT INTO `hoa_don` (`id`, `ma_hd`, `tong_tien`, `ngay_tao`) VALUES
(1, 'HD01', 5000000, '2025-11-29 16:40:08'),
(2, 'HD02', 2500000, '2025-11-29 16:40:08'),
(3, 'HD03', 8000000, '2025-11-29 16:40:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhan_vien`
--

CREATE TABLE `nhan_vien` (
  `id` int(11) NOT NULL,
  `ma_nv` varchar(10) DEFAULT NULL,
  `ten_dang_nhap` varchar(50) DEFAULT NULL,
  `mat_khau` varchar(100) NOT NULL,
  `ten_nv` varchar(100) DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `gioi_tinh` varchar(10) DEFAULT NULL,
  `ca_lam_viec` varchar(50) DEFAULT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhan_vien`
--

INSERT INTO `nhan_vien` (`id`, `ma_nv`, `ten_dang_nhap`, `mat_khau`, `ten_nv`, `ngay_sinh`, `gioi_tinh`, `ca_lam_viec`, `role`) VALUES
(1, 'TN01', 'anhtuan', '123456', 'Anh Tuấn', '2005-06-15', 'Nam', 'Sáng - Tối', 'admin'),
(2, 'TN02', 'giaphong', '123456', 'Gia Phong', '2005-07-20', 'Nam', 'Chiều - Tối', 'Nhân viên'),
(3, 'PV01', 'khachuy', '123456', 'Khắc Huy', '2005-09-17', 'Nam', 'Sáng - Tối', 'Nhân viên'),
(4, 'PV02', 'xuanpham', '123456', 'Xuân Phàm', '2005-04-27', 'Nam', 'Sáng - Chiều', 'Nhân viên'),
(5, 'PV03', 'voduy', '123456', 'Võ Duy', '2005-10-20', 'Nam', 'Sáng - Tối', 'Nhân viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuc_don`
--

CREATE TABLE `thuc_don` (
  `id` int(11) NOT NULL,
  `loai_mon` varchar(50) DEFAULT NULL,
  `ma_mon` varchar(20) DEFAULT NULL,
  `ten_mon` varchar(100) DEFAULT NULL,
  `nhom_thuc_don` varchar(50) DEFAULT NULL,
  `don_vi` varchar(20) DEFAULT NULL,
  `gia` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thuc_don`
--

INSERT INTO `thuc_don` (`id`, `loai_mon`, `ma_mon`, `ten_mon`, `nhom_thuc_don`, `don_vi`, `gia`) VALUES
(1, 'Đồ uống', 'U01', 'Cappuccio', 'Coffe', 'Ly', 65000),
(2, 'Đồ uống', 'U02', 'Cafe Latte', 'Coffe', 'Ly', 65000),
(3, 'Đồ uống', 'U03', 'Espresso', 'Coffe', 'Ly', 65000),
(4, 'Đồ uống', 'U04', 'Trà Dưa Gang', 'Trà', 'Ly', 65000),
(5, 'Đồ ăn', 'A01', 'Bánh Mì Bơ', 'Bánh', 'Phần', 29000);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chi_phi`
--
ALTER TABLE `chi_phi`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_nv` (`ma_nv`);

--
-- Chỉ mục cho bảng `thuc_don`
--
ALTER TABLE `thuc_don`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_mon` (`ma_mon`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chi_phi`
--
ALTER TABLE `chi_phi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `hoa_don`
--
ALTER TABLE `hoa_don`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `thuc_don`
--
ALTER TABLE `thuc_don`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
