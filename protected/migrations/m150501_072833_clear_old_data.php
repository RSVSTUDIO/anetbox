<?php

class m150501_072833_clear_old_data extends EDbMigration
{
	public function up()
	{
        $this->execute("
            DELETE FROM `user_instruments_data` WHERE `pages` IS NULL;
        ");
	}

	public function down()
	{
		echo "m150501_072833_clear_old_data does not support migration down.\n";
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