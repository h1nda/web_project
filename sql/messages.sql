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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `qid` varchar(256) NOT NULL,
  `uid` varchar(256) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `text` text NOT NULL,
  `sender_status` enum('owner','student') NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT 0,
  `sid` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`qid`, `uid`, `timestamp`, `text`, `sender_status`, `private`, `sid`) VALUES
('64eea0f83a119', '5000', '2023-08-30 02:03:27', 'Public message!', 'student', 0, 'bo50dll611cj9bgka38vldccvs'),
('64eea0f83a119', '3000', '2023-08-30 02:03:41', 'Private message...', 'student', 1, 'c9m6rfsll1bu1gcnmvv5ctp2l8'),
('64eea0f83a119', '5000', '2023-08-30 02:03:56', 'Public message!', 'student', 0, 'bo50dll611cj9bgka38vldccvs'),
('64eea0f83a119', '3000', '2023-08-30 02:04:06', 'Private message..', 'student', 1, 'c9m6rfsll1bu1gcnmvv5ctp2l8'),
('64eea0f83a119', '3000', '2023-08-30 02:16:46', 'Private message', 'student', 1, 'fuarqbt6i55gtg9b4di97lqrqu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD KEY `fk_mid` (`qid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_mid` FOREIGN KEY (`qid`) REFERENCES `queue_info` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
