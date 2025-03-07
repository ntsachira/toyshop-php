-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.39 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for toyshopdb
CREATE DATABASE IF NOT EXISTS `toyshopdb` /*!40100 DEFAULT CHARACTER SET utf32 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `toyshopdb`;

-- Dumping structure for view toyshopdb.active_category
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `active_category` (
	`category_id` INT(10) NOT NULL,
	`category_name` VARCHAR(50) NULL COLLATE 'utf32_general_ci',
	`status_status_id` INT(10) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view toyshopdb.active_product
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `active_product` (
	`product_id` INT(10) NOT NULL,
	`price` DOUBLE NULL,
	`quantity` INT(10) NULL,
	`title` VARCHAR(100) NULL COLLATE 'utf32_general_ci',
	`description` TEXT(16383) NULL COLLATE 'utf32_general_ci',
	`datetime_added` DATETIME NULL,
	`delivery_fee_matara` DOUBLE NULL,
	`delivery_fee_other` DOUBLE NULL,
	`brand_name` VARCHAR(20) NULL COLLATE 'utf32_general_ci',
	`model_name` VARCHAR(50) NULL COLLATE 'utf32_general_ci',
	`condition_name` VARCHAR(20) NULL COLLATE 'utf32_general_ci',
	`status_name` VARCHAR(10) NULL COLLATE 'utf32_general_ci',
	`color_name` VARCHAR(20) NULL COLLATE 'utf32_general_ci',
	`category_name` VARCHAR(50) NULL COLLATE 'utf32_general_ci',
	`category_id` INT(10) NOT NULL,
	`condition_id` INT(10) NOT NULL,
	`brand_id` INT(10) NOT NULL,
	`model_id` INT(10) NOT NULL,
	`color_id` INT(10) NULL
) ENGINE=MyISAM;

-- Dumping structure for view toyshopdb.active_user
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `active_user` (
	`email` VARCHAR(100) NOT NULL COLLATE 'utf32_general_ci',
	`first_name` VARCHAR(50) NOT NULL COLLATE 'utf32_general_ci',
	`last_name` VARCHAR(50) NOT NULL COLLATE 'utf32_general_ci',
	`password` VARCHAR(100) NOT NULL COLLATE 'utf32_general_ci',
	`mobile` VARCHAR(10) NOT NULL COLLATE 'utf32_general_ci',
	`joined_date` DATETIME NOT NULL,
	`verification_code` VARCHAR(20) NULL COLLATE 'utf32_general_ci',
	`gender_gender_id` INT(10) NOT NULL,
	`status_status_id` INT(10) NOT NULL,
	`gender_id` INT(10) NOT NULL,
	`gender_name` VARCHAR(10) NULL COLLATE 'utf32_general_ci',
	`status_id` INT(10) NOT NULL,
	`status_name` VARCHAR(10) NULL COLLATE 'utf32_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for table toyshopdb.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `email` varchar(100) NOT NULL,
  `password` varchar(20) CHARACTER SET utf32 COLLATE utf32_general_ci NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `admin_login_options_type_id` int NOT NULL,
  `otp` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_admin_admin_login_options1_idx` (`admin_login_options_type_id`),
  CONSTRAINT `fk_admin_admin_login_options1` FOREIGN KEY (`admin_login_options_type_id`) REFERENCES `admin_login_options` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.admin: ~0 rows (approximately)
INSERT INTO `admin` (`email`, `password`, `first_name`, `last_name`, `admin_login_options_type_id`, `otp`) VALUES
	('info.ntsachira@gmail.com', 'admin123', 'Sachira', 'Jayawardana', 1, '65dee42d427ea');

-- Dumping structure for table toyshopdb.admin_login_history
CREATE TABLE IF NOT EXISTS `admin_login_history` (
  `login_datetime` datetime NOT NULL,
  `login_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.admin_login_history: ~64 rows (approximately)
INSERT INTO `admin_login_history` (`login_datetime`, `login_id`) VALUES
	('2024-02-27 12:43:27', 1),
	('2024-02-27 12:44:18', 2),
	('2024-02-27 16:27:44', 3),
	('2024-02-27 16:27:52', 4),
	('2024-02-27 16:28:17', 5),
	('2024-02-27 16:28:26', 6),
	('2024-02-27 16:28:38', 7),
	('2024-02-27 16:28:44', 8),
	('2024-02-27 16:28:57', 9),
	('2024-02-27 16:29:02', 10),
	('2024-02-27 16:29:08', 11),
	('2024-02-27 16:29:12', 12),
	('2024-02-27 17:26:37', 13),
	('2024-02-28 13:03:12', 14),
	('2024-02-28 13:14:21', 15),
	('2024-02-28 21:32:30', 16),
	('2024-03-25 20:53:58', 17),
	('2024-03-25 21:01:42', 18),
	('2024-04-19 23:38:07', 19),
	('2024-04-20 12:13:41', 20),
	('2024-04-20 12:48:17', 21),
	('2024-04-21 12:52:11', 22),
	('2024-04-21 12:53:06', 23),
	('2024-04-22 15:52:13', 24),
	('2024-04-23 01:43:54', 25),
	('2024-04-23 10:39:23', 26),
	('2024-04-23 12:25:45', 27),
	('2024-04-23 12:31:07', 28),
	('2024-04-23 15:17:07', 29),
	('2024-04-23 15:39:02', 30),
	('2024-04-23 16:29:07', 31),
	('2024-04-23 20:46:19', 32),
	('2024-04-24 15:19:42', 33),
	('2024-04-26 10:38:49', 34),
	('2024-04-28 10:17:40', 35),
	('2024-05-11 14:24:37', 36),
	('2024-05-12 08:32:51', 37),
	('2024-05-12 21:22:48', 38),
	('2024-05-17 15:43:11', 39),
	('2024-05-19 21:40:10', 40),
	('2024-05-20 19:47:41', 41),
	('2024-05-28 02:01:54', 42),
	('2024-05-31 20:26:56', 43),
	('2024-06-25 21:09:50', 44),
	('2024-06-26 09:14:28', 45),
	('2024-06-26 09:51:24', 46),
	('2024-06-26 10:06:08', 47),
	('2024-06-26 10:18:18', 48),
	('2024-06-26 10:38:26', 49),
	('2024-06-26 10:58:47', 50),
	('2024-06-26 14:02:10', 51),
	('2024-06-26 14:18:25', 52),
	('2024-06-26 14:20:40', 53),
	('2024-06-26 15:49:50', 54),
	('2024-06-26 17:40:28', 55),
	('2024-06-26 17:50:56', 56),
	('2024-06-27 09:38:56', 57),
	('2024-06-27 16:08:04', 58),
	('2024-06-27 18:17:55', 59),
	('2024-07-03 20:18:30', 60),
	('2024-08-30 19:23:15', 61),
	('2024-09-03 20:43:46', 62),
	('2024-09-03 20:44:01', 63),
	('2024-09-13 11:23:08', 64);

-- Dumping structure for table toyshopdb.admin_login_options
CREATE TABLE IF NOT EXISTS `admin_login_options` (
  `type_id` int NOT NULL AUTO_INCREMENT,
  `type_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.admin_login_options: ~2 rows (approximately)
INSERT INTO `admin_login_options` (`type_id`, `type_name`) VALUES
	(1, 'Password'),
	(2, 'OTP');

-- Dumping structure for table toyshopdb.brand
CREATE TABLE IF NOT EXISTS `brand` (
  `brand_id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.brand: ~18 rows (approximately)
INSERT INTO `brand` (`brand_id`, `brand_name`) VALUES
	(1, 'McFarlane Toys'),
	(2, 'LEGO'),
	(3, 'Not Specified'),
	(4, 'Jada'),
	(5, 'Magilano'),
	(6, 'Divchi'),
	(7, 'FTX'),
	(8, 'mybra'),
	(9, 'Piececool'),
	(10, 'Maisto Tech R/C'),
	(13, 'Traxas'),
	(14, 'kokubura'),
	(15, 'kokatu'),
	(16, 'Hasbro'),
	(17, 'Construx'),
	(18, 'HOMCOM'),
	(19, 'TOMY'),
	(20, 'Schylling');

-- Dumping structure for table toyshopdb.brand_has_model
CREATE TABLE IF NOT EXISTS `brand_has_model` (
  `brand_has_model_id` int NOT NULL AUTO_INCREMENT,
  `brand_brand_id` int NOT NULL,
  `model_model_id` int NOT NULL,
  PRIMARY KEY (`brand_has_model_id`),
  KEY `fk_brand_has_model_model1_idx` (`model_model_id`),
  KEY `fk_brand_has_model_brand1_idx` (`brand_brand_id`),
  CONSTRAINT `fk_brand_has_model_brand1` FOREIGN KEY (`brand_brand_id`) REFERENCES `brand` (`brand_id`),
  CONSTRAINT `fk_brand_has_model_model1` FOREIGN KEY (`model_model_id`) REFERENCES `model` (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.brand_has_model: ~19 rows (approximately)
INSERT INTO `brand_has_model` (`brand_has_model_id`, `brand_brand_id`, `model_model_id`) VALUES
	(1, 1, 1),
	(2, 2, 2),
	(3, 3, 3),
	(4, 4, 4),
	(5, 5, 5),
	(6, 6, 3),
	(7, 7, 6),
	(8, 3, 9),
	(9, 9, 3),
	(10, 10, 3),
	(11, 16, 3),
	(12, 2, 3),
	(13, 17, 3),
	(14, 18, 10),
	(15, 18, 3),
	(16, 19, 3),
	(17, 20, 11),
	(18, 3, 12),
	(19, 3, 13);

-- Dumping structure for table toyshopdb.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `cart_quantity` double DEFAULT NULL,
  `product_product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `fk_cart_product1_idx` (`product_product_id`),
  KEY `fk_cart_user1_idx` (`user_email`),
  CONSTRAINT `fk_cart_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`),
  CONSTRAINT `fk_cart_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.cart: ~4 rows (approximately)
INSERT INTO `cart` (`cart_id`, `cart_quantity`, `product_product_id`, `user_email`) VALUES
	(46, 1, 8, 'sahan@gmail.com'),
	(49, 1, 25, 'prathi@gmail.com'),
	(50, 1, 7, 'prathi@gmail.com'),
	(54, 2, 36, 'ntsachira@gmail.com'),
	(55, 1, 34, 'rmp@gmail.com'),
	(56, 1, 18, 'rmp@gmail.com');

-- Dumping structure for table toyshopdb.category
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) DEFAULT NULL,
  `status_status_id` int NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `fk_category_status1_idx` (`status_status_id`),
  CONSTRAINT `fk_category_status1` FOREIGN KEY (`status_status_id`) REFERENCES `status` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.category: ~13 rows (approximately)
INSERT INTO `category` (`category_id`, `category_name`, `status_status_id`) VALUES
	(1, 'Action Figures', 1),
	(2, 'Building Toys', 1),
	(3, 'Classic Toys', 1),
	(4, 'Card Games', 2),
	(5, 'Toy Vehicles', 1),
	(6, 'Educational Toys', 1),
	(7, 'Games', 1),
	(10, 'Outdoor Toys', 2),
	(11, 'Puzzles', 1),
	(12, 'RC Model Vehicles', 1),
	(13, 'Robots', 2),
	(14, 'Stuffed Animals', 2),
	(17, 'Video Game', 2);

-- Dumping structure for table toyshopdb.category_has_brand
CREATE TABLE IF NOT EXISTS `category_has_brand` (
  `category_category_id` int NOT NULL,
  `brand_brand_id` int NOT NULL,
  PRIMARY KEY (`category_category_id`,`brand_brand_id`),
  KEY `fk_category_has_brand_brand1_idx` (`brand_brand_id`),
  KEY `fk_category_has_brand_category1_idx` (`category_category_id`),
  CONSTRAINT `fk_category_has_brand_brand1` FOREIGN KEY (`brand_brand_id`) REFERENCES `brand` (`brand_id`),
  CONSTRAINT `fk_category_has_brand_category1` FOREIGN KEY (`category_category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.category_has_brand: ~13 rows (approximately)
INSERT INTO `category_has_brand` (`category_category_id`, `brand_brand_id`) VALUES
	(2, 2),
	(1, 3),
	(5, 3),
	(11, 9),
	(5, 10),
	(1, 16),
	(2, 16),
	(3, 16),
	(5, 16),
	(2, 17),
	(3, 18),
	(3, 19),
	(3, 20);

-- Dumping structure for table toyshopdb.category_image
CREATE TABLE IF NOT EXISTS `category_image` (
  `image_path` text NOT NULL,
  `category_category_id` int NOT NULL,
  KEY `fk_category_image_category1_idx` (`category_category_id`),
  CONSTRAINT `fk_category_image_category1` FOREIGN KEY (`category_category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.category_image: ~13 rows (approximately)
INSERT INTO `category_image` (`image_path`, `category_category_id`) VALUES
	('resource\\category_image\\actionfigure.webp', 1),
	('resource\\category_image\\buildingtoy.webp', 2),
	('resource\\category_image\\classictoy.webp', 3),
	('resource\\category_image\\cardgames.webp', 4),
	('resource\\category_image\\toyvehicles.jpg', 5),
	('resource\\category_image\\educationaltoys.webp', 6),
	('resource\\category_image\\games.webp', 7),
	('resource\\category_image\\outdoortoy.png', 10),
	('resource\\category_image\\puzzels.jpg', 11),
	('resource\\category_image\\rcmodels.jpg', 12),
	('resource\\category_image\\robots.webp', 13),
	('resource\\category_image\\stuffedtoys.jpg', 14),
	('resource/category_image/cat_17.jpeg', 17);

-- Dumping structure for table toyshopdb.city
CREATE TABLE IF NOT EXISTS `city` (
  `city_id` int NOT NULL AUTO_INCREMENT,
  `city_name` varchar(50) DEFAULT NULL,
  `district_district_id` int NOT NULL,
  PRIMARY KEY (`city_id`),
  KEY `fk_city_district1_idx` (`district_district_id`),
  CONSTRAINT `fk_city_district1` FOREIGN KEY (`district_district_id`) REFERENCES `district` (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.city: ~9 rows (approximately)
INSERT INTO `city` (`city_id`, `city_name`, `district_district_id`) VALUES
	(1, 'Matara', 1),
	(2, 'Akuressa', 1),
	(3, 'Deniyaya', 1),
	(4, 'Weligama', 1),
	(5, 'Mirissa', 1),
	(6, 'Bandarawela', 7),
	(7, 'Colombo', 4),
	(8, 'Awissawella', 4),
	(9, 'Maharagama', 4);

-- Dumping structure for view toyshopdb.city_data
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `city_data` (
	`city_id` INT(10) NOT NULL,
	`city_name` VARCHAR(50) NULL COLLATE 'utf32_general_ci',
	`district_district_id` INT(10) NOT NULL,
	`district_id` INT(10) NOT NULL,
	`district_name` VARCHAR(50) NULL COLLATE 'utf32_general_ci',
	`province_province_id` INT(10) NOT NULL,
	`province_id` INT(10) NOT NULL,
	`province_name` VARCHAR(50) NULL COLLATE 'utf32_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for table toyshopdb.color
CREATE TABLE IF NOT EXISTS `color` (
  `color_id` int NOT NULL AUTO_INCREMENT,
  `color_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.color: ~12 rows (approximately)
INSERT INTO `color` (`color_id`, `color_name`) VALUES
	(2, 'Black'),
	(3, 'Gray'),
	(4, 'Yellow'),
	(5, 'Blue'),
	(6, 'Purple'),
	(7, 'Not Specified'),
	(8, 'Multi-color'),
	(9, 'Green'),
	(10, 'Pink'),
	(11, 'Red'),
	(12, 'White'),
	(13, 'Brown');

-- Dumping structure for table toyshopdb.condition
CREATE TABLE IF NOT EXISTS `condition` (
  `condition_id` int NOT NULL AUTO_INCREMENT,
  `condition_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`condition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.condition: ~3 rows (approximately)
INSERT INTO `condition` (`condition_id`, `condition_name`) VALUES
	(1, 'Brand New'),
	(2, 'Used'),
	(3, 'Unbranded');

-- Dumping structure for table toyshopdb.district
CREATE TABLE IF NOT EXISTS `district` (
  `district_id` int NOT NULL AUTO_INCREMENT,
  `district_name` varchar(50) DEFAULT NULL,
  `province_province_id` int NOT NULL,
  PRIMARY KEY (`district_id`),
  KEY `fk_district_province1_idx` (`province_province_id`),
  CONSTRAINT `fk_district_province1` FOREIGN KEY (`province_province_id`) REFERENCES `province` (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.district: ~8 rows (approximately)
INSERT INTO `district` (`district_id`, `district_name`, `province_province_id`) VALUES
	(1, 'Matara', 1),
	(2, 'Galle', 1),
	(3, 'Hambantota', 1),
	(4, 'Colombo', 2),
	(5, 'Kaluthara', 2),
	(6, 'Gampaha', 2),
	(7, 'Badulla', 4),
	(8, 'Monaragala', 4);

-- Dumping structure for table toyshopdb.footer
CREATE TABLE IF NOT EXISTS `footer` (
  `mission` text,
  `copy_right` varchar(50) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `tele` varchar(12) DEFAULT NULL,
  `updated_datetime` datetime NOT NULL,
  `site_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.footer: ~0 rows (approximately)
INSERT INTO `footer` (`mission`, `copy_right`, `address`, `email`, `tele`, `updated_datetime`, `site_name`) VALUES
	('Welcome to ToyShop! Our mission is to bring joy and smiles to children of all ages through a delightful selection of toys.', '2024 toyshop.lk || All Rights Reserved', '26, Temple Road, Matara', 'info.toyshop@gmail.com', '0412224789', '2024-02-27 08:21:30', 'Toy Shop');

-- Dumping structure for view toyshopdb.full_product
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `full_product` (
	`product_id` INT(10) NOT NULL,
	`price` DOUBLE NULL,
	`quantity` INT(10) NULL,
	`title` VARCHAR(100) NULL COLLATE 'utf32_general_ci',
	`description` TEXT(16383) NULL COLLATE 'utf32_general_ci',
	`datetime_added` DATETIME NULL,
	`delivery_fee_matara` DOUBLE NULL,
	`delivery_fee_other` DOUBLE NULL,
	`brand_name` VARCHAR(20) NULL COLLATE 'utf32_general_ci',
	`model_name` VARCHAR(50) NULL COLLATE 'utf32_general_ci',
	`condition_name` VARCHAR(20) NULL COLLATE 'utf32_general_ci',
	`status_name` VARCHAR(10) NULL COLLATE 'utf32_general_ci',
	`color_name` VARCHAR(20) NULL COLLATE 'utf32_general_ci',
	`category_name` VARCHAR(50) NULL COLLATE 'utf32_general_ci',
	`category_id` INT(10) NOT NULL,
	`condition_id` INT(10) NOT NULL,
	`brand_id` INT(10) NOT NULL,
	`model_id` INT(10) NOT NULL,
	`color_id` INT(10) NULL
) ENGINE=MyISAM;

-- Dumping structure for table toyshopdb.gender
CREATE TABLE IF NOT EXISTS `gender` (
  `gender_id` int NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`gender_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.gender: ~2 rows (approximately)
INSERT INTO `gender` (`gender_id`, `gender_name`) VALUES
	(1, 'Male'),
	(2, 'Female');

-- Dumping structure for table toyshopdb.invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` varchar(50) NOT NULL,
  `date` datetime DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `invoice_status_invoice_status_id` int DEFAULT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `FK__user` (`user_email`),
  KEY `invoice_status_invoice_status_id` (`invoice_status_invoice_status_id`),
  CONSTRAINT `FK__user` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`),
  CONSTRAINT `FK_invoice_invoice_status` FOREIGN KEY (`invoice_status_invoice_status_id`) REFERENCES `invoice_status` (`invoice_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.invoice: ~19 rows (approximately)
INSERT INTO `invoice` (`invoice_id`, `date`, `user_email`, `invoice_status_invoice_status_id`) VALUES
	('INV-170696642391', '2023-12-03 18:50:48', 'ntsachira@gmail.com', 3),
	('INV-170696867527', '2023-12-03 19:28:42', 'ntsachira@gmail.com', 3),
	('INV-170698165963', '2024-01-03 23:04:51', 'ntsachira@gmail.com', 3),
	('INV-170698515413', '2024-01-04 00:03:06', 'ntsachira@gmail.com', 3),
	('INV-170702496832', '2024-02-04 11:07:04', 'ntsachira@gmail.com', 3),
	('INV-170712544112', '2024-02-05 15:01:12', 'sahan@gmail.com', 2),
	('INV-170712589191', '2024-02-05 15:08:36', 'ntsachira@gmail.com', 6),
	('INV-170712629722', '2024-02-05 15:15:49', 'sahan@gmail.com', 3),
	('INV-170886034614', '2024-02-25 16:56:33', 'tharindu@gmail.com', 2),
	('INV-171378238948', '2024-04-22 16:12:05', 'prathi@gmail.com', 3),
	('INV-171385484922', '2024-04-23 12:19:47', 'ntsachira@gmail.com', 3),
	('INV-171385562159', '2024-04-23 12:30:51', 'prathi@gmail.com', 3),
	('INV-171386541947', '2024-04-23 15:14:04', 'prathi@gmail.com', 5),
	('INV-171386556911', '2024-04-23 15:16:32', 'sahan@gmail.com', 3),
	('INV-171395232457', '2024-04-24 15:22:46', 'prathi@gmail.com', 3),
	('INV-171937516500', '2024-06-26 09:47:42', 'sahan@gmail.com', 4),
	('INV-171937618279', '2024-06-26 10:00:01', 'sahan@gmail.com', 4),
	('INV-171937718404', '2024-06-26 10:17:15', 'prathi@gmail.com', 5),
	('INV-171949263122', '2024-06-27 18:21:03', 'ntsachira@gmail.com', 4);

-- Dumping structure for table toyshopdb.invoice_item
CREATE TABLE IF NOT EXISTS `invoice_item` (
  `invoice_item_id` int NOT NULL AUTO_INCREMENT,
  `product_product_id` int NOT NULL,
  `invoice_item_quantity` double DEFAULT NULL,
  `invoice_item_price` double DEFAULT NULL,
  `invoice_invoice_id` varchar(50) NOT NULL,
  `shipping_fee` double DEFAULT NULL,
  `review_status_review_status_id` int NOT NULL,
  PRIMARY KEY (`invoice_item_id`),
  KEY `fk_incoice_has_product_product1_idx` (`product_product_id`),
  KEY `fk_invoice_item_invoice1_idx` (`invoice_invoice_id`),
  KEY `fk_invoice_item_review_status1_idx` (`review_status_review_status_id`),
  CONSTRAINT `fk_incoice_has_product_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`),
  CONSTRAINT `fk_invoice_item_invoice1` FOREIGN KEY (`invoice_invoice_id`) REFERENCES `invoice` (`invoice_id`),
  CONSTRAINT `fk_invoice_item_review_status1` FOREIGN KEY (`review_status_review_status_id`) REFERENCES `review_status` (`review_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.invoice_item: ~27 rows (approximately)
INSERT INTO `invoice_item` (`invoice_item_id`, `product_product_id`, `invoice_item_quantity`, `invoice_item_price`, `invoice_invoice_id`, `shipping_fee`, `review_status_review_status_id`) VALUES
	(8, 20, 1, 11500, 'INV-170696642391', 20, 1),
	(9, 20, 1, 11500, 'INV-170696867527', 20, 1),
	(10, 1, 1, 10300, 'INV-170698165963', 0, 1),
	(11, 18, 1, 1750, 'INV-170698165963', 0, 1),
	(12, 19, 1, 9500, 'INV-170698165963', 10, 1),
	(13, 1, 1, 10300, 'INV-170698515413', 0, 1),
	(14, 4, 1, 16700, 'INV-170702496832', 0, 1),
	(15, 19, 1, 9500, 'INV-170702496832', 10, 2),
	(16, 2, 1, 19400, 'INV-170712544112', 100, 2),
	(17, 18, 2, 1750, 'INV-170712589191', 0, 2),
	(18, 2, 1, 19400, 'INV-170712629722', 100, 2),
	(19, 6, 1, 2500, 'INV-170886034614', 100, 2),
	(20, 24, 1, 2370, 'INV-171378238948', 100, 2),
	(21, 22, 1, 3600, 'INV-171378238948', 100, 2),
	(22, 6, 2, 2500, 'INV-171385484922', 0, 2),
	(23, 19, 1, 9500, 'INV-171385484922', 10, 2),
	(24, 23, 1, 4250, 'INV-171385562159', 100, 2),
	(25, 22, 1, 3600, 'INV-171386541947', 100, 2),
	(26, 24, 1, 2370, 'INV-171386556911', 100, 2),
	(27, 37, 1, 12500, 'INV-171395232457', 150, 2),
	(28, 38, 1, 2800, 'INV-171937516500', 100, 2),
	(29, 28, 1, 4800, 'INV-171937618279', 150, 2),
	(30, 36, 2, 2300, 'INV-171937618279', 150, 2),
	(31, 34, 2, 8700, 'INV-171937718404', 150, 2),
	(32, 23, 1, 4250, 'INV-171937718404', 100, 2),
	(33, 19, 1, 9500, 'INV-171937718404', 150, 2),
	(34, 37, 1, 12500, 'INV-171949263122', 50, 2);

-- Dumping structure for table toyshopdb.invoice_status
CREATE TABLE IF NOT EXISTS `invoice_status` (
  `invoice_status_id` int NOT NULL AUTO_INCREMENT,
  `status_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`invoice_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.invoice_status: ~6 rows (approximately)
INSERT INTO `invoice_status` (`invoice_status_id`, `status_name`) VALUES
	(1, 'Awaiting Confirm'),
	(2, 'Out for Delivery'),
	(3, 'Delivered'),
	(4, 'Confirmed'),
	(5, 'Packaging'),
	(6, 'Cancelled');

-- Dumping structure for table toyshopdb.message_history
CREATE TABLE IF NOT EXISTS `message_history` (
  `history_id` varchar(30) NOT NULL,
  `message_date` datetime DEFAULT NULL,
  `message` varchar(500) DEFAULT NULL,
  `sender` varchar(100) NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `seen_status_seen_status_id` int NOT NULL,
  PRIMARY KEY (`history_id`),
  KEY `fk_message_history_user1_idx` (`sender`),
  KEY `fk_message_history_user2_idx` (`receiver`),
  KEY `fk_message_history_seen_status1_idx` (`seen_status_seen_status_id`),
  CONSTRAINT `fk_message_history_seen_status1` FOREIGN KEY (`seen_status_seen_status_id`) REFERENCES `seen_status` (`seen_status_id`),
  CONSTRAINT `fk_message_history_user1` FOREIGN KEY (`sender`) REFERENCES `user` (`email`),
  CONSTRAINT `fk_message_history_user2` FOREIGN KEY (`receiver`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.message_history: ~6 rows (approximately)
INSERT INTO `message_history` (`history_id`, `message_date`, `message`, `sender`, `receiver`, `seen_status_seen_status_id`) VALUES
	('170721238270', '2024-02-06 15:09:42', 'I need help', 'sahan@gmail.com', 'admin@gmail.com', 1),
	('170721636955', '2024-02-06 16:16:09', 'I need a remort car', 'ntsachira@gmail.com', 'admin@gmail.com', 1),
	('170727987953', '2024-02-07 09:54:39', 'ok, ill send you', 'admin@gmail.com', 'ntsachira@gmail.com', 1),
	('170728148310', '2024-02-07 10:21:23', 'thank you', 'ntsachira@gmail.com', 'admin@gmail.com', 1),
	('171368434851', '2024-04-21 12:55:48', 'hi Can Use cash On delivery', 'prathi@gmail.com', 'admin@gmail.com', 1),
	('171368438136', '2024-04-21 12:56:21', 'Yes you can', 'admin@gmail.com', 'prathi@gmail.com', 1);

-- Dumping structure for table toyshopdb.model
CREATE TABLE IF NOT EXISTS `model` (
  `model_id` int NOT NULL AUTO_INCREMENT,
  `model_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.model: ~12 rows (approximately)
INSERT INTO `model` (`model_id`, `model_name`) VALUES
	(1, 'DC Direct BTAS'),
	(2, 'CITY SKI CENTER & CLIMBING SET'),
	(3, 'Not Specified'),
	(4, 'Skyline GT-R R34'),
	(5, 'skyjo'),
	(6, 'FTX557XS'),
	(8, 'mymo'),
	(9, 'Kratos'),
	(10, 'Mhstarukltd 330-080V01-2'),
	(11, 'Jack-In-The-Box'),
	(12, 'VAZ Lada 2106'),
	(13, 'Yupiter-2K');

-- Dumping structure for table toyshopdb.product
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `price` double DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `datetime_added` datetime DEFAULT NULL,
  `delivery_fee_matara` double DEFAULT NULL,
  `delivery_fee_other` double DEFAULT NULL,
  `brand_has_model_brand_has_model_id` int NOT NULL,
  `condition_condition_id` int NOT NULL,
  `category_category_id` int NOT NULL,
  `status_status_id` int NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_product_brand_has_model1_idx` (`brand_has_model_brand_has_model_id`),
  KEY `fk_product_condition1_idx` (`condition_condition_id`),
  KEY `fk_product_category1_idx` (`category_category_id`),
  KEY `fk_product_status1_idx` (`status_status_id`),
  CONSTRAINT `fk_product_brand_has_model1` FOREIGN KEY (`brand_has_model_brand_has_model_id`) REFERENCES `brand_has_model` (`brand_has_model_id`),
  CONSTRAINT `fk_product_category1` FOREIGN KEY (`category_category_id`) REFERENCES `category` (`category_id`),
  CONSTRAINT `fk_product_condition1` FOREIGN KEY (`condition_condition_id`) REFERENCES `condition` (`condition_id`),
  CONSTRAINT `fk_product_status1` FOREIGN KEY (`status_status_id`) REFERENCES `status` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.product: ~30 rows (approximately)
INSERT INTO `product` (`product_id`, `price`, `quantity`, `title`, `description`, `datetime_added`, `delivery_fee_matara`, `delivery_fee_other`, `brand_has_model_brand_has_model_id`, `condition_condition_id`, `category_category_id`, `status_status_id`) VALUES
	(1, 10300, 48, 'McFarlane Toys Condiment King Series DC BTAS Build-A-Figure Batman Action Figure - (081423SR)', 'BATMAN comes with 5 extra hands, batarang and grapnel launcher * BATMAN comes with the Condiment King build-a figure arms * Included collectible art card with character art on the front, and character biography on the back * Collect all McFARLANE TOYS BATMAN: THE ANIMATED SERIES figures * Condition: May have some little wear on the package.', '2023-12-01 22:26:16', 0, 100, 1, 1, 1, 1),
	(2, 19400, 48, 'BRAND NEW LEGO CITY SKI CENTER & CLIMBING SET #60366 Buidling Kit 1045 Pcs', 'New: A brand-new, unused, unopened, undamaged item in its original packaging (where packaging is applicable). Packaging should be the same as what is found in a retail store, unless the item is handmade or was packaged by the manufacturer in non-retail packaging, such as an unprinted box or plastic bag.', '2024-01-01 22:41:30', 0, 100, 2, 1, 2, 1),
	(3, 4100, 0, 'Yomega Brain - Auto Return Yo-Yo for Beginners - Free Strings Included', NULL, '2024-01-01 23:03:32', 0, 100, 3, 1, 3, 1),
	(4, 16700, 49, 'Jada 1:24 Fast & Furious Brians 02 Nissan Skyline GT-R Diecast Car Model Toy', 'New: A brand-new, unused, unopened, undamaged item (including handmade items).', '2024-01-01 23:11:06', 0, 100, 4, 1, 5, 1),
	(5, 5400, 50, 'SKYJO by Magilano - the Entertaining Card Game for Kids and Adults', 'New: A brand-new, unused, unopened, undamaged item (including handmade items).', '2024-01-01 23:18:30', 0, 100, 5, 1, 4, 2),
	(6, 2500, 0, 'Kids Maths Educational Toys Matching Number Game for boys & Girls Gift', NULL, '2024-01-01 23:22:49', 0, 100, 3, 1, 6, 1),
	(7, 2200, 1, 'Ludo Game - Traditional Ludo Board Game for Kids & Adults', NULL, '2024-01-01 23:28:11', 0, 100, 6, 1, 7, 1),
	(8, 20800, 10, 'FTX Tracer / HPI Blackzon Slyder 4WD 1:16 RTR RC Car', 'High Quality RC model car', '2024-01-01 23:37:20', 0, 100, 7, 1, 12, 1),
	(18, 1750, 4, 'Armor W Blades NECA Action Figure God of War Ghost of Sparta Kratos In Ares', 'Armor W Blades NECA Action Figure God of War Ghost of Sparta Kratos In Ares', '2024-01-21 17:19:42', 0, 100, 8, 1, 1, 1),
	(19, 9500, 1, '3D Puzzles Metal Queen Annes Revenge Pirate Ship Model Handmade Building Toys', ' 3D metal puzzles are suitable for teenagers and adults aged 16+. Making a metal model kit is challenging and may take over 8 hours, depending on your speed and patience. After hours dedicated working and completed your own amazing handcraft, you will get a strong sense of accomplishment and stress relief.\r\n', '2024-01-21 17:53:57', 10, 150, 9, 3, 11, 1),
	(20, 11500, 5, 'Maisto 1:16RC Vudoo Large Off-Road Series Remote Control Green Toy Car M82067', 'This RC Vudoo Off Road vehicle is a four-wheeled remote control truck thats built for off-road driving with its Big Off-Road Tires and Steering Alignment Adjustment.  The set contains 1 x Transmitter. The item requires 2 x AA Batteries for the controller and 4 x AA Batteries for the vehicle as these are not included. ', '2024-01-21 18:54:55', 20, 150, 10, 1, 5, 1),
	(21, 1200, 20, 'Authentic Hasbro Transformers Legacy Evolution Commander Optimus Prime', '100% Brand Newï¼ Authentic hasbro product no after sales service plz be aware of this. We will use foam and cardboard box for shipping but long distance "transportation may have the box slightly wrinkled we can only guarantee that the toy body is intact. If you are overly concerned about the integrity of the box please do not purchase. Thank you for your consideration and understanding!', '2024-04-20 08:57:02', 20, 100, 11, 1, 1, 1),
	(22, 3600, 18, 'Marvel Legends Clea Mindless One Wave Series Doctor Strange Marvel Knights Loose', 'Marvel Legends Clea from the Mindless One Series. Please see pictures attached as you will receive the exact item pictured. See pictures! Rare and hard to find! Please see my other auctions for more fantastic Marvel Legends collectibles.', '2024-04-21 08:35:30', 20, 100, 11, 2, 1, 1),
	(23, 4250, 18, 'G.I. Joe Classified Wreckage & Tiger Paw 137 Tiger Force Exclusive', 'Adjustable, Boxed, Exclusive, Limited Edition, With Clothes', '2024-04-21 08:46:34', 20, 100, 11, 1, 1, 1),
	(24, 2370, 18, 'SHF Anime Xman Wolverine 6 Model Kaiyodo Revoltech Amazing Yamaguchi Figure Toy', 'Material: PVC\r\nOrigin: CHINA\r\nCondition:100% Brand New.version of china\r\nAbout Size:16cm\r\nQuantity: 1PCS\r\ncondition: 100% new in box', '2024-04-21 08:58:09', 20, 100, 3, 1, 1, 1),
	(25, 22600, 20, 'Lego Star Wars - AT-TE Walker (75337) - BRAND NEW SEALED IN BOX', 'A brand-new, unused, unopened, undamaged item (including handmade items). ', '2024-04-23 07:31:16', 30, 150, 12, 1, 2, 1),
	(26, 6750, 20, 'LEGO MOC Custom City Creator Adventurer Red Biplane PDF Building Instructions!', 'Custom LEGO MOC Adventurer Red Biplane PDF Building Instructions designed by -gryffindorcommonroom.', '2024-04-23 17:25:06', 30, 150, 12, 1, 2, 1),
	(27, 11800, 20, 'Brand New MEGA Halo UNSC Falcon Sweep Building Toy Kit (HDP62) ', 'Suit up with NOBLE Team for a sweep mission aboard the UNSC Falcon. This high-flying construction set features a large troop bay big enough to transport 5 elite fireteam Spartans. Build the air transport carrier, complete with dual spinning propellers and poseable gunner turret, then place your designated pilot in the cockpit and close its door. Prepare for a tactical surveillance survey with 6 micro action figures known for their sacrifice NOBLE Team is ready to take flight. This Probuilders building toy is designed for ages 8 and up.', '2024-04-23 17:38:19', 30, 150, 13, 1, 2, 1),
	(28, 4800, 19, 'LEGO Harry Potter Series 2 (71028) COMPLETE SET 16 Minifigures Accessories [NEW]', 'Magic can be found everywhere! Kids and fans will love this authentic, brand new Complete Set of 16 Harry Potter Series 2 (71028) Minifigures with accessories. These awesome minifigures are great for imaginative play so kids can create adventures with their favorite characters in current sets that they own, make them part of new stories with other models, or collect them to display.', '2024-04-23 17:46:08', 30, 150, 12, 1, 2, 1),
	(29, 3200, 5, 'Star Wars & Indiana Jones Action figure Accessories Lot 3. 80+ Pieces!', 'An item that has been used previously. The item may have some signs of cosmetic wear, but is fully operational and functions as intended. This item may be a floor model or store return that has been used.', '2024-04-23 17:51:48', 30, 150, 11, 2, 2, 1),
	(30, 17600, 20, 'HOMCOM Kids Rocking Horse Ride On Swan Toy Music Safety Seat for Toddler', 'Give your child hours of endless fun and excitement with this ride on rocking animal from HOMCOM. Strong, durable and supporting a weight up to 30kg, the wood and reinforced steel frame is crafted into a smoothly curved design for it to rock backwards and forwards beautifully without any interruptions. Plush and padded, the swan top features a wide seat for comfort, two handlebars for them to hold on to and a music button on the back left wing which plays a piece of lullaby music whilst they rock along. The start of a great adventure once they hop on!', '2024-04-24 06:18:29', 200, 500, 14, 1, 3, 1),
	(31, 12400, 20, 'Homcom Kids Plush Rocking Horse W/ Moving Mouth Tail Sounds 18-36 Months Brown', 'Give your child endless adventure and fun with this rocking horse from HOMCOM. It is fitted with a flat seat, a rein and two handlebars for your child to hold on safely. With the squeeze of the ear button, the mouth and tail moves and plays sounds, making it fun and exciting', '2024-04-24 06:21:42', 200, 500, 15, 1, 3, 1),
	(32, 1000, 20, 'Five New Classic Hasbro Playmonster Koosh Balls. Colors as shown', 'Five New \r\nOriginal Classic Hasbro\r\nPlaymonster Koosh Balls. \r\nColors as shown.\r\nAll five have attached tags', '2024-04-24 06:26:00', 0, 10, 11, 1, 3, 1),
	(33, 6500, 20, 'Tomy Trackmaster Plarail Ben the Tank Engine Twin *complete set*', 'Tomy Trackmaster Plarail Ben with Freight Cars!\r\nItem is in MINT condition and the motor are working fine, \r\nruns well and can hitch up slope!', '2024-04-24 06:32:45', 20, 100, 16, 1, 3, 1),
	(34, 8700, 18, 'Schylling Jack-In-The-Box Musical Toy - 202881', 'This vintage style Schylling Jack in the Box features a playful Jester Clown character and comes brand new in its original box. With a recommended age range 3 years up , this classic toy is sure to bring joy and excitement to children and adults alike. Perfect for collectors or as a unique gift, this Jack in the Box is part of the Classic Toys category and can be found under Toys & Hobbies on eBay. Donot miss out on the chance to add this timeless piece to your collection or surprise someone special with a one-of-a-kind toy.', '2024-04-24 07:38:45', 50, 150, 17, 1, 3, 1),
	(35, 6100, 20, 'VAZ Lada 2106 The Cast Model Car Scale 1:32 Model Toy Collection Black', 'Great choice of gift for kids, especially for Birthday, Christmas and New Year Gift\r\nGreat item for collector, business gift, home decoration, office decoration, display', '2024-04-24 07:54:43', 50, 150, 18, 1, 5, 1),
	(36, 2300, 18, '1:24 motorcycle USSR Izh Yupiter 2K Russian Modimio magazine No51 USSR USSR USSR USSR USSR', '-', '2024-04-24 11:12:54', 50, 150, 19, 1, 5, 1),
	(37, 12500, 18, 'Diecast 1:50 Scale Kenworth W900 Maxicool', 'Introducing the Diecast 1:50 Scale Kenworth W900 Maxicool - Caterpillar styled engine , a brand new item that is perfect for collectors or anyone who loves trucks. Made by a trusted manufacturer , ICONIC REPLICAS , this model truck is highly detailed and accurately represents the Kenworth brand. With a 1:50 scale, it is perfect for display or for play and is sure to impress anyone who sees it.', '2024-04-24 11:48:44', 50, 150, 3, 1, 5, 1),
	(38, 2800, 19, 'Set of 7 Batman Batmobile & Truck Model Car Toy Kids Collection Black', 'No pull back function,you need to pushed forward and backward\r\nTips	Great choice of gift for kids,especially for Birthday,Christmas and New Year Gift\r\nGreat item for collector,business gift,home decoration,office decoration', '2024-04-24 12:37:33', 20, 100, 11, 1, 5, 1),
	(39, 2500, 20, 'LEGO Star Wars: 501st Legion Clone Troopers \r\n', 'Lego toy', '2024-06-27 14:49:27', 20, 100, 12, 1, 2, 1);

-- Dumping structure for table toyshopdb.product_has_color
CREATE TABLE IF NOT EXISTS `product_has_color` (
  `product_product_id` int NOT NULL,
  `color_color_id` int NOT NULL,
  KEY `fk_product_has_color_color1_idx` (`color_color_id`),
  KEY `fk_product_has_color_product1_idx` (`product_product_id`),
  CONSTRAINT `fk_product_has_color_color1` FOREIGN KEY (`color_color_id`) REFERENCES `color` (`color_id`),
  CONSTRAINT `fk_product_has_color_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.product_has_color: ~22 rows (approximately)
INSERT INTO `product_has_color` (`product_product_id`, `color_color_id`) VALUES
	(18, 7),
	(19, 8),
	(20, 9),
	(21, 8),
	(22, 6),
	(23, 8),
	(24, 4),
	(25, 8),
	(26, 11),
	(27, 8),
	(28, 8),
	(29, 8),
	(30, 12),
	(31, 13),
	(32, 8),
	(33, 7),
	(34, 8),
	(35, 2),
	(36, 5),
	(37, 9),
	(38, 2),
	(39, 8);

-- Dumping structure for table toyshopdb.product_image
CREATE TABLE IF NOT EXISTS `product_image` (
  `image_path` varchar(50) NOT NULL,
  `product_product_id` int NOT NULL,
  KEY `fk_product_image_product1_idx` (`product_product_id`),
  CONSTRAINT `fk_product_image_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.product_image: ~73 rows (approximately)
INSERT INTO `product_image` (`image_path`, `product_product_id`) VALUES
	('action_figures/DCDirectBTAS.jpg', 1),
	('building_toys/legocitysky.jpg', 2),
	('classic_toys/yomegaBrainYoYo.jpg', 3),
	('toy_vehicles/SkylineGTRR34.jpg', 4),
	('card_games/skyjo.jpg', 5),
	('educational_toys/matchingNumberGame.jpg', 6),
	('games/traditionalludo.jpg', 7),
	('rc_toys/FTXTracer.jpg', 8),
	('1_0.jpg', 1),
	('1_1.jpg', 1),
	('18_1.jpg', 18),
	('18_2.jpg', 18),
	('18_3.jpg', 18),
	('19_1.jpg', 19),
	('19_2.jpg', 19),
	('19_3.jpg', 19),
	('20_3.jpg', 20),
	('20_2.jpg', 20),
	('20_1.jpg', 20),
	('21_1.jpg', 21),
	('21_2.jpg', 21),
	('21_3.jpg', 21),
	('22_1.jpg', 22),
	('22_2.jpg', 22),
	('22_3.jpg', 22),
	('23_1.jpg', 23),
	('24_1.jpg', 24),
	('24_2.jpg', 24),
	('24_3.jpg', 24),
	('25_1.jpg', 25),
	('25_2.jpg', 25),
	('25_3.jpg', 25),
	('26_1.png', 26),
	('26_2.png', 26),
	('26_3.png', 26),
	('27_1.jpg', 27),
	('27_2.jpg', 27),
	('27_3.jpg', 27),
	('28_1.jpg', 28),
	('28_2.jpg', 28),
	('28_3.png', 28),
	('29_1.jpg', 29),
	('29_2.jpg', 29),
	('29_3.jpg', 29),
	('30_1.jpg', 30),
	('30_2.jpg', 30),
	('30_3.jpg', 30),
	('31_1.jpg', 31),
	('31_2.jpg', 31),
	('31_3.jpg', 31),
	('32_1.jpg', 32),
	('32_2.jpg', 32),
	('33_1.jpg', 33),
	('33_2.jpg', 33),
	('33_3.jpg', 33),
	('34_1.jpg', 34),
	('34_2.jpg', 34),
	('34_3.jpg', 34),
	('35_1.jpg', 35),
	('35_2.jpg', 35),
	('35_3.jpg', 35),
	('36_1.jpg', 36),
	('36_2.jpg', 36),
	('36_3.jpg', 36),
	('37_1.jpg', 37),
	('37_2.jpg', 37),
	('37_3.jpg', 37),
	('38_1.jpg', 38),
	('38_2.jpg', 38),
	('38_3.jpg', 38),
	('39_1.jpg', 39),
	('39_2.jpg', 39),
	('39_3.jpg', 39);

-- Dumping structure for table toyshopdb.province
CREATE TABLE IF NOT EXISTS `province` (
  `province_id` int NOT NULL AUTO_INCREMENT,
  `province_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.province: ~9 rows (approximately)
INSERT INTO `province` (`province_id`, `province_name`) VALUES
	(1, 'Southern'),
	(2, 'Western'),
	(3, 'Sabaragamuwa'),
	(4, 'Uva'),
	(5, 'Eastern'),
	(6, 'Central'),
	(7, 'Nort Central'),
	(8, 'Nothern'),
	(9, 'Wayaba');

-- Dumping structure for table toyshopdb.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` int NOT NULL AUTO_INCREMENT,
  `rate` double DEFAULT NULL,
  `user_review` varchar(500) DEFAULT NULL,
  `product_product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `review_date` datetime DEFAULT NULL,
  `invoice_item_invoice_item_id` int DEFAULT NULL,
  PRIMARY KEY (`review_id`),
  KEY `fk_reviews_product1_idx` (`product_product_id`),
  KEY `fk_reviews_user1_idx` (`user_email`),
  KEY `fk_reviews_invoice_item1_idx` (`invoice_item_invoice_item_id`),
  CONSTRAINT `fk_reviews_invoice_item1` FOREIGN KEY (`invoice_item_invoice_item_id`) REFERENCES `invoice_item` (`invoice_item_id`),
  CONSTRAINT `fk_reviews_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`),
  CONSTRAINT `fk_reviews_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.reviews: ~13 rows (approximately)
INSERT INTO `reviews` (`review_id`, `rate`, `user_review`, `product_product_id`, `user_email`, `review_date`, `invoice_item_invoice_item_id`) VALUES
	(1, 1, NULL, 19, 'ntsachira@gmail.com', '2024-02-04 12:46:28', 0),
	(5, 5, 'Good product', 19, 'ntsachira@gmail.com', '2024-02-04 12:54:41', 0),
	(6, 3, NULL, 6, 'ntsachira@gmail.com', '2024-02-04 14:08:34', 0),
	(7, 2, 'Amazing product, Good for Kids, thank You Toyshop', 1, 'ntsachira@gmail.com', '2024-02-04 17:48:16', 0),
	(8, 1, 'The worst product ever, Please do not deceive people for low quality products,\r\nI do not give any star but because the lowest is one, I give one', 1, 'sahan@gmail.com', '2024-02-04 17:53:36', 0),
	(14, 5, 'cool car , thanks seller', 20, 'ntsachira@gmail.com', '2024-02-23 12:29:15', 8),
	(15, 2, 'I found some damages parts but worth the price', 1, 'ntsachira@gmail.com', '2024-02-23 12:45:36', 10),
	(16, 4, NULL, 19, 'ntsachira@gmail.com', '2024-02-23 14:08:16', 12),
	(17, 2, 'I found s battery missing , but works fine', 4, 'ntsachira@gmail.com', '2024-02-23 14:12:03', 14),
	(18, 5, 'My kid really love this toy, Thank you', 1, 'ntsachira@gmail.com', '2024-02-23 14:20:03', 13),
	(19, 1, 'too bad', 20, 'ntsachira@gmail.com', '2024-02-28 13:16:10', 9),
	(20, 5, 'Thisis a cool toy, I love it, Thank you seller', 18, 'ntsachira@gmail.com', '2024-04-21 12:51:14', 11),
	(72, 3, 'good product', 25, 'prathi@gmail.com', '2024-04-23 12:08:47', NULL);

-- Dumping structure for table toyshopdb.review_status
CREATE TABLE IF NOT EXISTS `review_status` (
  `review_status_id` int NOT NULL AUTO_INCREMENT,
  `review_status_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`review_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.review_status: ~2 rows (approximately)
INSERT INTO `review_status` (`review_status_id`, `review_status_name`) VALUES
	(1, 'Reviewed'),
	(2, 'Not Reviewed');

-- Dumping structure for table toyshopdb.seen_status
CREATE TABLE IF NOT EXISTS `seen_status` (
  `seen_status_id` int NOT NULL AUTO_INCREMENT,
  `seen_status_name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`seen_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.seen_status: ~2 rows (approximately)
INSERT INTO `seen_status` (`seen_status_id`, `seen_status_name`) VALUES
	(1, 'Seen'),
	(2, 'Not Seen');

-- Dumping structure for table toyshopdb.status
CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int NOT NULL AUTO_INCREMENT,
  `status_name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.status: ~2 rows (approximately)
INSERT INTO `status` (`status_id`, `status_name`) VALUES
	(1, 'Active'),
	(2, 'Inactive');

-- Dumping structure for table toyshopdb.user
CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(100) CHARACTER SET utf32 COLLATE utf32_general_ci NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `joined_date` datetime NOT NULL,
  `verification_code` varchar(20) DEFAULT NULL,
  `gender_gender_id` int NOT NULL,
  `status_status_id` int NOT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_user_gender_idx` (`gender_gender_id`),
  KEY `fk_user_status1_idx` (`status_status_id`),
  CONSTRAINT `fk_user_gender` FOREIGN KEY (`gender_gender_id`) REFERENCES `gender` (`gender_id`),
  CONSTRAINT `fk_user_status1` FOREIGN KEY (`status_status_id`) REFERENCES `status` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.user: ~12 rows (approximately)
INSERT INTO `user` (`email`, `first_name`, `last_name`, `password`, `mobile`, `joined_date`, `verification_code`, `gender_gender_id`, `status_status_id`) VALUES
	('admin@gmail.com', 'Toyshop', 'Admin', '****', '****', '2022-02-06 14:14:33', NULL, 1, 1),
	('amanda@outlook.com', 'Hirushi', 'Amanda', '$2y$10$1iv.xalDEIoDTnb/I0hyM.CfT/Ms7rl7/34GN.KSjtoJ00vOKbQQ6', '0747845123', '2024-06-26 14:17:13', NULL, 2, 1),
	('jakob@gmail.com', 'Jackob', 'Addams', '$2y$10$lEAAZ4Uvf6eC/DiVgreSkO6D3U2DTW9kKFhpPitndVpek0Jwng0bC', '0778956123', '2024-06-26 14:11:09', NULL, 1, 1),
	('kamal@gmail.com', 'Kamal', 'Jayalath', '$2y$10$4EBORMXLjKhEMjhJKrcWxuRyfk03jFzZIzUSkrJukGpuU9BHXzhDy', '0777845123', '2024-02-06 04:13:15', NULL, 1, 2),
	('megha@gmail.com', 'Megha ', 'Blast', '$2y$10$ewRtFVEBGiWYngKGbkNuleRGwairG7l.3Dznknmx0.tyDLLMYHOQy', '0764512789', '2024-06-26 14:20:05', NULL, 1, 1),
	('ntsachira@gmail.com', 'Sachira', 'Jayawardana', '$2y$10$Fod1J9x5AZ06or0t0FxpAuIY0HxRnH7mBy3JvP.e4U.AWbQXXE2jS', '0714798940', '2023-12-24 09:49:17', '667d5ecf8f9f6', 1, 1),
	('oshada@gmail.com', 'Oshadha', 'Deemantha', '$2y$10$dYcasrnWGUmW92.eOX5UcuiM4xSlY1M87oESY1SW16ixEIa6Onz16', '0711285213', '2024-01-25 12:59:39', NULL, 1, 1),
	('prabath@gmail.com', 'Prabath', 'Bandara', '$2y$10$xOwkEdId8gPFvR6gla1Ue.TA6bECnhNAJTVp78a5PNpgg1Cc/pJkm', '0708596741', '2024-02-06 04:15:02', NULL, 1, 1),
	('prathi@gmail.com', 'Prathibhani', 'Manohari', '$2y$10$qWkbQyYAOJeWp77lVtenquevHLcrNQ.wXlSEb6u8kjeY2JIZsAcOS', '0774152963', '2024-01-21 12:44:45', '667b9c1435766', 2, 2),
	('rmp@gmail.com', 'Prathibhani', 'Manohari', '$2y$10$h/I5Y5nHimCHv/inxM334O8YaGTPkrI4vLJVpem7JtplkjWl2scae', '0714152963', '2025-03-07 10:20:43', NULL, 2, 1),
	('sahan@gmail.com', 'Sahan', 'Perera', '$2y$10$CQyfNs33RH8zxoGlbRNdh.8FpSwBNIYbU6EpV3/XiRsBVzv016HHm', '0714798940', '2023-12-24 18:26:05', NULL, 1, 1),
	('tharindu@gmail.com', 'Tharindu', 'Dilshan', '$2y$10$uWFWNCeAzrCy35/Pz9nUxerXSculJCBZjWzUmriLWIG1qEcwlfnFu', '0704856954', '2024-02-25 16:51:17', NULL, 1, 1);

-- Dumping structure for table toyshopdb.user_has_address
CREATE TABLE IF NOT EXISTS `user_has_address` (
  `user_email` varchar(100) NOT NULL,
  `city_city_id` int NOT NULL,
  `address_id` int NOT NULL AUTO_INCREMENT,
  `line1` text,
  `line2` text,
  `postal_code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`address_id`),
  KEY `fk_user_has_city_city1_idx` (`city_city_id`),
  KEY `fk_user_has_city_user1_idx` (`user_email`),
  CONSTRAINT `fk_user_has_city_city1` FOREIGN KEY (`city_city_id`) REFERENCES `city` (`city_id`),
  CONSTRAINT `fk_user_has_city_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.user_has_address: ~4 rows (approximately)
INSERT INTO `user_has_address` (`user_email`, `city_city_id`, `address_id`, `line1`, `line2`, `postal_code`) VALUES
	('ntsachira@gmail.com', 1, 3, 'Bothuragoda', 'Hiththatiya East', '81000'),
	('sahan@gmail.com', 7, 4, 'No.10', 'Matara Road', '118000'),
	('tharindu@gmail.com', 4, 5, 'No 23', 'Old Matara Road', '81000'),
	('prathi@gmail.com', 6, 6, 'Pasasuma', 'Malwaththa, Maliththa', '89000');

-- Dumping structure for table toyshopdb.user_image
CREATE TABLE IF NOT EXISTS `user_image` (
  `image_path` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`image_path`),
  KEY `fk_user_image_user1_idx` (`user_email`),
  CONSTRAINT `fk_user_image_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.user_image: ~3 rows (approximately)
INSERT INTO `user_image` (`image_path`, `user_email`) VALUES
	('Sachira_0714798940.jpeg', 'ntsachira@gmail.com'),
	('Sahan_0714798940.jpeg', 'sahan@gmail.com'),
	('Tharindu_0704856954.jpg', 'tharindu@gmail.com');

-- Dumping structure for table toyshopdb.watchlist
CREATE TABLE IF NOT EXISTS `watchlist` (
  `watchlist_id` int NOT NULL AUTO_INCREMENT,
  `product_product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`watchlist_id`),
  KEY `fk_watchlist_product1_idx` (`product_product_id`),
  KEY `fk_watchlist_user1_idx` (`user_email`),
  CONSTRAINT `fk_watchlist_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`),
  CONSTRAINT `fk_watchlist_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf32;

-- Dumping data for table toyshopdb.watchlist: ~9 rows (approximately)
INSERT INTO `watchlist` (`watchlist_id`, `product_product_id`, `user_email`) VALUES
	(36, 3, 'sahan@gmail.com'),
	(46, 3, 'ntsachira@gmail.com'),
	(55, 22, 'prathi@gmail.com'),
	(59, 32, 'sahan@gmail.com'),
	(60, 35, 'sahan@gmail.com'),
	(61, 37, 'sahan@gmail.com'),
	(62, 34, 'sahan@gmail.com'),
	(63, 1, 'prathi@gmail.com'),
	(64, 18, 'prathi@gmail.com'),
	(66, 37, 'rmp@gmail.com'),
	(68, 24, 'rmp@gmail.com');

-- Dumping structure for view toyshopdb.active_category
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `active_category`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `active_category` AS select `category`.`category_id` AS `category_id`,`category`.`category_name` AS `category_name`,`category`.`status_status_id` AS `status_status_id` from `category` where (`category`.`status_status_id` = 1);

-- Dumping structure for view toyshopdb.active_product
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `active_product`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `active_product` AS select `product`.`product_id` AS `product_id`,`product`.`price` AS `price`,`product`.`quantity` AS `quantity`,`product`.`title` AS `title`,`product`.`description` AS `description`,`product`.`datetime_added` AS `datetime_added`,`product`.`delivery_fee_matara` AS `delivery_fee_matara`,`product`.`delivery_fee_other` AS `delivery_fee_other`,`brand`.`brand_name` AS `brand_name`,`model`.`model_name` AS `model_name`,`condition`.`condition_name` AS `condition_name`,`status`.`status_name` AS `status_name`,`color`.`color_name` AS `color_name`,`category`.`category_name` AS `category_name`,`category`.`category_id` AS `category_id`,`condition`.`condition_id` AS `condition_id`,`brand`.`brand_id` AS `brand_id`,`model`.`model_id` AS `model_id`,`color`.`color_id` AS `color_id` from ((((((((`product` join `brand_has_model` on((`product`.`brand_has_model_brand_has_model_id` = `brand_has_model`.`brand_has_model_id`))) join `brand` on((`brand_has_model`.`brand_brand_id` = `brand`.`brand_id`))) join `model` on((`brand_has_model`.`model_model_id` = `model`.`model_id`))) join `condition` on((`product`.`condition_condition_id` = `condition`.`condition_id`))) join `status` on((`product`.`status_status_id` = `status`.`status_id`))) left join `product_has_color` on((`product`.`product_id` = `product_has_color`.`product_product_id`))) left join `color` on((`color`.`color_id` = `product_has_color`.`color_color_id`))) join `category` on((`product`.`category_category_id` = `category`.`category_id`))) where (`status`.`status_id` = '1');

-- Dumping structure for view toyshopdb.active_user
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `active_user`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `active_user` AS select `user`.`email` AS `email`,`user`.`first_name` AS `first_name`,`user`.`last_name` AS `last_name`,`user`.`password` AS `password`,`user`.`mobile` AS `mobile`,`user`.`joined_date` AS `joined_date`,`user`.`verification_code` AS `verification_code`,`user`.`gender_gender_id` AS `gender_gender_id`,`user`.`status_status_id` AS `status_status_id`,`gender`.`gender_id` AS `gender_id`,`gender`.`gender_name` AS `gender_name`,`status`.`status_id` AS `status_id`,`status`.`status_name` AS `status_name` from ((`user` join `gender` on((`gender`.`gender_id` = `user`.`gender_gender_id`))) join `status` on((`status`.`status_id` = `user`.`status_status_id`)));

-- Dumping structure for view toyshopdb.city_data
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `city_data`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `city_data` AS select `city`.`city_id` AS `city_id`,`city`.`city_name` AS `city_name`,`city`.`district_district_id` AS `district_district_id`,`district`.`district_id` AS `district_id`,`district`.`district_name` AS `district_name`,`district`.`province_province_id` AS `province_province_id`,`province`.`province_id` AS `province_id`,`province`.`province_name` AS `province_name` from ((`city` join `district` on((`city`.`district_district_id` = `district`.`district_id`))) join `province` on((`district`.`province_province_id` = `province`.`province_id`)));

-- Dumping structure for view toyshopdb.full_product
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `full_product`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `full_product` AS select `product`.`product_id` AS `product_id`,`product`.`price` AS `price`,`product`.`quantity` AS `quantity`,`product`.`title` AS `title`,`product`.`description` AS `description`,`product`.`datetime_added` AS `datetime_added`,`product`.`delivery_fee_matara` AS `delivery_fee_matara`,`product`.`delivery_fee_other` AS `delivery_fee_other`,`brand`.`brand_name` AS `brand_name`,`model`.`model_name` AS `model_name`,`condition`.`condition_name` AS `condition_name`,`status`.`status_name` AS `status_name`,`color`.`color_name` AS `color_name`,`category`.`category_name` AS `category_name`,`category`.`category_id` AS `category_id`,`condition`.`condition_id` AS `condition_id`,`brand`.`brand_id` AS `brand_id`,`model`.`model_id` AS `model_id`,`color`.`color_id` AS `color_id` from ((((((((`product` join `brand_has_model` on((`product`.`brand_has_model_brand_has_model_id` = `brand_has_model`.`brand_has_model_id`))) join `brand` on((`brand_has_model`.`brand_brand_id` = `brand`.`brand_id`))) join `model` on((`brand_has_model`.`model_model_id` = `model`.`model_id`))) join `condition` on((`product`.`condition_condition_id` = `condition`.`condition_id`))) join `status` on((`product`.`status_status_id` = `status`.`status_id`))) left join `product_has_color` on((`product`.`product_id` = `product_has_color`.`product_product_id`))) left join `color` on((`color`.`color_id` = `product_has_color`.`color_color_id`))) join `category` on((`product`.`category_category_id` = `category`.`category_id`)));

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
