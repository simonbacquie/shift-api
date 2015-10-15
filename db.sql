-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `shifts`;
CREATE TABLE `shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manager_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `break` float DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `shifts` (`id`, `manager_id`, `employee_id`, `break`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 2,  1,  1.5,  '2015-10-11 12:20:38',  '2015-10-11 19:20:38',  '2015-10-11 12:20:38',  '2015-10-11 12:20:38'),
(2, 2,  3,  1.5,  '2015-10-11 12:29:36',  '2015-10-11 16:29:36',  '2015-10-15 15:20:18',  '2015-10-15 15:20:18'),
(3, 2,  1,  NULL, '2015-01-01 00:00:00',  '2015-01-01 06:00:00',  '2015-10-14 23:23:16',  '2015-10-14 23:23:16'),
(16,  2,  1,  NULL, '2015-02-01 00:00:00',  '2015-02-01 08:00:00',  '2015-10-15 11:33:58',  '2015-10-15 11:33:58'),
(17,  2,  1,  NULL, '2015-02-03 00:00:00',  '2015-02-03 20:16:00',  '2015-10-15 11:49:35',  '2015-10-15 11:49:35');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('employee','manager') COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `name`, `role`, `email`, `phone`, `created_at`, `updated_at`, `password`) VALUES
(1, 'Peter',  'employee', 'peter@innitech.com', '9540001111', '2015-10-10 22:25:06',  '2015-10-10 22:25:06',  '8485ebd1189f167313d6b28618a7b83f70d4fd84'),
(2, 'Lumbergh', 'manager',  'lumbergh@innitech.com',  '6660006660', '2015-10-11 12:22:05',  '2015-10-11 12:22:05',  '3491e6c6121c11030677673a743529c0880c4580'),
(3, 'Joanna', 'employee', 'joanna@schlotzskys.net', '4010005555', '2015-10-15 12:30:37',  '2015-10-15 12:30:37',  '1ed7ca593b88f7f60184148229d12ec31e6b9d7c'),
(4, 'Michael',  'employee', 'mbolton@intertrode.com', '8081113030', '2015-10-15 12:33:44',  '2015-10-15 12:33:44',  '29aca3000830d0e280082e591f0c070e6545f969'),
(5, 'Bob',  'manager',  'bob@consultants.net',  '9991116606', '2015-10-15 12:35:03',  '2015-10-15 12:35:03',  '4a342b11502d79ddc41062b8a77e2e8ccb4c416c');

-- 2015-10-15 15:34:05
