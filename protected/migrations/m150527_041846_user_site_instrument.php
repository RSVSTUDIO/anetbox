<?php

class m150527_041846_user_site_instrument extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_site_instrument`
            CHANGE `login` `login` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `cron`,
            CHANGE `password` `password` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `login`;
        ");
	}

	public function down()
	{
		echo "m150527_041846_user_site_instrument does not support migration down.\n";
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