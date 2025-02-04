-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 06, 2021 at 02:17 PM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `id_pengguna` int(12) DEFAULT NULL,
  `mykad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bahagian` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `negeri` int(3) DEFAULT NULL,
  `email` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jawatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_akaun` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_access` int(2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_pengguna`, `mykad`, `nama`, `bahagian`, `negeri`, `email`, `jawatan`, `password`, `status_akaun`, `id_access`, `created_at`, `updated_at`) VALUES
(1, NULL, '770425026152', 'Chempawan Binti Saidina Othman', 'Bahagian Pengurusan Maklumat', NULL, NULL, 'Pegawai Teknologi Maklumat', '$2y$10$5mGVipStLZQVvO2CT3QWYO3uQ0OEMwOQdlHJtT6ZHYL/8K1zp2DxK', '4', 1, '2021-06-22 21:12:39', '2021-07-13 19:47:26'),
(2, NULL, '920106146756', 'Nur Miftah Farihah Binti Azman', 'Bahagian Pengurusan Maklumat', NULL, 'miftahfarihah@perpaduan.gov.my', 'Pegawai Teknologi Maklumat', '$2y$10$7NgI1Pu/AzTyeCBnxA88U.DsNK70u9KmVB1KvylkFPAdNTClluqrC', '4', 3, '2021-07-03 18:31:38', '2021-07-04 19:16:21'),
(3, NULL, '860923566388', 'Nor Azirah Binti Mohd Azhar', 'Bahagian Pengurusan Maklumat', NULL, NULL, 'Penolong Pegawai Teknologi Maklumat', '$2y$10$Pyezb5CJHvWnWGOj8Nd/2eKDdCBquGq94wIfq4P3LAeYpD5.ljBsm', '4', 2, '2021-07-05 00:13:46', '2021-07-13 19:45:02'),
(4, NULL, '111111111111', 'Test Johor', 'JPNIN Negeri Johor', 1, NULL, 'Pegawai Pembangunan Masyarakat', '$2y$10$cdEl8Z7qbM./z54JTjQeAe8HEtm0N0GtRG4mT8NpwUcHKVOi6VUie', '4', 2, '2021-07-05 08:48:17', '2021-07-05 08:48:17'),
(5, NULL, '840617025219', 'Muhammad Shafik Bin Abdul Halim', 'Bahagian Pengurusan Maklumat', NULL, NULL, 'Penolong Pegawai Teknologi Maklumat', '$2y$10$4z4Pro0EnBd3D71KuWi8iOidUY86poDL.y9NkMnJqJRw2NCYY9Tv.', '4', 5, '2021-07-25 11:18:07', '2021-07-25 11:18:07'),
(6, NULL, '690427085500', 'Hamidah Binti Ismail', 'Bahagian Pengurusan Maklumat', NULL, NULL, 'Setiausaha Bahagian', '$2y$10$x09Tv/URErv.heft0HCGGO9RNixm4T32ju1zrTkGIedqYj0pcj42u', '4', 4, '2021-07-25 11:19:22', '2021-07-25 11:19:22'),
(7, NULL, '821213125332', 'Rina Binti Ab. Harun', 'Bahagian Perhubungan Masyarakat', 14, 'rinaharun@perpaduan.gov.my', 'Ketua Penolong Setiausaha', '$2y$10$yhRiQIdwuXURL6kVL1QzJe0yFWWE7k/e89LudOSz8udtyMOvSiBjS', '4', 2, '2021-09-02 17:33:04', '2021-09-02 17:33:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
