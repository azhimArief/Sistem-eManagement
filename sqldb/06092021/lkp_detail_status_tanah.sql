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
-- Table structure for table `lkp_detail_status_tanah`
--

CREATE TABLE `lkp_detail_status_tanah` (
  `id_detail_tanah` int(1) NOT NULL,
  `keterangan` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `id_jenis_tanah` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `lkp_detail_status_tanah`
--

INSERT INTO `lkp_detail_status_tanah` (`id_detail_tanah`, `keterangan`, `id_jenis_tanah`) VALUES
(1, 'Ada Hak Milik/Geran ', 1),
(2, 'Daftar Atas Nama Individu', 1),
(3, 'Seksyen 62', 2),
(4, 'Kerajaan Mewartakan untuk Rumah Ibadat', 2),
(5, 'Tanah Milik Kerajaan/Pendudukan Tidak Sah', 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
