-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_bitap
CREATE DATABASE IF NOT EXISTS `db_bitap` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `db_bitap`;

-- Dumping structure for table db_bitap.detail_transaksi
CREATE TABLE IF NOT EXISTS `detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_detail_transaksi`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_bitap.detail_transaksi: ~10 rows (approximately)
INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `product_id`, `qty`, `price`, `discount`, `total_price`) VALUES
	(26, '202412200001', 2, 1, 7000000.00, 0.00, 7000000.00),
	(27, '202412210001', 1, 1, 5500000.00, 0.00, 5500000.00),
	(28, '202412210002', 3, 1, 2000000.00, 100000.00, 1900000.00),
	(29, '202412210003', 1, 1, 5500000.00, 0.00, 5500000.00),
	(30, '202412210003', 2, 1, 7000000.00, 0.00, 7000000.00),
	(31, '202412210004', 3, 1, 2500000.00, 50000.00, 2450000.00),
	(32, '202412210005', 3, 1, 2500000.00, 0.00, 2500000.00),
	(33, '202412210006', 8, 1, 9000000.00, 0.00, 9000000.00),
	(34, '202412210007', 1, 1, 5500000.00, 0.00, 5500000.00),
	(35, '202412210007', 3, 1, 2500000.00, 0.00, 2500000.00);

-- Dumping structure for table db_bitap.items
CREATE TABLE IF NOT EXISTS `items` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name_item` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`product_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_bitap.items: ~8 rows (approximately)
INSERT INTO `items` (`product_id`, `name_item`, `brand`, `category`, `stock`, `price`, `discount`, `image_path`) VALUES
	(1, 'Asus Vivobook', 'Asus', 'Laptop', 9, 5500000.00, 0.00, 'images/vivobook.jpeg'),
	(2, 'Lenovo Ideapad', 'Lenovo', 'Laptop', 8, 7000000.00, 0.00, 'images/lenovolaptop.webp'),
	(3, 'Intel Core I5 Gen12', 'Intel', 'Processor', 17, 2500000.00, 0.00, 'images/i5 Gen12 K - Web.png'),
	(4, 'AMD Ryzen7', 'AMD', 'Processor', 25, 3000000.00, 0.00, 'images/ryzen7.jpeg'),
	(5, 'Motherboard RX7', 'RX7', 'Motherboard', 10, 1500000.00, 0.00, 'images/motherboard rx7.jpeg'),
	(6, 'Motherboard Gigabyte', 'Gigabyte', 'Motherboard', 8, 2000000.00, 0.00, 'images/gigabyte.jpeg'),
	(7, 'Asus ROG', 'Asus', 'Laptop', 5, 20000000.00, 0.00, 'images/asus rog.jpg'),
	(8, 'Axioo Pongo', 'Axioo', 'Laptop', 6, 9000000.00, 0.00, 'images/axio pongo.jpg');

-- Dumping structure for table db_bitap.member
CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `registered` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_bitap.member: ~4 rows (approximately)
INSERT INTO `member` (`id`, `name`, `phone`, `email`, `registered`) VALUES
	(789, 'reza', '081316184657', 'reza.pangestu.fict@krw.horizon.ac.id', '2024-12-21'),
	(4337, 'Rivverio Gema Salsasdila', '081234567810', 'rivverio@gmail.com', '2024-12-21'),
	(101112, 'Amel', '0812', 'ameng@gmail.com', '2024-12-21'),
	(123456, 'Rofi Febrian Aji', '085161423027', 'aji.rofifebrian@gmail.com', '2024-12-05');

-- Dumping structure for table db_bitap.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_transaksi` varchar(255) NOT NULL,
  `id_member` int(11) DEFAULT NULL,
  `tanggal_transaksi` date DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `discount_member` decimal(10,2) DEFAULT NULL,
  `total_discount` decimal(10,2) DEFAULT NULL,
  `pajak` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `total_bayar` decimal(10,2) DEFAULT NULL,
  `kembalian` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_bitap.transaksi: ~8 rows (approximately)
INSERT INTO `transaksi` (`id_transaksi`, `id_member`, `tanggal_transaksi`, `sub_total`, `discount_member`, `total_discount`, `pajak`, `total`, `total_bayar`, `kembalian`) VALUES
	('202412200001', 123456, '2024-12-21', 7000.00, 350000.00, 350000.00, 350000.00, 7000.00, 7500.00, 500000.00),
	('202412210001', 4337, '2024-12-21', 5500.00, 275000.00, 275000.00, 275000.00, 5500.00, 5500.00, 0.00),
	('202412210002', 123456, '2024-12-21', 2000.00, 100000.00, 200000.00, 100000.00, 1900.00, 2000.00, 100000.00),
	('202412210003', 0, '2024-12-21', 12500.00, 0.00, 0.00, 625000.00, 13125.00, 14000.00, 875000.00),
	('202412210004', 4337, '2024-12-21', 2500.00, 125000.00, 175000.00, 125000.00, 2450.00, 2450.00, 0.00),
	('202412210005', 0, '2024-12-21', 2500.00, 0.00, 0.00, 125000.00, 2625.00, 2625.00, 0.00),
	('202412210006', 123456, '2024-12-21', 9000.00, 450000.00, 450000.00, 450000.00, 9000.00, 9000.00, 0.00),
	('202412210007', 101112, '2024-12-21', 8000.00, 400000.00, 400000.00, 400000.00, 8000.00, 8000.00, 0.00);

-- Dumping structure for table db_bitap.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kasir') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_bitap.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
	(1, 'admin', '$2y$10$HJxlQL4ltgINzbhAhw81v.6l6r47CKrHkmye/Fwm1bExfSJgupX26', 'admin'),
	(3, 'reza', '$2y$10$J9A.5d/umM7Q2FwH9bW3ee55QvoivsjV1Yz13oYG6359AcYsWumbC', 'kasir');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
