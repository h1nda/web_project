-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2023 at 05:39 AM
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
-- Database: `fmi_queues`
--

-- --------------------------------------------------------

--
-- Table structure for table `queue_info`
--

CREATE TABLE `queue_info` (
  `id` varchar(256) NOT NULL,
  `user_id` int(11) NOT NULL,
  `link` varchar(1208) NOT NULL,
  `status` enum('closed','open') NOT NULL DEFAULT 'closed',
  `queue_name` varchar(256) NOT NULL,
  `queue_limit` int(11) NOT NULL,
  `entry_method` enum('manual','interval') NOT NULL,
  `interval_time` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue_info`
--

INSERT INTO `queue_info` (`id`, `user_id`, `link`, `status`, `queue_name`, `queue_limit`, `entry_method`, `interval_time`) VALUES
('64ee892f78c64', 1, 'https://teams.microsoft.com/l/meetup-join/19:K1zUvJFv2vRowYQgI3gQw2IRkgppW9N7_eq0FXWak_I1@thread.tacv2/1693242040036?context=%7B%22Tid%22:%2293b0391c-45ad-4e7f-b52b-f1a2ab482711%22,%22Oid%22:%2216a7ff0e-10f7-43c4-9710-3ca95a2dbf29%22%7D', 'closed', 'Consultations', 30, 'interval', 5),
('64eea0f83a119', 3, 'https://teams.microsoft.com/l/meetup-join/19:K1zUvJFv2vRowYQgI3gQw2IRkgppW9N7_eq0FXWak_I1@thread.tacv2/1693242040036?context=%7B%22Tid%22:%2293b0391c-45ad-4e7f-b52b-f1a2ab482711%22,%22Oid%22:%2216a7ff0e-10f7-43c4-9710-3ca95a2dbf29%22%7D', 'open', 'My First Queue', 5, 'interval', 10);

--
-- Triggers `queue_info`
--
DELIMITER $$
CREATE TRIGGER `check_interval_time_null` BEFORE INSERT ON `queue_info` FOR EACH ROW BEGIN
    IF NEW.entry_method = 'interval' AND NEW.interval_time IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'interval_time cannot be null for entry_method "interval"';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `check_interval_time_null_update` BEFORE UPDATE ON `queue_info` FOR EACH ROW BEGIN
    IF NEW.entry_method = 'interval' AND NEW.interval_time IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'interval_time cannot be null for entry_method "interval"';
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `queue_info`
--
ALTER TABLE `queue_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_uid` (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `queue_info`
--
ALTER TABLE `queue_info`
  ADD CONSTRAINT `fk_uid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
