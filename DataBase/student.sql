-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2024 at 04:37 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(20) NOT NULL,
  `enrollmentNo` varchar(16) NOT NULL,
  `photoName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `enrollmentNo`, `photoName`) VALUES
(6, '230173116012', 'Sign.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `registeration`
--

CREATE TABLE `registeration` (
  `enrollmentNo` varchar(15) NOT NULL,
  `name` text NOT NULL,
  `Address` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(64) NOT NULL,
  `otp` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registeration`
--

INSERT INTO `registeration` (`enrollmentNo`, `name`, `Address`, `email`, `password`, `otp`) VALUES
('230173116001', 'Mahi Patel .G', 'B-2/801;Mota Park;Ahmedabad.', 'shahforam050@gmail.com', '$2y$10$RXbUcEhn1OrUVJ2Ab4jUkO2dUyoQNzIb1QxXUZRlrRdwh0P6ic0bS', 0),
('230173116012', 'SHAH FORAM SANCHESHKUMMAR', 'B-2/801;Rushikesh Residency\r\nChaprabhatta roa', 'shahforam.kep26@gmail.com', '$2y$10$LbjjdMVsV4GH2K6XZxqBLu/doxON272vMl8blhXksXTdg7CdwhjoK', 0),
('230173116018', 'Reeya Patel .G', 'B-2/801;Mota Park;Ahmedabad.', 'Reyya@gmail.com', '$2y$10$sj6TV74..tzJBKWGXz6r6en6G6cm1KTssca0/aXdOgw0y87Um0Wu6', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `taskid` int(11) NOT NULL,
  `enrollmentNo` varchar(15) NOT NULL,
  `task` varchar(255) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`taskid`, `enrollmentNo`, `task`, `Description`, `completed`, `date`) VALUES
(1, '230173116012', 'To go to college', 'To study', 1, '2024-02-28'),
(8, '230173116012', 'To go shopping', 'With Friend I will go To shop Clothes', 0, '2024-02-29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registeration`
--
ALTER TABLE `registeration`
  ADD PRIMARY KEY (`enrollmentNo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`taskid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`enrollmentNo`) REFERENCES `registeration` (`enrollmentNo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
