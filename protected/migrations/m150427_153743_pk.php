<?php

class m150427_153743_pk extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_friend`
            ADD `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
            
            ALTER TABLE `user_ban`
            ADD `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
        ");
	}

	public function down()
	{
		echo "m150427_153743_pk does not support migration down.\n";
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