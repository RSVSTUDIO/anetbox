<?php

class m150513_111718_yandex_token extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_instruments_users`
            CHANGE `password` `password` varchar(250) COLLATE 'utf8_general_ci' NOT NULL AFTER `login`;
        ");
	}

	public function down()
	{
        $this->execute("
            ALTER TABLE `user_instruments_users`
            CHANGE `password` `password` varchar(32) COLLATE 'utf8_general_ci' NOT NULL AFTER `login`;
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