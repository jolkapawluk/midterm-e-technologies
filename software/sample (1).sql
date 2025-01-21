-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2025 at 10:32 PM
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
-- Database: `sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `name` varchar(255) NOT NULL,
  `date` datetime(6) NOT NULL,
  `description` varchar(255) NOT NULL,
  `tag` varchar(535) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `creator` int(255) NOT NULL,
  `users_participating` varchar(535) NOT NULL,
  `max_places` int(255) NOT NULL,
  `current_places` int(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`name`, `date`, `description`, `tag`, `photo`, `creator`, `users_participating`, `max_places`, `current_places`, `location`, `id`) VALUES
('Volleyball', '2025-01-21 11:00:00.000000', '', 'Sports', 'photos/678eba746debc.jpg', 15, ',16', 100, 1, 'Vilnius Tech Sports Center', 9),
('Book Club', '2025-01-22 12:00:00.000000', 'Calling all book lovers! Join us for an engaging session of the University Book Club, where we dive into thought-provoking discussions, share ideas, and connect over our favorite reads. Whether you\'re a seasoned bookworm or just starting your literary jou', 'Books', 'photos/678ebb621f042.jpg', 15, ',16', 20, 1, 'Vilnius Tech Library', 11),
('International Food Tasting', '2025-01-23 20:30:00.000000', 'Embark on a culinary journey at our International Food Tasting Event! Discover a world of flavors as we showcase delicious dishes from different cultures and cuisines. It’s a celebration of diversity, food, and community—perfect for foodies and culture en', 'Food', 'photos/678ebbdf57198.jpg', 15, ',16', 50, 1, 'Vilnius Tech - SRL Cafeteria', 12),
('Basketball Tournament', '2025-01-25 18:00:00.000000', 'Get ready for some fast-paced action at the University Basketball Tournament! Watch as talented teams bring their A-game to the court, battling it out for victory and glory. It’s a slam dunk event you don’t want to miss!', 'Sports', 'photos/678ebc3f647db.jpg', 15, '', 40, 0, 'Vilnius Tech Sports Center', 13),
('Disco Party', '2025-01-24 23:00:00.000000', 'Get ready to groove and glow at the ultimate University Disco Party! Step into a night of dazzling lights, funky beats, and nonstop dancing. Dress to impress in your best disco-inspired outfit and let the music take you back to the golden era of the dance', 'Music', 'photos/678ebcd8e1325.jpg', 15, '', 200, 0, 'Vilnius Tech SRK Lobby', 14),
('Painting Club', '2025-01-31 17:00:00.000000', 'Unleash your inner artist at the University Painting Club! Whether you’re a seasoned painter or just looking to try something new, join us for a relaxing and inspiring session of creativity. All skill levels are welcome—just bring your passion for art!', 'Arts', 'photos/678ebe2f5a4a6.jpg', 16, '', 10, 0, 'Vilnius Tech Linkmenu Fabrikas', 15),
('New Students Orientation', '2025-09-01 14:00:00.000000', 'Kickstart your university journey at our New Student Orientation! This is your chance to explore campus, meet fellow students, and discover everything you need to make the most of your time here.', 'Music', 'photos/678ebef15e2c1.jpg', 16, '', 300, 0, 'Vilnius Tech Linkmenu Fabrikas', 16);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `faculty` varchar(255) NOT NULL,
  `events_participating` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `faculty`, `events_participating`, `username`, `password`) VALUES
(15, 'Anastasia Stepanova', 'Fundamental Sciences', '', '20223333', '20223333'),
(16, 'Jolanta Pavliukovič', 'Fundamental Sciences', ',11', '20222799', '20222799');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
