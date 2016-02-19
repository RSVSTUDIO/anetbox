<?php

class m150418_122014_user_site_index extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_instruments_users`
            CHANGE `user_id` `user_id` char(45) COLLATE 'utf8_general_ci' NULL AFTER `instrument_id`;
        ");
        
        $this->execute("
            ALTER TABLE `user_site`
            CHANGE `user_id` `user_id` char(45) COLLATE 'utf8_general_ci' NULL AFTER `id`;
        ");
	}

	public function down()
	{
		echo "m150418_122014_user_site_index does not support migration down.\n";
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