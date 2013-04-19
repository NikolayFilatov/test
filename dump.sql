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
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.dish: ~20 rows (приблизительно)
DELETE FROM `dish`;
/*!40000 ALTER TABLE `dish` DISABLE KEYS */;
INSERT INTO `dish` (`id`, `name`, `group_id`, `created`) VALUES
	(31, 'Суп грибной', 9, '2013-04-18 12:30:39'),
	(32, 'Щи свежие', 9, '2013-04-18 12:30:40'),
	(33, 'Суп гороховый', 9, '2013-04-18 12:30:40'),
	(34, 'Окрошка', 9, '2013-04-18 12:30:40'),
	(35, 'Солянка', 9, '2013-04-18 12:30:40'),
	(36, 'Свинина по деревенски', 10, '2013-04-18 12:30:41'),
	(39, 'Судак по домашнему', 10, '2013-04-18 12:30:42'),
	(40, 'Котлета по-киевски', 10, '2013-04-18 12:30:42'),
	(46, 'Картофель жареный', 12, '2013-04-18 12:30:45'),
	(47, 'Рис', 12, '2013-04-18 12:30:45'),
	(48, 'Греча', 12, '2013-04-18 12:30:45'),
	(49, 'Пюре', 12, '2013-04-18 12:30:46'),
	(50, 'Макароны', 12, '2013-04-18 12:30:47'),
	(51, 'Морс', 13, '2013-04-18 12:30:48'),
	(52, 'Сок яблочный', 13, '2013-04-18 12:30:48'),
	(53, 'Сок апельсиновый', 13, '2013-04-18 12:30:48'),
	(54, 'Сок ананасовый', 13, '2013-04-18 12:30:49'),
	(55, 'Молоко', 13, '2013-04-18 12:30:50'),
	(57, 'Свинина по деревенски с рисом', 16, '2013-04-19 11:22:01'),
	(58, 'Свинина по деревенски с пюре', 16, '2013-04-19 13:54:26');
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`id`),
  KEY `dish_id` (`dish_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы bludo.menu: ~25 rows (приблизительно)
DELETE FROM `menu`;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `date`, `dish_id`) VALUES
	(6, '2013-04-17 22:00:00', 31),
	(7, '2013-04-17 22:00:00', 32),
	(8, '2013-04-17 22:00:00', 33),
	(9, '2013-04-17 22:00:00', 34),
	(10, '2013-04-17 22:00:00', 35),
	(11, '2013-04-17 22:00:00', 36),
	(12, '2013-04-17 22:00:00', 37),
	(13, '2013-04-17 22:00:00', 38),
	(14, '2013-04-17 22:00:00', 39),
	(15, '2013-04-17 22:00:00', 40),
	(16, '2013-04-17 22:00:00', 41),
	(17, '2013-04-17 22:00:00', 42),
	(18, '2013-04-17 22:00:00', 43),
	(19, '2013-04-17 22:00:00', 44),
	(20, '2013-04-17 22:00:00', 45),
	(21, '2013-04-17 22:00:00', 46),
	(22, '2013-04-17 22:00:00', 47),
	(23, '2013-04-17 22:00:00', 48),
	(24, '2013-04-17 22:00:00', 49),
	(25, '2013-04-17 22:00:00', 50),
	(26, '2013-04-17 22:00:00', 51),
	(27, '2013-04-17 22:00:00', 52),
	(28, '2013-04-17 22:00:00', 53),
	(29, '2013-04-17 22:00:00', 54),
	(30, '2013-04-17 22:00:00', 55);
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

-- Дамп данных таблицы bludo.order_item: ~5 rows (приблизительно)
DELETE FROM `order_item`;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` (`id`, `menu_id`, `order_id`, `count`) VALUES
	(1, 11, 1, 1),
	(2, 17, 1, 1),
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
