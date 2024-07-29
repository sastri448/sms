-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2024 at 04:34 PM
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
-- Database: `user_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_of_joining` date NOT NULL,
  `blood_group` varchar(3) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_name`, `designation`, `date_of_birth`, `date_of_joining`, `blood_group`, `mobile`, `email`, `address`) VALUES
(1, 'peri sastri', 'Manager', '1985-06-15', '2010-01-15', 'O+', '1234567890', 'a@example.com', '123 Main City'),
(2, 'sasi', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'b@example.com', '456 Cillage city'),
(3, 'test1', 'Manager', '1985-06-15', '2010-01-15', 'O+', '1234567890', 'test1@example.com', 'test1 add'),
(4, 'test2', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test2@example.com', 'test2 add'),
(5, 'test3', 'Manager', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test3@example.com', 'test3 add'),
(6, 'test4', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test4@example.com', 'test4 add'),
(7, 'test5', 'Manager', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test5@example.com', 'test5 add'),
(8, 'test6', 'Manager', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test6@example.com', 'test6 add'),
(9, 'test7', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test7@example.com', 'test7 add'),
(10, 'test8', 'Manager', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test8@example.com', 'test8 add'),
(11, 'test9', 'Manager', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test9@example.com', 'test9 add'),
(12, 'test10', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test10@example.com', 'test10 add'),
(13, 'test11', 'Sr Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test11@example.com', 'test11 add'),
(14, 'test12', 'Jr Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test12@example.com', 'test12 add'),
(15, 'test13', 'QA', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test13@example.com', 'test13 add'),
(16, 'test14', 'QA', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test14@example.com', 'test14 add'),
(17, 'test15', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test15@example.com', 'test15 add'),
(18, 'test16', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test16@example.com', 'test16 add'),
(19, 'test17', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test17@example.com', 'test17 add'),
(20, 'test18', 'QA', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test18@example.com', 'test18 add'),
(21, 'test19', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test19@example.com', 'test19 add'),
(22, 'test20', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test20@example.com', 'test20 add'),
(23, 'test21', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test210@example.com', 'test210 add'),
(24, 'test22', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test222@example.com', 'test222 add'),
(25, 'test23', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test233@example.com', 'test233 add'),
(26, 'test24', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test2555@example.com', 'test2555 add'),
(27, 'test25', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test233@example.com', 'test233 add'),
(28, 'test26', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test2d@example.com', 'test2d add'),
(29, 'test27', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test2ddd@example.com', 'test2ddd add'),
(30, 'test28', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test2dddee@example.com', 'test2dddee add'),
(31, 'test29', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test2dddeee@example.com', 'test2dddeee add'),
(32, 'test30', 'Developer', '1990-09-21', '2012-03-22', 'A-', '0987654321', 'test2dd@example.com', 'test2dd add');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role_id`, `mobile`, `email`, `address`, `gender`, `date_of_birth`, `profile_picture`, `signature`, `username`, `password`, `approved`) VALUES
(1, 'super admin', 1, '9640069041', 'a@gmail.com', '#12, Munjeru, Bhogapuram, vizianagaram', 'Male', '2024-07-28', NULL, 'peri', 'superadmin', '$2y$10$ynVI6ZDHhFZuRYOIiBb1aesqgiWoidmtiFQHwmRFjXpVrNJ6ZsGlW', 1),
(7, 'admin', 2, '9640069042', 'b@gmail.com', '#12, Munjeru, Bhogapuram, vizianagaram', 'Male', '2024-07-29', '', 'sastri', 'admin', '$2y$10$q.X9FoRW0bvJWVG1epEIh.hYPwUKevvXu65s2dqmhHipSOQlVIcTG', 1),
(8, 'user', 3, '9640069043', 'c@gmail.com', '#12, Munjeru, Bhogapuram, vizianagaram', 'Male', '2024-07-30', '', 'peri sastri', 'user', '$2y$10$f9huwCshhwvgsEm5/Zdq2.7J1TEh8yme9bQQ4A7358FbDIwGgOrE2', 1),
(10, 'user4', 3, '9640069044', 'd@gmail.com', '#12, Munjeru, Bhogapuram, vizianagaram', 'Male', '2024-07-28', NULL, 'penumetsa', 'user4', '$2y$10$I.ppnCl.hpgwDk0jWKRCW.XcXVWX/skIFtbnDaIV9SEo6TxkK.vSa', 0),
(11, 'user3', 3, '9640069048', 'user3@gmail.com', '#12, Munjeru, Bhogapuram, vizianagaram', 'Male', '2024-07-29', '', 'peri sastri penumetsa', 'user3', '$2y$10$ITdLLTnyMZvJO.AWXtdpJuZFh7NGiowrlyRABUBgYnzcQQVjuZArK', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
