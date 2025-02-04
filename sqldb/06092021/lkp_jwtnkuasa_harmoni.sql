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
-- Table structure for table `lkp_jwtnkuasa_harmoni`
--

CREATE TABLE `lkp_jwtnkuasa_harmoni` (
  `id_jwtnkuasa_harmoni` int(3) NOT NULL,
  `nama_harmoni` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lkp_jwtnkuasa_harmoni`
--

INSERT INTO `lkp_jwtnkuasa_harmoni` (`id_jwtnkuasa_harmoni`, `nama_harmoni`) VALUES
(1, 'Encik Richard Lon'),
(2, 'Venerable Jue Cheng'),
(3, 'Cik Loh Pai Ling'),
(4, 'Venerable Sing Kan'),
(5, 'Rev. Dr. Eu Hong Seng'),
(6, 'Encik Jason Leong'),
(7, 'he Most Rev. Archbishop Julian Leow Beng Kim'),
(8, 'YBhg. Tan Sri Datuk R. Nadarajah'),
(9, 'Ybhg. Datuk RS Mohan Shan'),
(10, 'Sardar Jagir Singh a/l Arjan Singh'),
(11, 'Daozhang Dr. Yam Kah Kean'),
(12, 'Daozhang Tan Hoe Chieow'),
(13, 'Encik Vijaya Segaran Vadivelloo ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lkp_jwtnkuasa_harmoni`
--
ALTER TABLE `lkp_jwtnkuasa_harmoni`
  ADD PRIMARY KEY (`id_jwtnkuasa_harmoni`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lkp_jwtnkuasa_harmoni`
--
ALTER TABLE `lkp_jwtnkuasa_harmoni`
  MODIFY `id_jwtnkuasa_harmoni` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
