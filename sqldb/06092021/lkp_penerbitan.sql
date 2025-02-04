-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 06, 2021 at 02:15 PM
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
-- Table structure for table `lkp_penerbitan`
--

CREATE TABLE `lkp_penerbitan` (
  `id_jenis_penerbitan` int(20) DEFAULT NULL,
  `jenis_penerbitan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lkp_penerbitan`
--

INSERT INTO `lkp_penerbitan` (`id_jenis_penerbitan`, `jenis_penerbitan`) VALUES
(1, 'SOP'),
(2, 'Garis Panduan'),
(3, 'Pekeliling');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lkp_penerbitan`
--
ALTER TABLE `lkp_penerbitan`
  ADD KEY `lkp_penerbitan_ibfk_1` (`id_jenis_penerbitan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
