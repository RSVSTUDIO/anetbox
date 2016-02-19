<?php

class m150529_150447_api_data extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_site_instrument`
            ADD `api_data` text COLLATE 'utf8_general_ci' NULL;
        ");
	}

	public function down()
	{
		echo "m150529_150447_api_data does not support migration down.\n";
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