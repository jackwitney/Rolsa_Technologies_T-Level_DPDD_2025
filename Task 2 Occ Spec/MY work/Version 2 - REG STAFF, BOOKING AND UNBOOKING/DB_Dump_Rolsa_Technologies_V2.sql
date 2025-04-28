-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 01, 2025 at 11:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rolsa_technologies`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adm_id` int NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `adm_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adm_id`, `email_address`, `password`, `adm_type`) VALUES
(3, 'steve@rtech.co.uk', '$2y$10$gEsv/Zq1V/cFyatqImQ8HuEhjRvegknQY9237uGPef8q6f022JCTW', 'super'),
(5, 'Sbeve@rtech.co.uk', '$2y$10$it8uS568tLF6aF7Sv5wUzOCYvHb1Dt20OJ2xazd0S.z1IEbACOiPG', 'admin'),
(6, 'Sleve@rtech.co.uk', '$2y$10$7KIDbRIxAvDkmVcOdPYgsu.qNDHOvQCnG7epqNJE2826wpKNr1b9a', 'priv user');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int NOT NULL,
  `user_id` int NOT NULL,
  `staff_id` int NOT NULL,
  `date` int NOT NULL,
  `product` varchar(255) NOT NULL,
  `type_of_booking` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `staff_id`, `date`, `product`, `type_of_booking`) VALUES
(1, 3, 8, 1743676800, 'Solar Panels', 'INSTALLER'),
(3, 3, 9, 1743416160, 'Heat Pump', 'CONSULTANT'),
(4, 3, 10, 1743418800, 'Insulation', 'MAINTENANCE');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` text NOT NULL,
  `sname` text NOT NULL,
  `specialty` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `email_address`, `password`, `fname`, `sname`, `specialty`) VALUES
(8, 'Installedtest@rtech.co.uk', '$2y$10$K5RlBK8/enO0ki4.33HZwevpKKr93cm0HWniTBNOMcNKxKsa5QP.O', 'Installer', 'Test', 'INSTALLER'),
(9, 'ConsultantTest@rtech.co.uk', '$2y$10$prpECQLfySCxSlntjMRq0OyEnw/ncTdlrNWbTVffpaeTtyNfDOfH6', 'Consultant', 'Test', 'CONSULTANT'),
(10, 'MaintenanceTest@rtech.co.uk', '$2y$10$Abh0XyJ2lwyL151hAVx8WuBRdoZcwdPhrkCUMbW7jQEP7Nd1ccQcm', 'Maintenance', 'Test', 'MAINTENANCE');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `email_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fname` text NOT NULL,
  `sname` text NOT NULL,
  `addressln1` varchar(255) NOT NULL,
  `addressln2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `phone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email_address`, `password`, `fname`, `sname`, `addressln1`, `addressln2`, `city`, `postcode`, `phone`) VALUES
(3, 'seiko5@gmail.com', '$2y$10$GCwsSNlaNUGkNTnFQtB/l.VC8uUBQn7bToM4bkGvhMTg0Dcj0/SYq', 'Seiko', 'Five', 'Seiko Village', 'Chase Spring', 'Nagasaki', 'BS-HS2', '123456789'),
(5, 'Bantams@yahoo.com', '$2y$10$vYFwBaO9IN/i9rJxSHz/R./aHXCow1CW9CTmeGX34vB5xKUryujt6', 'Billy', 'Bantam', 'Valley Parade', 'Midland Road', 'Bradford', 'BD8 7DY', '123456789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`,`staff_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `adm_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
