-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 14, 2019 at 06:42 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `menu`
--
CREATE DATABASE IF NOT EXISTS `menu` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `menu`;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` char(13) NOT NULL,
  `name` varchar(64) NOT NULL,
  `image` char(13) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `image`, `price`, `category`) VALUES
(1, 'Signature Milk Tea', '1.png', '2.80','drink'),
(2, 'Brown Sugar Milk Tea', '2.png', '3.40','drink'),
(3, 'Passionfruit Green Tea', '3.png', '2.80','drink'),
(4, 'Brown Sugar Pearls', '4.jpg', '0.60','topping'),
(5, 'Grass Jelly', '5.jpg', '0.70','topping'),
(6, 'White Pearls', '6.jpg', '0.70','topping');
COMMIT;

-- INSERT INTO `menu` (`id`, `name`, `image`, `price`) VALUES
-- (1, 'Brown Sugar Milk Tea', '1.jpg', '3.40'),
-- (2, 'Signature Milk Tea', '2.jpg', '2.80'),
-- (3, 'Strawberry Cheese Tea', '3.jpg', '5.90'),
-- (4, 'Pearls', '4.jpg', '0.60'),
-- (5, 'Grass Jelly', '5.jpg', '0.70');
-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
