-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 11, 2024 at 03:50 PM
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
-- Database: `cathub`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` varchar(150) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `comment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `author_id`, `post_id`, `content`, `is_deleted`, `comment_date`) VALUES
(130, 14, 10, 'Laudantium enim quasi es…am sapiente accusantium.', 0, '2024-01-23 12:41:29'),
(131, 14, 8, 'Quo vero reiciendis velit similique earum.', 0, '2024-01-23 12:41:58'),
(132, 11, 10, 'Quia molestiae reprehend epturi deleniti ratione.', 0, '2024-01-23 12:42:37'),
(133, 11, 4, 'Non et atque occaecati …m deleniti ut occaecati.', 0, '2024-01-23 12:42:59'),
(134, 11, 5, 'Harum non quasi et ratio…voluptates magni quo et.', 0, '2024-01-23 12:44:12'),
(135, 12, 10, 'Doloribus at sed quis cu…s aspernatur dolorem in.', 0, '2024-01-23 12:44:40'),
(136, 12, 7, 'Maiores sed dolores simi…ia quia et magnam dolor.', 0, '2024-01-23 12:45:10'),
(137, 13, 8, 'Ut voluptatem corrupti uia aliquid ullam eaque.', 0, '2024-01-23 12:46:31'),
(138, 10, 9, 'Sapiente assumenda moles quas enim ipsam minus.', 0, '2024-01-23 12:47:42'),
(139, 10, 5, 'Voluptate iusto quis nob… accusamus nisi facilis.', 0, '2024-01-23 12:48:06'),
(141, 15, 11, 'comment', 0, '2024-01-23 17:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `reactions` int(11) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `image_url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `title`, `description`, `reactions`, `is_deleted`, `create_date`, `image_url`) VALUES
(4, 14, 'Sunt aut facere repellat provident occaecati excepturi optio reprehenderit', 'Quia et suscipit suscipit recusandae consequuntur expedita et cum reprehenderit molestiae ut ut quas totam nostrum rerum est autem sunt rem eveniet architecto.', 2, 0, '2024-01-23 12:30:15', '/cathub/media/images/65afa34742053.jpg'),
(5, 12, 'Qui est esse', 'Est rerum tempore vitae sequi sint nihil reprehenderit dolor beatae ea dolores neque fugiat blanditiis voluptate porro vel nihil molestiae ut reiciendis qui aperiam non debitis possimus qui neque nisi nulla.', 2, 0, '2024-01-23 12:31:15', '/cathub/media/images/65afa383d9649.jpeg'),
(6, 13, 'Ea molestias quasi exercitationem repellat qui ipsa sit aut', 'Et iusto sed quo iure voluptatem occaecati omnis eligendi aut ad voluptatem doloribus vel accusantium quis pariatur molestiae porro eius odio et labore et velit aut.', 3, 0, '2024-01-23 12:32:38', '/cathub/media/images/65afa3d6d4d93.jpeg'),
(7, 11, 'Eum et est occaecati', 'Ullam et saepe reiciendis voluptatem adipisci sit amet autem assumenda provident rerum culpa quis hic commodi nesciunt rem tenetur doloremque ipsam iure quis sunt voluptatem rerum illo velit.', 1, 0, '2024-01-23 12:33:51', '/cathub/media/images/65afa41f0d51f.jpg'),
(8, 10, 'Nesciunt quas odio', 'Repudiandae veniam quaerat sunt sed alias aut fugiat sit autem sed est voluptatem omnis possimus esse voluptatibus quis est aut tenetur dolor neque.', 2, 0, '2024-01-23 12:36:13', '/cathub/media/images/65afa4baa54e4.jpg'),
(9, 12, 'Dolorem eum magni eos aperiam quia', 'Ut aspernatur corporis harum nihil quis provident sequi mollitia nobis aliquid molestiae perspiciatis et ea nemo ab reprehenderit accusantium quas voluptate dolores velit et doloremque molestiae.', 1, 0, '2024-01-23 12:37:41', '/cathub/media/images/65afa505df7e2.jpg'),
(10, 10, 'Magnam facilis autem', 'Dolore placeat quibusdam ea quo vitae magni quis enim qui quis quo nemo aut saepe quidem repellat excepturi ut quia sunt ut sequi eos ea sed quas.', 5, 0, '2024-01-23 12:38:53', '/cathub/media/images/65afa54dcc323.jpg'),
(11, 15, 'test', 'test 2', 0, 1, '2024-01-23 17:11:10', ''),
(12, 11, 'test', 'test post', 0, 1, '2024-01-24 14:15:12', '/cathub/media/images/65b10d605ffaa.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `post_user_reaction`
--

CREATE TABLE `post_user_reaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `reaction_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_user_reaction`
--

INSERT INTO `post_user_reaction` (`id`, `user_id`, `post_id`, `reaction_date`) VALUES
(9, 10, 4, '2024-01-23 12:39:27'),
(10, 10, 5, '2024-01-23 12:39:29'),
(11, 10, 6, '2024-01-23 12:39:33'),
(12, 10, 9, '2024-01-23 12:39:37'),
(13, 11, 4, '2024-01-23 12:39:56'),
(14, 11, 6, '2024-01-23 12:39:59'),
(16, 12, 10, '2024-01-23 12:40:17'),
(17, 12, 8, '2024-01-23 12:40:21'),
(18, 12, 7, '2024-01-23 12:40:28'),
(19, 13, 10, '2024-01-23 12:40:37'),
(20, 13, 8, '2024-01-23 12:40:41'),
(21, 13, 5, '2024-01-23 12:40:44'),
(22, 14, 10, '2024-01-23 12:40:58'),
(23, 14, 6, '2024-01-23 12:41:04'),
(25, 15, 10, '2024-01-23 17:10:35'),
(26, 11, 10, '2024-01-24 14:14:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_admin`, `reg_date`, `is_deleted`, `email`) VALUES
(10, 'test_user_admin', '$2y$10$ib0jZhW1ic9Tl6SxY6RvF.bCp8uHfy1pbOtA1u3/J/mj85m5pJs2G', 1, '2024-01-23 12:03:17', 0, 'test_user_admin@email.com'),
(11, 'test_user_1', '$2y$10$8z1lnXvSR4xxSaWz/3bkYeEaXv6Z7sYh9AGJFRuYDoAkVCtrZzlwW', 0, '2024-01-23 12:03:40', 0, 'test_user_1@email.com'),
(12, 'test_user_2', '$2y$10$V1rDyiAOt1Bc1HahQG5B4uu/gS7Pos4QTT0WXZu4ofBf01q/x9V1a', 0, '2024-01-23 12:04:07', 0, 'test_user_2@email.com'),
(13, 'test_user_3', '$2y$10$hFzc/ByZvPz12os3NPuSH.IXMiajhyWvrDAC1Rm5yxfEEpG4MgFr6', 0, '2024-01-23 12:06:10', 0, 'test_user_3@email.com'),
(14, 'test_user_4', '$2y$10$i3lhqYvkF2tvkTiSQHADZOOAokHDORGy5.vNFJXUoC2GX6A8xYoEW', 0, '2024-01-23 12:06:45', 0, 'test_user_4@email.com'),
(15, 'test_user_5', '$2y$10$0kKxzgFcSADE8qqiDRBoFOXpwfffbNxjA6oiCswY4aofRwcaBVewe', 0, '2024-01-23 17:10:27', 0, 'test_user_5@email.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_ibfk_1` (`author_id`);

--
-- Indexes for table `post_user_reaction`
--
ALTER TABLE `post_user_reaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `post_user_reaction`
--
ALTER TABLE `post_user_reaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `post_user_reaction`
--
ALTER TABLE `post_user_reaction`
  ADD CONSTRAINT `post_user_reaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `post_user_reaction_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
