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
-- Table structure for table `lkp_agama`
--

CREATE TABLE `lkp_agama` (
  `id_agama` int(10) NOT NULL,
  `nama_agama` varchar(250) DEFAULT NULL,
  `id_jenis_risi` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lkp_agama`
--

INSERT INTO `lkp_agama` (`id_agama`, `nama_agama`, `id_jenis_risi`) VALUES
(1, 'Buddha', 1),
(2, 'Kristian', 2),
(3, 'Hindu', 3),
(4, 'Sikh', 4),
(5, 'Tao', 1),
(6, 'Baha\'i', 5),
(7, 'Lain_lain', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lkp_agama`
--
ALTER TABLE `lkp_agama`
  ADD PRIMARY KEY (`id_agama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lkp_agama`
--
ALTER TABLE `lkp_agama`
  MODIFY `id_agama` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
