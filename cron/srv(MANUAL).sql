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
-- Table structure for table `srv`
--

CREATE TABLE `srv` (
  `id` int(11) NOT NULL,
  `type` varchar(120) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(120) NOT NULL,
  `note` text NOT NULL,
  `price` int(13) NOT NULL,
  `status` enum('available','empty') NOT NULL,
  `brand` varchar(120) NOT NULL,
  `kategori` varchar(128) NOT NULL,
  `provider` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `srv`
--

INSERT INTO `srv` (`id`, `type`, `code`, `name`, `note`, `price`, `status`, `brand`, `kategori`, `provider`) VALUES
(1, 'games', 'FF50', 'DM - 50 Diamonds', '', 6700, 'available', 'FREE FIRE', 'Umum', 'X'),
(2, 'games', 'FF70', 'DM - 70 Diamonds', '', 9200, 'available', 'FREE FIRE', 'Umum', 'X'),
(3, 'games', 'PUBG35', '35 UC', '', 6500, 'available', 'PUBG MOBILE', 'Umum', 'X'),
(4, 'games', 'PUBG74', '74 UC', '', 13000, 'available', 'PUBG MOBILE', 'Umum', 'X'),
(5, 'games', 'CODM53', '53 CP', 'TIDAK BERLAKU UNTUK AKUN YANG TERBIND AKUN GARENA', 7000, 'available', 'COD MOBILE', 'Umum', 'X'),
(6, 'games', 'CODM112', '112 CP', 'TIDAK BERLAKU UNTUK AKUN YANG TERBIND AKUN GARENA', 14000, 'available', 'COD MOBILE', 'Umum', 'X'),
(7, 'games', 'FF100', 'DM - 100 Diamonds', '', 13300, 'available', 'FREE FIRE', 'Umum', 'X'),
(8, 'games', 'FF140', 'DM - 140 Diamonds', '', 18300, 'available', 'FREE FIRE', 'Umum', 'X'),
(9, 'games', 'FF150', 'DM - 150 Diamonds', '', 20000, 'available', 'FREE FIRE', 'Umum', 'X'),
(10, 'games', 'FF210', 'DM - 210 Diamonds', '', 27500, 'available', 'FREE FIRE', 'Umum', 'X'),
(11, 'games', 'FF250', 'DM - 250 Diamonds', '', 33000, 'available', 'FREE FIRE', 'Umum', 'X'),
(12, 'games', 'FF280', 'DM - 280 Diamonds', '', 36500, 'available', 'FREE FIRE', 'Umum', 'X'),
(13, 'games', 'FF300', 'DM - 300 Diamonds', '', 39500, 'available', 'FREE FIRE', 'Umum', 'X'),
(14, 'games', 'FF355', 'DM - 355 Diamonds', '', 46000, 'available', 'FREE FIRE', 'Umum', 'X'),
(15, 'games', 'FF425', 'DM - 425 Diamonds', '', 55400, 'available', 'FREE FIRE', 'Umum', 'X'),
(16, 'games', 'FF500', 'DM - 500 Diamonds', '', 65000, 'available', 'FREE FIRE', 'Umum', 'X'),
(17, 'games', 'FF565', 'DM - 565 Diamonds', '', 72000, 'available', 'FREE FIRE', 'Umum', 'X'),
(18, 'games', 'FF720', 'DM - 720 Diamonds', '', 92000, 'available', 'FREE FIRE', 'Umum', 'X'),
(19, 'games', 'FF1000', 'DM - 1000 Diamonds', '', 129000, 'available', 'FREE FIRE', 'Umum', 'X'),
(20, 'games', 'FF1075', 'DM - 1075 Diamonds', '', 138000, 'available', 'FREE FIRE', 'Umum', 'X'),
(21, 'games', 'FF2000', 'DM - 2000 Diamonds', '', 252000, 'available', 'FREE FIRE', 'Umum', 'X'),
(22, 'games', 'FF4000', 'DM - 4000 Diamonds', '', 504000, 'available', 'FREE FIRE', 'Umum', 'X'),
(23, 'games', 'FF6000', 'DM - 6000 Diamonds', '', 754000, 'available', 'FREE FIRE', 'Umum', 'X'),
(24, 'games', 'FF7290', 'DM - 7290 Diamonds', '', 920000, 'available', 'FREE FIRE', 'Umum', 'X'),
(25, 'games', 'FF9290', 'DM - 9290 Diamonds', '', 1165000, 'available', 'FREE FIRE', 'Umum', 'X'),
(26, 'games', 'FFMM7', 'PK - Member Mingguan', '', 28000, 'available', 'FREE FIRE', 'Umum', 'X'),
(27, 'games', 'FFMB', 'PK - Member Bulanan', '', 112000, 'available', 'FREE FIRE', 'Umum', 'X'),
(28, 'games', 'CODM165', '165 CP', 'TIDAK BERLAKU UNTUK AKUN YANG TERBIND AKUN GARENA', 21000, 'available', 'COD MOBILE', 'Umum', 'X'),
(29, 'games', 'CODM278', '278 CP', 'TIDAK BERLAKU UNTUK AKUN YANG TERBIND AKUN GARENA', 32000, 'available', 'COD MOBILE', 'Umum', 'X'),
(30, 'games', 'CODM581', '581 CP', 'TIDAK BERLAKU UNTUK AKUN YANG TERBIND AKUN GARENA', 64000, 'available', 'COD MOBILE', 'Umum', 'X'),
(31, 'games', 'CODM634', '634 CP', 'TIDAK BERLAKU UNTUK AKUN YANG TERBIND AKUN GARENA', 71000, 'available', 'COD MOBILE', 'Umum', 'X'),
(32, 'games', 'CODM859', '859 CP', 'TIDAK BERLAKU UNTUK AKUN YANG TERBIND AKUN GARENA', 93000, 'available', 'COD MOBILE', 'Umum', 'X'),
(33, 'games', 'CODM1268', '1268 CP', 'TIDAK BERLAKU UNTUK AKUN YANG TERBIND AKUN GARENA', 123000, 'available', 'COD MOBILE', 'Umum', 'X'),
(34, 'games', 'CODM1901', '1901 CP', 'TIDAK BERLAKU UNTUK AKUN YANG TERBIND AKUN GARENA', 185000, 'available', 'COD MOBILE', 'Umum', 'X'),
(35, 'games', 'CODM3300', '3300 CP', 'TIDAK BERLAKU UNTUK AKUN YANG TERBIND AKUN GARENA', 308000, 'available', 'COD MOBILE', 'Umum', 'X'),
(36, 'games', 'CODM7128', '7128 CP', 'TIDAK BERLAKU UNTUK AKUN YANG TERBIND AKUN GARENA', 620000, 'available', 'COD MOBILE', 'Umum', 'X'),
(37, 'games', 'PUBG221', '221 UC', '', 36000, 'available', 'PUBG MOBILE', 'Umum', 'X'),
(38, 'games', 'PUBG770', '770 UC', '', 125000, 'available', 'PUBG MOBILE', 'Umum', 'X'),
(39, 'games', 'PUBG2013', '2013 UC', '', 300000, 'available', 'PUBG MOBILE', 'Umum', 'X'),
(40, 'games', 'PUBG4200', '4200 UC', '', 600000, 'available', 'PUBG MOBILE', 'Umum', 'X'),
(41, 'games', 'PUBG8750', '8750 UC', '', 1160000, 'available', 'PUBG MOBILE', 'Umum', 'X'),
(42, 'pulsa-transfer', 'TF10', 'Telkomsel 10.000', 'Tidak Menambah Masa Aktif', 10200, 'available', 'TELKOMSEL', 'Umum', 'X'),
(43, 'pulsa-transfer', 'TF15', 'Telkomsel 15.000', 'Tidak Menambah Masa Aktif', 14600, 'available', 'TELKOMSEL', 'Umum', 'X'),
(44, 'pulsa-transfer', 'TF20', 'Telkomsel 20.000', 'Tidak Menambah Masa Aktif', 19300, 'available', 'TELKOMSEL', 'Umum', 'X'),
(45, 'pulsa-transfer', 'TF25', 'Telkomsel 25.000', 'Tidak Menambah Masa Aktif', 23700, 'available', 'TELKOMSEL', 'Umum', 'X'),
(46, 'pulsa-transfer', 'TF40', 'Telkomsel 40.000', 'Tidak Menambah Masa Aktif', 36400, 'available', 'TELKOMSEL', 'Umum', 'X'),
(47, 'pulsa-transfer', 'TF30', 'Telkomsel 30.000', 'Tidak Menambah Masa Aktif', 28000, 'available', 'TELKOMSEL', 'Umum', 'X'),
(48, 'pulsa-transfer', 'TF35', 'Telkomsel 35.000', 'Tidak Menambah Masa Aktif', 32200, 'available', 'TELKOMSEL', 'Umum', 'X'),
(49, 'pulsa-transfer', 'TF45', 'Telkomsel 45.000', 'Tidak Menambah Masa Aktif', 41000, 'available', 'TELKOMSEL', 'Umum', 'X'),
(50, 'pulsa-transfer', 'TF50', 'Telkomsel 50.000', 'Tidak Menambah Masa Aktif', 45600, 'available', 'TELKOMSEL', 'Umum', 'X'),
(51, 'pulsa-transfer', 'TF55', 'Telkomsel 55.000', 'Tidak Menambah Masa Aktif', 50000, 'available', 'TELKOMSEL', 'Umum', 'X'),
(52, 'pulsa-transfer', 'TF60', 'Telkomsel 60.000', 'Tidak Menambah Masa Aktif', 54200, 'available', 'TELKOMSEL', 'Umum', 'X'),
(53, 'pulsa-transfer', 'TF65', 'Telkomsel 65.000', 'Tidak Menambah Masa Aktif', 58600, 'available', 'TELKOMSEL', 'Umum', 'X'),
(54, 'pulsa-transfer', 'TF70', 'Telkomsel 70.000', 'Tidak Menambah Masa Aktif', 63000, 'available', 'TELKOMSEL', 'Umum', 'X'),
(55, 'pulsa-transfer', 'TF75', 'Telkomsel 75.000', 'Tidak Menambah Masa Aktif', 67200, 'available', 'TELKOMSEL', 'Umum', 'X'),
(56, 'pulsa-transfer', 'TF80', 'Telkomsel 80.000', 'Tidak Menambah Masa Aktif', 71600, 'available', 'TELKOMSEL', 'Umum', 'X'),
(57, 'pulsa-transfer', 'TF85', 'Telkomsel 85.000', 'Tidak Menambah Masa Aktif', 75000, 'available', 'TELKOMSEL', 'Umum', 'X'),
(58, 'pulsa-transfer', 'TF90', 'Telkomsel 90.000', 'Tidak Menambah Masa Aktif', 80200, 'available', 'TELKOMSEL', 'Umum', 'X'),
(59, 'pulsa-transfer', 'TF95', 'Telkomsel 95.000', 'Tidak Menambah Masa Aktif', 84600, 'available', 'TELKOMSEL', 'Umum', 'X'),
(60, 'pulsa-transfer', 'TF100', 'Telkomsel 100.000', 'Tidak Menambah Masa Aktif', 89000, 'available', 'TELKOMSEL', 'Umum', 'X'),
(61, 'pulsa-transfer', 'TF200', 'Telkomsel 200.000', 'Tidak Menambah Masa Aktif', 177200, 'available', 'TELKOMSEL', 'Umum', 'X'),
(62, 'pulsa-transfer', 'TF300', 'Telkomsel 300.000', 'Tidak Menambah Masa Aktif', 265000, 'available', 'TELKOMSEL', 'Umum', 'X'),
(63, 'pulsa-transfer', 'TF400', 'Telkomsel 400.000', 'Tidak Menambah Masa Aktif', 351500, 'available', 'TELKOMSEL', 'Umum', 'X'),
(64, 'pulsa-transfer', 'TF500', 'Telkomsel 500.000', 'Tidak Menambah Masa Aktif', 438000, 'available', 'TELKOMSEL', 'Umum', 'X'),
(65, 'games', 'ML86', 'DM - 86 Diamonds', '', 17700, 'available', 'MOBILE LEGEND', 'Umum', 'X'),
(66, 'games', 'ML172', 'DM - 172 Diamonds', '', 35900, 'available', 'MOBILE LEGEND', 'Umum', 'X'),
(67, 'games', 'ML257', 'DM - 257 Diamonds', '', 53100, 'available', 'MOBILE LEGEND', 'Umum', 'X'),
(68, 'games', 'ML706', 'DM - 706 Diamonds', '', 141600, 'available', 'MOBILE LEGEND', 'Umum', 'X'),
(69, 'games', 'ML2194', 'DM - 2194 Diamonds', '', 420375, 'available', 'MOBILE LEGEND', 'Umum', 'X'),
(70, 'games', 'ML3668', 'DM - 3668 Diamonds', '', 699150, 'available', 'MOBILE LEGEND', 'Umum', 'X'),
(71, 'games', 'ML5532', 'DM - 5532 Diamonds', '', 1050000, 'available', 'MOBILE LEGEND', 'Umum', 'X'),
(72, 'games', 'ML9288', 'DM - 9288 Diamonds', '', 1758200, 'available', 'MOBILE LEGEND', 'Umum', 'X'),
(73, 'games', 'MLSL', 'PK - Starlight Member', '', 118800, 'available', 'MOBILE LEGEND', 'Umum', 'X'),
(74, 'games', 'MLSLPLUS', 'PK - Starlight Member Plus', '', 270000, 'available', 'MOBILE LEGEND', 'Umum', 'X'),
(75, 'games', 'MLTP', 'PK - TWILIGHT PASS', '', 118800, 'available', 'MOBILE LEGEND', 'Umum', 'X');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `srv`
--
ALTER TABLE `srv`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `srv`
--
ALTER TABLE `srv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
