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
-- Table structure for table `lkp_daerah`
--

CREATE TABLE `lkp_daerah` (
  `id_daerah` int(3) DEFAULT NULL,
  `daerah` varchar(250) DEFAULT NULL,
  `id` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lkp_daerah`
--

INSERT INTO `lkp_daerah` (`id_daerah`, `daerah`, `id`) VALUES
(1, 'Padang Besar', 9),
(2, 'Kangar dan Arau', 9),
(3, 'Bandar Baharu', 2),
(4, 'Kuala Muda', 2),
(5, 'Kubang Pasu', 2),
(6, 'Kulim', 2),
(7, 'Langkawi', 2),
(8, 'Padang Terap', 2),
(9, 'Pendang', 2),
(10, 'Pokok Sena', 2),
(11, 'Sik', 2),
(12, 'Yan', 2),
(13, 'Baling', 2),
(14, 'Kota Setar', 2),
(15, 'Barat Daya', 7),
(16, 'Seberang Perai Selatan', 7),
(17, 'Seberang Perai Tengah', 7),
(18, 'Seberang Perai Utara', 7),
(19, 'Timor Laut', 7),
(20, 'Batang Padang', 8),
(21, 'Manjung', 8),
(22, 'Kampar', 8),
(23, 'Kinta', 8),
(24, 'Kerian', 8),
(25, 'Kuala Kangsar', 8),
(26, 'Larut & Matang', 8),
(27, 'Hilir Perak', 8),
(28, 'Hulu Perak', 8),
(29, 'Selama', 8),
(30, 'Perak Tengah', 8),
(31, 'Bagan Datuk', 8),
(32, 'Klang', 10),
(33, 'Kuala Langat', 10),
(34, 'Kuala Selangor', 10),
(35, 'Sabak Bernam', 10),
(36, 'Hulu Langat', 10),
(37, 'Hulu Selangor', 10),
(38, 'Petaling', 10),
(39, 'Gombak', 10),
(40, 'Sepang', 10),
(41, 'Bentong', 6),
(42, 'Cameron Highlands', 6),
(43, 'Jerantut', 6),
(44, 'Kuantan', 6),
(45, 'Lipis', 6),
(46, 'Pekan', 6),
(47, 'Raub', 6),
(48, 'Temerloh', 6),
(49, 'Rompin', 6),
(50, 'Maran', 6),
(51, 'Bera', 6),
(52, 'Bachok', 3),
(53, 'Kota Bharu', 3),
(54, 'Machang', 3),
(55, 'Pasir Mas', 3),
(56, 'Pasir Puteh', 3),
(57, 'Tanah Merah', 3),
(58, 'Tumpat', 3),
(59, 'Gua Musang', 3),
(60, 'Kuala Krai', 3),
(61, 'Jeli', 3),
(62, 'Besut', 11),
(63, 'Dungun', 11),
(64, 'Kemaman', 11),
(65, 'Kuala Terengganu', 11),
(66, 'Hulu Terengganu', 11),
(67, 'Marang', 11),
(68, 'Setiu', 11),
(69, 'Jelebu', 5),
(70, 'Kuala Pilah', 5),
(71, 'Port Dickson', 5),
(72, 'Rembau', 5),
(73, 'Seremban', 5),
(74, 'Tampin', 5),
(75, 'Jempol', 5),
(76, 'Melaka Tengah', 4),
(77, 'Jasin', 4),
(78, 'Alor Gajah', 4),
(79, 'Batu Pahat', 1),
(80, 'Muar ', 1),
(81, 'Pontian', 1),
(82, 'Kluang', 1),
(83, 'Johor Bahru', 1),
(84, 'Segamat', 1),
(85, 'Mersing', 1),
(86, 'Kota Tinggi', 1),
(87, 'Ledang', 1),
(88, 'Tangkak (dahulu Ledang)', 1),
(89, 'Kulai Jaya', 1),
(90, 'Kudat', 12),
(91, 'Pitas', 12),
(92, 'Kota Merudu', 12),
(93, 'Kota Belud', 12),
(94, 'Ranau', 12),
(95, 'Tuaran', 12),
(96, 'Kota Kinabalu', 12),
(97, 'Penampang', 12),
(98, 'Putatan', 12),
(99, 'Papar', 12),
(100, 'Kuala Penyu', 12),
(101, 'Beaufort', 12),
(102, 'Sipitang', 12),
(103, 'Keningau', 12),
(104, 'Tenom', 12),
(105, 'Pesiangan', 12),
(106, 'Tambunan', 12),
(107, 'Labuk & Sugut', 12),
(108, 'Telupid', 12),
(109, 'Tongod', 12),
(110, 'Kinabatangan', 12),
(111, 'Sandakan', 12),
(112, 'Lahad Datu', 12),
(113, 'Kunak', 12),
(114, 'Tawau', 12),
(115, 'Semporna', 12),
(116, 'Lawas', 13),
(117, 'Limbang ', 13),
(118, 'Marudi', 13),
(119, 'Miri', 13),
(120, 'Bintulu', 13),
(121, 'Tatau', 13),
(122, 'Kapit', 13),
(123, 'Belaga', 13),
(124, 'Song', 13),
(125, 'Selangau', 13),
(126, 'Kanowit', 13),
(127, 'Sibu', 13),
(128, 'Mukah', 13),
(129, 'Dalat', 13),
(130, 'Matu', 13),
(131, 'Daro', 13),
(132, 'Sarikei', 13),
(133, 'Maradong', 13),
(134, 'Julau', 13),
(135, 'Pakan', 13),
(136, 'Betong', 13),
(137, 'Saratok', 13),
(138, 'Lubok Antu', 13),
(139, 'Sri Aman', 13),
(140, 'Asa Jaya', 13),
(141, 'Samarahan', 13),
(142, 'Simunjan', 13),
(143, 'Serian', 13),
(144, 'Kuching', 13),
(145, 'Bau', 13),
(146, 'Lundu', 13),
(147, 'Putrajaya', 16),
(148, 'Nabawan', 12),
(149, 'Kuala Nerus', 11),
(148, 'Labuan', 15),
(149, 'Mualim', 8);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
