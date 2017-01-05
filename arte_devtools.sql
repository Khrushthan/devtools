-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 05, 2017 at 09:53 AM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.14-2+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arte.devtools`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE `backup` (
  `backup_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `backup_active` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `backup`
--

INSERT INTO `backup` (`backup_url`, `backup_active`) VALUES
('arte', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vhosts`
--

CREATE TABLE `vhosts` (
  `id` int(11) NOT NULL,
  `vhost_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `server_path` varchar(256) COLLATE utf8_bin NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `vhosts`
--

INSERT INTO `vhosts` (`id`, `vhost_name`, `server_path`, `status`) VALUES
(1, 'arte.devtools', '/var/www/html/arte.devtools', 1),
(2, 'arte.phpmy', '/var/www/http/arte.phpmy', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vhosts`
--
ALTER TABLE `vhosts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vhosts`
--
ALTER TABLE `vhosts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
