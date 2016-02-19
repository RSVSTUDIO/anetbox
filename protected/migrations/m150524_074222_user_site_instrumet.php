<?php

class m150524_074222_user_site_instrumet extends EDbMigration
{
	public function up()
	{

        $this->execute("
            ALTER TABLE `user_site_instrument` ADD `login` VARCHAR(255) , ADD `password` VARCHAR(255)  AFTER `cron`;
        ");
	}

	public function down()
	{
		echo "m150524_074222_user_site_instrumet does not support migration down.\n";
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