-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 31, 2024 at 11:20 AM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vitlone_app_db`
--
CREATE DATABASE IF NOT EXISTS `vitlone_app_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `vitlone_app_db`;

-- --------------------------------------------------------

--
-- Table structure for table `abstracts_tbl`
--

CREATE TABLE `abstracts_tbl` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text,
  `author` varchar(250) NOT NULL,
  `published_at` varchar(250) NOT NULL,
  `published_year` int(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `abstracts_tbl`
--

INSERT INTO `abstracts_tbl` (`id`, `title`, `description`, `author`, `published_at`, `published_year`, `user_id`, `created_at`) VALUES
(1, 'A Brief History of Heart', NULL, 'Sagar Kumar', 'The Journal of Urology', 2023, 11, '2023-12-27 15:39:01'),
(2, 'Test', 'Descrt', 'test', 'test', 2023, 11, '2023-12-27 16:05:05'),
(3, 'Repala Abstract', 'Test', 'Rahul Repala', 'Test Evening Vitl', 2023, 11, '2023-12-27 18:49:58'),
(4, 'Abcd', 'Terdt', 'Bcde', 'Aewr', 2021, 11, '2023-12-30 19:12:13'),
(5, 'Hi', 'Description ', 'Sachi', '2012', 2012, 18, '2024-01-18 16:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `files_tbl`
--

CREATE TABLE `files_tbl` (
  `id` int(11) NOT NULL,
  `file_name` text NOT NULL,
  `type` enum('service','abstract') NOT NULL,
  `file_type` enum('file','img') NOT NULL,
  `rec_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `files_tbl`
--

INSERT INTO `files_tbl` (`id`, `file_name`, `type`, `file_type`, `rec_id`) VALUES
(1, 'b9e633c564f510b88f677dd690d75018.jpg', 'abstract', 'img', 1),
(2, '648aceef5ddd9a8a1bf136e947cf795e.pdf', 'abstract', 'file', 1),
(3, 'e8a8907b8e5a47de476112d699a4ba33.png', 'abstract', 'img', 2),
(4, '6743c42d6349db584ac9c159f956551b.pdf', 'abstract', 'file', 2),
(5, 'f1b45aa6ae09c8593bc764a851f9d335.jpg', 'service', 'img', 2),
(6, 'a882f5528257aa974e90b6f7b0ab0432.jpg', 'abstract', 'img', 3),
(7, '67293765e5d98de7c40a3270f6c1b991.pdf', 'abstract', 'file', 3),
(8, 'f6f5d4fb495f636dc785346cbdf5aaa3.jpg', 'service', 'img', 4),
(9, 'c214437bc5a745797121419d3bc5b0c2.png', 'abstract', 'img', 4),
(10, '35ac76e001070851c3d5af363e18e4f8.jpg', 'service', 'img', 5),
(11, '7b50180addc9f473c8b974640896c387.jpg', 'service', 'img', 6),
(12, 'bc17c4bd8dfd2aff18dc6722dd9509c2.jpg', 'service', 'img', 7),
(13, '3902de4ad48a73b34d7cf98624ab3f78.jpg', 'service', 'img', 8),
(14, '14c0be0a3984a970b8286956f0b17906.jpg', 'service', 'img', 9),
(15, 'cf0660e29fd08e1fcd7cdc1f55ffa144.jpg', 'service', 'img', 10),
(16, '4f81aba1b3b195744102562e807ae478.jpg', 'service', 'img', 11),
(17, 'a29707b3b3286d4ac3cfe6616b0b8cea.jpg', 'service', 'img', 12),
(18, 'd21dc0561a6f72c417d43e456105cc48.jpg', 'service', 'img', 13),
(19, 'd5433b23b1366592488d3669130618db.jpg', 'service', 'img', 14),
(20, 'c947267fb6a5eff5abfbf489dec2e074.jpg', 'service', 'img', 15),
(21, 'a109f991a5b95e101d66ac0347395e26.jpg', 'service', 'img', 16),
(22, '7c2deb2fd27cbbacaf2ee89a1d917803.jpg', 'abstract', 'img', 5),
(23, 'e8c22477728c49e5539db2c3d4f1fb36.pdf', 'abstract', 'file', 5),
(24, 'b7b40986a50ba794df70eaf759d193a6.jpeg', 'service', 'img', 17),
(25, '3a07f4702bcce32d1833112d3471a7f4.jpeg', 'service', 'img', 17),
(26, '461581e01a7eedffd0b15e639c769209.jpeg', 'service', 'img', 17),
(27, '1ccd7b0eecb429c7582823cdf9d209a6.png', 'service', 'img', 18);

-- --------------------------------------------------------

--
-- Table structure for table `messages_tbl`
--

CREATE TABLE `messages_tbl` (
  `id` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `to_user` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  `status` enum('delivered','received','read') NOT NULL DEFAULT 'delivered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages_tbl`
--

INSERT INTO `messages_tbl` (`id`, `from_user`, `to_user`, `datetime`, `message`, `status`) VALUES
(1, 8, 11, '2023-12-27 13:10:04', 'Hello Doctor I am Mukesh. Are you available at 9.30AM tomorrow?', 'delivered'),
(2, 8, 11, '2023-12-27 18:26:24', 'Hi there\n', 'delivered'),
(3, 8, 11, '2023-12-27 18:57:25', 'hello', 'delivered'),
(5, 11, 8, '2024-01-03 21:20:03', 'hi', 'delivered'),
(6, 12, 12, '2024-01-07 22:30:03', 'My name is suresh', 'delivered'),
(7, 18, 18, '2024-01-18 16:22:36', 'Hi', 'delivered'),
(8, 8, 18, '2024-01-18 16:23:06', 'Hello', 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `services_tbl`
--

CREATE TABLE `services_tbl` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services_tbl`
--

INSERT INTO `services_tbl` (`id`, `user_id`, `title`, `description`, `created_at`) VALUES
(1, 11, 'Oncology Test', 'Test Description', '2023-12-27 14:52:17'),
(2, 11, 'Rahul Repala', 'Test Service', '2023-12-27 18:47:17'),
(3, 11, 'Consultation ', 'One to One', '2023-12-28 12:46:58'),
(4, 11, 'Consultation', 'Heart', '2023-12-30 19:09:11'),
(5, 6, 'I can do a lot of things', 'We do a lot of things ', '2024-01-10 21:07:44'),
(6, 6, 'I can do a lot of things', 'We do a lot of things ', '2024-01-10 21:07:50'),
(7, 6, 'I can do a lot of things', 'We do a lot of things ', '2024-01-10 21:07:50'),
(8, 6, 'I can do a lot of things', 'We do a lot of things ', '2024-01-10 21:07:50'),
(9, 6, 'I can do a lot of things', 'We do a lot of things ', '2024-01-10 21:07:51'),
(10, 6, 'I can do a lot of things', 'We do a lot of things ', '2024-01-10 21:07:51'),
(11, 6, 'I can do a lot of things', 'We do a lot of things ????', '2024-01-10 21:07:52'),
(12, 6, 'I can do a lot of things', 'We do a lot of things ????', '2024-01-10 21:07:52'),
(13, 6, 'I can do a lot of things', 'We do a lot of things ', '2024-01-10 21:07:52'),
(14, 6, 'I can do a lot of things', 'We do a lot of things', '2024-01-10 21:07:52'),
(15, 6, 'I can do a lot of things', 'We do a lot of things', '2024-01-10 21:07:53'),
(16, 18, 'Test Service ', 'Test Description ', '2024-01-18 16:20:41'),
(17, 3, 'Dermatology', 'Skin Related issues', '2024-01-22 12:40:12'),
(18, 19, 'Test Services', 'No new text is here! That same old placeholder.', '2024-01-22 16:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `id` bigint(20) NOT NULL,
  `name` varchar(120) NOT NULL,
  `profile_img` text,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `state` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `qualification` varchar(120) DEFAULT NULL,
  `description` text,
  `pin` varchar(4) DEFAULT NULL,
  `telephone` text,
  `maps` text,
  `calendly` text,
  `qrcode` text,
  `token` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `resume` text,
  `youtube` text,
  `whatsapp` text,
  `linkedin` text,
  `telegram` text,
  `twitter` text,
  `website` text,
  `smartphone` text,
  `upi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`id`, `name`, `profile_img`, `email`, `phone`, `state`, `city`, `username`, `qualification`, `description`, `pin`, `telephone`, `maps`, `calendly`, `qrcode`, `token`, `created_at`, `resume`, `youtube`, `whatsapp`, `linkedin`, `telegram`, `twitter`, `website`, `smartphone`, `upi`) VALUES
(3, 'Rahul', NULL, 'rahul0597repala@gmail.com', '8801931789', 'Telangana', 'Hyderabad ', 'rahul.repala', '.', '', '1234', NULL, NULL, NULL, 'https://vitl.one/test/be/assets/qrcodes/rahul.repala.png', '5210', '2023-12-28 11:26:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Savyasachi', NULL, 'Kss.5797@gmail.com ', '91809684333', 'Telangana', 'Hyderabad ', 'savyasachi ', 'BTech', NULL, '1234', NULL, NULL, NULL, 'https://vitl.one/test/be/assets/qrcodes/Savyasachi .png', '6186', '2023-12-28 12:30:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Shyam', '02d594d24adb0fe8bf30005ae26cbea3.jpg', 'shyam@naavigo.com', '8096846333', 'Telangana', 'Hyderabad', 'shyam2', 'Mba', '', '4320', NULL, NULL, NULL, 'https://vitl.one/test/be/assets/qrcodes/Shyam2.png', '9606', '2023-12-28 18:55:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Samarth Pandian', NULL, 'p.samarth@gmail.com', '9874566565', 'Odisha', 'Rourkela', 'samarth', 'MCA', NULL, '1234', NULL, NULL, NULL, 'https://vitl.one/test/be/assets/qrcodes/samarth.png', '4098', '2023-12-30 10:35:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Prashanth', NULL, 'prashanthgujjula77@gmail.com ', '1234567890', 'Telangana', 'Karimnagar', 'prashanth', 'Doc', NULL, '1234', NULL, NULL, NULL, 'https://vitl.one/test/be/assets/qrcodes/Prashanth.png', '7072', '2023-12-30 19:01:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '', NULL, '', '9441428837', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7759', '2023-12-30 19:07:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Shyam', NULL, 'shyam@naavigo.com', '9032317427', 'Telangana', 'Hyderabad', 'shyam', 'Doctor for life', NULL, '0146', '+91 9032317427', NULL, NULL, 'https://vitl.one/test/be/assets/qrcodes/Shyam.png', '4601', '2024-01-04 11:29:36', '28406effc0badb1be62898bbd1d6e45a.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Mohan', NULL, 'mohan07091990@gmail.com', '9438164490', 'Odisha', 'Rourkela', 'mohan', 'mbbs', NULL, '1234', NULL, NULL, NULL, 'https://vitl.one/test/be/assets/qrcodes/mohan.png', '9063', '2024-01-07 22:04:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Priyanka ', NULL, 'priyankavasu00@gmail.com', '6360306726', 'Ts', 'Hyd', 'priyanka', 'Mbbs', NULL, '2345', NULL, NULL, NULL, 'https://vitl.one/test/be/assets/qrcodes/priyanka.png', '5429', '2024-01-07 22:13:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Aamer', NULL, 'aamer@gmail.com', '8688448572', 'Telangana ', 'Hyderabad ', 'aamer', 'Btech', NULL, '1290', '8096846333', 'maps.google.com', 'https://calendly.com/teampixeltests/iit-madras-cce-pixeltests-admissions-latika', 'https://vitl.one/test/be/assets/qrcodes/Aamer.png', '7130', '2024-01-18 16:09:03', 'd304f0f0987857c72f1b887359ce4eca.pdf', 'https://youtube.com', '8096846333', 'https://linkedin.com/in/savyasachilive', '8096846333', 'https://Twitter.com/savyasachilive', 'https://naavigo.com', NULL, '9441428839@ybl'),
(19, 'Sagar Kumar Sutar', NULL, '1sagarsutar@gmail.com', '8339042376', 'Odisha', 'Rourkela', 'sagarsutar', 'MBBS', NULL, '1234', '9938850184', 'https://maps.google.com', 'https://calendly.com/sagarkumarsutar/30min', 'https://vitl.one/test/be/assets/qrcodes/sagarsutar.png', '3167', '2024-01-22 14:54:45', '45ecf5d193f3b2909e2691ddf80eb2b7.pdf', 'https://www.youtube.com/channel/UCLNP7j2BgiPiBuzydVngj7w', '8339042376', 'https://www.linkedin.com/in/sagarkumarsutar/', '8339042376', 'https://twitter.com/SagarKumarSutar', NULL, NULL, '8339042376@paytm'),
(22, '', NULL, '', '9248176187', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9778', '2024-01-30 13:10:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'Arjun', NULL, 'arjun.code.99@gmail.com', '6294162181', 'wb', 'falakata', 'arjun', '12', NULL, '1234', NULL, NULL, NULL, 'https://vitl.one/test/be/assets/qrcodes/arjun.png', '3293', '2024-01-30 16:17:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abstracts_tbl`
--
ALTER TABLE `abstracts_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files_tbl`
--
ALTER TABLE `files_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages_tbl`
--
ALTER TABLE `messages_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_tbl`
--
ALTER TABLE `services_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abstracts_tbl`
--
ALTER TABLE `abstracts_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `files_tbl`
--
ALTER TABLE `files_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `messages_tbl`
--
ALTER TABLE `messages_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `services_tbl`
--
ALTER TABLE `services_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
