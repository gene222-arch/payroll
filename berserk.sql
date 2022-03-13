-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2022 at 05:37 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `berserk`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(1, 'marasigan', '$2y$10$hiozUjhfxGjlD7n8gLmpNOtDXV/Gf5nxx2qOmJQ1aKX1/Ne4VzyxC', 'ronnie', 'marasigan', 'jeff.png', '2018-04-30');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `status` int(1) NOT NULL,
  `time_out` time NOT NULL,
  `num_hr` double NOT NULL,
  `time_in_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `date`, `time_in`, `status`, `time_out`, `num_hr`, `time_in_img`) VALUES
(100, 6, '2021-07-07', '07:26:00', 1, '17:10:00', 8.1666666666667, ''),
(106, 6, '2022-01-03', '07:45:00', 1, '17:01:00', 7, ''),
(108, 6, '2022-01-05', '08:00:00', 1, '17:00:00', 7, ''),
(109, 6, '2022-01-02', '07:45:00', 1, '17:15:00', 7, ''),
(110, 6, '2022-01-04', '08:00:00', 1, '17:40:00', 7, 'data:image/jpeg;base64,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');

-- --------------------------------------------------------

--
-- Table structure for table `cashadvance`
--

CREATE TABLE `cashadvance` (
  `id` int(11) NOT NULL,
  `date_advance` date NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cashadvance`
--

INSERT INTO `cashadvance` (`id`, `date_advance`, `employee_id`, `amount`) VALUES
(2, '2022-01-02', '6', 500);

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `amount` double NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `description`, `amount`, `employee_id`) VALUES
(1, 'SSS', 150, 6),
(2, 'Tax', 100, 6);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `position_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `firstname`, `lastname`, `address`, `birthdate`, `contact_info`, `gender`, `position_id`, `schedule_id`, `photo`, `created_on`) VALUES
(6, 'RNF809754321', 'paul', 'aguilar', 'camp vicente lim', '1999-07-03', '09674400023', 'Male', 4, 1, 'aaaaaaaaaaaaaaa.png', '2021-07-07');

-- --------------------------------------------------------

--
-- Table structure for table `overtime`
--

CREATE TABLE `overtime` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `hours` double NOT NULL,
  `rate` double NOT NULL,
  `date_overtime` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `overtime`
--

INSERT INTO `overtime` (`id`, `employee_id`, `hours`, `rate`, `date_overtime`) VALUES
(1, '6', 1, 40, '2022-01-03');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `description`, `rate`) VALUES
(4, 'lead man', 450);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `time_in`, `time_out`) VALUES
(1, '08:00:00', '16:00:00'),
(2, '09:00:00', '17:00:00'),
(3, '10:00:00', '18:00:00'),
(4, '11:00:00', '19:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE `supervisors` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(252) NOT NULL,
  `firstname` varchar(252) NOT NULL,
  `lastname` varchar(252) NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `contact_info` varchar(252) NOT NULL,
  `gender` varchar(252) NOT NULL,
  `photo` varchar(252) NOT NULL,
  `created_on` date NOT NULL,
  `password` varchar(252) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supervisors`
--

INSERT INTO `supervisors` (`id`, `employee_id`, `firstname`, `lastname`, `address`, `birthdate`, `contact_info`, `gender`, `photo`, `created_on`, `password`) VALUES
(40430, '2022-40430', 'Jane', 'Doe', '123 Test', '2000-01-08', '09998765432', 'Female', 'FB_IMG_1585855531439.jpg', '2022-01-04', '$2y$10$wCWQ8QpYcx.dB0oEcfkKa.hwtDoipTC0emVXRVRbF.V2R8aGXcnCC'),
(40431, '2022-40431', 'John', 'Doe', '123 Test', '2000-08-01', '09987654321', 'Male', 'FB_IMG_1585978367241.jpg', '2022-01-04', '$2y$10$KH9nn7u8gugxvoyQL2GlaONpDvN4GKNzGrGuSRhChkOqPS9P4xDn2'),
(40432, '2022-40432', 'Alexander', 'Blair', '123 Test', '2000-08-08', '09976543219', 'Male', '', '2022-01-04', '$2y$10$5ce5rpGNieeU2F708o0ReOk5xUUxfoSEYnDXgz6LFjWOKjjSfzobC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashadvance`
--
ALTER TABLE `cashadvance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `cashadvance`
--
ALTER TABLE `cashadvance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40433;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
