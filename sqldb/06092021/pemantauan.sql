-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 06, 2021 at 02:16 PM
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
-- Table structure for table `pemantauan`
--

CREATE TABLE `pemantauan` (
  `id_pemantauan` int(100) DEFAULT NULL,
  `id_jenis_pemantauan` int(3) DEFAULT NULL,
  `id_ss_pemantauan` int(3) DEFAULT NULL,
  `status_pematuhan` int(3) DEFAULT NULL,
  `catatan` varchar(250) DEFAULT NULL,
  `tarikh` date DEFAULT NULL,
  `tujuan` varchar(250) DEFAULT NULL,
  `id_personel` varchar(0) DEFAULT NULL,
  `laporan` varchar(250) DEFAULT NULL,
  `id_risi` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pemantauan`
--
ALTER TABLE `pemantauan`
  ADD KEY `id_jenis_pemantauan` (`id_jenis_pemantauan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
