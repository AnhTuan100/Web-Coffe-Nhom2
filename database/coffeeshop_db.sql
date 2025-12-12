-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 12, 2025 at 04:48 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffeeshop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `customer_phone` varchar(15) COLLATE utf8mb3_unicode_ci NOT NULL,
  `shipping_address` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `payment_method` enum('Tiền mặt','Thẻ ngân hàng') COLLATE utf8mb3_unicode_ci NOT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Mới','Đang giao','Hoàn thành','Đã hủy') COLLATE utf8mb3_unicode_ci DEFAULT 'Mới',
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `customer_name`, `customer_phone`, `shipping_address`, `total_amount`, `payment_method`, `order_date`, `status`) VALUES
(1, NULL, 'phong', '033', 'gia lai', 35000, 'Thẻ ngân hàng', '2025-12-11 04:47:24', 'Mới');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `detail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,0) NOT NULL,
  `size_option` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `product_id`, `product_name`, `quantity`, `unit_price`, `size_option`) VALUES
(1, 1, 2, 'Cà Phê Đen', 1, 35000, 'Lớn');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `base_price` decimal(10,0) NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `stock_quantity` int DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `category`, `base_price`, `description`, `image_path`, `stock_quantity`) VALUES
(1, 'Bạc Xỉu', 'Cà Phê', 30000, 'Ly sữa trắng kèm một chút cà phê, ngọt béo ngậy.', 'bacxiu.png', 99),
(2, 'Cà Phê Đen', 'Cà Phê', 30000, 'Cà phê rang đậm, nguyên chất, đá hoặc nóng.', 'capheden.png', 99),
(3, 'Trà Sữa Oolong Sương Sáo', 'Trà Sữa', 35000, 'Trà Oolong đậm vị, kết hợp thạch sương sáo mát lạnh.', 'trasuaolongsuongsao.png', 80),
(4, 'Trà Đào Cam Sả', 'Trà Trái Cây', 30000, 'Trà thanh mát, thêm vị cam tươi ngọt ngào.', 'tradaocamsa.png', 75);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `rating` int NOT NULL,
  `comment` text COLLATE utf8mb3_unicode_ci,
  `review_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`)
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `customer_name`, `rating`, `comment`, `review_date`) VALUES
(1, 'Nguyễn Văn A', 5, 'Bạc Xỉu rất ngon, giao hàng nhanh chóng!', '2025-12-11 13:21:03'),
(2, 'Trần Thị B', 4, 'Cà phê đen ổn, nên có thêm tùy chọn đá xay.', '2025-12-11 13:21:03'),
(3, 'Lê Hoàng C', 5, 'Tôi rất thích trà sữa Oolong ở đây, sẽ quay lại.', '2025-12-11 13:21:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb3_unicode_ci,
  `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `phone_number` (`phone_number`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
