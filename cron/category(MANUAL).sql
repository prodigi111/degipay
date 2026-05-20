-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 06, 2021 at 06:53 PM
-- Server version: 10.3.27-MariaDB-log-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nectpayc_rgs`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `code` varchar(120) NOT NULL,
  `name` varchar(120) NOT NULL,
  `type` varchar(120) NOT NULL,
  `real` varchar(120) NOT NULL,
  `order` enum('prepaid','postpaid') NOT NULL,
  `detect` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `code`, `name`, `type`, `real`, `order`, `detect`) VALUES
(1, 'MOBILE LEGEND', 'MOBILE LEGEND', 'games', 'GAMES', 'prepaid', 'true'),
(2, 'FREE FIRE', 'FREE FIRE', 'games', 'GAMES', 'prepaid', 'true'),
(3, 'PUBG MOBILE', 'PUBG MOBILE', 'games', 'GAMES', 'prepaid', 'true'),
(4, 'COD MOBILE', 'COD MOBILE', 'games', 'GAMES', 'prepaid', 'true'),
(5, 'ARENA OF VALOR', 'ARENA OF VALOR', 'games', 'GAMES', 'prepaid', 'true'),
(6, 'VALORANT', 'VALORANT', 'games', 'GAMES', 'prepaid', 'true'),
(7, 'SPEED DRIFTERS', 'SPEED DRIFTERS', 'games', 'GAMES', 'prepaid', 'true'),
(8, 'HAGO', 'HAGO', 'games', 'GAMES', 'prepaid', 'true'),
(9, 'RAGNAROK', 'RAGNAROK', 'games', 'GAMES', 'prepaid', 'true'),
(10, 'TELKOMSEL', 'TELKOMSEL', 'pulsa-transfer', 'pulsa-transfer', 'prepaid', '-');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
