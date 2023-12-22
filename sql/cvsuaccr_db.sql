-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2023 at 06:06 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cvsuaccr_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `file_id` varchar(200) NOT NULL,
  `file_viewLink` varchar(200) NOT NULL,
  `file_downloadLink` varchar(200) NOT NULL,
  `file_owner` varchar(200) NOT NULL,
  `file_directory` varchar(100) NOT NULL,
  `file_area` varchar(50) NOT NULL,
  `file_tags` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `owner_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `file_name`, `file_size`, `file_type`, `file_id`, `file_viewLink`, `file_downloadLink`, `file_owner`, `file_directory`, `file_area`, `file_tags`, `upload_date`, `owner_email`) VALUES
(86, 'Agravante-checklist.pdf', 115256, 'application/pdf', '1toQ5eTOftLPQ19wS3Y5calfN15Bha_k4', 'https://drive.google.com/file/d/1toQ5eTOftLPQ19wS3Y5calfN15Bha_k4/view?usp=drivesdk', 'https://drive.google.com/uc?id=1toQ5eTOftLPQ19wS3Y5calfN15Bha_k4&export=download', 'William Dave Agravante', 'CED', 'Area 8', '', '2023-12-19 17:30:16', 'williamdave.agravante@cvsu.edu.ph'),
(87, 'Agravante-checklist (1).pdf', 115256, 'application/pdf', '19PZRfe0Svo90qQ7-aRZG0MC2OAkivohG', 'https://drive.google.com/file/d/19PZRfe0Svo90qQ7-aRZG0MC2OAkivohG/view?usp=drivesdk', 'https://drive.google.com/uc?id=19PZRfe0Svo90qQ7-aRZG0MC2OAkivohG&export=download', 'William Dave Agravante', 'CAFENR', 'Area 3', '', '2023-12-20 15:51:12', 'williamdave.agravante@cvsu.edu.ph');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_level` int(11) NOT NULL,
  `college` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `activity` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `email`, `user_level`, `college`, `time`, `activity`) VALUES
(3, 'williamdave.agravante@cvsu.edu.ph', 1, 'CAS', '2023-12-17 16:46:21', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(4, 'williamdave.agravante@cvsu.edu.ph', 1, 'Unknown', '2023-12-17 16:48:18', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(5, 'williamdave.agravante@cvsu.edu.ph', 1, 'CAS', '2023-12-17 16:48:40', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(6, 'williamdave.agravante@cvsu.edu.ph', 1, 'Unknown', '2023-12-17 16:49:56', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(7, 'williamdave.agravante@cvsu.edu.ph', 1, 'CAS', '2023-12-17 16:54:46', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(8, 'williamdave.agravante@cvsu.edu.ph', 1, 'CAS', '2023-12-17 16:55:07', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(9, 'williamdave.agravante@cvsu.edu.ph', 1, 'CAS', '2023-12-17 17:00:58', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(10, 'aeioudreyahlenn.bingcan@cvsu.edu.ph', 0, '', '2023-12-17 17:05:51', 'aeioudreyahlenn.bingcan@cvsu.edu.ph has logged into the system'),
(11, 'aeioudreyahlenn.bingcan@cvsu.edu.ph', 3, 'CEMDS', '2023-12-17 17:07:13', 'aeioudreyahlenn.bingcan@cvsu.edu.ph has logged into the system'),
(12, 'aeioudreyahlenn.bingcan@cvsu.edu.ph', 3, 'CEMDS', '2023-12-17 17:10:14', 'aeioudreyahlenn.bingcan@cvsu.edu.ph has logged into the system'),
(13, 'aeioudreyahlenn.bingcan@cvsu.edu.ph', 3, 'CEMDS', '2023-12-17 17:12:32', 'aeioudreyahlenn.bingcan@cvsu.edu.ph has logged into the system'),
(14, 'williamdave.agravante@cvsu.edu.ph', 1, 'CAS', '2023-12-17 17:46:51', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(15, 'williamdave.agravante@cvsu.edu.ph', 1, 'CAS', '2023-12-18 03:38:47', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(16, 'williamdave.agravante@cvsu.edu.ph', 1, 'CAS', '2023-12-18 13:41:43', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(17, 'williamdave.agravante@cvsu.edu.ph', 1, 'CAS', '2023-12-19 01:00:22', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(18, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-19 01:02:49', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(19, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 01:03:12', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(20, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 01:08:42', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(21, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 01:10:09', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(22, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 14:10:46', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(23, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 15:12:20', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(24, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 15:14:57', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: ABSTRACT.pdf'),
(25, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 15:19:08', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: TLE-TechDraft-Exploratory-4 (1).pdf at CON'),
(26, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 15:21:18', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: Agravante_Graduation-Application.pdf at CVMBS'),
(27, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 15:22:25', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: Inventory_Management_System_.pdf at CSPEAR'),
(28, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 15:48:23', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: Agravante-checklist.pdf at CSPEAR'),
(29, 'williamdave.agravante@cvsu.edu.ph', 2, 'CSPEAR', '2023-12-19 15:49:15', 'File \'Agravante-checklist.pdf\' owned by \'William Dave Agravante\' in \'CSPEAR\' deleted by \'williamdave.agravante@cvsu.edu.ph\''),
(30, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 16:01:37', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(31, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 16:02:09', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(32, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 16:03:36', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(33, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-19 16:41:57', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(34, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-19 17:00:56', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(35, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 17:01:37', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(36, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2023-12-19 17:03:56', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(37, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-19 17:04:17', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(38, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-19 17:04:36', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(39, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-19 17:05:36', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(40, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-19 17:30:16', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: Agravante-checklist.pdf at CED'),
(41, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-19 22:33:27', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(42, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-20 15:42:27', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(43, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-20 15:43:55', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(44, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-20 15:44:26', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(45, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-20 15:46:12', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(46, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-20 15:51:13', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: Agravante-checklist (1).pdf at CAFENR'),
(47, 'williamdave.agravante@cvsu.edu.ph', 1, '', '2023-12-20 16:00:17', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(48, 'williamdave.agravante@cvsu.edu.ph', 1, 'CAFENR', '2023-12-20 16:01:13', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(49, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2023-12-20 16:01:45', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(50, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2023-12-20 16:34:02', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(51, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2023-12-20 16:36:40', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(52, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2023-12-20 16:42:47', 'williamdave.agravante@cvsu.edu.ph has logged into the system');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `oauth_uid` varchar(50) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `user_level` int(3) NOT NULL,
  `local` varchar(20) DEFAULT NULL,
  `college` varchar(50) NOT NULL,
  `active_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_uid`, `first_name`, `last_name`, `gender`, `birthdate`, `email`, `profile_pic`, `user_level`, `local`, `college`, `active_status`) VALUES
(2, '102958130049128401532', 'LAICA DENNISE', 'MIRANDA', '', '0000-00-00', 'laicadennise.miranda@cvsu.edu.ph', '', 0, 'https://lh3.googleus', '', 'offline'),
(3, '101333192880725710175', 'Laica Dennise', 'Miranda', 'Female', '2001-08-26', 'laicadennise.miranda@gmail.com', '', 1, 'https://lh3.googleus', 'CEIT', 'offline'),
(4, '111409479852703719423', 'Aeiou Drey Ahlenn', 'Bingcan', '', '0000-00-00', 'aeioudreyahlenn.bingcan@cvsu.edu.ph', '', 3, 'https://lh3.googleus', 'CEMDS', 'online'),
(5, '117732174434037950678', 'William Dave', 'Agravante', '', '2000-03-06', 'williamdave.agravante@cvsu.edu.ph', '', 3, 'https://lh3.googleus', 'CAFENR', 'online');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_owner` (`file_owner`) USING BTREE,
  ADD KEY `file_id` (`file_id`) USING BTREE;

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `oauth_uid` (`oauth_uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
