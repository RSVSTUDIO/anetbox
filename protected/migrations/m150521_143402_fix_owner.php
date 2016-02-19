<?php

class m150521_143402_fix_owner extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_instruments_users` SET `role` = 'owner';
        ");
	}

	public function down()
	{
		echo "m150521_143402_fix_owner does not support migration down.\n";
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