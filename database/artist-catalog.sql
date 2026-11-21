-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260422.e3a1824fe4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2026 at 06:56 AM
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
(1, 'Chế Linh', 'chelinh.jpg', 'active', '2026-10-23 00:00:00', 'dat123', '2026-11-17 00:00:00', 'admin'),
(2, 'Quang Lê', 'quangle.jpg', 'active', '2026-10-23 00:00:00', 'dat123', '2026-11-17 00:00:00', 'admin'),
(3, 'Thu Minh', 'thuminh.jpg', 'active', '2026-10-23 00:00:00', 'dat123', '2026-11-17 00:00:00', 'admin'),
(4, 'TLinh', 'tlinh.jpg', 'active', '2026-10-23 00:00:00', 'dat123', '2026-11-17 00:00:00', 'admin'),
(10, 'Duy Khánh', 'LskYA6jaBX.jpg', 'active', '2026-10-31 00:00:00', 'admin', '2026-11-17 00:00:00', 'admin'),
(11, 'Bạch Tuyết', 'MUYc5IINke.jpg', 'active', '2026-11-21 00:00:00', 'admin', NULL, NULL),
(12, 'Lệ Thủy', 'mTKLYAAiEl.jpg', 'active', '2026-11-21 00:00:00', 'admin', NULL, NULL),
(13, 'Thanh Sang', '1g7R7PzL7X.jpg', 'active', '2026-11-21 00:00:00', 'admin', NULL, NULL),
(15, 'Minh Vương', 'gSvgvh5Az9.jpg', 'active', '2026-11-21 00:00:00', 'admin', '2026-11-21 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `artist_genre`
--

CREATE TABLE `artist_genre` (
  `artist_id` int NOT NULL,
  `genre_id` int NOT NULL,
  `artist_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genre_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artist_genre`
--

INSERT INTO `artist_genre` (`artist_id`, `genre_id`, `artist_name`, `genre_name`) VALUES
(1, 1, 'Chế Linh', 'Nhạc vàng'),
(1, 2, 'Chế Linh', 'Nhạc trữ tình'),
(2, 1, 'Quang Lê', 'Nhạc vàng'),
(2, 2, 'Quang Lê', 'Nhạc trữ tình'),
(3, 3, 'Thu Minh', 'Pop'),
(4, 3, 'TLinh', 'Pop'),
(4, 4, 'TLinh', 'Rap/Hip-hop'),
(10, 1, 'Duy Khánh', 'Nhạc vàng'),
(10, 2, 'Duy Khánh', 'Nhạc trữ tình'),
(10, 5, 'Duy Khánh', 'Nhạc lính'),
(11, 7, 'Bạch Tuyết', 'Cải Lương - Vọng Cổ'),
(12, 7, 'Lệ Thủy', 'Cải Lương - Vọng Cổ'),
(13, 7, 'Thanh Sang', 'Cải Lương - Vọng Cổ'),
(15, 7, 'Minh Vương', 'Cải Lương - Vọng Cổ');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created` datetime DEFAULT NULL,
  `created_by` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`, `description`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Nhạc vàng', 'Nhạc vàng là một dòng nhạc trữ tình, lãng mạn phổ biến tại Việt Nam, có sự kết hợp giữa phong cách tân nhạc và âm điệu dân ca Nam Bộ.', 'active', '2026-11-13 12:47:19', 'admin', '2026-11-14 00:00:00', 'admin'),
(2, 'Nhạc trữ tình', 'Nhạc trữ tình là một thể loại âm nhạc tập trung bộc lộ, mô tả sâu sắc tình cảm, cảm xúc và tâm trạng của con người', 'active', '2026-11-13 12:47:19', 'admin', '2026-11-14 00:00:00', 'admin'),
(3, 'Pop', 'Nhạc Pop (viết tắt của từ Popular music trong tiếng Anh, nghĩa là nhạc đại chúng) là một thể loại âm nhạc thương mại hướng đến số đông khán giả.', 'active', '2026-11-13 12:47:19', 'admin', '2026-11-14 00:00:00', 'admin'),
(4, 'Rap/Hip-hop', 'Rap/Hip-hop là một nền văn hóa nghệ thuật đường phố và một thể loại âm nhạc lớn ra đời vào những năm 1970 tại khu Bronx, thành phố New York, Mỹ, bởi cộng đồng người Mỹ gốc Phi và Mỹ Latinh.', 'active', '2026-11-17 00:00:00', 'admin', '2026-11-17 00:00:00', 'admin'),
(5, 'Nhạc lính', 'Nhạc lính là một dòng nhạc phổ biến tại miền Nam Việt Nam trước năm 1975, chuyên viết về cuộc sống, tâm tư, nỗi niềm và hình ảnh của người lính (chủ yếu là lính Việt Nam Cộng hòa) trong bối cảnh chiến tranh', 'active', '2026-11-13 12:47:19', 'admin', '2026-11-14 00:00:00', 'admin'),
(6, 'Nhạc cổ điển', 'Nhạc cổ điển Tây Phương là một truyền thống nghệ thuật âm nhạc phát triển từ thế kỷ XI cho đến nay, nổi bật bởi cấu trúc phức tạp, tính chuẩn mực và hệ thống ký hiệu âm nhạc chi tiết', 'active', '2026-11-17 00:00:00', 'admin', '2026-11-17 00:00:00', 'admin'),
(7, 'Cải Lương - Vọng Cổ', 'Ca vọng cổ là làn điệu âm nhạc truyền thống đặc trưng của miền Nam Việt Nam, giữ vai trò linh hồn trong nghệ thuật cải lương.\r\n\r\nĐặc điểm của vọng cổ và cải lương\r\n\r\n• Vọng cổ: Làn điệu giàu tính tự sự, sâu lắng, thường dùng để bộc lộ tâm trạng, nỗi niềm hoặc kể chuyện.\r\n• Cải lương: Loại hình sân khấu kết hợp ca hát, diễn xuất, vũ đạo và âm nhạc dân tộc (như đờn ca tài tử, vọng cổ).\r\n• Tân cổ giao duyên: Hình thức kết hợp giữa nhạc tân nhạc và vọng cổ, rất phổ biến trong đời sống âm nhạc đại chúng.', 'active', '2026-11-21 00:00:00', 'admin', NULL, NULL);

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
-- Indexes for table `artist_genre`
--
ALTER TABLE `artist_genre`
  ADD PRIMARY KEY (`artist_id`,`genre_id`),
  ADD KEY `fk_ag_genre` (`genre_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_genres_name` (`name`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Constraints for table `artist_genre`
--
ALTER TABLE `artist_genre`
  ADD CONSTRAINT `fk_ag_artist` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ag_genre` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `fk_tracks_album` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
