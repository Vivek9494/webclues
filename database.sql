-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `cars`;
CREATE TABLE `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_photo` text,
  `car_name` varchar(50) NOT NULL,
  `car_color` varchar(10) NOT NULL,
  `car_fuel` int(1) NOT NULL COMMENT '1-Petrol,2-Diesel,3-CNG',
  `car_description` text NOT NULL,
  `car_date` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `cars` (`id`, `car_photo`, `car_name`, `car_color`, `car_fuel`, `car_description`, `car_date`, `status`) VALUES
(1,	'1588792160_464.JPG',	'Honda SUV',	'black',	3,	'Hello Thre adad',	'2000-02-08',	0),
(17,	'1588790758_244.JPG',	'Honda Amaze',	'white',	3,	'Red Color insane',	'2013-06-11',	1);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1,	'vivek',	'admin@admin.com',	'test');

-- 2020-05-06 19:10:26
