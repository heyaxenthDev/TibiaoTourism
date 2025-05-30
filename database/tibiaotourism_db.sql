-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2025 at 06:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tibiaotourism_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_guests`
--

CREATE TABLE `additional_guests` (
  `id` int(11) NOT NULL,
  `guest_code` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `additional_guests`
--

INSERT INTO `additional_guests` (`id`, `guest_code`, `firstname`, `lastname`, `age`) VALUES
(1, 'guest-71442', 'adas', 'sdsa', 22),
(2, 'guest-71442', 'sadasdf', 'dasdasdsa', 22),
(3, 'guest-71442', 'asdasdsfdas', 'adasfahhjsd', 21);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `profile_picture`, `date_created`) VALUES
(1, 'Hya Cynth Dojillo', 'hyacynthdojillo@gmail.com', '$2y$10$DIgBNto2G/fX01RIv4ynjuMthwUpgo4lLcQsIsDHrtmHztjox4JIi', '', '2024-06-20 13:42:47');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` int(11) NOT NULL,
  `guest_code` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `type_of_stay` varchar(255) NOT NULL,
  `arrival_date_time` timestamp NULL DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `guest_code`, `firstname`, `lastname`, `age`, `email`, `phone`, `type_of_stay`, `arrival_date_time`, `date_created`) VALUES
(1, 'guest-69089', 'Hya Cynth', 'Dojillo', 21, NULL, '09651168472', 'Over Night Stay', '2024-07-07 03:17:54', '2024-07-07 05:05:38'),
(2, 'guest-83177', 'Yangyang', 'Dojillo', 24, NULL, '09610519898', 'Day In', '2024-07-07 03:19:17', '2024-07-07 07:13:12'),
(3, 'guest-69089', 'Hya Cynth', 'Dojillo', 21, NULL, '09651168472', 'Over Night Stay', '2024-07-07 03:17:54', '2024-06-21 05:05:38'),
(4, 'guest-69089', 'Hya Cynth', 'Dojillo', 21, NULL, '09651168472', 'Over Night Stay', '2024-07-07 03:17:54', '2024-07-02 07:17:54'),
(5, 'guest-69089', 'Hya Cynth', 'Dojillo', 21, NULL, '09651168472', 'Over Night Stay', '2024-07-07 03:17:54', '2024-06-21 05:05:38'),
(6, 'guest-69090', 'John', 'Doe', 25, 'johndoe@example.com', '09123456789', 'Day In', '2024-07-03 02:30:00', '2024-07-03 07:20:37'),
(7, 'guest-69091', 'Jane', 'Smith', 30, 'janesmith@example.com', '09876543210', 'Over Night Stay', '2024-07-03 07:45:00', '2024-07-03 07:20:37'),
(8, 'guest-69092', 'Michael', 'Johnson', 28, 'michaeljohnson@example.com', '09567812345', 'Day In', '2024-07-03 04:00:00', '2024-07-03 07:20:37'),
(9, 'guest-69093', 'Emily', 'Brown', 22, 'emilybrown@example.com', '09432187654', 'Over Night Stay', '2024-07-03 09:00:00', '2024-07-03 07:20:37'),
(10, 'guest-69094', 'David', 'Martinez', 35, 'davidmartinez@example.com', '09785634129', 'Day In', '2024-07-03 06:30:00', '2024-07-03 07:20:37'),
(11, 'guest-69095', 'Sophia', 'Garcia', 27, 'sophiagarcia@example.com', '09123456789', 'Over Night Stay', '2024-07-03 08:45:00', '2024-07-03 07:20:37'),
(37, 'guest-85825', 'Kaye', 'Ordovas', 24, NULL, '09651168472', 'Day In', '2024-07-05 05:51:54', '2024-07-05 05:50:11'),
(41, 'guest-38440', 'Hya Cynth', 'Dojillo', 25, NULL, '09651168472', 'Over Night Stay', '2025-02-05 16:17:37', '2025-02-06 15:02:25'),
(42, 'guest-50375', 'asdas', 'sadsad', 24, 'hjsadh@gmail.com', NULL, 'Over Night Stay', '2025-02-05 17:35:51', '2025-02-05 17:35:39'),
(43, 'guest-97834', 'Hya Cynth', 'Dojillo', 24, NULL, '09651168472', 'Over Night Stay', NULL, '2025-02-06 03:05:12'),
(44, 'guest-71442', 'Hya Cynth', 'Dojillo', 24, NULL, '09651168472', 'Over Night Stay', '2025-02-06 03:34:44', '2025-02-06 03:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `guest_destinations`
--

CREATE TABLE `guest_destinations` (
  `id` int(11) NOT NULL,
  `guest_code` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `resort_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guest_destinations`
--

INSERT INTO `guest_destinations` (`id`, `guest_code`, `destination`, `resort_code`) VALUES
(1, 'guest-38440', 'Calawag', ''),
(2, 'guest-38440', 'Blue Wave', ''),
(3, 'guest-38440', 'Campolly Highland Resort', ''),
(4, 'guest-50375', 'La Escapo Mountain Resort ', ''),
(5, 'guest-97834', 'Calawag', ''),
(6, 'guest-71442', 'Calawag', '');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `guest_code` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `current_resort` varchar(255) DEFAULT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `guest_code`, `description`, `status`, `current_resort`, `date_created`) VALUES
(1, 'guest-50375', 'Guest with code guest-50375 has confirmed their arrival.', 'read', NULL, '2025-02-06'),
(2, 'guest-71442', 'Guest with code guest-71442 has confirmed their arrival at .', 'read', '', '2025-02-06'),
(3, 'guest-71442', 'Guest with code guest-71442 has confirmed their arrival at .', 'read', '', '2025-02-06'),
(4, 'guest-71442', 'Guest with code guest-71442 has confirmed their arrival at Calawag.', 'read', 'Calawag', '2025-02-06'),
(5, 'guest-71442', 'Guest with code guest-71442 has confirmed their arrival at .', 'read', '', '2025-02-06'),
(6, 'guest-71442', 'Guest with code guest-71442 has confirmed their arrival at .', 'read', '', '2025-02-06'),
(7, 'guest-71442', 'Guest with code guest-71442 has confirmed their arrival at .', 'read', '', '2025-02-06'),
(8, 'guest-71442', 'Guest with code guest-71442 has confirmed their arrival at .', 'read', '', '2025-02-06'),
(9, 'guest-71442', 'Guest with code guest-71442 has confirmed their arrival.', 'read', NULL, '2025-02-06');

-- --------------------------------------------------------

--
-- Table structure for table `resorts`
--

CREATE TABLE `resorts` (
  `id` int(11) NOT NULL,
  `resort_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `resorts`
--

INSERT INTO `resorts` (`id`, `resort_code`, `name`, `password`, `address`, `date_created`) VALUES
(1, 'resort-41606-1', 'Calawag', '$2y$10$L3Q15zgEWBOqE0OP6ZVJtOFSXxPnA79E9ld7kdQI3NESz0PUVqH46', 'Brgy. Tuno, Tibiao, Antique', '2024-06-21 02:37:52'),
(2, 'resort-74829-2', 'Blue Wave', '', 'Tuno Tibiao Antique', '2024-06-21 03:11:40'),
(3, 'resort-00344-3', 'Campolly Highland Resort', '', 'Sitio Alangan, Barangay Tuno , Antique', '2024-06-22 11:55:01'),
(4, 'resort-24527-4', 'La Escapo Mountain Resort ', '', 'Barangay Tuno, Tibiao, Antique', '2024-06-24 07:17:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_guests`
--
ALTER TABLE `additional_guests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_destinations`
--
ALTER TABLE `guest_destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resorts`
--
ALTER TABLE `resorts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_guests`
--
ALTER TABLE `additional_guests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `guest_destinations`
--
ALTER TABLE `guest_destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `resorts`
--
ALTER TABLE `resorts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
