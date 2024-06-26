-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-06-03 13:52:31
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
  `status` varchar(3) NOT NULL DEFAULT '審核中',
  `rejectreason` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `applications`
--

INSERT INTO `applications` (`application_id`, `user_id`, `course_id`, `category_id`, `date`, `periods`, `reason`, `doc_name`, `apply_time`, `status`, `rejectreason`) VALUES
(82, '411401229', 'D741201584', 1, '2024-05-07', 'D5,D6,D7', '請假測試1', 'uploads/測試用文件test.pdf', '2024-05-30 20:43:32', '已批准', ''),
(83, '411401229', 'D741201584', 6, '2024-05-28', 'D5,D6,D7', '請假測試2', 'uploads/20240301103032_13326.png', '2024-05-30 20:47:23', '已拒絕', '不可以這樣喔'),
(84, '411401229', 'D741201584', 2, '2024-05-14', 'D5', '請假測試4', 'uploads/輔仁大學學生請假規則.pdf', '2024-05-30 20:48:52', '審核中', ''),
(85, '411401229', 'DSTM800530', 2, '2024-05-06', 'D1,D2', 'pobolo', 'uploads/螢幕擷取畫面 2024-05-09 102913.png', '2024-05-30 20:53:12', '審核中', ''),
(86, '411401229', 'D741210681', 1, '2024-05-14', 'D2,D3,D4', 'idsjfowied', 'uploads/螢幕擷取畫面 2024-05-12 151252.png', '2024-05-30 20:53:49', '審核中', ''),
(87, '411401229', 'D741202222', 3, '2024-05-30', 'D2,D3', '請假申請6\r\n', 'uploads/螢幕擷取畫面 2024-05-12 151247.png', '2024-05-30 21:24:40', '審核中', ''),
(88, '411401229', 'D741202222', 5, '2024-05-30', 'D2,D3,D4', '請假測試7', 'uploads/螢幕擷取畫面 2024-05-27 093719.png', '2024-05-30 21:28:05', '審核中', ''),
(89, '411401229', 'D741202223', 1, '2024-05-30', 'DN', '真的不想上課欸', 'uploads/螢幕擷取畫面 2024-05-28 152441.png', '2024-05-30 21:33:15', '審核中', ''),
(90, '411401229', 'D741201584', 1, '2024-07-02', 'D5', 'test', 'uploads/螢幕擷取畫面 2024-05-09 102913.png', '2024-06-02 08:55:17', '已拒絕', '已經放暑假囉\r\n'),
(92, '411401229', 'D741201584', 2, '2024-06-04', 'D5,D6,D7', '我想放假', 'uploads/螢幕擷取畫面 2024-05-12 151252.png', '2024-06-02 17:23:56', '已批准', ''),
(93, '411401229', 'D741201584', 1, '2024-05-07', 'D5,D6,D7', '逼播', 'uploads/螢幕擷取畫面 2024-05-28 152441.png', '2024-06-02 17:30:37', '已批准', '');

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
  `aon` int(1) NOT NULL COMMENT '0：未設定 1：允許線上請假 2：1：不允許線上請假',
  `assistant` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_class`, `notice`, `aon`, `assistant`) VALUES
('D740202632', '管理數學', '資管二', 'test', 0, ''),
('D740209514', '電子商務', '資管二', '接受線上請假', 2, ''),
('D740219411', '雲端應用程式設計', '資管二', 'test   ', 0, ''),
('D741201584', '系統分析與設計', '資管二甲', '假別請假規則測試', 1, ''),
('D741202222', '統計學', '資管二甲', '要不要請假都可以喔~', 1, '411401001'),
('D741202223', '統計學實習', '資管二甲', '', 0, ''),
('D741202457', '經濟學', '資管二甲', 'test', 1, ''),
('D741202492', '資料結構', '資管二甲', 'test', 0, ''),
('D741202795', '導師時間', '資管二甲', 'test', 2, ''),
('D741210681', '資料通訊與網路', '資管二甲', 'test           ', 0, ''),
('D742202457', '經濟學', '資管二乙', 'test     ', 0, ''),
('D742202795', '導師時間', '資管二乙', 'test      ', 2, ''),
('DATP203638F', '羽球', '體育二以上必', 'test       ', 0, ''),
('DFTEN00772I', '日文', 'FT-非英文', 'test  ', 2, ''),
('DNAO123456', '測試不給請假課程', '不給請假', 'test          ', 2, ''),
('DSTM800530', '企業成敗個案探討', '管理類', '整學期不可缺課三次', 1, '');

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
('0004', 'D742202795'),
('0005', 'D740209514'),
('0005', 'D741202457'),
('0006', 'DFTEN00772I'),
('0007', 'D740209514'),
('0008', 'DSTM800530'),
('0009', 'DATP203638F'),
('0010', 'D740219411'),
('0011', 'D740202632'),
('0012', 'DNAO123456'),
('411401001', 'D741202223');

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
('411401001', 'D742202457'),
('411401001', 'D742202795'),
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
('411401229', 'D741202223'),
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
-- 資料表結構 `leaverule`
--

CREATE TABLE `leaverule` (
  `rule_id` bigint(20) NOT NULL,
  `course_id` varchar(11) NOT NULL,
  `category_id` int(2) NOT NULL,
  `rule` int(1) NOT NULL COMMENT '0: 只能事前請假, 1: 不限制'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `leaverule`
--

INSERT INTO `leaverule` (`rule_id`, `course_id`, `category_id`, `rule`) VALUES
(9, 'D741201584', 1, 1),
(10, 'D741201584', 2, 1),
(11, 'D741201584', 3, 0),
(12, 'D741201584', 4, 0),
(13, 'D741201584', 5, 0),
(14, 'D741201584', 6, 1),
(15, 'D741201584', 7, 0),
(16, 'D741202795', 1, 1),
(17, 'D741202795', 2, 1),
(18, 'D741202795', 3, 1),
(19, 'D741202795', 4, 1),
(20, 'D741202795', 5, 1),
(21, 'D741202795', 6, 1),
(22, 'D741202795', 7, 1),
(23, 'D741202222', 1, 1),
(24, 'D741202222', 2, 1),
(25, 'D741202222', 3, 0),
(26, 'D741202222', 4, 1),
(27, 'D741202222', 5, 0),
(28, 'D741202222', 6, 0),
(29, 'D741202222', 7, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `period_time`
--

CREATE TABLE `period_time` (
  `period` varchar(10) NOT NULL,
  `start_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `period_time`
--

INSERT INTO `period_time` (`period`, `start_time`) VALUES
('D1', '08:10:00'),
('D2', '09:10:00'),
('D3', '10:10:00'),
('D4', '11:10:00'),
('D5', '13:40:00'),
('D6', '14:40:00'),
('D7', '15:40:00'),
('D8', '16:40:00'),
('DN', '12:40:00');

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
(46, 'DNAO123456', 6, 'DN', 0),
(47, 'D741202223', 4, 'DN', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `user_id` char(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `notify` int(1) NOT NULL COMMENT '0：不接收通知 1：接收通知\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`user_id`, `password`, `user_email`, `user_name`, `role`, `notify`) VALUES
('0001', '0000', 'henrylambb@gmail.com', '吳濟聰', '教授', 1),
('0002', '0000', '', '蔡幸蓁', '教授', 0),
('0003', '0000', '', '林青峰', '教授', 0),
('0004', '0000', '', '黃曜輝', '教授', 0),
('0005', '0000', '', '許嘉霖', '教授', 0),
('0006', '0000', '', 'Ishikawa Takao', '教授', 0),
('0007', '0000', '', '張銀益', '教授', 0),
('0008', '0000', '', '國安民', '教授', 0),
('0009', '0000', '', '陳冠旭', '教授', 0),
('0010', '0000', '', '黃懷陞', '教授', 0),
('0011', '0000', '', '鄭美娟', '教授', 0),
('0012', '0000', '', '不給請假教授', '教授', 0),
('411401001', '0000', 'henrylambb@gmail.com', '泥巴', '助教', 1),
('411401085', '0000', 'tibby494171@gmail.com', '朱唯綸', '學生', 0),
('411401229', '0000', 'henrylambb@gmail.com', '林亨奕', '學生', 1);

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
-- 資料表索引 `leaverule`
--
ALTER TABLE `leaverule`
  ADD PRIMARY KEY (`rule_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `category_id` (`category_id`);

--
-- 資料表索引 `period_time`
--
ALTER TABLE `period_time`
  ADD PRIMARY KEY (`period`);

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
  MODIFY `application_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `leaverule`
--
ALTER TABLE `leaverule`
  MODIFY `rule_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
-- 資料表的限制式 `leaverule`
--
ALTER TABLE `leaverule`
  ADD CONSTRAINT `leaverule_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leaverule_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
