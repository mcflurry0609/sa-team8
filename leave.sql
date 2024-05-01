-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-05-01 16:57:38
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
(50, '411401229', 'D741201584', 2, '2024-05-14', 'D5', 'sss', 'uploads/測試用文件test.pdf', '2024-05-01 11:34:04', '已批准'),
(51, '411401229', 'D741202222', 1, '2024-05-02', 'D2D3', 'test', 'uploads/測試用文件test.pdf', '2024-05-01 21:33:23', '已拒絕'),
(52, '411401229', 'D741202457', 1, '2024-05-08', 'D2D3D4', 'test', 'uploads/測試用文件test.pdf', '2024-05-01 22:27:13', '審核中');

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
  `notice` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `aon` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_class`, `notice`, `aon`) VALUES
('D740202632', '管理數學', '資管二', '這是管理數學的請假規則', 0),
('D740209514', '電子商務', '資管二', '這是電子商務的請假規則', 0),
('D740219411', '雲端應用程式設計', '資管二', '這是雲端應用程式設計的請假規則', 0),
('D741201584', '系統分析與設計', '資管二甲', '這是系統分析與設計的請假規則', 0),
('D741202222', '統計學', '資管二甲', '這是統計學的請假規則', 0),
('D741202457', '經濟學', '資管二甲', '這是經濟學的請假規則', 0),
('D741202492', '資料結構', '資管二甲', '這是資料結構的請假規則', 0),
('D741202795', '導師時間', '資管二甲', '這是導師時間的請假規則', 0),
('D741210681', '資料通訊與網路', '資管二甲', '這是資料通訊與網路的請假規則', 0),
('D742202457', '經濟學', '資管二乙', '這是經濟學的請假規則', 0),
('D742202795', '導師時間', '資管二乙', '這是導師時間的請假規則', 0),
('DATP203638F', '羽球', '體育二以上必', '這是羽球的請假規則', 0),
('DFTEN00772I', '日文', 'FT-非英文', '這是日文的請假規則', 0),
('DNAO123456', '測試不給請假課程', '不給請假', '', 1),
('DSTM800530', '企業成敗個案探討', '管理類', '這是企業成敗個案探討的請假規則', 0);

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
('0002', 'D741202492'),
('0003', 'D741210681'),
('0004', 'D741202222'),
('0005', 'D740209514'),
('0005', 'D741202457'),
('0006', 'DFTEN00772I'),
('0007', 'D740209514'),
('0008', 'DSTM800530'),
('0009', 'DATP203638F'),
('0010', 'D740219411'),
('0011', 'D740202632'),
('0012', 'DNAO123456');

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
('411401085', 'D740202632'),
('411401085', 'D740209514'),
('411401085', 'D740219411'),
('411401085', 'D741201584'),
('411401085', 'D741202222'),
('411401085', 'D741202457'),
('411401085', 'D741202492'),
('411401085', 'D741210681'),
('411401085', 'D742202795'),
('411401085', 'DNAO123456'),
('411401229', 'D740209514'),
('411401229', 'D740219411'),
('411401229', 'D741201584'),
('411401229', 'D741202222'),
('411401229', 'D741202457'),
('411401229', 'D741202492'),
('411401229', 'D741202795'),
('411401229', 'D741210681'),
('411401229', 'DATP203638F'),
('411401229', 'DFTEN00772I'),
('411401229', 'DNAO123456'),
('411401229', 'DSTM800530');

-- --------------------------------------------------------

--
-- 資料表結構 `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` bigint(20) NOT NULL,
  `course_id` varchar(11) NOT NULL,
  `weekday_id` int(2) NOT NULL,
  `period` varchar(10) NOT NULL,
  `week` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `course_id`, `weekday_id`, `period`, `week`) VALUES
(1, 'D740209514', 1, 'D5', 0),
(2, 'D740209514', 1, 'D6', 0),
(3, 'D740209514', 1, 'D7', 0),
(4, 'DFTEN00772I', 1, 'D3', 0),
(5, 'DFTEN00772I', 1, 'D4', 0),
(6, 'D741210681', 2, 'D2', 0),
(7, 'D741210681', 2, 'D3', 0),
(8, 'D741210681', 2, 'D4', 0),
(9, 'D741202457', 3, 'D2', 0),
(10, 'D741202457', 3, 'D3', 0),
(11, 'D741202457', 3, 'D4', 0),
(12, 'D742202457', 4, 'D5', 0),
(13, 'D742202457', 4, 'D6', 0),
(14, 'D742202457', 4, 'D7', 0),
(15, 'D741201584', 2, 'D5', 0),
(16, 'D741201584', 2, 'D6', 0),
(17, 'D741201584', 2, 'D7', 0),
(18, 'D741202795', 3, 'D5', 1),
(19, 'D741202795', 3, 'D6', 1),
(20, 'D742202795', 3, 'D5', 2),
(21, 'D742202795', 3, 'D6', 2),
(22, 'D741202222', 4, 'D2', 0),
(23, 'D741202222', 4, 'D3', 0),
(24, 'D741202222', 4, 'D4', 0),
(25, 'DATP203638F', 5, 'D3', 0),
(26, 'DATP203638F', 5, 'D4', 0),
(27, 'D740202632', 5, 'D2', 0),
(28, 'D740202632', 5, 'D3', 0),
(29, 'D740202632', 5, 'D4', 0),
(30, 'D740219411', 5, 'DN', 0),
(31, 'D740219411', 5, 'D5', 0),
(32, 'D740219411', 5, 'D6', 0),
(40, 'DSTM800530', 1, 'D1', 0),
(41, 'DSTM800530', 1, 'D2', 0),
(42, 'D741202492', 4, 'D5', 0),
(43, 'D741202492', 4, 'D6', 0),
(44, 'D741202492', 4, 'D7', 0),
(45, 'DNAO123456', 6, 'D4', 0),
(46, 'DNAO123456', 6, 'DN', 0);

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
('0008', '0000', '國安民', '教授'),
('0009', '0000', '陳冠旭', '教授'),
('0010', '0000', '黃懷陞', '教授'),
('0011', '0000', '鄭美娟', '教授'),
('0012', '0000', '不給請假教授', '教授'),
('411401085', '0000', '朱唯綸', '學生'),
('411401229', '12345678', '林亨奕', '學生');

-- --------------------------------------------------------

--
-- 資料表結構 `weekdays`
--

CREATE TABLE `weekdays` (
  `weekday_id` int(2) NOT NULL,
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
  MODIFY `application_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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

--
-- 資料表的限制式 `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
