<?php

class m150708_115224_news extends EDbMigration
{
	public function up()
	{
        $this->execute("
            DROP TABLE IF EXISTS `news`;
            CREATE TABLE `news` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `instrument_id` bigint(20) unsigned NOT NULL,
              `title` varchar(200) DEFAULT NULL,
              `short_text` text,
              `full_text` mediumtext,
              `created_at` datetime DEFAULT NULL,
              `created_by` int(10) unsigned DEFAULT NULL,
              `updated_at` datetime DEFAULT NULL,
              `updated_by` int(10) unsigned DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `instrument_id` (`instrument_id`),
              CONSTRAINT `news_instrument_id` FOREIGN KEY (`instrument_id`) REFERENCES `user_instruments` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
	}

	public function down()
	{
		echo "m150708_115224_news does not support migration down.\n";
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