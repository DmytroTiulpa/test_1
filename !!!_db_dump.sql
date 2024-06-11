-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 11 2024 г., 08:27
-- Версия сервера: 8.3.0
-- Версия PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test-task`
--

-- --------------------------------------------------------

--
-- Структура таблицы `urls`
--

DROP TABLE IF EXISTS `urls`;
CREATE TABLE IF NOT EXISTS `urls` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `original_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `urls_original_url_unique` (`original_url`),
  UNIQUE KEY `urls_short_url_unique` (`short_url`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `urls`
--

INSERT INTO `urls` (`id`, `original_url`, `short_url`, `created_at`, `updated_at`) VALUES
(1, 'https://utmk.com.ua/', 'http://127.0.0.1:8000/5xltLl', '2024-06-11 05:23:51', '2024-06-11 05:23:51'),
(2, 'https://www.youtube.com/watch?v=bpNw7jYkbVc&ab_channel=JoanJettVEVO', 'http://127.0.0.1:8000/YKtWcs', '2024-06-11 05:24:21', '2024-06-11 05:24:21'),
(3, 'https://www.youtube.com/watch?v=CmXWkMlKFkI&ab_channel=MotleyCrueVEVO', 'http://127.0.0.1:8000/qTmihm', '2024-06-11 05:24:48', '2024-06-11 05:24:48'),
(4, 'https://www.youtube.com/watch?v=l482T0yNkeo&ab_channel=acdcVEVO', 'http://127.0.0.1:8000/NKZLNA', '2024-06-11 05:26:45', '2024-06-11 05:26:45');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
