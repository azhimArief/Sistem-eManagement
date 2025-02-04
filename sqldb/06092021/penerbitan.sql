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
-- Table structure for table `penerbitan`
--

CREATE TABLE `penerbitan` (
  `id_penerbitan` int(100) NOT NULL,
  `tajuk_penerbitan` varchar(250) DEFAULT NULL,
  `no_siri` varchar(20) DEFAULT NULL,
  `jenis_penerbitan` int(3) DEFAULT NULL,
  `keterangan` text,
  `tarikh_kuatkuasa` date DEFAULT NULL,
  `tkh_kemaskini` date DEFAULT NULL,
  `kemaskini_oleh` int(3) DEFAULT NULL,
  `path` varchar(250) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penerbitan`
--

INSERT INTO `penerbitan` (`id_penerbitan`, `tajuk_penerbitan`, `no_siri`, `jenis_penerbitan`, `keterangan`, `tarikh_kuatkuasa`, `tkh_kemaskini`, `kemaskini_oleh`, `path`, `updated_at`, `created_at`) VALUES
(4, 'KPN PKPD SOP Pengurusan Pengebumian Selain Orang Islam', NULL, 1, NULL, '2021-05-31', '2021-06-27', 1, 'uploads\\penerbitan\\pT2eVMcdOH_KPN PKPD SOP Pengurusan Pengebumian Selain Orang Islam Kemaskini 31 Mei 2021.pdf', NULL, NULL),
(5, 'KPN  PKP SOP Pembukaan RISI', NULL, 1, NULL, '2021-05-31', '2021-06-27', 1, 'uploads\\penerbitan\\qUMIzG1LET_KPN PKP SOP Pengurusan Pengebumian Selain Orang Islam 31 Mei 2021.pdf', NULL, NULL),
(6, '25 MEI 2021 -PKPD- SOP PEMBUKAAN RIBI DALAM TEMPOH PKPD', NULL, 1, NULL, '2021-05-25', '2021-06-27', 1, 'uploads\\penerbitan\\tHKjrbEzwE_25 MEI 2021 -PKPD- SOP PEMBUKAAN RIBI DALAM TEMPOH PKPD.pdf', NULL, NULL),
(7, 'KPN  PKP SOP Pembukaan RISI Kemaskini 31 Mei 2021', NULL, 1, NULL, '2021-05-31', '2021-06-27', 1, 'uploads\\penerbitan\\MhgqLnpNGJ_KPN  PKP SOP Pembukaan RISI Kemaskini 31 Mei 2021.pdf', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `penerbitan`
--
ALTER TABLE `penerbitan`
  ADD PRIMARY KEY (`id_penerbitan`),
  ADD KEY `id_jenis_penerbitan` (`jenis_penerbitan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `penerbitan`
--
ALTER TABLE `penerbitan`
  MODIFY `id_penerbitan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
