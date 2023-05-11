-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2023 at 08:33 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin-id` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mobile_no` bigint(10) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `password` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin-id`, `name`, `mobile_no`, `mail`, `password`) VALUES
('AD01', 'Mihir', 9898989898, 'mihirathod25@gmail.com', '62b23be5d29dfe26e6fb0d97b12a82b9'),
('AD02', 'karan', 8989898989, 'karanpatel23@gmail.com', '15c4a354a743205e762aaa71aec4ff02');

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `operator-id` varchar(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Mobile_no` bigint(10) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`operator-id`, `Name`, `Mobile_no`, `Email`, `Password`) VALUES
('OP01', 'Mihir Rathod', 9537071342, 'mihirathod25@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
('OP02', 'Baburao Aapte', 9562316489, 'mihirathod5@gmail.com', '250cf8b51c773f3f8dc8b4be867a9a02'),
('OP03', 'Karan Patel', 9537071346, 'karanpatel23@gmail.com', '68053af2923e00204c3ca7c6a3150cf7'),
('OP04', 'Kishan Talaviya', 6895421300, 'mihirathod2525@gmail.com', '68053af2923e00204c3ca7c6a3150cf7');

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE `parking` (
  `Operator` varchar(10) NOT NULL,
  `floor` int(1) NOT NULL,
  `slot_no` int(9) NOT NULL,
  `vh_no` varchar(10) NOT NULL,
  `mobile_no` bigint(15) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `entrytime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`Operator`, `floor`, `slot_no`, `vh_no`, `mobile_no`, `mail`, `entrytime`) VALUES
('OP01', 0, 12, 'GJ05AB5005', 6000000001, 'mihirathod25@gmail.com', '2023-05-09 18:17:28'),
('OP01', 1, 100, 'GJ01MH4567', 6000000017, 'mihirathod25@gmail.com', '2023-05-09 18:18:02'),
('OP01', 1, 2, 'MH01AA7777', 9994512368, 'mihirathod25@gmail.com', '2023-05-09 18:18:58'),
('OP01', 2, 60, 'RJ05AN1234', 9598500065, 'mihirathod25@gmail.com', '2023-05-09 18:19:32');

-- --------------------------------------------------------

--
-- Table structure for table `parking_data`
--

CREATE TABLE `parking_data` (
  `entry_operator` varchar(10) NOT NULL,
  `exit_operator` varchar(10) NOT NULL,
  `slot_no` int(9) NOT NULL,
  `vh_no` varchar(10) NOT NULL,
  `mobile_no` bigint(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `entrytime` datetime NOT NULL,
  `exittime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `floor` int(5) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parking_data`
--

INSERT INTO `parking_data` (`entry_operator`, `exit_operator`, `slot_no`, `vh_no`, `mobile_no`, `email`, `entrytime`, `exittime`, `floor`, `price`) VALUES
('OP01', 'OP02', 4, 'GJ05AS6968', 6000000000, 'kp@gmail.com', '2023-05-05 14:06:50', '2023-05-05 08:38:25', 0, '25.00'),
('OP01', 'OP02', 9, 'GJ07AC8080', 6000000000, 'patelkaran8402@gmail.com', '2023-05-05 14:09:57', '2023-05-05 10:22:53', 0, '25.00'),
('OP01', 'OP02', 7, 'GJ05MK6969', 6000000000, 'chamailahera@gmail.com', '2023-05-05 14:11:33', '2023-05-05 10:24:10', 0, '25.00'),
('OP01', 'OP02', 24, 'GJ05AB5000', 9338453905, 'patelkaran8402@gmail.com', '2023-05-05 16:22:26', '2023-05-05 10:55:01', 0, '25.00'),
('OP01', 'OP02', 24, 'GJ05AB5000', 9438453907, 'patelkaran8402@gmail.com', '2023-05-05 16:26:02', '2023-05-05 10:56:40', 0, '25.00'),
('OP01', 'OP02', 24, 'GJ05AB5000', 9327453907, 'patelkaran8402@gmail.com', '2023-05-05 16:27:41', '2023-05-05 10:59:23', 0, '25.00'),
('OP01', 'OP02', 6, 'MH01GJ0005', 6000000000, 'patelkaran8402@gmail.com', '2023-05-05 14:17:51', '2023-05-05 11:00:00', 2, '50.00'),
('OP01', 'OP02', 8, 'GJ05ER0969', 6000000000, 'patelkaran8402@gmail.com', '2023-05-05 14:17:23', '2023-05-05 11:00:54', 1, '50.00'),
('OP01', 'OP02', 24, 'GJ05AB5000', 9327453907, 'patelkaran8402@gmail.com', '2023-05-05 22:02:30', '2023-05-05 16:38:47', 0, '25.00'),
('OP01', 'OP02', 24, 'GJ05AB5000', 9338453905, 'patelkaran8402@gmail.com', '2023-05-06 13:48:55', '2023-05-06 08:19:46', 0, '25.00'),
('OP03', 'OP02', 77, 'GJ05AB5005', 6300000000, 'mihirathod25@gmail.com', '2023-05-06 08:52:13', '2023-05-06 08:24:58', 0, '125.00'),
('OP01', 'OP02', 8, 'GJ05AB5000', 6000000000, 'mihirathod25@gmail.com', '2023-05-09 23:47:08', '2023-05-09 18:21:04', 0, '25.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin-id`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`operator-id`);

--
-- Indexes for table `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`entrytime`);

--
-- Indexes for table `parking_data`
--
ALTER TABLE `parking_data`
  ADD PRIMARY KEY (`exittime`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
