-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 06, 2020 at 06:58 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id12763816_payrollbeta`
--

-- --------------------------------------------------------

--
-- Table structure for table `checks`
--

CREATE TABLE `checks` (
  `id` int(10) UNSIGNED NOT NULL,
  `quantity` time NOT NULL,
  `date` date NOT NULL,
  `userid` int(10) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `overtime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `checks`
--

INSERT INTO `checks` (`id`, `quantity`, `date`, `userid`, `amount`, `overtime`) VALUES
(11, '09:55:00', '2019-01-01', 7, 163.12, 43);

-- --------------------------------------------------------

--
-- Table structure for table `clock_in_clock_out`
--

CREATE TABLE `clock_in_clock_out` (
  `id` int(11) UNSIGNED NOT NULL,
  `clock_in` time DEFAULT NULL,
  `clock_out` time DEFAULT NULL,
  `difference` time NOT NULL,
  `overtime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clock_in_clock_out`
--

INSERT INTO `clock_in_clock_out` (`id`, `clock_in`, `clock_out`, `difference`, `overtime`) VALUES
(7, NULL, NULL, '00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gross`
--

CREATE TABLE `gross` (
  `id` int(10) UNSIGNED NOT NULL,
  `gross_tax` float(10,2) NOT NULL,
  `gross_deduction` float(10,2) NOT NULL,
  `total_income` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gross`
--

INSERT INTO `gross` (`id`, `gross_tax`, `gross_deduction`, `total_income`) VALUES
(7, 48.37, 70.17, 163.12);

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(10) UNSIGNED NOT NULL,
  `income` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `rate` int(3) NOT NULL,
  `federal_income_tax` decimal(7,7) DEFAULT 0.1000000,
  `social_security` decimal(7,7) DEFAULT 0.0620000,
  `medicare` decimal(7,7) DEFAULT 0.0145000,
  `state_income_tax` decimal(7,7) NOT NULL,
  `city_income_tax` decimal(7,7) NOT NULL,
  `health_insurance` decimal(7,7) DEFAULT NULL,
  `dental_health_insurance` decimal(7,7) DEFAULT NULL,
  `four01K` decimal(10,10) DEFAULT NULL,
  `division` varchar(70) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`id`, `income`, `rate`, `federal_income_tax`, `social_security`, `medicare`, `state_income_tax`, `city_income_tax`, `health_insurance`, `dental_health_insurance`, `four01K`, `division`) VALUES
(7, 'Regular Hourly Pay', 15, 0.1000000, 0.0620000, 0.0145000, 0.0400000, 0.0800000, 0.4000000, 0.0600000, 0.1200000000, 'New York, New York City');

-- --------------------------------------------------------

--
-- Table structure for table `retiree`
--

CREATE TABLE `retiree` (
  `id` int(11) UNSIGNED NOT NULL,
  `info` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_deduction`
--

CREATE TABLE `tax_deduction` (
  `id` int(10) UNSIGNED NOT NULL,
  `federal_income_tax` float(10,2) DEFAULT NULL,
  `social_security` float(10,2) DEFAULT NULL,
  `medicare` float(10,2) DEFAULT NULL,
  `state_income_tax` float(10,2) DEFAULT NULL,
  `city_income_tax` float(10,2) DEFAULT NULL,
  `health_insurance` float(10,2) DEFAULT NULL,
  `dental_health_insurance` float(10,2) DEFAULT NULL,
  `four01K` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tax_deduction`
--

INSERT INTO `tax_deduction` (`id`, `federal_income_tax`, `social_security`, `medicare`, `state_income_tax`, `city_income_tax`, `health_insurance`, `dental_health_insurance`, `four01K`) VALUES
(11, 16.31, 10.11, 2.37, 6.53, 13.05, 44.00, 6.60, 19.57);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` int(64) DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `social_security` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_method` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notification` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `email`, `name`, `permissions`, `phone`, `social_security`, `address`, `note`, `payment_method`, `notification`) VALUES
(7, '$2y$10$r.rN3LZGT9AghxNPQlhPKOl09A4h68xV2GZ1nupF1xL9VLexy35Ca', 'admin@mail.com', 'admin', 63, '342-343-3433', '$2y$10$cm8kfGOV.Z3aUl3VYSE79.D9/.hyKVno926cmtEIGVKxqd9xePw8a', '34 Green StSINY10314', '', 'Check', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checks`
--
ALTER TABLE `checks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clock_in_clock_out`
--
ALTER TABLE `clock_in_clock_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gross`
--
ALTER TABLE `gross`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retiree`
--
ALTER TABLE `retiree`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_deduction`
--
ALTER TABLE `tax_deduction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checks`
--
ALTER TABLE `checks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
