-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2020 at 09:17 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kiranransing`
--

-- --------------------------------------------------------

--
-- Table structure for table `mst_city`
--

CREATE TABLE `mst_city` (
  `id` bigint(11) NOT NULL,
  `city` varchar(200) NOT NULL,
  `state_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mst_city`
--

INSERT INTO `mst_city` (`id`, `city`, `state_id`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Pune', 1, '2020-09-26 07:50:56', 1, '2020-09-26 08:00:38', 1),
(3, 'Hubli', 2, '2020-09-26 09:17:02', 1, '2020-09-26 09:17:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_state`
--

CREATE TABLE `mst_state` (
  `id` bigint(11) NOT NULL,
  `state` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mst_state`
--

INSERT INTO `mst_state` (`id`, `state`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Maharashtra', '2020-09-26 03:09:10', 1, '2020-09-26 03:09:10', 1),
(2, 'Karnataka', '2020-09-26 03:09:10', 1, '2020-09-26 04:32:37', 1),
(6, 'Goa', '2020-09-26 07:30:15', 1, '2020-09-26 07:30:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_users`
--

CREATE TABLE `mst_users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `user_email` varchar(200) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '1= active 0 = not active',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_users`
--

INSERT INTO `mst_users` (`id`, `name`, `contact_no`, `user_email`, `password`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Kiran Ransing', '9028213465', 'karanransing111@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, '2020-09-26 04:09:09', 1, '2020-09-26 02:05:07', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_city`
--
ALTER TABLE `mst_city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city` (`city`),
  ADD KEY `state_id` (`state_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `mst_state`
--
ALTER TABLE `mst_state`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state` (`state`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `mst_users`
--
ALTER TABLE `mst_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `contact_no` (`contact_no`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `password` (`password`),
  ADD KEY `status` (`status`),
  ADD KEY `updated_at` (`updated_at`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `created_at` (`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_city`
--
ALTER TABLE `mst_city`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mst_state`
--
ALTER TABLE `mst_state`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mst_users`
--
ALTER TABLE `mst_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
