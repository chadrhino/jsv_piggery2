-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 08:46 AM
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
-- Database: `pig`
--

-- --------------------------------------------------------

--
-- Table structure for table `pigs`
--

CREATE TABLE `pigs` (
  `id` int(11) NOT NULL,
  `pigno` varchar(255) NOT NULL,
  `breed_id` int(11) NOT NULL,
  `weight` varchar(10) NOT NULL,
  `img` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `arrived` varchar(10) NOT NULL,
  `remark` text NOT NULL,
  `description` varchar(250) NOT NULL,
  `health_status` varchar(50) NOT NULL,
  `classification_id` int(11) NOT NULL,
  `feed_id` int(11) NOT NULL,
  `vitamins_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1=active,2=quarantined,3=sold\r\n',
  `type` varchar(255) DEFAULT NULL,
  `month` varchar(200) DEFAULT NULL,
  `users` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pigs`
--

INSERT INTO `pigs` (`id`, `pigno`, `breed_id`, `weight`, `img`, `gender`, `arrived`, `remark`, `description`, `health_status`, `classification_id`, `feed_id`, `vitamins_id`, `status`, `type`, `month`, `users`) VALUES
(2, 'pig-fms-5174', 4, '35', 'uploadfolder/Screenshot (1).png', 'male', '2024-11-15', '', 'jhkahfkjhaktry', 'active', 6, 0, 1, 1, NULL, '0000-00-00', NULL),
(3, 'pig-fms-8819', 1, '20', 'uploadfolder/Screenshot (1).png', 'female', '2024-11-15', '', 'try', 'active', 1, 2, 1, 2, 'sow', '0000-00-00', NULL),
(4, 'pig-fms-1160', 3, '34', 'uploadfolder/pig.png', 'male', '2024-11-20', '', 'hjakjgkhia', 'active', 3, 3, 1, 1, NULL, '1', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pigs`
--
ALTER TABLE `pigs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pigs`
--
ALTER TABLE `pigs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
