<?php

class m150409_152200_site_active extends EDbMigration
{
	public function up()
	{
        $this->execute("
                ALTER TABLE `user_site`
                ADD `active` enum('active','no_active') NOT NULL DEFAULT 'no_active',
                COMMENT='';
        ");
	}

	public function down()
	{
		echo "m150409_152200_site_active does not support migration down.\n";
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