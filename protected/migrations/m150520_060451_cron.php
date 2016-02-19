<?php

class m150520_060451_cron extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_site_instrument`
            ADD `cron` enum('y','n') NOT NULL DEFAULT 'y' COMMENT 'обрабатывать данный сайт в кроне или нет';
            
            DROP TABLE IF EXISTS `user_instruments_cron_log`;
            CREATE TABLE `user_instruments_cron_log` (
              `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
              `usi_id` int(11) NOT NULL DEFAULT '0' COMMENT 'user_site_instrument primary key',
              `comment` tinytext NOT NULL,
              `created_at` datetime NOT NULL,
              PRIMARY KEY (`id`),
              KEY `usi_id` (`usi_id`),
              CONSTRAINT `user_instruments_cron_log_usi_id` FOREIGN KEY (`usi_id`) REFERENCES `user_site_instrument` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Лог крона для инструментов';
        ");
	}

	public function down()
	{
		echo "m150520_060451_cron does not support migration down.\n";
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