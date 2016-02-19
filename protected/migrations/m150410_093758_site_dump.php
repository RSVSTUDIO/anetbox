<?php

class m150410_093758_site_dump extends EDbMigration
{
	public function up()
	{
        $this->execute("
            SET NAMES utf8;
            SET time_zone = '+00:00';
            SET foreign_key_checks = 0;
            SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

            DROP TABLE IF EXISTS `user_instruments`;
            CREATE TABLE `user_instruments` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `title` varchar(100) NOT NULL,
              `description` varchar(250) DEFAULT NULL,
              `url` varchar(250) NOT NULL,
              `cpa` tinyint(1) DEFAULT NULL,
              `cpc` tinyint(1) DEFAULT NULL,
              `cpv` tinyint(1) DEFAULT NULL,
              `driver` varchar(50) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            INSERT INTO `user_instruments` (`id`, `title`, `description`, `url`, `cpa`, `cpc`, `cpv`, `driver`) VALUES
            (1,	'AnetBOX',	'Сеть AnetBOX',	'anetbox.shermancmd.com',	NULL,	NULL,	NULL,	NULL),
            (4,	'AdSense',	'Google AdSense',	'www.google.com/adsense',	1,	1,	1,	'AdSenseApi'),
            (5,	'TeaserNET',	NULL,	'teasernet.com',	1,	NULL,	NULL,	NULL),
            (6,	'Direct Advert',	NULL,	'directadvert.ru',	NULL,	1,	1,	NULL),
            (9,	'AdmitAd',	NULL,	'admitad.com',	NULL,	1,	1,	NULL);

            DROP TABLE IF EXISTS `user_instruments_data`;
            CREATE TABLE `user_instruments_data` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `site_id` int(11) NOT NULL,
              `instrument_id` int(11) NOT NULL,
              `pages` bigint(20) DEFAULT NULL,
              `users` bigint(20) DEFAULT NULL,
              `views` bigint(20) DEFAULT NULL,
              `clicks` bigint(20) DEFAULT NULL,
              `actions` bigint(20) DEFAULT NULL,
              `recdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `site_id` (`site_id`),
              KEY `instrument_id` (`instrument_id`),
              CONSTRAINT `user_instruments_data_instrument_id` FOREIGN KEY (`instrument_id`) REFERENCES `user_instruments` (`id`) ON DELETE CASCADE,
              CONSTRAINT `user_instruments_data_site_id` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            INSERT INTO `user_instruments_data` (`id`, `site_id`, `instrument_id`, `pages`, `users`, `views`, `clicks`, `actions`, `recdate`) VALUES
            (109,	1,	1,	NULL,	NULL,	8,	NULL,	NULL,	'2015-03-24 08:33:21'),
            (110,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-24 10:30:04'),
            (111,	2,	1,	NULL,	NULL,	4,	NULL,	NULL,	'2015-03-24 11:42:24'),
            (112,	1,	1,	NULL,	NULL,	6,	NULL,	NULL,	'2015-03-24 11:57:16'),
            (113,	3,	1,	NULL,	NULL,	5,	NULL,	NULL,	'2015-03-24 12:04:12'),
            (114,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-24 14:11:07'),
            (115,	1,	1,	NULL,	NULL,	8,	NULL,	NULL,	'2015-03-25 00:05:35'),
            (116,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-25 00:09:12'),
            (117,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-25 01:27:59'),
            (118,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-25 01:58:49'),
            (119,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-25 03:27:35'),
            (120,	1,	1,	NULL,	NULL,	3,	NULL,	NULL,	'2015-03-25 05:30:22'),
            (121,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-25 06:00:14'),
            (122,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-25 08:25:43'),
            (123,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-25 08:38:15'),
            (124,	1,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-25 10:57:06'),
            (125,	1,	1,	NULL,	NULL,	4,	NULL,	NULL,	'2015-03-25 12:03:00'),
            (126,	1,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-25 14:48:36'),
            (127,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-25 23:17:48'),
            (128,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-26 00:09:38'),
            (129,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-26 02:40:29'),
            (130,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-26 03:48:21'),
            (131,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-26 05:42:00'),
            (132,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-26 09:01:41'),
            (133,	1,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-26 09:33:50'),
            (134,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-27 00:08:19'),
            (135,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-27 02:49:44'),
            (136,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-27 03:52:32'),
            (137,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-27 04:13:46'),
            (138,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-27 06:36:42'),
            (139,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-27 08:28:57'),
            (140,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-27 08:32:34'),
            (141,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-27 10:18:32'),
            (142,	3,	1,	NULL,	NULL,	7,	NULL,	NULL,	'2015-03-27 11:29:54'),
            (143,	2,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-27 14:44:16'),
            (144,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-27 14:57:38'),
            (145,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-27 16:41:54'),
            (146,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-28 09:33:39'),
            (148,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-29 04:19:35'),
            (149,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-30 04:07:13'),
            (150,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-30 07:56:25'),
            (151,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-30 09:57:52'),
            (152,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-30 11:35:01'),
            (153,	3,	1,	NULL,	NULL,	5,	NULL,	NULL,	'2015-03-30 11:41:49'),
            (154,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-30 14:10:27'),
            (155,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-31 00:04:47'),
            (156,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-31 02:29:18'),
            (157,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-31 07:11:06'),
            (158,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-03-31 09:32:55'),
            (159,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-31 10:20:39'),
            (160,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-31 11:56:42'),
            (161,	1,	1,	NULL,	NULL,	4,	NULL,	NULL,	'2015-03-31 12:53:01'),
            (162,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-03-31 14:39:54'),
            (163,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-01 01:18:37'),
            (164,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-01 03:27:25'),
            (165,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-01 05:55:08'),
            (166,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-01 10:46:16'),
            (167,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-01 14:21:50'),
            (168,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-01 22:37:12'),
            (169,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-01 23:52:14'),
            (170,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-02 00:26:52'),
            (171,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-02 04:47:01'),
            (172,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-02 06:35:50'),
            (173,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-02 08:42:17'),
            (174,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-02 10:47:47'),
            (175,	3,	1,	NULL,	NULL,	4,	NULL,	NULL,	'2015-04-02 10:51:47'),
            (176,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-02 12:30:18'),
            (177,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-03 00:14:57'),
            (178,	1,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-03 04:39:27'),
            (179,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-03 05:12:41'),
            (180,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-03 08:27:38'),
            (181,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-03 09:47:30'),
            (182,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-03 14:34:12'),
            (183,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-03 16:39:55'),
            (184,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-04 04:23:37'),
            (185,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-04 05:43:13'),
            (186,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-04 14:15:13'),
            (187,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-05 04:01:57'),
            (188,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-05 05:46:55'),
            (189,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-05 09:47:48'),
            (190,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-05 13:41:00'),
            (191,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-05 19:52:09'),
            (192,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-06 00:03:13'),
            (193,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-06 02:33:09'),
            (194,	1,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-06 03:58:31'),
            (195,	3,	1,	NULL,	NULL,	4,	NULL,	NULL,	'2015-04-06 07:33:08'),
            (196,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-06 08:38:28'),
            (197,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-06 10:40:24'),
            (198,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-06 11:59:40'),
            (199,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-06 13:07:07'),
            (200,	1,	1,	NULL,	NULL,	3,	NULL,	NULL,	'2015-04-06 14:05:23'),
            (201,	1,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-06 17:39:28'),
            (202,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-06 21:25:02'),
            (203,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-06 22:50:16'),
            (204,	3,	1,	NULL,	NULL,	4,	NULL,	NULL,	'2015-04-07 01:57:15'),
            (205,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-07 03:11:50'),
            (206,	1,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-07 04:12:37'),
            (207,	1,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-07 06:50:45'),
            (209,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-07 07:01:12'),
            (210,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-07 09:02:35'),
            (211,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-07 11:19:21'),
            (212,	1,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-07 15:51:59'),
            (213,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-08 00:34:16'),
            (214,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-08 01:09:09'),
            (216,	3,	1,	NULL,	NULL,	3,	NULL,	NULL,	'2015-04-08 02:28:10'),
            (217,	1,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-08 03:15:49'),
            (218,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-08 04:30:57'),
            (219,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-08 05:19:50'),
            (220,	3,	1,	NULL,	NULL,	11,	NULL,	NULL,	'2015-04-08 07:09:46'),
            (221,	3,	1,	NULL,	NULL,	3,	NULL,	NULL,	'2015-04-08 09:22:09'),
            (222,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-08 10:50:34'),
            (223,	1,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-09 01:07:56'),
            (224,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-09 02:23:43'),
            (225,	3,	1,	NULL,	NULL,	4,	NULL,	NULL,	'2015-04-09 03:33:06'),
            (226,	3,	1,	NULL,	NULL,	4,	NULL,	NULL,	'2015-04-09 04:45:42'),
            (229,	3,	1,	NULL,	NULL,	3,	NULL,	NULL,	'2015-04-09 06:03:18'),
            (231,	1,	1,	NULL,	NULL,	11,	NULL,	NULL,	'2015-04-09 07:56:28'),
            (232,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-09 07:57:39'),
            (240,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-09 16:02:04'),
            (242,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-09 18:04:57'),
            (247,	3,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-09 22:42:07'),
            (248,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-09 22:43:54'),
            (251,	3,	1,	NULL,	NULL,	2,	NULL,	NULL,	'2015-04-10 00:32:25'),
            (252,	1,	1,	NULL,	NULL,	1,	NULL,	NULL,	'2015-04-10 00:59:27');

            DROP TABLE IF EXISTS `user_instruments_users`;
            CREATE TABLE `user_instruments_users` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `instrument_id` int(11) NOT NULL,
              `user_id` varchar(45) DEFAULT NULL,
              `role` varchar(150) NOT NULL,
              `login` varchar(250) NOT NULL,
              `password` varchar(32) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `instrument_id` (`instrument_id`),
              KEY `user_id` (`user_id`),
              CONSTRAINT `user_instruments_users_instrument_id` FOREIGN KEY (`instrument_id`) REFERENCES `user_instruments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            INSERT INTO `user_instruments_users` (`id`, `instrument_id`, `user_id`, `role`, `login`, `password`) VALUES
            (1,	1,	'36ac7a30-bd90-47d0-82d6-06ffa9685a3c',	'ovner',	'tracerrecart@gmail.com',	'2128506A'),
            (2,	4,	'36ac7a30-bd90-47d0-82d6-06ffa9685a3c',	'ovner',	'tracerrecart@gmail.com',	'1234567890'),
            (3,	6,	'36ac7a30-bd90-47d0-82d6-06ffa9685a3c',	'ovner',	'tracerrecart@gmail.com',	'1234567890');

            DROP TABLE IF EXISTS `user_site`;
            CREATE TABLE `user_site` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` varchar(45) DEFAULT NULL,
              `title` varchar(100) NOT NULL,
              `url` varchar(250) NOT NULL,
              `description` varchar(250) DEFAULT NULL,
              `code` varchar(36) DEFAULT NULL,
              `recdate` date NOT NULL,
              `active` enum('y','n') NOT NULL DEFAULT 'n',
              PRIMARY KEY (`id`),
              KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            INSERT INTO `user_site` (`id`, `user_id`, `title`, `url`, `description`, `code`, `recdate`, `active`) VALUES
            (1,	'36ac7a30-bd90-47d0-82d6-06ffa9685a3c',	'ShermanCMD',	'shermancmd.com',	'Тестовая площадка',	'ANB_628ab0574dac629712bbfda5885226c5',	'2015-02-18',	'y'),
            (2,	'36ac7a30-bd90-47d0-82d6-06ffa9685a3c',	'IN3',	'in3.shermancmd.com',	'Рынок коммерческой недвижимости России',	'ANB_0d81224f2095e2288c0df6528dca8015',	'2015-02-19',	'y'),
            (3,	'36ac7a30-bd90-47d0-82d6-06ffa9685a3c',	'Adbase',	'adbase.ru',	'Adbase',	'ANB_c12f3160cfcd62834b35bfe01884e9ab',	'2015-03-12',	'y'),
            (4,	'36ac7a30-bd90-47d0-82d6-06ffa9685a3c',	'Fincake',	'fincake.ru',	'Fincake',	'ANB_6ea870186cbfe07cdd03c98caa837615',	'2015-04-07',	'y'),
            (5,	'36ac7a30-bd90-47d0-82d6-06ffa9685a3c',	'Reclamonetizator',	'reclamonetizator.ru',	'Reclamonetizator',	'ANB_72f42ee2f5bdfc3c9b05554f5bbc6dbf',	'2015-04-06',	'y');

            DROP TABLE IF EXISTS `user_site_instrument`;
            CREATE TABLE `user_site_instrument` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `site_id` int(11) NOT NULL,
              `instrument_id` int(11) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `site_id` (`site_id`),
              KEY `instrument_id` (`instrument_id`),
              CONSTRAINT `user_site_instrument_instrument_id` FOREIGN KEY (`instrument_id`) REFERENCES `user_instruments` (`id`) ON DELETE CASCADE,
              CONSTRAINT `user_site_instrument_site_id` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            INSERT INTO `user_site_instrument` (`id`, `site_id`, `instrument_id`) VALUES
            (1,	1,	1),
            (3,	1,	1),
            (4,	3,	1),
            (5,	4,	1),
            (6,	5,	1);
        ");
	}

	public function down()
	{
		echo "m150410_093758_site_dump does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}