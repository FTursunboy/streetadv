-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.45-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных sa-new-admin
CREATE DATABASE IF NOT EXISTS `sa-new-admin` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sa-new-admin`;


-- Дамп структуры для таблица sa-new-admin.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `categoryID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `languageID` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_number` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `color` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bg_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.categories: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`categoryID`, `languageID`, `name`, `sort_number`, `active`, `color`, `bg_image`, `icon_image`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Городские', 0, 0, '#B02525', 'http://falltog2.bget.ru/uploads/admin/1d42b3634aaa3f38d1d1d55eafa72539.jpg', 'uploads/admin/abc67d45a65a3316c37e3504d5015c0f.png', '2016-08-19 21:26:18', '2017-03-18 13:12:10'),
	(7, 1, 'Музейные', 1, 0, '#1518B5', 'uploads/admin/c0fa4bdf014fb21c6df20b2a72d98ca8.png', 'uploads/admin/2795e22ab36532246f64f795368d0dd3.png', '2017-05-19 12:45:28', '2017-05-19 12:45:28'),
	(8, 1, 'Прогулочные', 3, 0, '#0D5403', 'uploads/admin/2555a0cb098364bfd5696b52de2c6df9.jpg', 'uploads/admin/55e03eb4761bbc634b9af810df713513.png', '2017-05-19 12:46:12', '2017-07-25 06:17:01'),
	(9, 1, 'Сюжетные', 4, 0, '#F9F50E', 'uploads/admin/d9d760a7c588f1c60484155616d6f358.jpg', 'uploads/admin/798c3fc8957f528777c946d8ad55b9a5.jpg', '2017-05-19 12:47:13', '2017-07-25 06:17:01'),
	(12, 1, 'asd', 2, 0, 'FFFFFF', '44248b9f648794b43f571b3488cc66e4.jpg', '5f1f4e60a5a028d711c08696bf57d3d2.jpg', '2017-07-24 06:42:15', '2017-07-25 06:17:01'),
	(13, 1, 'test', 0, 0, 'FFFFFF', NULL, NULL, '2017-07-25 06:17:13', '2017-07-25 06:17:13');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `cityID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `languageID` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lat` double(13,10) DEFAULT NULL,
  `lng` double(13,10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cityID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.cities: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` (`cityID`, `languageID`, `name`, `lat`, `lng`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Москва', 55.7522200000, 37.6155600000, '2016-08-19 21:26:18', '2016-08-19 21:26:18');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.languages
CREATE TABLE IF NOT EXISTS `languages` (
  `languageID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ru_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `en_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prefix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`languageID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.languages: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` (`languageID`, `ru_name`, `en_name`, `prefix`, `created_at`, `updated_at`) VALUES
	(1, 'Русский', 'Russian', 'ru', '2016-08-19 21:26:18', '2017-07-19 10:09:23'),
	(2, 'Английский', 'English', 'en', '2016-08-19 21:26:18', '2016-08-19 21:26:18');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.migrations: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.quests
CREATE TABLE IF NOT EXISTS `quests` (
  `questID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryIDs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `cityID` int(10) unsigned NOT NULL,
  `product_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `bottomLeftLat` double DEFAULT NULL,
  `bottomLeftLng` double DEFAULT NULL,
  `topRightLat` double DEFAULT NULL,
  `topRightLng` double DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `price_android` double(8,2) DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `steps` int(11) NOT NULL,
  `distance` int(11) NOT NULL,
  `calories` double(8,2) NOT NULL,
  `nextQuestionPhraseAction` text COLLATE utf8_unicode_ci,
  `previous_price` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_bg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'all',
  `sticker` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_number` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `recommend` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`questID`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.quests: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `quests` DISABLE KEYS */;
INSERT INTO `quests` (`questID`, `categoryIDs`, `name`, `description`, `cityID`, `product_id`, `type`, `address`, `longitude`, `latitude`, `bottomLeftLat`, `bottomLeftLng`, `topRightLat`, `topRightLng`, `price`, `price_android`, `points`, `steps`, `distance`, `calories`, `nextQuestionPhraseAction`, `previous_price`, `discount`, `image`, `image_bg`, `access`, `sticker`, `sort_number`, `active`, `recommend`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(31, '7,9', 'Тестовый квест', 'тест', 1, 'com.test', 'Исторический квест', 'test', 22.222222, 11.111111, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 123, 123, 123.00, NULL, NULL, NULL, 'bb9ec1c8aeffd52e7d28a6ab3301bb1c.jpg', 'ff0c617267a885e93dacac17b0ff1a09.jpg', 'all', NULL, 1, 1, 0, '2017-07-25 06:36:35', '2017-07-25 09:28:07', NULL);
/*!40000 ALTER TABLE `quests` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.quest_answers
CREATE TABLE IF NOT EXISTS `quest_answers` (
  `answerID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questionID` int(10) unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text_input',
  `coords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `voice_over` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_number` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`answerID`)
) ENGINE=InnoDB AUTO_INCREMENT=777 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.quest_answers: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `quest_answers` DISABLE KEYS */;
INSERT INTO `quest_answers` (`answerID`, `questionID`, `type`, `coords`, `voice_over`, `sort_number`, `created_at`, `updated_at`) VALUES
	(776, 683, 'text_input', NULL, NULL, 630, '2017-07-07 14:52:42', '2017-08-07 15:43:49');
/*!40000 ALTER TABLE `quest_answers` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.quest_answers_components
CREATE TABLE IF NOT EXISTS `quest_answers_components` (
  `componentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questID` int(10) unsigned NOT NULL,
  `questionID` int(10) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `text` text,
  `right` int(10) NOT NULL DEFAULT '0',
  `file` varchar(255) DEFAULT NULL,
  `sort_number` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`componentID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы sa-new-admin.quest_answers_components: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `quest_answers_components` DISABLE KEYS */;
INSERT INTO `quest_answers_components` (`componentID`, `questID`, `questionID`, `type`, `text`, `right`, `file`, `sort_number`, `created_at`, `updated_at`) VALUES
	(4, 31, 683, 'text_input', '4444', 0, NULL, 1, '2017-08-07 16:58:00', '2017-08-07 16:58:00');
/*!40000 ALTER TABLE `quest_answers_components` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.quest_appearances
CREATE TABLE IF NOT EXISTS `quest_appearances` (
  `appearanceID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questID` int(10) unsigned NOT NULL,
  `question_bg_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `question_text_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `question_font_size` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `question_font` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'San-Francisco',
  `answer_bg_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer_text_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer_font_size` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer_font` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'San-Francisco',
  `hint_bg_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hint_text_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hint_font_size` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hint_font` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'San-Francisco',
  `quest_background_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_background_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cell_description_font` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cell_description_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_background_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`appearanceID`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.quest_appearances: ~14 rows (приблизительно)
/*!40000 ALTER TABLE `quest_appearances` DISABLE KEYS */;
INSERT INTO `quest_appearances` (`appearanceID`, `questID`, `question_bg_color`, `question_text_color`, `question_font_size`, `question_font`, `answer_bg_color`, `answer_text_color`, `answer_font_size`, `answer_font`, `hint_bg_color`, `hint_text_color`, `hint_font_size`, `hint_font`, `quest_background_color`, `chat_background_color`, `cell_description_font`, `cell_description_color`, `chat_background_image`, `created_at`, `updated_at`) VALUES
	(11, 31, '#0064AD', '#FFFFFF', '18', 'FreeSans', '#00B6EE', '#FFFFFF', '17', 'SFUIDisplay-Regular', '#0064AD', '#FFFFFF', '18', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#E7E7E7', 'uploads/admin/eab0970e6182b40bced6fbfe5c1a51f6.jpg', '2017-03-19 12:40:48', '2017-05-31 16:13:54'),
	(22, 42, '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#00ABEE', '#FFFFFF', '17', 'Roboto-Condensed', '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#797979', 'uploads/admin/0fb620fa9d4d12aaeb0524dc649da4d7.jpeg', '2017-05-19 12:19:56', '2017-05-20 16:39:48'),
	(23, 43, '#EDE5A5', '#424032', '17', 'Elizabeth_tt-Uni', '#EDE5A5', '#424032', '17', 'Elizabeth_tt-Uni-Italic', '#EDE5A5', '#424032', '17', 'Elizabeth_tt-Uni', '#FFFFFF', '#FFFFFF', 'Elizabeth_tt-Uni-Italic', '#797979', 'http://nikitas4.beget.tech/uploads/admin/b8d82032109c9dccf8669ee1618386d6.png', '2017-05-19 12:38:39', '2017-05-19 17:20:34'),
	(25, 45, '#8EC957', '#FFFFFF', '17', 'Roboto-Condensed', '#FF550D', '#FFFFFF', '17', 'Roboto-Condensed', '#8EC957', '#FFFFFF', '17', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#5B8C2D', 'uploads/admin/0cb524c70ac9f5cded31729e0039c70e.jpeg', '2017-05-19 13:07:51', '2017-05-20 16:43:31'),
	(27, 47, '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#00ABEE', '#FFFFFF', '17', 'Roboto-Condensed', '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#797979', NULL, '2017-05-27 17:04:50', '2017-05-27 17:04:50'),
	(28, 48, '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#00ABEE', '#FFFFFF', '17', 'Roboto-Condensed', '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#797979', NULL, '2017-05-29 13:17:27', '2017-05-29 13:17:27'),
	(29, 49, '#EDC9BB', '#FFFFFF', '17', 'Roboto-Condensed', '#3E3533', '#FFFFFF', '17', 'Roboto-Condensed', '#EDC9BB', '#FFFFFF', '17', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#797979', 'http://nikitas4.beget.tech/uploads/admin/19734a8aeb5055f834ddfef9a3833924.jpeg', '2017-05-30 18:23:52', '2017-06-07 15:55:47'),
	(31, 51, '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#00ABEE', '#FFFFFF', '17', 'Roboto-Condensed', '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#797979', 'uploads/admin/682d531deebddb3cb443b70f4c385d02.jpeg', '2017-06-19 13:32:59', '2017-06-19 15:03:00'),
	(32, 52, '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#00ABEE', '#FFFFFF', '17', 'Roboto-Condensed', '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#797979', 'uploads/admin/d5ea35536c9ef3eae4de1ea351a85060.jpeg', '2017-06-19 15:18:48', '2017-06-19 21:12:05'),
	(33, 53, '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#00ABEE', '#FFFFFF', '17', 'Roboto-Condensed', '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#797979', 'uploads/admin/46b64be9b02d8982a4fa240710a249c5.jpeg', '2017-06-20 12:49:14', '2017-06-20 14:06:55'),
	(34, 54, '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#00ABEE', '#FFFFFF', '17', 'Roboto-Condensed', '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#797979', 'uploads/admin/69188d6ea6d15cf1ed5d96a2b3d831eb.jpeg', '2017-06-20 15:58:55', '2017-06-20 17:53:45'),
	(35, 55, '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#00ABEE', '#FFFFFF', '17', 'Roboto-Condensed', '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#797979', 'uploads/admin/cc9275d334a6f6ad697b4c3960fa4d7d.jpeg', '2017-06-21 15:07:39', '2017-06-21 15:09:23'),
	(36, 56, '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#00ABEE', '#FFFFFF', '17', 'Roboto-Condensed', '#EE355E', '#FFFFFF', '17', 'Roboto-Condensed', '#FFFFFF', '#FFFFFF', 'Roboto-Condensed', '#797979', NULL, '2017-06-21 16:23:27', '2017-06-21 16:23:27'),
	(37, 57, 'FFFFFF', 'FFFFFF', '12', 'Upheaval Pro', 'FFFFFF', 'FFFFFF', '13', 'Upheaval Pro', 'FFFFFF', 'FFFFFF', '14', 'Upheaval Pro', 'FFFFFF', 'FFFFFF', 'Upheaval Pro', 'FFFFFF', 'b9ccd9b7292ea35322acc728a20f5edf.jpg', '2017-07-25 06:36:35', '2017-07-25 09:28:23');
/*!40000 ALTER TABLE `quest_appearances` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.quest_phrases
CREATE TABLE IF NOT EXISTS `quest_phrases` (
  `phraseID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questID` int(10) unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `voice` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`phraseID`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.quest_phrases: ~11 rows (приблизительно)
/*!40000 ALTER TABLE `quest_phrases` DISABLE KEYS */;
INSERT INTO `quest_phrases` (`phraseID`, `questID`, `type`, `description`, `voice`, `created_at`, `updated_at`) VALUES
	(90, 31, 'need_help_phrases', 'Сломал голову, мне нужна подсказка.', NULL, '2017-03-19 12:40:48', '2017-05-31 13:52:20'),
	(100, 31, 'correct_answer_phrases', 'Отлично! Это правильный ответ.', 'uploads/admin/876ce982d49a165b570d0d2172874fc5.mp3', '2017-03-23 19:34:58', '2017-05-31 13:40:37'),
	(101, 31, 'correct_answer_phrases', 'Вы правы!', 'uploads/admin/9526244fa967dd563bd29ff455e9d45b.mp3', '2017-03-23 19:35:22', '2017-05-31 17:45:32'),
	(102, 31, 'correct_answer_phrases', 'Просто супер!', 'uploads/admin/432d70e9bb0019514b30a969b1bf3065.mp3', '2017-03-23 19:35:57', '2017-05-31 13:44:18'),
	(103, 31, 'correct_answer_phrases', 'Ура! Вы справились!', 'uploads/admin/b7fbdf06c2bac543d3131ec362cccc2f.mp3', '2017-03-23 19:36:27', '2017-05-31 13:45:18'),
	(104, 31, 'correct_geoanswer_phrases', 'Отлично, вы на месте!', 'uploads/admin/eda25365f0b4d5180b674614f051ba92.mp3', '2017-03-23 19:36:59', '2017-04-07 11:38:17'),
	(105, 31, 'timer-finished', 'Ой! Время истекло :(', 'uploads/admin/9365f6d7f067c17a76c82e1a2b089c94.mp3', '2017-03-23 19:48:01', '2017-05-31 13:52:44'),
	(106, 31, 'wrong-answer-ask-for-hint', 'Упс! Наверное, вам нужна помощь.', 'uploads/admin/18ec513ed3db41cd7e76a200470d46f7.mp3', '2017-03-23 19:48:46', '2017-05-31 13:55:04'),
	(107, 31, 'wrong_answer_phrases', 'Это неправильный ответ :(', 'uploads/admin/d61aa9eae5d2084546af3567a12326b7.mp3', '2017-03-23 19:49:08', '2017-05-31 13:53:18'),
	(108, 31, 'wrong_answer_phrases', 'Нет, не так!', 'uploads/admin/c6224eebcad88e2df33087b145e6f0ce.mp3', '2017-03-23 19:49:30', '2017-05-31 13:53:52'),
	(109, 31, 'wrong_answer_phrases', 'Неверно!', 'uploads/admin/ffad4f089660c010229814365e0ed584.mp3', '2017-03-23 19:50:00', '2017-05-31 13:54:37');
/*!40000 ALTER TABLE `quest_phrases` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.quest_questions
CREATE TABLE IF NOT EXISTS `quest_questions` (
  `questionID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questID` int(10) unsigned NOT NULL,
  `lat` double(13,10) DEFAULT NULL,
  `lng` double(13,10) DEFAULT NULL,
  `radius` int(11) DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `geoType` tinyint(1) NOT NULL,
  `isAugmentedReality` tinyint(4) NOT NULL,
  `voice_over` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `offline_map_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_number` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`questionID`)
) ENGINE=InnoDB AUTO_INCREMENT=684 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.quest_questions: ~24 rows (приблизительно)
/*!40000 ALTER TABLE `quest_questions` DISABLE KEYS */;
INSERT INTO `quest_questions` (`questionID`, `questID`, `lat`, `lng`, `radius`, `points`, `geoType`, `isAugmentedReality`, `voice_over`, `offline_map_image`, `sort_number`, `created_at`, `updated_at`) VALUES
	(161, 31, 0.0000000000, 0.0000000000, 0, 5, 0, 0, 'uploads/admin/321f5d770c3417e08dd5d423d0e02e00.mp3', '', 2, '2017-03-19 12:47:21', '2017-08-03 17:38:17'),
	(162, 31, 55.7477580000, 37.5860250000, 25, 15, 0, 0, 'uploads/admin/4c586db3acef2358323cb752f5d39cd3.wav', 'http://nikitas4.beget.tech/uploads/admin/0f7481c43839b4ba0bd1df67b7e7f03d.jpg', 1, '2017-03-19 12:58:13', '2017-08-03 17:38:17'),
	(163, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 1, 'uploads/admin/3a19ea0301cf051c64f8d6335474a694.mp3', '', 3, '2017-03-19 13:10:50', '2017-08-03 17:38:17'),
	(164, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 0, 'uploads/admin/ea7ddc9707dbe8854e2f45dead78f037.mp3', '', 4, '2017-03-19 13:14:48', '2017-08-03 17:38:17'),
	(165, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 0, 'uploads/admin/0af6027c740703ce786085acffacf444.mp3', '', 5, '2017-03-19 13:18:56', '2017-08-03 17:38:17'),
	(166, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 0, 'uploads/admin/e6ddeede54122800ee2e725cea3a7a42.mp3', '', 6, '2017-03-19 13:22:01', '2017-08-03 17:38:17'),
	(167, 31, 0.0000000000, 0.0000000000, 0, 5, 0, 0, 'uploads/admin/3224c9b46a4a3669a37cdb44026aece6.mp3', '', 7, '2017-03-19 13:28:09', '2017-08-03 17:38:17'),
	(171, 31, 0.0000000000, 0.0000000000, 0, 5, 0, 0, 'uploads/admin/7fed402b8a0e14c970d4a0aedf4dd52b.mp3', '', 8, '2017-03-19 13:32:58', '2017-08-03 17:38:17'),
	(172, 31, 0.0000000000, 0.0000000000, 0, 40, 0, 0, 'uploads/admin/aaf631dbc9273939d22a508d9c782981.mp3', '', 9, '2017-03-19 13:34:16', '2017-08-03 17:38:17'),
	(173, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 0, 'uploads/admin/5a6d35692851f9e75cb02bec316fbaf2.mp3', '', 10, '2017-03-19 13:35:49', '2017-06-19 12:28:15'),
	(174, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 0, 'uploads/admin/e17dadcf323706e52a170751a33c8594.mp3', '', 11, '2017-03-19 13:48:52', '2017-06-19 12:28:15'),
	(176, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 0, 'http://nikitas4.beget.tech/uploads/admin/60719a762a08504ded7cf0ccc53c3d53.mp3', '', 12, '2017-03-19 14:02:41', '2017-06-19 12:28:15'),
	(177, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 0, 'uploads/admin/5dbd34bd432ba2ab01cc541375404d55.mp3', '', 13, '2017-03-19 14:05:34', '2017-06-19 12:28:15'),
	(178, 31, 0.0000000000, 0.0000000000, 0, 5, 0, 0, 'uploads/admin/fa67460e61541f97f0ef1ea4e800fb8b.mp3', '', 14, '2017-03-19 14:08:38', '2017-06-19 12:28:15'),
	(179, 31, 55.7477580000, 37.5860250000, 25, 15, 0, 0, 'uploads/admin/f342c51035da84e4902c14207adacaa4.mp3', 'uploads/admin/c93065cb9cc7a1b6d544dcb2ab3c8f16.jpg', 15, '2017-03-19 14:10:11', '2017-06-19 12:28:15'),
	(180, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 0, 'uploads/admin/9f600a7d58817a1b781af8029e95c617.mp3', '', 16, '2017-03-19 14:12:37', '2017-06-19 12:28:15'),
	(181, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 0, 'uploads/admin/a77845f7791f7349b570bfe8fd63657c.mp3', '', 17, '2017-03-19 14:17:59', '2017-06-19 12:28:15'),
	(182, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 0, 'uploads/admin/2213edc0dba80aad6eede03faf5971db.mp3', '', 18, '2017-03-19 14:24:28', '2017-06-19 12:28:15'),
	(219, 31, 0.0000000000, 0.0000000000, 0, 5, 0, 0, 'uploads/admin/41c068c19c9e94ff8faf387ea3497ad3.mp3', '', 19, '2017-04-02 14:53:03', '2017-06-19 12:28:15'),
	(220, 31, 55.7521500000, 37.5997520000, 25, 15, 0, 0, 'http://nikitas4.beget.tech/uploads/admin/f334a81dff38b45a800339d3f1e14616.mp3', 'uploads/admin/dd84a9d45829891db8127de9aa62e747.jpg', 20, '2017-04-02 15:01:59', '2017-06-19 12:28:15'),
	(221, 31, 0.0000000000, 0.0000000000, 0, 15, 0, 0, 'http://nikitas4.beget.tech/uploads/admin/eadf1404f2c2859d90239e13efa4e008.mp3', '', 21, '2017-04-02 15:07:50', '2017-06-19 12:28:15'),
	(222, 31, NULL, NULL, 0, 15, 0, 0, NULL, '', 22, '2017-04-02 15:10:56', '2017-08-03 19:15:15'),
	(682, 31, NULL, NULL, NULL, 118, 0, 0, NULL, '4e277b67753041ebbf51ce834d708727.png', 23, '2017-08-03 19:16:45', '2017-08-03 19:16:45'),
	(683, 31, NULL, NULL, NULL, 234, 0, 0, NULL, NULL, 24, '2017-08-06 15:43:26', '2017-08-06 15:43:26');
/*!40000 ALTER TABLE `quest_questions` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.quest_questions_components
CREATE TABLE IF NOT EXISTS `quest_questions_components` (
  `componentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questID` int(10) unsigned NOT NULL,
  `questionID` int(10) unsigned NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT '',
  `description` text,
  `file` varchar(255) DEFAULT NULL,
  `timer` int(10) DEFAULT NULL,
  `sort_number` int(10) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`componentID`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы sa-new-admin.quest_questions_components: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `quest_questions_components` DISABLE KEYS */;
INSERT INTO `quest_questions_components` (`componentID`, `questID`, `questionID`, `type`, `description`, `file`, `timer`, `sort_number`, `created_at`, `updated_at`) VALUES
	(113, 31, 683, 'file', NULL, 'd296e102fd41096f37488aad8c46e557.jpg', NULL, 1, '2017-08-06 18:24:25', '2017-08-06 18:24:25'),
	(114, 31, 683, 'timer', NULL, NULL, 222, 2, '2017-08-06 18:24:25', '2017-08-06 18:24:25');
/*!40000 ALTER TABLE `quest_questions_components` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.users: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Владислав', 'fallton.vm@gmail.com', '$2y$10$xB8h/5Aii67QxYMJSFWhB.8suQ3Zd4pwemRn3Mxf6t0EVk0iIGXi6', 'YZJLTxnk4xEKMrwVJT7CBu9C3L7bd7jbrxT2g9oZELgZBDdY1C6yXMjONrzM', NULL, NULL),
	(2, 'Юлия Реутова', 'streetadventuremsk@gmail.com', '$2y$10$xB8h/5Aii67QxYMJSFWhB.8suQ3Zd4pwemRn3Mxf6t0EVk0iIGXi6', 'ey59wxZ3ixk3FO785PvGi5QjKmgNCoOL9pIF6ezSHc9ESQbzRsSyEzjUIFfh', NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
