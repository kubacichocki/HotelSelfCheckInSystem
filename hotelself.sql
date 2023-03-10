-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2023 at 02:35 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotelself`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservation_id`
--

CREATE TABLE `reservation_id` (
  `Reservation_ID` int(50) NOT NULL,
  `Check_in_date` date NOT NULL,
  `Check_out_date` date NOT NULL,
  `user_id` int(10) NOT NULL,
  `room_id` int(50) NOT NULL,
  `Checked_in_date` date NOT NULL,
  `Checked_out_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `Room_ID` int(50) NOT NULL,
  `Room_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Floor` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int(50) NOT NULL,
  `Name` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Phone_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservation_id`
--
ALTER TABLE `reservation_id`
  ADD PRIMARY KEY (`Reservation_ID`),
  ADD UNIQUE KEY `Check_in_date` (`Check_in_date`),
  ADD UNIQUE KEY `Reservation_ID` (`Reservation_ID`),
  ADD UNIQUE KEY `Check_out_date` (`Check_out_date`),
  ADD UNIQUE KEY `dd/mm/yy` (`Checked_in_date`),
  ADD UNIQUE KEY `dd/mm/yyyy` (`Checked_out_date`),
  ADD KEY `Reservation_ID_2` (`Reservation_ID`),
  ADD KEY `Check_in_date_2` (`Check_in_date`),
  ADD KEY `Check_out_date_2` (`Check_out_date`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`Room_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Email Address` (`Email`);
ALTER TABLE `user` ADD FULLTEXT KEY `FullName` (`Name`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation_id`
--
ALTER TABLE `reservation_id`
  ADD CONSTRAINT `Check_in_date` FOREIGN KEY (`Check_in_date`) REFERENCES `reservation_id` (`Checked_in_date`),
  ADD CONSTRAINT `Check_out_date` FOREIGN KEY (`Check_out_date`) REFERENCES `reservation_id` (`Checked_out_date`),
  ADD CONSTRAINT `reservation_id_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`User_ID`),
  ADD CONSTRAINT `reservation_id_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`Room_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
