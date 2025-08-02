-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2025 at 07:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_mast`
--

CREATE TABLE `admin_mast` (
  `a_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_mast`
--

INSERT INTO `admin_mast` (`a_id`, `name`, `email`, `password`) VALUES
(1, 'AdminS', 'admins@gmail.com', '0531'),
(2, 'AdminM', 'adminm@gmail.com', '1110');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `a_id` int(11) NOT NULL,
  `specilization` varchar(100) NOT NULL,
  `d_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `fees` int(11) NOT NULL,
  `a_date` varchar(255) NOT NULL,
  `a_time` varchar(255) NOT NULL,
  `postingdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `userstatus` int(11) NOT NULL,
  `d_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`a_id`, `specilization`, `d_id`, `p_id`, `fees`, `a_date`, `a_time`, `postingdate`, `userstatus`, `d_status`) VALUES
(3, 'ENT', 1, 1, 1000, '2025-03-05', '02:00', '2025-03-02 17:28:50', 1, 2),
(4, 'ENT', 1, 10, 1000, '2025-03-15', '04:00', '2025-03-02 17:32:21', 1, 1),
(5, 'ENT', 1, 11, 1000, '2025-03-21', '06:07', '2025-03-02 19:33:19', 1, 0),
(6, 'Orthopedics', 3, 1, 1800, '2025-03-28', '06:00', '2025-03-02 19:34:16', 1, 2),
(7, 'ENT', 1, 1, 1000, '2025-03-15', '03:04', '2025-03-02 19:34:37', 1, 0),
(8, 'Orthopedics', 3, 1, 1800, '2025-03-03', '11:11', '2025-03-02 19:41:17', 1, 1),
(11, 'Orthopedics', 3, 11, 1800, '2025-03-03', '11:26', '2025-03-03 06:38:04', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `c_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` text NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`c_id`, `name`, `email`, `mobile`, `message`, `created_at`) VALUES
(3, 'sonali Mehta', 'sonali13@gmail.com', '6325587415', 'for the test..', '2025-03-03 05:36:02');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_mast`
--

CREATE TABLE `doctor_mast` (
  `d_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `specilization` text NOT NULL,
  `docfees` int(11) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_mast`
--

INSERT INTO `doctor_mast` (`d_id`, `name`, `specilization`, `docfees`, `contact`, `email`, `password`) VALUES
(1, 'Dr. Maitri Solanki', 'ENT', 1000, '9852364152', 'drms@gmail.com', '1110'),
(2, 'Dr.Sonali Mehta', 'Dental Care', 1500, '8563216475', 'drsm@gmail.com', '0531'),
(3, 'Dr. Priyansh Maisuriya', 'Orthopedics', 1800, '9524324255', 'drpm@gmail.com', '0531');

-- --------------------------------------------------------

--
-- Table structure for table `medical_history`
--

CREATE TABLE `medical_history` (
  `m_id` int(10) NOT NULL,
  `p_detail_id` int(10) DEFAULT NULL,
  `bp` varchar(200) DEFAULT NULL,
  `bs` varchar(200) NOT NULL,
  `weight` varchar(100) DEFAULT NULL,
  `temperature` varchar(200) DEFAULT NULL,
  `m_prescription` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_history`
--

INSERT INTO `medical_history` (`m_id`, `p_detail_id`, `bp`, `bs`, `weight`, `temperature`, `m_prescription`, `created_at`) VALUES
(1, 1, '80/120', '110', '85', '97', 'Dolo,Levocit 5mg', '2025-02-07 10:16:32'),
(5, 1, '60/120', '120', '80', '67', 'fgdboh', '2025-03-02 18:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `img`, `type`, `category`, `description`) VALUES
(1, 'd1.jpg', 'gallery', 'dental', ''),
(2, 'd2.jpg', 'gallery', 'dental', ''),
(3, 'd3.jpg', 'gallery', 'dental', ''),
(4, 'd5.jpg', 'gallery', 'dental', ''),
(5, 'c1.jpg', 'gallery', 'cardiology', ''),
(6, 'c2.jpg', 'gallery', 'cardiology', ''),
(7, 'c3.jpg', 'gallery', 'cardiology', ''),
(8, 'c4.jpg', 'gallery', 'cardiology', ''),
(9, 'n1.jpg', 'gallery', 'neurology', ''),
(10, 'n2.jpg', 'gallery', 'neurology', ''),
(11, 'n3.jpg', 'gallery', 'neurology', ''),
(12, 'l1.jpg', 'gallery', 'laboratry', ''),
(13, 'l2.jpg', 'gallery', 'laboratry', ''),
(14, 'l3.jpg', 'gallery', 'laboratry', ''),
(15, 'a5.jpg', 'about', '', 'The Hospital Management System (HMS) is designed to replace the manual, paper-based system in hospitals, streamlining patient information, room availability, staff schedules, and billing. It ensures efficient data management, timely retrieval, and optimal resource utilization. By automating hospital operations, HMS enhances efficiency, reduces errors, standardizes data, and maintains data integrity while minimizing inconsistencies.'),
(16, 'a2.jpg', 'ad', '', ''),
(17, 'a3.jpg', 'ad', '', ''),
(18, 'a4.jpg', 'ad', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `patient_detail`
--

CREATE TABLE `patient_detail` (
  `p_detail_id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `p_email` varchar(100) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `p_gender` varchar(50) NOT NULL,
  `p_add` varchar(100) NOT NULL,
  `p_age` int(11) NOT NULL,
  `p_medhis` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_detail`
--

INSERT INTO `patient_detail` (`p_detail_id`, `d_id`, `p_name`, `p_email`, `contact_no`, `p_gender`, `p_add`, `p_age`, `p_medhis`, `created_at`) VALUES
(1, 1, 'sonali Mehta', 'sonali13@gmail.com', '9874563214', 'Female', 'bmfbo', 19, 'fever , cold', '2025-02-07 10:18:38'),
(8, 1, 'jeiny thakor', 'jt123@gmail.com', '8456756842', 'Female', 'bfohp', 21, 'cold', '2025-03-02 17:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `patient_mast`
--

CREATE TABLE `patient_mast` (
  `p_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_mast`
--

INSERT INTO `patient_mast` (`p_id`, `fullname`, `address`, `city`, `gender`, `email`, `password`, `created_at`) VALUES
(1, 'sonali', 'fbnfg', 'fmf', 'Female', 'patients13@gmail.com', '$2y$10$j7DH2TDd2F2J4ijndadUD.Uf0S.vgimuYp31QaBoC1Ye..mdPvsla', '2025-01-22 06:53:26'),
(2, 'Maitri', 'gfmhmf', 'cvombdo', 'Female', 'maitri04@gmail.com', '$2y$10$EIp.K.ZiaDK0aRx32Q4uI.ri.Zc5MFJCS3iXLTUha8LwSkt/OjfqS', '2025-01-27 08:48:32'),
(8, 'priyanshu', 'cmvdfkb', 'fkd', 'Male', 'lttl@gmail.com', '$2y$10$Jak2io01OVKkZR2GkEa6NuiXasQfbq3Gp2UuKIOTbFmlX7HSDhmM2', '2025-03-01 07:40:09'),
(10, 'mayur', 'cxlbmf', 'cvlbmdf', 'Male', 'mb123@gmail.com', '$2y$10$p9uaysXZ8xpXp21B5BUcCOPIy8xN4xuCQXzGwnm5e9GH8fA7gtKGO', '2025-03-02 17:30:17'),
(11, 'pratham', 'vclbmfl', 'vlbmdf', 'Male', 'pp1102@gmail.com', '$2y$10$wN7srw8INmaVCmomLTUHfOyXi7hn9kgDeRrtu2dFRpLHLtGYPJLLq', '2025-03-02 17:38:27'),
(15, 'vrushang', 'blml', 'fvbmfd', 'Male', 'vk12345@gmail.com', '$2y$10$cruoYntjFEaKfGOhi204h.GHoWh6tyOnf0eaTqYzwqcDuD3H9lzgK', '2025-03-03 05:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `specilization`
--

CREATE TABLE `specilization` (
  `s_id` int(11) NOT NULL,
  `specilization` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specilization`
--

INSERT INTO `specilization` (`s_id`, `specilization`, `created_at`) VALUES
(1, 'ENT', '2025-02-07 06:25:34'),
(2, 'Dental Care', '2025-02-07 10:20:48'),
(7, 'Neurologist', '2025-03-02 10:53:29'),
(8, 'Orthopedics', '2025-03-02 10:53:49'),
(9, 'Pathology', '2025-03-02 10:54:02'),
(10, 'General Surgery', '2025-03-02 10:54:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_mast`
--
ALTER TABLE `admin_mast`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `doctor_mast`
--
ALTER TABLE `doctor_mast`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `medical_history`
--
ALTER TABLE `medical_history`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_detail`
--
ALTER TABLE `patient_detail`
  ADD PRIMARY KEY (`p_detail_id`);

--
-- Indexes for table `patient_mast`
--
ALTER TABLE `patient_mast`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `specilization`
--
ALTER TABLE `specilization`
  ADD PRIMARY KEY (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_mast`
--
ALTER TABLE `admin_mast`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctor_mast`
--
ALTER TABLE `doctor_mast`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `medical_history`
--
ALTER TABLE `medical_history`
  MODIFY `m_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `patient_detail`
--
ALTER TABLE `patient_detail`
  MODIFY `p_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `patient_mast`
--
ALTER TABLE `patient_mast`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `specilization`
--
ALTER TABLE `specilization`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
