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
-- Table structure for table `lkp_jenis_risi`
--

CREATE TABLE `lkp_jenis_risi` (
  `id_jenis_risi` int(10) NOT NULL,
  `jenis_risi` varchar(250) DEFAULT NULL,
  `id_agama` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lkp_jenis_risi`
--

INSERT INTO `lkp_jenis_risi` (`id_jenis_risi`, `jenis_risi`, `id_agama`) VALUES
(1, 'Tokong', NULL),
(2, 'Gereja', NULL),
(3, 'Kuil', NULL),
(4, 'Gurdwara', NULL),
(5, 'Baha\'i Centre', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lkp_jenis_risi`
--
ALTER TABLE `lkp_jenis_risi`
  ADD PRIMARY KEY (`id_jenis_risi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lkp_jenis_risi`
--
ALTER TABLE `lkp_jenis_risi`
  MODIFY `id_jenis_risi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
