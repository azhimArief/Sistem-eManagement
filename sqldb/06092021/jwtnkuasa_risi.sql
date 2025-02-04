-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 06, 2021 at 02:12 PM
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
-- Table structure for table `jwtnkuasa_risi`
--

CREATE TABLE `jwtnkuasa_risi` (
  `id_jwtankuasa_risi` int(10) NOT NULL,
  `nama` varchar(250) DEFAULT NULL,
  `emel` varchar(250) DEFAULT NULL,
  `no_tel` varchar(250) DEFAULT NULL,
  `id_jawatan` int(10) DEFAULT NULL,
  `jawatan` varchar(250) DEFAULT NULL,
  `id_risi` int(10) DEFAULT NULL,
  `tkh_lantikan` date DEFAULT NULL,
  `id_status` int(2) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `created_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jwtnkuasa_risi`
--

INSERT INTO `jwtnkuasa_risi` (`id_jwtankuasa_risi`, `nama`, `emel`, `no_tel`, `id_jawatan`, `jawatan`, `id_risi`, `tkh_lantikan`, `id_status`, `updated_date`, `created_date`) VALUES
(23696, '123', '123', '123', 1, NULL, 12585, '2021-08-31', 4, '2021-08-29 20:07:33', '2021-08-29 20:07:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jwtnkuasa_risi`
--
ALTER TABLE `jwtnkuasa_risi`
  ADD PRIMARY KEY (`id_jwtankuasa_risi`),
  ADD KEY `id_jawatan` (`id_jawatan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jwtnkuasa_risi`
--
ALTER TABLE `jwtnkuasa_risi`
  MODIFY `id_jwtankuasa_risi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23697;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
