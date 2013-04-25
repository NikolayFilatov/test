-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.27-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              7.0.0.4390
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных bludo
DROP DATABASE IF EXISTS `bludo`;
CREATE DATABASE IF NOT EXISTS `bludo` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `bludo`;


-- Дамп структуры для таблица bludo.dish
DROP TABLE IF EXISTS `dish`;
CREATE TABLE IF NOT EXISTS `dish` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.dish: ~21 rows (приблизительно)
DELETE FROM `dish`;
/*!40000 ALTER TABLE `dish` DISABLE KEYS */;
INSERT INTO `dish` (`id`, `name`, `group_id`, `created`, `deleted`) VALUES
	(31, 'Суп грибной 1/2', 9, '2013-04-18 12:30:39', 0),
	(32, 'Щи свежие 1/2', 9, '2013-04-18 12:30:40', 0),
	(33, 'Суп гороховый', 9, '2013-04-18 12:30:40', 0),
	(34, 'Окрошка', 9, '2013-04-18 12:30:40', 0),
	(35, 'Солянка', 9, '2013-04-18 12:30:40', 0),
	(36, 'Свинина по деревенски', 10, '2013-04-18 12:30:41', 0),
	(39, 'Судак по домашнему', 10, '2013-04-18 12:30:42', 0),
	(40, 'Котлета по-киевски', 10, '2013-04-18 12:30:42', 0),
	(46, 'Картофель жареный', 12, '2013-04-18 12:30:45', 0),
	(47, 'Рис', 12, '2013-04-18 12:30:45', 0),
	(48, 'Греча', 12, '2013-04-18 12:30:45', 0),
	(49, 'Пюре', 12, '2013-04-18 12:30:46', 0),
	(50, 'Макароны', 12, '2013-04-18 12:30:47', 0),
	(51, 'Морс', 13, '2013-04-18 12:30:48', 0),
	(52, 'Сок яблочный', 13, '2013-04-18 12:30:48', 0),
	(53, 'Сок апельсиновый', 13, '2013-04-18 12:30:48', 0),
	(54, 'Сок ананасовый', 13, '2013-04-18 12:30:49', 0),
	(55, 'Молоко', 13, '2013-04-18 12:30:50', 0),
	(57, 'Свинина по деревенски с рисом', 16, '2013-04-19 11:22:01', 0),
	(58, 'Свинина по деревенски с пюре', 16, '2013-04-19 13:54:26', 0),
	(59, 'Новое блюдо2', 12, '2013-04-22 06:42:28', 1);
/*!40000 ALTER TABLE `dish` ENABLE KEYS */;


-- Дамп структуры для таблица bludo.dish_group
DROP TABLE IF EXISTS `dish_group`;
CREATE TABLE IF NOT EXISTS `dish_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `level` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.dish_group: ~5 rows (приблизительно)
DELETE FROM `dish_group`;
/*!40000 ALTER TABLE `dish_group` DISABLE KEYS */;
INSERT INTO `dish_group` (`id`, `name`, `created`, `level`) VALUES
	(9, 'Первые блюда', '2013-04-18 12:30:39', 1),
	(10, 'Вторые блюда', '2013-04-18 12:30:41', 2),
	(12, 'Гарниры', '2013-04-18 12:30:44', 3),
	(13, 'Напитки', '2013-04-18 12:30:47', 5),
	(16, 'Специальные предложения', '2013-04-19 11:21:43', 4);
/*!40000 ALTER TABLE `dish_group` ENABLE KEYS */;


-- Дамп структуры для таблица bludo.menu
DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `dish_id` int(11) DEFAULT NULL,
  `deleted` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `dish_id` (`dish_id`)
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.menu: ~122 rows (приблизительно)
DELETE FROM `menu`;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `date`, `dish_id`, `deleted`) VALUES
	(73, '2013-04-18 00:00:00', 31, 0),
	(74, '2013-04-18 00:00:00', 32, 0),
	(75, '2013-04-18 00:00:00', 33, 0),
	(76, '2013-04-18 00:00:00', 34, 0),
	(77, '2013-04-18 00:00:00', 35, 0),
	(78, '2013-04-18 00:00:00', 36, 0),
	(79, '2013-04-18 00:00:00', 39, 0),
	(80, '2013-04-18 00:00:00', 40, 0),
	(81, '2013-04-18 00:00:00', 46, 0),
	(82, '2013-04-18 00:00:00', 47, 0),
	(83, '2013-04-18 00:00:00', 48, 0),
	(84, '2013-04-18 00:00:00', 49, 0),
	(85, '2013-04-18 00:00:00', 50, 0),
	(86, '2013-04-18 00:00:00', 59, 0),
	(87, '2013-04-18 00:00:00', 51, 0),
	(88, '2013-04-18 00:00:00', 52, 0),
	(89, '2013-04-18 00:00:00', 53, 0),
	(90, '2013-04-18 00:00:00', 54, 0),
	(91, '2013-04-18 00:00:00', 55, 0),
	(92, '2013-04-18 00:00:00', 57, 0),
	(93, '2013-04-18 00:00:00', 58, 0),
	(115, '2013-04-22 00:00:00', 31, 0),
	(116, '2013-04-22 00:00:00', 32, 0),
	(117, '2013-04-22 00:00:00', 33, 0),
	(118, '2013-04-22 00:00:00', 34, 0),
	(119, '2013-04-22 00:00:00', 35, 0),
	(120, '2013-04-22 00:00:00', 36, 0),
	(121, '2013-04-22 00:00:00', 39, 0),
	(122, '2013-04-22 00:00:00', 40, 0),
	(123, '2013-04-22 00:00:00', 46, 0),
	(124, '2013-04-22 00:00:00', 47, 0),
	(125, '2013-04-22 00:00:00', 48, 0),
	(126, '2013-04-22 00:00:00', 49, 0),
	(127, '2013-04-22 00:00:00', 50, 0),
	(128, '2013-04-22 00:00:00', 59, 0),
	(129, '2013-04-22 00:00:00', 51, 0),
	(130, '2013-04-22 00:00:00', 52, 0),
	(131, '2013-04-22 00:00:00', 53, 0),
	(132, '2013-04-22 00:00:00', 54, 0),
	(133, '2013-04-22 00:00:00', 55, 0),
	(134, '2013-04-22 00:00:00', 57, 0),
	(135, '2013-04-22 00:00:00', 58, 0),
	(157, '2013-04-24 00:00:00', 31, 0),
	(158, '2013-04-24 00:00:00', 32, 0),
	(159, '2013-04-24 00:00:00', 33, 0),
	(160, '2013-04-24 00:00:00', 34, 0),
	(161, '2013-04-24 00:00:00', 35, 0),
	(162, '2013-04-24 00:00:00', 36, 0),
	(163, '2013-04-24 00:00:00', 39, 0),
	(164, '2013-04-24 00:00:00', 40, 0),
	(165, '2013-04-24 00:00:00', 46, 0),
	(166, '2013-04-24 00:00:00', 47, 0),
	(167, '2013-04-24 00:00:00', 48, 0),
	(168, '2013-04-24 00:00:00', 49, 0),
	(169, '2013-04-24 00:00:00', 50, 0),
	(170, '2013-04-24 00:00:00', 51, 0),
	(171, '2013-04-24 00:00:00', 52, 0),
	(172, '2013-04-24 00:00:00', 53, 0),
	(173, '2013-04-24 00:00:00', 54, 0),
	(174, '2013-04-24 00:00:00', 55, 0),
	(175, '2013-04-24 00:00:00', 57, 0),
	(176, '2013-04-24 00:00:00', 58, 0),
	(217, '2013-04-23 00:00:00', 31, 0),
	(218, '2013-04-23 00:00:00', 32, 0),
	(219, '2013-04-23 00:00:00', 33, 0),
	(220, '2013-04-23 00:00:00', 34, 0),
	(221, '2013-04-23 00:00:00', 35, 0),
	(222, '2013-04-23 00:00:00', 36, 0),
	(223, '2013-04-23 00:00:00', 39, 0),
	(224, '2013-04-23 00:00:00', 40, 0),
	(225, '2013-04-23 00:00:00', 46, 0),
	(226, '2013-04-23 00:00:00', 47, 0),
	(227, '2013-04-23 00:00:00', 48, 0),
	(228, '2013-04-23 00:00:00', 49, 0),
	(229, '2013-04-23 00:00:00', 50, 0),
	(230, '2013-04-23 00:00:00', 51, 0),
	(231, '2013-04-23 00:00:00', 52, 0),
	(232, '2013-04-23 00:00:00', 53, 0),
	(233, '2013-04-23 00:00:00', 54, 0),
	(234, '2013-04-23 00:00:00', 55, 0),
	(235, '2013-04-23 00:00:00', 57, 0),
	(236, '2013-04-23 00:00:00', 58, 0),
	(257, '2013-04-26 00:00:00', 31, 0),
	(258, '2013-04-26 00:00:00', 32, 0),
	(259, '2013-04-26 00:00:00', 33, 0),
	(260, '2013-04-26 00:00:00', 34, 0),
	(261, '2013-04-26 00:00:00', 35, 0),
	(262, '2013-04-26 00:00:00', 36, 0),
	(263, '2013-04-26 00:00:00', 39, 0),
	(264, '2013-04-26 00:00:00', 40, 0),
	(265, '2013-04-26 00:00:00', 46, 0),
	(266, '2013-04-26 00:00:00', 47, 0),
	(267, '2013-04-26 00:00:00', 48, 0),
	(268, '2013-04-26 00:00:00', 49, 0),
	(269, '2013-04-26 00:00:00', 50, 0),
	(270, '2013-04-26 00:00:00', 51, 0),
	(271, '2013-04-26 00:00:00', 52, 0),
	(272, '2013-04-26 00:00:00', 53, 0),
	(273, '2013-04-26 00:00:00', 54, 0),
	(274, '2013-04-26 00:00:00', 55, 0),
	(275, '2013-04-26 00:00:00', 57, 0),
	(276, '2013-04-26 00:00:00', 58, 0),
	(277, '2013-04-25 00:00:00', 31, 0),
	(278, '2013-04-25 00:00:00', 32, 0),
	(279, '2013-04-25 00:00:00', 33, 0),
	(280, '2013-04-25 00:00:00', 34, 0),
	(281, '2013-04-25 00:00:00', 35, 0),
	(282, '2013-04-25 00:00:00', 36, 0),
	(283, '2013-04-25 00:00:00', 39, 0),
	(284, '2013-04-25 00:00:00', 40, 0),
	(285, '2013-04-25 00:00:00', 46, 0),
	(286, '2013-04-25 00:00:00', 47, 0),
	(287, '2013-04-25 00:00:00', 48, 0),
	(288, '2013-04-25 00:00:00', 49, 0),
	(289, '2013-04-25 00:00:00', 50, 0),
	(290, '2013-04-25 00:00:00', 51, 0),
	(291, '2013-04-25 00:00:00', 52, 0),
	(292, '2013-04-25 00:00:00', 53, 0),
	(293, '2013-04-25 00:00:00', 54, 0),
	(294, '2013-04-25 00:00:00', 55, 0),
	(295, '2013-04-25 00:00:00', 57, 0),
	(296, '2013-04-25 00:00:00', 58, 0);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;


-- Дамп структуры для таблица bludo.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `storage_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `storage_id` (`storage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.orders: ~4 rows (приблизительно)
DELETE FROM `orders`;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `user_id`, `storage_id`) VALUES
	(13, 1, 2),
	(14, 2, 2),
	(15, 2, 3),
	(16, 3, 2),
	(17, 1, 4),
	(18, 4, 4),
	(20, 3, 4),
	(21, 2, 4);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;


-- Дамп структуры для таблица bludo.order_item
DROP TABLE IF EXISTS `order_item`;
CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dish_id` int(10) DEFAULT NULL,
  `order_id` int(10) DEFAULT NULL,
  `count` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`dish_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.order_item: ~12 rows (приблизительно)
DELETE FROM `order_item`;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` (`id`, `dish_id`, `order_id`, `count`) VALUES
	(41, 31, 13, 1),
	(44, 36, 13, 1),
	(45, 36, 14, 1),
	(46, 33, 14, 1),
	(47, 52, 14, 1),
	(48, 33, 15, 1),
	(49, 48, 15, 1),
	(50, 49, 15, 1),
	(51, 55, 15, 1),
	(52, 55, 16, 1),
	(53, 35, 16, 1),
	(54, 54, 16, 1),
	(55, 36, 17, 1),
	(56, 53, 17, 1),
	(57, 53, 18, 1),
	(58, 35, 18, 1),
	(59, 49, 20, 1),
	(60, 35, 20, 1),
	(61, 54, 20, 1),
	(62, 34, 21, 1),
	(63, 48, 21, 1),
	(64, 36, 21, 1),
	(65, 55, 21, 1);
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;


-- Дамп структуры для таблица bludo.order_storage
DROP TABLE IF EXISTS `order_storage`;
CREATE TABLE IF NOT EXISTS `order_storage` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.order_storage: ~2 rows (приблизительно)
DELETE FROM `order_storage`;
/*!40000 ALTER TABLE `order_storage` DISABLE KEYS */;
INSERT INTO `order_storage` (`id`, `date`, `status`) VALUES
	(2, '2013-04-24 00:00:00', 'close'),
	(3, '2013-04-23 00:00:00', 'close'),
	(4, '2013-04-25 00:00:00', 'close'),
	(5, '2013-04-27 00:00:00', NULL);
/*!40000 ALTER TABLE `order_storage` ENABLE KEYS */;


-- Дамп структуры для таблица bludo.price
DROP TABLE IF EXISTS `price`;
CREATE TABLE IF NOT EXISTS `price` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `dish_id` int(11) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `dish_id` (`dish_id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.price: ~21 rows (приблизительно)
DELETE FROM `price`;
/*!40000 ALTER TABLE `price` DISABLE KEYS */;
INSERT INTO `price` (`id`, `date`, `dish_id`, `cost`) VALUES
	(71, '2013-04-18 22:00:00', 31, 30),
	(72, '2013-04-18 22:00:00', 32, 45),
	(73, '2013-04-18 22:00:00', 33, 30),
	(74, '2013-04-18 22:00:00', 34, 30),
	(75, '2013-04-18 22:00:00', 35, 35),
	(76, '2013-04-18 22:00:00', 36, 140),
	(77, '2013-04-18 22:00:00', 39, 140),
	(78, '2013-04-18 22:00:00', 40, 140),
	(79, '2013-04-18 22:00:00', 46, 40),
	(80, '2013-04-18 22:00:00', 47, 40),
	(81, '2013-04-18 22:00:00', 48, 40),
	(82, '2013-04-18 22:00:00', 49, 40),
	(83, '2013-04-18 22:00:00', 50, 40),
	(84, '2013-04-18 22:00:00', 51, 30),
	(85, '2013-04-18 22:00:00', 52, 40),
	(86, '2013-04-18 22:00:00', 53, 40),
	(87, '2013-04-18 22:00:00', 54, 40),
	(88, '2013-04-18 22:00:00', 55, 25),
	(89, '2013-04-18 22:00:00', 57, 160),
	(90, '2013-04-18 22:00:00', 58, 160),
	(91, '2013-04-23 00:00:00', 31, 35),
	(92, '2013-04-25 00:00:00', 31, 35);
/*!40000 ALTER TABLE `price` ENABLE KEYS */;


-- Дамп структуры для таблица bludo.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `backcolor` varchar(7) DEFAULT 'FFFFFF',
  `color` varchar(7) DEFAULT '000000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.user: ~4 rows (приблизительно)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `email`, `password`, `state`, `created`, `backcolor`, `color`) VALUES
	(1, 'Николай Филатов', '2519483@gmail.com', '$2y$14$y8bIOoBBFJ.NFbQN9lqMAeKA3dzWQDerlWCA60UheTJn4ZETEYfNW', NULL, '2013-04-18 07:15:34', '#3b8cd9', '#fdf6f6'),
	(2, 'Три три три', '333@333.ru', '$2y$14$KIPU1NpIjk06G4xL9BJ4y.1tDnaTLHKjim8z9OnediLU15XOtr75u', NULL, '2013-04-18 13:23:21', '#26ff00', '#ff4900'),
	(3, 'Иванов Иван', '111@111.ru', '$2y$14$njqvOyBndlW4Hd6cJMP4OedTpUpa/AG3Cl9wRvEd3s6kVy2E9RDdu', NULL, '2013-04-23 11:33:57', '#b56eb7', '#0a0000'),
	(4, 'Второй пользователь', '222@222.ru', '$2y$14$Fodszef3Q1/T15ub1Ye3g.nQH/jLE7Ud0zM2i3BSJE3kuuVGtkM.O', NULL, '2013-04-23 11:38:52', '#53d0f9', '#2c54c0'),
	(5, 'Мое имя2', '321654@321.ru', '$2y$14$WKjNYhcIyUrgFElKBmGtNOqOOPFktM.xkI41jseH0Mn5.SSi/TLoq', NULL, '2013-04-25 10:07:10', '#88aeea', '#8c0ea3');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
