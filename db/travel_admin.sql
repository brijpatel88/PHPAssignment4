-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 17, 2026 at 07:31 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `owner_uid` int(11) DEFAULT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT 1,
  `category` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_mode` varchar(20) NOT NULL DEFAULT 'card',
  `notes` varchar(255) DEFAULT NULL,
  `expense_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `trip_id`, `owner_uid`, `is_private`, `category`, `title`, `amount`, `payment_mode`, `notes`, `expense_date`, `created_at`) VALUES
(1, 1, NULL, 1, 'Stay', 'Hotel', 10.00, 'card', NULL, '2026-02-07', '2026-02-07 03:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` int(11) NOT NULL,
  `owner_uid` int(11) DEFAULT NULL,
  `created_by_aid` int(11) DEFAULT NULL,
  `created_by_role` enum('user','agent') NOT NULL DEFAULT 'user',
  `is_user_editable` tinyint(1) NOT NULL DEFAULT 1,
  `destination` varchar(150) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `trip_type` varchar(30) NOT NULL DEFAULT 'Solo',
  `currency` varchar(10) NOT NULL DEFAULT 'USD',
  `budget` int(11) NOT NULL DEFAULT 0,
  `spent` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `owner_uid`, `created_by_aid`, `created_by_role`, `is_user_editable`, `destination`, `start_date`, `end_date`, `trip_type`, `currency`, `budget`, `spent`, `created_at`) VALUES
(1, NULL, NULL, 'user', 1, 'AHmedabad', '2026-02-06', '2026-02-06', 'Solo', 'USD', 10, 0, '2026-02-07 00:41:50'),
(2, NULL, NULL, 'user', 1, 'Toronto', '2026-02-16', '2026-02-19', 'Solo', 'USD', 1000, 0, '2026-02-14 01:02:37'),
(3, 1, 1, 'agent', 0, 'Ahmedabad', '2026-02-16', '0006-02-19', 'Solo', 'USD', 1000, 0, '2026-02-14 01:05:49'),
(4, 1, NULL, 'user', 1, 'Ahmedabad', '2026-02-14', '2026-02-16', 'Solo', 'USD', 10, 0, '2026-02-14 01:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `email` varchar(180) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','agent','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_id` (`trip_id`),
  ADD KEY `owner_uid` (`owner_uid`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_uid` (`owner_uid`),
  ADD KEY `created_by_aid` (`created_by_aid`);

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
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `fk_expenses_trip` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
