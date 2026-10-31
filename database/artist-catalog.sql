-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260422.e3a1824fe4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 31, 2026 at 07:46 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `artist-catalog`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id` int NOT NULL,
  `artist_id` int DEFAULT NULL,
  `artist_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created` datetime DEFAULT NULL,
  `created_by` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `artist_id`, `artist_name`, `name`, `thumb`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 1, 'Chế Linh', 'Hòn vọng phu', 'honvongphu.jpg', 'active', '2026-10-23 00:00:00', 'dat123', '2026-10-23 00:00:00', 'admin'),
(2, 1, 'Chế Linh', 'Đêm Hoang', 'demhoang.jpg', 'active', '2026-10-23 00:00:00', 'dat123', '2026-10-23 00:00:00', 'admin'),
(7, 10, 'Duy Khánh', 'Tiếng Hát Duy Khánh', 'Md9Cr82H7z.jpg', 'active', '2026-10-31 00:00:00', 'admin', NULL, NULL),
(8, 10, 'Duy Khánh', 'Những ngày xưa thân ái', 'JdsaZ3476c.jpg', 'active', '2026-10-31 00:00:00', 'admin', '2026-10-31 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `id` int NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created` datetime DEFAULT NULL,
  `created_by` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`id`, `name`, `thumb`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Chế Linh', 'chelinh.jpg', 'active', '2026-10-23 00:00:00', 'dat123', '2026-10-23 00:00:00', 'admin'),
(2, 'Quang Lê', 'quangle.jpg', 'active', '2026-10-23 00:00:00', 'dat123', '2026-10-23 00:00:00', 'admin'),
(3, 'Thu Minh', 'thuminh.jpg', 'active', '2026-10-23 00:00:00', 'dat123', '2026-10-23 00:00:00', 'admin'),
(4, 'TLinh', 'tlinh.jpg', 'active', '2026-10-23 00:00:00', 'dat123', '2026-10-23 00:00:00', 'admin'),
(10, 'Duy Khánh', 'NdMyoYEG79.jpg', 'active', '2026-10-31 00:00:00', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE `tracks` (
  `id` int NOT NULL,
  `album_id` int DEFAULT NULL,
  `album_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `audio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created` datetime DEFAULT NULL,
  `created_by` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`id`, `album_id`, `album_name`, `name`, `audio`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 1, 'Hòn vọng phu', 'Hòn vọng phu 01', 'hon-vong-phu-01.mp3', 'active', '2026-10-23 00:00:00', 'dat123', '2026-10-23 00:00:00', 'admin'),
(2, 1, 'Hòn vọng phu', 'Xóm đêm', 'xom-dem.mp3', 'active', '2026-10-23 00:00:00', 'dat123', '2026-10-23 00:00:00', 'admin'),
(3, 2, 'Đêm Hoang', 'Áo Đẹp Nàng Dâu', 'ao-dep-nang-dau.mp3', 'active', '2026-10-23 00:00:00', 'dat123', '2026-10-23 00:00:00', 'admin'),
(4, 2, 'Đêm Hoang', 'Con Đường Xưa Em Đi', 'con-duong-xua-em-di.mp3', 'active', '2026-10-23 00:00:00', 'dat123', '2026-10-28 00:00:00', 'admin'),
(19, 7, 'Tiếng Hát Duy Khánh', 'Xin anh giữ chọn tình quê', 'xin-anh-giu-tron-tinh-quemp3-1793430260.mp3', 'active', '2026-10-31 00:00:00', 'admin', NULL, NULL),
(20, 7, 'Tiếng Hát Duy Khánh', 'Một Mai Giã Từ Vũ Khí', 'mot-mai-gia-tu-vu-khimp3-1793430271.mp3', 'active', '2026-10-31 00:00:00', 'admin', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_album_artist` (`artist_id`);

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tracks_album` (`album_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `fk_album_artist` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `fk_tracks_album` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
