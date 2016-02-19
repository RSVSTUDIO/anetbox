<?php

class m150806_083404_anetbox extends EDbMigration
{
	public function up()
	{
        $this->execute("UPDATE `user_instruments` SET `url` = 'anetbox.com' WHERE `id` = '1';");
	}

	public function down()
	{
		echo "m150806_083404_anetbox does not support migration down.\n";
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