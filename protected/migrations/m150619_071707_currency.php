<?php

class m150619_071707_currency extends EDbMigration
{
	public function up()
	{
        $this->execute("
            DROP TABLE IF EXISTS `currency`;
            CREATE TABLE `currency` (
              `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
              `code` enum('usd','eur','rub') NOT NULL DEFAULT 'usd',
              `value` decimal(10,4) NOT NULL DEFAULT '0.0000',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            INSERT INTO `currency` (`id`, `code`, `value`) VALUES
            (1,	'usd',	1.0000),
            (2,	'eur',	1.1371),
            (3,	'rub',	53.3301);
        ");
	}

	public function down()
	{
		echo "m150619_071707_currency does not support migration down.\n";
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