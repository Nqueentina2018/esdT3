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
  `name` varchar(64) NOT NULL,
  `menuID` char(13) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(64) NOT NULL,
  PRIMARY KEY (`menuID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`name`, `menuID`, `price`, `category`) VALUES
('Milk Tea', 'D1', '3.00','drink'),
('Passion Fruit Yakult', 'D2', '3.50','drink'),
('Earl Grey Milk Tea', 'D3', '3.20','drink'),
('Ginger Milk Tea', 'D3', '3.20','drink'),
('Pearl', 'T1', '0.30','topping'),
('Jelly', 'T2', '0.30','topping'),
('Rainbow Jelly', 'T3', '0.30','topping'),
('Aloe Vera', 'T4', '0.30','topping');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
