<?php

class m150409_182045_site_code_default extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_site`
            CHANGE `code` `code` varchar(36) COLLATE 'utf8_general_ci' NULL AFTER `description`;
        ");
	}

	public function down()
	{
		echo "m150409_182045_site_code_default does not support migration down.\n";
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