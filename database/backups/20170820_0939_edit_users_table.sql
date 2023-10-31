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

-- Дамп данных таблицы sa-new-admin.users: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`userID`, `name`, `email`, `password`, `token`, `push_token`, `os_type`, `avatar`, `roleID`, `cityID`, `writer_questsIDs`, `facebook_id`, `vkontakte_id`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Владислав Моцный', 'fallton.vm@gmail.com', '$2y$10$xB8h/5Aii67QxYMJSFWhB.8suQ3Zd4pwemRn3Mxf6t0EVk0iIGXi6', NULL, NULL, NULL, 'a4ac1165831489b6f69cf2e0b69f80be.jpg', 1, 1, NULL, '0', NULL, 'kTi2iRtc25yhoVyRvigmxSyiN1dlEzc6NR43XXduuWYJTc1wx60pgzlIYhtf', NULL, '2017-08-20 05:20:59'),
	(2, 'Юлия Реутова', 'streetadventuremsk@gmail.com', '$2y$10$xB8h/5Aii67QxYMJSFWhB.8suQ3Zd4pwemRn3Mxf6t0EVk0iIGXi6', NULL, NULL, NULL, '9abfd1fc5a53899d999f002969146aef.jpg', 1, 1, NULL, '0', NULL, 'GSB7zzp4CkADDhkRQ1YCCvw3hEk7oS6mFjS6rT0zuifIaybWSJLHLakF1CMi', NULL, '2017-08-20 05:30:57'),
	(5, 'Test user', 'vl86@bk.ru', '$2y$10$xDJhK5EQF6dNpHjIvCDUuOCLg2AgEmEume687P4gKyn4IIJlj3kpO', NULL, NULL, NULL, '9652399d37cee1874d48b8e4e3f029d8.jpg', 2, 1, '31,32', NULL, NULL, 'nRLonoUXBgonhUS3SO4orjPMOSgebsIUO67ykw5bacspm1WyH8kEVraVbgyP', '2017-08-17 08:53:08', '2017-08-20 05:20:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
