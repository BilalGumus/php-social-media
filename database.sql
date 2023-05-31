-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 17 May 2023, 19:28:33
-- Sunucu sürümü: 10.4.22-MariaDB
-- PHP Sürümü: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `selcuksozluk`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(50) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `category`
--

INSERT INTO `category` (`category_id`, `category_title`) VALUES
(1, 'gündem'),
(2, 'teknoloji'),
(3, 'politika'),
(4, 'eğitim'),
(5, 'müzik');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(280) COLLATE utf8_turkish_ci NOT NULL,
  `post_image` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `user_id` int(50) NOT NULL,
  `post_category_id` int(50) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `post`
--

INSERT INTO `post` (`post_id`, `post_title`, `post_image`, `user_id`, `post_category_id`, `post_date`) VALUES
(1, 'Mollit ut labore nostrud pariatur veniam pariatur ullamco labore et est officia duis nisi nostrud. Dolore sit do laborum nulla laboris Lorem. Cupidatat consequat aliqua voluptate consectetur cupidatat nostrud.', '', 6, 1, '2022-05-19 12:27:56'),
(2, 'Id minim nulla Lorem eu occaecat cillum. Voluptate officia in occaecat sunt mollit ipsum Lorem ullamco cupidatat laboris mollit proident. Nisi occaecat enim anim sunt dolore eu ea nostrud velit deserunt.', '', 7, 2, '2022-05-19 12:29:54'),
(3, 'Ipsum amet voluptate voluptate ipsum ea ipsum ipsum sit ex non. Proident Lorem pariatur non incididunt velit labore velit nisi. Proident elit tempor ad ipsum ex velit. Velit sint officia cillum adipisicing cupidatat occaecat.', '9_2022-05-24_01-00-27_383748353.png', 5, 1, '2022-05-20 17:21:48'),
(4, 'In dolor voluptate aute ex anim quis excepteur magna fugiat magna dolor. Mollit ex fugiat in quis. Nisi ex amet ad magna eu est exercitation velit dolore anim. Ad nulla labore adipisicing.\r\n', '', 1, 4, '2022-05-20 18:54:16'),
(5, 'Consequat adipisicing eu id tempor cupidatat eiusmod ex laboris eiusmod aliqua. Qui fugiat laboris tempor dolore. Sit anim mollit nisi nostrud culpa consequat irure est minim. Exercitation est cillum excepteur amet amet magna est.', '', 7, 5, '2022-05-20 19:56:24'),
(9, 'Consequat culpa ea ea reprehenderit incididunt non. Et minim tempor velit ut velit nostrud incididunt esse ad est consectetur aute. Velit sit incididunt do anim eu consectetur aliqua anim laboris magna.\n', '', 1, 1, '2022-05-21 15:39:40'),
(29, 'Amet velit ea cillum velit aliqua elit voluptate adipisicing quis irure. Dolore cillum ullamco aliquip adipisicing dolor nulla duis excepteur ea occaecat aute velit enim aliqua.', '9_2022-05-24_01-00-06_5748587.png', 9, 2, '2022-05-23 22:00:06');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `post_comment`
--

CREATE TABLE `post_comment` (
  `post_comment_id` int(11) NOT NULL,
  `post_comment_title` varchar(280) COLLATE utf8_turkish_ci NOT NULL,
  `post_comment_image` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `post_comment_user_id` int(11) NOT NULL,
  `post_comment_post_id` int(11) NOT NULL,
  `post_comment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `post_comment`
--

INSERT INTO `post_comment` (`post_comment_id`, `post_comment_title`, `post_comment_image`, `post_comment_user_id`, `post_comment_post_id`, `post_comment_date`) VALUES
(1, 'Amet laborum anim ullamco laborum duis voluptate aliquip aliqua dolore mollit tempor ullamco cillum. Cupidatat commodo quis nulla sunt magna id occaecat id anim labore minim. Officia in officia magna quis anim esse dolor non est aliqua elit.', '', 7, 1, '2022-05-22 19:30:46'),
(2, 'Minim voluptate ex dolor enim id nulla mollit. Duis enim minim anim ea deserunt fugiat eiusmod ex est tempor.', '', 1, 3, '2022-05-22 19:38:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `post_comment_review`
--

CREATE TABLE `post_comment_review` (
  `post_comment_review_id` int(11) NOT NULL,
  `post_comment_review_user_id` int(11) NOT NULL,
  `post_comment_review_post_comment_id` int(11) NOT NULL,
  `post_comment_review_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `post_comment_review`
--

INSERT INTO `post_comment_review` (`post_comment_review_id`, `post_comment_review_user_id`, `post_comment_review_post_comment_id`, `post_comment_review_type`) VALUES
(15, 7, 1, -1),
(16, 7, 2, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `post_review`
--

CREATE TABLE `post_review` (
  `post_review_id` int(11) NOT NULL,
  `post_review_user_id` int(11) NOT NULL,
  `post_review_post_id` int(11) NOT NULL,
  `post_review_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `post_review`
--

INSERT INTO `post_review` (`post_review_id`, `post_review_user_id`, `post_review_post_id`, `post_review_type`) VALUES
(45, 7, 9, 1),
(46, 7, 3, -1),
(47, 7, 2, -1),
(48, 7, 1, -1),
(52, 1, 9, 1),
(53, 1, 5, 1),
(54, 9, 29, 1),
(55, 9, 3, -1),
(57, 7, 29, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `profile_picture` varchar(50) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'default',
  `banner_picture` varchar(50) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'default',
  `role_id` int(11) NOT NULL DEFAULT 3,
  `user_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `profile_picture`, `banner_picture`, `role_id`, `user_date`) VALUES
(1, 'admin', 'Bilal', 'Gümüş', 'bilalgumus@gmail.com', '$2y$10$LHmuV6Xemcg48G1Ge9PD8uZrn2qu0WpNOfGQqCCGGktXouOD82f3e', 'default', 'default', 1, '2022-05-23 21:47:42'),
(5, 'ali', 'Ali', 'Brown', 'ali@brown.com', '$2y$10$U5arQa6tVfopfl4LY6sUoe/Mm6V7a5GxgmQOejif7iVUhdvle2oES', '5_2022-05-24_00-53-41_1290135353.png', '5_2022-05-24_00-53-41_1540012117.jpg', 3, '2022-05-23 21:53:41'),
(6, 'jane', 'Jane', 'Doe', 'jane@goe.com', '$2y$10$S0kIYhkNduINPF23Cmcqy.WMRSZTTz3GfRKVGamnkx.AQFTF8Tmq6', '6_2022-05-24_00-48-52_1998432899.png', '6_2022-05-24_00-48-52_1715334211.jpg', 3, '2022-05-23 21:48:52'),
(7, 'AlexW', 'Alex', 'Williams', 'alex@outlook.com', '$2y$10$4Od5nm6lDHRNzia4ofWFl.bam.K8XrR/ZxV/BOqwfo61dX2/A8wV2', '7_2022-05-24_00-49-22_593500969.png', '7_2022-05-24_00-49-22_2015963498.jpg', 2, '2022-05-23 21:49:22'),
(9, 'andrea', 'Andrea', 'Pelkas', 'andrea@dev.com', '$2y$10$4Od5nm6lDHRNzia4ofWFl.bam.K8XrR/ZxV/BOqwfo61dX2/A8wV2', '9_2022-05-24_00-58-11_857356489.jpg', 'default', 3, '2022-05-23 21:59:11');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_follow`
--

CREATE TABLE `user_follow` (
  `user_follow_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `user_follow_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `user_follow`
--

INSERT INTO `user_follow` (`user_follow_id`, `sender_id`, `receiver_id`, `user_follow_date`) VALUES
(1, 9, 7, '2022-05-20 20:11:56'),
(2, 9, 6, '2022-05-20 20:11:56'),
(3, 9, 5, '2022-05-20 20:11:56'),
(4, 9, 1, '2022-05-20 20:11:56'),
(23, 6, 1, '2022-05-25 14:11:03');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_role`
--

CREATE TABLE `user_role` (
  `user_role_id` int(11) NOT NULL,
  `user_role_title` varchar(50) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `user_role`
--

INSERT INTO `user_role` (`user_role_id`, `user_role_title`) VALUES
(1, 'admin'),
(2, 'moderator'),
(3, 'user');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Tablo için indeksler `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Tablo için indeksler `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`post_comment_id`);

--
-- Tablo için indeksler `post_comment_review`
--
ALTER TABLE `post_comment_review`
  ADD PRIMARY KEY (`post_comment_review_id`);

--
-- Tablo için indeksler `post_review`
--
ALTER TABLE `post_review`
  ADD PRIMARY KEY (`post_review_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `user_follow`
--
ALTER TABLE `user_follow`
  ADD PRIMARY KEY (`user_follow_id`);

--
-- Tablo için indeksler `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_role_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Tablo için AUTO_INCREMENT değeri `post_comment`
--
ALTER TABLE `post_comment`
  MODIFY `post_comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `post_comment_review`
--
ALTER TABLE `post_comment_review`
  MODIFY `post_comment_review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `post_review`
--
ALTER TABLE `post_review`
  MODIFY `post_review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `user_follow`
--
ALTER TABLE `user_follow`
  MODIFY `user_follow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Tablo için AUTO_INCREMENT değeri `user_role`
--
ALTER TABLE `user_role`
  MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
