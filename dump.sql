-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.27-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              7.0.0.4389
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

-- Дамп данных таблицы bludo.dish: ~20 rows (приблизительно)
DELETE FROM `dish`;
/*!40000 ALTER TABLE `dish` DISABLE KEYS */;
INSERT INTO `dish` (`id`, `name`, `group_id`, `created`, `deleted`) VALUES
	(31, 'Суп грибной', 9, '2013-04-18 12:30:39', 0),
	(32, 'Щи свежие', 9, '2013-04-18 12:30:40', 0),
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
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.menu: ~24 rows (приблизительно)
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
	(136, '2013-04-23 00:00:00', 31, 0),
	(137, '2013-04-23 00:00:00', 32, 0),
	(138, '2013-04-23 00:00:00', 33, 1),
	(139, '2013-04-23 00:00:00', 34, 0),
	(140, '2013-04-23 00:00:00', 35, 0),
	(141, '2013-04-23 00:00:00', 36, 0),
	(142, '2013-04-23 00:00:00', 39, 0),
	(143, '2013-04-23 00:00:00', 40, 0),
	(144, '2013-04-23 00:00:00', 46, 0),
	(145, '2013-04-23 00:00:00', 47, 0),
	(146, '2013-04-23 00:00:00', 48, 0),
	(147, '2013-04-23 00:00:00', 49, 0),
	(148, '2013-04-23 00:00:00', 50, 0),
	(149, '2013-04-23 00:00:00', 59, 0),
	(150, '2013-04-23 00:00:00', 51, 0),
	(151, '2013-04-23 00:00:00', 52, 0),
	(152, '2013-04-23 00:00:00', 53, 0),
	(153, '2013-04-23 00:00:00', 54, 0),
	(154, '2013-04-23 00:00:00', 55, 0),
	(155, '2013-04-23 00:00:00', 57, 0),
	(156, '2013-04-23 00:00:00', 58, 0);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;


-- Дамп структуры для таблица bludo.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.orders: ~2 rows (приблизительно)
DELETE FROM `orders`;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `user_id`, `date`) VALUES
	(1, 1, '2013-04-17 22:00:00'),
	(2, 2, '2013-04-17 22:00:00');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;


-- Дамп структуры для таблица bludo.order_item
DROP TABLE IF EXISTS `order_item`;
CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) DEFAULT NULL,
  `order_id` int(10) DEFAULT NULL,
  `count` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.order_item: ~4 rows (приблизительно)
DELETE FROM `order_item`;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` (`id`, `menu_id`, `order_id`, `count`) VALUES
	(1, 11, 1, 1),
	(3, 25, 1, 1),
	(5, 12, 2, 1),
	(6, 19, 2, 1);
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.price: ~20 rows (приблизительно)
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
	(90, '2013-04-18 22:00:00', 58, 160);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.user: ~2 rows (приблизительно)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `email`, `password`, `state`, `created`) VALUES
	(1, NULL, '2519483@gmail.com', '$2y$14$y8bIOoBBFJ.NFbQN9lqMAeKA3dzWQDerlWCA60UheTJn4ZETEYfNW', NULL, '2013-04-18 07:15:34'),
	(2, NULL, '333@333.ru', '$2y$14$KIPU1NpIjk06G4xL9BJ4y.1tDnaTLHKjim8z9OnediLU15XOtr75u', NULL, '2013-04-18 13:23:21');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
