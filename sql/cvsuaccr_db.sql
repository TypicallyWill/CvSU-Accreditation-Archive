-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2024 at 12:48 PM
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
-- Table structure for table `access_request`
--

CREATE TABLE `access_request` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `user_level` varchar(5) DEFAULT NULL,
  `college` varchar(80) DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `owner_email` varchar(255) NOT NULL,
  `file_directory` varchar(100) NOT NULL,
  `file_course` varchar(255) NOT NULL,
  `file_area` varchar(50) NOT NULL,
  `file_tags` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `valid_until` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `file_name`, `file_size`, `file_type`, `file_id`, `file_viewLink`, `file_downloadLink`, `file_owner`, `owner_email`, `file_directory`, `file_course`, `file_area`, `file_tags`, `upload_date`, `valid_until`) VALUES
(1, 'Test File.pdf', 31443, 'application/pdf', '12Bw8RZSBeGgaK-oNxYju2hsrZeQfqs20', 'https://drive.google.com/file/d/12Bw8RZSBeGgaK-oNxYju2hsrZeQfqs20/view?usp=drivesdk', 'https://drive.google.com/uc?id=12Bw8RZSBeGgaK-oNxYju2hsrZeQfqs20&export=download', 'Laica Dennise Miranda', 'laicadennise.miranda@gmail.com', 'CAFENR', 'Bachelor of Science in Agriculture', 'Area 1', 'test', '2024-01-06 06:59:44', '2024-01-13'),
(2, 'TECHNICAL-EVALUATIONproper.docx', 93424, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', '1ER5zM99WIfO2DjhpGaQujNsgxVYGAYR5', 'https://docs.google.com/document/d/1ER5zM99WIfO2DjhpGaQujNsgxVYGAYR5/edit?usp=drivesdk&ouid=101333192880725710175&rtpof=true&sd=true', 'https://drive.google.com/uc?id=1ER5zM99WIfO2DjhpGaQujNsgxVYGAYR5&export=download', 'Laica Dennise Miranda', 'laicadennise.miranda@gmail.com', 'General', '', 'Area 4', '', '2024-01-06 07:01:18', '2024-01-13'),
(5, 'Test File for College of Medicine.docx', 12091, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', '1xkAtQYSOkjOeZvgu5Z39UPKIEFrp5ikb', 'https://docs.google.com/document/d/1xkAtQYSOkjOeZvgu5Z39UPKIEFrp5ikb/edit?usp=drivesdk&ouid=102958130049128401532&rtpof=true&sd=true', 'https://drive.google.com/uc?id=1xkAtQYSOkjOeZvgu5Z39UPKIEFrp5ikb&export=download', 'LAICA DENNISE MIRANDA', 'laicadennise.miranda@cvsu.edu.ph', 'College of Medicine', '', 'Area 9', 'test', '2024-01-06 07:27:10', '2024-01-25'),
(6, 'Revision-Sheet.docx', 31290, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', '1DTuK1j4k-pLo-N04en9_nOPUq8UBd9x1', 'https://docs.google.com/document/d/1DTuK1j4k-pLo-N04en9_nOPUq8UBd9x1/edit?usp=drivesdk&ouid=102958130049128401532&rtpof=true&sd=true', 'https://drive.google.com/uc?id=1DTuK1j4k-pLo-N04en9_nOPUq8UBd9x1&export=download', 'LAICA DENNISE MIRANDA', 'laicadennise.miranda@cvsu.edu.ph', 'CEIT', 'Bachelor of Science in Computer Science', 'Area 4', '', '2024-01-06 07:28:02', '2024-01-01'),
(7, 'Test File for CAS.pdf', 36252, 'application/pdf', '1z0HqfwSwM_qepLGZEC5bO15B8kXD2k-n', 'https://drive.google.com/file/d/1z0HqfwSwM_qepLGZEC5bO15B8kXD2k-n/view?usp=drivesdk', 'https://drive.google.com/uc?id=1z0HqfwSwM_qepLGZEC5bO15B8kXD2k-n&export=download', 'Laica Dennise Miranda', 'laicadennise.miranda@gmail.com', 'CAS', 'Bachelor of Arts in English', 'Area 2', 'cas', '2024-01-06 07:30:36', '2024-01-18'),
(9, 'Test File for CCJ.pdf', 35405, 'application/pdf', '16vRo3wCMiROKCpHnwaXnt_bA51mWzudH', 'https://drive.google.com/file/d/16vRo3wCMiROKCpHnwaXnt_bA51mWzudH/view?usp=drivesdk', 'https://drive.google.com/uc?id=16vRo3wCMiROKCpHnwaXnt_bA51mWzudH&export=download', 'Laica Dennise Miranda', 'laicadennise.miranda@gmail.com', 'CCJ', 'Bachelor of Science in Criminology', 'Area 6', '', '2024-01-06 07:35:54', '2024-01-11'),
(10, 'Test File for CED.pdf', 35660, 'application/pdf', '1fqm2dPPtLd41v8UQehwtkSPsEIaQjbAj', 'https://drive.google.com/file/d/1fqm2dPPtLd41v8UQehwtkSPsEIaQjbAj/view?usp=drivesdk', 'https://drive.google.com/uc?id=1fqm2dPPtLd41v8UQehwtkSPsEIaQjbAj&export=download', 'Laica Dennise Miranda', 'laicadennise.miranda@gmail.com', 'CED', 'Bachelor of Secondary Education', 'Area 7', '', '2024-01-06 07:45:22', '2024-01-17'),
(13, 'Test File for CEMDS.pdf', 36290, 'application/pdf', '140lQEmMpS_83jfNRlfs2PpxzPMM5CrfH', 'https://drive.google.com/file/d/140lQEmMpS_83jfNRlfs2PpxzPMM5CrfH/view?usp=drivesdk', 'https://drive.google.com/uc?id=140lQEmMpS_83jfNRlfs2PpxzPMM5CrfH&export=download', 'Laica Dennise Miranda', 'laicadennise.miranda@gmail.com', 'CEMDS', 'Bachelor of Science in Development Management', 'Area 2', '', '2024-01-06 07:51:31', '2024-01-11'),
(14, 'Test File for CEIT.png', 5579, 'image/png', '1hXNeksya72IwNk7k1Y014QVEP643bvej', 'https://drive.google.com/file/d/1hXNeksya72IwNk7k1Y014QVEP643bvej/view?usp=drivesdk', 'https://drive.google.com/uc?id=1hXNeksya72IwNk7k1Y014QVEP643bvej&export=download', 'Laica Dennise Miranda', 'laicadennise.miranda@gmail.com', 'CEIT', 'Bachelor of Science in Electrical Engineering', 'Area 1', '', '2024-01-06 07:52:35', '2024-01-16'),
(15, 'Test File for CON.jpg', 14442, 'image/jpeg', '1zCZk-7IyqgYwu0RwYcVcYfXzXecp-sKq', 'https://drive.google.com/file/d/1zCZk-7IyqgYwu0RwYcVcYfXzXecp-sKq/view?usp=drivesdk', 'https://drive.google.com/uc?id=1zCZk-7IyqgYwu0RwYcVcYfXzXecp-sKq&export=download', 'Laica Dennise Miranda', 'laicadennise.miranda@gmail.com', 'CON', 'Bachelor of Science in Medical Technology', 'Area 4', '', '2024-01-06 07:53:11', '2023-10-11'),
(16, 'Test File for CSPEAR.pdf', 37644, 'application/pdf', '18wOr_ykp3SSc-3jZ62e9W5Xjb5Mdndbf', 'https://drive.google.com/file/d/18wOr_ykp3SSc-3jZ62e9W5Xjb5Mdndbf/view?usp=drivesdk', 'https://drive.google.com/uc?id=18wOr_ykp3SSc-3jZ62e9W5Xjb5Mdndbf&export=download', 'Laica Dennise Miranda', 'laicadennise.miranda@gmail.com', 'CSPEAR', 'Bachelor in Sports and Recreational Management', 'Area 2', '', '2024-01-06 07:54:00', '2024-01-18'),
(17, 'Test File for CVMBS.docx', 12059, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', '16ynIrvOnw_vfzQFhrCqp_22awOj-OCjQ', 'https://docs.google.com/document/d/16ynIrvOnw_vfzQFhrCqp_22awOj-OCjQ/edit?usp=drivesdk&ouid=101333192880725710175&rtpof=true&sd=true', 'https://drive.google.com/uc?id=16ynIrvOnw_vfzQFhrCqp_22awOj-OCjQ&export=download', 'Laica Dennise Miranda', 'laicadennise.miranda@gmail.com', 'CVMBS', 'Bachelor of Science in Veterinary Technology', 'Area 8', '', '2024-01-06 07:54:34', '2024-01-14'),
(18, 'Test File for Grad School.pdf', 42217, 'application/pdf', '1Cl0Z3EpEl2mfcDTVyJ3eqaswta6uB8qT', 'https://drive.google.com/file/d/1Cl0Z3EpEl2mfcDTVyJ3eqaswta6uB8qT/view?usp=drivesdk', 'https://drive.google.com/uc?id=1Cl0Z3EpEl2mfcDTVyJ3eqaswta6uB8qT&export=download', 'Laica Dennise Miranda', 'laicadennise.miranda@gmail.com', 'Graduate School and Open Learning College', 'Master of Professional Studies', 'Area 1', '', '2024-01-06 07:55:18', '2028-06-22'),
(21, 'jane.docx', 17436, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', '17eNjHI0Xbu4AYO8lLjwo3AkHyigsYzlV', 'https://docs.google.com/document/d/17eNjHI0Xbu4AYO8lLjwo3AkHyigsYzlV/edit?usp=drivesdk&ouid=117732174434037950678&rtpof=true&sd=true', 'https://drive.google.com/uc?id=17eNjHI0Xbu4AYO8lLjwo3AkHyigsYzlV&export=download', 'William Dave Agravante', 'williamdave.agravante@cvsu.edu.ph', 'CAS', 'Bachelor of Arts in Journalism', '', 'Document,,Try,,To,be,signed', '2024-01-21 17:07:57', '2025-05-05'),
(22, 'authorization-letter.pdf', 94494, 'application/pdf', '1ZuJbEANDrFQ-VXglxqfnbkfs37LKMuBE', 'https://drive.google.com/file/d/1ZuJbEANDrFQ-VXglxqfnbkfs37LKMuBE/view?usp=drivesdk', 'https://drive.google.com/uc?id=1ZuJbEANDrFQ-VXglxqfnbkfs37LKMuBE&export=download', 'William Dave Agravante', 'williamdave.agravante@cvsu.edu.ph', 'CEIT', 'Bachelor of Science in Computer Science', '', 'try', '2024-01-23 15:28:47', '2024-03-23'),
(23, 'notes.docx', 19545, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', '1pjciY9q_Y8Sp5iSSJCDSHsJT6_sUZOHX', 'https://docs.google.com/document/d/1pjciY9q_Y8Sp5iSSJCDSHsJT6_sUZOHX/edit?usp=drivesdk&ouid=117732174434037950678&rtpof=true&sd=true', 'https://drive.google.com/uc?id=1pjciY9q_Y8Sp5iSSJCDSHsJT6_sUZOHX&export=download', 'William Dave Agravante', 'williamdave.agravante@cvsu.edu.ph', 'CAFENR', 'Bachelor of Science in Land Use Design and Management', '', 'yes,,gumagana,na', '2024-01-23 16:13:43', '2024-08-24'),
(24, 'DFD_Nicolette.pdf', 319254, 'application/pdf', '1_B-k8uhu8qG2-ESK7Cf6Aj-_tE5kHOm-', 'https://drive.google.com/file/d/1_B-k8uhu8qG2-ESK7Cf6Aj-_tE5kHOm-/view?usp=drivesdk', 'https://drive.google.com/uc?id=1_B-k8uhu8qG2-ESK7Cf6Aj-_tE5kHOm-&export=download', 'William Dave Agravante', 'williamdave.agravante@cvsu.edu.ph', 'CAFENR', 'Bachelor of Science in Land Use Design and Management', '', 'try', '2024-02-06 11:02:02', '2029-03-27'),
(25, 'ERD_NIcolette.pdf', 214765, 'application/pdf', '', '', '', 'William Dave Agravante', 'williamdave.agravante@cvsu.edu.ph', 'CAFENR', 'Bachelor of Science in Food Technology', '', '', '2024-02-06 11:03:30', '2025-07-29');

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
(1, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:45:21', 'laicadennise.miranda@gmail.com has logged into the system'),
(2, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:46:22', 'laicadennise.miranda@gmail.com has deleted a user access request from the database'),
(3, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:46:26', 'laicadennise.miranda@gmail.com has logged out from the system'),
(4, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:47:56', 'laicadennise.miranda@gmail.com has logged into the system'),
(5, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:49:11', 'laicadennise.miranda@gmail.com has uploaded a file: Test File.pdf at CAFENR'),
(6, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:50:20', 'laicadennise.miranda@gmail.com has uploaded a file: document.pdf at General'),
(7, 'laicadennise.miranda@gmail.com', 0, 'CAFENR', '2024-01-06 06:54:11', 'File \'Test File.pdf\' owned by \'Laica Dennise Miranda\' in \'CAFENR\' was deleted by \'laicadennise.miranda@gmail.com\''),
(8, 'laicadennise.miranda@gmail.com', 0, 'General', '2024-01-06 06:54:20', 'File \'document.pdf\' owned by \'Laica Dennise Miranda\' in \'General\' was deleted by \'laicadennise.miranda@gmail.com\''),
(9, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:54:45', 'laicadennise.miranda@gmail.com has deleted a user access request from the database'),
(10, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:55:08', 'laicadennise.miranda@gmail.com has logged out from the system'),
(11, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:56:02', 'laicadennise.miranda@gmail.com has logged into the system'),
(12, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:56:30', 'laicadennise.miranda@gmail.com has uploaded a file: Test File.pdf at General'),
(13, 'laicadennise.miranda@gmail.com', 0, 'General', '2024-01-06 06:56:48', 'File \'Test File.pdf\' owned by \'Laica Dennise Miranda\' in \'General\' was deleted by \'laicadennise.miranda@gmail.com\''),
(14, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:57:34', 'laicadennise.miranda@gmail.com has logged out from the system'),
(15, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:58:22', 'laicadennise.miranda@gmail.com has logged into the system'),
(16, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 06:59:44', 'laicadennise.miranda@gmail.com has uploaded a file: Test File.pdf at CAFENR'),
(17, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:01:18', 'laicadennise.miranda@gmail.com has uploaded a file: TECHNICAL-EVALUATIONproper.docx at General'),
(18, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:02:53', 'laicadennise.miranda@gmail.com has uploaded a file: NON-TECHNICAL-EVALUATION.docx at General'),
(19, 'laicadennise.miranda@gmail.com', 0, 'General', '2024-01-06 07:17:29', 'File \'NON-TECHNICAL-EVALUATION.docx\' owned by \'Laica Dennise Miranda\' in \'General\' was deleted by \'laicadennise.miranda@gmail.com\''),
(20, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:18:10', 'laicadennise.miranda@gmail.com has uploaded a file: NON-TECHNICAL-EVALUATION.docx at CEIT'),
(21, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:20:10', 'laicadennise.miranda@gmail.com has logged out from the system'),
(22, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:20:18', 'laicadennise.miranda@gmail.com has logged into the system'),
(23, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:20:25', 'laicadennise.miranda@gmail.com has logged out from the system'),
(24, 'laicadennise.miranda@cvsu.edu.ph', 0, '', '2024-01-06 07:20:48', 'laicadennise.miranda@cvsu.edu.ph has logged into the system'),
(25, 'laicadennise.miranda@cvsu.edu.ph', 0, '', '2024-01-06 07:27:10', 'laicadennise.miranda@cvsu.edu.ph has uploaded a file: Test File for College of Medicine.docx at College of Medicine'),
(26, 'laicadennise.miranda@cvsu.edu.ph', 0, '', '2024-01-06 07:28:02', 'laicadennise.miranda@cvsu.edu.ph has uploaded a file: Revision-Sheet.docx at CEIT'),
(27, 'laicadennise.miranda@cvsu.edu.ph', 0, '', '2024-01-06 07:28:35', 'laicadennise.miranda@cvsu.edu.ph has logged out from the system'),
(28, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:29:36', 'laicadennise.miranda@gmail.com has logged into the system'),
(29, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:30:36', 'laicadennise.miranda@gmail.com has uploaded a file: Test File for CAS.pdf at CAS'),
(30, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:32:39', 'laicadennise.miranda@gmail.com has added the user: testuser@gmail.com to the database'),
(31, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:32:48', 'laicadennise.miranda@gmail.com has deleted a user from the database'),
(32, 'laicadennise.miranda@gmail.com', 0, 'CEIT', '2024-01-06 07:33:30', 'File \'NON-TECHNICAL-EVALUATION.docx\' owned by \'Laica Dennise Miranda\' in \'CEIT\' was deleted by \'laicadennise.miranda@gmail.com\''),
(33, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:34:59', 'laicadennise.miranda@gmail.com has uploaded a file: document.pdf at CAFENR'),
(34, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:35:54', 'laicadennise.miranda@gmail.com has uploaded a file: Test File for CCJ.pdf at CCJ'),
(35, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:42:36', 'laicadennise.miranda@gmail.com has logged out from the system'),
(36, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:43:45', 'laicadennise.miranda@gmail.com has logged into the system'),
(37, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:45:22', 'laicadennise.miranda@gmail.com has uploaded a file: Test File for CED.pdf at CED'),
(38, 'laicadennise.miranda@gmail.com', 0, 'CAFENR', '2024-01-06 07:46:46', 'File \'document.pdf\' owned by \'Laica Dennise Miranda\' in \'CAFENR\' was deleted by \'laicadennise.miranda@gmail.com\''),
(39, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:47:27', 'laicadennise.miranda@gmail.com has uploaded a file: Authorization-Letter.pdf at CVMBS'),
(40, 'laicadennise.miranda@gmail.com', 0, 'CVMBS', '2024-01-06 07:48:01', 'File \'Authorization-Letter.pdf\' owned by \'Laica Dennise Miranda\' in \'CVMBS\' was deleted by \'laicadennise.miranda@gmail.com\''),
(41, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:48:28', 'laicadennise.miranda@gmail.com has added the user: testuser@gmail.com to the database'),
(42, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:48:34', 'laicadennise.miranda@gmail.com has deleted a user from the database'),
(43, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:48:38', 'laicadennise.miranda@gmail.com has deleted a user access request from the database'),
(44, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:49:58', 'laicadennise.miranda@gmail.com has uploaded a file: Signed Form 1.png at CAFENR'),
(45, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:51:31', 'laicadennise.miranda@gmail.com has uploaded a file: Test File for CEMDS.pdf at CEMDS'),
(46, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:52:35', 'laicadennise.miranda@gmail.com has uploaded a file: Test File for CEIT.png at CEIT'),
(47, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:53:11', 'laicadennise.miranda@gmail.com has uploaded a file: Test File for CON.jpg at CON'),
(48, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:54:00', 'laicadennise.miranda@gmail.com has uploaded a file: Test File for CSPEAR.pdf at CSPEAR'),
(49, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:54:34', 'laicadennise.miranda@gmail.com has uploaded a file: Test File for CVMBS.docx at CVMBS'),
(50, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:55:18', 'laicadennise.miranda@gmail.com has uploaded a file: Test File for Grad School.pdf at Graduate School and Open Learning College'),
(51, 'laicadennise.miranda@gmail.com', 0, '', '2024-01-06 07:56:41', 'laicadennise.miranda@gmail.com has logged out from the system'),
(52, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-08 00:06:04', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(53, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-08 15:38:10', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(54, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-08 15:38:56', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(55, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-08 16:16:10', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(56, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-11 14:28:32', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(57, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-13 15:10:11', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(58, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-13 15:14:18', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(59, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-13 15:18:50', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(60, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-13 15:21:22', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(61, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 14:35:55', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(62, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2024-01-21 14:43:10', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(63, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-21 14:43:33', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(64, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-21 14:55:14', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(65, 'williamdave.agravante@cvsu.edu.ph', 3, '', '2024-01-21 14:57:15', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(66, 'williamdave.agravante@cvsu.edu.ph', 3, 'CEIT', '2024-01-21 14:59:35', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(67, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-01-21 15:01:21', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(68, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-21 15:01:54', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(69, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-21 15:04:12', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: Agravante_COSC111A.pdf at CAFENR'),
(70, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-21 15:04:43', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(71, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-01-21 15:05:38', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(72, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-01-21 15:06:47', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(73, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 15:07:23', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(74, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 15:07:58', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(75, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 15:08:58', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: Agravante_COSC111A.pdf at CAFENR'),
(76, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 15:10:44', 'williamdave.agravante@cvsu.edu.ph has added the user: williamdaveagravante848@gmail.com to the database'),
(77, 'williamdaveagravante848@gmail.com', 2, 'CAFENR', '2024-01-21 15:11:04', 'williamdaveagravante848@gmail.com has logged into the system'),
(78, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 15:11:44', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(79, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 15:12:09', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(80, 'williamdaveagravante848@gmail.com', 3, 'CAFENR', '2024-01-21 15:12:33', 'williamdaveagravante848@gmail.com has logged into the system'),
(81, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 15:19:14', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(82, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 15:28:05', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(83, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 15:29:36', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(84, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 15:44:20', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(85, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 15:45:13', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(86, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 15:45:43', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(87, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 15:46:24', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(88, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 15:49:52', 'williamdave.agravante@cvsu.edu.ph has changed the info of user: williamdaveagravante848@gmail.com'),
(89, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 15:50:42', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(90, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 15:51:06', 'williamdave.agravante@cvsu.edu.ph has changed the info of user: laicadennise.miranda@gmail.com'),
(91, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 15:53:45', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(92, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 16:15:48', 'williamdave.agravante@cvsu.edu.ph has changed the info of user: williamdaveagravante848@gmail.com'),
(93, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 16:16:54', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(94, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 16:21:03', 'williamdave.agravante@cvsu.edu.ph has changed the info of user: williamdaveagravante848@gmail.com'),
(95, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 16:24:32', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(96, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 16:26:30', 'williamdave.agravante@cvsu.edu.ph has changed the info of user: williamdaveagravante848@gmail.com'),
(97, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 16:26:44', 'williamdave.agravante@cvsu.edu.ph has changed the info of user: williamdaveagravante848@gmail.com'),
(98, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 16:29:16', 'williamdave.agravante@cvsu.edu.ph has changed the info of user: williamdaveagravante848@gmail.com'),
(99, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 16:34:03', 'williamdave.agravante@cvsu.edu.ph has changed the info of user: williamdaveagravante848@gmail.com'),
(100, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 16:34:45', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(101, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-21 16:35:05', 'williamdave.agravante@cvsu.edu.ph has changed the info of user: williamdaveagravante848@gmail.com'),
(102, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 16:35:51', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(103, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 16:36:13', 'williamdave.agravante@cvsu.edu.ph has changed the info of user: williamdaveagravante848@gmail.com'),
(104, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 17:02:51', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(105, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 17:05:04', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(106, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-21 17:07:57', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: jane.docx at CAS'),
(107, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-22 14:47:54', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(108, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-22 14:57:39', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(109, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-22 14:59:32', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(110, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-22 15:04:00', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(111, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-22 15:04:26', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(112, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-22 15:25:42', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(113, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-22 15:34:57', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(114, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-22 16:23:34', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(115, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-22 17:00:31', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(116, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-22 17:01:31', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(117, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-23 13:42:56', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(118, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-23 14:45:44', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(119, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-23 15:28:48', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: authorization-letter.pdf at CEIT'),
(120, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-23 15:49:11', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(121, 'williamdave.agravante@cvsu.edu.ph', 0, '', '2024-01-23 15:51:09', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(122, 'williamdave.agravante@cvsu.edu.ph', 2, '', '2024-01-23 15:52:17', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(123, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-23 15:53:12', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(124, 'williamdave.agravante@cvsu.edu.ph', 2, 'CAFENR', '2024-01-23 15:55:06', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(125, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-23 15:55:47', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(126, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-23 16:12:06', 'File \'Signed Form 1.png\' owned by \'Laica Dennise Miranda\' in \'CAFENR\' was deleted by \'williamdave.agravante@cvsu.edu.ph\''),
(127, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-23 16:13:44', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: notes.docx at CAFENR'),
(128, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-28 08:35:32', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(129, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-28 08:37:04', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(130, 'williamdaveagravante848@gmail.com', 4, 'CAFENR', '2024-01-28 08:37:27', 'williamdaveagravante848@gmail.com has logged into the system'),
(131, 'williamdaveagravante848@gmail.com', 3, 'CAFENR', '2024-01-28 08:38:36', 'williamdaveagravante848@gmail.com has logged into the system'),
(132, 'williamdaveagravante848@gmail.com', 3, 'CAFENR', '2024-01-30 20:12:27', 'williamdaveagravante848@gmail.com has logged out from the system'),
(133, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-30 20:13:32', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(134, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-30 20:13:34', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(135, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-30 20:13:35', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(136, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-30 20:15:37', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(137, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-01-30 20:16:20', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(138, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-01-30 20:17:00', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(139, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-30 20:17:59', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(140, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-01-30 20:18:08', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(141, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-02-06 10:59:20', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(142, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-02-06 11:02:03', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: DFD_Nicolette.pdf at CAFENR'),
(143, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-02-06 11:03:30', 'williamdave.agravante@cvsu.edu.ph has uploaded a file: ERD_NIcolette.pdf at CAFENR'),
(144, 'williamdave.agravante@cvsu.edu.ph', 0, 'CAFENR', '2024-02-06 11:03:53', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(145, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-02-06 11:10:18', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(146, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-02-06 11:10:20', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(147, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-02-06 11:13:26', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(148, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-02-06 11:13:45', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(149, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-02-06 11:35:34', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(150, 'williamdave.agravante@cvsu.edu.ph', 3, 'CEIT', '2024-02-06 11:36:16', 'williamdave.agravante@cvsu.edu.ph has logged into the system'),
(151, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-02-06 11:38:25', 'williamdave.agravante@cvsu.edu.ph has logged out from the system'),
(152, 'williamdave.agravante@cvsu.edu.ph', 3, 'CAFENR', '2024-02-06 11:38:52', 'williamdave.agravante@cvsu.edu.ph has logged into the system');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `oauth_uid` varchar(50) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `user_level` int(3) NOT NULL,
  `local` varchar(20) DEFAULT NULL,
  `college` varchar(50) NOT NULL,
  `course` varchar(200) NOT NULL,
  `active_status` varchar(50) NOT NULL DEFAULT 'Offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_uid`, `first_name`, `last_name`, `email`, `profile_pic`, `user_level`, `local`, `college`, `course`, `active_status`) VALUES
(2, '102958130049128401532', 'LAICA DENNISE', 'MIRANDA', 'laicadennise.miranda@cvsu.edu.ph', '', 0, 'https://lh3.googleus', '', '', 'Offline'),
(3, '101333192880725710175', 'Laica Dennise', 'Miranda', 'laicadennise.miranda@gmail.com', '', 0, 'https://lh3.googleus', '', '', 'Offline'),
(28, '117732174434037950678', 'William Dave', 'Agravante', 'williamdave.agravante@cvsu.edu.ph', '', 3, '', 'CAFENR', 'Bachelor of Science in Food Technology', 'Online'),
(29, '104158604052786964755', 'William Dave', 'Agravante', 'williamdaveagravante848@gmail.com', '', 3, NULL, 'CAFENR', 'Bachelor of Science in Food Technology', 'Offline');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_request`
--
ALTER TABLE `access_request`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_request`
--
ALTER TABLE `access_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
