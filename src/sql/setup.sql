-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2026 at 06:08 AM
-- Server version: 8.0.45-cll-lve
-- PHP Version: 8.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shabaily_cmss`
--

-- --------------------------------------------------------

--
-- Table structure for table `cmss_media`
--

CREATE TABLE `cmss_media` (
  `media_id` int NOT NULL,
  `url` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_size` double NOT NULL,
  `file_name` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `author_id` int NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cmss_pages`
--

CREATE TABLE `cmss_pages` (
  `page_id` int NOT NULL,
  `author_id` int NOT NULL,
  `template_id` int NOT NULL,
  `url` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `title` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb3_unicode_ci NOT NULL,
  `fields` json DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cmss_reset_hashes`
--

CREATE TABLE `cmss_reset_hashes` (
  `hash` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `expires_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cmss_templates`
--

CREATE TABLE `cmss_templates` (
  `template_id` int NOT NULL,
  `title` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `fields` json NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cmss_users`
--

CREATE TABLE `cmss_users` (
  `user_id` int NOT NULL,
  `email` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(5000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `role` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `firstname` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `surname` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `profile_image_id` int DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cmss_media`
--
ALTER TABLE `cmss_media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `FK_MEDIA_AUTHOR_ID` (`author_id`);

--
-- Indexes for table `cmss_pages`
--
ALTER TABLE `cmss_pages`
  ADD PRIMARY KEY (`page_id`),
  ADD KEY `FK_PAGE_TEMPLATE_ID` (`template_id`),
  ADD KEY `FK_PAGE_AUTHOR_ID` (`author_id`);

--
-- Indexes for table `cmss_templates`
--
ALTER TABLE `cmss_templates`
  ADD PRIMARY KEY (`template_id`),
  ADD KEY `FK_TEMPLATE_AUTHOR_ID` (`author_id`);

--
-- Indexes for table `cmss_users`
--
ALTER TABLE `cmss_users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `FK_PROFILE_IMAGE_ID` (`profile_image_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cmss_media`
--
ALTER TABLE `cmss_media`
  MODIFY `media_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `cmss_pages`
--
ALTER TABLE `cmss_pages`
  MODIFY `page_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `cmss_templates`
--
ALTER TABLE `cmss_templates`
  MODIFY `template_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `cmss_users`
--
ALTER TABLE `cmss_users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
