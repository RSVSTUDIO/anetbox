<?php

class m150619_110759_user_currency extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user` ADD `currency` char(3) COLLATE 'utf8_general_ci' NULL;
        ");
	}

	public function down()
	{
        $this->execute("
            ALTER TABLE `user` DROP `currency`;
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