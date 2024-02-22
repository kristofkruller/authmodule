-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:9115
-- Generation Time: Feb 22, 2024 at 09:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auth`
--
CREATE DATABASE IF NOT EXISTS `auth` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `auth`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `token`, `created_at`, `updated_at`) VALUES
(14, 'varju', 'varju@varju.hu', '$2y$10$jitKfDwfA91jpZF9ZpTJMeV8D4c1pueesaSXux3vmwhQIc7S17Nny', NULL, '2024-02-22 09:18:36', '2024-02-22 09:18:36'),
(17, 'kacsa', 'kacsa@kacsa.hu', '$2y$10$2AAa05TZREnvptmC.zDDmO0IwkSlGBHYmKN/sMMtJTsaIGkndeXsu', NULL, '2024-02-22 09:53:29', '2024-02-22 09:53:29'),
(19, 'cica', 'cica@cica.com', '$2y$10$ltHINjFK1c77CgbSt78/8Om2I95jaQpsOPgLz8DtgwLIOVTFM4d4K', NULL, '2024-02-22 17:51:04', '2024-02-22 17:51:04'),
(20, 'tacsi', 'tacsi@tacsi.cz', '$2y$10$E6K4fJQ9M6qsxsdVVj.LnOZPzVQsKkhs9OtFpJ4Xjsod0rbAsG2K6', NULL, '2024-02-22 17:51:20', '2024-02-22 17:51:20'),
(21, 'süni', 'suni@suni.hu', '$2y$10$gN5aDMmrPOIbH55bjs23tO1D0LetGih4z31hWtA4tS1rhaPRUEOU6', NULL, '2024-02-22 17:51:49', '2024-02-22 17:51:49'),
(22, 'csacsi', 'csacsi@csacsi.hu', '$2y$10$DHKmZZ2jI4DHEnrEUsfD1.f.KbcPZ5C07.ztKcgM324xtHlsvZ462', NULL, '2024-02-22 17:52:12', '2024-02-22 17:52:12'),
(23, 'admin', 'admin@admin.hu', '$2y$10$kM3ckKu4XBUy1.DLAibYqOKW9by14GBkV.SCnTZ1VwC4slr7HcDru', NULL, '2024-02-22 17:52:27', '2024-02-22 17:52:27');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
