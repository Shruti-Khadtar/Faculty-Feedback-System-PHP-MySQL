-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2024 at 01:57 PM
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
-- Database: `ffs`
--

-- --------------------------------------------------------

--
-- Table structure for table `alogin`
--

CREATE TABLE `alogin` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alogin`
--

INSERT INTO `alogin` (`id`, `username`, `password`) VALUES
(1, 'Admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subjects` varchar(500) NOT NULL,
  `year` enum('i','ii','iii','iv') DEFAULT NULL,
  `sem` enum('i','ii','iii','iv','v','vi','vii','viii') NOT NULL DEFAULT 'v'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `name`, `subjects`, `year`, `sem`) VALUES
(6569, 'Pranita Jadhav', 'Orgnaizational Behaviour, Digital Logic and Microproccessor, Data Structures and application', 'ii', 'iii'),
(6570, 'Sapna Barphe', 'Web Technology, Object Oriented Pprograming with C++', 'ii', 'iv'),
(6571, 'Suvarna Thakur', 'Software Engineering, Human Computer and Interaction', 'iii', 'v'),
(6572, 'Karan Korpe', 'Computer Networks and internetworking Protocol', 'iii', 'v'),
(6573, 'Pranita Jadhav', 'Programming in Java', 'iii', 'v'),
(6574, 'Ekta Meshram', 'Network Management', 'iii', 'v'),
(6575, 'Sadhana Hivre', 'Graph Theory', 'iii', 'v');

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
  `id` int(255) NOT NULL,
  `year` enum('i','ii','iii','iv') NOT NULL,
  `sem` enum('i','ii','iii','iv','v','vi','vii','viii') NOT NULL,
  `faculty_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `q1` enum('1','2','3','4','5') NOT NULL,
  `q2` enum('1','2','3','4','5') NOT NULL,
  `q3` enum('1','2','3','4','5') NOT NULL,
  `q4` enum('1','2','3','4','5') NOT NULL,
  `q5` enum('1','2','3','4','5') NOT NULL,
  `q6` enum('1','2','3','4','5') NOT NULL,
  `q7` enum('1','2','3','4','5') NOT NULL,
  `q8` enum('1','2','3','4','5') NOT NULL,
  `q9` enum('1','2','3','4','5') NOT NULL,
  `q10` enum('1','2','3','4','5') NOT NULL,
  `q11` enum('1','2','3','4','5') NOT NULL,
  `q12` enum('1','2','3','4','5') NOT NULL,
  `total` varchar(255) NOT NULL,
  `percent` varchar(5) NOT NULL,
  `roll` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feeds`
--

INSERT INTO `feeds` (`id`, `year`, `sem`, `faculty_id`, `name`, `subject`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `q10`, `q11`, `q12`, `total`, `percent`, `roll`) VALUES
(1, 'iii', 'v', '6574', 'Ekta Meshram', 'Network Management', '3', '4', '5', '5', '4', '3', '2', '3', '4', '5', '3', '4', '45', '75', '2230331246508'),
(2, 'iii', 'v', '6572', 'Karan Korpe', 'Computer Networks and Internetworking Protocol', '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', '36', '60', '2230331246506'),
(3, 'ii', 'iii', '6570', 'Sapna Barphe', 'Object Oriented paradigm with C++', '3', '4', '5', '1', '2', '3', '4', '5', '4', '3', '2', '1', '37', '61.66', '2330331246506'),
(4, 'iii', 'v', '6574', 'Ekta Meshram', 'Network Management', '3', '4', '2', '1', '5', '3', '4', '2', '3', '4', '5', '1', '37', '61.66', '2230331246506'),
(5, 'iii', 'v', '6569', 'Pranita Jadhav', 'Programming in Java', '4', '3', '2', '5', '3', '4', '2', '1', '3', '4', '5', '2', '38', '63.33', '2230331246506'),
(6, 'ii', 'iv', '6569', 'Pranita Jadhav', 'Orgnaizational Behaviour', '3', '4', '3', '3', '3', '4', '3', '3', '4', '3', '4', '2', '39', '65', '2330331246506'),
(7, 'iii', 'v', '6571', 'Suvarna Thakur', 'Software Engineering', '3', '1', '2', '3', '4', '5', '4', '3', '2', '1', '2', '3', '33', '55', '2230331246515'),
(16, 'iii', 'v', '6571', 'Suvarna Thakur', 'Software Engineering', '5', '3', '2', '3', '4', '1', '3', '4', '2', '3', '4', '3', '37', '61.66', '2230331246506');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(255) NOT NULL,
  `question` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question`) VALUES
(1, '1. Has a Teacher covered entire syllabus as prescribe by University/Collage/Board?'),
(2, '2. Has a Teacher covered relevant topic beyond syllabus?'),
(3, '3. Effectiveness of Teacher interms of </br>a. Technical and Course Content'),
(4, 'b. Communication Skill'),
(5, 'c. Use of Teaching Aids'),
(6, '4. Base on which contents were covered.'),
(7, '5. Motivation and Inspiration for Students to learn.'),
(8, '6. Support for Development of Students to Learn: </br>i) Practical Demonstration'),
(9, 'ii) Hands on Training'),
(10, '7. Clarity of Expectations of Students.'),
(11, '8. Student Feedback provided on Students Progress.'),
(12, '9. Willingness to offer help and advice to Students.');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(255) NOT NULL,
  `name` varchar(500) NOT NULL,
  `year` enum('i','ii','iii','iv') NOT NULL,
  `roll` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `subjects` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `year`, `roll`, `email`, `subjects`, `password`) VALUES
(1, 'Shruti Khadtar', 'iii', '2230331246506', 'shrutikhadtar00@gmail.com', 'Software Engineering, Computer Networks and internetworking Protocol, Programming in Java, Network Management', 'Shruti'),
(2, 'Bhakti Waje', 'iii', '2230331246515', 'bhaktiwaje2@gmail.com', 'Software Engineering, Human Computer and Interaction, Computer Networks and internetworking Protocol, Network Management', 'Bhakti515'),
(3, 'Shridhar Naidu', 'iii', '2230331246507', 'shridhar00@gmail.com', 'Software Engineering, Human Computer and Interaction, Computer Networks and internetworking Protocol, Network Management', 'Shridhar507'),
(4, 'Sangameshwar Gurushette', 'iii', '2230331246505', 'sangam03@gmail.com', 'Software Engineering, Computer Networks and Internetworking Protoco, Programming in Java, Network Management', 'Sangam505'),
(5, 'Shruti Khadtar', 'ii', '2330331246506', 'shruti00@gmail.com', 'Orgnaizational Behaviour, Data Structures and application, Web Technology, Object Oriented Pprograming with C++', 'Shruti00');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(255) NOT NULL,
  `sem` enum('i','ii','iii','iv','v','vi','vii','viii') NOT NULL,
  `subject_code` varchar(500) NOT NULL,
  `course_title` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `sem`, `subject_code`, `course_title`) VALUES
(1, 'iii', '', 'Object Oriented paradigm with C++'),
(2, 'v', '', 'Network Management'),
(3, 'v', '', 'Data Visualization'),
(4, 'v', '', 'Graph Theory'),
(5, 'v', '', 'Programming in Java'),
(6, 'v', '', 'Human Computer and Interaction'),
(7, 'iii', '', 'Data Structures and Application'),
(8, 'iv', '', 'Organizational Behavior'),
(9, 'iv', '', 'Discrete Mathematics'),
(10, 'iv', '', 'Digital Logic and Microprocessor '),
(11, 'iv', '', 'Web Technology'),
(12, 'iv', '', 'Constitution of India '),
(13, 'v', '', 'Software Engineering'),
(14, 'v', '', 'Computer Networks and Internetworking Protocol');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alogin`
--
ALTER TABLE `alogin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alogin`
--
ALTER TABLE `alogin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
