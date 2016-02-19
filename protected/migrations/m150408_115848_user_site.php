<?php

class m150408_115848_user_site extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_site`
            DROP FOREIGN KEY `user_site_user_id`;
            
            ALTER TABLE `user_instruments_users`
            DROP FOREIGN KEY `user_instruments_users_user_id`;
            
            ALTER TABLE `user_instruments_users`
            CHANGE `user_id` `user_id` varchar(45) NULL AFTER `instrument_id`;

            ALTER TABLE `user_site`
            CHANGE `user_id` `user_id` varchar(45) NULL AFTER `id`;
        ");
	}

	public function down()
	{
		echo "m150408_115848_user_site does not support migration down.\n";
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