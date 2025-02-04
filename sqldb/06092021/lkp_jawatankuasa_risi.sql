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
-- Table structure for table `lkp_jawatankuasa_risi`
--

CREATE TABLE `lkp_jawatankuasa_risi` (
  `id_jawatan` int(10) NOT NULL,
  `nama_jawatan` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lkp_jawatankuasa_risi`
--

INSERT INTO `lkp_jawatankuasa_risi` (`id_jawatan`, `nama_jawatan`) VALUES
(1, 'Pengerusi/Pemimpin/Penghulu'),
(2, 'Setiausaha'),
(3, 'Naib Pengerusi/Penolong Ketua'),
(4, 'Bendahari'),
(5, 'Lain-lain'),
(6, 'Tiada Maklumat'),
(7, 'Paderi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lkp_jawatankuasa_risi`
--
ALTER TABLE `lkp_jawatankuasa_risi`
  ADD PRIMARY KEY (`id_jawatan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lkp_jawatankuasa_risi`
--
ALTER TABLE `lkp_jawatankuasa_risi`
  MODIFY `id_jawatan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
