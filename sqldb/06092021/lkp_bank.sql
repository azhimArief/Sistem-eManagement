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
-- Table structure for table `lkp_bank`
--

CREATE TABLE `lkp_bank` (
  `id_bank` int(3) NOT NULL,
  `nama_bank` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `lkp_bank`
--

INSERT INTO `lkp_bank` (`id_bank`, `nama_bank`) VALUES
(1, 'The Royal Bank of Scotland Berhad '),
(2, ' Affin Investment Bank Berhad '),
(3, ' Affin Bank Berhad 3'),
(4, ' Alliance Investment Bank Berhad 3'),
(5, ' Alliance Bank Malaysia Berhad 3'),
(6, ' AmInvestment Bank Berhad 4'),
(7, ' AmBank (M) Berhad 4'),
(8, ' Aseambankers Malaysia Berhad 5'),
(9, ' Bangkok Bank Berhad 5'),
(10, ' CIMB Investment Bank Berhad 6'),
(11, ' CIMB Bank Berhad 6'),
(12, ' Hwang-DBS Investment Bank Berhad 7'),
(13, ' Bank of America Malaysia Berhad 7'),
(14, ' KAF Investment Bank Berhad 8'),
(15, ' Bank of China (Malaysia) Berhad 8'),
(16, ' Kenanga Investment Bank Berhad 9'),
(17, ' Bank of Tokyo-Mitsubishi UFJ (Malaysia) Berhad 9'),
(18, ' MIDF Amanah Investment Bank Berhad 10'),
(19, ' Citibank Berhad 10'),
(20, ' MIMB Investment Bank Berhad 11'),
(21, ' Deutsche Bank (Malaysia) Berhad 11'),
(22, ' OSK Investment Bank Berhad 12'),
(23, ' EON Bank Berhad 12'),
(24, ' Public Investment Bank Berhad 13'),
(25, ' Hong Leong Bank Berhad 13'),
(26, ' RHB Investment Bank Berhad 14'),
(27, ' HSBC Bank Malaysia Berhad 14'),
(28, ' Southern Investment Bank Berhad 15'),
(29, ' J.P.Morgan Chase Bank Berhad 15'),
(30, ' ECM Libra Investment Bank Berhad 16'),
(31, ' Malayan Banking Berhad 17'),
(32, ' OCBC Bank (Malaysia) Berhad 18'),
(33, ' Public Bank Berhad 19'),
(34, ' RHB Bank Berhad 20'),
(35, ' Standard Chartered Bank Malaysia Berhad 21'),
(36, ' The Bank of Nova Scotia Berhad 22'),
(37, ' United Overseas Bank (Malaysia) Berhad 23'),
(38, ' Affin Islamic Bank Berhad 24'),
(39, ' Al Rajhi Banking & Investment Corporation (Malaysia) Berhad 25'),
(40, ' AmIslamic Bank Berhad 26'),
(41, ' Asian Finance Bank Berhad 27'),
(42, ' Bank Islam Malaysia Berhad 28'),
(43, ' Bank Muamalat Malaysia Berhad 29'),
(44, ' CIMB Islamic Bank Berhad 30'),
(45, ' EONCAP Islamic Bank Berhad 31'),
(46, ' Hong Leong Islamic Bank Berhad 32'),
(47, ' Kuwait Finance House (Malaysia) Berhad 33'),
(48, ' RHB ISLAMIC Bank Berhad 34'),
(49, ' Maybank Islamic Berhad 35'),
(50, ' Alliance Islamic Bank Berhad 36'),
(51, ' HSBC Amanah Malaysia Berhad 37'),
(52, ' Standard Chartered Saadiq Berhad 38'),
(53, ' Public Islamic Bank Berhad 39'),
(54, ' OCBC Al-Amin Bank Berhad');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
