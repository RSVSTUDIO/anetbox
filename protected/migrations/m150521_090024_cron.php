<?php

class m150521_090024_cron extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_instruments_cron_log`
            CHANGE `comment` `comment` text COLLATE 'utf8_general_ci' NOT NULL AFTER `usi_id`;
        ");
	}

	public function down()
	{
        $this->execute("
            ALTER TABLE `user_instruments_cron_log`
            CHANGE `comment` `comment` tinytext COLLATE 'utf8_general_ci' NOT NULL AFTER `usi_id`;
        ");
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