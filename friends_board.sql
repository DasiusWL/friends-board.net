-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2025 at 01:03 AM
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
-- Database: `friends_board`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `event_time` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `creator_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `creator_id`, `created_at`, `location`) VALUES
(6, '2BKI21', 'Klasse 2BKI21', 9, '2025-03-25 19:20:02', 'Mannheim'),
(7, 'Leaver Deaver', 'I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE I HATE', 6, '2025-03-25 23:04:48', 'Rostock'),
(8, '123', '123', 10, '2025-03-25 23:49:57', '123'),
(9, '123', '123', 11, '2025-03-25 23:50:38', '123');

-- --------------------------------------------------------

--
-- Table structure for table `group_memberships`
--

CREATE TABLE `group_memberships` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(4, 'vargazoltan', 'vargazoli.03@hotmail.com', '$2y$10$Yk2fI0lJUAWXkFt8b/FjKOsCDW0RB.el5VjmI43vNGFGKbXQ.znMO', '2025-03-20 13:07:01'),
(6, 'test1', 'vargazoli.454@gmail.com', '$2y$10$Gy/EpxJpnFRqkj0BqnEv/.aO7Ku6Uk36Zvx7MFnap5K9sD9oZmgs.', '2025-03-20 13:37:32'),
(9, '123', '123@gmail.com', '$2y$10$HNQ8o4P/6peCBGZsykKnou/JzE3ET72cZ5SJhXlH6AbcqLBv2w2Iy', '2025-03-25 19:18:55'),
(10, 'hushroom', 'lmao@gmail.com', '$2y$10$Sn64fTn0O3h9El5Qq15t0uZvARnywIzb7kg.KbPg1q3u4vNfR/Hdm', '2025-03-25 23:49:49'),
(11, 'Dasius', 'cash@gmail.com', '$2y$10$jzyvkteBL9EVAxNEq8.VKeRqQm4/z/J2k.LIsYI9luN84ux/Sp7LG', '2025-03-25 23:50:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- Indexes for table `group_memberships`
--
ALTER TABLE `group_memberships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `group_memberships`
--
ALTER TABLE `group_memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_memberships`
--
ALTER TABLE `group_memberships`
  ADD CONSTRAINT `group_memberships_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_memberships_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
