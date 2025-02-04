-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 06, 2021 at 02:13 PM
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
-- Table structure for table `lkp_access`
--

CREATE TABLE `lkp_access` (
  `id_access` int(1) NOT NULL,
  `access_type` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lkp_access`
--

INSERT INTO `lkp_access` (`id_access`, `access_type`) VALUES
(1, 'Pentadbir Sistem'),
(2, 'Pentadbir Negeri'),
(3, 'Pegawai BPHM'),
(4, 'Pengurusan Tertinggi'),
(5, 'Pengguna Biasa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lkp_access`
--
ALTER TABLE `lkp_access`
  ADD PRIMARY KEY (`id_access`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lkp_access`
--
ALTER TABLE `lkp_access`
  MODIFY `id_access` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
