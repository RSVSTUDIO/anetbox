<?php

class m150526_135148_instruments_users extends EDbMigration
{
	public function up()
	{
        $this->execute("DELETE FROM `user_instruments_users`;");
	}

	public function down()
	{
		echo "m150526_135148_instruments_users does not support migration down.\n";
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