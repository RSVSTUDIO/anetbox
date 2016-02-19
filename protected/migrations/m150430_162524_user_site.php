<?php

class m150430_162524_user_site extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_site`
            CHANGE `code` `code` char(36) COLLATE 'utf8_general_ci' NULL AFTER `description`;
            
            ALTER TABLE `user_site`
            ADD UNIQUE `code` (`code`);
            
            ALTER TABLE `user_site`
            CHANGE `url` `url` char(250) COLLATE 'utf8_general_ci' NOT NULL AFTER `title`;
            
            ALTER TABLE `user_site`
            ADD UNIQUE `user_id_url` (`user_id`, `url`);
        ");
	}

	public function down()
	{
		echo "m150430_162524_user_site does not support migration down.\n";
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