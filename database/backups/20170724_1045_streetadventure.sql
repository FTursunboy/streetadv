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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.categories: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`categoryID`, `languageID`, `name`, `sort_number`, `active`, `color`, `bg_image`, `icon_image`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Городские', 0, 0, '#B02525', 'http://falltog2.bget.ru/uploads/admin/1d42b3634aaa3f38d1d1d55eafa72539.jpg', 'uploads/admin/abc67d45a65a3316c37e3504d5015c0f.png', '2016-08-19 21:26:18', '2017-03-18 13:12:10'),
	(7, 1, 'Музейные', 1, 0, '#1518B5', 'uploads/admin/c0fa4bdf014fb21c6df20b2a72d98ca8.png', 'uploads/admin/2795e22ab36532246f64f795368d0dd3.png', '2017-05-19 12:45:28', '2017-05-19 12:45:28'),
	(8, 1, 'Прогулочные', 2, 0, '#0D5403', 'uploads/admin/2555a0cb098364bfd5696b52de2c6df9.jpg', 'uploads/admin/55e03eb4761bbc634b9af810df713513.png', '2017-05-19 12:46:12', '2017-05-19 12:46:12'),
	(9, 1, 'Сюжетные', 3, 0, '#F9F50E', 'uploads/admin/d9d760a7c588f1c60484155616d6f358.jpg', 'uploads/admin/798c3fc8957f528777c946d8ad55b9a5.jpg', '2017-05-19 12:47:13', '2017-05-19 12:47:13'),
	(12, 1, 'asd', 0, 0, 'FFFFFF', '44248b9f648794b43f571b3488cc66e4.jpg', '5f1f4e60a5a028d711c08696bf57d3d2.jpg', '2017-07-24 06:42:15', '2017-07-24 06:42:15');
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
  `city_id` int(10) unsigned NOT NULL,
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
  `nextQuestionPraseAction` text COLLATE utf8_unicode_ci,
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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.quests: ~13 rows (приблизительно)
/*!40000 ALTER TABLE `quests` DISABLE KEYS */;
INSERT INTO `quests` (`questID`, `categoryIDs`, `name`, `description`, `city_id`, `product_id`, `type`, `address`, `longitude`, `latitude`, `bottomLeftLat`, `bottomLeftLng`, `topRightLat`, `topRightLng`, `price`, `price_android`, `points`, `steps`, `distance`, `calories`, `nextQuestionPraseAction`, `previous_price`, `discount`, `image`, `image_bg`, `access`, `sticker`, `sort_number`, `active`, `recommend`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(31, NULL, 'Ах, Арбат! (старый)', 'Исторический центр Москвы – настоящая сокровищница любопытных фактов и необычных историй.\r\nНо экскурсии любят не все. А кто не любит приключения!\r\nВам предстоит узнать:\r\n- Что такое "сграффито"?\r\n- Кто охраняет принцессу Турандот?\r\n- Где находится старейший московский зоомагазин?\r\n- Как деревья связаны с Пушкином?\r\n- И, наконец, при чём здесь пчёлы?', 1, '', 'Квест по сердцу столицы:', 'ст. м. Смоленская (выход на Арбат)', 37.5836873, 55.747933, 55.747201, 37.581519, 55.753591, 37.603148, 299.00, 299.00, 350, 3400, 2, 320.00, 'Дальше!', 0, 0, '41532454220deacce3ff1fbee2dc6cfd.jpg', '6075f68910c0f32be00de484da03cdfb.jpg', 'users', NULL, 1, 1, 1, '2017-03-19 12:40:48', '2017-06-21 09:51:22', NULL),
	(42, NULL, 'Тайны Патриарших (старые)', 'Патриаршие пруды — район особенный, мистический. В старину здесь было Козье болото, а в XVII веке поселился тогдашний Патриарх Всея Руси. Представляете, какая гремучая смесь? Неудивительно, что и поныне звон церковных колоколов смешивается здесь с завываниями привидений, а странностей — не перечесть.\r\n- Почему на Патриаршем пруду есть памятник Крылову, но нет памятника Булгакову?\r\n- Откуда вылетела Маргарита, намазав тело волшебной мазью?\r\n- Что за таинственный мальчик стоит у дома с чертополохом?\r\n- И сколько всё-таки должно быть прудов?', 1, '', 'Прогулка сквозь время:', 'ст. м. Тверская / Пушкинская (Новопушкинский сквер)', 37.60429, 55.765078, 55.760973, 37.587342, 55.769998, 37.606954, 459.00, 459.00, 370, 3900, 2, 380.00, '', 0, 0, 'c0df5d4f5fd520cedfd093bc4b6c4905.jpg', '2716e8f30292e955efda8e31125a8d4f.jpg', 'users', NULL, 0, 1, 0, '2017-05-19 12:19:56', '2017-06-21 09:51:22', NULL),
	(43, NULL, 'Философский камень', 'Вы сами не знаете когда, но однажды в ваших головах поселился робкий голос, шепот, который преследовал вас даже во снах. И вот сегодня вам впервые удалось различить слова.\r\nДух давно погибшей женщины рассказал о деле всей своей жизни: о создании философского камня. Увы, ей не удалось закончить работу, и даже после смерти ей не найти покоя. Она просит вас о помощи, - и, кажется, у вас нет особого выбора.', 1, 'philstone', 'Таинственная история:', 'ст. м. Пушкинская / Тверская (Пушкинский сквер)', 37.60516, 55.765197, 55.763213, 37.596361, 55.768718, 37.610566, 0.00, 0.00, 350, 4600, 2, 420.00, '', 0, 0, 'c8b34a650f6c997b5d42abe7fb52e188.jpg', '5254faa20d2b5d7de96f9ce019722cfb.jpg', 'promocode', NULL, 8, 1, 0, '2017-05-19 12:38:39', '2017-06-21 09:51:22', NULL),
	(45, NULL, 'Литквест в РГБМ', 'Окунись в атмосферу Российской Государственной Библиотеки для Молодёжи!\r\nДОСТУПЕН С 27 МАЯ!', 1, 'rgbmlit', 'Квест по библиотеке:', 'ул. Большая Черкизовская, 4к1 (ст. м. Преображенская площадь)', 37.71766, 55.795863, 55.79397, 37.708512, 55.799143, 37.721987, 0.00, 0.00, 255, 800, 0, 100.00, '', 0, 0, '7726aa676848abf4a9a3b362e92840b9.jpg', 'f88cde9491a1cec65fa439276bc626e1.jpg', 'promocode', NULL, 2, 1, 0, '2017-05-19 13:07:51', '2017-06-21 09:51:22', NULL),
	(47, NULL, 'Гость из будущего', 'Тут будет описание', 1, 'visitor', 'Квест про путешествие во времени', 'ст. м. Лубянка', 37.627355, 55.759162, 0, 0, 0, 0, 0.00, 0.00, 345, 150, 3, 600.00, '', 0, 0, '4bd63cc6366cd932eda096057177d249.jpg', 'fec5a7163dc9b91edd7dfec1a3a40f19.jpg', 'promocode', NULL, 3, 1, 0, '2017-05-27 17:04:50', '2017-06-21 09:51:22', NULL),
	(48, NULL, 'Тени прошлого (старые)', 'Вы сами не знаете когда, но однажды в ваших головах поселился робкий голос, шепот, который преследовал вас даже во снах. И вот сегодня вам впервые удалось различить слова. Дух давно погибшей женщины рассказал о деле всей своей жизни, и даже после смерти ей не найти покоя. Она просит вас о помощи, – и, кажется, у вас нет особого выбора.\r\nЭта мистическая история разворачивается в самом сердце столицы, показывая игрокам необычные уголки настоящей, “непарадной” Москвы, которую многие жители города не замечают в спешке.', 1, '', 'Таинственная история:', 'ст. м. Пушкинская / Тверская (Пушкинский сквер)', 37.60516, 55.765197, 55.758817, 37.601063, 55.766875, 37.619945, 379.00, 379.00, 350, 4600, 2, 420.00, '', 0, 0, '21819f0aa48d5532847832a0ac0527db.jpg', '977d8b05082118b7720f017157aecbeb.jpg', 'users', NULL, 4, 1, 0, '2017-05-29 13:17:27', '2017-06-21 15:42:16', NULL),
	(49, NULL, 'Разгульная Сретенка (старый)', 'Старинный квартал «красных фонарей» в самом центре Москвы! Не верите? Совершите прогулку по знаменитой Сретенке и узнайте, как развлекались москвичи на закате Российской империи! Роскошные рестораны и гостиницы, злачные бордели и трактиры. Раскройте пикантные секреты и полузабытые легенды на увлекательном квесте «Разгульная Сретенка»!', 1, 'sret', 'Исторический квест', 'м. Трубная', 37.621884, 55.767939, 0, 0, 0, 0, 0.00, 0.00, 400, 900, 3, 350.00, '', 0, 0, '2a57c0c7260d74cb4edce4a52b3fe2b9.jpg', 'a780b1013afa785404d8756808ba1c04.jpg', 'users', NULL, 5, 1, 0, '2017-05-30 18:23:52', '2017-06-21 17:23:36', NULL),
	(51, NULL, 'Окно в модерн', 'Увлекательный квест, посвящённый творчеству Антонио Гауди. Маршрут проходит по выставке "Антонио Гауди. Барселона" в Московском музее современного искусства и центру Москвы, знакомя участников с испанской архитектурой, творческим вкладом Гауди и московским модерном.', 1, 'com.sa.mmoma', 'Квест по выставке', 'ул. Петровка, 25 (ст. м. Чеховская)', 37.614089, 55.767357, 0, 0, 0, 0, 0.00, 0.00, 380, 2150, 1, 150.00, '', 0, 0, '8166825b6c8d63261e37e185100d7bcd.jpg', 'de25a2db96c1f2e899222ba90a060127.jpg', 'promocode', NULL, 6, 1, 0, '2017-06-19 13:32:59', '2017-06-21 09:51:22', NULL),
	(52, NULL, 'Окно в Испанию', 'Ну что, вы готовы побороться за поездку в Барселону? Тогда скорее открывайте последнюю, секретную часть квеста, посвящённую Испании: её традициям, одежде, политике и искусству, и просто необычным интересным фактам! Обещаем, будет весело! :)', 1, 'com.sa.spain', 'Приключение со вкусом Испании', 'Пушкинская площадь', 37.605555, 55.76532, 0, 0, 0, 0, 0.00, 0.00, 140, 1430, 1, 100.00, '', 0, 0, 'b40b8f4b7624b6803044578672907db5.jpg', '557335a426010bdf63652de4abfb3337.jpg', 'promocode', NULL, 7, 1, 0, '2017-06-19 15:18:48', '2017-06-21 09:51:22', NULL),
	(53, NULL, 'Ах, Арбат!', 'Исторический центр Москвы – настоящая сокровищница любопытных фактов и необычных историй.\r\nНо экскурсии любят не все. А кто не любит приключения!\r\nВам предстоит узнать:\r\n- Что такое "сграффито"?\r\n- Кто охраняет принцессу Турандот?\r\n- Где находится старейший московский зоомагазин?\r\n- Как деревья связаны с Пушкином?\r\n- И, наконец, при чём здесь пчёлы?', 1, 'com.sa.arbat', 'Квест по сердцу столицы', 'ст. м. Смоленская (выход на Арбат)', 37.5836873, 55.747933, 55.747201, 37.581519, 55.753591, 37.603148, 299.00, 299.00, 335, 3400, 2, 320.00, 'Дальше!', 0, 0, 'a1c053825bd4e46b6d2658c9df497920.jpg', 'dca9c24e9be651d62e51748a4fcd0136.jpg', 'all', NULL, 9, 1, 0, '2017-06-20 12:49:14', '2017-06-21 10:33:33', NULL),
	(54, NULL, 'Тайны Патриарших', 'Патриаршие пруды — район особенный, мистический. В старину здесь было Козье болото, а в XVII веке поселился тогдашний Патриарх Всея Руси. Представляете, какая гремучая смесь? Неудивительно, что и поныне звон церковных колоколов смешивается здесь с завываниями привидений, а странностей — не перечесть.\r\n- Почему на Патриаршем пруду есть памятник Крылову, но нет памятника Булгакову?\r\n- Откуда вылетела Маргарита, намазав тело волшебной мазью?\r\n- Что за таинственный мальчик стоит у дома с чертополохом?\r\n- И сколько всё-таки должно быть прудов?', 1, 'com.sa.patrpr', 'Прогулка сквозь время', 'ст. м. Тверская / Пушкинская (Новопушкинский сквер)', 37.60429, 55.765078, 55.760973, 37.587342, 55.769998, 37.606954, 459.00, 459.00, 300, 3900, 2, 380.00, '', 0, 0, 'b7f55ec73a780e010fcbe56a44252b08.jpg', '12380fbb74d237aecf01107638892a1b.jpg', 'all', NULL, 10, 1, 0, '2017-06-20 15:58:55', '2017-06-21 13:58:00', NULL),
	(55, NULL, 'Тени прошлого', 'Вы сами не знаете когда, но однажды в ваших головах поселился робкий голос, шепот, который преследовал вас даже во снах. И вот сегодня вам впервые удалось различить слова. Дух давно погибшей женщины рассказал о деле всей своей жизни, и даже после смерти ей не найти покоя. Она просит вас о помощи, – и, кажется, у вас нет особого выбора.\r\nЭта мистическая история разворачивается в самом сердце столицы, показывая игрокам необычные уголки настоящей, “непарадной” Москвы, которую многие жители города не замечают в спешке.', 1, 'com.sa.shadows', 'Таинственная история:', 'ст. м. Пушкинская / Тверская (Пушкинский сквер)', 37.60516, 55.765197, 55.758817, 37.601063, 55.766875, 37.619945, 379.00, 379.00, 340, 4600, 2, 420.00, '', 0, 0, '74ffd59825d82236c24edc9bfec5cf2f.jpg', 'a769b60f84418a846cebd5889f645b46.jpg', 'all', NULL, 11, 1, 0, '2017-06-21 15:07:39', '2017-06-21 16:01:53', NULL),
	(56, NULL, 'Разгульная Сретенка', 'Старинный квартал «красных фонарей» в самом центре Москвы! Не верите? Совершите прогулку по знаменитой Сретенке и узнайте, как развлекались москвичи на закате Российской империи! Роскошные рестораны и гостиницы, злачные бордели и трактиры. Раскройте пикантные секреты и полузабытые легенды на увлекательном квесте «Разгульная Сретенка»!', 1, 'com.sa.sretenka', 'Исторический квест', 'м. Трубная', 37.621884, 55.767939, 0, 0, 0, 0, 0.00, 0.00, 390, 900, 3, 350.00, '', 0, 0, '2fda2deded3a7f670b1e46bc2a06f16c.jpg', '4430267cb8b4fd88387b222969e2f872.jpg', 'promocode', NULL, 12, 1, 0, '2017-06-21 16:23:27', '2017-06-22 09:21:17', NULL);
/*!40000 ALTER TABLE `quests` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.users: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Владислав', 'fallton.vm@gmail.com', '$2y$10$xB8h/5Aii67QxYMJSFWhB.8suQ3Zd4pwemRn3Mxf6t0EVk0iIGXi6', 'TOMTtZ0KShRbMEZ0u1JFqO0bjGLPvC7kku3k1x3MfE3j1c24KxNLLDS42Odd', NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
