-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 06, 2021 at 02:14 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `risi`
--

-- --------------------------------------------------------

--
-- Table structure for table `lkp_jenis_pemantauan`
--

CREATE TABLE `lkp_jenis_pemantauan` (
  `id_jenis_pemantauan` int(10) DEFAULT NULL,
  `jenis_pemantauan` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lkp_jenis_pemantauan`
--
ALTER TABLE `lkp_jenis_pemantauan`
  ADD KEY `id_jenis_pemantauan` (`id_jenis_pemantauan`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lkp_jenis_pemantauan`
--
ALTER TABLE `lkp_jenis_pemantauan`
  ADD CONSTRAINT `lkp_jenis_pemantauan_ibfk_1` FOREIGN KEY (`id_jenis_pemantauan`) REFERENCES `pemantauan` (`id_jenis_pemantauan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
