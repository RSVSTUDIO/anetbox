<?php

class m150504_083953_reset_code extends EDbMigration
{
	public function up()
	{
        $this->execute("
            UPDATE `user_site` SET `code` = NULL;
        ");
	}

	public function down()
	{
		echo "m150504_083953_reset_code does not support migration down.\n";
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