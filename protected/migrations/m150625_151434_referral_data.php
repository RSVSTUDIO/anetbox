<?php

class m150625_151434_referral_data extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_referral_data`
            DROP FOREIGN KEY `user_referral_data_site_id`;
            
            ALTER TABLE `user_referral_data`
            DROP `site_id`;
        ");
	}

	public function down()
	{
		echo "m150625_151434_referral_data does not support migration down.\n";
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