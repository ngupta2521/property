-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2017 at 03:28 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `property`
--

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) DEFAULT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 0, 'f3599dba24e40c1ff9367e56b386b87e', 1, 0, 0, NULL, 1477768625),
(2, 1, 'd333dc94f4a3462cd905c7f903ed5aee', 1, 0, 0, NULL, 1502686986),
(3, 5, '70af40362318a63dafc3b1e7f891689c', 1, 0, 0, NULL, 1502691459);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_message`
--

CREATE TABLE `tbl_message` (
  `id` int(11) NOT NULL,
  `message_key` varchar(30) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` int(1) NOT NULL,
  `sender_deleted` int(1) NOT NULL,
  `receiver_deleted` int(1) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_message`
--

INSERT INTO `tbl_message` (`id`, `message_key`, `sender_id`, `property_id`, `receiver_id`, `message`, `is_read`, `sender_deleted`, `receiver_deleted`, `created_date`) VALUES
(1, '3_5_6', 5, 6, 3, 'This is testing', 0, 0, 0, '2017-08-14 14:08:23'),
(2, '3_5_6', 5, 6, 3, 'This is testing2', 0, 0, 0, '2017-08-14 14:08:44'),
(3, '3_5_6', 5, 6, 3, 'fgdgdfg', 0, 0, 0, '2017-08-14 14:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_property`
--

CREATE TABLE `tbl_property` (
  `id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '''buyer''=>1,''seller''=>2,''tenant''=>3,''landlord''=>4',
  `property_type` int(11) NOT NULL COMMENT '''residential''=>1,''commercial''=>2,''industrial''=>3,''agricultural''=>4',
  `budget_min_price` int(11) NOT NULL,
  `budget_max_price` int(11) NOT NULL,
  `postal_pin` varchar(55) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_property`
--

INSERT INTO `tbl_property` (`id`, `city`, `user_type`, `property_type`, `budget_min_price`, `budget_max_price`, `postal_pin`, `user_id`, `created_date`, `deleted_at`) VALUES
(1, 'Vadodara', 2, 1, 200000, 400000, '390002', 1, '2017-08-10 19:03:51', '2017-08-14 08:05:21'),
(2, 'Vadodara', 2, 1, 100000, 400000, '390002', 4, '2017-08-11 18:20:07', '2017-08-11 14:59:26'),
(3, 'Vadodara', 2, 1, 100000, 400000, '390002', 4, '2017-08-11 18:29:26', '2017-08-11 15:42:22'),
(4, 'Vadodara', 2, 1, 250000, 300000, '390002', 3, '2017-08-11 19:08:25', '2017-08-11 15:40:24'),
(5, 'Vadodara', 2, 1, 200000, 400000, '390002', 4, '2017-08-11 19:12:22', NULL),
(6, 'vadodara', 2, 1, 200000, 500000, '390002', 5, '2017-08-14 10:20:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_report`
--

CREATE TABLE `tbl_report` (
  `id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '''buyer''=>1,''seller''=>2,''tenant''=>3,''landlord''=>4',
  `property_type` int(11) NOT NULL COMMENT '''residential''=>1,''commercial''=>2,''industrial''=>3,''agricultural''=>4',
  `budget_min_price` int(11) NOT NULL,
  `budget_max_price` int(11) NOT NULL,
  `postal_pin` varchar(55) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_report`
--

INSERT INTO `tbl_report` (`id`, `city`, `user_type`, `property_type`, `budget_min_price`, `budget_max_price`, `postal_pin`, `user_id`, `property_id`, `created_date`, `deleted_at`) VALUES
(1, 'Vadodara', 2, 1, 200000, 400000, '390002', 1, 1, '2017-08-11 13:50:52', '2017-08-14 08:05:21'),
(2, 'Vadodara', 1, 1, 200000, 300000, '390002', 2, 0, '2017-08-11 17:21:21', NULL),
(3, 'Vadodara', 1, 1, 250000, 300000, '390002', 3, 0, '2017-08-11 17:48:39', '2017-08-11 15:38:25'),
(4, 'Vadodara', 2, 1, 100000, 400000, '390002', 4, 2, '2017-08-11 18:20:07', '2017-08-11 14:59:26'),
(5, 'Vadodara', 2, 1, 100000, 400000, '390002', 4, 3, '2017-08-11 18:29:27', '2017-08-11 15:27:23'),
(6, 'Vadodara', 1, 1, 200000, 400000, '390002', 4, 0, '2017-08-11 18:57:23', '2017-08-11 15:42:22'),
(7, 'Vadodara', 2, 1, 250000, 300000, '390002', 3, 4, '2017-08-11 19:08:25', '2017-08-11 15:38:53'),
(8, 'Vadodara', 1, 1, 250000, 300000, '390002', 3, 0, '2017-08-11 19:08:53', '2017-08-11 15:40:23'),
(9, 'Vadodara', 1, 1, 250000, 300000, '390002', 3, 0, '2017-08-11 19:10:24', NULL),
(10, 'Vadodara', 2, 1, 200000, 400000, '390002', 4, 5, '2017-08-11 19:12:22', NULL),
(11, 'vadodara', 2, 1, 200000, 500000, '390002', 5, 6, '2017-08-14 10:20:14', NULL),
(12, 'vadodara', 1, 1, 200000, 500000, '390002', 1, 0, '2017-08-14 11:35:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otp` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_prefix` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `is_mobile_verified` int(1) NOT NULL DEFAULT '0',
  `is_seller` int(1) NOT NULL DEFAULT '0',
  `is_seller_verified` int(1) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `user_role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `deviceToken` text COLLATE utf8_unicode_ci NOT NULL,
  `deviceUser` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `name`, `email`, `password`, `otp`, `mobile_prefix`, `mobile_number`, `is_mobile_verified`, `is_seller`, `is_seller_verified`, `last_login`, `user_role`, `status`, `deviceToken`, `deviceUser`, `created_at`) VALUES
(1, 'Nilesh Gupta', 'nileshkumar.gupta4@gmail.com', 'MTIzNDU2', '3258', '+91', '8306816376', 0, 0, 0, NULL, '', 1, '', '', '2017-08-11 13:50:52'),
(2, 'Nilesh Kumar', 'nilesh.gupta@gmail.com', 'MTIzNDU2', '4196', '+91', '8306816377', 0, 0, 0, NULL, '', 1, '', '', '2017-08-11 17:21:21'),
(3, 'Jimish G', 'jmish@gmail.com', 'MTIzNDU2', '4108', '+91', '1234567890', 0, 0, 0, NULL, '', 1, '', '', '2017-08-11 17:48:39'),
(4, 'Nilu Gupta', 'nilu@gmail.com', 'MTIzNDU2', '2875', '+91', '8306816386', 0, 0, 0, NULL, '', 1, '', '', '2017-08-11 18:20:06'),
(5, 'Piyu', 'pgupta@gmail.com', 'MTIzNDU2', '2263', '+91', '8690292401', 0, 0, 0, NULL, '', 1, '', '', '2017-08-14 10:20:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_message`
--
ALTER TABLE `tbl_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_property`
--
ALTER TABLE `tbl_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_report`
--
ALTER TABLE `tbl_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_message`
--
ALTER TABLE `tbl_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_property`
--
ALTER TABLE `tbl_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_report`
--
ALTER TABLE `tbl_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
