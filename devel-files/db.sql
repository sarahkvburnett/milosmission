-- phpMyAdmin SQLBuilder Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jan 29, 2021 at 11:55 PM
-- Server version: 10.5.8-MariaDB-1:10.5.8+maria~focal
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `milosmission`
--

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `animal_id` int(11) NOT NULL,
  `animal_name` varchar(255) NOT NULL,
  `animal_type` enum('Cat','Dog') NOT NULL,
  `animal_breed` varchar(255) DEFAULT NULL,
  `animal_colour` varchar(255) DEFAULT NULL,
  `animal_age` int(11) DEFAULT NULL,
  `animal_status` enum('New','Waiting','Rehomed') NOT NULL,
  `animal_image_id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `friend_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `rehoming_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`animal_id`, `animal_name`, `animal_type`, `animal_breed`, `animal_colour`, `animal_age`, `animal_status`, `animal_image_id`, `room_id`, `friend_id`, `owner_id`, `rehoming_id`) VALUES
(1, 'Milo', 'Cat', 'Longhaired moggie', 'Black and White', 13, 'Waiting', 1, 2, 2, NULL, NULL),
(2, 'Misty', 'Cat', 'Shorthaired moggie', 'Grey and White', 12, 'Waiting', 2, 2, 1, NULL, NULL),
(3, 'Cody', 'Dog', 'Border Collie', 'Black and White', 12, 'New', 3, 7, NULL, NULL, NULL),
(16, 'Nala', 'Cat', 'Unknown', 'Tabby', 4, 'New', 13, NULL, NULL, NULL, NULL),
(24, 'misty', 'Cat', 'Jack Russell', 'Tabby', 14, 'Waiting', 23, 11, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `animal_media`
--

CREATE TABLE `animal_media` (
  `animal_media_id` int(11) NOT NULL,
  `animal_id` int(11) DEFAULT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `animal_media`
--

INSERT INTO `animal_media` (`animal_media_id`, `animal_id`, `image_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(7, 1, 4),
(8, 2, 8),
(9, 3, 9),
(10, 3, 10),
(11, 3, 11),
(12, 3, 12),
(13, 16, 13),
(14, 3, 14),
(15, 3, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 2, 20),
(21, 2, 21),
(22, 2, 22);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `media_id` int(11) NOT NULL,
  `media_filename` varchar(255) NOT NULL,
  `media_type` enum('Image','Video') DEFAULT NULL,
  `media_category` varchar(50) DEFAULT NULL,
  `media_subcategory` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`media_id`, `media_filename`, `media_type`, `media_category`, `media_subcategory`) VALUES
(1, 'animals/milo/milo1.jpg', 'Image', 'animals', 'milo'),
(2, 'animals/misty/misty2.jpg', 'Image', 'animals', 'misty'),
(3, 'animals/cody/cody1.jpg', 'Image', 'animals', 'cody'),
(4, 'animals/milo/milo2.jpg', 'Image', 'animals', 'milo'),
(8, 'animals/misty/misty3.jpg', 'Image', 'animals', 'misty'),
(9, 'animals/cody/cody2.jpg', 'Image', 'animals', 'cody'),
(10, 'animals/cody/cody3.jpg', 'Image', 'animals', 'cody'),
(11, 'animals/cody/cody4.jpg', 'Image', 'animals', 'cody'),
(12, 'animals/cody/cody5.jpg', 'Image', 'animals', 'cody'),
(13, 'animals/nala/nala1.jpg', 'Image', 'animals', 'nala'),
(14, 'animals/cody/cody6.jpg', 'Image', 'animals', 'cody'),
(15, 'animals/cody/cody7.jpg', 'Image', 'animals', 'cody'),
(16, 'animals/milo/milo2.jpg', 'Image', 'animals', 'milo'),
(17, 'animals/milo/milo3.jpg', 'Image', 'animals', 'milo'),
(18, 'animals/milo/milo4.jpg', 'Image', 'animals', 'milo'),
(19, 'animals/milo/milo5.jpg', 'Image', 'animals', 'milo'),
(20, 'animals/misty/misty4.jpg', 'Image', 'animals', 'misty'),
(21, 'animals/misty/misty5.jpg', 'Image', 'animals', 'misty'),
(22, 'animals/misty/misty6.jpg', 'Image', 'animals', 'misty'),
(23, 'animals/todd/todd1.jpeg', 'Image', 'animals', 'todd'),
(24, 'animals/todd/todd2.jpeg', 'Image', 'animals', 'todd'),
(25, 'animals/todd/todd3.jpeg', 'Image', 'animals', 'todd'),
(61, '/animals/pexels-josh-hild-2820134.jpg', 'Image', 'animals', 'Milo');

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `owner_id` int(11) NOT NULL,
  `owner_firstname` varchar(155) NOT NULL,
  `owner_lastname` varchar(155) NOT NULL,
  `owner_address` text NOT NULL,
  `owner_postcode` varchar(8) NOT NULL,
  `owner_animal` enum('Cat','Dog') NOT NULL,
  `owner_status` enum('New','Waiting','Rehomed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`owner_id`, `owner_firstname`, `owner_lastname`, `owner_address`, `owner_postcode`, `owner_animal`, `owner_status`) VALUES
(1, 'Sarah', 'Burnett', '67D Magdalen Road', 'EX2 4TA', 'Cat', 'Waiting'),
(2, 'Susan', 'Burnett', '24 Ennismore Green', 'LU2 8UP', 'Cat', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `rehomings`
--

CREATE TABLE `rehomings` (
  `rehoming_id` int(11) NOT NULL,
  `rehoming_date` date NOT NULL,
  `rehoming_status` enum('Pending','Rehomed') NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_type` enum('Cat','Dog') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_type`) VALUES
(1, 'Cat'),
(2, 'Cat'),
(3, 'Cat'),
(4, 'Cat'),
(5, 'Cat'),
(6, 'Cat'),
(7, 'Dog'),
(8, 'Dog'),
(9, 'Dog'),
(10, 'Dog'),
(11, 'Dog'),
(12, 'Dog');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(155) NOT NULL,
  `user_lastname` varchar(155) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_password`) VALUES
(1, 'Sarah', 'Burnett', 'sarahkvburnett@gmail.com', '$2y$10$nuFVXC1EtoBrbUqEUhcShO2D0yMtjiXNiyo/2ULv7krV7SY2XlawK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`animal_id`),
  ADD KEY `animals_ibfk_1` (`room_id`),
  ADD KEY `animals_ibfk_2` (`friend_id`),
  ADD KEY `animals_ibfk_3` (`owner_id`),
  ADD KEY `animals_ibfk_4` (`rehoming_id`);

--
-- Indexes for table `animal_media`
--
ALTER TABLE `animal_media`
  ADD PRIMARY KEY (`animal_media_id`),
  ADD KEY `animal_media_ibfk_1` (`animal_id`),
  ADD KEY `animal_media_ibfk_2` (`image_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `rehomings`
--
ALTER TABLE `rehomings`
  ADD PRIMARY KEY (`rehoming_id`),
  ADD KEY `owner` (`owner_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `animal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `animal_media`
--
ALTER TABLE `animal_media`
  MODIFY `animal_media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rehomings`
--
ALTER TABLE `rehomings`
  MODIFY `rehoming_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
