-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 15, 2024 at 03:51 AM
-- Server version: 8.0.32
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `college_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `college_id` int NOT NULL,
  `college_name` varchar(255) NOT NULL,
  `college_location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`college_id`, `college_name`, `college_location`) VALUES
(8, 'COEP ', 'pune'),
(9, 'Dr. D. Y. Patil Institute of Technology', 'pune'),
(10, 'SINHGAD COLLEGE', 'PUNE');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int NOT NULL,
  `college_id` int DEFAULT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `college_id`, `course_name`, `course_description`) VALUES
(19, 8, 'Computer Applications and IT', 'Computer Applications and IT'),
(20, 8, 'Engineering and Architecture', 'Engineering and Architecture'),
(21, 8, 'MBA ', 'MBA DESCRIPTION'),
(22, 9, 'Computer Applications and IT	 	 ', 'Computer Applications and IT	 '),
(23, 9, 'Engineering and Architecture', 'Engineering and Architecture'),
(24, 10, 'Computer Engineering', 'Computer Engineering'),
(25, 10, 'Mechanical Engineering', 'Mechanical Engineering'),
(26, 8, 'MCA', 'Describe it some words');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`college_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `college_id` (`college_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `college_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`college_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
