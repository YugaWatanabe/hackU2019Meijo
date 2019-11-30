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
  `iine_point` int(11) NOT NULL,
  `dark_point` int(11) NOT NULL,
  `light_point` int(11) NOT NULL,
  `sum_coment` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `password`, `picture`, `iine_point`, `dark_point`, `light_point`, `sum_coment`, `created`, `modified`) VALUES
(3, 'maedaken1', 'maeda@maeda1', '4a5c7d376969ac5419a8e441f8c7fcf05210fd11', '20191030174722lcomtop2.png', 0, 2, 3, 0, '2019-10-30 17:47:25', '2019-11-28 08:52:33'),
(4, 'unkoburiburi', '193426021@ccmailg.meijo-u.ac.jp', '16641f482801c0f50bc01a4eea9479a68fc2cc03', '20191030175815lcomtop1.png', 0, 0, 0, 0, '2019-10-30 17:58:21', '2019-10-30 08:58:21'),
(5, 'きょうすけ', 'kyosuke@tomoki.com', '4a5c7d376969ac5419a8e441f8c7fcf05210fd11', '20191031134906unti1.png', 0, 0, 0, 0, '2019-10-31 21:49:14', '2019-10-31 12:49:14'),
(6, 'えるこむ2', 'lcom@lcom2', '4a5c7d376969ac5419a8e441f8c7fcf05210fd11', '20191031203125lcom_3.png', 0, 0, 0, 0, '2019-11-01 04:31:36', '2019-10-31 19:31:36'),
(7, 'えるこむ3', 'lcom@lcom3', '4a5c7d376969ac5419a8e441f8c7fcf05210fd11', '20191031203442lcom_3.png', 0, 0, 0, 0, '2019-11-01 04:34:51', '2019-10-31 19:34:51'),
(8, 'えるこむ５', 'lcom@lcom4', '4a5c7d376969ac5419a8e441f8c7fcf05210fd11', '20191107162139lcom_6.png', 0, 3, 0, 3, '2019-11-08 00:21:42', '2019-11-28 14:57:31'),
(9, 'えるこむ6', 'lcom@lcom6', '4a5c7d376969ac5419a8e441f8c7fcf05210fd11', '20191107171442lcom_4.png', 0, 10, 0, 10, '2019-11-08 01:14:44', '2019-11-28 15:19:59'),
(10, 'スーパーえるこむ', 'lcom@lcom7', '4a5c7d376969ac5419a8e441f8c7fcf05210fd11', '20191128181700lcom_25.png', 0, 0, 0, 0, '2019-11-29 02:17:02', '2019-11-28 17:17:02');

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

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `message`, `member_id`, `reply_project_id`, `reply_message_id`, `created`, `modified`) VALUES
(29, 'こんにちわ', 8, 21, 0, '2019-11-13 01:29:16', '2019-11-12 16:29:16'),
(30, 'なんでやねん', 9, 21, 0, '2019-11-25 03:24:39', '2019-11-24 18:24:39'),
(35, 'ふぁああああああ', 8, 17, 0, '2019-11-26 02:58:23', '2019-11-25 17:58:23'),
(36, '初めての投稿！', 8, 22, 0, '2019-11-26 03:01:51', '2019-11-25 18:01:51'),
(37, 'ペットの持ち込みはありですか？', 8, 22, 0, '2019-11-26 03:02:52', '2019-11-25 18:02:52'),
(38, 'はい！小動物なら大丈夫です', 8, 22, 0, '2019-11-26 03:04:51', '2019-11-25 18:04:51'),
(43, '初めての投稿！', 7, 23, 0, '2019-11-26 17:06:54', '2019-11-26 08:06:54'),
(44, 'こんばんわに', 7, 23, 0, '2019-11-26 17:52:45', '2019-11-26 08:52:45'),
(46, '川に洗濯なんて最高です', 7, 16, 0, '2019-11-28 17:04:18', '2019-11-28 08:04:18'),
(47, 'なんか山に芝刈りしたくなってきました', 7, 16, 0, '2019-11-28 17:07:47', '2019-11-28 08:07:47'),
(48, 'その日の川はやめるべきじゃ', 7, 16, 0, '2019-11-28 17:08:55', '2019-11-28 08:08:55'),
(49, '柴犬を連れていきたいです', 7, 16, 0, '2019-11-28 17:13:46', '2019-11-28 08:13:46'),
(50, '柴犬は嫌いでしょうか', 7, 16, 0, '2019-11-28 17:19:44', '2019-11-28 08:19:44'),
(51, '柴犬はてめえだ', 7, 16, 0, '2019-11-28 17:22:13', '2019-11-28 08:22:13'),
(52, '僕はトイプードルが好きです', 7, 16, 0, '2019-11-28 17:23:54', '2019-11-28 08:23:54'),
(53, 'うつくしい心を持っているのですね', 7, 16, 0, '2019-11-28 17:52:33', '2019-11-28 08:52:33');

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
  `pro_point` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `message`, `member_id`, `place`, `project_picture`, `open_year`, `open_month`, `open_date`, `open_time`, `place_id`, `pro_point`, `created`, `modified`) VALUES
(1, 'ああああ', 'ああああああああああああああああああああああああああああああああああ', 0, '', '20191031064125lcom_1.png', 0, 0, 0, 0, 0, 0, '2019-10-31 14:41:27', '2019-10-31 05:41:27'),
(9, 'テスト', '今回も無事完了いたしました。つぎもがんばろう', 3, '', '20191031191445lcom_1.png', 2019, 11, 16, 15, 2, 22, '2019-11-01 03:14:51', '2019-11-28 15:19:59'),
(10, 'らららららら', 'この日焼肉おごってくれる人いませんか。', 3, '', '20191031192311lcom_4.png', 2019, 12, 30, 18, 2, 0, '2019-11-01 03:23:18', '2019-10-31 18:23:18'),
(11, '平家物語', '祇園精舎の鐘の声、諸行無常の響あり。娑沙羅双樹の花の色、盛者必衰のことはりをあらはす。おごれる人も久しからず、只春の夜の夢のごとし。たけき者も遂にはほろびぬ、偏に風の前の塵に同じ。', 3, '', '20191031192532lcom_1.png', 2029, 9, 14, 15, 1, 1, '2019-11-01 03:25:33', '2019-11-26 13:12:36'),
(12, '10万ボルト', '大君は神にしませば天雲あまくもの雷いかづちの上に廬いほりせるかもーー巻3・柿本人麻呂', 3, '', '20191031192714lcom_3.png', 2021, 2, 16, 14, 2, 0, '2019-11-01 03:27:16', '2019-10-31 18:27:16'),
(15, 'なんでやねん', 'ねむたしつきぬけりたり', 3, '', '20191107161539lcom_10.png', 2023, 2, 14, 12, 4, 0, '2019-11-08 00:15:45', '2019-11-07 15:15:45'),
(16, '山へ芝刈りに', 'おばあさんは川に洗濯に行きました。', 3, '', '20191107161808lcom_4.png', 2020, 3, 7, 7, 1, 36, '2019-11-08 00:18:09', '2019-11-28 16:16:26'),
(17, 'Lコムプロジェクト', '桃がたべたいなえええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええええ', 8, '', '20191107162250lcom_8.png', 2020, 9, 2, 13, 4, 1, '2019-11-08 00:22:53', '2019-11-26 13:11:35'),
(18, 'えるこむ6', 'えええええええええええええええええええええええええええええええええええええええええええええええ', 9, '', '20191107171544lcom_10.png', 2022, 4, 2, 6, 3, 0, '2019-11-08 01:15:45', '2019-11-07 16:15:45'),
(22, '桃源郷', 'たまには山に冒険にでませんか。今は紅葉がとても綺麗でキノコもいっぱい取れます。愛知県天白区の塩釜口駅前に集合してください。', 8, '', '20191125190148lcompro1.png', 2019, 12, 1, 9, 4, 54, '2019-11-26 03:01:51', '2019-11-28 16:55:53'),
(23, 'テストプロジェクト2', 'あああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ', 7, '', '20191126090652kurohime1.png', 2019, 11, 29, 12, 28, 6, '2019-11-26 17:06:54', '2019-11-28 16:40:52');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- テーブルのAUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- テーブルのAUTO_INCREMENT `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;