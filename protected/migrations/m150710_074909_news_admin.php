<?php

class m150710_074909_news_admin extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user` ADD `news_admin` tinyint(4) NOT NULL DEFAULT '0' AFTER `super_admin`;
        ");
	}

	public function down()
	{
		echo "m150710_074909_news_admin does not support migration down.\n";
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