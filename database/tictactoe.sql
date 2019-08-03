-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2019 at 08:59 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tictactoe`
--

-- --------------------------------------------------------

--
-- Table structure for table `game_session`
--

CREATE TABLE `game_session` (
  `id` int(10) NOT NULL,
  `sid` varchar(100) NOT NULL COMMENT 'Session ID',
  `r11` varchar(10) DEFAULT NULL,
  `r12` varchar(10) DEFAULT NULL,
  `r13` varchar(10) DEFAULT NULL,
  `r21` varchar(10) DEFAULT NULL,
  `r22` varchar(10) DEFAULT NULL,
  `r23` varchar(10) DEFAULT NULL,
  `r31` varchar(10) DEFAULT NULL,
  `r32` varchar(10) DEFAULT NULL,
  `r33` varchar(10) DEFAULT NULL,
  `p1_turn` varchar(10) NOT NULL,
  `p2_turn` varchar(10) NOT NULL,
  `p1_engage` varchar(10) DEFAULT NULL,
  `p2_engage` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `game_session`
--

INSERT INTO `game_session` (`id`, `sid`, `r11`, `r12`, `r13`, `r21`, `r22`, `r23`, `r31`, `r32`, `r33`, `p1_turn`, `p2_turn`, `p1_engage`, `p2_engage`) VALUES
(35, '5d459f861a11c', 'p1', NULL, 'p1', 'p2', 'p2', 'p2', 'p1', NULL, NULL, 'yes', 'no', 'yes', 'yes'),
(36, '5d45d3377ab96', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', 'no', 'yes', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game_session`
--
ALTER TABLE `game_session`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sid` (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game_session`
--
ALTER TABLE `game_session`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
