-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-04-25 09:05:05
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `leave`
--

-- --------------------------------------------------------

--
-- 資料表結構 `applications`
--

CREATE TABLE `applications` (
  `application_id` bigint(20) NOT NULL,
  `user_id` char(10) NOT NULL,
  `course_id` varchar(11) NOT NULL,
  `category_id` int(2) NOT NULL,
  `date` date NOT NULL,
  `periods` varchar(10) NOT NULL,
  `reason` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `doc_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apply_time` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(3) NOT NULL DEFAULT '審核中'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `applications`
--

INSERT INTO `applications` (`application_id`, `user_id`, `course_id`, `category_id`, `date`, `periods`, `reason`, `doc_name`, `apply_time`, `status`) VALUES
(1, '411401085', 'D741210681', 2, '2024-04-24', '', 'aaaaaaaaaa', 'hi.jpg', '2024-04-24 10:28:31', '審核中'),
(2, '411401085', 'DFTEN00772I', 1, '2024-04-21', '', 'bbbbbb', 'hii.jpg', '2024-04-24 10:28:31', '已批准'),
(3, '411401229', 'D741202457', 6, '2024-04-20', '', 'ccccccccccccc', 'cry.jpg', '2024-04-24 10:28:31', '已拒絕'),
(4, '411401229', 'D741201584', 1, '2024-04-23', 'D6D7', 'aaaa', 'test.pdf', '2024-04-24 10:28:31', '已批准'),
(5, '411401085', 'D741201584', 4, '2024-04-24', 'D5D7', '阿阿阿阿阿阿', 'poopoo', '2024-04-25 00:17:26', '已拒絕'),
(6, '411401229', 'D741202795', 6, '2024-04-17', 'D3D4', 'so tired', 'aaaaaaa', '2024-04-25 00:23:08', '已批准');

-- --------------------------------------------------------

--
-- 資料表結構 `category`
--

CREATE TABLE `category` (
  `category_id` int(2) NOT NULL,
  `category_name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, '事假'),
(2, '病假'),
(3, '喪假'),
(4, '生理假'),
(5, '陪產假'),
(6, '心理假'),
(7, '哺育幼兒假');

-- --------------------------------------------------------

--
-- 資料表結構 `courses`
--

CREATE TABLE `courses` (
  `course_id` varchar(11) NOT NULL,
  `course_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `course_class` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `notice` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_class`, `notice`) VALUES
('D740209514', '電子商務', '資管二', 'D740209514'),
('D741201584', '系統分析與設計', '資管二甲', 'D741201584'),
('D741202222', '統計學', '資管二甲', 'D741202222'),
('D741202457', '經濟學', '資管二甲', 'D741202457'),
('D741202468', '經濟學', '資管二乙', 'D741202468'),
('D741202492', '資料結構', '資管二甲', 'D741202492'),
('D741202795', '導師時間', '資管二甲', 'D741202795'),
('D741210681', '資料通訊與網路', '資管二甲', 'D741210681'),
('DFTEN00772I', '日文', 'FT-非英文', 'DFTEN00772I');

-- --------------------------------------------------------

--
-- 資料表結構 `courseteacher`
--

CREATE TABLE `courseteacher` (
  `user_id` char(10) NOT NULL,
  `course_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `courseteacher`
--

INSERT INTO `courseteacher` (`user_id`, `course_id`) VALUES
('0001', 'D741201584'),
('0001', 'D741202795'),
('0003', 'D741210681'),
('0005', 'D740209514'),
('0005', 'D741202457'),
('0005', 'D741202468'),
('0006', 'DFTEN00772I'),
('0007', 'D740209514');

-- --------------------------------------------------------

--
-- 資料表結構 `enrollments`
--

CREATE TABLE `enrollments` (
  `user_id` char(10) NOT NULL,
  `course_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `enrollments`
--

INSERT INTO `enrollments` (`user_id`, `course_id`) VALUES
('411401085', 'D740209514'),
('411401085', 'D741202457'),
('411401085', 'D741202795'),
('411401085', 'D741210681'),
('411401229', 'D741201584'),
('411401229', 'D741202468'),
('411401229', 'D741202795'),
('411401229', 'DFTEN00772I');

-- --------------------------------------------------------

--
-- 資料表結構 `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` bigint(20) NOT NULL,
  `course_id` varchar(11) NOT NULL,
  `weekday` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `period` varchar(10) NOT NULL,
  `week` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `course_id`, `weekday`, `period`, `week`) VALUES
(1, 'D740209514', '週一', 'D5', 0),
(2, 'D740209514', '週一', 'D6', 0),
(3, 'D740209514', '週一', 'D7', 0),
(4, 'DFTEN00772I', '週一', 'D3', 0),
(5, 'DFTEN00772I', '週一', 'D4', 0),
(6, 'D741210681', '週二', 'D2', 1),
(7, 'D741210681', '週二', 'D3', 1),
(8, 'D741210681', '週二', 'D4', 1),
(9, 'D741202457', '週三', 'D2', 0),
(10, 'D741202457', '週三', 'D3', 0),
(11, 'D741202457', '週三', 'D4', 0),
(12, 'D741202468', '週四', 'D5', 2),
(13, 'D741202468', '週四', 'D6', 2),
(14, 'D741202468', '週四', 'D7', 2),
(15, 'D741201584', '週二', 'D5', 0),
(16, 'D741201584', '週二', 'D6', 0),
(17, 'D741201584', '週二', 'D7', 0),
(18, 'D741202795', '週三', 'D5', 0),
(19, 'D741202795', '週三', 'D6', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `user_id` char(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  `user_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`user_id`, `password`, `user_name`, `role`) VALUES
('0001', '0000', '吳濟聰', '教授'),
('0002', '0000', '蔡幸蓁', '教授'),
('0003', '0000', '林青峰', '教授'),
('0004', '0000', '黃曜輝', '教授'),
('0005', '0000', '許嘉霖', '教授'),
('0006', '0000', 'Ishikawa Takao', '教授'),
('0007', '0000', '張銀益', '教授'),
('411401085', '0000', '朱唯綸', '學生'),
('411401229', '12345678', '林亨奕', '學生');

-- --------------------------------------------------------

--
-- 資料表結構 `weekdays`
--

CREATE TABLE `weekdays` (
  `weekday_id` int(1) NOT NULL,
  `weekday` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `weekdays`
--

INSERT INTO `weekdays` (`weekday_id`, `weekday`) VALUES
(1, '週一'),
(2, '週二'),
(3, '週三'),
(4, '週四'),
(5, '週五'),
(6, '週六'),
(7, '週日');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- 資料表索引 `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- 資料表索引 `courseteacher`
--
ALTER TABLE `courseteacher`
  ADD PRIMARY KEY (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- 資料表索引 `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- 資料表索引 `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `course_id` (`course_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- 資料表索引 `weekdays`
--
ALTER TABLE `weekdays`
  ADD PRIMARY KEY (`weekday_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `courseteacher`
--
ALTER TABLE `courseteacher`
  ADD CONSTRAINT `courseteacher_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courseteacher_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
