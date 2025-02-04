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
-- Table structure for table `lkp_mazhab`
--

CREATE TABLE `lkp_mazhab` (
  `id_mazhab` int(10) NOT NULL,
  `nama_mazhab` varchar(250) DEFAULT NULL,
  `id_agama` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lkp_mazhab`
--

INSERT INTO `lkp_mazhab` (`id_mazhab`, `nama_mazhab`, `id_agama`) VALUES
(1, 'Roman Katolik', 2),
(2, 'Protestan', 2),
(3, 'Ortodox', 2),
(4, 'Lain-lain', 7),
(5, 'Tiada Maklumat', 2),
(6, NULL, NULL),
(7, 'Theeravada', 1),
(8, 'Shaivam', 3),
(9, 'Gaumaram', 3),
(10, 'Ganapathyam', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lkp_mazhab`
--
ALTER TABLE `lkp_mazhab`
  ADD PRIMARY KEY (`id_mazhab`),
  ADD KEY `id_agama` (`id_agama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lkp_mazhab`
--
ALTER TABLE `lkp_mazhab`
  MODIFY `id_mazhab` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lkp_mazhab`
--
ALTER TABLE `lkp_mazhab`
  ADD CONSTRAINT `lkp_mazhab_ibfk_1` FOREIGN KEY (`id_agama`) REFERENCES `lkp_agama` (`id_agama`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
