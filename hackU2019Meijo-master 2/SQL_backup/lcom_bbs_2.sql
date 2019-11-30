-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 
-- サーバのバージョン： 10.3.16-MariaDB
-- PHP のバージョン: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `lcom_bbs`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `point` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `password`, `picture`, `point`, `created`, `modified`) VALUES
(3, 'maedaken1', 'maeda@maeda1', '4a5c7d376969ac5419a8e441f8c7fcf05210fd11', '20191030174722lcomtop2.png', 0, '2019-10-30 17:47:25', '2019-10-30 08:47:25'),
(4, 'unkoburiburi', '193426021@ccmailg.meijo-u.ac.jp', '16641f482801c0f50bc01a4eea9479a68fc2cc03', '20191030175815lcomtop1.png', 0, '2019-10-30 17:58:21', '2019-10-30 08:58:21'),
(5, 'きょうすけ', 'kyosuke@tomoki.com', '4a5c7d376969ac5419a8e441f8c7fcf05210fd11', '20191031134906unti1.png', 0, '2019-10-31 21:49:14', '2019-10-31 12:49:14');

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `member_id` int(11) NOT NULL,
  `reply_project_id` int(11) NOT NULL,
  `reply_message_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `member_id` int(11) NOT NULL,
  `place` varchar(255) NOT NULL,
  `project_picture` varchar(255) NOT NULL,
  `open_year` int(11) NOT NULL,
  `open_month` int(11) NOT NULL,
  `open_date` int(11) NOT NULL,
  `open_time` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `message`, `member_id`, `place`, `project_picture`, `open_year`, `open_month`, `open_date`, `open_time`, `place_id`, `created`, `modified`) VALUES
(1, 'ああああ', 'ああああああああああああああああああああああああああああああああああ', 0, '', '20191031064125lcom_1.png', 0, 0, 0, 0, 0, '2019-10-31 14:41:27', '2019-10-31 05:41:27'),
(8, 'なんでやねん', 'それはなんでやあああああああああああああああああああああああああああああああああああああああああああああああああああ', 3, '', '20191031190806ninjin.png', 2021, 10, 14, 17, 1, '2019-11-01 03:08:08', '2019-10-31 18:08:08'),
(9, 'テスト', '今回も無事完了いたしました。つぎもがんばろう', 3, '', '20191031191445lcom_1.png', 2019, 11, 16, 15, 2, '2019-11-01 03:14:51', '2019-10-31 18:14:51'),
(10, 'らららららら', 'この日焼肉おごってくれる人いませんか。', 3, '', '20191031192311lcom_4.png', 2019, 12, 30, 18, 2, '2019-11-01 03:23:18', '2019-10-31 18:23:18'),
(11, '平家物語', '祇園精舎の鐘の声、諸行無常の響あり。娑沙羅双樹の花の色、盛者必衰のことはりをあらはす。おごれる人も久しからず、只春の夜の夢のごとし。たけき者も遂にはほろびぬ、偏に風の前の塵に同じ。', 3, '', '20191031192532lcom_1.png', 2029, 9, 14, 15, 1, '2019-11-01 03:25:33', '2019-10-31 18:25:33'),
(12, '10万ボルト', '大君は神にしませば天雲あまくもの雷いかづちの上に廬いほりせるかもーー巻3・柿本人麻呂', 3, '', '20191031192714lcom_3.png', 2021, 2, 16, 14, 2, '2019-11-01 03:27:16', '2019-10-31 18:27:16'),
(13, '色がない世界', 'えええええええええええええええええええええええええええええええええええええええええええええええええええ', 3, '', '20191031192839unti3.png', 2026, 1, 18, 17, 3, '2019-11-01 03:28:44', '2019-10-31 18:28:44');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- テーブルのAUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
