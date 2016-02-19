<?php

class m150623_061753_referral_data extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user_site_instrument`
            DROP FOREIGN KEY `user_site_instrument_instrument_id`;

            ALTER TABLE `user_site_instrument`
            DROP FOREIGN KEY `user_site_instrument_site_id`;

            ALTER TABLE `user_instruments_users`
            DROP FOREIGN KEY `user_instruments_users_instrument_id`;

            ALTER TABLE `user_instruments_log`
            DROP FOREIGN KEY `user_instruments_cron_log_usi_id`;

            ALTER TABLE `user_instruments_data`
            DROP FOREIGN KEY `user_instruments_data_site_id`;

            ALTER TABLE `user_instruments_data`
            DROP FOREIGN KEY `user_instruments_data_instrument_id`;
        ");
        
        $this->execute("
            ALTER TABLE `user_instruments_data`
            CHANGE `id` `id` bigint unsigned NOT NULL AUTO_INCREMENT FIRST;

            ALTER TABLE `user_instruments_data`
            ADD INDEX `earnings` (`earnings`);
            
            ALTER TABLE `user_instruments`
            CHANGE `id` `id` bigint unsigned NOT NULL AUTO_INCREMENT FIRST;

            ALTER TABLE `user_instruments_data`
            CHANGE `site_id` `site_id` bigint unsigned NOT NULL AFTER `id`,
            CHANGE `instrument_id` `instrument_id` bigint unsigned NOT NULL AFTER `site_id`;

            ALTER TABLE `user_instruments_log`
            CHANGE `usi_id` `usi_id` bigint unsigned NOT NULL DEFAULT '0' COMMENT 'user_site_instrument primary key' AFTER `id`;

            ALTER TABLE `user_instruments_users`
            CHANGE `id` `id` bigint unsigned NOT NULL AUTO_INCREMENT FIRST,
            CHANGE `instrument_id` `instrument_id` bigint unsigned NOT NULL AFTER `id`;

            ALTER TABLE `user_site`
            CHANGE `id` `id` bigint unsigned NOT NULL AUTO_INCREMENT FIRST;

            ALTER TABLE `user_site_instrument`
            CHANGE `id` `id` bigint unsigned NOT NULL AUTO_INCREMENT FIRST,
            CHANGE `site_id` `site_id` bigint unsigned NOT NULL AFTER `id`,
            CHANGE `instrument_id` `instrument_id` bigint unsigned NOT NULL AFTER `site_id`;
        ");
        
        $this->execute("
            ALTER TABLE `user_site_instrument`
            ADD CONSTRAINT `user_site_instrument_site_id` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
            ADD CONSTRAINT `user_site_instrument_instrument_id` FOREIGN KEY (`instrument_id`) REFERENCES `user_instruments` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

            ALTER TABLE `user_instruments_data`
            ADD CONSTRAINT `user_instruments_data_site_id` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
            ADD CONSTRAINT `user_instruments_data_instrument_id` FOREIGN KEY (`instrument_id`) REFERENCES `user_instruments` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

            ALTER TABLE `user_instruments_users`
            ADD CONSTRAINT `user_instruments_users_instrument_id` FOREIGN KEY (`instrument_id`) REFERENCES `user_instruments` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

            ALTER TABLE `user_instruments_log`
            ADD CONSTRAINT `user_instruments_log_usi_id` FOREIGN KEY (`usi_id`) REFERENCES `user_site_instrument` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
        ");
        
        $this->execute("
            DROP TABLE IF EXISTS `user_referral_data`;
            CREATE TABLE `user_referral_data` (
              `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
              `site_id` bigint(20) unsigned NOT NULL,
              `instrument_id` bigint(20) unsigned NOT NULL,
              `referrals` bigint(20) unsigned DEFAULT NULL,
              `earnings` decimal(10,2) unsigned DEFAULT NULL,
              `recdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `referrals` (`referrals`),
              KEY `earnings` (`earnings`),
              KEY `site_id` (`site_id`),
              KEY `instrument_id` (`instrument_id`),
              CONSTRAINT `user_referral_data_site_id` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`) ON DELETE CASCADE,
              CONSTRAINT `user_referral_data_instrument_id` FOREIGN KEY (`instrument_id`) REFERENCES `user_instruments` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        
	}

	public function down()
	{
		echo "m150623_061753_referral_data does not support migration down.\n";
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