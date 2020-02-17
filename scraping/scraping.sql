-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2020 at 12:57 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scraping`
--
CREATE DATABASE IF NOT EXISTS `scraping` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `scraping`;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `country_id`, `name`, `last_updated`) VALUES
(1, 1, 'A Coruña', '2020-02-16 16:55:25'),
(2, 2, 'Aachen', '2020-02-16 16:55:25'),
(3, 3, 'Aalborg', '2020-02-16 16:55:25'),
(4, 3, 'Aarhus', '2020-02-16 16:55:25'),
(5, 4, 'Aba', '2020-02-16 16:55:25'),
(6, 5, 'Babol', '2020-02-16 16:55:32'),
(7, 6, 'Babruysk', '2020-02-16 16:55:32'),
(8, 7, 'Bacabal', '2020-02-16 16:55:32'),
(9, 8, 'Bacău', '2020-02-16 16:55:32'),
(10, 9, 'Bacolod', '2020-02-16 16:55:32'),
(11, 9, 'Cabanatuan', '2020-02-16 16:55:40'),
(12, 10, 'Cabimas', '2020-02-16 16:55:40'),
(13, 7, 'Cabo de Santo Agostinho', '2020-02-16 16:55:40'),
(14, 7, 'Cabo Frio', '2020-02-16 16:55:40'),
(15, 9, 'Cabuyao', '2020-02-16 16:55:40'),
(16, 11, 'Da Lat', '2020-02-16 17:11:32'),
(17, 11, 'Da Nang', '2020-02-16 17:11:32'),
(18, 12, 'Dabgram', '2020-02-16 17:11:32'),
(19, 13, 'Dąbrowa Górnicza', '2020-02-16 17:11:32'),
(20, 14, 'Dadu', '2020-02-16 17:11:32'),
(21, 15, 'East Jerusalem', '2020-02-16 17:11:38'),
(22, 16, 'Eastbourne', '2020-02-16 17:11:38'),
(23, 17, 'Ebetsu', '2020-02-16 17:11:38'),
(24, 17, 'Ebina', '2020-02-16 17:11:38'),
(25, 18, 'Ecatepec', '2020-02-16 17:11:38'),
(26, 19, 'Facatativá', '2020-02-16 17:11:45'),
(27, 20, 'Fairfield', '2020-02-16 17:11:45'),
(28, 14, 'Faisalabad', '2020-02-16 17:11:45'),
(29, 12, 'Faizabad', '2020-02-16 17:11:45'),
(30, 21, 'Fallujah', '2020-02-16 17:11:45');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `last_updated`) VALUES
(1, 'Spain', '2020-02-16 16:50:11'),
(2, 'Germany', '2020-02-16 16:50:11'),
(3, 'Denmark', '2020-02-16 16:50:11'),
(4, 'Nigeria', '2020-02-16 16:50:11'),
(5, 'Iran', '2020-02-16 16:50:18'),
(6, 'Belarus', '2020-02-16 16:50:18'),
(7, 'Brazil', '2020-02-16 16:50:18'),
(8, 'Romania', '2020-02-16 16:50:18'),
(9, 'Philippines', '2020-02-16 16:50:18'),
(10, 'Venezuela', '2020-02-16 16:50:28'),
(11, 'Vietnam', '2020-02-16 17:11:32'),
(12, 'India', '2020-02-16 17:11:32'),
(13, 'Poland', '2020-02-16 17:11:32'),
(14, 'Pakistan', '2020-02-16 17:11:32'),
(15, 'State of Palestine', '2020-02-16 17:11:38'),
(16, 'United Kingdom', '2020-02-16 17:11:38'),
(17, 'Japan', '2020-02-16 17:11:38'),
(18, 'Mexico', '2020-02-16 17:11:38'),
(19, 'Colombia', '2020-02-16 17:11:45'),
(20, 'United States', '2020-02-16 17:11:45'),
(21, 'Iraq', '2020-02-16 17:11:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
