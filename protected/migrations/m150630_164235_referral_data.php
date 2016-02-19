<?php

class m150630_164235_referral_data extends EDbMigration
{
	public function up()
	{
        $this->execute("
            TRUNCATE `user_referral_data`;

            ALTER TABLE `user_referral_data`
            ADD `site_id` bigint(20) unsigned NOT NULL AFTER `id`;
            
            ALTER TABLE `user_referral_data`
            ADD CONSTRAINT `user_referral_data_site_id` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
        ");
	}

	public function down()
	{
		echo "m150630_164235_referral_data does not support migration down.\n";
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