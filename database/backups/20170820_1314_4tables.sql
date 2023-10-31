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

-- Дамп структуры для таблица sa-new-admin.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `menuID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sub` int(10) unsigned NOT NULL,
  `route` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `sort_number` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`menuID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы sa-new-admin.menus: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` (`menuID`, `sub`, `route`, `name`, `icon`, `sort_number`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, 'Квесты', 'zmdi-view-list', 1, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(2, 1, NULL, 'Категории квестов', 'zmdi-assignment', 2, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(3, 1, NULL, 'Города', 'zmdi-globe', 3, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(4, 1, NULL, 'Языки', 'zmdi-flag', 4, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(5, 1, NULL, 'Пользователи', 'zmdi-accounts', 5, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(6, 1, NULL, 'Роли пользователей', 'zmdi-account-box-mail', 6, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(7, 0, 'admin_settings_edit', 'Настройки', 'zmdi-settings', 7, '2017-08-16 09:16:29', '2017-08-16 09:16:29');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.menus_items
CREATE TABLE IF NOT EXISTS `menus_items` (
  `itemID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menuID` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы sa-new-admin.menus_items: ~12 rows (приблизительно)
/*!40000 ALTER TABLE `menus_items` DISABLE KEYS */;
INSERT INTO `menus_items` (`itemID`, `menuID`, `name`, `route`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Список квестов', 'admin_quests_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(2, 1, 'Новый квест', 'admin_quests_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(3, 2, 'Список категорий', 'admin_categories_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(4, 2, 'Новая категория', 'admin_categories_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(5, 3, 'Список городов', 'admin_cities_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(6, 3, 'Новый город', 'admin_cities_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(7, 4, 'Список языков', 'admin_languages_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(8, 4, 'Новый язык', 'admin_languages_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(9, 5, 'Список пользователей', 'admin_users_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(10, 5, 'Новый пользователь', 'admin_users_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(11, 6, 'Список ролей', 'admin_roles_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(12, 6, 'Новая роль', 'admin_roles_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29');
/*!40000 ALTER TABLE `menus_items` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `roleID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `menusIDs` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы sa-new-admin.roles: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`roleID`, `name`, `menusIDs`, `created_at`, `updated_at`) VALUES
	(1, 'Администратор', '1,2,3,4,5,6,7', '2017-08-16 09:16:29', '2017-08-20 09:13:45'),
	(2, 'Редактор', '1,2,3,4', '2017-08-16 09:16:58', '2017-08-20 09:14:05'),
	(3, 'Сценарист', '1', '2017-08-17 07:28:46', '2017-08-20 09:14:13');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;


-- Дамп структуры для таблица sa-new-admin.users
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `roleID` int(10) unsigned NOT NULL,
  `cityID` int(10) unsigned NOT NULL,
  `writer_questsIDs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vkontakte_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- Дамп данных таблицы sa-new-admin.users: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`userID`, `name`, `email`, `password`, `token`, `push_token`, `os_type`, `avatar`, `roleID`, `cityID`, `writer_questsIDs`, `facebook_id`, `vkontakte_id`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Владислав Моцный', 'fallton.vm@gmail.com', '$2y$10$xB8h/5Aii67QxYMJSFWhB.8suQ3Zd4pwemRn3Mxf6t0EVk0iIGXi6', NULL, NULL, NULL, 'a4ac1165831489b6f69cf2e0b69f80be.jpg', 1, 1, NULL, '0', NULL, 'SghNjR12h9qnYKAFWslIBTWLk9FOUkmWPrPdexg8dn1HqjLjGWdi8rzsVnlY', NULL, '2017-08-20 09:04:49'),
	(2, 'Юлия Реутова', 'streetadventuremsk@gmail.com', '$2y$10$xB8h/5Aii67QxYMJSFWhB.8suQ3Zd4pwemRn3Mxf6t0EVk0iIGXi6', NULL, NULL, NULL, '9abfd1fc5a53899d999f002969146aef.jpg', 1, 1, NULL, '0', NULL, 'psfMaaapqni84bPU31DabLRtSN0xXAChOyUy3besEX1zQSH8vkrpU27LLGql', NULL, '2017-08-20 05:30:57'),
	(5, 'Test user', 'vl86@bk.ru', '$2y$10$xDJhK5EQF6dNpHjIvCDUuOCLg2AgEmEume687P4gKyn4IIJlj3kpO', NULL, NULL, NULL, 'avatar.png', 3, 1, '31', NULL, NULL, 'dNszhEIszVMlmoytOPoH47Mudf3G8FiaxiYJvRapptXpRWvtiXP1nmP5Fd6P', '2017-08-17 08:53:08', '2017-08-20 09:05:03');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
