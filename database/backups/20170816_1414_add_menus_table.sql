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
	(1, 0, 'admin_dashboard', 'Главная', 'zmdi-view-dashboard', 1, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(2, 1, NULL, 'Квесты', 'zmdi-view-list', 2, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(3, 1, NULL, 'Категории квестов', 'zmdi-assignment', 3, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(4, 1, NULL, 'Города', 'zmdi-globe', 4, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(5, 1, NULL, 'Языки', 'zmdi-flag', 5, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(6, 1, NULL, 'Пользователи', 'zmdi-accounts', 6, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(7, 1, NULL, 'Роли пользователей', 'zmdi-account-box-mail', 7, '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(8, 0, 'admin_settings_edit', 'Настройки', 'zmdi-settings', 8, '2017-08-16 09:16:29', '2017-08-16 09:16:29');
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
	(1, 2, 'Список квестов', 'admin_quests_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(2, 2, 'Новый квест', 'admin_quests_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(3, 3, 'Список категорий', 'admin_categories_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(4, 3, 'Новая категория', 'admin_categories_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(5, 4, 'Список городов', 'admin_cities_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(6, 4, 'Новый город', 'admin_cities_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(7, 5, 'Список языков', 'admin_languages_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(8, 5, 'Новый язык', 'admin_languages_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(9, 6, 'Список пользователей', 'admin_users_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(10, 6, 'Новый пользователь', 'admin_users_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(11, 7, 'Список ролей', 'admin_roles_list', '2017-08-16 09:16:29', '2017-08-16 09:16:29'),
	(12, 7, 'Новая роль', 'admin_roles_edit', '2017-08-16 09:16:29', '2017-08-16 09:16:29');
/*!40000 ALTER TABLE `menus_items` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
