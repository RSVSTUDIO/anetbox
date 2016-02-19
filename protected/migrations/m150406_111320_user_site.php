<?php

class m150406_111320_user_site extends EDbMigration
{
	public function up()
	{
        $this->execute("
            DROP TABLE IF EXISTS `user_site`;
            CREATE TABLE `user_site` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `title` varchar(100) NOT NULL,
              `url` varchar(250) NOT NULL,
              `description` varchar(250) DEFAULT NULL,
              `code` varchar(36) NOT NULL,
              `recdate` date NOT NULL,
              PRIMARY KEY (`id`),
              KEY `user_id` (`user_id`),
              CONSTRAINT `user_site_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
              CONSTRAINT `user_instruments_data_site_id` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`) ON DELETE CASCADE,
              CONSTRAINT `user_instruments_data_instrument_id` FOREIGN KEY (`instrument_id`) REFERENCES `user_instruments` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            DROP TABLE IF EXISTS `user_instruments_users`;
            CREATE TABLE `user_instruments_users` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `instrument_id` int(11) NOT NULL,
              `user_id` int(11) NOT NULL,
              `role` varchar(150) NOT NULL,
              `login` varchar(250) NOT NULL,
              `password` varchar(32) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `instrument_id` (`instrument_id`),
              KEY `user_id` (`user_id`),
              CONSTRAINT `user_instruments_users_instrument_id` FOREIGN KEY (`instrument_id`) REFERENCES `user_instruments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `user_instruments_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            DROP TABLE IF EXISTS `user_site_instrument`;
            CREATE TABLE `user_site_instrument` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `site_id` int(11) NOT NULL,
              `instrument_id` int(11) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `site_id` (`site_id`),
              KEY `instrument_id` (`instrument_id`),
              CONSTRAINT `user_site_instrument_site_id` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`) ON DELETE CASCADE,
              CONSTRAINT `user_site_instrument_instrument_id` FOREIGN KEY (`instrument_id`) REFERENCES `user_instruments` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
	}

	public function down()
	{
		echo "m150406_111320_user_site does not support migration down.\n";
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