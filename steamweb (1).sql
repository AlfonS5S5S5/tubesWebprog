-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 03:49 PM
-- Server version: 11.1.2-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `steamweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE `block` (
  `block_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `block_reason` varchar(30) NOT NULL,
  `block_status` varchar(20) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `block`
--

INSERT INTO `block` (`block_id`, `user_id`, `block_reason`, `block_status`) VALUES
(2, 1, 'Racist', 'ACCEPTED');

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `game_id` int(11) NOT NULL,
  `game_name` varchar(30) NOT NULL,
  `game_genre` varchar(30) NOT NULL,
  `game_developer` varchar(20) NOT NULL,
  `game_release_date` date NOT NULL,
  `game_price` int(11) NOT NULL,
  `game_supported_os` varchar(10) NOT NULL,
  `game_type` varchar(20) NOT NULL,
  `game_picture` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`game_id`, `game_name`, `game_genre`, `game_developer`, `game_release_date`, `game_price`, `game_supported_os`, `game_type`, `game_picture`) VALUES
(1, 'Apex Legends', 'Shooter', 'EA', '2023-11-20', 60000, 'Windows 10', 'Multiplayer', 'apex.jpg'),
(2, 'Counter Strike', 'Shooter', 'Valve', '2022-07-15', 30000, 'Windows 11', 'Multiplayer', 'cs.png'),
(3, 'F1 24', 'Racing', 'EA', '2024-01-05', 15000, 'Windows 11', 'Singleplayer', 'f1.jpeg'),
(4, 'Dota 2', 'MOBA', 'Valve', '2013-07-09', 20000, 'Windows 10', 'Multiplayer', 'dota2.jpg'),
(5, 'Cyberpunk 2077', 'RPG', 'CD Projekt', '2020-12-10', 75000, 'Windows 10', 'Singleplayer', 'cyberpunk2077.jpg'),
(6, 'Baldur\'s Gate 3', 'RPG', 'Larian Studios', '2023-08-03', 89000, 'Windows 10', 'Singleplayer', 'bg3.jpg'),
(7, 'Stardew Valley', 'Simulation', 'ConcernedApe', '2016-02-26', 12000, 'Windows 10', 'Singleplayer', 'stardew.jpg'),
(8, 'The Witcher 3', 'RPG', 'CD Projekt', '2015-05-18', 60000, 'Windows 10', 'Singleplayer', 'witcher3.jpg'),
(9, 'Terraria', 'Adventure', 'Re-Logic', '2011-05-16', 10000, 'Windows 10', 'Multiplayer', 'terraria.jpg'),
(10, 'Elden Ring', 'Action', 'FromSoftware', '2022-02-25', 75000, 'Windows 11', 'Singleplayer', 'eldenring.jpg'),
(11, 'Left 4 Dead 2', 'Shooter', 'Valve', '2009-11-17', 20000, 'Windows 10', 'Multiplayer', 'l4d2.jpg'),
(12, 'Sea of Thieves', 'Adventure', 'Rare', '2018-03-20', 65000, 'Windows 10', 'Multiplayer', 'seaofthieves.jpg'),
(13, 'Hades', 'Roguelike', 'Supergiant Games', '2020-09-17', 25000, 'Windows 10', 'Singleplayer', 'hades.jpg'),
(14, 'Phasmophobia', 'Horror', 'Kinetic Games', '2020-09-18', 40000, 'Windows 10', 'Multiplayer', 'phasmophobia.jpg'),
(15, 'It Takes Two', 'Adventure', 'Hazelight Studios', '2021-03-26', 55000, 'Windows 11', 'Multiplayer', 'ittakestwo.jpg'),
(16, 'Among Us', 'Party', 'Innersloth', '2018-11-16', 10000, 'Windows 10', 'Multiplayer', 'amongus.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `library_status` varchar(20) DEFAULT 'NOT INSTALLED',
  `library_buy_game_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`user_id`, `game_id`, `library_status`, `library_buy_game_price`) VALUES
(1, 1, 'INSTALLED', 60000),
(1, 4, 'INSTALLED', 0),
(1, 7, 'NOT INSTALLED', 12000),
(3, 2, 'INSTALLED', 30000),
(3, 5, 'NOT INSTALLED', 75000),
(3, 9, 'INSTALLED', 10000),
(5, 1, 'NOT INSTALLED', 60000),
(5, 2, 'NOT INSTALLED', 30000),
(5, 3, 'NOT INSTALLED', 15000),
(5, 4, 'NOT INSTALLED', 0),
(5, 6, 'NOT INSTALLED', 89000),
(5, 7, 'INSTALLED', 89000),
(5, 12, 'INSTALLED', 65000),
(6, 1, 'NOT INSTALLED', 60000),
(6, 2, 'NOT INSTALLED', 30000),
(6, 3, 'NOT INSTALLED', 15000),
(6, 4, 'NOT INSTALLED', 0),
(6, 8, 'NOT INSTALLED', 60000);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `review_text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `game_id`, `review_text`) VALUES
(1, 1, 1, 'Ugly game, not recommended, black man developer'),
(2, 1, 4, 'Classic MOBA, never gets old.'),
(3, 3, 2, 'Best tactical shooter out there.'),
(4, 3, 9, 'Fun and creative, great to play with friends.'),
(5, 5, 6, 'One of the best RPGs I\'ve ever played.'),
(6, 5, 12, 'Great pirate adventure with amazing co-op gameplay.'),
(9, 3, 2, 'game nya jelek');

-- --------------------------------------------------------

--
-- Table structure for table `topup`
--

CREATE TABLE `topup` (
  `topup_id` int(11) NOT NULL,
  `topup_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `topup_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topup`
--

INSERT INTO `topup` (`topup_id`, `topup_date`, `user_id`, `topup_quantity`) VALUES
(1, '2024-04-01', 1, 50000),
(2, '2024-04-02', 3, 20000),
(3, '2024-04-03', 5, 150000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_wallet` int(10) DEFAULT 0,
  `user_block_status` varchar(10) NOT NULL DEFAULT 'UNBLOCKED',
  `user_profile_picture` varchar(200) DEFAULT NULL,
  `user_role` varchar(30) NOT NULL DEFAULT 'MEMBER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_wallet`, `user_block_status`, `user_profile_picture`, `user_role`) VALUES
(1, 'member1', '32250170a0dca92d53ec9624f336ca24', 50000, 'UNBLOCKED', NULL, 'MEMBER'),
(2, 'admin1', '25e4ee4e9229397b6b17776bfceaf8e7', NULL, 'UNBLOCKED', NULL, 'ADMIN'),
(3, 'member2', '73a054cc528f91ca1bbdda3589b6a22d', 20000, 'BLOCKED', 'Images/userProfile/Alfons.jpg', 'MEMBER'),
(4, 'admin2', '8b478e5c89442c1e054b49e2c3814e9e', 0, 'UNBLOCKED', NULL, 'ADMIN'),
(5, 'alfonsGaming', 'da26f30d97cd676a721b33cde6c3e1ce', 1327270, 'UNBLOCKED', 'Images/userProfile/â€”Pngtreeâ€”the black hole in space_448838.png', 'MEMBER'),
(6, 'alfons', '8b6bc5d8046c8466359d3ac43ce362ab', 25000, 'UNBLOCKED', NULL, 'MEMBER');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `wishlist_date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`user_id`, `game_id`, `wishlist_date_added`) VALUES
(1, 2, '2025-04-10'),
(1, 5, '2025-04-11'),
(1, 8, '2025-04-12'),
(1, 10, '2025-04-13'),
(1, 13, '2025-04-14'),
(3, 4, '2025-04-11'),
(3, 7, '2025-04-12'),
(5, 5, '2025-04-11'),
(5, 8, '2025-05-27'),
(5, 10, '2025-04-13'),
(5, 15, '2025-04-14'),
(6, 2, '2025-05-18'),
(6, 6, '2025-05-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`block_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`user_id`,`game_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `topup`
--
ALTER TABLE `topup`
  ADD PRIMARY KEY (`topup_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`user_id`,`game_id`),
  ADD KEY `game_id` (`game_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `block`
--
ALTER TABLE `block`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `topup`
--
ALTER TABLE `topup`
  MODIFY `topup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `block`
--
ALTER TABLE `block`
  ADD CONSTRAINT `block_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `library`
--
ALTER TABLE `library`
  ADD CONSTRAINT `library_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `library_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topup`
--
ALTER TABLE `topup`
  ADD CONSTRAINT `topup_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
