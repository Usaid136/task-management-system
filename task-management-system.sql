-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2026 at 07:04 AM
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
-- Database: `task-management-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT 'No description',
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `status`, `priority`, `due_date`, `created_at`, `updated_at`) VALUES
(11, 11, 'Setup project structure', 'Create folders and basic architecture for the project', 'completed', 'high', '2026-05-01', '2026-05-04 05:01:53', '2026-05-04 05:01:53'),
(12, 11, 'Design database schema', 'Create tables for users and tasks with proper relations', 'completed', 'high', '2026-05-02', '2026-05-04 05:01:53', '2026-05-04 05:01:53'),
(13, 11, 'Build authentication system', 'Implement login, signup, and session handling', 'completed', 'high', '2026-05-03', '2026-05-04 05:01:53', '2026-05-04 05:01:53'),
(14, 11, 'Create task CRUD system', 'Add, edit, delete and view tasks functionality', 'completed', 'high', '2026-05-04', '2026-05-04 05:01:53', '2026-05-04 05:01:53'),
(15, 11, 'Fix navbar active state', 'Highlight active page link dynamically in navbar', 'completed', 'medium', '2026-05-05', '2026-05-04 05:01:53', '2026-05-04 05:01:53'),
(16, 11, 'Improve responsive UI', 'Make dashboard mobile friendly using Bootstrap', 'pending', 'medium', '2026-05-10', '2026-05-04 05:01:53', '2026-05-04 05:01:53'),
(17, 11, 'Add form validation', 'Validate task inputs before inserting into database', 'pending', 'high', '2026-05-12', '2026-05-04 05:01:53', '2026-05-04 05:01:53'),
(18, 11, 'Implement flash messages', 'Show success and error messages after actions', 'completed', 'medium', '2026-05-06', '2026-05-04 05:01:53', '2026-05-04 05:01:53'),
(19, 11, 'Add task search feature', 'Allow users to search tasks by title or status', 'pending', 'low', '2026-05-15', '2026-05-04 05:01:53', '2026-05-04 05:01:53'),
(20, 11, 'Optimize database queries', 'Improve performance and reduce redundant queries', 'in_progress', 'medium', '2026-05-18', '2026-05-04 05:01:53', '2026-05-04 05:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(11, 'M.Usaid', 'usaid@example.com', '$2y$10$MB8l7FPdihsB2MukqpZS1.Vy3ZrVZBwjm/xvUgIO1nntxiLuWFLQe', '2026-05-04 04:56:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
